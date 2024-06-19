<?php

namespace App\Providers;

use App\Models\Group;
use App\Models\Permission;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot() :void
    {
        foreach (Permission::all() as $permission) {
            Gate::define($permission->name , function ($user) use ($permission) {
                return $user->has_permission($permission);
            });
        }
//        foreach (Group::all() as $group) {
//            Gate::define($group->name , function ($user) use ($group) {
//                return $user->has_groups($group);
//            });
//        }
    }
}
