<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiftVouchers extends Model
{
    use HasFactory;

    protected $table = 'gift_voucher';

    // Define the attributes that are mass assignable
    protected $fillable = [
        'gift_voucher_Id',
        'gift_voucher_name',
        'description',
        'price',
        'start_date',
        'end_date',
    ];

    
}
