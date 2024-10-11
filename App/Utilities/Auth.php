<?php

namespace App\Utilities;

class Auth
{
    public static function chackLogin()
    {
        if (isset($_COOKIE['auth'])) {
            #code
        } else {
            return Url::redirect('./auth');
        }
    }
}