<?php 
namespace App\Utilities;

class Lang{
    private static $lang;
    private static $translation = [];

    public static function set($language)
    {
        self::$lang = $language;
        self::loadTranslation();
    }

    protected static function loadTranslation()
    {
        $file = __DIR__ . '/../../lang/' . self::$lang . '.php';
        if(file_exists($file)){
            self::$translation = include($file);
        }
    }

    public static function get($key)
    {
        return self::$translation[$key] ?? $key;
    }
}

