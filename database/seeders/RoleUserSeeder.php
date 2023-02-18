<?php

namespace Database\Seeders;

use App\Helpers\CoreHelper;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\Staff;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // create roles
        $role1 = Role::create(['name' => 'standard', 'label' => Str::slug('standard')]);
        $role2 = Role::create(['name' => 'manager', 'label' => Str::slug('manager')]);
        $role3 = Role::create(['name' => 'super-admin', 'label' => Str::slug('super-admin')]);

        $now = Carbon::now();

        // create demo users
        // Super Admin
        $admin_staff = Staff::create([
            'code' => CoreHelper::generateRandomString('IT', 6),
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'mobile' => '09986507933',
            'join_date' => $now->format('Y-m-d'),
            'department_id' => 1,
            'position' => 'Admin',
            'age' => 23,
            'gender' => 'Male'
        ]);
        $super_admin = \App\Models\User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'staff_id' => $admin_staff->id
        ]);

        RoleUser::create([
            'role_id' => $role3->id,
            'user_id' => $super_admin->id
        ]);

        // Manager User
        $manager_staff = Staff::create([
            'code' => CoreHelper::generateRandomString('IT', 6),
            'name' => 'Manager',
            'email' => 'manager@example.com',
            'mobile' => '09770109404',
            'join_date' => $now->format('Y-m-d'),
            'department_id' => 1,
            'position' => 'Manager',
            'age' => 23,
            'gender' => 'Male',
            'created_by' => $super_admin->id
        ]);

        $manager_user = \App\Models\User::factory()->create([
            'name' => 'Manager',
            'email' => 'manager@example.com',
            'staff_id' => $manager_staff->id,
            'created_by' => $super_admin->id
        ]);

        RoleUser::create([
            'role_id' => $role2->id,
            'user_id' => $manager_user->id
        ]);

        // Standard User
        $standard_staff = Staff::create([
            'code' => CoreHelper::generateRandomString('IT', 6),
            'name' => 'Standard User',
            'email' => 'standard@example.com',
            'mobile' => '09956623925',
            'join_date' => $now->format('Y-m-d'),
            'department_id' => 1,
            'position' => 'standard staff',
            'age' => 23,
            'gender' => 'Female',
            'created_by' => $super_admin->id
        ]);

        $standard_user = \App\Models\User::factory()->create([
            'name' => 'Standard User',
            'email' => 'standard@example.com',
            'staff_id' => $standard_staff->id,
            'created_by' => $manager_user->id
        ]);

        RoleUser::create([
            'role_id' => $role1->id,
            'user_id' => $standard_user->id
        ]);
    }
}
