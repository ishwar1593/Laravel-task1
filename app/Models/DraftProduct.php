<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DraftProduct extends Model
{
    use HasFactory;

    protected $table = 'draft_products';

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
    ];

    // Define relationships
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function deleter()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    public function molecules()
    {
        return $this->belongsToMany(Molecule::class, 'product_molecules', 'draft_product_id', 'molecule_id');
    }
}
