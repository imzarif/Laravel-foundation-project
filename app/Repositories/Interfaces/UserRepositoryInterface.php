<?php

namespace App\Repositories\Interfaces;

interface UserRepositoryInterface
{
    public function getUserDetails(string $email, string $roleCode = "cp");
    public function validateUserExistance(string $email);
    public function otpSaveHistory(string $email, string $otp, int $otpSendNo, string $status, string $uuid);
    public function validateUserSession(string $uuid);
    public function getUserLastSendOtp(string $email, string $uuid);
    public function verifyOtp(string $email, string $otp, string $uuid);
    public function saveAccountLoginHistory(string $email, string $uuid, string $status);
    public function totalFailedLoginAttemptOneSession(string $uuid);
    public function accountBlock(int $id, int $status, $unlockedTime);
    public function updateOtpStatus(int $id, string $status);
    public function userDetails(string $email, int $status);
    public function accountUnlock(int $id, int $status);
    public function exportUserList();
}
