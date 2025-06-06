<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ConcertController;
use App\Http\Controllers\BookingController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

Route::get('/concerts', [ConcertController::class, 'index']);
Route::get('/concerts/{id}', [ConcertController::class, 'show']);

Route::middleware('auth:sanctum')->post('/bookings', [BookingController::class, 'book']);
Route::middleware('auth:sanctum')->post('/bookings/cancel', [BookingController::class, 'cancel']);
