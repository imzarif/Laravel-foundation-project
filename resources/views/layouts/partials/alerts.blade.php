@if (session('status'))
<div class="row">
    <div class="col-md-12 grid-margin">
        <div class="alert alert-primary mb-0 alert-dismissible fade show" role="alert">
            {{ session('status') }}

            <button type="button" class="btn btn-sm border-0 p-0 float-right" data-dismiss="alert" aria-label="Close">
                <i class="mdi mdi-close text-dark font-weight-bolder"></i>
            </button>
        </div>
    </div>
</div>
@endif

@if (session('success'))
<div class="row">
    <div class="col-md-12 grid-margin">
        <div class="alert alert-success mb-0 alert-dismissible fade show" role="alert">
            {{ session('success') }}

            <button type="button" class="btn btn-sm border-0 p-0 float-right" data-dismiss="alert" aria-label="Close">
                <i class="mdi mdi-close text-dark font-weight-bolder"></i>
            </button>
        </div>
    </div>
</div>
@endif

@if (session('warning'))
<div class="row">
    <div class="col-md-12 grid-margin">
        <div class="alert alert-warning mb-0 alert-dismissible fade show" role="alert">
            {{ session('warning') }}

            <button type="button" class="btn btn-sm border-0 p-0 float-right" data-dismiss="alert" aria-label="Close">
                <i class="mdi mdi-close text-dark font-weight-bolder"></i>
            </button>
        </div>
    </div>
</div>
@endif

@if (session('error'))
<div class="row">
    <div class="col-md-12 grid-margin">
        <div class="alert alert-danger mb-0 alert-dismissible fade show" role="alert">
            {{ session('error') }}

            <button type="button" class="btn btn-sm border-0 p-0 float-right" data-dismiss="alert" aria-label="Close">
                <i class="mdi mdi-close text-dark font-weight-bolder"></i>
            </button>
        </div>
    </div>
</div>
@endif