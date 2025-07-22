@extends('layouts.Master')

{{-- @section('title', 'BM Maintenance') --}}
@section('subtitle', 'Dashboard')
@section('title', 'Dashboard Summary – ' . \Carbon\Carbon::create($year, $month)->format('F Y')) {{-- Ini judul di halaman content --}}

@section('content')

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

        .hover-scale:hover {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            transform: scale(1.02);
            cursor: pointer;
        }

        .step-icon {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            border: 1px solid #ccc;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 5px;
        }

        .border-primary {
            border-color: #0d6efd !important; /* Bootstrap Primary */
        }

        .bg-primary {
            background-color: #0d6efd !important;
        }

        .text-white {
            color: white !important;
        }        
    </style>
    
    {{-- Style Tracking --}}
    <style>

    .table-responsive::-webkit-scrollbar {
        height: 8px;
        width: 8px;
    }
    .table-responsive::-webkit-scrollbar-thumb {
        background: #d1d1d1;
        border-radius: 4px;
    }
    .table-responsive::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    .stepper-wrapper {
        position: relative;
        flex-wrap: nowrap;
        overflow-x: auto;
        padding: 0 10px;
        gap: 0 !important;
    }

    .step-item {
        position: relative;
        z-index: 2;
        min-width: 100px;
    }

    .step-circle {
        width: 40px;
        height: 40px;
        line-height: 40px;
        border-radius: 50%;
        background-color: #e0e0e0;
        color: #999;
        font-weight: bold;
        font-size: 14px;
    }

    .step-circle.active {
        background-color: #0d6efd;
        color: #fff;
        box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.2);
    }

    .step-circle.done {
        background-color: #198754;
        color: #fff;
        box-shadow: 0 0 0 4px rgba(25, 135, 84, 0.2);
    }

    .step-line {
        flex-grow: 1;
        height: 2px;
        background-color: #ccc;
        margin: 0 4px;
        z-index: 1;
    }

    .stepper-track::before {
        content: '';
        position: absolute;
        top: 18px;
        left: 0;
        right: 0;
        height: 3px;
        background-color: #dee2e6;
        z-index: 0;
    }

    .stepper-item {
        z-index: 1;
        position: relative;
    }

    .step-circle {
        width: 36px;
        height: 36px;
        background: #e0e0e0;
        color: #6c757d;
        font-weight: bold;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: 0.3s;
    }
    .step-circle.active {
        background: #0d6efd;
        color: #fff;
    }
    .step-circle.done {
        background: #198754;
        color: #fff;
    }

    .info-card {
        border-radius: 12px;
        padding: 16px;
        height: 100%;
        box-shadow: 0 3px 10px rgba(0,0,0,0.05);
        background-color: #fff;
        transition: 0.3s ease;
    }
    .bg-soft-blue { background-color: #e9f2ff; }
    .bg-soft-green { background-color: #e6f8ed; }
    .bg-soft-yellow { background-color: #fff8e1; }

    .info-header {
        font-weight: 600;
        font-size: 1.05rem;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        border-bottom: 1px solid #dee2e6;
        padding-bottom: 6px;
    }

    .info-body {
        list-style: none;
        padding-left: 0;
        font-size: 0.9rem;
        line-height: 1.6;
    }

    .info-body li span {
        font-weight: 500;
        color: #495057;
        margin-right: 4px;
        display: inline-block;
        width: 100px;
    }

    </style>

    <!--begin::Dashboard Creator-->
    @if(auth()->user()->hasAnyPermission(['view cr', 'view wo', 'view mr']))
        <!-- Main Content -->       
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-xxl">
                
                <div class="d-flex flex-wrap align-items-center gap-3 mb-4">
                    <form method="GET" action="{{ route('Dashboard') }}" class="d-flex gap-2 align-items-center flex-wrap">
                        <label for="month" class="fw-semibold mb-0 me-2">Month Filter:</label>
                        <select name="month" id="month" class="form-select w-auto" onchange="this.form.submit()">
                            @for ($m = 1; $m <= 12; $m++)
                                <option value="{{ $m }}" {{ $m == request('month', now()->month) ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create()->month($m)->format('F') }}
                                </option>
                            @endfor
                        </select>

                        <select name="year" id="year" class="form-select w-auto ms-2" onchange="this.form.submit()">
                            @for ($y = now()->year; $y >= now()->year - 3; $y--)
                                <option value="{{ $y }}" {{ $y == request('year', now()->year) ? 'selected' : '' }}>
                                    {{ $y }}
                                </option>
                            @endfor
                        </select>
                    </form>
                </div>

                <!-- Row 1: Summary Cards -->
                <div class="d-flex flex-wrap gap-5 mb-xl-10">

                    <!-- Total Case Summary - Baru -->
                    <div class="flex-grow-1" style="min-width: 300px; max-width: 600px">
                        <div class="card card-flush shadow-sm h-md-100 border-0">
                            <div class="card-body d-flex flex-column">
                                <!-- Header -->
                                <div class="mb-6">
                                    <h3 class="text-dark fw-bold mb-1">Your Case Summary</h3>
                                    <span class="text-muted">This month</span>
                                </div>

                                <!-- Total Cases -->
                                <div class="d-flex align-items-center mb-5">
                                    <div class="symbol symbol-60px me-4">
                                        <div class="symbol-label bg-primary">
                                            <i class="ki-duotone ki-note-2 fs-3hx text-white">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                                <span class="path4"></span>
                                            </i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="fs-1 fw-bolder text-dark" id="total-case">0</div>
                                        <div class="text-muted">Total Cases Created</div>
                                    </div>
                                </div>

                                <!-- Status Breakdown Pills -->
                                <div class="d-flex flex-column gap-3">
                                    <a href="{{ route('ViewCase', ['status' => 'INPROGRESS']) }}" 
                                        class="d-flex align-items-center justify-content-between p-3 rounded bg-light-success hover-scale"
                                        data-bs-toggle="tooltip" 
                                        title="Cases in Approved status are ready for Work Order creation.">
                                        <div class="d-flex align-items-center">
                                            <i class="ki-duotone ki-check fs-2 text-success me-2"></i>
                                            <span class="fw-semibold text-success">Approved</span>
                                        </div>
                                        <span class="fw-bold text-success" id="total-approved">0</span>
                                    </a>

                                    <a href="{{ route('ViewCase', ['status' => 'REJECT']) }}" 
                                        class="d-flex align-items-center justify-content-between p-3 rounded bg-light-danger hover-scale">
                                        <div class="d-flex align-items-center">
                                            <i class="ki-duotone ki-information-3 fs-2 text-danger me-2"">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                            </i>
                                            <span class="fw-semibold text-danger">Rejected</span>
                                        </div>
                                        <span class="fw-bold text-danger" id="total-rejected">0</span>
                                    </a>
                                </div>

                                <!-- Button Section -->
                                @if ($totalApproved > 0 || $totalRejected > 0)
                                    <div class="mt-5 d-flex flex-column gap-3">
                                        @if ($totalApproved > 0)
                                            <a href="{{ route('CreateWO') }}"
                                                class="btn btn-flex btn-info w-100 py-4 px-5 shadow-sm fw-bold fs-6 text-white hover-scale"
                                                style="transition: 0.3s ease;">
                                                <i class="ki-duotone ki-notepad-edit fs-2hx me-3">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                                <span class="d-flex flex-column align-items-start">
                                                    <span>Create Work Order</span>
                                                    <small class="text-white-50">From {{ $totalApproved }} Approved Case(s)</small>
                                                </span>
                                            </a>
                                        @endif

                                        @if ($totalRejected > 0)
                                            <a href="{{ route('ViewCase') }}?from=rejected"
                                                class="btn btn-flex btn-danger w-100 py-4 px-5 shadow-sm fw-bold fs-6 text-white hover-scale"
                                                style="transition: 0.3s ease;">
                                                <i class="ki-duotone ki-cross-square fs-2hx me-3">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                                <span class="d-flex flex-column align-items-start">
                                                    <span>Review Rejected Cases</span>
                                                    <small class="text-white-50">{{ $totalRejected }} Case(s) Rejected</small>
                                                </span>
                                            </a>
                                        @endif
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>

                    <!-- Total Work Orders - Baru -->
                    <div class="flex-grow-1" style="min-width: 300px; max-width: 100%">
                        <div class="card card-flush shadow-sm h-md-100 border-0">
                            <div class="card-body d-flex flex-column">
                                <!-- Header -->
                                <div class="mb-6">
                                    <h3 class="text-dark fw-bold mb-1">Your Work Order Summary</h3>
                                    <span class="text-muted">This month</span>
                                </div>

                                <!-- Total Work Orders -->
                                <div class="d-flex align-items-center mb-5">
                                    <div class="symbol symbol-60px me-4">
                                        <div class="symbol-label bg-info">
                                            <i class="ki-duotone ki-briefcase fs-3hx text-white">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                                <span class="path4"></span>
                                            </i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="fs-1 fw-bolder text-dark" id="wo-total">0</div>
                                        <div class="text-muted">Total Work Orders Created</div>
                                    </div>
                                </div>

                                <!-- Status Breakdown Pills -->
                                <div class="d-flex flex-column gap-3">
                                    <a href="{{ route('ListWO', ['status' => 'INPROGRESS']) }}"
                                        class="d-flex align-items-center justify-content-between p-3 rounded bg-light-info hover-scale">
                                        <div class="d-flex align-items-center">
                                            <i class="ki-duotone ki-watch fs-2 text-info me-2">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                            <span class="fw-semibold text-info">Submitted</span>
                                        </div>
                                        <span class="fw-bold text-info" id="wo-inprogress">0</span>
                                    </a>

                                    <a href="{{ route('ListWO', ['status' => 'DONE']) }}"
                                        class="d-flex align-items-center justify-content-between p-3 rounded bg-light-success hover-scale">
                                        <div class="d-flex align-items-center">
                                            <i class="ki-duotone ki-check fs-2 text-success me-2"></i>
                                            <span class="fw-semibold text-success">Completed</span>
                                        </div>
                                        <span class="fw-bold text-success" id="wo-done">0</span> 
                                    </a>
                                </div>

                                <!-- Optional Button: Create Material Request -->
                                @if ($totalWOtoMR > 0)
                                    <div class="mt-5">
                                        <a href="{{ route('CreateMR') }}"
                                        class="btn btn-flex btn-primary w-100 py-4 px-5 shadow-sm fw-bold fs-6 text-white hover-scale"
                                        style="transition: 0.3s ease;">
                                            <i class="ki-duotone ki-notepad fs-2hx me-3">   
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                            <span class="d-flex flex-column align-items-start">
                                                <span>Create Material Request</span>
                                                <small class="text-white-50">Based on {{ $totalWOtoMR }} Work Order{{ $totalWOtoMR > 1 ? 's' : '' }}</small>
                                            </span>
                                        </a>
                                    </div>
                                @endif

                                @if ($totalWOtoWOC > 0)
                                    <div class="mt-5">
                                        <a href="{{ route('CreateWOC') }}"
                                        class="btn btn-flex btn-primary w-100 py-4 px-5 shadow-sm fw-bold fs-6 text-white hover-scale"
                                        style="transition: 0.3s ease;">
                                            <i class="ki-duotone ki-notepad fs-2hx me-3">   
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                            <span class="d-flex flex-column align-items-start">
                                                <span>Create Work Order Completion</span>
                                                <small class="text-white-50">Based on {{ $totalWOtoWOC }} Work Order {{ $totalWOtoWOC > 1 ? 's' : '' }}</small>
                                            </span>
                                        </a>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>

                </div>

                <!-- Row 2: WOC DAN MR -->
                <div class="d-flex flex-wrap gap-5 mb-xl-10">
                    
                    <!-- Total WOC -->
                    <div class="flex-grow-1" style="min-width: 300px; max-width: 600px">
                        <div class="card card-flush shadow-sm h-md-100 border-0">
                            <div class="card-body d-flex flex-column">
                                <!-- Header -->
                                <div class="mb-6">
                                    <h3 class="text-dark fw-bold mb-1">Your Work Order Completion Summary</h3>
                                    <span class="text-muted">This month</span>
                                </div>

                                <!-- Total WO-C -->
                                <div class="d-flex align-items-center mb-5">
                                    <div class="symbol symbol-60px me-4">
                                        <div class="symbol-label bg-info">
                                            <i class="ki-duotone ki-briefcase fs-3hx text-white">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                                <span class="path4"></span>
                                            </i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="fs-1 fw-bolder text-dark" id="woc-total"></div>
                                        <div class="text-muted">Total WO Completion</div>
                                    </div>
                                </div>

                                <!-- Status Breakdown Pills -->
                                <div class="d-flex flex-column gap-3">
                                    <a href="{{ route('ListWOCPage', ['status' => 'REJECT_COMPLETION']) }}"
                                        class="d-flex align-items-center justify-content-between p-3 rounded bg-light-danger hover-scale">
                                        <div class="d-flex align-items-center">
                                            <i class="ki-duotone ki-information-3 fs-2 text-danger me-2"">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                            </i>
                                            <span class="fw-semibold text-danger">Rejected</span>
                                        </div>
                                        <span class="fw-bold text-danger" id="woc-reject">{{ $rejectedWoc }}</span>
                                    </a>

                                    <a href="{{ route('ListWOCPage', ['status' => 'DONE']) }}"
                                        class="d-flex align-items-center justify-content-between p-3 rounded bg-light-success hover-scale">
                                        <div class="d-flex align-items-center">
                                            <i class="ki-duotone ki-check fs-2 text-success me-2"></i>
                                            <span class="fw-semibold text-success">Completed</span>
                                        </div>
                                        <span class="fw-bold text-success" id="woc-done">{{ $doneWoc }}</span>
                                    </a>
                                </div>

                                <!-- Button Section -->
                                @if ($rejectedWoc > 0)
                                    <div class="mt-5">
                                        <a href="{{ route('ListWOCPage', ['status' => 'REJECT_COMPLETION']) }}"
                                            class="btn btn-flex btn-danger w-100 py-4 px-5 shadow-sm fw-bold fs-6 text-white hover-scale"
                                            style="transition: 0.3s ease;">
                                            <i class="ki-duotone ki-cross-square fs-2hx me-3">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                            <span class="d-flex flex-column align-items-start">
                                                <span>Review Rejected WO-C</span>
                                                <small class="text-white-50">{{ $rejectedWoc }} Rejected</small>
                                            </span>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Total Material Requests -->
                    @if(auth()->user()->hasAnyPermission(['view mr']))
                    <!-- Total Material Requests - Baru -->
                    <div class="flex-grow-1" style="min-width: 300px; max-width: 100%">
                        <div class="card card-flush shadow-sm h-md-100 border-0">
                            <div class="card-body d-flex flex-column">
                                <!-- Header -->
                                <div class="mb-6">
                                    <h3 class="text-dark fw-bold mb-1">Your Material Request Summary</h3>
                                    <span class="text-muted">This month</span>
                                </div>

                                <!-- Total MR -->
                                <div class="d-flex align-items-center mb-5">
                                    <div class="symbol symbol-60px me-4">
                                        <div class="symbol-label bg-danger">
                                            <i class="ki-duotone ki-parcel-tracking fs-3hx text-white">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                            </i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="fs-1 fw-bolder text-dark" id="mr-total">0</div>
                                        <div class="text-muted">Total Material Requests</div>
                                    </div>
                                </div>

                                <!-- Status Breakdown Pills -->
                                <div class="d-flex flex-column gap-3">
                                    <a href="{{ route('ListMR', ['status' => 'DONE']) }}" 
                                        class="d-flex align-items-center justify-content-between p-3 rounded bg-light-success hover-scale"
                                        data-bs-toggle="tooltip"
                                        title="Approved Material Requests are ready for processing.">
                                        <div class="d-flex align-items-center">
                                            <i class="ki-duotone ki-check fs-2 text-success me-2"></i>
                                            <span class="fw-semibold text-success">Approved</span>
                                        </div>
                                        <span class="fw-bold text-success" id="mr-approved">0</span>
                                    </a>

                                    <a href="{{ route('ListMR', ['status' => 'REJECTED']) }}" 
                                        class="d-flex align-items-center justify-content-between p-3 rounded bg-light-danger hover-scale">
                                        <div class="d-flex align-items-center">
                                            <i class="ki-duotone ki-information-3 fs-2 text-danger me-2"">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                            </i>
                                            <span class="fw-semibold text-danger">Rejected</span>
                                        </div>
                                        <span class="fw-bold text-danger" id="mr-rejected">0</span>
                                    </a>
                                </div>

                                <!-- Button Section -->
                                <div class="mt-5 d-flex flex-column gap-3">
                                    @if ($TotalMRapproved > 0)
                                        <a href="{{ route('CreateWOC') }}"
                                            class="btn btn-flex btn-primary w-100 py-4 px-5 shadow-sm fw-bold fs-6 text-white hover-scale"
                                            style="transition: 0.3s ease;">
                                            <i class="ki-duotone ki-truck fs-2hx me-3">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                            <span class="d-flex flex-column align-items-start">
                                                <span>Create WorkOrder Completion</span>
                                                <small class="text-white-50">From {{ $TotalMRapproved }} Approved WO</small>
                                            </span>
                                        </a>
                                    @endif

                                    @if ($TotalMRrejected > 0)
                                        <a href="{{ route('ListMR') }}"
                                            class="btn btn-flex btn-danger w-100 py-4 px-5 shadow-sm fw-bold fs-6 text-white hover-scale"
                                            style="transition: 0.3s ease;">
                                            <i class="ki-duotone ki-cross-square fs-2hx me-3">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                            <span class="d-flex flex-column align-items-start">
                                                <span>Review Rejected MR</span>
                                                <small class="text-white-50">{{ $TotalMRrejected }} Rejected MR(s)</small>
                                            </span>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                </div>

                <!-- Row 3: Case Tracking -->
                <div class="row gx-5 gx-xl-10 mb-xl-10">
                    <div class="col-md-12 col-xl-12">
                        <div class="card h-md-100 shadow-sm">
                            <div class="card-header p=5 d-flex justify-content-between align-items-center">
                                {{-- <h3 class="card-title fw-bold text-gray-800">
                                    <i class="ki-duotone ki-briefcase me-2 text-primary fs-2"></i>
                                    Tracking Case - {{ \Carbon\Carbon::now()->format('F Y') }}
                                </h3> --}}
                                <h3 class="card-title fw-bold text-gray-800">
                                    <i class="ki-duotone ki-briefcase me-2 text-primary fs-2"></i>
                                    Tracking Case - {{ \Carbon\Carbon::create($year, $month)->format('F Y') }}
                                </h3>
                                <span class="badge badge-light-primary">{{ $cases->total() }} Case(s)</span>
                            </div>

                            <div class="card-body py-0">
                                <div class="table-responsive">
                                    <table id="kt_datatable_both_scrolls" class="table table-striped table-row-bordered gy-5 gs-7">
                                        <thead>
                                            <tr class="fw-semibold fs-6 text-gray-800 text-start">
                                                <th class="min-w-250px">Case No</th>
                                                <th class="min-w-250px">Case Name</th>
                                                <th class="min-w-250px">Status</th>
                                                <th class="min-w-250px">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($cases as $case)
                                                <tr>
                                                    <td class="text-start text-primary fw-semibold">{{ $case->Case_No ?? '-' }}</td>
                                                    <td>{{ $case->Case_Name ?? '-' }} {{ $case->creator->name ?? '-' }}</td>
                                                    <td>
                                                        <span class="badge 
                                                            @if(in_array($case->Case_Status, ['AP1', 'AP2', 'DONE'])) badge-success
                                                            @elseif($case->Case_Status === 'REJECT') badge-danger
                                                            @else badge-warning
                                                            @endif">
                                                            {{ $case->Case_Status ?? '-' }}
                                                        </span>
                                                    </td>

                                                    <td class="text-start">
                                                        <button class="btn btn-sm btn-light-primary px-3 py-2" data-bs-toggle="modal"
                                                            data-bs-target="#trackModal"
                                                            onclick="showTracking('{{ $case->Case_No }}')">
                                                            <i class="fas fa-search me-1"></i> View
                                                        </button>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="text-center text-muted">No cases found for this month.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                {{-- <div class="d-flex justify-content-center my-4">
                                    {{ $cases->links('pagination::bootstrap-5') }}
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Row 4: Charts -->
                <div class="row gx-5 gx-xl-10 mb-xl-10">
                    <!-- Case by Category Chart -->
                    <div class="col-md-4">
                        <div class="card card-flush h-md-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h5 class="text-muted fw-semibold mb-0">Cases by Category (Monthly)</h5>
                                    <div id="case-change"></div>
                                </div>
                                <div id="kt_docs_google_chart_column" style="height: 200px;"></div>
                                <div class="mt-4" id="category-list"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Case vs Work Order Chart -->
                    <div class="col-md-8">
                        <div class="card card-flush h-md-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h5 class="text-muted fw-semibold mb-0">Monthly Case vs Work Order</h5>
                                </div>
                                <div id="kt_apexcharts_1" style="height: 350px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
  
        </div>
        <!--end::Content-->
        
        <!-- Modal: Tracking Case -->
        <div class="modal fade" id="trackModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content rounded-4 shadow-lg border-0">

                    <!-- Header -->
                    <div class="modal-header bg-primary text-white py-3 px-4">
                        <h5 class="modal-title fw-bold text-white  ">
                            <i class="bi bi-search me-2"></i>Tracking Case Progress
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>

                    <!-- Body -->
                    <div class="modal-body p-4">

                        {{-- Stepper --}}
                        <div class="d-flex justify-content-between align-items-center position-relative mb-5 px-2 stepper-track">
                            @php
                                $steps = [
                                    'Case Created', 'Case Approved', 'WO Created', 'Material Request',
                                    'MR Approved', 'WOC Created', 'WOC Approved', 'Done'
                                ];
                            @endphp

                            @foreach ($steps as $i => $label)
                                <div class="text-center flex-fill stepper-item">
                                    <div class="step-circle mx-auto mb-1" id="step-icon-{{ $i }}">
                                        {{ $i + 1 }}
                                    </div>
                                    <small class="d-block text-muted fw-medium text-uppercase small">{{ $label }}</small>
                                </div>
                            @endforeach
                        </div>

                        <!-- Divider -->
                        <hr class="my-4">

                        <!-- Details Grid -->
                        <div class="row g-4">
                            <!-- Case Info -->
                            <div class="col-md-4">
                                <div class="info-card bg-soft-blue">
                                    <div class="info-header text-primary">
                                        <i class="bi bi-folder me-1"></i> Case Info
                                    </div>
                                    <ul class="info-body">
                                        <li><span>Created By:</span> {{ $case->creator->Fullname }}</li>
                                        <li><span>Case Status</span> {{ $case->Case_Status ?? '-' }}</li>
                                        <li><span>AP1:</span> {{ $case->approver1->Fullname ?? '-' }}</li>
                                        <li><span>AP2:</span> {{ $case->approver2->Fullname ?? '-' }}</li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Work Order -->
                            <div class="col-md-4">
                                <div class="info-card bg-soft-green">
                                    <div class="info-header text-success">
                                        <i class="bi bi-gear me-1"></i> Work Order Completion
                                    </div>
                                    <ul class="info-body">
                                        <li><span>Created By:</span> {{ $case->workOrder->creator->Fullname ?? '-' }}</li>
                                        <li><span>Status:</span> {{ $case->workOrder->WO_Status ?? '-' }}</li>
                                        <li><span>Need Material:</span> {{ $case->workOrder->WO_NeedMat == 'Y' ? 'Yes' : 'No' }}</li>
                                        <li><span>AP1:</span> {{ $case->approver1->Fullname ?? '-' }}</li>
                                        <li><span>AP2:</span> {{ $case->approver2->Fullname ?? '-' }}</li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Material Request -->
                            <div class="col-md-4">
                                <div class="info-card bg-soft-yellow">
                                    <div class="info-header text-warning">
                                        <i class="bi bi-box-seam me-1"></i> Material Request
                                    </div>
                                    <ul class="info-body">
                                        @php $mr = $case->workOrder->materialRequest ?? null; @endphp
                                        @if ($mr)
                                            <li><span>Created By:</span> {{ $mr->creator->Fullname }}</li>
                                            <li><span>Status:</span> {{ $mr->MR_Status }}</li>
                                            @foreach (range(1, $mr->MR_APMaxStep) as $n)
                                                <li><span>AP{{ $n }}:</span> {{ $mr->{'approver'.$n}->Fullname ?? '-' }}</li>
                                            @endforeach
                                        @else
                                            <li class="text-muted">No MR data</li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @endif

    <!-- Tracking Case Modal -->    
    {{-- <div class="modal fade" id="trackModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content shadow">
                
                <!-- Header -->
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white fw-bold">Tracking Case Progress</h5>
                    <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal" aria-label="Close">
                        &times;
                    </button>
                </div>

                <!-- Body -->
                <div class="modal-body p-5">
                    <div class="stepper-wrapper d-flex justify-content-between align-items-center">

                        @php
                            $steps = [
                                'CASE CREATED',
                                'CASE APPROVED',
                                'WORK ORDER CREATED',
                                'MATERIAL REQUEST',
                                'MR APPROVED',
                                'WOC CREATED',
                                'WOC APPROVED',
                                'DONE'
                            ];
                        @endphp

                        @foreach($steps as $index => $label)
                            <div class="step-item d-flex flex-column align-items-center text-center flex-fill">
                                <div class="step-circle mb-1" id="step-icon-{{ $index }}">
                                    {{ $index + 1 }}
                                </div>
                                <div class="step-label text-muted fw-semibold small">{{ $label }}</div>
                            </div>

                            @if($index < count($steps) - 1)
                                <div class="step-line"></div>
                            @endif
                        @endforeach

                    </div>

                    <!-- Tracking Detail -->
                    <div class="mt-5">
                        <h6 class="fw-bold mb-3">Approval Details</h6>
                        <div class="row">
                            <div class="col-md-4">
                                <h6 class="text-primary">Case Approval</h6>
                                <ul class="list-unstyled small">
                                    <li>Created By: <strong>{{ $case->Created_By }}</strong></li>
                                    <li>AP1: {{ $case->Case_AP1 ?? '-' }}</li>
                                    <li>AP2: {{ $case->Case_AP2 ?? '-' }}</li>
                                </ul>
                            </div>
                            <div class="col-md-4">
                                <h6 class="text-success">Work Order</h6>
                                @if ($case->workOrder)
                                <ul class="list-unstyled small">
                                    <li>Created By: <strong>{{ $case->workOrder->WO_Created_By }}</strong></li>
                                    <li>AP1: {{ $case->workOrder->WO_AP1 ?? '-' }}</li>
                                    <li>AP2: {{ $case->workOrder->WO_AP2 ?? '-' }}</li>
                                    <li>Status: {{ $case->workOrder->WO_Status }}</li>
                                </ul>
                                @else
                                    <p class="text-muted small">No Work Order</p>
                                @endif
                            </div>
                            <div class="col-md-4">
                                <h6 class="text-warning">Material Request</h6>
                                @if ($case->workOrder && $case->workOrder->materialRequest)
                                <ul class="list-unstyled small">
                                    <li>Created By: <strong>{{ $case->workOrder->materialRequest->MR_Created_By }}</strong></li>
                                    <li>AP1: {{ $case->workOrder->materialRequest->MR_AP1 ?? '-' }}</li>
                                    <li>AP2: {{ $case->workOrder->materialRequest->MR_AP2 ?? '-' }}</li>
                                    <li>AP3: {{ $case->workOrder->materialRequest->MR_AP3 ?? '-' }}</li>
                                    <li>AP4: {{ $case->workOrder->materialRequest->MR_AP4 ?? '-' }}</li>
                                    <li>AP5: {{ $case->workOrder->materialRequest->MR_AP5 ?? '-' }}</li>
                                    <li>Status: {{ $case->workOrder->materialRequest->MR_Status }}</li>
                                </ul>
                                @else
                                    <p class="text-muted small">No Material Request</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div> --}}

    {{-- Script Table Tracking --}}
    <script>
        @if($cases->count() > 0)
            $(document).ready(function() {
                $('#kt_datatable_both_scrolls').DataTable({ 
                    paging: true,
                    searching: true,
                    info: true,
                    lengthChange: false,
                    pageLength: 5,
                });
            });
        @endif
    </script>

    {{-- Dashboard APPROVAL --}}
    @if(auth()->user()->hasAnyPermission(['view cr_ap','view mr_ap']))

        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-xxl">
                
                <!--begin::Row: Approval Summary-->
                <div class="row gx-5 gx-xl-10 mb-10">

                    <!--begin::Card: Total Cases Created-->
                    <div class="col-md-4 col-lg-4 col-xl-4">
                        <a href="{{ route('ApprovalCase') }}" class="card card-flush h-md-100 flex-grow-1 text-decoration-none hover-scale" style="transition: all 0.3s;">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="text-gray-600 fw-bold fs-4">Approval Cases</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span class="fs-3hx fw-bold text-primary me-2" id="total-case-to-approve">0</span>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!--begin::Card: Material Requests Awaiting Approval-->
                    <div class="col-md-4 col-lg-4 col-xl-4">
                        <a href="{{ route('ApprovalListMR') }}" class="card card-flush h-md-100 flex-grow-1 text-decoration-none hover-scale" style="transition: all 0.3s;">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="text-gray-600 fw-bold fs-4">Approval Material Requests</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span class="fs-3hx fw-bold text-info me-2" id="pending-mr-count">0</span>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!--begin::Card: Completed WOs Awaiting Approval-->
                    <div class="col-md-4 col-lg-4 col-xl-4">
                        <a href="{{ route('ApprovalListWOC') }}" class="card card-flush h-md-100 flex-grow-1 text-decoration-none hover-scale" style="transition: all 0.3s;">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="text-gray-600 fw-bold fs-4">Approval WO's Complition</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span class="fs-3hx fw-bold text-success me-2" id="pending-woc-count">0</span>
                                </div>
                            </div>
                        </a>
                    </div>

                </div>
            </div>
        </div>


    @endif

    <!--Script: Dashboard Creator-->
    @if(auth()->user()->hasAnyPermission(['view cr', 'view wo', 'view mr']))
        <script>
            $(document).ready(function () {
                fetchWaitingCounts();

                function fetchWaitingCounts() {
                    $.ajax({
                        url: "{{ route('dashboard.waitingCounts') }}", 
                        method: "GET",
                        success: function (res) {
                            $("#total-case-ap2").text(res.total_case_ap2);
                            $("#total-mr-ap4").text(res.total_mr_ap4);
                        },
                        error: function () {
                            console.error("Failed to fetch waiting data.");
                        }
                    });
                }
            });
        </script>

        <!--Script Case Chart & Total Case-->
        <script type="text/javascript">
            document.addEventListener("DOMContentLoaded", function () {
                // fetch("{{ route('case.summary') }}")
                fetch("{{ route('case.summary') }}?month={{ $month }}&year={{ $year }}")
                    .then(response => response.json())
                    .then(data => {
                        // Tampilkan total case bulan ini
                        const total = data.totalCases ?? 0;
                        const approved = data.totalApproved ?? 0;
                        const rejected = data.totalRejected ?? 0;

                        document.getElementById("total-approved").textContent = approved;
                        document.getElementById("total-rejected").textContent = rejected;

                        const totalCaseEl = document.getElementById("total-case");
                        if (totalCaseEl) totalCaseEl.textContent = total;

                        // Data Kategori dan Setup Warna
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
                            if (total > 0) isAllZero = false;

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

                        // Load & Gambar Chart
                        google.charts.load('current', { 'packages': ['corechart'] });
                        google.charts.setOnLoadCallback(drawChart);

                        function drawChart() {
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
                        }

                    })
                    .catch(err => {
                        console.error("Gagal memuat data dashboard:", err);
                    });
            });
        </script>

        {{-- Script WO hanya Tampil total data WO --}}
        <script type="text/javascript">
            document.addEventListener("DOMContentLoaded", function () {
                // Parse query params for month & year, fallback to current
                const urlParams = new URLSearchParams(window.location.search);
                const month = urlParams.get('month') || new Date().getMonth() + 1; // JS month is 0-based
                const year = urlParams.get('year') || new Date().getFullYear();

                const fetchUrl = `{{ route('dashboard.wo-summary') }}?month=${month}&year=${year}`;

                fetch(fetchUrl)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById("wo-total").textContent = data.total ?? 0;
                        document.getElementById("wo-inprogress").textContent = data.inprogress ?? 0;
                        document.getElementById("wo-done").textContent = data.done ?? 0;
                    })
                    .catch(error => console.error("Gagal ambil data WO:", error));
            });
        </script>

        {{-- SCRIPT MR --}}
        <script>
            $(document).ready(function () {
                const urlParams = new URLSearchParams(window.location.search);
                const month = urlParams.get('month') || new Date().getMonth() + 1;
                const year = urlParams.get('year') || new Date().getFullYear();

                const fetchUrl = `{{ route('Dashboard.MR.Summary') }}?month=${month}&year=${year}`;

                $.ajax({
                    url: fetchUrl,
                    type: "GET",
                    success: function (data) {
                        $("#mr-total").text(data.total ?? 0);
                        $("#mr-approved").text(data.approved ?? 0);
                        $("#mr-rejected").text(data.rejected ?? 0);
                    },
                    error: function (xhr) {
                        console.error("Gagal mengambil data Material Request", xhr);
                    }
                });
            });
        </script>

        {{-- SCRIPT WOC --}}
        <script>
            $(document).ready(function () {
                const urlParams = new URLSearchParams(window.location.search);
                const month = urlParams.get('month') || new Date().getMonth() + 1;
                const year = urlParams.get('year') || new Date().getFullYear();

                const apiUrl = "{{ route('WOC.Summary') }}" + `?month=${month}&year=${year}`;

                $.ajax({
                    url: apiUrl,
                    type: 'GET',
                    success: function (response) {
                        $('#woc-total').text(response.total ?? 0);
                        $('#woc-done').text(response.doneWoc ?? 0);
                        $('#woc-reject').text(response.rejectedWoc ?? 0); 
                    },
                    error: function (xhr) {
                        console.error('Failed to load WOC Summary:', xhr.responseText);
                    }
                });
            });
        </script>

        {{-- Tracking Case berdasarkan data --}}
        <script>
            function showTracking(caseNo) {
                const encodedCaseNo = btoa(caseNo);
                const fetchUrl = "{{ route('track.case') }}?case=" + encodeURIComponent(encodedCaseNo);

                fetch(fetchUrl)
                    .then(res => {
                        if (!res.ok) throw new Error("Network response was not ok");
                        return res.json();
                    })
                    .then(data => {
                        const currentStep = data.step;
                        const skipMR = data.skip_mat_req;

                        for (let i = 0; i < 8; i++) {
                            const icon = document.getElementById(`step-icon-${i}`);
                            if (icon) {
                                icon.style.backgroundColor = '#eee';
                                icon.style.color = '#666';
                                icon.style.display = '';
                            }
                        }

                        for (let i = 0; i < currentStep; i++) {
                            const icon = document.getElementById(`step-icon-${i}`);
                            if (icon) {
                                icon.style.backgroundColor = '#0d6efd';
                                icon.style.color = '#fff';
                            }
                        }

                        if (skipMR) {
                            const icon3 = document.getElementById('step-icon-3');
                            const icon4 = document.getElementById('step-icon-4');
                            if (icon3) icon3.style.display = 'none';
                            if (icon4) icon4.style.display = 'none';
                        }
                    })
                    .catch(err => {
                        alert('Error loading tracking data');
                        console.error(err);
                    });
            }
        </script>

        {{-- Script Tracking untuk modal --}}
        <script>
            function highlightSteps(step, skipMatReq = false, approvalData = null) {
                const totalSteps = 8;
                for (let i = 0; i < totalSteps; i++) {
                    const icon = document.getElementById(`step-icon-${i}`);
                    if (!icon) continue;

                    icon.classList.remove('active', 'done');
                    icon.style.backgroundColor = '#e0e0e0';
                    icon.style.color = '#999';

                    if (i < step - 1) {
                        icon.classList.add('done');
                    } else if (i === step - 1) {
                        icon.classList.add('active');
                    }

                    // Optional: hide MR step if skipped
                    if (skipMatReq && i === 3) {
                        icon.closest('.step-item').style.display = 'none';
                    } else if (i === 3) {
                        icon.closest('.step-item').style.display = '';
                    }
                }

                // Inject approval detail if available
                const detailSection = document.getElementById("approval-detail-section");
                if (approvalData && detailSection) {
                    const caseInfo = approvalData.case || {};
                    const woInfo = approvalData.wo || {};
                    const mrInfo = approvalData.mr || {};

                    detailSection.classList.remove("d-none");
                    detailSection.innerHTML = `
                        <h6 class="fw-bold mb-3">Approval Details</h6>
                        <div class="row">
                            <div class="col-md-4">
                                <h6 class="text-primary">Case Approval</h6>
                                <ul class="list-unstyled small">
                                    <li>Created By: <strong>${caseInfo.created_by || '-'}</strong></li>
                                    <li>AP1: ${caseInfo.ap1 || '-'}</li>
                                    <li>AP2: ${caseInfo.ap2 || '-'}</li>
                                </ul>
                            </div>
                            <div class="col-md-4">
                                <h6 class="text-success">Work Order</h6>
                                ${woInfo.created_by ? `
                                <ul class="list-unstyled small">
                                    <li>Created By: <strong>${woInfo.created_by}</strong></li>
                                    <li>AP1: ${woInfo.ap1 || '-'}</li>
                                    <li>AP2: ${woInfo.ap2 || '-'}</li>
                                    <li>Status: ${woInfo.status || '-'}</li>
                                </ul>` : `<p class="text-muted small">No Work Order</p>`}
                            </div>
                            <div class="col-md-4">
                                <h6 class="text-warning">Material Request</h6>
                                ${mrInfo.created_by ? `
                                <ul class="list-unstyled small">
                                    <li>Created By: <strong>${mrInfo.created_by}</strong></li>
                                    <li>AP1: ${mrInfo.ap1 || '-'}</li>
                                    <li>AP2: ${mrInfo.ap2 || '-'}</li>
                                    <li>AP3: ${mrInfo.ap3 || '-'}</li>
                                    <li>AP4: ${mrInfo.ap4 || '-'}</li>
                                    <li>AP5: ${mrInfo.ap5 || '-'}</li>
                                    <li>Status: ${mrInfo.status || '-'}</li>
                                </ul>` : `<p class="text-muted small">No Material Request</p>`}
                            </div>
                        </div>
                    `;
                }

                new bootstrap.Modal(document.getElementById('trackModal')).show();
            }
        </script>

        <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css"/>
        <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>

        {{-- Grafik/Chart --}}
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

    @if (session('session_expired'))
		<script>
			window.onload = () => {
				Swal.fire({
					icon: 'info',
					title: 'Session Expired',
					text: '{{ session('session_expired') }}',
					confirmButtonText: 'Login Ulang'
				});
			};
		</script>
	@endif

    @if(session('warning'))
        <script>
            Swal.fire({
                icon: 'warning',
                title: 'Warning',
                text: '{{ session('warning') }}',
                confirmButtonText: 'OK'
            });
        </script>
    @endif

@endsection
