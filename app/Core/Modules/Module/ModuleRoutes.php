<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ModuleController;

// Route::get('/profiles-users', [ProfilesUsersController::class, 'index'])->name('profiles_users');
// Route::resource('users', UserController::class);

Route::prefix('module')->group(function () {
    Route::get('/', [ModuleController::class, 'index'])->name('module.index');
});