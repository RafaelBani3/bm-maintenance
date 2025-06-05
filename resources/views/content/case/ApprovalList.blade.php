@extends('layouts.Master')

@section('title', 'BM-Maintenance')
@section('subtitle', 'List Approval Case')

@section('content')

    <style>
        .badge {
            padding: 0.5em 0.75em;
            font-size: 0.75rem;
            font-weight: 600;
            border-radius: 0.35rem;
        }
    </style>

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
                                <div class="col-lg-5">
                                    <label for="searchReport" class="form-label fw-bold">Search Report</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">
                                            <i class="fa-solid fa-magnifying-glass text-muted"></i>
                                        </span>
                                        <input type="text" id="searchReport" class="form-control form-control-solid" placeholder="Input your Case No" aria-describedby="basic-addon1" />
                                    </div>
                                </div>
                                <!--end::Search-->
                        
                                <!--begin::Date Range Picker-->
                                <div class="col-lg-5">
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
                                <h3 class="fw-bold m-0 text-gray-800">Approval Case List</h3>
                            </div>
                            <!--end::Title-->
                        </div>
                
                        <div class="card-body">
                            <div class="row g-5 align-items-end">
                                <div class="tab-content">
                                    <div id="kt_billing_months" class="card-body p-0 tab-pane fade show active" role="tabpanel" aria-labelledby="kt_billing_months">
                                        <div class="table-responsive">
                                            <table class="table table-row-bordered align-middle gy-5 gs-9" id="casesTable"> 
                                                <thead>
                                                    <tr class="fw-bold text-muted">
                                                        <th class="min-w-150px text-start text-muted align-middle sortable fs-6" data-column="Case_No">Case Id</th>
                                                        <th class="min-w-140px text-start align-middle sortable fs-6" data-column="Case_Date">Case Date</th>
                                                        <th class="min-w-120px text-start align-middle fs-6">Case Name</th>
                                                        <th class="min-w-120px text-start align-middle fs-6">Case Category</th>
                                                        <th class="min-w-120px text-start align-middle fs-6">Created By</th>
                                                        <th class="min-w-120px text-start align-middle fs-6">Position</th>
                                                        <th class="min-w-120px text-start align-middle fs-6">Status</th>
                                                        <th class="min-w-100px text-start align-middle fs-6">Actions</th>
                                                    </tr>
                                                </thead> 
                                                <tbody class="fw-semibold text-gray-600">
                    
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <!--end::Navbar-->
                </div>
            </div>
            <!--end::Table Card-->
        </div>
    </div>

    @include('content.case.partial.ApprovalListJs')
    
    <script>
        const BASE_URL = "{{ url('/') }}";
    </script>
@endsection


