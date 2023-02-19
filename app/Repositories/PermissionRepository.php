<?php

namespace App\Repositories;

use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermission;
use App\Models\RoleUser;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Support\Str;

class PermissionRepository
{
    public function getByUser($user_id)
    {
        $rolesIds = RoleUser::where('user_id', $user_id)
            ->pluck('role_id')
            ->toArray();


        $permissionIds = RolePermission::whereIn('role_id', $rolesIds)->pluck('permission_id')
            ->toArray();

        $permissions = Permission::whereIn('id', $permissionIds)
            ->get();

        return $permissions;
    }

    public function show($id)
    {
        $item = Permission::find($id);

        return $item;
    }

    public function store($data)
    {
        $item = new Permission();
        $item->name = $data->name;
        $item->label = Str::slug($data->name);
        $item->flag = 0;
        $item->save();

        foreach ($data->assign_roles as $role) {
            RolePermission::create([
                'role_id' => $role,
                'permission_id' => $item->id
            ]);
        }

        return $item;
    }

    public function update($id, $data)
    {
        $item = Permission::findOrFail($id);
        $item->name = $data->name;
        $item->label = Str::slug($data->name);
        $item->flag = 0;
        $item->save();

        return $item;
    }

    public function destroy($id)
    {
        $item = Permission::findOrFail($id);
        $item->delete();

        return true;
    }
}
