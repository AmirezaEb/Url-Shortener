<?php

namespace App\Utilities;

/* Developed by Hero Expert
- Telegram channel: @HeroExpert_ir
- Author: Amirreza Ebrahimi
- Telegram Author: @a_m_b_r
*/
class Cookie
{
    # Secret key used for encrypting cookies
    private static string $key = '!@-HeroExpert-@!';

    /**
     * Sets a secure cookie with optional parameters.
     *
     * @param string $name The name of the cookie.
     * @param string $value The value of the cookie.
     * @param int $expire The expiration time of the cookie in seconds (default is 6 hours).
     * @param string $path The path on the server in which the cookie will be available (default is '/').
     * @param string $domain The domain that the cookie is available to (default is empty).
     * @param bool $secure Indicates if the cookie should only be transmitted over a secure HTTPS connection (default is false).
     * @param bool $httponly When true, the cookie will be made accessible only through the HTTP protocol (default is true).
     * @return bool Returns true if the cookie was set successfully, otherwise false.
     */
    public static function setSecureCookie(string $name, string $value, int $expire = (3600 * 6), string $path = '/', string $domain = '', bool $secure = false, bool $httponly = true): bool
    {
        # Set secure and httponly flags based on the environment
        if (!self::isLocalhost()) {
            $secure = true; # Enforce secure cookies on production
            $httponly = false; # Allow JavaScript access to cookies on production (adjust as needed)
        }

        # Set the cookie using the PHP set-cookie function
        return setcookie($name, $value, time() + $expire, $path, $domain, $secure, $httponly);
    }

    /**
     * Retrieves the value of a cookie by its name.
     *
     * @param string $name The name of the cookie.
     * @return string|null Returns the cookie value or null if it doesn't exist.
     */
    public static function getCookie(string $name): string|null
    {
        return $_COOKIE[$name] ?? null; # Return the cookie value or null
    }

    /**
     * Deletes a cookie by its name.
     *
     * @param string $name The name of the cookie to delete.
     * @param string $path The path on the server in which the cookie is available (default is '/').
     * @param string $domain The domain that the cookie is available to (default is empty).
     */
    public static function deleteCookie(string $name, string $path = '/', string $domain = ''): void
    {
        setcookie($name, '', time() - 3600, $path, $domain); # Set the cookie expiration time to the past
        unset($_COOKIE[$name]); # Remove the cookie from the super global array
    }

    /**
     * Sets an encrypted cookie.
     *
     * @param string $name The name of the cookie.
     * @param string $value The value to encrypt and store in the cookie.
     * @return bool Returns true if the cookie was set successfully, otherwise false.
     */
    public static function setEncryptedCookie(string $name, string $value): bool
    {
        $encryptedValue = openssl_encrypt($value, 'aes-256-cbc', self::$key, 0, self::getIv());
        return self::setSecureCookie($name, $encryptedValue); # Set the encrypted cookie
    }

    /**
     * Retrieves and decrypts a cookie by its name.
     *
     * @param string $name The name of the cookie to decrypt.
     * @return string|null Returns the decrypted cookie value or null if it doesn't exist.
     */
    public static function getDecryptedCookie(string $name): string|null
    {
        $encryptedValue = self::getCookie($name);
        return $encryptedValue ? openssl_decrypt($encryptedValue, 'aes-256-cbc', self::$key, 0, self::getIv()) : null; # Decrypt and return the cookie value
    }

    /**
     * Retrieves the initialization vector for encryption.
     *
     * @return string Returns the initialization vector derived from the key.
     */
    private static function getIv(): string
    {
        return substr(hash('sha256', self::$key), 0, 16); # Generate a 16-byte IV from the key
    }

    /**
     * Checks if the current environment is localhost.
     *
     * @return bool Returns true if the request is from localhost, otherwise false.
     */
    private static function isLocalhost(): bool
    {
        return in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1']); # Check for localhost IP addresses
    }
}
