@extends('layouts.Master')

@section('title', 'BM Maintenance')
@section('subtitle', 'BM Maintenance')

@section('content')

    <!-- Tambahkan di <head> jika belum ada -->
    <style>
    
        .card.card-flush {
            border-radius: 1rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            background-color: #ffffff;
            transition: all 0.3s ease;
        }

        .card.card-flush:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .card-header .card-title {
            gap: 0.5rem;
        }

        .card-header {
            border-bottom: 1px solid #eff2f5;
            padding-bottom: 1rem;
        }

        .card-footer {
            padding-top: 1rem;
            border-top: 1px solid #eff2f5;
            background-color: #f9fbfd;
            border-bottom-left-radius: 1rem;
            border-bottom-right-radius: 1rem;
        }

        .progress {
            height: 8px;
            border-radius: 4px;
            background-color: #e4e6ef;
        }

        .progress-bar {
            border-radius: 4px;
        }

        .badge i {
            margin-right: 0.25rem;
        }

        .fs-4hx {
            font-size: 2.75rem;
        }

        @media (max-width: 768px) {
            .card-body {
                text-align: center;
            }
        }
    </style>
             
<!--begin::Content-->
    {{-- Dashboard Creator --}}
    @if(auth()->user()->hasAnyPermission(['view cr', 'view wo', 'view mr']))
        
        {{-- <div id="kt_app_content" class="app-content flex-column-fluid">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container container-xxl">
                <!--begin::Row-->
                <div class="row gx-5 gx-xl-10 mb-xl-10">
                    <!--begin::Col-->
                    <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12 mb-10 d-flex gap-10 flex-wrap">

                        <!--begin::Card Total Case-->
                        <div class="card card-flush h-md-100 mb-5 flex-grow-1">
                            <!--begin::Header-->
                            <div class="card-header pt-5">
                                <div class="card-title d-flex flex-column">
                                    <div class="d-flex align-items-baseline">
                                        <span class="fs-4hx fw-bold text-gray-900 me-3 lh-1" id="total-case">0</span>
                                        <span class="badge badge-light-primary fs-3 align-self-start">
                                            <i class="ki-duotone ki-chart fs-8 text-primary ms-n1"></i>
                                            Cases
                                        </span>
                                    </div>
                                    <span class="text-gray-500 pt-1 fw-semibold fs-3">Total Case Submitted by You</span>
                                </div>
                            </div>
                            <!--end::Header-->

                            <!--begin::Body-->
                            <div class="card-body mb-10 d-flex align-items-center">
                                <div class="d-flex flex-center me-5">
                                    <div class="chart-case" id="kt_docs_google_chart_column" style="width: 130px; height: 130px;" data-kt-size="150" data-kt-line="150"></div>
                                </div>
                                <div class="d-flex flex-column content-justify-center w-100">
                                    <!-- Category List -->
                                    <div class="flex-grow-1 w-100" id="category-list">
                                        <!-- Akan diisi oleh JS -->
                                    </div>
                                </div>
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Card Total Case-->

                        <!--begin::Card Total Work Order-->
                        <div class="card card-flush h-md-100 mb-5 flex-grow-1" >
                            <!--begin::Header-->
                            <div class="card-header pt-5">
                                <div class="card-title d-flex flex-column">
                                    <div class="d-flex align-items-baseline">
                                        <span id="wo-total" class="fs-4hx fw-bold text-gray-900 me-2 lh-1">0</span>
                                        <span class="badge badge-light-info fs-3 align-self-start">
                                            <i class="ki-duotone ki-chart fs-5 text-primary ms-n1"></i>
                                            Work Orders
                                        </span>
                                    </div>
                                    <span class="text-gray-500 pt-1 fw-semibold fs-3">Work Orders This Month</span>
                                </div>
                            </div>
                            <!--end::Header-->

                            <!--begin::Card body-->
                            <div class="card-body d-flex align-items-center">
                                <div class="d-flex align-items-center flex-column w-100">
                                    <!--begin::Details-->
                                    <div class="d-flex flex-column justify-content-center w-100 mb-4">
                                        <div class="d-flex justify-content-between align-items-center mb-5">
                                            <div class="d-flex align-items-center">
                                                <span class="bullet bullet-vertical bg-info me-2 h-10px w-10px"></span>
                                                <span class="text-gray-600">In Progress</span>
                                            </div>
                                            <span id="inprogress-count" class="fw-bold text-gray-800">0</span>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center mb-5">
                                            <div class="d-flex align-items-center">
                                                <span class="bullet bullet-vertical bg-success me-2 h-10px w-10px"></span>
                                                <span class="text-gray-600">Done</span>
                                            </div>
                                            <span id="completed-count" class="fw-bold text-gray-800">0</span>
                                        </div>
                                         <div class="d-flex justify-content-between align-items-center mb-5">
                                            <div class="d-flex align-items-center">
                                                <span class="bullet bullet-vertical bg-danger me-2 h-10px w-10px"></span>
                                                <span class="text-gray-600">Reject</span>
                                            </div>
                                            <span id="submit-count" class="fw-bold text-gray-800">0</span>
                                        </div>
                                    </div>
                                    <!--end::Details-->

                                    <div class="d-flex justify-content-between w-100 mb-2">
                                        <span class="fw-bolder fs-7 text-gray-900" id="wo-to-goal">0 of 0 Work Orders Have Been Completed</span>
                                        <span class="fw-bold fs-6 text-gray-500" id="wo-percent">0%</span>
                                    </div>

                                    <div class="h-10px mx-3 w-100 bg-secondary rounded">
                                        <div id="progress-done" class="bg-success h-10px rounded" style="width: 0%;" role="progressbar"></div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Card Total Work Order-->

                        <!--begin::Card Total Material Request-->
                        <div class="card card-flush h-md-100 mb-5 flex-grow-1">
                            <!--begin::Header-->
                            <div class="card-header pt-5">
                                <div class="card-title d-flex flex-column">
                                    <div class="d-flex align-items-baseline">
                                        <span id="mr-total" class="fs-4hx fw-bold text-gray-900 me-2 lh-1 ls-n2">0</span>
                                        <span class="badge badge-light-success fs-3 align-self-start">
                                            <i class="ki-duotone ki-chart fs-5 text-primary ms-n1"></i>
                                            Material Request
                                        </span>
                                    </div>
                                    <span class="text-gray-500 pt-1 fw-semibold fs-3">Material Requests This Month</span>
                                </div>
                            </div>
                            <!--end::Header-->

                            <!--begin::Card body-->
                            <div class="card-body d-flex align-items-center">
                                <div class="d-flex align-items-center flex-column w-100">
                                    <!--begin::Details-->
                                    <div class="d-flex flex-column justify-content-center w-100 mb-4">
                                        <div class="d-flex justify-content-between align-items-center mb-5">
                                            <div class="d-flex align-items-center">
                                                <span class="bullet bullet-vertical bg-danger me-2 h-10px w-10px"></span>
                                                <span class="text-gray-600">Reject</span>
                                            </div>
                                            <span id="mr-submit-count" class="fw-bold text-gray-800">0</span>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center mb-5">
                                            <div class="d-flex align-items-center">
                                                <span class="bullet bullet-vertical bg-info me-2 h-10px w-10px"></span>
                                                <span class="text-gray-600">In Progress</span>
                                            </div>
                                            <span id="mr-inprogress-count" class="fw-bold text-gray-800">0</span>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center mb-5">
                                            <div class="d-flex align-items-center">
                                                <span class="bullet bullet-vertical bg-success me-2 h-10px w-10px"></span>
                                                <span class="text-gray-600">Done</span>
                                            </div>
                                            <span id="mr-completed-count" class="fw-bold text-gray-800">0</span>
                                        </div>
                                    </div>
                                    <!--end::Details-->

                                    <div class="d-flex justify-content-between w-100 mb-2">
                                        <span class="fw-bolder fs-7 text-gray-900" id="mr-to-goal">0 of 0 Material Requests Have Been Completed</span>
                                        <span class="fw-bold fs-6 text-gray-500" id="mr-percent">0%</span>
                                    </div>
                                    <div class="h-10px mx-3 w-100 bg-secondary rounded d-flex">
                                        <div id="mr-progress-submit" class="bg-warning h-10px rounded-start rounded-end" style="width: 0%;" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                        <div id="mr-progress-inprogress" class="bg-info h-20px rounded-start" style="width: 0%;" role="progressbar"></div>
                                        <div id="mr-progress-done" class="bg-success h-10px rounded-end" style="width: 0%;" role="progressbar"></div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Card Total Material Request-->

                    </div>
                    <!--end::Col-->
                    
                    <!--Tabel-->
                    <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12 mb-10 d-flex gap-10 flex-wrap">
                        <div class="card card-flush h-md-100 flex-grow-1">
                            <div class="card-header card-header-stretch">
                                <div class="card-title d-flex align-items-center">
                                    <h1 class="fw-bold m-0 text-gray-800">Case List</h1>
                                </div>
                            </div>
                    
                            <div class="card-body">
                                <div class="tab-content">
                                    <div id="kt_billing_months" class="card-body p-0 tab-pane fade show active" role="tabpanel" aria-labelledby="kt_billing_months">
                                        <div class="table-responsive">
                                            <table id="kt_datatable_responsive" class="table table-row-bordered rounded gy-5 gs-7">
                                                <thead>
                                                    <tr class="fw-semibold fs-6 text-gray-800">
                                                        <th class="min-w-150px" data-priority="1">Case</th>
                                                        <th class="min-w-150px">Work Order</th>
                                                        <th class="min-w-150px">Material Request</th>
                                                        <th class="min-w-150px">Created By</th>
                                                        <th class="min-w-150px">Case Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($cases as $case)
                                                        <tr>
                                                            <td>
                                                                {{ $case->Case_No }}
                                                                <span class="badge badge-light-primary">{{ $case->Case_Status }}</span>
                                                            </td>
                                                            <td>
                                                                @if($case->workOrder)
                                                                    {{ $case->workOrder->WO_No }}
                                                                    <span class="badge badge-light-{{ $case->workOrder->WO_Status == 'DONE' ? 'success' : 'warning' }}">
                                                                        {{ $case->workOrder->WO_Status }}
                                                                    </span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if($case->workOrder && $case->workOrder->WO_NeedMat == 'Y' && $case->workOrder->materialRequest)
                                                                    {{ $case->workOrder->materialRequest->MR_No }}
                                                                    <span class="badge badge-light-info">{{ $case->workOrder->materialRequest->MR_Status }}</span>
                                                                @endif
                                                            </td>
                                                            <td>{{ $case->creator->Fullname ?? '-' }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($case->CR_DT)->format('d/m/Y') }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>

                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
                <!--end::Row-->
            </div>
        </div> --}}

        <!-- Main Content -->       
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-xxl">

                <!-- Cards Section - Baris 1 -->
                <div class="row gx-5 gx-xl-10 mb-xl-10">             
                    <!-- Total Case -->
                    <div class="col-md-4 col-lg-4 col-xl-4">
                        <div class="card card-flush h-md-100 flex-grow-1">
                            <div class="card-body">
                                <!-- Header -->
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-gray-600 fw-bold fs-1">Total Case</span>
                                    <span class="badge badge-light-primary fs-7">This Month</span>
                                </div>

                                <!-- Total Value and Change -->
                                <div class="d-flex align-items-center">
                                    <span class="fs-4hx fw-bold text-dark me-2" id="total-case">0</span>
                                    {{-- <span id="case-change"></span> --}}
                                </div>

                                <!-- Comparison Note -->
                                {{-- <div class="text-muted fs-7 mt-3" id="case-to-goal">Compared to last month</div> --}}
                            </div>
                        </div>
                    </div>

                    <!-- Total Work Order -->
                    <div class="col-md-4 col-lg-4 col-xl-4">
                        <div class="card card-flush h-md-100 flex-grow-1">
                            <div class="card-body">
                                <!-- Header -->
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-gray-600 fw-bold fs-1">Total Work Order</span>
                                    <span class="badge badge-light-info fs-7">This Month</span>
                                </div>

                                <!-- Total Value and Change -->
                                {{-- <div class="d-flex align-items-center">
                                    <span class="fs-4hx fw-bold text-dark me-2" id="wo-total">0</span>
                                    <span id="wo-change" class="fs-4 fw-bold d-flex align-items-center">
                                        <!-- Filled dynamically -->
                                    </span>
                                </div> --}}
                                <!-- Total Value -->
                                <div class="d-flex align-items-center">
                                    <span class="fs-4hx fw-bold text-dark me-2" id="wo-total">0</span>
                                </div>

                                <!-- Comparison Note -->
                                {{-- <div class="text-muted fs-7 mt-3">Compared to last month</div> --}}
                            </div>
                        </div>
                    </div>
                    <!--end::Card Total Work Order-->

                    <!-- Total Material Request -->
                    <div class="col-md-4 col-lg-4 col-xl-4">
                        <div class="card card-flush h-md-100 flex-grow-1">
                            <div class="card-body">
                                <!-- Header -->
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-gray-600 fw-bold fs-1">Total Material Request</span>
                                    <span class="badge badge-light-danger fs-7">This Month</span>
                                </div>

                                <!-- Total Value and Change -->
                                {{-- <div class="d-flex align-items-center">
                                    <span class="fs-4hx fw-bold text-dark me-2" id="mr-total">0</span>
                                    <span id="mr-change"></span>
                                </div> --}} 
                                <!-- Total Value Only -->
                                <div class="d-flex align-items-center">
                                    <span class="fs-4hx fw-bold text-dark me-2" id="mr-total">0</span>
                                </div>

                                <!-- Comparison Note -->
                                {{-- <div class="text-muted fs-7 mt-3">Compared to last month</div> --}}
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Cards Section - Baris 2 -->
                <div class="row gx-5 gx-xl-10 mb-xl-10">             
                    <!-- Grafik Total Case Berdasarkan Category -->
                    <div class="col-md-4 col-lg-4 col-xl-4">
                        <div class="card card-flush h-md-100 flex-grow-1">
                            <div class="card-body">
                                <!-- Header -->
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <div>
                                        <div class="text-muted fw-semibold fs-3 mb-5">Total Case By Category (This Month)</div>
                                    </div>
                                    <div id="case-change"></div>
                                </div>

                                <!-- Chart -->
                                <div id="kt_docs_google_chart_column" style="height: 200px;"></div>

                                <!-- Legend -->
                                <div class="mt-5" id="category-list"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8 col-lg-8 col-xl-8">
                        <div class="card card-flush h-md-100 flex-grow-1">
                            <div class="card-body">
                                <!-- Header -->
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <div>
                                        <div class="text-muted fw-semibold fs-3 mb-5">Perbandingan Case dan Work Order per Bulan</div>
                                    </div>
                                </div>

                                <!-- Chart -->
                                <div id="kt_apexcharts_1" style="height: 350px;"></div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!--end::Content-->

    @endif

    {{-- Dashboard APPROVAL --}}
    @if(auth()->user()->hasAnyPermission(['view cr_ap','view mr_ap']))
        {{-- <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-xxl">
                <!--begin::Row-->
                <div class="row gx-5 gx-xl-10 mb-xl-10">
                    <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12 mb-10 d-flex gap-10 flex-wrap">
                        
                        <!--begin::Card: Total Case to Approve-->
                        <div class="card card-flush h-md-100 mb-5 flex-grow-1">
                            <div class="card-header pt-5">
                                <div class="card-title d-flex flex-column">
                                    <div class="d-flex align-items-baseline">
                                        <span id="pending-case-count" class="fs-4hx fw-bold text-gray-900 me-2 lh-1">0</span>
                                        <span class="badge badge-light-primary fs-3 align-self-start">
                                            <i class="ki-duotone ki-folder fs-8 text-primary ms-n1"></i>
                                            Awaiting Approval
                                        </span>
                                    </div>
                                    <span class="text-gray-500 pt-1 fw-semibold fs-4">Pending Case Approval</span>
                                </div>
                            </div>
                            <div class="card-body mb-10 d-flex align-items-center justify-content-center">
                                <a href="{{ url('Case/Approval-list') }}" class="btn btn-primary">Lihat Detail</a>
                            </div>
                            <div class="card-footer">
                                <div class="d-flex flex-column w-100">
                                    <div class="d-flex justify-content-between fs-6 fw-semibold text-muted mb-2">
                                        <span id="case-progress-text">Loading progress...</span>
                                    </div>
                                    <div class="progress h-6px w-100">
                                        <div id="case-progress-bar" class="progress-bar bg-primary" style="width: 0%;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--begin::Card: Total Work Order Completion to Approve-->
                        <div class="card card-flush h-md-100 mb-5 flex-grow-1">
                            <div class="card-header pt-5">
                                <div class="card-title d-flex flex-column">
                                    <div class="d-flex align-items-baseline">
                                        <span id="pending-woc-count" class="fs-4hx fw-bold text-gray-900 me-2 lh-1">...</span>
                                        <span class="badge badge-light-info fs-3 align-self-start">
                                            <i class="ki-duotone ki-clipboard fs-8 text-info ms-n1"></i>
                                            Work Order Completion
                                        </span>
                                    </div>
                                    <span class="text-gray-500 pt-1 fw-semibold fs-4">Pending WOC Approval</span>
                                </div>
                            </div>
                            <div class="card-body mb-10 d-flex align-items-center justify-content-center">
                                <a href="" class="btn btn-info">Lihat Detail</a>
                            </div>
                        </div>

                        <!--begin::Card: Total MR to Approve-->
                        @if(auth()->user()->hasAnyPermission(['view mr_ap']))
                            <!--begin::Card: Total Material Request to Approve-->
                            <div class="card card-flush h-md-100 mb-5 flex-grow-1">
                                <div class="card-header pt-5">
                                    <div class="card-title d-flex flex-column">
                                        <div class="d-flex align-items-baseline">
                                            <span id="pending-mr-count" class="fs-4hx fw-bold text-gray-900 me-2 lh-1">...</span>
                                            <span class="badge badge-light-warning fs-3 align-self-start">
                                                <i class="ki-duotone ki-clipboard fs-8 text-warning ms-n1"></i>
                                                Material Request
                                            </span>
                                        </div>
                                        <span class="text-gray-500 pt-1 fw-semibold fs-4">Pending MR Approval</span>
                                    </div>
                                </div>
                                <div class="card-body mb-10 d-flex align-items-center justify-content-center">
                                    <a href="" class="btn btn-warning">Lihat Detail</a>
                                </div>
                            </div>
                        @endif   
                    </div>
                </div>
            </div>
        </div> --}}

        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-xxl">
                
                <!--begin::Row: Approval Summary-->
                <div class="row gx-5 gx-xl-10 mb-10">
                    <!--begin::Card: Total Case to Approve-->
                    <div class="col-md-4 col-lg-4 col-xl-4">
                        <div class="card card-flush h-md-100 flex-grow-1">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="text-gray-600 fw-bold fs-4">Total Case</span>
                                    <span class="badge badge-light-primary fs-8">This Month</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span class="fs-3hx fw-bold text-primary me-2" id="total-case-to-approve">0</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--begin::Card: Total MR to Approve-->
                    <div class="col-md-4 col-lg-4 col-xl-4">
                        <div class="card card-flush h-md-100 flex-grow-1">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="text-gray-600 fw-bold fs-4">MR (Need Approval)</span>
                                    <span class="badge badge-light-info fs-8">Pending Approval</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span class="fs-3hx fw-bold text-info me-2" id="pending-mr-count">0</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--begin::Card: Total WO to Approve-->
                    <div class="col-md-4 col-lg-4 col-xl-4">
                        <div class="card card-flush h-md-100 flex-grow-1">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="text-gray-600 fw-bold fs-4">WO Completed (Need Approval)</span>
                                    <span class="badge badge-light-success fs-8">Pending Approval</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span class="fs-3hx fw-bold text-success me-2" id="pending-woc-count">0</span>
                                </div>
                            </div>
                        </div>
                    </div>
                  
                </div>
                
                <!--begin::Row: Latest Approval Activities-->
                <div class="row gx-5 gx-xl-10">
                    <div class="col-12">
                        <div class="card card-flush">
                            <div class="card-header">
                                <h3 class="card-title">Latest Approval Activities</h3>
                            </div>
                            <div class="card-body">
                                <table class="table align-middle table-row-dashed">
                                    <thead>
                                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                            <th>Type</th>
                                            <th>Reference</th>
                                            <th>Status</th>
                                            <th>Approved On</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Material Request</td>
                                            <td>#MR045</td>
                                            <td><span class="badge badge-light-success">Approved</span></td>
                                            <td>2025-05-26</td>
                                        </tr>
                                        <tr>
                                            <td>Work Order</td>
                                            <td>#WO031</td>
                                            <td><span class="badge badge-light-danger">Rejected</span></td>
                                            <td>2025-05-24</td>
                                        </tr>
                                        <tr>
                                            <td>Case</td>
                                            <td>#CASE008</td>
                                            <td><span class="badge badge-light-warning">Pending</span></td>
                                            <td>-</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    @endif

    {{-- Script Creator--}}
    @if(auth()->user()->hasAnyPermission(['view cr', 'view wo', 'view mr']))
        {{-- Script Case--}}
        {{-- Script Case tampil total data + Perbandingan + Grafik --}}
        <script type="text/javascript">
            google.load('visualization', '1', { packages: ['corechart'] });

            google.setOnLoadCallback(function () {
                fetch("{{ route('dashboard.case-summary') }}")
                    .then(response => response.json())
                    .then(data => {
                        const total = data.totalCases || 0;
                        const lastMonth = data.totalCasesLastMonth || 0;
                        const diff = total - lastMonth;
                        const percentChange = lastMonth > 0 ? (diff / lastMonth) * 100 : 100;

                        document.getElementById("total-case").textContent = total;

                        const icon = percentChange >= 0
                            ? '<i class="ki-outline ki-arrow-up fs-3 text-success me-1"></i>'
                            : '<i class="ki-outline ki-arrow-down fs-3 text-danger me-1"></i>';
                        const textClass = percentChange >= 0 ? 'text-success' : 'text-danger';
                        const formattedChange = `${icon}${Math.abs(percentChange).toFixed(1)}%`;

                        const colorList = [
                            { color: '#fe3995', class: 'bg-danger' },
                            { color: '#f6aa33', class: 'bg-warning' },
                            { color: '#6e4ff5', class: 'bg-primary' },
                            { color: '#2abe81', class: 'bg-success' },
                            { color: '#c7d2e7', class: 'bg-info' }
                        ];

                        const chartData = [['Category', 'Total Cases']];
                        const chartColors = [];
                        const categoryList = document.getElementById("category-list");
                        categoryList.innerHTML = "";

                        let isAllZero = true;

                        data.categories.forEach((cat, index) => {
                            const total = parseInt(cat.total);
                            const colorInfo = total > 0
                                ? colorList[index % colorList.length]
                                : { color: '#E4E6EF', class: 'bg-secondary' };

                            chartData.push([cat.Cat_Name, total]);
                            chartColors.push(colorInfo.color);

                            categoryList.innerHTML += `
                                <div class="d-flex fs-7 fw-semibold align-items-center mb-3 flex-wrap">
                                    <div class="bullet w-8px h-6px rounded-2 ${colorInfo.class} me-2"></div>
                                    <div class="text-gray-500 flex-grow-1 text-truncate">${cat.Cat_Name}</div>
                                    <div class="fw-bolder text-gray-700 text-end">${total} Case</div>
                                </div>
                            `;
                        });

                        if (isAllZero) {
                            chartData.push(['No Data', 1]);
                            chartColors.push('#E4E6EF');
                        }

                        const dataTable = google.visualization.arrayToDataTable(chartData);
                        const options = {
                            backgroundColor: '#ffffff',
                            pieHole: 0.7,
                            pieSliceText: 'none',
                            legend: 'none',
                            chartArea: { width: '100%', height: '100%' },
                            colors: chartColors,
                            tooltip: {
                                showColorCode: true,
                                textStyle: {
                                    fontSize: 14,
                                    bold: true,
                                    color: 'black'
                                }
                            }
                        };
                        

                        const chart = new google.visualization.PieChart(
                            document.getElementById('kt_docs_google_chart_column')
                        );
                        chart.draw(dataTable, options);
                    })
                    .catch(err => {
                        console.error("Gagal memuat data grafik case:", err);
                    });
            });
        </script>

        
        {{-- Script WO --}}
        {{-- Script WO yang Change(Persenan) dan Grafik ada  --}}
            {{-- <script type="text/javascript">
                document.addEventListener("DOMContentLoaded", function () {
                    google.charts.load("current", { packages: ["corechart"] });
                    google.charts.setOnLoadCallback(fetchAndDrawChart);

                    function fetchAndDrawChart() {
                        fetch("{{ route('dashboard.wo-summary') }}")
                            .then(response => response.json())
                            .then(data => {
                                const total = data.total || 0;
                                const lastMonthTotal = data.lastMonthTotal || 0;

                                const change = total - lastMonthTotal;
                                const percentChange = lastMonthTotal > 0
                                    ? (change / lastMonthTotal) * 100
                                    : 100;

                                const totalEl = document.getElementById("wo-total");
                                if (totalEl) totalEl.textContent = total;

                                const changeEl = document.getElementById("wo-change");
                                const changeIcon = change >= 0
                                    ? `<i class="ki-outline ki-arrow-up fs-3 text-success me-1"></i>`
                                    : `<i class="ki-outline ki-arrow-down fs-3 text-danger me-1"></i>`;
                                const changeClass = change >= 0 ? 'text-success' : 'text-danger';

                                if (changeEl) {
                                    changeEl.innerHTML = `${changeIcon}${percentChange.toFixed(1)}%`;
                                    changeEl.className = `fs-4 fw-bold d-flex align-items-center ${changeClass}`;
                                }

                                const chartData = google.visualization.arrayToDataTable([
                                    ['Status', 'Jumlah', { role: 'style' }],
                                    ['INPROGRESS', data.inprogressCount, '#ffc107'], 
                                    ['REJECT', data.submitCount, '#dc3545'],         
                                    ['DONE', data.completedCount, '#28a745']     
                                ]);

                                const options = {
                                    title: '',
                                    chartArea: { width: '80%', height: '70%' },
                                    legend: { position: 'none' },
                                    
                                    vAxis: {
                                        title: 'Jumlah WO',
                                        minValue: 0,
                                    },
                                    hAxis: {
                                        title: 'Status',
                                    },
                                    bar: { groupWidth: "20%" },
                                };

                                const chart = new google.visualization.ColumnChart(document.getElementById('kt_docs_google_chart_bar'));
                                chart.draw(chartData, options);
                            })
                            .catch(error => console.error("Gagal ambil data WO:", error));
                    }
                });
            </script> --}}

        {{-- Script WO hanya Tampil total data WO --}}
        <script type="text/javascript">
            document.addEventListener("DOMContentLoaded", function () {
                fetch("{{ route('dashboard.wo-summary') }}")
                    .then(response => response.json())
                    .then(data => {
                        const total = data.total || 0;
                        const totalEl = document.getElementById("wo-total");
                        if (totalEl) totalEl.textContent = total;
                    })
                    .catch(error => console.error("Gagal ambil data WO:", error));
            });
        </script>

        {{-- SCRIPT MR --}}
        {{-- Script MR tampil total data + Persen Perbandingan + Grafik --}}
            {{-- <script>
                $(document).ready(function () {
                    $.ajax({
                        url: "{{ url('/dashboard/material-request-summary') }}",
                        type: "GET",
                        success: function (data) {
                            const total = data.total || 0;
                            const lastMonth = data.totalLastMonth || 0;
                            const submitted = data.submitted;
                            const inProgress = data.inProgress;
                            const done = data.done;

                            const diff = total - lastMonth;
                            const percentChange = lastMonth > 0 ? (diff / lastMonth) * 100 : 100;

                            // Format angka
                            const percentDone = total > 0 ? (done / total) * 100 : 0;
                            const formatPercent = (val) => `${val.toFixed(1)}%`;

                            $("#mr-total").text(total);

                            $("#mr-to-goal")?.text(`${done} of ${total} Material Requests Have Been Completed/Done`);
                            $("#mr-percent")?.text(formatPercent(percentDone));
                            $("#mr-progress-done")?.css("width", percentDone + "%");
                            $("#mr-progress-done")?.attr("title", `Done: ${formatPercent(percentDone)} (${done} MR)`);

                            const icon = percentChange >= 0
                                ? '<i class="ki-outline ki-arrow-up fs-3 text-success me-1"></i>'
                                : '<i class="ki-outline ki-arrow-down fs-3 text-danger me-1"></i>';
                            const textClass = percentChange >= 0 ? 'text-success' : 'text-danger';
                            const formattedChange = `${icon}${Math.abs(percentChange).toFixed(1)}%`;

                            $("#mr-change").html(`<span class="${textClass} fs-4 fw-bold d-flex align-items-center">${formattedChange}</span>`);
                        },
                        error: function (xhr) {
                            console.error("Gagal mengambil data Material Request", xhr);
                        }
                    });
                });
            </script> --}}

        {{-- Script Tampila total data WO sj--}}
        <script>
            $(document).ready(function () {
                $.ajax({
                    url: "{{ url('/dashboard/material-request-summary') }}",
                    type: "GET",
                    success: function (data) {
                        const total = data.total || 0;
                        $("#mr-total").text(total);
                    },
                    error: function (xhr) {
                        console.error("Gagal mengambil data Material Request", xhr);
                    }
                });
            });
        </script>

        <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css"/>
        <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>

        <script>
            document.addEventListener("DOMContentLoaded", function () {
                fetch("{{ route('dashboard.case-wo-summary') }}")
                    .then(response => response.json())
                    .then(data => {
                        var element = document.getElementById('kt_apexcharts_1');
                        var height = parseInt(KTUtil.css(element, 'height'));
                        var labelColor = KTUtil.getCssVariableValue('--kt-gray-500');
                        var borderColor = KTUtil.getCssVariableValue('--kt-gray-200');

                        if (!element) return;

                        var options = {
                            series: [
                                { name: 'Case', data: data.caseData },
                                { name: 'Work Order', data: data.woData }
                            ],
                            chart: {
                                fontFamily: 'inherit',
                                type: 'bar',
                                height: height,
                                toolbar: { show: false }
                            },
                            plotOptions: {
                                bar: {
                                    horizontal: false,
                                    columnWidth: '30%',
                                    endingShape: 'rounded'
                                }
                            },
                            legend: {
                                show: true,
                                labels: {
                                    colors: labelColor,
                                    useSeriesColors: false
                                }
                            },
                            dataLabels: {
                                enabled: false
                            },
                            stroke: {
                                show: true,
                                width: 2,
                                colors: ['transparent']
                            },
                            xaxis: {
                                categories: data.months,
                                axisBorder: { show: false },
                                axisTicks: { show: false },
                                labels: {
                                    style: {
                                        colors: labelColor,
                                        fontSize: '12px'
                                    }
                                }
                            },
                            yaxis: {
                                labels: {
                                    style: {
                                        colors: labelColor,
                                        fontSize: '12px'
                                    }
                                }
                            },
                            fill: {
                                opacity: 1
                            },
                            states: {
                                normal: { filter: { type: 'none', value: 0 } },
                                hover: { filter: { type: 'none', value: 0 } },
                                active: {
                                    allowMultipleDataPointsSelection: false,
                                    filter: { type: 'none', value: 0 }
                                }
                            },
                            tooltip: {
                                style: {
                                    fontSize: '12px'
                                },
                                y: {
                                    formatter: function (val) {
                                        return val + ' data';
                                    }
                                }
                            },
                            colors: ['#007bff', '#ffc107'], 
                            grid: {
                                borderColor: borderColor,
                                strokeDashArray: 4,
                                yaxis: {
                                    lines: {
                                        show: true
                                    }
                                }
                            }
                        };

                        new ApexCharts(element, options).render();
                    });
            });
        </script>
    @endif

    {{-- Script Dashboard Approval --}}
    @if(auth()->user()->hasAnyPermission(['view cr_ap','view mr_ap']))
        {{-- Script Approval Case --}}
        {{-- <script>
            document.addEventListener('DOMContentLoaded', function () {
                fetch('{{ route('dashboard.case-approval-progress') }}')
                    .then(response => response.json())
                    .then(data => {
                        const pendingCount = data.pending ?? 0;
                        const approvedCount = data.approved ?? 0;
                        const total = data.total ?? 0;
                        const percentage = data.percentage ?? 0;

                        document.getElementById('pending-case-count').textContent = pendingCount;
                        document.getElementById('case-progress-bar').style.width = percentage + "%";

                        const progressText = (total === 0)
                            ? "No assigned case approval"
                            : `${approvedCount} of ${total} Case Approved (${percentage}%)`;

                        document.getElementById('case-progress-text').textContent = progressText;
                    })
                    .catch(error => {
                        console.error('Error fetching case approval progress:', error);
                        document.getElementById('case-progress-text').textContent = "Unable to load approval data.";
                    });
            });
        </script> --}}

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                fetch('{{ route('dashboard.case-approval-progress') }}')
                    .then(response => response.json())
                    .then(data => {
                        const pendingCount = data.pending ?? 0;
                        const approvedCount = data.approved ?? 0;
                        const total = data.total ?? 0;
                        const percentage = data.percentage ?? 0;

                        // Menampilkan jumlah total case yg pending (yang harus di-approve)
                        document.getElementById('total-case-to-approve').textContent = pendingCount;

                        // Untuk progress bar dan text lain, jika kamu pakai
                        const progressBar = document.getElementById('case-progress-bar');
                        const progressText = document.getElementById('case-progress-text');

                        if (progressBar) progressBar.style.width = percentage + "%";
                        if (progressText) {
                            progressText.textContent = (total === 0)
                                ? "No assigned case approval"
                                : `${approvedCount} of ${total} Case Approved (${percentage}%)`;
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching case approval progress:', error);
                        const progressText = document.getElementById('case-progress-text');
                        if (progressText) {
                            progressText.textContent = "Unable to load approval data.";
                        }
                    });
            });
        </script>

        {{-- Script MR Approval By Manger --}}
        {{-- <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Untuk Pending Material Request
                fetch('{{ route('ajax.pendingMRCount') }}')
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('pending-mr-count').textContent = data.count;
                    });
            });
        </script> --}}
        {{-- Script MR Approval By Manager --}}
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                fetch('{{ route('ajax.pendingMRCount') }}')
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('pending-mr-count').textContent = data.count;
                    })
                    .catch(error => {
                        console.error('Error fetching pending MR count:', error);
                        document.getElementById('pending-mr-count').textContent = "0";
                    });
            });
        </script>

        {{-- Script woc APPROVAL --}}
        {{-- <script>
            document.addEventListener('DOMContentLoaded', function () {
                fetch('{{ route('ajax.pendingWOCCount') }}')
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('pending-woc-count').textContent = data.count;
                    })
                    .catch(error => {
                        console.error('Error fetching pending WOC count:', error);
                    });
            });
        </script> --}}
        {{-- Script WO Completed (Need Approval) --}}
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                fetch('{{ route('ajax.pendingWOCCount') }}')
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('pending-woc-count').textContent = data.count;
                    })
                    .catch(error => {
                        console.error('Error fetching pending WOC count:', error);
                        document.getElementById('pending-woc-count').textContent = "0";
                    });
            });
        </script>

    @endif
@endsection

      