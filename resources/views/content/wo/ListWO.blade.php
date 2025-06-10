@extends('layouts.Master')

@section('title', 'BM-Maintenance')
@section('subtitle', 'BM Maintenance - List Work Order')

@section('content')

    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
        <!--begin::Content wrapper-->
        <div class="d-flex flex-column flex-column-fluid py-3 py-lg-6">
            <div id="kt_app_content" class="app-content flex-column-fluid">
                <!--begin::Content container-->
                <div id="kt_app_content_container" class="app-container container-xxl">
                    <!--begin::Navbar-->
                    <div class="card mb-5 mb-xl-10">
                        <div class="card-header card-header-stretch">
                            <!--begin::Title-->
                            <div class="card-title d-flex align-items-center">
                                <h3 class="fw-bold m-0 text-gray-800">Filter</h3>
                            </div>
                            <!--end::Title-->
                        </div>
                
                        {{-- Filter --}}
                        <div class="card-body">
                            <div class="row g-5 align-items-end">
                                <!--begin::Search-->
                                <div class="col-lg-4">
                                    <label for="searchReport" class="form-label fw-bold">Search Report</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">
                                            <i class="fa-solid fa-magnifying-glass text-muted"></i>
                                        </span>
                                        <input type="text" id="searchReport" class="form-control form-control-solid" placeholder="Input your Case No" aria-describedby="basic-addon1" />
                                    </div>
                                </div>
                                <!--end::Search-->
                        
                                <!--begin::Filter-->
                                <div class="col-lg-3">
                                    <label for="statusFilter" class="form-label fw-bold">Status</label>
                                    <select class="form-select form-select-solid" name="category" id="statusFilter" data-control="select2" data-hide-search="true" data-placeholder="Select Category">
                                        <option value="all">All Status</option>
                                        <option value="OPEN">OPEN</option>
                                        <option value="OPEN_COMPLETION">OPEN_COMPLETION</option>
                                        <option value="SUBMIT">SUBMIT</option>
                                        <option value="AP1">AP1</option>
                                        <option value="AP2">AP2</option>
                                        <option value="AP3">AP3</option>
                                        <option value="AP4">AP4</option>
                                        <option value="AP5">AP5</option>
                                        <option value="CLOSE">CLOSE</option>
                                        <option value="REJECT">REJECT</option>
                                        <option value="DONE">DONE</option>
                                    </select>
                                </div>
                                <!--end::Filter-->
                        
                                <!--begin::Date Range Picker-->
                                <div class="col-lg-3">
                                    <label for="dateFilter" class="form-label fw-bold">Date Range</label>
                                    <input type="text" id="dateFilter" class="form-control form-control-solid" placeholder="Pick a date range" />
                                </div>
                                <!--end::Date Range Picker-->
                        
                                <!--begin::Apply Button-->
                                <div class="col-lg-2">
                                    <label class="form-label fw-bold text-white">.</label> 
                                    <button class="btn btn-primary w-100" id="applyFilter">
                                        <i class="fa-solid fa-filter me-1"></i> Apply
                                    </button>
                                </div>
                                <!--end::Apply Button-->
                            </div>
                        </div>
                        {{-- Filter --}}
                    </div>
                    <!--end::Navbar-->

                    <div class="card mb-5 mb-xl-10">
                        <div class="card-header card-header-stretch">
                            <!--begin::Title-->
                            <div class="card-title d-flex align-items-center">
                                <h3 class="fw-bold m-0 text-gray-800">WorkOrder List</h3>
                            </div>
                            <div class=" d-flex align-items-center">
                                <!--begin::Export-->
                                {{-- <a href="{{ route('wo.export') }}"> --}}
                                    <button type="button" class="btn btn-light-primary me-3" id="exportExcel">
                                            <i class="ki-duotone ki-exit-up fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>Export
                                    </button>
                                {{-- </a> --}}
                                <!--end::Export-->
                            </div>

                            <!--end::Title-->
                        </div>
                
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="WoTable" class="table table-row-bordered gy-5 gs-7" style="width:100%;">
                                    <thead>
                                        <tr class="fw-semibold fs-6 text-gray-800">
                                            <th class="min-w-150px text-start">WO No</th>
                                            <th class="min-w-150px text-start">Case No</th>
                                            <th class="min-w-150px text-start">Requested By</th>
                                            <th class="min-w-150px text-start">Created Date</th>
                                            <th class="min-w-150px text-start">WO Start</th>
                                            <th class="min-w-150px text-start">WO End</th>
                                            <th class="min-w-150px text-start">Status</th>
                                            <th class="min-w-250px text-start">Narrative</th>
                                            <th class="min-w-150px text-start">Need Material</th>
                                            <th class="min-w-120px text-center">Completed Date</th>
                                            <th class="min-w-200px text-center">Completed By</th>
                                            <th class="min-w-100px text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                
                    <!--end::Navbar-->
                </div>
            </div>
        </div>
    </div>

    <div class="page-loader flex-column d-flex position-fixed top-0 start-0 w-100 h-100 d-none justify-content-center align-items-center bg-dark bg-opacity-25" style="z-index: 1055;">
        <div class="text-center">
            <span class="spinner-border text-primary" role="status"></span>
            <div class="mt-3 text-white fw-semibold">Loading...</div>
        </div>
    </div>
    
    @include('content.wo.partial.ListWOJS')

@endsection



