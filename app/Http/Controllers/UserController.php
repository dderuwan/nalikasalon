<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    public function index()
    {
        $user_list = User::all();
        return view('setting.user.add_user', compact('user_list'));
    }


    public function show()
    {
        $user_list = User::all();
        return view('setting.user.user_list', compact('user_list'));
    }


    public function store(StoreUserRequest $request)
    {
        $validatedData = $request->validated();
        try {
            foreach ($validatedData['firstname'] as $key => $value) {
                $user = new User();
                $user->firstname = $validatedData['firstname'][$key];
                $user->lastname = $validatedData['lastname'][$key] ?? null;
                $user->email = $validatedData['email'][$key];
                $user->password = bcrypt($validatedData['password'][$key]);
                $user->about = $validatedData['about'];
                $user->user_type = $validatedData['user_type'];
                $user->status = $validatedData['status'];

                // Handle image upload
                if ($request->hasFile('image') && $request->file('image')[$key]->isValid()) {
                    $user->image = $request->file('image')[$key]->store('users', 'public');
                }

                $user->save();
            }

            return redirect()->route('user.show')->with('success', 'User details saved successfully'); 
        } catch (\Exception $e) {
            Log::error('Error saving user: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Failed to save the user details.');
        }
    }



         function edit(User $user, $id)
        {

            $user = User::find($id);
            return view('setting.user.edit_user', compact('user'));
        }

  
        public function update(UpdateUserRequest $request, $id)
        {
            try {
                Log::info('User ID: ' . $id . ' - Starting update process.');
            
                // Find the user by ID
                $user = User::find($id);
            
                if (!$user) {
                    Log::error('User not found: ID ' . $id);
                    return redirect()->back()->with('error', 'User not found.');
                }
            
                // Validate and get validated data
                $validatedData = $request->validated();
                Log::info('Validated Data: ', $validatedData);
            
                $user->firstname = $validatedData['firstname'];
                $user->lastname = $validatedData['lastname'];
                $user->email = $validatedData['email'];
                if (!empty($validatedData['password'])) {
                    $user->password = bcrypt($validatedData['password']); 
                }
                $user->about = $validatedData['about'];
                $user->user_type = $validatedData['user_type'];
                $user->status = $validatedData['status'];
            
                // Handle optional image upload
                if ($request->hasFile('image')) {
                    $image = $request->file('image');
                    $imageName = time() . '.' . $image->getClientOriginalExtension();
                    $image->storeAs('public', $imageName);
                    $user->image = $imageName;
                }
            
                $user->save();
                Log::info('User ID: ' . $id . ' - Update successful.');      
                
                return redirect()->route('user.show', ['id' => $id])->with('success', 'User updated successfully.');      
            } catch (\Exception $e) {
                Log::error('Error updating user: ' . $e->getMessage());
                return redirect()->back()->with('error', 'Failed to update user.');
            }
        }

        

        



    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('user.show')->with('success', 'User deleted successfully.');
    }


    public function showuser(Employee $user)
    {
        // Pass the user details to the view
        return view('setting.userd', compact('user'));
    }

}
