<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Model
{
    use HasFactory;
    
    protected $table  = "users";

    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'password',
        'about',
        'image',
        'user_type',
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
}
