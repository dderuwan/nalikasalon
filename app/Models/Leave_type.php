<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leave_type extends Model
{
    use HasFactory;
    protected $table = 'leave_type';

    protected $fillable = [
        'leave_type' ,
        'leave_days' ,
    ];
}
