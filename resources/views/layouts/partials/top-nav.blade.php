<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="navbar-brand-wrapper d-flex justify-content-center">
        <div class="navbar-brand-inner-wrapper d-flex justify-content-between align-items-center w-100">
            <a class="navbar-brand brand-logo" href="{{ url('/'.Auth::user()?->role->code . '/') }}">
                <img src="{{ asset('assets/images/logo.png') }}" alt="VAS & NB Portal" />
            </a>

            <a class="navbar-brand brand-logo-mini" href="{{ url('/'.Auth::user()?->role->code . '/') }}">
                <img src="{{ asset('assets/images/logo.png') }}" alt="VAS & NB Portal" />
            </a>

            <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                <span class="mdi mdi-sort-variant"></span>
            </button>
        </div>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        @if (explode('/', parse_url(URL::current())['path'])[1] != auth()->user()?->role->code)
        @if (in_array(auth()->user()?->role->code, [\App\Constant\AppConstant::ROLE_CODE_VENDOR,\App\Constant\AppConstant::ROLE_CODE_OSS]))
        @elseif(auth()->user())
         <a class="nav-link navbar-nav-right" href="{{ route(auth()->user()?->role->code . '.dashboard') }}">
                <i class="mdi mdi-home menu-icon align-middle"></i>
                <span class="menu-title">Back To My Profile</span>
         </a>
        @else
            <a class="nav-link navbar-nav-right" href="{{ route('login') }}">
                <i class="mdi mdi-home menu-icon align-middle"></i>
                <span class="menu-title">Back To My Profile</span>
            </a>
        @endif
        @endif
        <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item nav-profile dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" id="profileDropdown">
                    <span class="nav-profile-name">{{ auth()->user()?->name }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                    @yield('top-right-menu')
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item">
                            <i class="mdi mdi-logout text-primary"></i>
                            Logout
                        </button>
                    </form>
                </div>
            </li>
        </ul>

        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
            data-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
        </button>

    </div>
</nav>
