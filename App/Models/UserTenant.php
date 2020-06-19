<?php
declare(strict_types=1);

namespace Modules\User\App\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Modules\User\App\Tenant\TenantModels;

/**
 * @property User $user
 */
class UserTenant extends Model
{

    protected $guard_name = 'app_web';

    use TenantModels, Uuid, HasRoles;

    ////////////
    // TENANT //
    ////////////

    public static function createUser(array $attributes): UserTenant
    {
        $userTenant = self::create([]);
        $userTenant->users()->create($attributes['user']);
        return $userTenant;
    }

    public function users()
    {
        return $this->morphToMany(User::class, 'userable');
    }
}
