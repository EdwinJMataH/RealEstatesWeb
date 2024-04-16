<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfilesUsersController;

Route::get('/profiles-users', [ProfilesUsersController::class, 'index'])->name('profiles_users');