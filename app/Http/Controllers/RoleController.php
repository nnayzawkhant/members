<?php



namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        return view('roles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
        ]);
    
        // Check if the role already exists
        $roleExists = Role::where('name', $request->name)->exists();
    
        if (!$roleExists) {
            // Create the role
            $role = Role::create(['name' => $request->name]);
    
            // Check if permissions were provided
            if ($request->permissions) {
                $permissions = explode(',', $request->permissions);
    
                // Loop through each provided permission
                foreach ($permissions as $permissionName) {
                    // Trim whitespace from permission name
                    $permissionName = trim($permissionName);
    
                    // Check if the permission already exists
                    $permissionExists = Permission::where('name', $permissionName)->exists();
    
                    if (!$permissionExists) {
                        // Create the permission only if it doesn't exist
                        Permission::create(['name' => $permissionName]);
                    }
    
                    // Assign the permission to the role
                    $permission = Permission::where('name', $permissionName)->first();
                    $role->givePermissionTo($permission);
                }
            }
        }
    
        return redirect()->route('roles.index')->with('success', 'Role created successfully.');
    }
    


    public function show(Role $role)
    {
        return view('roles.show', compact('role'));
    }


    public function edit(Role $role)
    {
        $permissions = Permission::all();
        return view('roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
        ]);

        $role->update(['name' => $request->name]);

        if ($request->permissions) {
            $permissions = Permission::whereIn('id', $request->permissions)->pluck('name')->toArray();
            $role->syncPermissions($permissions);
        }

        return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Role deleted successfully.');
    }
}
