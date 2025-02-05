<?php

namespace App\Interfaces;

interface PublishedProductRepositoryInterface
{
    public function getAllPublishedProducts();
    public function getPublishedProductById($id);
    public function getAllBannedProducts();
}
