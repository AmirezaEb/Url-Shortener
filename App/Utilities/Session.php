<?php

namespace App\Utilities;

/**
 * Class Session
 * Manages session data and settings for the application.
 */
class Session
{
    /**
     * Starts the session and configures session settings.
     *
     * Sets session cookie parameters and session garbage collection max lifetime.
     *
     * @return void
     */
    public static function run(): void
    {
        # Set session cookie parameters for enhanced security
        ini_set('session.cookie_httponly', '1'); # Prevent JavaScript access to session cookies
        ini_set('session.gc_maxlifetime', '300'); # Set session max lifetime to 300 seconds (5 minutes)

        # Start the session
        session_start();
    }

    /**
     * Sets a session variable.
     *
     * @param string $key The session variable key.
     * @param string|array $value The value to store in the session variable.
     * @return void
     */
    public static function set(string $key, string|array $value): void
    {
        $_SESSION[$key] = $value; # Store the value in the session array
    }

    /**
     * Retrieves a session variable value.
     *
     * @param string $key The session variable key.
     * @return mixed The value of the session variable or null if it does not exist.
     */
    public static function get(string $key): mixed
    {
        return self::has($key) ? $_SESSION[$key] : null; # Return the value if it exists, otherwise null
    }

    /**
     * Checks if a session variable exists.
     *
     * @param string $key The session variable key.
     * @return bool True if the session variable exists, false otherwise.
     */
    public static function has(string $key): bool
    {
        return isset($_SESSION[$key]); # Return true if the key exists in the session
    }

    /**
     * Checks if a session variable is empty.
     *
     * @param string $key The session variable key.
     * @return bool True if the session variable is empty, false otherwise.
     */
    public static function empty(string $key): bool
    {
        return empty($_SESSION[$key]); # Return true if the session variable is empty
    }

    /**
     * Deletes a session variable.
     *
     * @param string $key The session variable key to delete.
     * @return void
     */
    public static function delete(string $key): void
    {
        if (self::has($key)) {
            unset($_SESSION[$key]); # Remove the session variable if it exists
        }
    }

    /**
     * Clears all session variables and destroys the session.
     *
     * @return void
     */
    public static function clear(): void
    {
        session_unset(); # Unset all session variables
        session_destroy(); # Destroy the session
    }
}

