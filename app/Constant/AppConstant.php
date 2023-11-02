<?php

namespace App\Constant;

class AppConstant
{
    //Profile Status
    const PROFILE_PENDING = 0;
    const PROFILE_APPROVED = 1;
    const PROFILE_REJECTED = 2;

    public static function getProfileStatus()
    {
        return [
            self::PROFILE_PENDING => 'Pending',
            self::PROFILE_APPROVED => 'Approved',
            self::PROFILE_REJECTED => 'Rejected',
        ];
    }

    public static function getProfileStatusBgClass()
    {
        return [
            self::PROFILE_PENDING => 'bg-warning',
            self::PROFILE_APPROVED => 'bg-success',
            self::PROFILE_REJECTED => 'bg-danger',
        ];
    }

    //Partner types
    const PARTNER_TYPE_LOCAL = 'local';
    const PARTNER_TYPE_FOERIGN = 'foreign';

    //Common status
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_LOCKED = 2;

    //Submission type
    const CONCEPT_SUBMISSION_TYPE_INTERNAL = 'internal';
    const CONCEPT_SUBMISSION_TYPE_SELF = 'self';

    // Role codes
    const ROLE_CODE_SUPER_ADMIN = 'admin';
    const ROLE_CODE_PM = 'pm';
    const ROLE_CODE_GM = 'gm';
    const ROLE_CODE_CP = 'cp';
    const ROLE_CODE_SPOC = 'spoc';
    const ROLE_CODE_OPERATION = 'operation';
    const ROLE_CODE_OSS = 'oss';
    const ROLE_CODE_VENDOR = 'vendor';
    const ROLE_ADDITIONAL_ACCESS = [
        self::ROLE_CODE_SUPER_ADMIN => [
            self::ROLE_CODE_GM,
            self::ROLE_CODE_PM,
            self::ROLE_CODE_SPOC,
            self::ROLE_CODE_CP,
            self::ROLE_CODE_OPERATION,
        ],
        self::ROLE_CODE_GM => [
            self::ROLE_CODE_PM,
            self::ROLE_CODE_SPOC,
            self::ROLE_CODE_CP,
        ],
        self::ROLE_CODE_PM => [
            self::ROLE_CODE_SPOC,
            self::ROLE_CODE_CP,
        ],
        self::ROLE_CODE_SPOC => [
            self::ROLE_CODE_CP,
        ],
    ];

    // Demo profile informations
    const NOT_APPLICABLE = 'Not Applicable';
    const COMPANY_ADDRESS = 'Robi';
    const COMPANY_OWNER_NAME = self::NOT_APPLICABLE;
    const COMPANY_OWNER_PHONE = self::NOT_APPLICABLE;
    const COMPANY_OWNER_EMAIL = self::NOT_APPLICABLE;
    const COMPANY_BANK_ACCOUNT_DETAILS = self::NOT_APPLICABLE;

    public static function getAccessableRoleCodes(string $roleCode)
    {
        $accessableRoles = [];
        if (isset(self::ROLE_ADDITIONAL_ACCESS[$roleCode])) {
            $accessableRoles = self::ROLE_ADDITIONAL_ACCESS[$roleCode];
        }
        $accessableRoles[] = $roleCode;
        return $accessableRoles;
    }

    // Task Actual Status
    const TASK_ACTUAL_STATUS_PENDING = 0;
    const TASK_ACTUAL_STATUS_COMPLETE = 1;
    const TASK_ACTUAL_STATUS_HALTED = 2;
    const TASK_ACTUAL_STATUS_DELAYED = 3;
    const TASK_ACTUAL_STATUS_WIP = 4;
    const TASK_ACTUAL_STATUS_NOTFEASIBLE = 5;
    const TASK_ACTUAL_STATUS_SCRAPPED = 6;

    public static function getTaskActualStatus()
    {
        return [
            self::TASK_ACTUAL_STATUS_COMPLETE => 'Complete',
            self::TASK_ACTUAL_STATUS_PENDING => 'Pending',
            self::TASK_ACTUAL_STATUS_HALTED => 'Halted',
            self::TASK_ACTUAL_STATUS_DELAYED => 'Delayed',
            self::TASK_ACTUAL_STATUS_WIP => 'WIP',
            self::TASK_ACTUAL_STATUS_NOTFEASIBLE => 'Not Feasible',
            self::TASK_ACTUAL_STATUS_SCRAPPED => 'Scrapped',
        ];
    }

