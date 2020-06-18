<?php
declare(strict_types=1);

namespace Modules\User\App\Models;

use App\Support\Cropper;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;

/**
 * @property Admin $admin
 * @property UserTenant $userTenant
 */
class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $guard_name = 'admin_web';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'email', 'password', 'last_login_at', 'last_login_ip'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    ////////////////
    // ATRIBUTTOS //
    ////////////////

    public function getProfileFileAttribute($value)
    {
        if (!empty($value)) {
            return Storage::url(Cropper::thumb($value, 500, 500));
        }

        return asset('assets\admin\images\avatar.jpg');
    }

    public function fill(array $attributes)
    {
        !isset($attributes['password']) ?: $attributes['password'] = bcrypt($attributes['password']);
        return parent::fill($attributes);
    }

    ////////////
    // TENANT //
    ////////////

    public static function createAdmin(array $attributes)
    {
        $user = self::create($attributes);
        $admin = Admin::create([]);
        $user->userable()->associate($admin);
        return $user;
    }

    public static function createUserTenant(array $attributes)
    {
        $user = self::create($attributes);
        $admin = UserTenant::create([]);
        $user->userable()->associate($admin);
        return $user;
    }

    public function containsType($typeClass): bool
    {
        return self
                ::query()
                ->join('userables', 'userables.user_id', '=', 'users.id')
                ->where('userable_type', $typeClass)
                ->where('users.id', $this->id)
                ->count() == 1;
    }

    public function getAdminAttribute()
    {
        return $this->admins->first();
    }

    public function admins()
    {
        return $this->morphedByMany(Admin::class, 'userable');
    }

    public function getUserTenantAttribute()
    {
        return $this->userTenants->first();
    }

    public function userTenants()
    {
        return $this->morphedByMany(UserTenant::class, 'userable');
    }

}
