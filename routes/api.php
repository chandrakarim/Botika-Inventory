<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MemberController;
use App\Http\Controllers\Api\InventoryController;
use App\Http\Controllers\Api\DepartmentController;
use App\Http\Controllers\Api\PositionController;


Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('departments', DepartmentController::class);
    Route::apiResource('positions', PositionController::class);
    Route::apiResource('members', MemberController::class);
    Route::apiResource('inventories', InventoryController::class);
    Route::get('/analytics', [InventoryController::class, 'analytics']);
});


Route::middleware('auth:sanctum')->get('/me', function (Request $request) {
    return $request->user();
});

