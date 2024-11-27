<?php

use App\Controllers\PanelController;
use App\Controllers\HomeController;
use App\Controllers\AuthController;
use App\Core\Routing\Route;

/**
 * Define authentication routes
 * 
 * These routes handle displaying the login page and processing
 * authentication requests (e.g., login or OTP).
 */
Route::get('/auth', [AuthController::class, 'index']); # Show the authentication form (login, OTP, etc.)
Route::post('/auth', [AuthController::class, 'handleAuth']); # Handle authentication form submission

/**
 * Define user panel routes
 * 
 * These routes manage the user panel, including viewing, editing, 
 * deleting URLs, and logging out.
 */
Route::get('/panel', [PanelController::class, 'index']); # Show the user panel dashboard
Route::get('/panel/edit/{url_id}', [PanelController::class, 'edit']); # Display the edit form for a specific URL
Route::post('/panel/edit/{url_id}', [PanelController::class, 'edit']); # Handle the URL edit form submission
Route::get('/panel/delete/{url_id}', [PanelController::class, 'delete']); # Handle URL deletion
Route::get('/panel/logout', [PanelController::class, 'logout']); # Log the user out of the panel

/**
 * Define the home page route
 * 
 * This route handles displaying the main landing page where users 
 * can shorten URLs or access the user panel.
 */
Route::get('/', [HomeController::class, 'index']); # Show the home page (URL shortener form)
Route::post('/', [HomeController::class, 'createUrl']);
Route::get('/{short_url}', [HomeController::class, 'redirectUrl']);
