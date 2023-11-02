<?php

namespace App\Models;

use App\Constant\AppConstant;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use OwenIt\Auditing\Contracts\Auditable;

class User extends Authenticatable implements MustVerifyEmail, Auditable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use \OwenIt\Auditing\Auditable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'role_id',
        'ad_login',
        'email_verified_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'remember_token',
    ];

    public function role()
    {
        return $this->hasOne(Role::class, 'id', 'role_id');
    }

    protected function setTeamPermissionsAttribute($value = [])
    {
        if (!empty($value)) {
            $value = implode(',', $value);
        }
        $this->attributes['team_permissions'] = $value;
    }

    protected function getTeamPermissionsAttribute($value)
    {
        return !empty($value) ? explode(",", $value) : [];
    }

    public function partnerProfile()
    {
        return $this->belongsTo(PartnerProfile::class, 'id', 'user_id');
    }

    public static function updateSuperAdminTeamPermissions(array $teamIds)
    {
        return self::where(
            'role_id',
            Role::getId(AppConstant::ROLE_CODE_SUPER_ADMIN)
        )->update(['team_permissions' => implode(',', $teamIds)]);
    }
}
