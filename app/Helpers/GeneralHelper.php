<?php

namespace App\Helpers;

use App\Constant\AppConstant;

class GeneralHelper
{
    public static function generateRandomOtp(int $length)
    {
        $characters = AppConstant::VALID_OTP_CHARACTERS;
        $charactersLength = strlen($characters);
        $otp = '';
        for ($i = 0; $i < $length; $i++) {
            $otp .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $otp;
    }

    public static function addMinuteWithDatetime($datetime, $addMinutes)
    {
        $selectedDatetime = date_create($datetime);
        date_modify($selectedDatetime, "+$addMinutes minutes");
        return date_format($selectedDatetime, "Y-m-d H:i:s");
    }
}
