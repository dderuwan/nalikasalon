<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RealTimeBooking extends Model
{
    use HasFactory;

    protected $table = 'real_time_booking';

    protected $fillable = [
        'real_time_app_no',
        'customer_code',
        'customer_name',
        'customer_contact_1',
        'customer_address',
        'customer_dob',
        'Service_type',
        'Package_name_1',
        'Package_name_2',
        'Package_name_3',
        'today',
        'appointment_time',
        'main_job_holder',
        'Assistant_1',
        'Assistant_2',
        'Assistant_3',
        'note',
        'preorder_id',
        'Advanced_price',
        'payment_type',
        'gift_voucher_No',
        'gift_voucher_price',
        'promotional_code_No',
        'promotional_price',
        'Total discount',
        'vat',
        'Total_price',
    ];
}
