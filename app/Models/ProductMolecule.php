<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductMolecule extends Model
{
    use HasFactory;

    protected $table = 'product_molecules';

    protected $fillable = [
        'draft_product_id',
        'molecule_id',
    ];
    public $timestamps = false; // <--- Disable timestamps

    // Define relationships
    public function draftProduct()
    {
        return $this->belongsTo(DraftProduct::class, 'draft_product_id');
    }

    public function molecule()
    {
        return $this->belongsTo(Molecule::class, 'molecule_id');
    }
}