    public static function getConceptOverallStatus()
    {
        return self::getTaskActualStatus();
    }

    const MAX_NO_OF_SENDING_OTP_LIMIT = 3;
    const OTP_EXPIRE_TIME_IN_MINUTES = 5;
    const ACCOUNT_BLOCK_FOR_FAILED_ATTEMPT = 3;
    const ACCOUNT_BLOCK_DURATION_IN_MINUTE = 15;
    const PARTNERS_LOGIN_VERIFICATION_SESSION_DURATION_IN_MINUTE = 15;
    const OTP_LENGTH = 6;
    const VALID_OTP_CHARACTERS = '0123456789';
    const TEST_OTP = '000000';

    // OTP status
    const OTP_STATUS_USABLE = 'usable';
    const OTP_STATUS_USED = 'used';
    const OTP_STATUS_EXPIRED = 'expired';
    const OTP_STATUS_INVALIDATE = 'invalidate';

    public static function getOtpStatus()
    {
        return [self::OTP_STATUS_USABLE, self::OTP_STATUS_USED, self::OTP_STATUS_EXPIRED, self::OTP_STATUS_INVALIDATE];
    }

    // partner login attempt status
    const LOGIN_ATTEMPT_STATUS_SUCCESS = 'success';
    const LOGIN_ATTEMPT_STATUS_FAILED = 'failed';

    public static function getLoginAttemptStatus()
    {
        return [self::LOGIN_ATTEMPT_STATUS_SUCCESS, self::LOGIN_ATTEMPT_STATUS_FAILED];
    }

    public static function getConceptOverallStatusBgClass()
    {
        return [
            self::TASK_ACTUAL_STATUS_PENDING => 'bg-warning',
            self::TASK_ACTUAL_STATUS_COMPLETE => 'bg-success',
            self::TASK_ACTUAL_STATUS_WIP => 'bg-primary',
            self::TASK_ACTUAL_STATUS_HALTED => 'bg-danger',
            self::TASK_ACTUAL_STATUS_DELAYED => 'bg-info',
            self::TASK_ACTUAL_STATUS_NOTFEASIBLE => 'bg-secondary',
            self::TASK_ACTUAL_STATUS_SCRAPPED => 'bg-dark',
        ];
    }

    public static function getConceptStatusColor()
    {
        return [
            self::TASK_ACTUAL_STATUS_COMPLETE => "#34a853",
            self::TASK_ACTUAL_STATUS_PENDING => "#fabd03",
            self::TASK_ACTUAL_STATUS_HALTED => "#e79b97",
            self::TASK_ACTUAL_STATUS_DELAYED => "#a83297",
            self::TASK_ACTUAL_STATUS_WIP => "#4286f5",
            // self::TASK_ACTUAL_STATUS_NOTFEASIBLE => 'Not Feasible',
            // self::TASK_ACTUAL_STATUS_SCRAPPED => 'Scrapped',
        ];
    }

    # invoice status
    const INVOICE_PENDING = 'pending';
    const INVOICE_INPROGRESS = 'inprogress';
    const INVOICE_REVERTED = 'reverted';
    const INVOICE_REJECTED = 'rejected';
    const INVOICE_APPROVED = 'approved';

    public static function getInvoiceStatusBgClass()
    {
        return array(
            self::INVOICE_PENDING => "bg-secondary",
            self::INVOICE_INPROGRESS => "bg-info",
            self::INVOICE_REVERTED => "bg-warning",
            self::INVOICE_REJECTED => "bg-danger",
            self::INVOICE_APPROVED => "bg-success",
        );
    }

    public static function getInvoiceStatus()
    {
        return [self::INVOICE_PENDING, self::INVOICE_INPROGRESS, self::INVOICE_REVERTED, self::INVOICE_REJECTED, self::INVOICE_APPROVED];

    }

    const PAGINATION = 50;


}
