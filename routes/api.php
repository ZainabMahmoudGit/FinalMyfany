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



// المسارات الخاصة بالخدمات (Services)
Route::prefix('services')->group(function () {
    Route::get('/', [ServiceCategoryController::class, 'index'])->name('services.index'); // عرض كل الخدمات
    Route::post('/', [ServiceCategoryController::class, 'store'])->name('services.store'); // إنشاء خدمة جديدة
    Route::get('/{category}', [ServiceCategoryController::class, 'show'])->name('services.show'); // عرض خدمة واحدة
    Route::put('/{category}', [ServiceCategoryController::class, 'update'])->name('services.update'); // تعديل خدمة
    Route::delete('/{category}', [ServiceCategoryController::class, 'destroy'])->name('services.destroy'); // حذف خدمة
});

// المسارات الخاصة بالخدمات الفرعية (Subservices)
Route::prefix('subservices')->group(function () {
    Route::get('/', [SubserviceController::class, 'index'])->name('subservices.index'); // عرض كل الخدمات الفرعية
    Route::post('/', [SubserviceController::class, 'store'])->name('subservices.store'); // إنشاء خدمة فرعية جديدة
    Route::get('/{subservice}', [SubserviceController::class, 'show'])->name('subservices.show'); // عرض خدمة فرعية واحدة
    Route::put('/{subservice}', [SubserviceController::class, 'update'])->name('subservices.update'); // تعديل خدمة فرعية
    Route::delete('/{subservice}', [SubserviceController::class, 'destroy'])->name('subservices.destroy'); // حذف خدمة فرعية
});

Route::get('/packages', [PackageController::class, 'index']);
