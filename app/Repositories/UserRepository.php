<?php

namespace App\Repositories;

use App\Constant\AppConstant;
use App\Models\OtpHistory;
use App\Models\PartnerLoginHistory;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use DB;


class UserRepository implements UserRepositoryInterface
{
    public function getUserDetails(string $email, string $roleCode = "cp")
    {
        return User::select('users.id', 'roles.code')
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->where('users.status', 1)
            ->where('users.email', $email)
            ->where('roles.status', 1)
            ->first();
    }

    public function validateUserExistance(string $email)
    {
        return User::select('users.id', 'users.unlocked_time', 'roles.code')
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->where('users.email', $email)
            ->first();
    }

    public function otpSaveHistory(string $email, string $otp, int $otpSendNo, string $status, string $uuid)
    {
        $otpHistory = new OtpHistory();
        $otpHistory->email = $email;
        $otpHistory->uuid = $uuid;
        $otpHistory->otp = $otp;
        $otpHistory->otp_send_no = $otpSendNo;
        $otpHistory->status = $status;
        return $otpHistory->save();
    }

    public function validateUserSession(string $uuid)
    {
        return OtpHistory::select('email', 'created_at')
            ->where('otp_histories.uuid', $uuid)
            ->first();
    }

    public function getUserLastSendOtp(string $email, string $uuid)
    {
        return OtpHistory::select('id', 'otp_send_no')
            ->where('email', $email)
            ->where('uuid', $uuid)
            ->orderBy('id', 'desc')
            ->first();
    }

    public function verifyOtp(string $email, string $otp, string $uuid)
    {
        return OtpHistory::select('id', 'status', 'created_at')
            ->where('email', $email)
            ->where('otp', $otp)
            ->where('uuid', $uuid)
            ->orderBy('id', 'desc')
            ->first();
    }

    public function saveAccountLoginHistory(string $email, string $uuid, string $status)
    {
        $loginAttemptHistory = new PartnerLoginHistory();
        $loginAttemptHistory->email = $email;
        $loginAttemptHistory->uuid = $uuid;
        $loginAttemptHistory->status = $status === AppConstant::OTP_STATUS_USED ? "success" : "failed";
        return $loginAttemptHistory->save();
    }

    public function totalFailedLoginAttemptOneSession(string $uuid)
    {
        return PartnerLoginHistory::select(DB::raw('COUNT(*) as total'))
            ->where('status', 'failed')
            ->where('uuid', $uuid)
            ->get();
    }

    public function accountBlock(int $id, int $status, $unlockedTime)
    {
        return User::where('id', $id)
            ->update(['status' => $status, 'unlocked_time' => $unlockedTime]);
    }

    public function updateOtpStatus(int $id, string $status)
    {
        return OtpHistory::where('id', $id)
            ->update(['status' => $status]);
    }

    public function userDetails(string $email, int $status)
    {
        return User::where('email', $email)
            ->where('status', $status)
            ->first();
    }

    public function accountUnlock(int $id, int $status)
    {
        return User::where('id', $id)
            ->update(['status' => $status, 'unlocked_time' => null]);
    }

    public function totalOtpSendOneSession(string $uuid)
    {
        return OtpHistory::select(DB::raw('COUNT(*) as total'))
            ->where('uuid', $uuid)
            ->get();
    }

    public function exportUserList()
    {
        return User::select('users.name','users.email', 'roles.name AS role',
        DB::raw('(CASE WHEN users.status = 1 THEN "Active" ELSE "Inactive" END) AS status'))
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->get();
    }
}
