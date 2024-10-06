<?php
define('BASEPATH', __DIR__ . '/../');

if (file_exists(BASEPATH . '/vendor/autoload.php') && file_exists(BASEPATH . '/helpers/helper.php')) {
    include BASEPATH . "/vendor/autoload.php";
    $dotenv = Dotenv\Dotenv::createImmutable(BASEPATH);
    $dotenv->load();
    App\Utilities\Lang::set($_ENV['APP_LANG']);
    include BASEPATH . "/helpers/helper.php";
} else {
    include BASEPATH . "/resources/views/errors/500.php";
}
