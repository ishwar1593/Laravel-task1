<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDraft extends Model
{
    use HasFactory;

    protected $table = 'product_drafts';

    protected $fillable = [
        'product_name',
        'manufacturer_name',
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
}
