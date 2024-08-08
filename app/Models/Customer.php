<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = "customers";
    protected $fillable = [
        'name',
        'contact_number_1',
        'contact_number_2',
        'address',
        'date_of_birth',
        'customer_code'
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
