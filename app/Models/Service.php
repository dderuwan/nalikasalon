<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $table = "services";
    protected $fillable = [
        'service_code',
        'service_name',
        'description',
        'image',  
    ];

    // Define the relationship with the Package model
    public function packages()
    {
        return $this->hasMany(Package::class, 'services_id', 'service_code');
    }
}
