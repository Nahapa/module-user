<?php

namespace Modules\User\App\Auth;

use App\Models\Admin;
use Illuminate\Auth\EloquentUserProvider;

class AdminProvider extends EloquentUserProvider
{
    use UserProviders;

    public static function userOrNull($user){
        return $user && $user->containsType(Admin::class) ? $user : null;
    }
}
