<?php

namespace App\Controllers;

use App\{Core\Request, Models\User, Services\Email};
use App\Utilities\{Auth, Cookie, ExceptionHandler, Lang, Session};
use Illuminate\Support\Facades\DB;

/* Developed by Hero Expert
- Telegram channel: @HeroExpert_ir
- Author: Amirreza Ebrahimi
- Telegram Author: @a_m_b_r
*/

class AuthController
{
    private Email $emailService;

    /**
     * Constructor for initializing the email service
     */
    public function __construct()
    {
        $this->emailService = new Email();
    }

    /**
     * Display the login page or redirect to user panel if already logged in
     * @throws \Exception
     */
    public function index()
    {
        # Check if user is logged in
        if (Auth::checkLogin()) {
            # Redirect to user panel
            return redirect('./panel');
        } else {
            # Show login view
            return view('home.login');
        }
    }

    /**
     * Handle authentication requests (registration/login)
     *
     * @param Request $request
     */
    public function handleAuth(Request $request): void
    {
        # Get the action type (register or login)
        $action = $request->param('action') ?? null;

        # If action is 'register' and user data exists in session, process registration
        if ($action === 'register' && Session::has('UserData') && !empty($request->param('verifyCode'))) {
            $this->register($request); # Otherwise, process register
        } else {
            $this->login($request); # Otherwise, process login
        }
    }

    /**
     * Handle user login
     *
     * @param Request $request
     */
    public function login(Request $request): void
    {
        try {
            # Check if request method is POST and email is provided
            if ($request->method() !== 'post' && empty($request->param('email') && !$request->has('email'))) {
                # Delete session And Throw Error if email is invalid
                $this->throwExceptionAndDeleteSession('UserData', 'InvalidEmail');
            }

            # Sanitize email input
            $email = filter_var($request->param('email'), FILTER_SANITIZE_EMAIL);

            # Validate email format
            if (!validateEmail($email)) {
                # Delete session And Throw Error if email is invalid
                $this->throwExceptionAndDeleteSession('UserData', 'InvalidEmail');
            }

            $user = User::where('email', $email)->first(); # Attempt to find user by email
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
        } catch (\Exception $e) {
            # Handle any exceptions and redirect to authentication page with error
            ExceptionHandler::setErrorAndRedirect($e->getMessage(), './auth');
        }
    }

    /**
     * Handle user registration
     *
     * @param Request $request
     */
    public function register(Request $request): void
    {
        try {
            # Validate OTP code received from user
            if (!filter_var($request->param('verifyCode'), FILTER_VALIDATE_INT)) {
                # Delete session And Throw Error if VerifyCode invalid
                $this->throwExceptionAndDeleteSession('UserData');
            }

            $email = Session::get('UserData')['email']; # Get email from session
            $user = User::where('email', $email)->first(); # Find user by email
            $otpCode = $user->otpCode ?? null; # Get OTP code from user
            $verifyCode = $request->param('verifyCode'); # Get verification code from request

            # Check if user exists and has valid OTP
            if (!$user) {
                # Delete session And Throw Error if user don't exist
                $this->throwExceptionAndDeleteSession('UserData');
            }

            # If OTP has expired, clear session and throw error
            if ($user->otpExpired <= time()) {
                # Delete session And Throw Error if OTP has expired
                $this->throwExceptionAndDeleteSession('UserData', 'Expired');
            }

            # If OTP matches, complete registration
            if ($verifyCode === $otpCode) {
                $this->completeRegistration($user);
            } else {
                # Handle invalid OTP attempts
                $this->handleInvalidOtpAttempt();
            }
        } catch (\Exception $e) {
            # Handle any exceptions and redirect to authentication page with error
            ExceptionHandler::setErrorAndRedirect($e->getMessage(), './auth');
        }
    }

    /**
     * Update user OTP in the database and send it via email
     *
     * @param User $user
     * @param object $otp
     * @throws \Exception
     */
    private function updateUserOtp(User $user, object $otp): void
    {
        try {
            # Start Transaction
            DB::beginTransaction();

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
            if (!$updateSuccess || !Session::has('UserData') || !$emailSent) {
                # Delete session And Throw Error if failures process Update User And Send Email
                throw new \Exception();
            }

            DB::commit();
        } catch (\Exception) {
            DB::rollBack();
            Session::delete('UserData');
            $this->throwExceptionAndDeleteSession('UserData');
        }
    }

    /**
     * Create a new user with OTP and send it via email
     *
     * @param string $email
     * @param object $otp
     * @throws \Exception
     */
    private function createUserWithOtp(string $email, object $otp): void
    {
        try {
            # Start Transaction
            DB::beginTransaction();

            # Create User
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
                throw new \Exception();
            }

            DB::commit();
        } catch (\Exception) {
            DB::rollBack();
            Session::delete('UserData');
            $this->throwExceptionAndDeleteSession('UserData');
        }
    }

    /**
     * Complete the user registration process
     *
     * @param User $user
     * @throws \Exception
     */
    private function completeRegistration(User $user): void
    {
        Session::delete('UserData'); # Clear session user data
        $setCookie = Cookie::setEncryptedCookie('Auth', $user->email); # Set authentication cookie

        # If setting cookie fails
        if (!$setCookie) {
            # Delete session And Throw Error if failures process Set Cookies
            $this->throwExceptionAndDeleteSession('UserData');
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
     * @throws \Exception
     */
    private function handleInvalidOtpAttempt(): void
    {
        $countInvalidLogin = Session::get('invalidLogin') ?? 0;
        Session::set('invalidLogin', $countInvalidLogin + 1); # Increment invalid attempts

        ExceptionHandler::setError(Lang::get('Er-InvalidCode')); # Show error for invalid OTP

        # If user exceeds 3 invalid attempts, throw error
        if ($countInvalidLogin >= 3) {
            # Delete session And Throw Error if attempts after 3 failures
            $this->throwExceptionAndDeleteSession('invalidLogin');
        }

        view('home.verify'); # Show OTP verification page again
    }

    /**
     * @throws \Exception
     */
    private function throwExceptionAndDeleteSession(string $sessionName, string $exceptionMessage = 'TryAgain')
    {
        Session::delete($sessionName); # Delete session
        throw new \Exception(Lang::get("Er-{$exceptionMessage}")); # Throw Error
    }
}
