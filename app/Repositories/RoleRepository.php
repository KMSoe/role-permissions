<?php

namespace App\Repositories;

use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermission;
use App\Models\RoleUser;
use App\Models\Staff;
use App\Models\User;

class RoleRepository
{
    public function getByUser($user_id)
    {
        $rolesIds = RoleUser::where('user_id', $user_id)
            ->pluck('role_id')
            ->toArray();

        $roles = Role::whereIn('id', $rolesIds)
            ->get();

        foreach ($roles as $role) {
            $permissionIds = RolePermission::where('role_id', $role->id)->pluck('permission_id')
                ->toArray();

            $role->permissions = Permission::whereIn('id', $permissionIds)
                ->get();
        }

        return $roles;
    }
}
