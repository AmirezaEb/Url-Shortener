<?php

namespace App\Utilities;

/* Developed by Hero Expert
- Telegram channel: @HeroExpert_ir
- Author: Amirreza Ebrahimi
- Telegram Author: @a_m_b_r
*/
class Lang
{
    # Holds the currently set language
    private static string $lang;

    # Stores the translations for the current language
    private static array $translation = [];

    /**
     * Set the desired language for translations.
     *
     * @param string $language The language code (e.g., 'en', 'fr').
     * @return void
     */
    public static function set(string $language): void
    {
        self::$lang = $language; # Set the language
        self::loadTranslation(); # Load the corresponding translations
    }

    /**
     * Load translations from a file based on the currently set language.
     *
     * The translation file must be located in the '/lang/' directory
     * with a naming convention of '{language}.php'.
     *
     * @return void
     */
    protected static function loadTranslation(): void
    {
        # Construct the path to the translation file
        $file = BASEPATH . '/lang/' . self::$lang . '.php';

        # Check if the translation file exists
        if (file_exists($file)) {
            self::$translation = include($file); # Load translations into the array
        } else {
            # Log a warning if the file does not exist (optional improvement)
            error_log("Translation file for language " . self::$lang . " not found.");
        }
    }

    /**
     * Retrieve the translation for a given key.
     *
     * If the key does not exist in the translations, return the key itself.
     *
     * @param string $key The translation key.
     * @return string The translated string or the key if not found.
     */
    public static function get(string $key): string
    {
        return self::$translation[$key] ?? $key; # Return the translation or the key
    }
}
