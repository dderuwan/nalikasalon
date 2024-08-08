<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $table = 'packages';

    protected $fillable = [
        'services_id',
        'package_name',
        'description',
        'price',
        'duration',
    ];

    // Define the inverse relationship with the Service model
    public function service()
    {
        return $this->belongsTo(Service::class, 'services_id', 'service_code');
    }

    public function appointments()
    {
        return $this->hasMany(Preorder::class);
    }
}
