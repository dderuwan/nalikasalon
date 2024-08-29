<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Employee;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; 
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function showUsers()
    {
        $employees = Employee::all();
        $roles = Role::all();
        $employeeRoles = Employee::with('roles')->get()->filter(function ($employee) {
            return $employee->roles->isNotEmpty();
        });
        return view('setting.roles.assign_user_role', compact('employees','roles','employeeRoles'));
    }

    //permissions


    public function addPermission()
    {
        $permissions = Permission::all();
        return view('role-permission.permission.create', compact('permissions'));
    }

    public function storePermission(Request $request)
    {
        $request->validate([
            'name' =>[
                'required',
                'string',
                'unique:permissions,name'
            ]
        ]);

        Permission::create([
            'name'=> $request->name
        ]);

        return redirect('addPermission')->with('ststus','Permission Created Succesfully');
    }

    public function edit($id)
    {
        $permission = Permission::findOrFail($id);
        return view('role-permission.permission..edit', compact('permission'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $permission = Permission::findOrFail($id);
        $permission->name = $request->name;
        $permission->save();

        return redirect()->route('addPermission')
                        ->with('success', 'Permission updated successfully');
    }

    
    public function deletePermission($id)
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();

        return redirect()->route('addPermission')
                        ->with('success', 'Permission deleted successfully');
    }






    //roles
    public function addRole()
    {
        $roles = Role::all();
        return view('role-permission.Roles.create', compact('roles'));
    }



    public function storeRole(Request $request)
    {
        $request->validate([
            'name' =>[
                'required',
                'string',
                'unique:roles,name'
            ]
        ]);

        Role::create([
            'name'=> $request->name
        ]);

        return redirect('addRole')->with('ststus','Role Created Succesfully');
    }

    public function editRole($id)
    {
        $role = Role::findOrFail($id);
        return view('role-permission.Roles.edit', compact('role'));
    }

    public function updateRole(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $role = Role::findOrFail($id);
        $role->name = $request->name;
        $role->save();

        return redirect()->route('addRole')
                        ->with('success', 'Role updated successfully');
    }

    public function deleteRole($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return redirect()->route('addRole')
                        ->with('success', 'Role deleted successfully');
    }



    public function addPermitionToRole($id) {
        $permissions = Permission::all(); // Get all permissions
        $role = Role::findOrFail($id); // Find the role by ID
        $rolePermissions = $role->permissions->pluck('id')->toArray(); // Get the IDs of permissions assigned to the role
    
        return view('role-permission.Roles.add-permission', [
            'role' => $role,
            'permissions' => $permissions,
            'rolePermissions' => $rolePermissions
        ]);
    }
    


    public function givePermissionToRole(Request $request, $id)
    {
        $request->validate([
            'permissions' => 'required|array'
        ]);

        $role = Role::findOrFail($id);
        $role->permissions()->sync($request->permissions);

        return redirect()->route('addRole')->with('status', 'Permissions updated successfully');
    }

    

    public function assignRole(Request $request)
    {
        
        $request->validate([
            'employee_id' => 'required',
            'role_id' => 'required',
        ]);
        //dd($request);
        $employee = Employee::findOrFail($request->employee_id);
        $role = Role::findOrFail($request->role_id);

        $employee->roles()->attach($role->id);

        return redirect()->back()->with('success', 'Role assigned successfully!');
    }


}
