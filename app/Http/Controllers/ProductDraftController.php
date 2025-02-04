<?php

namespace App\Http\Controllers;

use App\Interfaces\ProductDraftRepositoryInterface;
use Illuminate\Http\Request;

class ProductDraftController extends Controller
{
    protected $productDraftRepository;

    public function __construct(ProductDraftRepositoryInterface $productDraftRepository)
    {
        $this->productDraftRepository = $productDraftRepository;
    }

    // get all product drafts
    public function index()
    {
        return response()->json($this->productDraftRepository->getAllProductDrafts());
    }

    // get product draft by id
    public function show($id)
    {
        return response()->json($this->productDraftRepository->getProductDraftById($id));
    }

    // create product draft
    public function store(Request $request)
    {
        $data = $request->validate([
            'product_name' => 'required|string|max:255|unique:product_drafts',
            'manufacturer_name' => 'required|string|max:255',
            'sales_price' => 'required|numeric',
            'mrp' => 'required|numeric',
            'molecule_string' => 'required|string',
            'is_banned' => 'required|boolean',
            'is_discontinued' => 'required|boolean',
            'is_assured' => 'required|boolean',
            'is_refridgerated' => 'required|boolean',
            'is_published' => 'required|boolean',
            'created_by' => 'required|exists:users,id',
            'updated_by' => 'required|exists:users,id',
            'is_active' => 'required|boolean',
            'deleted_by' => 'nullable|exists:users,id',
        ]);

        return response()->json($this->productDraftRepository->createProductDraft($data), 201);
    }

    // update product draft
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'product_name' => 'required|string|max:255|unique:product_drafts,product_name,' . $id,
            'manufacturer_name' => 'required|string|max:255',
            'sales_price' => 'required|numeric',
            'mrp' => 'required|numeric',
            'molecule_string' => 'required|string',
            'is_banned' => 'required|boolean',
            'is_discontinued' => 'required|boolean',
            'is_assured' => 'required|boolean',
            'is_refridgerated' => 'required|boolean',
            'is_published' => 'required|boolean',
            'created_by' => 'required|exists:users,id',
            'updated_by' => 'required|exists:users,id',
            'is_active' => 'required|boolean',
            'deleted_by' => 'nullable|exists:users,id',
        ]);

        return response()->json($this->productDraftRepository->updateProductDraft($id, $data));
    }

    // delete product draft
    public function destroy($id)
    {
        return response()->json($this->productDraftRepository->deleteProductDraft($id));
    }
}
