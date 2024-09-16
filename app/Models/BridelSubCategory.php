<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BridelSubCategory extends Model
{
    use HasFactory;

    protected $table  = "bridel_sub_category";

    protected $fillable = [
        'subcategory_name',
        'description',
    ];

    public function packages()
    {
        return $this->belongsToMany(Package::class, 'package_sub_category');
    }

    public function bridelItems()
    {
        return $this->hasMany(BridelItems::class, 'Bridel_sub_category');
    }

}
