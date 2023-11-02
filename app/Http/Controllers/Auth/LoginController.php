<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;
use App\Helpers\GeneralHelper;
use App\Constant\AppConstant;
use App\Mail\OtpSendMail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Validator;
use Exception;
use Illuminate\Support\Facades\Auth as LoginAuth;
use App\Jobs\UnlockedUser;

class LoginController extends Controller
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function otpSend(Request $request)
    {
        $request->validate([
            "email" => ["required", "string", "email", "max:255"],
        ]);
        $userDetails = $this->userRepository->validateUserExistance(
            $request->email
        );
        $userId = $userDetails->id ?? 0;
        $userRole = $userDetails->code ?? "";
        $unlockedTime = $userDetails->unlocked_time ?? "";
        $appEnv = config("app.env");
        if (
            $userId &&
            !in_array($userRole, [AppConstant::ROLE_CODE_CP, AppConstant::ROLE_CODE_VENDOR]) &&
            !in_array($appEnv, ["local", "staging"])
        ) {
            return back()->with("error", __("messages.ad_login"));
        } elseif (
            $userId &&
            $unlockedTime &&
            date("Y-m-d H:i:s") <= $unlockedTime
        ) {
            return back()->with("error", __("messages.account_blocked"));
        } elseif (
            $userId &&
            $unlockedTime &&
            date("Y-m-d H:i:s") >= $unlockedTime
        ) {
            # unlock user
            $this->userRepository->accountUnlock(
                $userId,
                AppConstant::STATUS_ACTIVE
            );
        }
        if ($userId && in_array($appEnv, ["local", "staging"])) {
            # static otp set for local development(dev mode)
            $otp = AppConstant::TEST_OTP;
        } else {
            $otp =
                $userId && $appEnv !== "local"
                    ? GeneralHelper::generateRandomOtp(AppConstant::OTP_LENGTH)
                    : "";
        }
        $uuid = Str::uuid();
        $otpStatus = $userId
            ? AppConstant::OTP_STATUS_USABLE
            : AppConstant::OTP_STATUS_INVALIDATE;
        $this->userRepository->otpSaveHistory(
            $request->email,
            $otp,
            1,
            $otpStatus,
            $uuid
        );
        if ($userId) {
            $mailDetail = [
                "app_name" => env("APP_NAME"),
                "otp" => $otp,
            ];
            // Mail::to($request->email)->send(new OtpSendMail($mailDetail));
            Log::info("LoginController:otpSend : Otp sent successfully");
        }
        return redirect()->route("user.otp_verification", ["uuid" => $uuid]);
    }

    public function otpVerification(Request $request, $uuid)
    {
        $userSession = $this->userRepository->validateUserSession($uuid);
        $email = isset($userSession->email) ? $userSession->email : "";
        if ($email) {
            $loginVerificationDurationInMinute =
                AppConstant::PARTNERS_LOGIN_VERIFICATION_SESSION_DURATION_IN_MINUTE;
            $sessionExpireTime = GeneralHelper::addMinuteWithDatetime(
                $userSession->created_at,
                $loginVerificationDurationInMinute
            );
            if ($sessionExpireTime >= date("Y-m-d H:i:s")) {
                $totalOtp = $this->userRepository->totalOtpSendOneSession(
                    $uuid
                );
                return view("auth.otp-verification", [
                    "session_status" => "valid",
                    "no_of_otp_send" => $totalOtp[0]->total,
                    "email" => $email,
                    "uuid" => $uuid,
                ]);
            } else {
                return view("auth.otp-verification", [
                    "session_status" => "expire",
                    "message" => __("messages.session_time_out"),
                ]);
            }
        } else {
            return view("auth.otp-verification", [
                "session_status" => "not_found",
                "message" => __("messages.unauthorized_access"),
            ]);
        }
    }

    public function resendOtp(Request $request)
    {
        try {
            $emailValidator = Validator::make($request->all(), [
                "email" => ["required", "string", "email", "max:255"],
                "uuid" => ["required", "min:36", "max:36"],
            ]);
            if ($emailValidator->fails()) {
                $messages = implode(",", $emailValidator->messages()->all());
                throw new Exception($messages, 6000);
            } else {
                //$userDetails =  $this->userRepository->getUserDetails($request->email, AppConstant::ROLE_CODE_CP);
                $userDetails = $this->userRepository->validateUserExistance(
                    $request->email
                );
                $userId = $userDetails->id ?? 0;
                // if($userId) {
                $userLastSendOtpDetails = $this->userRepository->getUserLastSendOtp(
                    $request->email,
                    $request->uuid
                );
                $noOfOtpSend = !empty($userLastSendOtpDetails->otp_send_no)
                    ? $userLastSendOtpDetails->otp_send_no
                    : 0;
                $otpSendingLimit = AppConstant::MAX_NO_OF_SENDING_OTP_LIMIT;
                if ($noOfOtpSend && $noOfOtpSend < $otpSendingLimit) {
                    $expireOtpStatus = $this->userRepository->updateOtpStatus(
                        $userLastSendOtpDetails->id,
                        AppConstant::OTP_STATUS_INVALIDATE
                    );
                    $otp = $userId
                        ? GeneralHelper::generateRandomOtp(
                            AppConstant::OTP_LENGTH
                        )
                        : "";
                    $otpStatus = $userId
                        ? AppConstant::OTP_STATUS_USABLE
                        : AppConstant::OTP_STATUS_INVALIDATE;
                    $savedStatus = $this->userRepository->otpSaveHistory(
                        $request->email,
                        $otp,
                        ++$noOfOtpSend,
                        $otpStatus,
                        $request->uuid
                    );
                    if ($userId) {
                        $mailDetail = ["app_name" => env("APP_NAME"), "otp" => $otp,];
                        // Mail::to($request->email)->send(new OtpSendMail($mailDetail));
                    }
                    $response = [
                        "success" => true,
                        "no_of_otp_send" => $noOfOtpSend,
                        "messages" => "",
                    ];
                    return response()->json($response);
                } else {
                    Log::info(
                        "LoginController:resendOtp: messages.otp_limit_exceed"
                    );
                    throw new Exception(__("messages.otp_limit_exceed"), 6002);
                }
                //  } else {
                //   throw new Exception(__('messages.email_not_found'), 6001);
                //  }
            }
        } catch (Exception $e) {
            Log::error("LoginController:resendOtp:" . $e->getMessage());
            $errorCode = $e->getCode();
            $errorMessage = $errorCode
                ? $e->getMessage()
                : __("messages.default_error_message");
            $response = [
                "success" => false,
                "messages" => $errorMessage,
                "error_code" => $errorCode,
            ];
            Log::error(
                "LoginController:resendOtp:" .
                    $e->getMessage() .
                    json_encode($response)
            );
            return response()->json($response);
        }
    }

    public function verifyOtp(Request $request)
    {
        try {
            $otpValidator = Validator::make($request->all(), [
                "email" => ["required", "string", "email", "max:255"],
                "otp" => ["required", "string", "min:6", "max:6"],
                "uuid" => ["required", "min:36", "max:36"],
            ]);
            if ($otpValidator->fails()) {
                $messages = implode(",", $otpValidator->messages()->all());
                throw new Exception($messages, 6000);
            } else {
                $userSession = $this->userRepository->validateUserSession(
                    $request->uuid
                );
                $sessionExpireTime = GeneralHelper::addMinuteWithDatetime(
                    $userSession->created_at,
                    AppConstant::PARTNERS_LOGIN_VERIFICATION_SESSION_DURATION_IN_MINUTE
                );
                if ($sessionExpireTime <= date("Y-m-d H:i:s")) {
                    throw new Exception(__("messages.session_time_out"), 6006);
                }
                $getUserDetails = $this->userRepository->getUserDetails(
                    $request->email,
                    ""
                );
                $userId = isset($getUserDetails->id) ? $getUserDetails->id : 0;
                $partnerRole = isset($getUserDetails->code)
                    ? $getUserDetails->code
                    : "";
                $otpDetails = $this->userRepository->verifyOtp(
                    $request->email,
                    $request->otp,
                    $request->uuid
                );
                $otpVerificationStatus = "wrong_otp";
                if (isset($otpDetails->created_at)) {
                    $otpExpireDatetime = GeneralHelper::addMinuteWithDatetime(
                        $otpDetails->created_at,
                        AppConstant::OTP_EXPIRE_TIME_IN_MINUTES
                    );
                    if (
                        $otpDetails->status ===
                            AppConstant::OTP_STATUS_USABLE &&
                        $otpExpireDatetime >= date("Y-m-d H:i:s")
                    ) {
                        $otpVerificationStatus = AppConstant::OTP_STATUS_USED;
                    } else {
                        $otpVerificationStatus =
                            AppConstant::OTP_STATUS_EXPIRED;
                    }
                    # update otp histories table
                    $this->userRepository->updateOtpStatus(
                        $otpDetails->id,
                        $otpVerificationStatus
                    );
                }
                # log write in DB
                $this->userRepository->saveAccountLoginHistory(
                    $request->email,
                    $request->uuid,
                    $otpVerificationStatus
                );
                # check account failed login attempt
                $totalFailedLoginAttempt = $this->userRepository->totalFailedLoginAttemptOneSession(
                    $request->uuid
                );
                $accountBlockStatus =
                    $totalFailedLoginAttempt[0]->total >=
                    AppConstant::ACCOUNT_BLOCK_FOR_FAILED_ATTEMPT
                        ? true
                        : false;
                if ($accountBlockStatus && $userId) {
                    # execute account block query
                    $this->userRepository->accountBlock(
                        $userId,
                        AppConstant::STATUS_LOCKED,
                        GeneralHelper::addMinuteWithDatetime(
                            date("Y-m-d H:i:s"),
                            AppConstant::ACCOUNT_BLOCK_DURATION_IN_MINUTE
                        )
                    );
                    # call the unlocked job
                    $getUserDetails = $this->userRepository->userDetails(
                        $request->email,
                        AppConstant::STATUS_LOCKED
                    );
                    UnlockedUser::dispatch(
                        $getUserDetails,
                        $this->userRepository
                    )->delay(
                        now()->addMinutes(
                            AppConstant::ACCOUNT_BLOCK_DURATION_IN_MINUTE
                        )
                    );
                }
                if ($otpVerificationStatus === AppConstant::OTP_STATUS_USED) {
                    $response = [
                        "success" => true,
                        "user_role_code" => $partnerRole,
                        "messages" => "",
                    ];
                    $userDetails = $this->userRepository->userDetails(
                        $request->email,
                        AppConstant::STATUS_ACTIVE
                    );
                    $userDetails->last_login_time = Carbon::now();
                    $userDetails->update();
                    LoginAuth::login($userDetails);
                    return response()->json($response);
                } elseif ($accountBlockStatus) {
                    $accountBlockDurationInMinutes =
                        AppConstant::ACCOUNT_BLOCK_DURATION_IN_MINUTE;
                    throw new Exception(
                        __("messages.account_block", [
                            "duration" => $accountBlockDurationInMinutes,
                        ]),
                        6005
                    );
                } elseif (
                    $otpVerificationStatus === AppConstant::OTP_STATUS_EXPIRED
                ) {
                    throw new Exception(__("messages.otp_time_expired"), 6003);
                } else {
                    # wrong_otp
                    throw new Exception(__("messages.wrong_otp"), 6004);
                }
            }
        } catch (Exception $e) {
            Log::info($e);
            $errorCode = $e->getCode();
            $errorMessage = $errorCode
                ? $e->getMessage()
                : __("messages.default_error_message");
            $response = [
                "success" => false,
                "messages" => $errorMessage,
                "error_code" => $errorCode,
            ];
            Log::error(
                "LoginController:verifyOtp:" .
                    $e->getMessage() .
                    json_encode($response)
            );
            return response()->json($response);
        }
    }
}
