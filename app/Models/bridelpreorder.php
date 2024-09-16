<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bridelpreorder extends Model
{
    use HasFactory;


    protected $table = 'bridelpreorder';

    protected $fillable = [
        'Auto_serial_number',
        'contact_number_1',
        'customer_id',
        'customer_name',
        'service_id',
        'package_id',
        'Appoinment_date',
        'today',
        'Appointment_time',
        'note',
        'photographer_name',
        'photographer_contact',
        'Main_Dresser',
        'Assistent_Dresser_1',
        'Assistent_Dresser_2',
        'Assistent_Dresser_3',
        'hotel_dress',
        'Transport',
        'Discount',
        'payment_method',
        'Gift_vouchwe_id',
        'Gift_voucher_value',
        'promotion_id',
        'Promotiona_value',
        'advanced_payment',
        'Balance_Payment',
        'total_price',
        'status'
    ];

    // Define relationships
    public function additionalPackages()
    {
        return $this->hasMany(AdditionalPackage::class);
    }

    public function subcategoryItems()
    {
        return $this->hasMany(SubcategoryItem::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id');
    }

    
}
