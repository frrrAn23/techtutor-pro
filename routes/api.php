<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('payments/midtrans-notification', [App\Http\Controllers\PaymentCallbackController::class, 'receive']);
Route::post('user-material-progress/{materialId}', [App\Http\Controllers\MaterialController::class, 'saveUserProgress'])->name('material.complete');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
