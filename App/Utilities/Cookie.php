<?php

namespace App\Utilities;

class Cookie
{
    private static $key = '!@-HeroExpert-@!';

    public static function setSecureCookie(string $name, string $value, int $expire = (3600 * 6), string $path = '/', string $domain = '', bool $secure = false, string $httponly = true,): void
    {
        if (!self::isLocalhost()) {
            $secure = true;
            $httponly = false;
        }
        setcookie($name, $value, time() + $expire, $path, $domain, $secure, $httponly);
    }

    public static function getCookie(string $name): bool|null
    {
        return isset($_COOKIE[$name]) ? $_COOKIE[$name] : null;
    }

    public static function deleteCookie(string $name, string $path = '/', string $domain = ''): void
    {
        setcookie($name, '', time() - 3600, $path, $domain);
        unset($_COOKIE[$name]);
    }

    public static function setEncryptedCookie(string $name, string $value): void
    {
        $encryptedValue = openssl_encrypt($value, 'aes-256-cbc', self::$key, 0, self::getIv());
        self::setSecureCookie($name, $encryptedValue);
    }

    public static function getDecryptedCookie(string $name): string|null
    {
        $encryptedValue = self::getCookie($name);
        return $encryptedValue ? openssl_decrypt($encryptedValue, 'aes-256-cbc', self::$key, 0, self::getIv()) : null;
    }

    private static function getIv(): string
    {
        return substr(hash('sha256', self::$key), 0, 16);
    }

    private static function isLocalhost(): bool
    {
        return in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1']);
    }

    public static function regenerateCsrfToken(string $tokenName = 'csrf_token'): string
    {
        $token = bin2hex(random_bytes(32));
        self::setSecureCookie($tokenName, $token);
        return $token;
    }

    public static function validateCsrfToken(string $tokenName = 'csrf_token', string $userToken): string
    {
        $storedToken = self::getCookie($tokenName);
        return hash_equals($storedToken, $userToken);
    }

    public static function getCookieExpiration(int $seconds = (3600 * 6)): int
    {
        return time() + $seconds;
    }
}
