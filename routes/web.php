<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Artisan;

Route::get('/', function () {
    return redirect()->route('dashboard');
});


//login registration
Route::get('/register', [AuthController::class, 'showRegisterForm'])->middleware('guest')->name('register');
Route::post('/register', [AuthController::class, 'prosessRegister']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->middleware('guest')->name('login');
Route::post('/login', [AuthController::class, 'processLogin']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

Route::get('email/verify/{id}/{hash}', [AuthController::class, 'verify'])->name('verification.verify');
Route::get('/verification-notice', [AuthController::class, 'verificationShow'])->name('verification.notice');
Route::get('/email/resend', [AuthController::class, 'resend'])->name('resend');

//forget password
Route::get('/forgot-password', [AuthController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'reset'])->name('password.update');



// 2. Routes restricted to ADMINS ONLY (role = 1) using an inline check
Route::middleware(['auth'])->group(function () {

    // Logic wrapper just for admins
    Route::group(['middleware' => function ($request, $next) {
        if (auth()->user()->role != 1) {
            abort(403, 'Unauthorized. Admin access required.');
        }
        return $next($request);
    }], function () {
        
        Route::resource('posts', PostController::class);
        Route::resource('banners', BannerController::class);

        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
        
    });
});



Route::get('/create-storage-link', function () {
    Artisan::call('storage:link');
    return 'Storage link created successfully';
});



// Route::resource('posts', PostController::class);
// Route::resource('banners', BannerController::class);

// Route::middleware(['auth'])->group(function () {
//     Route::get('/users', [UserController::class, 'index'])->name('users.index');
//     Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
//     Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
//     Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
//     Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
// });
