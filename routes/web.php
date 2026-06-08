<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
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




