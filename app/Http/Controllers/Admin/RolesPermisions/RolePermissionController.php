<?php

namespace App\Http\Controllers\Admin\RolesPermisions;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionController extends Controller
{
    public function index()
    {
        $roles = Role::get();
        $permissions = Permission::get();
        $rolesWithPermissions = Role::with('permissions')->get();
        return view('admin.users.roles_permissions', compact('roles', 'permissions', 'rolesWithPermissions'));
    }


}
