 @extends('layouts.master')
 @section('sections')
     <div class="col-md-12 stretch-card table-striped">
         <div class="card">
             <div class="card-body">

                 <body>
                     <div class="vh-100">
                         <div class="text-center" style="margin-top: 20%">
                             <h1 class="display-1 fw-bold">401</h1>
                             <p class="fs-3"> <span class="text-danger">Oops!</span> UNAUTHORIZED.</p>
                             <p class="lead">
                                 You are not authorized to access this page.
                             </p>
                             @isset(auth()->user()->role->code)

                             @if (auth()->user()->role->code==\App\Constant\AppConstant::ROLE_CODE_OPERATION)
                             <a href="{{ route(auth()->user()->role->code . '.user-list') }}"
                                class="btn btn-primary border border-danger mt-2">Go Back</a>
                              @endif

                            @if (auth()->user()->role->code==\App\Constant\AppConstant::ROLE_CODE_VENDOR)
                             <a href="{{ route('vendor.dashboard') }}"
                                class="btn btn-primary border border-danger mt-2">Go Back</a>
                            @endif
                            <a href="{{ route(auth()->user()->role->code . '.dashboard') }}"
                                class="btn btn-primary border border-danger mt-2">Go Home</a>

                             @endisset
                         </div>
                     </div>
                 </body>
             </div>
         </div>
     </div>
 @endsection
