<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>VAS & NB Portal | Partner Registration</title>
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
                    <div class="col-md-6 col-lg-4 mx-auto">
                        <div class="auth-form">
                            <div class="d-flex mb-3">
                                <div class="flex-shrink-0 brand-logo">
                                    <img src="{{ asset('assets/images/logo.png') }}" alt="Logo">
                                </div>
                                <div class="flex-grow-1 ms-3 text-end">
                                    <h4 class="mt-3 m-b-5 text-welcome">IFRS</h4>
                                    <p class="text-muted">Register as Partner</p>
                                </div>
                            </div>
                            <form class="pt-3" method="POST" action="{{ route('register') }}">
                                @csrf
                                  <div class="form-group">
                                    <label>Partner Role<span class="text-danger">*</span></label>
                                    <select class="form-control" id="partner_code" name="partner_code">
                                        <option value="" disabled selected>Select a Partner</option>
                                        @foreach ($partners as $partner)
                                            <option {{ old('partner_code') == $partner['code'] ? 'selected' : '' }}
                                                value="{{ $partner['code'] }}">{{ $partner['name'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('partner_code')
                                        <p class="mt-1 text-danger">{{ 'Selecting a partner name is required' }}
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Company Name:</label>
                                    <input type="text" name="company_name" class="form-control"
                                        placeholder="Company Name">
                                    @error('company_name')
                                        <p class="error">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Account Email:</label>
                                    <input type="text" name="email" class="form-control" placeholder="Verfication Email will send to this ">
                                    @error('email')
                                        <p class="error">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for=""> Email:</label>
                                    <input type="text" name="robi_spoc_email" class="form-control"
                                        placeholder="IFRS">
                                    @error('robi_spoc_email')
                                        <p class="error">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Partner SPOC Email:</label>
                                    <input type="text" name="partner_spoc_email" class="form-control"
                                        placeholder="Partner Spoc Email">
                                    @error('partner_spoc_email')
                                        <p class="error">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mt-3">
                                    <button type="submit" class="btn btn-red btn-block">Register As Partner</button>
                                </div>
                            </form>
                            <div class="text-center mt-15">
                                <p>
                                    <span>Already have an account? </span><a href="{{ route('login') }}"
                                        class="auth-link">Login</a>
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
