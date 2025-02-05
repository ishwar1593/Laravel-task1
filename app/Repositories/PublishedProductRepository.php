<?php

namespace App\Repositories;

use App\Interfaces\PublishedProductRepositoryInterface;
use App\Models\PublishedProduct;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class PublishedProductRepository implements PublishedProductRepositoryInterface
{
    public function getAllPublishedProducts()
    {
        try {
            return PublishedProduct::where('is_active', true)->get();
        } catch (\Exception $e) {
            Log::error('Error fetching all draft products: ' . $e->getMessage());
            return response()->json(['error' => 'Error fetching all draft products'], 500);
        }
    }

    public function getPublishedProductById($id)
    {
        try {
            $draftProduct = PublishedProduct::where('is_active', true)->where('id', $id)->first();
            if (!$draftProduct) {
                return response()->json(['error' => 'Draft product not found'], 404);
            }
            return $draftProduct;
        } catch (ModelNotFoundException $e) {
            Log::warning('Draft product not found: ' . $e->getMessage());
            return response()->json(['error' => 'Draft product not found'], 404);
        } catch (\Exception $e) {
            Log::error('Error fetching draft product by ID: ' . $e->getMessage());
            return response()->json(['error' => 'Error fetching draft product by ID'], 500);
        }
    }
}
