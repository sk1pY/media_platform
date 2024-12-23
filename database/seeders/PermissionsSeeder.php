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
        Permission::create(['name' => 'view content']);
        Permission::create(['name' => 'create posts']);
        Permission::create(['name' => 'delete posts']);
        Permission::create(['name' => 'manage users']);
        Permission::create(['name' => 'moderate comments']);

        $userRole = Role::where(['name' => 'user'])->first();
        $userRole->givePermissionTo('view content');

        $adminRole = Role::where(['name' => 'admin'])->first();
        $adminRole->givePermissionTo(Permission::all());
    }
}
