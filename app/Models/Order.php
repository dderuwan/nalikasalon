<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = "pos";
    protected $fillable = [
        'order_code', 'customer_code', 'date',  'total_cost_payment', 'discount','vat','paid_amount','change','payment_type'
    ];

    public function items()
    {
        return $this->hasMany(OrderItems::class, 'pos_id');
    }
}
