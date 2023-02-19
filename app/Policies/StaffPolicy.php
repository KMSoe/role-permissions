<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\RoleUser;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class StaffPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function viewAny(User $user)
    {
        return $this->allowOnlyAdmin($user);
    }

    public function view(User $user, Staff $staff)
    {
        return $this->allowOnlyAdmin($user) || $this->allowSelf($user, $staff);
    }

    public function viewByDepartment(User $user)
    {
        return $this->allowAdminAndManager($user);
    }

    public function create(User $user)
    {
        return $this->allowAdminAndManager($user);
    }

    public function update(User $user, Staff $staff)
    {
        return $this->allowOnlyAdmin($user) || $this->allowManager($user, $staff) || $this->allowSelf($user, $staff);
    }

    public function delete(User $user, Staff $staff)
    {
        return $this->allowOnlyAdmin($user) || $this->allowManager($user, $staff);
    }

    private function allowOnlyAdmin(User $user)
    {
        $roleIds = RoleUser::where('user_id', $user->id)
            ->pluck('role_id')
            ->toArray();

        $roles = Role::whereIn('id', $roleIds)->get();

        foreach ($roles as $role) {
            if ($role->name == 'super-admin') {
                return true;
            }
        }

        return false;
    }

    private function allowAdminAndManager(User $user)
    {
        $roleIds = RoleUser::where('user_id', $user->id)
            ->pluck('role_id')
            ->toArray();

        $roles = Role::whereIn('id', $roleIds)->get();

        foreach ($roles as $role) {
            if ($role->name == 'super-admin' || $role->name == 'manager') {
                return true;
            }
        }

        return false;
    }

    private function allowManager(User $user, Staff $staff)
    {
        $user_staff = Staff::find($user->staff_id);

        return $user_staff->department_id == $staff->department_id;
    }

    private function allowSelf(User $user, Staff $staff)
    {
        return $user->staff_id == $staff->id;
    }
}
