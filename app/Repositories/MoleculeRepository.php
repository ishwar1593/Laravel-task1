<?php

namespace App\Repositories;

use App\Interfaces\MoleculeRepositoryInterface;
use App\Models\Molecule;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class MoleculeRepository implements MoleculeRepositoryInterface
{
    public function getAllMolecules()
    {
        try {
            return Molecule::where('is_delete', false)->get();
        } catch (\Exception $e) {
            Log::error('Error fetching all molecules: ' . $e->getMessage());
            return response()->json(['error' => 'Error fetching all molecules'], 500);
        }
    }

    public function getMoleculeById($id)
    {
        try {
            $molecule = Molecule::where('is_delete', false)->findOrFail($id);
            return $molecule;
        } catch (ModelNotFoundException $e) {
            Log::warning('Molecule not found: ' . $e->getMessage());
            return response()->json(['error' => 'Molecule not found'], 404);
        } catch (\Exception $e) {
            Log::error('Error fetching molecule by ID: ' . $e->getMessage());
            return response()->json(['error' => 'Error fetching molecule by ID'], 500);
        }
    }

    public function createMolecule(array $data)
    {
        try {
            return Molecule::create($data);
        } catch (\Exception $e) {
            Log::error('Error creating molecule: ' . $e->getMessage());
            return response()->json(['error' => 'Error creating molecule'], 500);
        }
    }

    public function updateMolecule($id, array $data)
    {
        try {
            $molecule = Molecule::where('is_delete', false)->findOrFail($id);
            $molecule->update($data);
            return $molecule;
        } catch (ModelNotFoundException $e) {
            Log::warning('Molecule not found: ' . $e->getMessage());
            return response()->json(['error' => 'Molecule not found'], 404);
        } catch (\Exception $e) {
            Log::error('Error updating molecule: ' . $e->getMessage());
            return response()->json(['error' => 'Error updating molecule'], 500);
        }
    }

    public function deleteMolecule($id)
    {
        try {
            // Fetch the molecule with `first()`
            $molecule = Molecule::where('is_delete', false)->where('id', $id)->first();

            // Debugging: Check if molecule is found
            if (!$molecule) {
                return response()->json(['message' => 'Molecule not found or already deleted'], 404);
            }

            // Soft delete the molecule
            $molecule->is_delete = true;
            $molecule->deleted_at = now();
            $molecule->deleted_by = Auth::id();
            $molecule->save();

            return response()->json(['success' => true, 'message' => 'Molecule deleted successfully']);
        } catch (\Exception $e) {
            Log::error('Error deleting molecule: ' . $e->getMessage());
            return response()->json(['error' => 'Error deleting molecule'], 500);
        }
    }
}
