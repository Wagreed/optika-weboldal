<?php

use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

// Admin login with token
Route::get('/auth/admin-session/{token}', function ($token) {
    // Find user by token
    $accessToken = PersonalAccessToken::findToken($token);

    if (!$accessToken) {
        return redirect('/admin/login')->withErrors(['token' => 'Invalid token']);
    }

    $user = $accessToken->tokenable;

    // Login user with session
    Auth::login($user);

    // Redirect to admin panel
    return redirect('/admin');
})->name('admin.session');
