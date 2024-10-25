<?php

use Illuminate\Database\Capsule\Manager as DataBase; # Import the Capsule Manager for Eloquent ORM

# Initialize the Eloquent database manager
$dataBase = new DataBase;

# Configure the database connection settings
$dataBase->addConnection([
    'driver' => 'mysql', # Specify the database driver
    'host' => $_ENV['DB_HOST'], # Database host from environment variable
    'database' => $_ENV['DB_NAME'], # Database name from environment variable
    'username' => $_ENV['DB_USER'], # Database username from environment variable
    'password' => $_ENV['DB_PASS'], # Database password from environment variable
    'charset' => 'utf8', # Character set for the database connection
    'collation' => 'utf8_unicode_ci', # Collation for string comparison
    'prefix' => '' # Table prefix (if needed, otherwise keep it empty)
]);

# Set the database connection as global to make it accessible throughout the application
$dataBase->setAsGlobal();

# Boot Eloquent, allowing you to use the ORM features
$dataBase->bootEloquent();

?>