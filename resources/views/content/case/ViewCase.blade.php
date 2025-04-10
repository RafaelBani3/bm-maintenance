@extends('layouts.Master')

@section('title', 'BM-Maintenance')
@section('subtitle', 'BM Maintenance - List Case')

@section('content')

<div id="kt_app_content" class="app-content flex-column-fluid">
    <div id="kt_app_content_container" class="app-container container-fluid">
        <!--begin::Filter Card-->
        <div class="card mb-5 mb-xl-8">
            <div class="card-header border-0 pt-5">
                <h3 class="card-title">Filter</h3>
            </div>
            <div class="card-body">
                <div class="row g-3 align-items-center">
                    <!--begin::Search-->
                    <div class="col-md-4">
                        <label for="searchReport" class="form-label">Search Report</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </span>
                            <input type="text" id="searchReport" class="form-control form-control-solid" placeholder="Enter report keyword...">
                        </div>
                    </div>
                    <!--end::Search-->

                    <!--begin::Filter-->
                    <div class="col-md-3">
                        <label for="statusFilter" class="form-label">Status</label>
                        <select id="statusFilter" class="form-select form-select-solid" data-control="select2" data-hide-search="true">
                            <option value="all">All Status</option>
                            <option value="OPEN">OPEN</option>
                            <option value="SUBMIT">SUBMIT</option>
                            <option value="AP1">AP1</option>
                            <option value="AP2">AP2</option>
                            <option value="AP3">AP3</option>
                            <option value="AP4">AP4</option>
                            <option value="AP5">AP5</option>
                            <option value="CLOSE">CLOSE</option>
                            <option value="REJECT">REJECT</option>
                        </select>
                    </div>
                    <!--end::Filter-->

                    <!--begin::Date Range Picker-->
                    <div class="col-md-4">
                        <label for="dateFilter" class="form-label">Date Range</label>
                        <input type="text" id="dateFilter" class="form-control form-control-solid" placeholder="Pick a date range">
                    </div>
                    <!--end::Date Range Picker-->

                    <!--begin::Apply Button-->
                    <div class="col-md-1 d-flex align-items-end mt-10">
                        <button class="btn btn-primary w-100" id="applyFilter">Apply</button>
                    </div>
                    <!--end::Apply Button-->
                </div>
            </div>
        </div>
        <!--end::Filter Card-->

        <!--begin::Table Card-->
        <div class="card mb-5 mb-xl-8">
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold fs-3 mb-1">@yield('title')</span>
                    <span class="text-muted mt-1 fw-semibold fs-7">@yield('subtitle')</span>
                </h3>
            </div>
            <div class="card-body py-3">
                <div class="table-responsive">
                    <table class="table table-striped table-row-bordered align-middle gs-0 gy-3" id="casesTable"> 
                        <thead>
                            <tr class="fw-bold text-muted">
                                <th class="min-w-150px text-center align-middle sortable" data-column="Case_No">Case Id</th>
                                <th class="min-w-140px text-center align-middle sortable" data-column="Case_Date">Case Date</th>
                                <th class="min-w-120px text-center align-middle">Case Name</th>
                                <th class="min-w-120px text-center align-middle">Case Category</th>
                                <th class="min-w-120px text-center align-middle">Created By</th>
                                <th class="min-w-120px text-center align-middle">Position</th>
                                <th class="min-w-120px text-center align-middle">Status</th>
                                <th class="min-w-100px text-center align-middle">Actions</th>
                            </tr>
                        </thead> 
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
        <!--end::Table Card-->
    </div>
</div>

    

    @include('content.case.partial.CaseListJs')
@endsection
