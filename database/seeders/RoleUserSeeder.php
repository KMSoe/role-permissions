<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\RoleUser;
use Illuminate\Database\Seeder;

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
        $role1 = Role::create(['name' => 'standard']);
        $role2 = Role::create(['name' => 'manager']);
        $role3 = Role::create(['name' => 'super-admin']);


        // create demo users
        // Standard User
        $standard_user = \App\Models\User::factory()->create([
            'name' => 'Standard User',
            'email' => 'standard@example.com',
        ]);
        
        RoleUser::create([
            'role_id' => $role1->id,
            'user_id' => $standard_user->id
        ]);

        // Manager User
        $manager_user = \App\Models\User::factory()->create([
            'name' => 'Manager',
            'email' => 'manager@example.com',
        ]);
        
        RoleUser::create([
            'role_id' => $role2->id,
            'user_id' => $manager_user->id
        ]);

        // Super Admin
        $super_admin = \App\Models\User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
        ]);
        
        RoleUser::create([
            'role_id' => $role3->id,
            'user_id' => $super_admin->id
        ]);        
    }
}
