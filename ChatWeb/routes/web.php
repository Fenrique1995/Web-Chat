<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('auth/login');
});

Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);

Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

Route::post('user/update', [UserController::class, 'update'])->name('user.update');
Route::delete('user/delete', [UserController::class, 'destroy'])->name('user.delete');

Route::middleware(['auth'])->group(function () {
    Route::get('chat', [ChatController::class, 'showChat'])->name('chat');
    Route::post('chat/send', [ChatController::class, 'sendMessage'])->name('chat.send');
    Route::get('chat/messages', [ChatController::class, 'getMessages'])->name('chat.messages');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});
