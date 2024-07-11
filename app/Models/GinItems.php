<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GinItems extends Model
{
    use HasFactory;
    protected $table = "gin_items";
    protected $fillable = [
        'gin_id', 'item_name', 'packsize', 'unit_price', 'in_quantity', 'total_cost','payment',
    ];

    public function gin()
    {
        return $this->belongsTo(Gin::class, 'gin_id');
    }

    
}
