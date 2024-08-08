<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;


Route::prefix('profile')->group(function () {
    Route::get('/',          [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/update',    [ProfileController::class, 'update'])->name('profile.information');
    Route::post('/password', [ProfileController::class, 'password'])->name('profile.password');
    Route::post('/image',    [ProfileController::class, 'image'])->name('profile.image');
    Route::get('/show',  [ProfileController::class, 'show'])->name('profile.show');
});
