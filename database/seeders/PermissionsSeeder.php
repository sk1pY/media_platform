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
        Permission::create(['name' => 'view_content']);
        Permission::create(['name' => 'create_posts']);
        Permission::create(['name' => 'delete_posts']);
        Permission::create(['name' => 'manage_users']);
        Permission::create(['name' => 'moderate_comments']);

        $userRole = Role::where(['name' => 'user'])->first();
        $userRole->givePermissionTo('create_posts');

        $adminRole = Role::where(['name' => 'admin'])->first();
        $adminRole->givePermissionTo(Permission::all());
    }
}
