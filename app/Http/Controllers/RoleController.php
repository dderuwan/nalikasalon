<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Employee;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; 
use Illuminate\Support\Facades\DB;

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


    public function addPermission()
    {
        return view('setting.roles.add_permissions');
    }

    
   
    public function storePermission(Request $request)
    {

        //dd($request);
        try {
            $request->validate([
                'category' => 'required',
                'items.*.name' => 'required|string|max:255',
                'items.*.description' => 'nullable|string',
            ]);

            foreach ($request->items as $itemData) {
                $item = new Permission();
                
                $item->name = $itemData['name'];
                $item->description = $itemData['description'];
                $item->section = $request->category;

                $item->save();
            }

            return redirect()->route('showPermission')->with('success', 'Permission added successfully!');
        } catch (Exception $e) {
            return back()->withError($e->getMessage())->withInput();
        }
    }

    public function showPermission()
    {
        $permissions = Permission::all();
        return view('setting.roles.show_permissions', compact('permissions'));
    }

    
    public function deletePermission($id)
    {
        try {
            $permission = Permission::findOrFail($id);
            $permission->delete();
            return redirect()->route('showPermission')->with('success', 'Permission deleted successfully.');
        } catch (Exception $e) {
            return redirect()->route('showPermission')->withErrors(['error' => 'Failed to delete permission.']);
        }
    }

    public function addRole()
    {
        $permissions = Permission::all()->groupBy('category');
        return view('setting.roles.add_roles', compact('permissions'));
    }



    public function storeRole(Request $request)
    {
        //dd($request);
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'role_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        // Begin a transaction
        DB::beginTransaction();

        try {
            // Create the new role
            $role = Role::create([
                'name' => $request->input('role_name'),
                'description' => $request->input('description'),
            ]);

            // Attach the selected permissions to the role
            if ($request->has('permissions')) {
                $role->permissions()->sync($request->input('permissions'));
            }

            // Commit the transaction
            DB::commit();

            // Redirect or return a success response
            return redirect()->route('showRole')->with('success', 'Role created successfully.');
        } catch (\Exception $e) {
            // Rollback the transaction if an error occurs
            DB::rollback();

            // Redirect or return an error response
            return redirect()->back()->with('error', 'Failed to create role: ' . $e->getMessage());
        }
    }

    public function showRole()
    {
        $roles = Role::with('permissions')->get();
        return view('setting.roles.role_list', compact('roles'));
    }

    public function editRole($id)
    {
        $role = Role::with('permissions')->findOrFail($id);
        return view('setting.roles.role_edit', compact('role'));
    }

    public function updateRole(Request $request, $id)
    {
        $request->validate([
            'role_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'permissions' => 'required|array'
        ]);

        $role = Role::findOrFail($id);
        $role->update([
            'name' => $request->role_name,
            'description' => $request->description,
        ]);

        $role->permissions()->delete();

        foreach ($request->permissions as $permission => $value) {
            $role->permissions()->create([
                'permission' => $permission,
                'can_create' => $value['can_create'] ?? 0,
                'can_read' => $value['can_read'] ?? 0,
                'can_edit' => $value['can_edit'] ?? 0,
                'can_delete' => $value['can_delete'] ?? 0,
            ]);
        }

        return redirect()->route('showRole')->with('success', 'Role updated successfully');
    }

    public function deleteRole($id)
    {
        $role = Role::findOrFail($id);

        // Delete the permissions associated with the role
        $role->permissions()->delete();

        // Delete the role
        $role->delete();

        return redirect()->route('showRole')->with('success', 'Role deleted successfully');
    }
    

    public function assignRole(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employee,id',
            'role_id' => 'required|exists:roles,id',
        ]);

        $employee = Employee::findOrFail($request->employee_id);
        $role = Role::findOrFail($request->role_id);

        $employee->roles()->attach($role->id);

        return redirect()->back()->with('success', 'Role assigned successfully!');
    }


}
