<?php

namespace App\Http\Controllers;

use App\Interfaces\MoleculeRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $data = $request->validate([
            'molecule_name' => 'required|string|max:255|unique:molecules',
        ]);

        $data['created_by'] = Auth::id();

        $molecule = $this->moleculeRepository->createMolecule($data);

        return $this->jsonResponse($molecule, 201);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'molecule_name' => 'required|string|max:255|unique:molecules,molecule_name,' . $id,
        ]);

        $data['updated_by'] = Auth::id();

        $molecule = $this->moleculeRepository->updateMolecule($id, $data);
        return $this->jsonResponse($molecule);
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
