<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CalenderController;

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

Route::middleware('auth:sanctum')->group(function () {
    Route::delete('/logout', [AuthController::class, 'logout']);
    Route::delete('/delete-account', [RegisterController::class, 'accountDelete']);
    Route::get('/profile', [UserController::class, 'profile']);

    Route::get('/facilities', [FacilityController::class, 'index']);
    Route::post('/facilities/{facilityId}/favorite', [FavoriteController::class, 'store'])->whereNumber('facilityId');
    Route::delete('/facilities/{facilityId}/favorite', [FavoriteController::class, 'destroy'])
            ->whereNumber('facilityId');
    Route::get('/facilities/{facilityId}', [FacilityController::class, 'show'])->whereNumber('facilityId');

    Route::get('/calendar/events', [CalenderController::class, 'index']);

    Route::get('/favorites', [FavoriteController::class, 'index']);
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [RegisterController::class, 'register']);

Route::post('/password/reset/request', [AuthController::class, 'sendPasswordResetEmail'])->name('password.reset');
Route::post('/password/reset/verify', [AuthController::class, 'verifyTokenAndEmail']);
Route::post('/password/reset', [AuthController::class, 'updatePassword']);
