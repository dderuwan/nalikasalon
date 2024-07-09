<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderRequest extends Model
{
    use HasFactory;

    protected $fillable = ['order_request_code', 'supplier_code','date'];

    public function items()
    {
        return $this->hasMany(OrderRequestItem::class, 'order_request_id');
    }
}
