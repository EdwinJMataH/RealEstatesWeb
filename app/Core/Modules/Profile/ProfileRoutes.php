<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;


Route::prefix('profile')->group(function () {
    Route::get('/', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/all', [ProfileController::class, 'all'])->name('profile.all');
});
