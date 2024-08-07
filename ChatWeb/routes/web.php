<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ChatController;

Route::get('/', function () {
    return view('auth/login');
});

Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);

// Ruta para mostrar el formulario de registro
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');

// Ruta para manejar el envío del formulario de registro
Route::post('register', [RegisterController::class, 'register']);

// Ruta para la vista de chat
Route::get('chat', [ChatController::class, 'showChat'])->middleware('auth')->name('chat');

// Ruta para enviar mensajes de chat
Route::post('send-message', [ChatController::class, 'sendMessage'])->middleware('auth');

// Ruta para cerrar sesión
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('chat', [ChatController::class, 'index'])->name('chat');
    Route::post('chat/send', [ChatController::class, 'sendMessage'])->name('chat.send');
});
