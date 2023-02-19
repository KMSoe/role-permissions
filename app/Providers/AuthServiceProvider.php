<?php

namespace App\Providers;

use App\Models\Permission;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\User;
use App\Policies\PermissionPolicy;
use App\Policies\RolePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Role::class => RolePolicy::class,
        Permission::class => PermissionPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Gate::define('manage_roles', function (User $user) {
        //     $roleIds = RoleUser::where('user_id', $user->id)
        //         ->pluck('role_id')
        //         ->toArray();

        //     $roles = Role::whereIn('id', $roleIds)->get();

        //     foreach ($roles as $role) {
        //         if ($role->name == 'super-admin') {
        //             return true;
        //         }
        //     }

        //     return false;
        // });
    }
}
