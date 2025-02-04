<?php

namespace App\Repositories;

use App\Interfaces\CategoryRepositoryInterface;
use App\Models\Category;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function getAllCategories()
    {
        try {
            return Category::all();
        } catch (\Exception $e) {
            Log::error('Error fetching all categories: ' . $e->getMessage());
            return response()->json(['error' => 'Error fetching all categories'], 500);
        }
    }

    public function getCategoryById($id)
    {
        try {
            return Category::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            Log::warning('Category not found: ' . $e->getMessage());
            return response()->json(['error' => 'Category not found'], 404);
        } catch (\Exception $e) {
            Log::error('Error fetching category by ID: ' . $e->getMessage());
            return response()->json(['error' => 'Error fetching category by ID'], 500);
        }
    }
}
