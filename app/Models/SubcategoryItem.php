<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubcategoryItem extends Model
{
    use HasFactory;

    protected $table = 'subcategory_items';

    protected $fillable = [
        'bridelpreorder_id',
        'subcategory_id',
        'item_id',
    ];

    // Define relationships
    public function bridelPreorder()
    {
        return $this->belongsTo(BridelPreorder::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(BridelSubCategory::class); // Ensure you have a Subcategory model
    }

    public function item()
    {
        return $this->belongsTo(BridelItems::class); // Ensure you have an Item model
    }
}
