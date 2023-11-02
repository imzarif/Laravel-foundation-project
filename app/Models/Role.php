<?php

namespace App\Models;

use App\Constant\AppConstant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Role extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    public function getIsSuperAdminAttribute()
    {
        return $this->code ==  AppConstant::ROLE_CODE_SUPER_ADMIN;
    }

    public function getIsGMAttribute()
    {
        return $this->code == AppConstant::ROLE_CODE_GM;
    }

    public function getIsPMAttribute()
    {
        return $this->code == AppConstant::ROLE_CODE_PM;
    }

    public function getIsCPAttribute()
    {
        return $this->code == AppConstant::ROLE_CODE_CP;
    }

    public function getIsSPOCAttribute()
    {
        return $this->code == AppConstant::ROLE_CODE_SPOC;
    }
    /**
     * Get role_id by role code
     */
    public static function getId(string $roleCode)
    {
        $role = self::where('code', $roleCode)->first();
        if (!empty($role->id)) {
            return $role->id;
        }
        return null;
    }

    /**
     * Check accessbilities
     */
    public function hasAccess(int $roleId)
    {
         $accessableRoleIds = self::getAccessableRoleIds(AppConstant::getAccessableRoleCodes($this->code));
         return in_array($roleId, $accessableRoleIds);
    }
    /**
     * Get role_id by role code
     */
    public static function getAccessableRoleIds(array $roleCode)
    {
        $role = self::select('id')->whereIn('code', $roleCode)->pluck('id')->toArray();
        if (count($role)) {
            return $role;
        }
        return [];
    }

    public static function verifyLogViewPermission(string $roleCode) : bool {
             return $roleCode === AppConstant::ROLE_CODE_OPERATION;
    }
}
