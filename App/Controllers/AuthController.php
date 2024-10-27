<?php

namespace App\Controllers;

use App\Core\Request;
use App\Models\User;
use App\Services\Email;
use App\Utilities\Auth;
use App\Utilities\Cookie;
use App\Utilities\Lang;
use App\Utilities\Session;
use App\Utilities\ExceptionHandler;
use Exception;

class AuthController
{
    private $emailService;

    /**
     * Constructor for initializing the email service
     */
    public function __construct()
    {
        $this->emailService = new Email();
    }

    /**
     * Display the login page or redirect to user panel if already logged in
     */
    public function index()
    {
        if (Auth::checkLogin()) { # Check if user is logged in
            redirect('./panel'); # Redirect to user panel
        } else {
            return view('home.login'); # Show login view
        }
    }

    /**
     * Handle authentication requests (registration/login)
     *
     * @param Request $request
     */
    public function handleAuth(Request $request): void
    {
        $action = $_POST['action'] ?? null; # Get the action type (register or login)

        # If action is 'register' and user data exists in session, process registration
        if ($action === 'register' && Session::has('UserData') && !empty($request->param('verifyCode'))) {
            $this->register($request);
        } else {
            $this->login($request); # Otherwise, process login
        }
    }

    /**
     * Handle user login
     *
     * @param Request $request
     */
    public function login(Request $request)
    {
        try {
            # Check if request method is POST and email is provided
            if ($request->method() === 'post' && !empty($request->param('email'))) {
                $email = filter_var($request->param('email'), FILTER_SANITIZE_EMAIL); # Sanitize email input

                if (filter_var($email, FILTER_VALIDATE_EMAIL)) { // Validate email format
                    # Attempt to find user by email
                    $user = User::where('email', $email)->first();
                    $otp = Auth::generateOtp(); # Generate OTP for authentication

                    # If user exists, update OTP and send via email
                    if ($user) {
                        $this->updateUserOtp($user, $otp);
                    } else {
                        # If user does not exist, create a new user with OTP
                        $this->createUserWithOtp($email, $otp);
                    }
                    # Show OTP verification page
                    view('home.verify');
                } else {
                    # Clear session if email is invalid
                    Session::clear();
                    throw new Exception(Lang::get('Er-InvalidEmail')); // Throw invalid email error
                }
            }
        } catch (Exception $e) {
            # Handle any exceptions and redirect to authentication page with error
            ExceptionHandler::setErrorAndRedirect($e->getMessage(), './auth');
        }
    }

    /**
     * Handle user registration
     *
     * @param Request $request
     */
    public function register(Request $request)
    {
        try {
            # Validate OTP code received from user
            if (filter_var($request->param('verifyCode'), FILTER_VALIDATE_INT)) {
                $email = Session::get('UserData')['email']; # Get email from session
                $user = User::where('email', $email)->first(); # Find user by email
                $otpCode = $user->otpCode ?? null; # Get OTP code from user
                $verifyCode = $request->param('verifyCode'); # Get verification code from request

                # Check if user exists and has valid OTP
                if ($user) {
                    # If OTP has expired, clear session and throw error
                    if ($user->otpExpired <= time()) {
                        Session::delete('UserData');
                        throw new Exception(Lang::get('Er-Expired')); # OTP expired error
                    }

                    # If OTP matches, complete registration
                    if ($verifyCode === $otpCode) {
                        $this->completeRegistration($user);
                    } else {
                        # Handle invalid OTP attempts
                        $this->handleInvalidOtpAttempt();
                    }
                } else {
                    Session::clear(); # Clear session if user not found
                    throw new Exception(Lang::get('Er-TryAgain1')); // Retry error
                }
            } else {
                Session::clear(); # Clear session if OTP is invalid
                throw new Exception(Lang::get('Er-TryAgain2')); // Retry error
            }
        } catch (Exception $e) {
            # Handle any exceptions and redirect to authentication page with error
            ExceptionHandler::setErrorAndRedirect($e->getMessage(), './auth');
        }
    }

    /**
     * Update user OTP in the database and send it via email
     *
     * @param User $user
     * @param object $otp
     */
    private function updateUserOtp(User $user, object $otp)
    {
        # Update OTP and expiration time for existing user
        $updateSuccess = User::where('id', $user->id)->update([
            'otpCode' => $otp->code,
            'otpExpired' => $otp->expired
        ]);

        # Store user data in session
        Session::set('UserData', ['email' => $user->email]);

        # Send OTP via email
        $emailSent = $this->emailService->send($user->email, $otp->code);

        # Check for failures
        if (!$updateSuccess ||  !Session::has('UserData') || !$emailSent) {
            Session::clear(); # Clear session on failure
            throw new Exception(Lang::get('Er-TryAgain3')); # Throw retry error
        }
    }

    /**
     * Create a new user with OTP and send it via email
     *
     * @param string $email
     * @param object $otp
     */
    private function createUserWithOtp(string $email, object $otp)
    {
        $createSuccess = User::create([
            'email' => $email,
            'otpCode' => $otp->code,
            'otpExpired' => $otp->expired
        ]);

        # Store user data in session
        Session::set('UserData', ['email' => $email]);

        # Send OTP via email
        $emailSent = $this->emailService->send($email, $otp->code);

        # Check for failures
        if (!$createSuccess || !Session::has('UserData') || !$emailSent) {
            Session::clear(); # Clear session on failure
            throw new Exception(Lang::get('Er-TryAgain4')); # Throw retry error
        }
    }

    /**
     * Complete the user registration process
     *
     * @param User $user
     */
    private function completeRegistration(User $user)
    {
        Session::delete('UserData'); # Clear session user data
        $setCookie = Cookie::setEncryptedCookie('Auth', $user->email); # Set authentication cookie

        if (!$setCookie) { # If setting cookie fails, throw error
            throw new Exception(Lang::get('Er-TryAgain')); # Retry error
        }

        # Clear OTP from database
        User::where('id', $user->id)->update([
            'otpCode' => null,
            'otpExpired' => null
        ]);

        # Redirect user to panel after successful registration
        ExceptionHandler::setMessageAndRedirect(Lang::get('Ms-LoginSuccess'), './panel');
    }

    /**
     * Handle invalid OTP attempts
     */
    private function handleInvalidOtpAttempt()
    {
        $countInvalidLogin = Session::get('invalidLogin') ?? 0;
        Session::set('invalidLogin', $countInvalidLogin + 1); # Increment invalid attempts

        ExceptionHandler::setError(Lang::get('Er-InvalidCode')); # Show error for invalid OTP

        # If user exceeds 3 invalid attempts, throw error
        if ($countInvalidLogin >= 3) {
            Session::delete('invalidLogin'); # Reset attempts after 3 failures
            throw new Exception(Lang::get('Er-TryAgain')); # Retry error
        }

        view('home.verify'); # Show OTP verification page again
    }
}
