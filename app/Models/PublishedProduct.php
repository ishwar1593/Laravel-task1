<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class PublishedProduct extends Model
{
    use HasFactory;
    use Searchable;

    /**
     * Get the name of the index associated with the model.
     */
    public function searchableAs(): string
    {
        return 'published_products_index';
    }

    /**
     * Get the indexable data array for the model.
     */
    public function toSearchableArray(): array
    {
        $array = [
            "product_name" => $this->product_name,
            "product_ws_code" => $this->product_ws_code
        ];

        // Customize the data array...

        return $array;
    }


    protected $table = 'published_products';

    protected $fillable = [
        'product_name',
        'manufacturer_name',
        'category_id',
        'sales_price',
        'mrp',
        'molecule_string',
        'is_banned',
        'is_discontinued',
        'is_assured',
        'is_refridgerated',
        'is_published',
        'created_by',
        'updated_by',
        'is_active',
        'deleted_by',
        'draft_product_id',
        'product_ws_code',
    ];

    // Define relationships
    public function draftProduct()
    {
        return $this->belongsTo(DraftProduct::class, 'draft_product_id');
    }
}
