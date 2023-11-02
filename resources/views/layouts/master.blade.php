@include('layouts.partials.head')

<div class="container-scroller">

    @include('layouts.partials.top-nav')
    <div id="loader" class="loader">
        <div class="content">
            <span class="loader-text">
            <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
            @yield('loader-text')
        </span>
        </div>
    </div>
    <div class="container-fluid page-body-wrapper">

        @include('layouts.partials.sidebar-nav')

        <div class="main-panel">

            <div class="content-wrapper">
                @hasSection('page-heading')

                <div class="row">
                    <div class="col-md-12 grid-margin">
                        <div class="d-flex justify-content-between flex-wrap">
                            <div class="d-flex align-items-end flex-wrap">
                                <div class="mr-md-3 mr-xl-5 pl-1">
                                    <h2 class="page-title">@yield('page-heading')</h2>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-end flex-wrap">
                                @yield('actions')
                            </div>

                        </div>
                    </div>
                </div>
                @endif
                @include('layouts.partials.alerts')
                @yield('sections')
            </div>
            @include('layouts.partials.footer')
        </div>

    </div>
</div>
@include('layouts.partials.foot')