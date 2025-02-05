<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublishedProduct extends Model
{
    use HasFactory;

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
