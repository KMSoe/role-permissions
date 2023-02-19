<?php

namespace App\Repositories;

use App\Helpers\CoreHelper;
use App\Models\Department;
use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermission;
use App\Models\RoleUser;
use App\Models\Staff;
use App\Models\User;
use Carbon\Carbon;

class StaffRepository
{
    public function getByDepartment($department_id)
    {
        $staffs = Staff::with(['department'])->where('department_id', $department_id)
            ->get();

        foreach ($staffs as $staff) {
            // $rolesIds = RoleUser::where('user_id', $staff->user->id)
            //     ->pluck('role_id')
            //     ->toArray();

            // $roles = Role::with(['permissions'])->whereIn('id', $rolesIds)
            //     ->get();

            $rolesIds = RoleUser::where('user_id', $staff->user->id)
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
            // $rolesIds = RoleUser::where('user_id', $staff->user->id)
            //     ->pluck('role_id')
            //     ->toArray();

            // $roles = Role::with(['permissions'])->whereIn('id', $rolesIds)
            //     ->get();

            $rolesIds = RoleUser::where('user_id', $staff->user->id)
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

            $staff->roles = $roles;
        }

        return $staffs;
    }

    public function show($id)
    {
        $staff = Staff::with(['department'])->findOrFail($id);

        $rolesIds = RoleUser::where('user_id', $staff->user->id)
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

        $staff->roles = $roles;

        return $staff;
    }

    public function store($data)
    {
        $now = Carbon::now();

        $code_prefix = Department::find($data->department_id)->name;

        $staff = new Staff();
        $staff->code = CoreHelper::generateRandomString($code_prefix, 6);
        $staff->name = $data->name;
        $staff->email = $data->email;
        $staff->mobile = $data->mobile;
        $staff->join_date = $now->format('Y-m-d');
        $staff->department_id = $data->department_id;
        $staff->position = $data->position;
        $staff->age = $data->age;
        $staff->gender = $data->gender;
        $staff->created_by = $data->created_by;
        $staff->save();

        \App\Models\User::factory()->create([
            'name' => $data->name,
            'email' => $data->email,
            'staff_id' => $staff->id,
            'created_by' => $data->created_by
        ]);

        return $staff;
    }

    public function update($id, $data)
    {
        $now = Carbon::now();
        $code_prefix = Department::find($data->department_id)->name;

        $staff = Staff::find($id);
        $staff->code = CoreHelper::generateRandomString($code_prefix, 6);
        $staff->name = $data->name;
        $staff->email = $data->email;
        $staff->mobile = $data->phone;
        $staff->join_date = $now->format('Y-m-d');
        $staff->department_id = $data->department_id;
        $staff->position = $data->position;
        $staff->age = $data->age;
        $staff->gender = $data->gender;
        $staff->updated_by = $data->updated_by;
        $staff->save();

        \App\Models\User::factory()->where('staff_id', $staff->id)->update([
            'name' => $data->name,
            'email' => $data->email,
            'staff_id' => $staff->id,
            'updated_by' => $data->updated_by
        ]);

        return $staff;
    }

    public function destroy($id)
    {
        $staff = Staff::findOrFail($id);
        $staff->delete();

        return true;
    }
}
