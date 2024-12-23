<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionController extends Controller
{
    public function index(){
        $roles = Role::all();
        $permissions = Permission::all();
        $rolesWithPermissions = Role::with('permissions')->get();
        return view('admin.users.roles_and_permissions',compact('roles','permissions','rolesWithPermissions'));
    }

    public function role_for_user(Request $request, User $user){

        $role = Role::where('name',$request->input('role'))->first();


        $user ->syncRoles($role);

        return redirect()->route('admin.users.index');
    }


    public function roles_store(){
        $validated = request()->validate([
            'name' => 'required|string|unique:roles,name'
        ]);

        Role::create($validated);
        return redirect()->route('admin.roles_and_permissions.index');

    }

    public function roles_destroy(Role $role){
        $role->delete();
        return redirect()->route('admin.roles_and_permissions.index');
    }
    public function permissions_store(){
        $validated = request()->validate([
            'name' => 'required|string|unique:permissions,name'
        ]);
        Permission::create($validated);
        return redirect()->route('admin.roles_and_permissions.index');

    }

    public function permissions_destroy(Permission $permission){
            $permission->delete();
            return redirect()->route('admin.roles_and_permissions.index');
    }

    public function roles_and_permissions_update(Request $request,Role $role){

        if(! $request->input('permissions')){
                $role->permissions()->detach();
                return redirect()->route('admin.roles_and_permissions.index')->with('success', 'Deleted');

        }

        $permissionName = Permission::whereIn('id', $request->input('permissions'))->pluck('name')->toArray();
        $role->syncPermissions($permissionName);

        return redirect()->route('admin.roles_and_permissions.index')->with('success', 'Role permission added successfully');

    }




}
