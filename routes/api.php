<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\ServiceCategoryController;
use App\Http\Controllers\SubserviceController;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;
use Illuminate\Http\Request;


Route::get('/countries', [LocationController::class, 'getCountries']); 
Route::get('/areas/{countryId}', [LocationController::class, 'getAreas']); 
Route::get('/area/{id}', [LocationController::class, 'getAreaDetails']); 

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);


Route::apiResource('service-categories', ServiceCategoryController::class);
Route::apiResource('subservices', SubserviceController::class);
Route::apiResource('packages', PackageController::class);

Route::apiResource('orders', OrderController::class);


Route::middleware([EnsureFrontendRequestsAreStateful::class, 'auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/test', function () {
    return response()->json([
        'message' => 'API is working successfully!',
        'status' => 200
    ]);
});