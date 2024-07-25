<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyDetails extends Model
{
    use HasFactory;

    protected $table  = "company_details";

    protected $fillable = [
        'title',
        'address',
        'email',
        'contact',
        'logo',
        'website',
        'poweredbytext',
        'footertext',
    ];
}
