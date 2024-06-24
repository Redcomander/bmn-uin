<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryTable extends Model
{
    use HasFactory;
    protected $table = 'inventory';
    protected $guarded = ['id'];

    protected $casts = [
        'barcode' => 'string',
        // Add other cast types if needed

    ];

    public function inputter()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function relatedItems()
    {
        return $this->hasMany(InventoryTable::class, 'posisi', 'posisi');
    }
}
