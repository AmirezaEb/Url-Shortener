<?php

use App\Controllers\HomeController;
use App\Core\Routing\Route;

Route::get('/',[HomeController::class,'index']);
Route::post('/',[HomeController::class,'index2']);
