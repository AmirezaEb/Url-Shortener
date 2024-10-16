<?php

namespace App\Utilities;

class Lang
{
    private static $lang;
    private static $translation = [];

    public static function set(string $language): void
    {
        self::$lang = $language;
        self::loadTranslation();
    }

    protected static function loadTranslation(): void
    {
        $file = __DIR__ . '/../../lang/' . self::$lang . '.php';
        if (file_exists($file)) {
            self::$translation = include($file);
        }
    }

    public static function get(string $key): string
    {
        return self::$translation[$key] ?? $key;
    }
}
