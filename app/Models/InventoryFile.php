<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryFile extends Model
{
    protected $fillable = [
        'inventory_id',
        'file_name',
        'file_path',
        'file_type',
        'file_size'
    ];

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }
    
}
