<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

// Route::get('/profiles-users', [ProfilesUsersController::class, 'index'])->name('profiles_users');
// Route::resource('users', UserController::class);

Route::prefix('users')->group(function () {
    Route::get('/index', [UserController::class, 'all'])->name('users.all');
    Route::get('/', [UserController::class, 'index'])->name('users.index');
    Route::post('/', [UserController::class, 'store'])->name('users.store');
    Route::post('/{uuid}', [UserController::class, 'update'])->name('users.update');
    Route::post('/destroy/{uuid}', [UserController::class, 'destroy'])->name('users.destroy');
});
