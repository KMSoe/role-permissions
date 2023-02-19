<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\RoleUser;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PermissionPolicy
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
        return true;
    }

    public function view(User $user)
    {
        return true;
    }

    public function permissionList(User $user)
    {
        return $this->allowOnlyAdmin($user);
    }

    public function store(User $user)
    {
        return $this->allowOnlyAdmin($user);
    }

    public function update(User $user)
    {
        return $this->allowOnlyAdmin($user);
    }

    public function delete(User $user)
    {
        return $this->allowOnlyAdmin($user);
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
}
