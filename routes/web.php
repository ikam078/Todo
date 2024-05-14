<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/tak', [App\Http\Controllers\HomeController::class, 'index']);

Route::middleware(['auth'])->group(function () {
    Route::resource('tasks', TaskController::class);
    Route::patch('todos/{todo}/status', [TaskController::class, 'updateStatus']);

    // Tambahkan route logout
    Route::post('/logout', function () {
        Auth::logout();
        return redirect('/'); // Redirect ke halaman utama setelah logout
    })->name('logout');
});