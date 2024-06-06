<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ModuleController;

Route::prefix('module')->group(function () {
    Route::post('/', [ModuleController::class, 'index'])->name('module.index');
});
