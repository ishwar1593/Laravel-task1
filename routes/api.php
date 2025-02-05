<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MoleculeController;
use App\Http\Controllers\DraftProductController;
use App\Http\Controllers\PublishedProductController;
use App\Http\Controllers\SearchController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('signup', [UserAuthController::class, 'signup']);
Route::post('login', [UserAuthController::class, 'login']);
// routes/api.php
Route::post('logout', [UserAuthController::class, 'logout'])->middleware('auth:sanctum');


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

// Product Draft Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('product-drafts', [DraftProductController::class, 'index']);
    Route::get('product-drafts/{id}', [DraftProductController::class, 'show']);
    Route::post('product-drafts', [DraftProductController::class, 'store']);
    Route::put('product-drafts/{id}', [DraftProductController::class, 'update']);
    Route::delete('product-drafts/{id}', [DraftProductController::class, 'destroy']);
    Route::post('product-drafts/publish/{id}', [DraftProductController::class, 'publish']);
});

// Published products
Route::middleware('auth:sanctum')->group(function () {
    Route::get('published-products', [PublishedProductController::class, 'index']);
    Route::get('published-products/banned', [PublishedProductController::class, 'bannedProducts']);
    Route::get('published-products/{id}', [PublishedProductController::class, 'show']);
});

// Search route
Route::get('search', [SearchController::class, 'search']);
