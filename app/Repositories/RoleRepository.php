<?php

namespace App\Repositories;

use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermission;
use App\Models\RoleUser;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Support\Str;

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

    public function all()
    {
        $data = Role::all();

        return $data;
    }

    public function show($id)
    {

        $role = Role::where('id', $id)
            ->get();

        $permissionIds = RolePermission::where('role_id', $role->id)->pluck('permission_id')
            ->toArray();

        $role->permissions = Permission::whereIn('id', $permissionIds)
            ->get();

        return $role;
    }

    public function store($data)
    {
        $role = new Role();
        $role->name = $data->name;
        $role->label = Str::slug($data->name);
        $role->flag = 0;
        $role->save();

        return $role;
    }

    public function update($id, $data)
    {
        $role = Role::findOrFail($id);
        $role->name = $data->name;
        $role->label = Str::slug($data->name);
        $role->flag = 0;
        $role->save();

        return $role;
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return true;
    }
}
