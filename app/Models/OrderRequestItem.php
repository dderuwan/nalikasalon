<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderRequestItem extends Model
{
    use HasFactory;

    protected $fillable = ['order_request_id', 'item_code', 'instock', 'quantity', ];

    public function orderRequest()
    {
        return $this->belongsTo(OrderRequest::class,'order_request_id');
    }
}
