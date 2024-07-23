<?php

namespace App\Http\Controllers;
use App\Models\User;

use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function showUsers()
    {
        $users = User::all();
        return view('setting.roles.assign_user_role', compact('users'));
    }
}
