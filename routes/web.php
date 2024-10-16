<?php

use App\Controllers\HomeController;
use App\Core\Routing\Route;
use App\Controllers\AuthController;
use App\Controllers\PanelController;

Route::get('/auth', [AuthController::class, 'index']);
Route::post('/auth', [AuthController::class, 'handelrAuth']);


Route::get('/panel', [PanelController::class, 'index']);

Route::get('/', [HomeController::class, 'index']);
