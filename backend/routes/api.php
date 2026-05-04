<?php

use App\Http\Controllers\Api\AppointmentController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\UserProfileController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Public product & category routes
Route::get('/products/featured', [ProductController::class, 'featured']);
Route::get('/products/{slug}', [ProductController::class, 'show']);
Route::get('/products', [ProductController::class, 'index']);
Route::get('/categories', [CategoryController::class, 'index']);

// Appointment types (public – a foglalási form tölti be)
Route::get('/appointment-types', [AppointmentController::class, 'types']);

// Naptár elérhetőség: blokkolt/foglalt napok és slotok adott hónapra
Route::get('/appointments/availability', [AppointmentController::class, 'availability']);

// Időpont foglalás: vendégek és bejelentkezett felhasználók is küldhetnek kérést
// A controller auth('sanctum')->user() hívással különbözteti meg őket
Route::post('/appointments', [AppointmentController::class, 'store']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);

    // User profile routes
    Route::get('/profile', [UserProfileController::class, 'show']);
    Route::put('/profile', [UserProfileController::class, 'update']);
    Route::post('/profile/avatar', [UserProfileController::class, 'uploadAvatar']);

    // Bejelentkezett felhasználó saját időpontjai
    Route::get('/appointments/my', [AppointmentController::class, 'myAppointments']);
});
