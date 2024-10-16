<?php

namespace App\Controllers;

use App\Core\Request;
use App\Models\User;
use App\Services\Email;
use App\Utilities\Url;
use App\Utilities\Auth;
use App\Utilities\Cookie;
use App\Utilities\Lang;
use App\Utilities\Session;
use App\Utilities\ExceptionHandler;

class AuthController
{
    private $Email;

    public function __construct()
    {
        $this->Email = new Email();
    }

    public function index()
    {
        if (Auth::chackLogin()) {
            Url::redirect('./panel');
        } else {
            return view('home.login');
        }
    }

    public function handelrAuth(Request $request): void
    {
        $action = $_POST['action'];

        if ($action === 'register' && Session::has('UserData') === true && !empty($request->param('verifyCode'))) {
            $this->register($request);
        } else {
            $this->Login($request);
        }
    }

    public function Login(Request $request)
    {
        if ($request->method() === 'post' && isset($request->params()['email']) && !empty($request->param('email'))) {
            $email = filter_var($request->param('email'), FILTER_SANITIZE_EMAIL);
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

                $user = User::where('email', $email)->first();
                $otp = Auth::generateOtp();

                if ($user) {

                    $updateUser = User::where('id', $user->id)->update([
                        'otpCode' => $otp->code,
                        'otpExpired' => $otp->expired
                    ]);

                    $updateSession = Session::set('UserData', [
                        'email' => $user->email
                    ]);

                    $sendEmail = true;
                    // $sendEmail = $this->Email->send($user->email, $otp->code);

                    if (!$updateUser || Session::has('UserData') === false || !$sendEmail) {
                        Session::clear();
                        ExceptionHandler::setErrorAndRedirect(Lang::get('Er-TryAgain'), './auth');
                    }

                    view('home.verify');
                } else {
                    $createUser = User::create([
                        'email' => $email,
                        'otpCode' => $otp->code,
                        'otpExpired' => $otp->expired
                    ]);

                    $updateSession = Session::set('UserData', [
                        'email' => $email
                    ]);

                    $sendEmail = true;
                    // $sendEmail = $this->Email->send($email, $otp->code);

                    if (!$createUser || Session::has('UserData') === false || !$sendEmail) {
                        Session::clear();
                        ExceptionHandler::setErrorAndRedirect(Lang::get('Er-TryAgain'), './auth');
                    }

                    view('home.verify');
                }
            } else {
                Session::clear();
                ExceptionHandler::setErrorAndRedirect(Lang::get('Er-InvalidEmail'), './auth');
            }
        }
    }

    public function register(Request $request)
    {
        if (filter_var($request->param('verifyCode'), FILTER_VALIDATE_INT)) {
            $email = Session::get('UserData',)['email'];
            $user = User::where('email', $email)->first();
            $otpCode = $user->otpCode;
            $verifyCode = $request->param('verifyCode');

            if ($user->email) {
                if ($user->otpExpired <= time()) {
                    Session::clear();
                    ExceptionHandler::setErrorAndRedirect(Lang::get('Er-Expired'), './auth');
                }
                if ($verifyCode === $otpCode) {
                    Session::clear();
                    $setCookie = Cookie::setEncryptedCookie('Auth', $user->email);
                    if (!$setCookie) {
                        ExceptionHandler::setError(Lang::get('Er-TryAgain'));
                    }
                    Url::Redirect('./panel');
                } else {
                    $countInvalidLogin = Session::get('invalidLogin');
                    Session::set('invalidLogin', $countInvalidLogin + 1);
                    ExceptionHandler::setError(Lang::get('Er-InvalidCode'));
                    if ($countInvalidLogin >= 3) {
                        Session::clear();
                        ExceptionHandler::setErrorAndRedirect(Lang::get('Er-TryAgain'), './auth');
                    }
                    view('home.verify');
                }
            } else {
                Session::clear();
                ExceptionHandler::setErrorAndRedirect(Lang::get('Er-TryAgain'), './auth');
            }
        } else {
            Session::clear();
            ExceptionHandler::setErrorAndRedirect(Lang::get('Er-TryAgain'), './auth');
        }
    }
}
