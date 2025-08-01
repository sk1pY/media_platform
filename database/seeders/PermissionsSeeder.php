<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'admin_panel']);
        Permission::create(['name' => 'create_posts']);
        Permission::create(['name' => 'delete_posts']);
        Permission::create(['name' => 'update_posts']);
        Permission::create(['name' => 'create_comments']);
        Permission::create(['name' => 'like_posts']);
        Permission::create(['name' => 'hidden_posts']);
        Permission::create(['name' => 'complain_posts']);
        Permission::create(['name' => 'bookmark_posts']);
        Permission::create(['name' => 'subscribe_users']);

        $userRole = Role::where(['name' => 'user'])->first();
        $userRole->givePermissionTo('create_posts','delete_posts','update_posts','create_comments','like_posts','hidden_posts','complain_posts','subscribe_users','bookmark_posts');

        $adminRole = Role::where(['name' => 'admin'])->first();
        $adminRole->givePermissionTo(Permission::all());

        $guestRole = Role::where(['name' => 'guest'])->first();
        $guestRole->givePermissionTo();

        $permissionsManager = Permission::where('name','!=','admin_panel')->get();
        $managerRole = Role::where(['name' => 'manager'])->first();
        $managerRole->givePermissionTo($permissionsManager);

        $userBlocked = Role::where(['name' => 'user_blocked'])->first();
        $userBlocked->givePermissionTo('delete_posts','update_posts','subscribe_users','bookmark_posts');

    }
}
