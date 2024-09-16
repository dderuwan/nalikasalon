<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditionalPackage extends Model
{
    use HasFactory;

    protected $table = 'additional_packages';

    protected $fillable = [
        'bridelpreorder_id',
        'package_id',
    ];

    // Define relationships
    public function bridelPreorder()
    {
        return $this->belongsTo(BridelPreorder::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class); // Ensure you have a Package model
    }
}
