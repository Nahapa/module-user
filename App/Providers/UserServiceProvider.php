<?php

namespace Modules\User\App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{

    public function boot()
    {

        Schema::defaultStringLength(191);

        \Validator::extend('is_admin', function ($attribute, $value, $parameters, $validator) {
            $user = User::whereEmail($value)->first();
            return $user && $user->containsType(UserAdmin::class);
        });

        \Validator::extend('is_user_tenant', function ($attribute, $value, $parameters, $validator) {
            $user = User::whereEmail($value)->first();
            return $user && $user->containsType(UserTenant::class);
        });

        \Tenant::bluePrintMacros();

        $this->loadMigrationsFrom(__DIR__.'/../../Migrations');
        $this->loadViewsFrom(__DIR__.'/../../Resources/Views', 'User');
        $this->loadTranslationsFrom(__DIR__.'/../../Lang', 'User');

        Route::namespace('Modules\User\App\Http\Controllers')
            ->group(__DIR__.'/../../Routes/web.php');

        $this->publishes([
            __DIR__.'/../../Migrations' => database_path('migrations'),
        ], 'migrations');

        $this->publishes([
            __DIR__.'/../../Resources' => resource_path(),
        ], 'resources');

        $this->publishes([
            __DIR__.'/../../Lang' => resource_path('lang/vendor/User'),
        ], 'lang');

        // $this->publishes([
        //     __DIR__.'/../../Config/sections.php' => config_path('sections.php'),
        //     __DIR__.'/../../Config/auth.php' => config_path('auth.php'),
        // ], 'config');


    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../../config/sections.php', 'sections');
        $this->mergeConfigFrom(__DIR__.'/../../config/auth.php', 'auth');
    }

}
