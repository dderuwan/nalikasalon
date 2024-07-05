<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_code',
        'item_name',
        'item_description',
        'pack_size',
        'item_quentity',
        'unit_price',
        'supplier_code',
        'image',
    ];
}
