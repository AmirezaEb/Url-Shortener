<?php

namespace App\Controllers;

use App\Core\Request;
use App\Models\User;

class AuthController
{
    public function index()
    {
        return view('home.login');
    }

    public function Login(Request $request)
    {
        if ($request->method() === 'post' && isset($request->params()['sub-email']) && !empty($request->params()['email'])) {
            $email = $request->params()['email'];
            $user = User::where('email',$email)->first();
            if($user){
                # send otp code to email
            }else{
                # create usea and send code to email
            }
        }
    }
}
