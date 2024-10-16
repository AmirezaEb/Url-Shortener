<?php

namespace App\Utilities;

use ErrorException;
use Exception;

class ExceptionHandler
{
    public static function handler(Exception $exception): void
    {
        self::logError($exception);

        if (self::isDevelopment()) {
            self::displayDetailedError($exception);
        } else {
            self::displayGenericError();
        }
    }

    private static function logError(Exception $exception): void
    {
        $logMessage = sprintf(
            "[%s] %s : %s in %s on line %d\nStack Trace:\n%s\n\n",
            date('Y-m-d H:i:s'),
            get_class($exception),
            $exception->getMessage(),
            $exception->getFile(),
            $exception->getLine(),
            $exception->getTraceAsString()
        );

        error_log($logMessage, 3, BASEPATH . 'logs/error.log');
    }

    private static function isDevelopment(): bool
    {

        if ($_ENV['APP_MODE'] === 'development') {
            return true;
        } else {
            return false;
        }
    }

    private static function displayDetailedError(Exception $exception): void
    {
        view('errors.development', $exception);
    }

    private static function displayGenericError(): void
    {
        view('errors.production');
    }

    public static function handlerShutdown(): void
    {
        $error = error_get_last();
        if ($error && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
            self::handler(new ErrorException(
                $error['message'],
                0,
                $error['type'],
                $error['file'],
                $error['line']
            ));
        }
    }

    public static function setErrorAndRedirect(string $message, string $target): void
    {
        Session::set('error', $message);
        Url::Redirect(siteUrl($target));
    }

    public static function setError(string $message): void
    {
        Session::set('error', $message);
    }

    public static function run(): void
    {
        set_exception_handler([self::class, 'handler']);
        register_shutdown_function([self::class, 'handlerShutdown']);
    }
}
