<?php

use Illuminate\Container\Container;
use Illuminate\Database\Capsule\Manager as Database;
use Illuminate\Support\Facades\Facade;

# Step 1: Set up the application container and Facades
$app = new Container();
Facade::setFacadeApplication($app);

# Step 2: Initialize and configure the Eloquent database manager
$database = new Database;

# Add the MySQL connection settings from environment variables
$database->addConnection([
    'driver' => 'mysql',             # Specify the database driver (MySQL)
    'host' => $_ENV['DB_HOST'],       # Database host (e.g., localhost or IP address)
    'database' => $_ENV['DB_NAME'],   # Database name
    'username' => $_ENV['DB_USER'],   # Database username
    'password' => $_ENV['DB_PASS'],   # Database password
    'charset' => 'utf8',              # Character encoding for the connection
    'collation' => 'utf8_unicode_ci', # Collation for string comparison (e.g., utf8_unicode_ci)
    'prefix' => ''                    # Table prefix (optional, default is no prefix)
]);

# Step 3: Make the database connection globally accessible
$database->setAsGlobal(); # Allows global access to the database connection throughout the app

# Step 4: Boot Eloquent ORM for full ORM functionality
$database->bootEloquent(); # Initialize Eloquent features (e.g., query builder, models)

# Step 5: Register the database manager in the container for easier access
$app->instance('db', $database->getDatabaseManager()); # Make database manager instance available as 'db'