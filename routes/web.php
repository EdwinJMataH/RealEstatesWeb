<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return Inertia::render('Prueba');
// });

Route::group([
    // 'prefix'     => '/admin',
    'middleware' => [
        'auth',
        'verified'
    ]
], function () {
    require base_path('app/Core/Modules/Dashboard/DashboardRoutes.php');
    require base_path('app/Core/Modules/Profile/ProfileRoutes.php');
    // require base_path('app/Core/Modules/ProfilesUsers/ProfilesUsersRoutes.php');
    require base_path('app/Core/Modules/User/UserRoutes.php');
    require base_path('app/Core/Modules/Estate/EstateRoutes.php');
    require base_path('app/Core/Modules/Module/ModuleRoutes.php');
    // Route::get('/dashboard', function () {
    //     return Inertia::render('Dashboard');
    // })->name('dashboard');
});
// Route::get('/a', function () {
//     return Inertia::render('Auth/Login');
// });

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
