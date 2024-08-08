<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeAvailability extends Model
{
    use HasFactory;

    protected $table = 'employee_availabilities';

    protected $fillable = [
        'employee_id',
        'date',
        'time_slot'
    ];

    /**
     * Get the employee that owns the availability.
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
