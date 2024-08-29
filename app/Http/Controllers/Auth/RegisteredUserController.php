<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        //dd($request);
        $request->validate([
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:Employee,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'nic' => ['required', 'string', 'max:255'],
            'contactno' => ['required', 'string', 'max:255'],
        ]);
    
        
        $user = Employee::create([
            'firstname' => $request->firstname,
            'middlename'=> $request->middlename,
            'lastname' => $request->lastname,
            'DOB'=> $request->dob ,
            'NIC' => $request->nic,
            'contactno'=> $request->contactno ,
            'email' => $request->email,
            'address'=> $request->address ,
            'city'=> $request->city ,
            'zipecode'=> $request->zipcode,
            'password' => Hash::make($request->password),
            'status' => 1,
        ]);
    
        event(new Registered($user));
    
        Auth::login($user);
    
        return redirect()->route('wellcome');
    }
    
}
