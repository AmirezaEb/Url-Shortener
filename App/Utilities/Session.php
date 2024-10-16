<?php

namespace App\Utilities;

class Session
{

    public static function run(): void
    {
        session_start();
        ini_set('sesson.cookie_httponly',1);
        ini_set('sesion.gc_maxlifetime',300);
    }

    public static function set(string $key, string|array $value): void
    {
        $_SESSION[$key] = $value;
    }

    public static function get(string $key): mixed
    {
        return self::has($key) ? $_SESSION[$key] : null;
    }

    public static function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    public static function empty(string $key): bool
    {
        return empty($_SESSION[$key]);
    }

    public static function delete(string $key): void
    {
        if (self::has($key)) {
            unset($_SESSION[$key]);
        }
    }
    public static function clear(): void
    {
        session_unset();
        session_destroy();
    }
}
