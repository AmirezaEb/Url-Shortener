<?php

use App\Controllers\Home\HomeController;
use App\Core\Routing\Route;

Route::get('/',[HomeController::class,'index']);
Route::post('/',[HomeController::class,'createUrl']);
Route::post('/',[HomeController::class,'index2']);
