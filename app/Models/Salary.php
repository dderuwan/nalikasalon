<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    use HasFactory;


    protected $table = 'salary';
    protected $fillable = [
        'employee_id',
        'year',
        'month',
        'days_of_work',
        'no_pay_days',
        'no_pay_amount',
        'salary',
        'allowance',
        'epf_deduction',
        'salary_advance_deduction',
        'gross_salary',
    ];

    

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
