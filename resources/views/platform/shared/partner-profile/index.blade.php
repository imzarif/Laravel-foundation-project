@php
 $roleCode = requestFirstSegment();
@endphp
@extends("platform.{$roleCode}.layout")
@section('page-heading')
    All Partner
@endsection
@section('actions')
@endsection
@section('sections')
    <div class="row">
        <div class="col-md-12 stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="grid-filter-box">
                        <form action="{{ route('gm.partners.index') }}" method="GET">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Partner Type</label>
                                        <input name="partner_type" class="form-control"
                                            value="{{ request()->has('partner_type') ? request()->get('partner_type') : '' }}"
                                            type="text" placeholder="Partner Type">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Local or Foreign partner name</label>
                                        <input name="partner_name" class="form-control"
                                            value="{{ request()->has('partner_name') ? request()->get('partner_name') : '' }}"
                                            type="text" placeholder="Partner Name">
                                    </div>
                                </div>
                                <div class="col-md-4 btn-filter-input-inline text-end">
                                    <button type="submit" class="btn btn-inverse-primary btn-fw btn-inline">Apply
                                        Filter</button>
                                    <a href="{{ route('gm.partners.index') }}"
                                        class="btn btn-inverse-danger btn-fw btn-inline">Reset</a>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordred table-striped">
                            <thead>
                                <tr>
                                    <th>Partner Type</th>
                                    <th>Local Partner Name</th>
                                    <th>Foreign Partner Name</th>
                                    <th class="text-center">Status</th>
                                    <th>Creation Date</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($partners as $cp)
                                    <tr>
                                        <td>{{ ucfirst($cp->partner_type) }}</td>
                                        <td>{{ empty($cp->local_partner_name) ? '--' : $cp->local_partner_name }}</td>
                                        <td>{{ empty($cp->foreign_partner_name) ? '--' : $cp->foreign_partner_name }}</td>
                                        <td align="center"><span
                                                class="badge rounded-pill {{ isset($profileStatusBgClass[$cp->status]) ? $profileStatusBgClass[$cp->status] : 'N/A' }}">{{ isset($profileStatus[$cp->status]) ? $profileStatus[$cp->status] : 'N/A' }}</span>
                                        </td>
                                        <td>{{ presentableDate($cp->created_at) }}</td>
                                        <td align="center">
                                            <a href="{{ route("{$roleCode}.partner.review", $cp->id) }}"
                                                @if (\App\Constant\AppConstant::PROFILE_APPROVED == $cp->status) class="btn btn-inverse-primary btn-fw btn-sm btn-inline">
                                                    <i class="mdi mdi-eye mr-5 align-middle"></i>
                                                    &nbsp View  &nbsp
                                                @else
                                                    class="btn btn-inverse-info btn-fw btn-sm btn-inline">
                                                    <i class="mdi mdi-pencil-box-outline mr-5 align-middle"></i>
                                                    Review @endif
                                                {{-- {{ \App\Constant\AppConstant::PROFILE_APPROVED == $cp->status ? 'View' : 'Review' }} --}} </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3 d-flex justify-content-end">
                        {{ $partners->onEachSide(1)->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
