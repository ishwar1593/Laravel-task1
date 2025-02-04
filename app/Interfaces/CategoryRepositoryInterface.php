<?php

namespace App\Interfaces;

interface CategoryRepositoryInterface
{
    /**
     * Get all categories.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllCategories();

    /**
     * Get a category by its ID.
     *
     * @param int $id
     * @return \App\Models\Category
     */
    public function getCategoryById($id);
}
