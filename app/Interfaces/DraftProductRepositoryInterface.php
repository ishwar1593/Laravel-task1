<?php

namespace App\Interfaces;

interface DraftProductRepositoryInterface
{
    public function getAllDraftProducts();
    public function getDraftProductById($id);
    public function createDraftProduct(array $data);
    public function updateDraftProduct($id, array $data);
    public function deleteDraftProduct($id);
    public function publishDraftProduct($id); // Add this method
}
