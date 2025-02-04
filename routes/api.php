<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\ProductDraftController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MoleculeController;

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

// Category Routes
// Route::middleware('auth:sanctum')->group(function () {
Route::get('categories', [CategoryController::class, 'index']);
Route::get('categories/{id}', [CategoryController::class, 'show']);
// });

// Molecule Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('molecules', [MoleculeController::class, 'index']);
    Route::get('molecules/{id}', [MoleculeController::class, 'show']);
    Route::post('molecules', [MoleculeController::class, 'store']);
    Route::put('molecules/{id}', [MoleculeController::class, 'update']);
    Route::delete('molecules/{id}', [MoleculeController::class, 'destroy']);
});
