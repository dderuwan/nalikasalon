<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'employee';

    protected $fillable = [
        'firstname',
        'middlename' ,
        'lastname' ,
        'DOB' ,
        'NIC' ,
        'contactno' ,
        'Email' ,
        'address' ,
        'city' ,
        'zipecode',
        'status'
    ];

    public function appointments()
    {
        return $this->hasMany(Preorder::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'employee_roles');
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
   
}
