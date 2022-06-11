<?php

use App\Http\Controllers\LessonController;
use App\Http\Controllers\BookingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/classes', [LessonController::class, 'index']);
Route::get('/classes/{lesson}', [LessonController::class, 'show']);
Route::post('/classes', [LessonController::class, 'store']);
Route::put('/classes/{lesson}', [LessonController::class, 'update']);
Route::delete('/classes/{lesson}', [LessonController::class, 'destroy']);

Route::get('/bookings', [BookingController::class, 'index']);
Route::get('/bookings/{booking}', [BookingController::class, 'show']);
Route::post('/bookings', [BookingController::class, 'store']);
Route::put('/bookings/{booking}', [BookingController::class, 'update']);
Route::delete('/bookings/{booking}', [BookingController::class, 'destroy']);