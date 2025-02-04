<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\ProductDraftController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('signup', [UserAuthController::class, 'signup']);
Route::post('login', [UserAuthController::class, 'login']);
// routes/api.php
Route::post('logout', [UserAuthController::class, 'logout'])->middleware('auth:sanctum');

// Product Draft Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('product-drafts', [ProductDraftController::class, 'index']);
    Route::get('product-drafts/{id}', [ProductDraftController::class, 'show']);
    Route::post('product-drafts', [ProductDraftController::class, 'store']);
    Route::put('product-drafts/{id}', [ProductDraftController::class, 'update']);
    Route::delete('product-drafts/{id}', [ProductDraftController::class, 'destroy']);
});
