<?php
define('BASEPATH', __DIR__ . '/../');

if (file_exists(BASEPATH . 'vendor/autoload.php') && file_exists(BASEPATH . 'helpers/helper.php')) {
    require BASEPATH . 'vendor/autoload.php';
    Dotenv\Dotenv::createImmutable(BASEPATH)->load();
    App\Utilities\Lang::set($_ENV['APP_LANG']);
    App\Utilities\Session::run();
    App\Utilities\ExceptionHandler::run();
    App\Core\Routing\Route::run();
    require BASEPATH . 'helpers/helper.php';
    require BASEPATH . 'config/database.php';
} else {
    include BASEPATH . 'resources/views/errors/500.php';
}
