<?php

namespace App\Http\Controllers;

use App\Interfaces\DraftProductRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class DraftProductController extends Controller
{
    protected $draftProductRepository;

    public function __construct(DraftProductRepositoryInterface $draftProductRepository)
    {
        $this->draftProductRepository = $draftProductRepository;
    }

    public function index()
    {
        $draftProducts = $this->draftProductRepository->getAllDraftProducts();
        if ($draftProducts instanceof \Illuminate\Http\JsonResponse) {
            return $draftProducts;
        }
        return response()->json($draftProducts);
    }

    public function show($id)
    {
        $draftProduct = $this->draftProductRepository->getDraftProductById($id);
        if ($draftProduct instanceof \Illuminate\Http\JsonResponse) {
            return $draftProduct;
        }
        return response()->json($draftProduct);
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'product_name' => 'required|string|max:255|unique:draft_products',
                'manufacturer_name' => 'required|string|max:255',
                'category_id' => 'required|exists:categories,id',
                'sales_price' => 'required|numeric',
                'mrp' => 'required|numeric|gte:sales_price',
                'molecule_string' => 'required|string',
                'is_discontinued' => 'required|boolean',
                'is_assured' => 'required|boolean',
                'is_refridgerated' => 'required|boolean',
            ]);


            $data['created_by'] = Auth::id();

            // return $this->draftProductRepository->createDraftProduct($data);
            $draftProduct = $this->draftProductRepository->createDraftProduct($data);
            if ($draftProduct instanceof \Illuminate\Http\JsonResponse) {
                return $draftProduct;
            }
            return response()->json($draftProduct, 201);
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
                'product_name' => 'required|string|max:255|unique:draft_products,product_name,' . $id,
                'manufacturer_name' => 'required|string|max:255',
                'category_id' => 'required|exists:categories,id',
                'sales_price' => 'required|numeric',
                'mrp' => 'required|numeric|gte:sales_price',
                'molecule_string' => 'required|string',
                'is_banned' => 'required|boolean',
                'is_discontinued' => 'required|boolean',
                'is_assured' => 'required|boolean',
                'is_refridgerated' => 'required|boolean',
            ]);

            $data['updated_by'] = Auth::id();

            $draftProduct = $this->draftProductRepository->updateDraftProduct($id, $data);
            if ($draftProduct instanceof \Illuminate\Http\JsonResponse) {
                return $draftProduct;
            }
            return response()->json($draftProduct);
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
        $draftProduct = $this->draftProductRepository->deleteDraftProduct($id);
        if ($draftProduct instanceof \Illuminate\Http\JsonResponse) {
            return $draftProduct;
        }
        return response()->json($draftProduct);
    }

    /**
     * Publish a draft product.
     */
    public function publish($id)
    {
        return $this->draftProductRepository->publishDraftProduct($id);
    }
}
