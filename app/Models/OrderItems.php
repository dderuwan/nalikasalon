<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItems extends Model
{
    use HasFactory;
    protected $table = "pos_items";
    protected $fillable = [
        'pos_id', 'item_code', 'item_name', 'quantity', 'total_cost', 
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'pos_id');
    }
}
