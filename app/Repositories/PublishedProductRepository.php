<?php

namespace App\Repositories;

use App\Interfaces\PublishedProductRepositoryInterface;
use App\Models\PublishedProduct;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class PublishedProductRepository implements PublishedProductRepositoryInterface
{
    /**
     * Get all published products with Redis cache.
     */
    public function getAllPublishedProducts()
    {
        try {
            return Cache::remember('published_products', 30, function () {
                return PublishedProduct::where('is_active', true)->get();
            });
        } catch (\Exception $e) {
            Log::error('Error fetching all published products: ' . $e->getMessage());
            return response()->json(['error' => 'Error fetching all published products'], 500);
        }
    }

    /**
     * Get a single published product by ID with Redis cache.
     */
    public function getPublishedProductById($id)
    {
        try {
            return Cache::remember("published_product_{$id}", 30, function () use ($id) {
                $publishedProduct = PublishedProduct::where('is_active', true)->where('id', $id)->first();

                if (!$publishedProduct) {
                    return response()->json(['error' => 'Published product not found'], 404);
                }

                return $publishedProduct;
            });
        } catch (ModelNotFoundException $e) {
            Log::warning('Published product not found: ' . $e->getMessage());
            return response()->json(['error' => 'Published product not found'], 404);
        } catch (\Exception $e) {
            Log::error('Error fetching published product by ID: ' . $e->getMessage());
            return response()->json(['error' => 'Error fetching published product by ID'], 500);
        }
    }

    /**
     * Get all banned products with Redis cache.
     */
    public function getAllBannedProducts()
    {
        try {
            return Cache::remember('banned_products', 30, function () {
                // return PublishedProduct::where('is_active', true)->where('is_banned', true)->get();
                return PublishedProduct::where('is_banned', true)->get();
            });
        } catch (\Exception $e) {
            Log::error('Error fetching all banned products: ' . $e->getMessage());
            return response()->json(['error' => 'Error fetching all banned products'], 500);
        }
    }

}
