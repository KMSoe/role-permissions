<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // create permissions
        $permissions = [
            'permission list',
            'permission create',
            'permission edit',
            'permission delete',
            'role list',
            'role create',
            'role edit',
            'role delete',
            'staff list',
            'same department staff list',
            'staff create',
            'staff edit',
            'staff delete'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'label' => Str::slug($permission)]);
        }

        // create roles and assign existing permissions
        $standard_role = Role::where('name', 'standard')->first();
        $manager_role = Role::where('name', 'manager')->first();
        $admin_role = Role::where('name', 'super-admin')->first();

        $admin_permissions = Permission::get();
        foreach ($admin_permissions as $permission) {
            RolePermission::create([
                'role_id' => $admin_role->id,
                'permission_id' => $permission->id,
            ]);
        }

        $manager_permissions = Permission::whereIn('name', [
            'permission list', 'role list', 'same department staff list', 'staff create',
            'staff edit',
            'staff delete'
        ])
            ->get();
        foreach ($manager_permissions as $permission) {
            RolePermission::create([
                'role_id' => $manager_role->id,
                'permission_id' => $permission->id,
            ]);
        }

        $standard_permissions = Permission::whereIn('name', ['permission list', 'role list'])
            ->get();
        foreach ($standard_permissions as $permission) {
            RolePermission::create([
                'role_id' => $standard_role->id,
                'permission_id' => $permission->id,
            ]);
        }
    }
}
