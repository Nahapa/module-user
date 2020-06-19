<?php
declare(strict_types=1);

namespace Modules\User\App\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

/**
 * @property User $user
 */
class UserAdmin extends Model
{
    use HasRoles;

    protected $guard_name = 'admin_web';

    /////////
    // ACL //
    /////////

    public function getHasPermission($permission)
    {
        return $this->hasPermissionTo($permission);
    }

    ////////////
    // TENANT //
    ////////////

    public static function createUserAndTenant(array $attributes)
    {
        $admin = self::createUser($attributes);
        $userTenant = UserTenant::create([]);
        $user = $admin->user;
        $userTenant->users()->sync($user->id);
        return ['admin' => $admin, 'user_tenant' => $userTenant];
    }

    public static function createUser(array $attributes): Admin
    {
        $admin = self::create([]);
        $admin->users()->create($attributes['user']);
        return $admin;
    }

    public function getUserAttribute()
    {
        return $this->users->first();
    }

    public function users()
    {
        return $this->morphToMany(User::class, 'userable');
    }

}
