<?php

use App\Core\Routing\Router;
use App\Services\Email;
use PHPMailer\PHPMailer\PHPMailer;

include "bootstrap/bootstrap.php";

$r = new Router();
$r->run();
// echo "<pre>";


?>