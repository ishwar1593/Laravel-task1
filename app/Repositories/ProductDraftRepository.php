<?php

namespace App\Repositories;

use App\Interfaces\ProductDraftRepositoryInterface;
use App\Models\ProductDraft;

class ProductDraftRepository implements ProductDraftRepositoryInterface
{
    public function getAllProductDrafts()
    {
        return ProductDraft::all();
    }

    public function getProductDraftById($id)
    {
        return ProductDraft::findOrFail($id);
    }

    public function createProductDraft(array $data)
    {
        return ProductDraft::create($data);
    }

    public function updateProductDraft($id, array $data)
    {
        $productDraft = ProductDraft::findOrFail($id);
        $productDraft->update($data);
        return $productDraft;
    }

    public function deleteProductDraft($id)
    {
        $productDraft = ProductDraft::findOrFail($id);
        $productDraft->delete();
        return $productDraft;
    }
}
