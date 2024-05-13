<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/test', function () {
    return view('auth.logins');
});
Route::get('/template', function () {
    return view('layouts.template');
});
Route::resource('/category', App\Http\Controllers\CategoryController::class);
