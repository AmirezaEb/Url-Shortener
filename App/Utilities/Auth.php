<?php

namespace App\Utilities;

class Auth
{
    /**
     * Checks if the user is logged in by verifying the authentication cookie.
     *
     * @return bool|string Returns the decrypted cookie value if the user is logged in; otherwise, returns false.
     */
    public static function checkLogin(): bool|string
    {
        # Retrieve and decrypt the authentication cookie
        $getCookie = Cookie::getDecryptedCookie('Auth');

        # Check if the cookie exists and is successfully decrypted
        if (!is_null(Cookie::getCookie('Auth')) && $getCookie !== false) {
            return $getCookie; # User is logged in, return the cookie value
        }

        return false; # User is not logged in
    }

    /**
     * Generates a One-Time Password (OTP) for authentication purposes.
     *
     * @return object An object containing the OTP code and its expiration time.
     */
    public static function generateOtp(): object
    {
        # Generate a random integer between 100030 and 999999 for the OTP code
        $otpCode = random_int(100030, 999999);

        # Set the OTP expiration time to 400 seconds (6 minutes) from the current time
        $otpExpired = time() + 400;

        # Return an object containing the OTP code and its expiration time
        return (object)[
            'code' => $otpCode,
            'expired' => $otpExpired
        ];
    }
}
?>