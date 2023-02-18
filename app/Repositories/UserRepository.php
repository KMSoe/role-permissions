<?php

namespace App\Repositories;

use App\Models\Role;
use App\Models\RoleUser;
use App\Models\Staff;
use App\Models\User;

class UserRepository
{
    public function get($user_id)
    {
        $user = User::find($user_id);

        $staff = Staff::with(['department'])->find($user->staff_id);

        $rolesIds = RoleUser::where('user_id', $user->id)
            ->pluck('role_id')
            ->toArray();

        $roles = Role::with(['permissions'])->whereIn('id', $rolesIds)
            ->get();

        return [
            'info' => $staff,
            'roles' => $roles
        ];
    }
}
