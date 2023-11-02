@php
 $roleCode = requestFirstSegment();
@endphp
@extends("platform.{$roleCode}.layout")
@section('page-heading')
{{ \App\Constant\AppConstant::PROFILE_APPROVED == $partner->status ? 'Partner Details' : 'Review Partner Profile' }}
@endsection
@section('actions')
    <a class="btn btn-inverse-primary btn-fw mt-2 mt-xl-0" href="{{ route("{$roleCode}.partners.index") }}">
        <i class="mdi mdi-arrow-left-bold-circle-outline mr-5 align-middle"></i>Back</a>
@endsection
@section('sections')
    <div class="row">
        <div class="col-md-12 stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-view-page">
                                    <tbody>
                                        <tr>
                                            <td>Partner Type: </td>
                                            <td>{{ ucfirst($partner->partner_type) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Local Partner Name :</td>
                                            <td>{{ empty($partner->local_partner_name) ? '--' : $partner->local_partner_name }}</td>
                                        </tr>
                                        <tr>
                                            <td>Foreign Partner Name :</td>
                                            <td> {{ empty($partner->foreign_partner_name) ? '--' : $partner->foreign_partner_name }}</td>
                                        </tr>
                                        <tr>
                                            <td>Company Address :</td>
                                            <td>{{ $partner->company_address }}</td>
                                        </tr>
                                        <tr>
                                            <td>Partner Email :</td>
                                            <td>{{ $partner->email }}</td>
                                        </tr>
                                        <tr>
                                            <td>Contact Number :</td>
                                            <td>{{ $partner->phone }}</td>
                                        </tr>
                                        <tr>
                                            <td>Company Owner Name :</td>
                                            <td>{{ $partner->company_owner_name }}</td>
                                        </tr>
                                        <tr>
                                            <td>Company Owner Phone :</td>
                                            <td>{{ $partner->company_owner_phone }}</td>
                                        </tr>
                                        <tr>
                                            <td>Company Owner Email :</td>
                                            <td>{{ $partner->company_owner_email }}</td>
                                        </tr>
                                        <tr>
                                            <td>TVAS Certificate:</td>
                                            <td>
                                                @if (!empty($partner->tvas_certificate))
                                                    <a class="file-view-link" target="_blank"
                                                        href="{{ asset('files/' . $partner->tvas_certificate) }}"><i
                                                        class="{{ getFileTypeIcon($partner->tvas_certificate) }} align-middle"></i> View
                                                        file</a>
                                                @else
                                                    Unavailable
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Trade License :</td>
                                            <td>
                                                @if (!empty($partner->trade_license))
                                                    <a class="file-view-link" target="_blank"
                                                        href="{{ asset('files/' . $partner->trade_license) }}"><i
                                                        class="{{ getFileTypeIcon($partner->trade_license) }} align-middle"></i> View
                                                        file</a>
                                                @else
                                                    Unavailable
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>TIN Certificate :</td>
                                            <td>
                                                @if (!empty($partner->tin_certificate))
                                                    <a class="file-view-link" target="_blank"
                                                        href="{{ asset('files/' . $partner->tin_certificate) }}"><i
                                                        class="{{ getFileTypeIcon($partner->tin_certificate) }} align-middle"></i> View
                                                        file</a>
                                                @else
                                                    Unavailable
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>BIN Certificate :</td>
                                            <td>
                                                @if (!empty($partner->bin_certificate))
                                                    <a class="file-view-link" target="_blank"
                                                        href="{{ asset('files/' . $partner->bin_certificate) }}"><i
                                                        class="{{ getFileTypeIcon($partner->bin_certificate) }} align-middle"></i> View
                                                        file</a>
                                                @else
                                                    Unavailable
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Tarrif Approval :</td>
                                            <td>
                                                @if (!empty($partner->tarrif_approval))
                                                    <a class="file-view-link" target="_blank"
                                                        href="{{ asset('files/' . $partner->tarrif_approval) }}"><i
                                                        class="{{ getFileTypeIcon($partner->tarrif_approval) }} align-middle"></i> View
                                                        file</a>
                                                @else
                                                    Unavailable
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Company Last Year Financial Report:</td>
                                            <td>
                                                @if (!empty($partner->last_year_financial_report))
                                                    <a class="file-view-link" target="_blank"
                                                        href="{{ asset('files/' . $partner->last_year_financial_report) }}"><i
                                                        class="{{ getFileTypeIcon($partner->last_year_financial_report) }} align-middle"></i> View
                                                        file</a>
                                                @else
                                                    Unavailable
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Bank account details:</td>
                                            <td>
                                                @if (!empty($partner->company_bank_account_details))
                                                    {{ $partner->company_bank_account_details }}
                                                @else
                                                    Unavailable
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Email:</td>
                                            <td>
                                                @if (!empty($partner->robi_spoc_email))
                                                    {{ $partner->robi_spoc_email }}
                                                @else
                                                    Unavailable
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Partner SPOC Email:</td>
                                            <td>
                                                @if (!empty($partner->partner_spoc_email))
                                                    {{ $partner->partner_spoc_email }}
                                                @else
                                                    Unavailable
                                                @endif
                                            </td>
                                        </tr>
                                        @if (\App\Constant\AppConstant::PROFILE_APPROVED != $partner->status)
                                            <form action="{{ route("{$roleCode}.partner.review.update", $partner->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')
                                                <tr>
                                                    <td> Approval:</td>
                                                    <td>
                                                        @foreach ($profileStatus as $value => $label)
                                                            <div class="form-check form-check-danger form-check-inline">
                                                                <label class="form-check-label">
                                                                    <input name="status" value="{{ $value }}"
                                                                        type="radio" class="form-check-input"
                                                                        {{ $partner->status == $value ? 'checked' : '' }}>
                                                                    {{ $label }}
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                        @error('status')
                                                        <p class="text-danger">{{ $message }}</p>
                                                        @enderror
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>Remarks:</td>
                                                    <td>
                                                        <textarea class="form-control" name="remarks" rows="4" style="max-width:500px"></textarea>
                                                        <p class="input-note">Max length: 5000 Characters.</p>
                                                    </td>

                                                </tr>

                                                <tr>
                                                    <td>
                                                        <button type="submit" class="btn btn-primary">Submit</button>
                                                    </td>
                                                </tr>
                                            </form>
                                        @endif
                                    </tbody>
                                </table>
                                @if (!empty($partner->reviewHistory))
                                    <div class="card bg-light mt-5">
                                        <div class="card-header">
                                            <h5>Review Histories</h5>

                                        </div>
                                        <div class="card-body">
                                            <table class="table table-bordred table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Review By</th>
                                                        <th>Remarks</th>
                                                        <th class="text-center">Action</th>
                                                        <th>Date</th>
                                                    </tr>
                                                <tbody>
                                                    @forelse ($partner->reviewHistory as $history)
                                                        <tr>
                                                            <td style="width:200px">{{ $history->reviewer->name }}
                                                                ({{ $history->reviewer->role->name }})</td>
                                                            <td>{{ empty($history->remarks) ? '--': $history->remarks  }}</td>
                                                            <td align="center"><span
                                                                    class="badge rounded-pill {{ isset($profileStatusBgClass[$history->review_action]) ? $profileStatusBgClass[$history->review_action] : 'N/A' }}">{{ $profileStatus[$history->review_action] }}
                                                                </span></td>
                                                            <td>{{ presentableDate($history->created_at) }}</td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td align="center" colspan='4'>History is not available.</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
