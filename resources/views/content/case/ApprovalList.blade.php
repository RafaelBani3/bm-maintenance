@extends('layouts.Master')

@section('title', 'BM-Maintenance')
@section('subtitle', 'BM Maintenance - List Approval Case')

@section('content')

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">
            <div class="card mb-5 mb-xl-8">
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold fs-3 mb-1">@yield('title')</span>
                        <span class="text-muted mt-1 fw-semibold fs-7">@yield('subtitle')</span>
                    </h3>
                </div>
            
                <div class="card-body py-3">
                    <!--begin::Table container-->
                    <div class="table-responsive">
                        <!--begin::Table-->
                        <table class="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3" id="casesTable"> 
                            <!--begin::Table head-->
                            <thead>
                                <tr class="fw-bold text-muted">
                                    <th class="w-25px">
                                        <div class="form-check form-check-sm form-check-custom form-check-solid">
                                            <input class="form-check-input" id="selectAll" type="checkbox" value="1" data-kt-check="true" data-kt-check-target=".widget-13-check" />
                                        </div>
                                    </th>
                                    <th class="min-w-150px text-center align-middle">Case Id</th>
                                    <th class="min-w-140px text-center align-middle">Case Date</th>
                                    <th class="min-w-120px text-center align-middle">Case Name</th>
                                    <th class="min-w-120px text-center align-middle">Case Category</th>
                                    <th class="min-w-120px text-center align-middle">Created By</th>
                                    <th class="min-w-100px text-center align-middle">Position</th>
                                    <th class="min-w-120px text-center align-middle">Status</th>
                                    <th class="min-w-100px text-center align-middle">Actions</th>
                                </tr>
                            </thead>
                    
                            <tbody>
                            
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('content.case.partial.ApprovalListJs')
@endsection

{{-- <td class="text-end align-middle min-w-100px ">
    <a href="/Case/Approval/${caseItem.Case_No}" class="btn btn-primary btn-sm">
        View Details
    </a>
</td> --}}

