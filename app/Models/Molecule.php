<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Molecule extends Model
{
    use HasFactory;

    protected $table = 'molecules';

    protected $fillable = [
        'molecule_name',
        'created_by',
        'updated_by',
        'is_delete',
        'deleted_at',
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
