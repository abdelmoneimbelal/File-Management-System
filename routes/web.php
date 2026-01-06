<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\FileController;

// Home redirect
Route::get('/', function () {
    return redirect()->route('files.index');
});

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'login'])->middleware('guest');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');
// Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register')->middleware('guest');
// Route::post('/register', [RegisterController::class, 'register'])->middleware('guest');

// File Routes (Protected)
Route::middleware('auth')->prefix('files')->name('files.')->group(function () {
    Route::get('/', [FileController::class, 'index'])->name('index');
    Route::get('/create', [FileController::class, 'create'])->name('create');
    Route::post('/', [FileController::class, 'store'])->name('store');
    Route::delete('/{file}', [FileController::class, 'destroy'])->name('destroy');
});

// Public download and view routes (using token)
Route::get('/download/{token}', [FileController::class, 'download'])->name('files.download');
Route::get('/view/{token}', [FileController::class, 'view'])->name('files.view');
