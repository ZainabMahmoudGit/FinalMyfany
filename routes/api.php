<?php

use App\Http\Controllers\DriverController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OTPController;


Route::middleware('api')->group(function () {
    
  

  Route::post('/send-otp', [OTPController::class, 'sendOtp']);
  Route::post('/verify-otp', [OTPController::class, 'verifyOtp']);
  Route::post('/update-profile', [OTPController::class, 'updateProfile']);


  Route::get('/users/{id}', [OTPController::class, 'indexUser']);
  Route::put('/users/{id}', [OTPController::class, 'updateUser']);
  Route::delete('/users/{id}', [OTPController::class, 'deleteUser']);


  Route::prefix('drivers')->group(function () {
    Route::post('send-otp', [DriverController::class, 'sendOtp']);
    Route::post('verify-otp', [DriverController::class, 'verifyOtp']);
    Route::put('update-profile', [DriverController::class, 'updateProfile']);
    Route::get('/', [DriverController::class, 'index']);
    Route::get('{id}', [DriverController::class, 'indexDriver']);
    Route::delete('{id}', [DriverController::class, 'deleteDriver']);

  });

});


