<?php

# Define the base path for the application
define('BASEPATH', realpath(__DIR__ . '/../') . '/');

# Check if necessary files exist before including them
if (file_exists(BASEPATH . 'vendor/autoload.php') && file_exists(BASEPATH . 'helpers/helper.php')) {

    # Autoload dependencies using Composer
    require BASEPATH . 'vendor/autoload.php';

    # Load environment variables from the .env file
    Dotenv\Dotenv::createImmutable(BASEPATH)->load();

    # Set the application language using the configured environment variable
    App\Utilities\Lang::set($_ENV['APP_LANG']);

    # Run the global exception handler to manage errors and exceptions
    App\Utilities\ExceptionHandler::run();
    
    # Initialize the session management
    App\Utilities\Session::run();

    # Run the application's routing system to handle incoming requests
    App\Core\Routing\Route::run();

    # Include helper functions for the application
    require BASEPATH . 'helpers/helper.php';

    # Include the database configuration settings
    require BASEPATH . 'config/database.php';

    if (!extension_loaded('gd')) {
        view('errors.GDLibrary');
    }
    
} else {
    # If required files are missing, display a 500 error page
    include BASEPATH . 'resources/views/errors/500.php';
}
