<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>IFRS | Login</title>
    <link rel="stylesheet" href="{{ asset('assets/vendors/base/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/theme-default.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/auth.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/images/logo.png') }}" />
</head>

<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper">
                <div class="row">
                    <div class="col-sm-10 col-md-6 col-lg-4 mx-auto">
                        <div class="auth-form mt-5">
                            <div class="d-flex mb-5">
                                <div class="flex-shrink-0 brand-logo">
                                    <img src="{{ asset('assets/images/logo.png') }}" alt="Logo">
                                </div>
                                <div class="flex-grow-1 ms-3 text-end">
                                    <h4 class="mt-3 m-b-5 text-welcome">IFRS</h4>
                                    <p class="text-muted">Account Verification</p>
                                </div>
                            </div>
                            <div>
                                <p class="text-notmal">
                                    <strong>Thanks for signing up!</strong> Before getting started, could you verify
                                    your email address by clicking on the link we just emailed to you? If you didn't
                                    receive the email, we will gladly send you another.
                                </p>

                                @if (session('status') == 'verification-link-sent')
                                    <p class="text-notmal text-danger">A new verification link has been sent to the
                                        email address you provided during registration.
                                    </p>
                                @endif

                                <div class="mt-5 mb-3 d-flex justify-content-between">
                                    <form method="POST" action="{{ route('verification.send') }}">
                                        @csrf
                                        <button type="submit"
                                            class="btn btn-red">{{ __('Resend Verification Email') }}</button>
                                    </form>

                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf

                                        <button type="submit" class="btn btn-dark">
                                            {{ __('Log Out') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
