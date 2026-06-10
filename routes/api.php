<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\BannerController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/signin', [AuthController::class, 'processLoginApi']); 
Route::post('/signup', [AuthController::class, 'prosessRegisterApi']);

Route::get('/pdf', function (Request $request) {
    $lang = $request->query('lang', 'en');
    $path = storage_path("app/pdfs/document_{$lang}.pdf");
    return response()->file($path, ['Content-Type' => 'application/pdf']);
});


Route::get('/posts', [PostController::class, 'allposts']);
Route::get('/banners', [BannerController::class, 'allbanners']);

Route::post('/verifyotp', [AuthController::class, 'verifyOtp']);
