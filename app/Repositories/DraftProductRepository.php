<?php

namespace App\Repositories;

use App\Interfaces\DraftProductRepositoryInterface;
use App\Models\DraftProduct;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use App\Models\Molecule;

class DraftProductRepository implements DraftProductRepositoryInterface
{
    public function getAllDraftProducts()
    {
        try {
            return DraftProduct::where('is_active', true)->get();
        } catch (\Exception $e) {
            Log::error('Error fetching all draft products: ' . $e->getMessage());
            return response()->json(['error' => 'Error fetching all draft products'], 500);
        }
    }

    public function getDraftProductById($id)
    {
        try {
            return DraftProduct::where('is_active', true)->where('id', $id)->first();
        } catch (ModelNotFoundException $e) {
            Log::warning('Draft product not found: ' . $e->getMessage());
            return response()->json(['error' => 'Draft product not found'], 404);
        } catch (\Exception $e) {
            Log::error('Error fetching draft product by ID: ' . $e->getMessage());
            return response()->json(['error' => 'Error fetching draft product by ID'], 500);
        }
    }

    public function createDraftProduct(array $data)
    {
        try {
            $moleculeIds = explode(',', $data['molecule_string']);
            $moleculeNames = [];

            foreach ($moleculeIds as $moleculeId) {
                $molecule = Molecule::find($moleculeId);
                if ($molecule) {
                    $moleculeNames[] = $molecule->molecule_name;
                }
            }

            $data['molecule_string'] = implode('+', $moleculeNames);

            return DraftProduct::create($data);
        } catch (\Illuminate\Database\QueryException $e) {
            // Check for unique constraint violation
            if ($e->getCode() == '23505') { // PostgreSQL unique violation error code
                Log::warning('Draft product creation failed due to unique constraint: ' . $e->getMessage());
                return response()->json(['error' => 'Draft product with this name already exists'], 409);
            }
            Log::error('Error creating draft product: ' . $e->getMessage());
            return response()->json(['error' => 'Error creating draft product'], 500);
        } catch (\Exception $e) {
            Log::error('Error creating draft product: ' . $e->getMessage());
            return response()->json(['error' => 'Error creating draft product'], 500);
        }
    }

    public function updateDraftProduct($id, array $data)
    {
        try {
            $draftProduct = DraftProduct::where('is_active', true)->findOrFail($id);

            $moleculeIds = explode(',', $data['molecule_string']);
            $moleculeNames = [];

            foreach ($moleculeIds as $moleculeId) {
                $molecule = Molecule::find($moleculeId);
                if ($molecule) {
                    $moleculeNames[] = $molecule->molecule_name;
                }
            }

            $data['molecule_string'] = implode('+', $moleculeNames);

            $draftProduct->update($data);
            return $draftProduct;
        } catch (ModelNotFoundException $e) {
            Log::warning('Draft product not found: ' . $e->getMessage());
            return response()->json(['error' => 'Draft product not found'], 404);
        } catch (\Exception $e) {
            Log::error('Error updating draft product: ' . $e->getMessage());
            return response()->json(['error' => 'Error updating draft product'], 500);
        }
    }

    public function deleteDraftProduct($id)
    {
        try {
            $draftProduct = DraftProduct::where('is_active', true)->findOrFail($id);

            // Debugging: Check if draft product is found
            if (!$draftProduct) {
                Log::warning('Draft product not found with ' . $id);
                return response()->json(['message' => 'Draft product not found or already deleted.'], 404);
            }

            $draftProduct->update(['is_active' => false]);
            return $draftProduct;
        } catch (\Exception $e) {
            Log::error('Error deleting draft product: ' . $e->getMessage());
            return response()->json(['error' => 'Error deleting draft product'], 500);
        }
    }
}
