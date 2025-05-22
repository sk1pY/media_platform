<?php

namespace App\Http\Controllers\admin;

use     App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('roles')->paginate(10);
        $roles = Role::get();
        return view('admin.users.users', compact('users','roles'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }
    public function updateUserStatus(Request $request, User $user)
    {
        $status = $request->input('status');
        $user->update(['status' => $status]);

        if($status == 0){
            $user->posts()->update(['status'=> 0]);
        }
        return response()->json(['success' => 'User status updated successfully.','status' => $status]);
    }

    public function userRoleUpdate(Request $request, User $user)
    {
        $role = $request->input('role');
        $user->syncRoles($role);
        return response()->json(['success' => 'User role updated successfully.','role' => $role]);

    }

    public function rolePermissionUpdate(Request $request, Role $role)
    {
        $permission = Permission::find($request->input('permissionId'));
        $role->hasPermissionTo($permission) ?
            $role->revokePermissionTo($permission) :
            $role->givePermissionTo($permission);
        return response()->json();

    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index');
    }
}
