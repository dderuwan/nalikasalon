<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalonThretment extends Model
{
    use HasFactory;

    protected $table = 'salon_threatment';

    protected $fillable = [
        'Booking_number',
        'contact_number_1',
        'customer_id',
        'customer_name',
        'service_id',
        'package_id',
        'today',
        'Appoinment_date',
        'Appointment_time',
        'note',
        'Main_Dresser',
        'Assistent_Dresser_1',
        'Assistent_Dresser_2',
        'Assistent_Dresser_3',
        'Discount',
        'payment_method',
        'total_price',
        'status',
    ];
}
