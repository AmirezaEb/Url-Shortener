<?php

namespace App\Utilities;

use Error;
use Exception;
use ErrorException;

class ExceptionHandler extends Exception
{
    /**
     * Handles an exception by logging it and displaying the appropriate error page.
     *
     * @param Exception $exception The exception to handle.
     * @return void
     */
    public static function handler($exception): void
    {
        # Check if the exception is an instance of Error or Exception
        if ($exception instanceof Error) {

            $severity = $exception->getCode(); // Use the error code as the severity

            # Create an ErrorException with the correct severity
            $exception = new ErrorException(
                $exception->getMessage(),
                $exception->getCode(),
                $severity,  # Correct severity type
                $exception->getFile(),
                $exception->getLine()
            );
        }

        # Log the exception details for debugging purposes
        self::logError($exception);

        # Check if the application is in development mode to determine error display
        if (self::isDevelopment()) {
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);
            self::displayDetailedError($exception);
        } else {
            ini_set('display_errors', 0);
            error_reporting(0);
            self::displayGenericError();
        }
    }

    /**
     * Logs the exception details to a log file.
     *
     * @param Exception $exception The exception to log.
     * @return void
     */
    private static function logError(Exception $exception): void
    {
        # Format the log message with relevant exception details
        $logMessage = sprintf(
            "[%s] %s : %s in %s on line %d\nStack Trace:\n%s\n\n",
            date('Y-m-d H:i:s'),
            get_class($exception),
            $exception->getMessage(),
            $exception->getFile(),
            $exception->getLine(),
            $exception->getTraceAsString()
        );

        # Write the log message to the specified error log file
        error_log($logMessage, 3, BASEPATH . 'logs/error.log');
    }

    /**
     * Checks if the application is running in development mode.
     *
     * @return bool Returns true if in development mode, otherwise false.
     */
    private static function isDevelopment(): bool
    {
        return $_ENV['APP_MODE'] === 'development'; # Simplified return statement
    }

    /**
     * Displays detailed error information for development.
     *
     * @param Exception $exception The exception to display.
     * @return void
     */
    private static function displayDetailedError(Exception $exception): void
    {
        # Render the development error view with the exception details
        view('errors.development', $exception);
        exit();
    }

    /**
     * Displays a generic error message for production.
     *
     * @return void
     */
    private static function displayGenericError(): void
    {
        # Render the production error view
        view('errors.500');
        exit();
    }

    /**
     * Handles shutdown errors by checking for fatal errors.
     *
     * @return void
     */
    public static function handlerShutdown(): void
    {
        $error = error_get_last(); # Get the last error if there is one
        # Check if the error is a fatal type
        if ($error && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
            # Handle the error as an exception
            self::handler(new ErrorException(
                $error['message'],
                0,
                $error['type'],
                $error['file'],
                $error['line']
            ));
        }
    }

    /**
     * Sets an error message in the session and redirects to a specified URL.
     *
     * @param string $message The error message to set.
     * @param string $target The URL to redirect to.
     * @return void
     */
    public static function setErrorAndRedirect(string $message, string $target): void
    {
        Session::set('error', $message); # Store the error message in the session
        redirect(siteUrl($target)); # Redirect to the specified URL
    }

    /**
     * Sets a message in the session and redirects to a specified URL.
     *
     * @param string $message The message to set.
     * @param string $target The URL to redirect to.
     * @return void
     */
    public static function setMessageAndRedirect(string $message, string $target): void
    {
        Session::set('message', $message); # Store the message in the session
        redirect(siteUrl($target)); # Redirect to the specified URL
    }

    /**
     * Sets an error message in the session without redirecting.
     *
     * @param string $message The error message to set.
     * @return void
     */
    public static function setError(string $message): void
    {
        Session::set('error', $message); # Store the error message in the session
    }

    /**
     * Sets an Success message in the session without redirecting.
     *
     * @param string $message The Success message to set.
     * @return void
     */
    public static function setMessage(string $message): void
    {
        Session::set('message', $message); # Store the Success message in the session
    }

    /**
     * Initializes the exception handler and shutdown function.
     *
     * @return void
     */
    public static function run(): void
    {
        # Set the exception handler to the handler method
        set_exception_handler([self::class, 'handler']);
        # Register the shutdown function to handle fatal errors
        register_shutdown_function([self::class, 'handlerShutdown']);
    }
}
