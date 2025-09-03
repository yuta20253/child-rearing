<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Auth\RegisterController;

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
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/test', function () {
        return response()->json(['message' => 'Hello from Laravel API']);
    });

    Route::delete('/logout', [AuthController::class, 'logout']);
    Route::delete('/delete-account', [RegisterController::class, 'accountDelete']);
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [RegisterController::class, 'register']);

Route::post('/password/reset/request', [AuthController::class, 'sendPasswordResetEmail'])->name('password.reset');
Route::post('/password/reset', [AuthController::class, 'updatePassword']);
