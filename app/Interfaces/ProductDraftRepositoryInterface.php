<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface ProductDraftRepositoryInterface
{
    public function getAllProductDrafts();
    public function getProductDraftById($id);
    public function createProductDraft(array $data);
    public function updateProductDraft($id, array $data);
    public function deleteProductDraft($id);
}
