<?php

use Illuminate\Database\Capsule\Manager as DataBase;

$dataBase = new DataBase;

$dataBase->addConnection([
    'driver' => 'mysql',
    'host' => $_ENV['DB_HOST'],
    'database' => $_ENV['DB_NAME'],
    'username' => $_ENV['DB_USER'],
    'password' => $_ENV['DB_PASS'],
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'perfix' => ''
]);

$dataBase->setAsGlobal();
$dataBase->bootEloquent();
?>