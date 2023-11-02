<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login</title>
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
                        <div class="auth-form">
                            <div class="d-flex mb-5">
                                <div class="flex-shrink-0 brand-logo">
                                    <img src="{{ asset('assets/images/logo.png') }}" alt="Logo">
                                </div>
                                <div class="flex-grow-1 ms-3 text-end">
                                    <h4 class="mt-3 m-b-5 text-welcome">Laravel Base Project</h4>
                                    <p class="text-muted">Login to your Account</p>
                                </div>
                            </div>

                            <div class="mt-3">
                                <a href="{{ route('azure.login') }}" class="btn btn-red btn-block">
                                    AD
                                </a>
                            </div>
                            <form class="pt-3" method="POST" action="{{ route('user.otp_login') }}">
                                @csrf
                                <div class="form-group">
                                    <input type="email" name="email" class="form-control" placeholder="Email"
                                        value="{{ old('email') }}">
                                    @error('email')
                                        <p class="error">{{ $message }}</p>
                                    @enderror
                                    @if (session('error'))
                                        <p class="error">{{ session('error') }}</p>
                                    @endif
                                </div>
                                <div class="mt-3">
                                    <button type="submit" class="btn btn-red btn-block">Login with otp</button>
                                </div>
                            </form>
                            <div class="text-center mt-15">
                                <p class="mt-15">
                                    <span clss="mr-15">Don't have an account?</span> <a href="{{ route('register') }}"
                                        class="auth-link">Sign Up Now</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
