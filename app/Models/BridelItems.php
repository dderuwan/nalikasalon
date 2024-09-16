<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BridelItems extends Model
{
    use HasFactory;

    protected $table  = "bridel_items";

    protected $fillable = [
        'Bridel_sub_category',
        'Item_name',
        'quentity',
        'price',
        'description',
    ];

    public function bridelSubCategory()
    {
        return $this->belongsTo(BridelSubCategory::class, 'Bridel_sub_category');
    }

}
