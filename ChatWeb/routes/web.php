<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ChatController;

Route::get('/', function () {
    return view('auth/login');
});

Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);

Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

Route::middleware(['auth'])->group(function () {
    Route::get('chat', [ChatController::class, 'showChat'])->name('chat');
    Route::post('chat/send', [ChatController::class, 'sendMessage'])->name('chat.send');
    Route::get('chat/messages', [ChatController::class, 'getMessages'])->name('chat.messages');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});
