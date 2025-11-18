<?php

use App\Http\Controllers\SignupController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

// home at both "/" and "/index.html"
Route::view('/', 'pages.home')->name('home');
Route::view('/index.html', 'pages.home');
Route::view('/admin.html', 'pages.admin');

// keep legacy filenames so your links/iframe work unchanged
Route::view('/login.html', 'pages.login');
Route::view('/signup.html', 'pages.signup');
Route::view('/topten_slider.html', 'pages.topten_slider');

Route::get('/signup', function () {
    return view('pages.signup');
});
Route::post('/signup', [SignupController::class, 'signup']);

Route::get('login', function () {
    return view('pages.login');
});
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout']);
