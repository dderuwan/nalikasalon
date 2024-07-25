<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $table = 'emp_attendance';

    protected $fillable = [
        'emp_id',
        'date' ,
        'sign_in' ,
        'sign_out' ,
        'stayed_time' 
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'emp_id');
    }

}
