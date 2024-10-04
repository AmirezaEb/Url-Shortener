<?php
include "vendor/autoload.php";

use App\Core\Request;

echo $_SERVER['REQUEST_URI'];



$a = new Request();
var_dump($a);