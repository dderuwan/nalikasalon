<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;


class Employee extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $table = 'employee';

    protected $fillable = [
        'firstname',
        'middlename',
        'lastname',
        'DOB',
        'NIC',
        'contactno',
        'email',
        'address',
        'city',
        'zipecode',
        'password',
        'status',
    ];

    // Hide attributes for arrays
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Cast attributes to native types
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Relationships
     */

    public function appointments()
    {
        return $this->hasMany(Preorder::class);
    }


    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    


}
