<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $fillable = [
        'inventory_code',
        'name',
        'type',
        'serial_number',
        'specification',
        'status',
        'member_id'
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function files()
    {
        return $this->hasMany(InventoryFile::class);
    }
}
