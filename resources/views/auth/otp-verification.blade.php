<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>VAS & NB Portal | OTP VERIFICATION</title>
    {{-- <link rel="stylesheet" href="{{ asset('assets/vendors/base/vendor.bundle.base.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('assets/vendors/base/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/theme-default.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/auth.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" />
    <script src="{{ asset('assets/js/jquery.js') }}"></script>
    <script src="{{ asset('assets/js/ajax.service.js') }}"></script>
</head>

<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper">
                <div class="row">
                    <div class="col-sm-10 col-md-6 col-lg-4 mx-auto">
                        <div class="auth-form">
                            <div class="d-flex mb-5">
                                <div class="flex-shrink-0 brand-logo">
                                    <img src="{{ asset('assets/images/logo.png') }}" alt="Logo">
                                </div>
                                <div class="flex-grow-1 ms-3 text-end">
                                    <h4 class="mt-3 m-b-5 text-welcome">IFRS</h4>
                                    <p class="text-muted">OTP Verification</p>
                                </div>
                            </div>

                            <div class="otp-separator-or-line"></div>
                            @if ($session_status === 'valid')
                                <form class="pt-3" id="otpVerificationForm">
                                    <div class="form-group">
                                        <input type="hidden" id="email" name="email"
                                            value="{{ $email }}" />
                                        <input type="hidden" id="uuid" name="uuid"
                                            value="{{ $uuid }}" />
                                        <p class="otp-message">
                                            OTP sent to: <strong>{{ $email }}</strong>.
                                        </p>
                                        <p class="info-message">
                                            <small>(If you didn't receive OTP in mail, Please recheck your mail address or Resend OTP)</small>
                                        </p><br>
                                        <input type="number" id="otp" name="otp" class="form-control"
                                            placeholder="OTP" />
                                        <p class="input-note">Current OTP will expire in 5 minute(s)</p>
                                        <p id="errorMessage" class="api-error-message mt-1">&nbsp;</p>
                                    </div>
                                    <div>
                                        <button type="button" class="btn btn-info btn-fw" id="resendOtp" {{ $no_of_otp_send >= 3 ? 'disabled' : '' }}>
                                            <span id="resendOtpContent">Resend OTP</span>
                                            <span class="spinner-grow spinner-grow-sm hide-otp-resend-content"></span>
                                            <span class="hide-otp-resend-content">Please wait..</span>
                                        </button>
                                        <span class="text-otp-sent-no">OTP Sent: <span id="otpSendNo">{{ $no_of_otp_send }}/3</span></span>
                                    </div>
                                    <div class="mt-3">
                                        <button type="submit" class="btn btn-red btn-block" id="submitOtp">
                                            <span id="submitOtpContent">Confirm</span>
                                            <span class="spinner-grow spinner-grow-sm hide-otp-submit-content"></span>
                                            <span class="hide-otp-submit-content">Verifying..</span>
                                        </button>
                                    </div>
                                </form>
                            @elseif ($session_status === 'expire')
                                <div class="warning-message">{{ $message }}</div>
                            @else
                                <div class="error-message">{{ $message }}</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
