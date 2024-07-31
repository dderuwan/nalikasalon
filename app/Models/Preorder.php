<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Preorder extends Model
{
    use HasFactory;
    // Specify the table associated with the model if it's not the plural form of the model name
    protected $table = 'preorders';

    // Specify the primary key if it's not the default 'id'
    protected $primaryKey = 'id';

    // Define the attributes that are mass assignable
    protected $fillable = [
        'Auto_serial_number',
        'booking_reference_number',
        'customer_code',
        'customer_name',
        'customer_contact_1',
        'customer_address',
        'customer_dob',
        'Service_type',
        'Package_name_1',
        'Package_name_2',
        'Package_name_3',
        'appointment_date',
        'today',
        'appointment_time',
        'main_job_holder',
        'Assistant_1',
        'Assistant_2',
        'Assistant_3',
        'note',
        'payment_type',
        'Advanced_price',
        'Total_price',
    ];

    // Define the attributes that should be cast to a specific type
    protected $casts = [
        'customer_dob' => 'date',
        'appointment_date' => 'date',
        'today' => 'date',
        'Advanced_price' => 'decimal:2',
        'Total_price' => 'decimal:2',
    ];
}
