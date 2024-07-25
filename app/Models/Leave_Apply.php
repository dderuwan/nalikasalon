<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leave_Apply extends Model
{
    use HasFactory;
    protected $table = 'leave_apply';

    protected $fillable = [
        'employee_id' ,
        'leave_type_id' ,
        'apply_strt_date' ,
        'apply_end_date' ,
        'apply_day' ,
        'leave_aprv_strt_date' ,
        'leave_aprv_end_date' ,
        'num_aprv_day' ,
        'reason' ,
        'apply_hard_copy' ,
        'apply_date' ,
        'approve_date' ,
        'approved_by' ,
    ];


    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function leaveType()
    {
        return $this->belongsTo(Leave_type::class, 'leave_type_id');
    }
}
