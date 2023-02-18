<?php

namespace App\Repositories;

use App\Models\Role;
use App\Models\RoleUser;
use App\Models\Staff;
use App\Models\User;

class StaffRepository
{
    public function getByDepartment($department_id)
    {
        $staffs = Staff::with(['department'])->where('department_id', $department_id)
            ->get();

        foreach ($staffs as $staff) {
            $rolesIds = RoleUser::where('user_id', $staff->user->id)
                ->pluck('role_id')
                ->toArray();

            $roles = Role::with(['permissions'])->whereIn('id', $rolesIds)
                ->get();

            $staff['roles'] = $roles;
        }

        return $staffs;
    }

    public function all()
    {
        $staffIds = User::orderBy('created_at', 'DESC')
            ->pluck('staff_id')
            ->toArray();

        $staffs = Staff::with(['department'])->whereIn('id', $staffIds)
            ->get();

        foreach ($staffs as $staff) {
            $rolesIds = RoleUser::where('user_id', $staff->user->id)
                ->pluck('role_id')
                ->toArray();

            $roles = Role::with(['permissions'])->whereIn('id', $rolesIds)
                ->get();

            $staff->roles = $roles;
        }

        return $staffs;
    }
}
