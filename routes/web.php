<?php

use App\Controllers\HomeController;
use App\Core\Routing\Route;
use App\Controllers\AuthController;
use App\Controllers\PanelController;

Route::get('/',[HomeController::class,'index']);
Route::post('/',[HomeController::class,'createUrl']);
Route::get('/auth',[AuthController::class,'index']);

Route::get('/panel',[PanelController::class,'index']);

Route::post('/auth',[AuthController::class,'Login']);
Route::post('/',[HomeController::class,'index2']);
