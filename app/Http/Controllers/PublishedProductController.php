<?php

namespace App\Http\Controllers;

use App\Interfaces\PublishedProductRepositoryInterface;
use Illuminate\Http\Request;

class PublishedProductController extends Controller
{
    protected $publishedProductRepository;

    public function __construct(PublishedProductRepositoryInterface $publishedProductRepository)
    {
        $this->publishedProductRepository = $publishedProductRepository;
    }

    public function index()
    {
        $publishedProducts = $this->publishedProductRepository->getAllPublishedProducts();
        if ($publishedProducts instanceof \Illuminate\Http\JsonResponse) {
            return $publishedProducts;
        }
        return response()->json($publishedProducts);
    }

    public function show($id)
    {
        $publishedProduct = $this->publishedProductRepository->getPublishedProductById($id);
        if ($publishedProduct instanceof \Illuminate\Http\JsonResponse) {
            return $publishedProduct;
        }
        return response()->json($publishedProduct);
    }
}
