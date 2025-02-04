<?php

namespace App\Http\Controllers;

use App\Interfaces\MoleculeRepositoryInterface;
use Illuminate\Http\Request;

class MoleculeController extends Controller
{
    protected $moleculeRepository;

    public function __construct(MoleculeRepositoryInterface $moleculeRepository)
    {
        $this->moleculeRepository = $moleculeRepository;
    }

    public function index()
    {
        $molecules = $this->moleculeRepository->getAllMolecules();
        if ($molecules instanceof \Illuminate\Http\JsonResponse) {
            return $molecules;
        }
        return response()->json($molecules);
    }

    public function show($id)
    {
        $molecule = $this->moleculeRepository->getMoleculeById($id);
        if ($molecule instanceof \Illuminate\Http\JsonResponse) {
            return $molecule;
        }
        return response()->json($molecule);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'molecule_name' => 'required|string|max:255|unique:molecules',
            'created_by' => 'required|exists:users,id',
            'updated_by' => 'required|exists:users,id',
            'is_delete' => 'required|boolean',
            'deleted_at' => 'nullable|date',
            'deleted_by' => 'nullable|exists:users,id',
        ]);

        $molecule = $this->moleculeRepository->createMolecule($data);
        if ($molecule instanceof \Illuminate\Http\JsonResponse) {
            return $molecule;
        }
        return response()->json($molecule, 201);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'molecule_name' => 'required|string|max:255|unique:molecules,molecule_name,' . $id,
            'created_by' => 'required|exists:users,id',
            'updated_by' => 'required|exists:users,id',
            'is_delete' => 'required|boolean',
            'deleted_at' => 'nullable|date',
            'deleted_by' => 'nullable|exists:users,id',
        ]);

        $molecule = $this->moleculeRepository->updateMolecule($id, $data);
        if ($molecule instanceof \Illuminate\Http\JsonResponse) {
            return $molecule;
        }
        return response()->json($molecule);
    }

    public function destroy($id)
    {
        $molecule = $this->moleculeRepository->deleteMolecule($id);
        if ($molecule instanceof \Illuminate\Http\JsonResponse) {
            return $molecule;
        }
        return response()->json($molecule);
    }
}
