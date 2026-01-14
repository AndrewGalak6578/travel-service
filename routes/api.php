<?php

use App\Http\Controllers\Api\ActivityController;
use App\Http\Controllers\Api\BudgetController;
use App\Http\Controllers\Api\ContactRequestController;
use App\Http\Controllers\Api\DestinationController;
use App\Http\Controllers\Api\TripCompareController;
use App\Http\Controllers\Api\TripController;
use App\Http\Controllers\Api\TripDayController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/ping', fn() => ['ok' => true, 'time' => now()->toISOString()]);

Route::get('/destinations', [DestinationController::class, 'index']);
Route::get('/destinations/{destination:slug}', [DestinationController::class, 'show']);

Route::apiResource('trips', TripController::class);
Route::get('/trips/{trip}/full', [TripController::class, 'full']);

Route::post('/trips/{trip}/days', [TripDayController::class, 'store']);
Route::delete('/trips/{trip}/days/{day}', [TripDayController::class, 'destroy']);

Route::post('/days/{day}/activities', [ActivityController::class, 'store']);
Route::put('/activities/{activity}', [ActivityController::class, 'update']);
Route::delete('/activities/{activity}', [ActivityController::class, 'destroy']);
Route::post('/days/{day}/activities/reorder', [ActivityController::class, 'reorder']);

Route::put('/trips/{trip}/budget', [BudgetController::class, 'upsert']);

Route::get('/trips/compare', [TripCompareController::class, 'compare']); // ?a=1&b=2

Route::post('/contact', [ContactRequestController::class, 'store']);
