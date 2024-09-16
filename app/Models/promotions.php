<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class promotions extends Model
{
    use HasFactory;

    protected $table = 'promotions';

    // Define the attributes that are mass assignable
    protected $fillable = [
        'promotions_Id',
        'promotions_name',
        'description',
        'price',
        'start_date',
        'end_date',
    ];

}
