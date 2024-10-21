<?php

use App\Core\Routing\Route;
use App\Controllers\HomeController;
use App\Controllers\AuthController;
use App\Controllers\PanelController;

Route::get('/auth', [AuthController::class, 'index']);
Route::post('/auth', [AuthController::class, 'handelrAuth']);

Route::get('/panel', [PanelController::class, 'index']);
Route::get('/panel/edit/{url_id}', [PanelController::class, 'edit']);
Route::post('/panel/edit/{url_id}', [PanelController::class, 'edit']);
Route::get('/panel/delete/{url_id}', [PanelController::class, 'delete']);
Route::get('/panel/logout', [PanelController::class, 'logout']);

Route::get('/', [HomeController::class, 'index']);
