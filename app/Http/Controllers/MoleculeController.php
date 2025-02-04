<?php

namespace App\Http\Controllers;

use App\Interfaces\MoleculeRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class MoleculeController extends Controller
{
    public function __construct(protected MoleculeRepositoryInterface $moleculeRepository) {}

    public function index()
    {
        $molecules = $this->moleculeRepository->getAllMolecules();
        return $this->jsonResponse($molecules);
    }

    public function show($id)
    {
        $molecule = $this->moleculeRepository->getMoleculeById($id);
        return $this->jsonResponse($molecule);
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'molecule_name' => 'required|string|max:255|unique:molecules',
            ]);

            $data['created_by'] = Auth::id();

            $molecule = $this->moleculeRepository->createMolecule($data);

            return $this->jsonResponse($molecule, 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'molecule_name' => 'required|string|max:255|unique:molecules,molecule_name,' . $id,
            ]);

            $data['updated_by'] = Auth::id();

            $molecule = $this->moleculeRepository->updateMolecule($id, $data);
            return $this->jsonResponse($molecule);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        return $this->moleculeRepository->deleteMolecule($id);
    }

    private function jsonResponse($data, $status = 200)
    {
        return response()->json($data, $status);
    }
}
