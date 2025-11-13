<?php

use Illuminate\Support\Facades\Route;

// home at both "/" and "/index.html"
Route::view('/', 'pages.home')->name('home');
Route::view('/index.html', 'pages.home');
Route::view('/admin.html', 'pages.admin');

// keep legacy filenames so your links/iframe work unchanged
Route::view('/login.html', 'pages.login');
Route::view('/signup.html', 'pages.signup');
Route::view('/topten_slider.html', 'pages.topten_slider');
