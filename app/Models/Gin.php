<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gin extends Model
{
    use HasFactory;
    protected $table = "gins";
    protected $fillable = [
        'gin_code', 'order_request_code', 'supplier_code',  'date', 'total_cost_payment'
    ];

    public function items()
    {
        return $this->hasMany(GinItems::class, 'gin_id');
    }
    
    
}
