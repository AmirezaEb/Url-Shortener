<?php

namespace App\Utilities;

class Auth
{
    public static function chackLogin() :bool|string
    {
        $getCookie = Cookie::getDecryptedCookie('Auth');
        if (!is_null(Cookie::getCookie('Auth')) && $getCookie !== false) {
            return $getCookie;
        } else {
            return false;
        }
    }

    public static function generateOtp(): object
    {
        $otpCode = random_int(100030, 999999);
        $otpExpired = time() + 400;
        return (object)[
            'code' => $otpCode,
            'expired' => $otpExpired
        ];
    }
}
