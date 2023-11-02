@extends('layouts.master')
@section('sections')
    <div class="col-md-12 stretch-card table-striped">
        <div class="card">
            <div class="card-body">

                <body>
                    <div class="vh-100">
                        <div class="text-center" style="margin-top: 20%">

                            @if ($exception->getMessage()=='basic')
                                <p class="fs-3"> <span class="text-danger">Oops!</span> Basic Form/Stage doesn't exist.</p>
                                <p class="lead">
                                   <b> Assign a PM, who can fill up a Basic Form and configure stages.</b>
                                </p>
                            @isset(auth()->user()->role->code)
                                <a href="{{ route('gm.concepts.index')}}"
                                    class="btn btn-primary border border-danger mt-2">Go Back</a>
                            @endisset
                            @else
                            <h1 class="display-1 fw-bold">404</h1>
                            <p class="fs-3"> <span class="text-danger">Oops!</span> Page doesn't exist.</p>
                            <p class="lead">
                                The page you are looking for, does not exist
                            </p>
                            @isset(auth()->user()->role->code)

                            @if (auth()->user()->role->code==\App\Constant\AppConstant::ROLE_CODE_OPERATION)
                            <a href="{{ route(auth()->user()->role->code . '.user-list') }}"
                                class="btn btn-primary border border-danger mt-2">Go Back</a>
                            @endif
                            @if (auth()->user()->role->code==\App\Constant\AppConstant::ROLE_CODE_VENDOR)
                            <a href="{{ route( 'vendor.dashboard') }}"
                                   class="btn btn-primary border border-danger mt-2">Go Back</a>
                            @endif

                            <a href="{{ route(auth()->user()->role->code . '.dashboard') }}"
                                class="btn btn-primary border border-danger mt-2">Go Home</a>

                        @endisset
                            @endif

                        </div>
                    </div>
                </body>
            </div>
        </div>
    </div>
@endsection
