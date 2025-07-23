@extends('layouts.Master')

@section('title', 'BM Maintenance')
@section('subtitle', 'Tracking Case List')

@section('content')
{{-- Style Tracking --}}
    <style>
        .stepper-wrapper {
            position: relative;
            overflow-x: auto;
            padding: 10px;
            flex-wrap: nowrap;
            white-space: nowrap;
            scroll-behavior: smooth;
        }

        .step-item {
            position: relative;
            min-width: 80px;
        }

        .step-circle {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background-color: #e0e0e0;
            color: #999;
            font-weight: bold;
            font-size: 14px;
            transition: background-color 0.3s ease, color 0.3s ease;
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
            margin: 0 12px;
            z-index: 1;
        }
    </style>

    <style>
    .step-circle {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background-color: #e0e0e0;
        color: #999;
        font-size: 18px;
        transition: all 0.3s ease-in-out;
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

    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
        <div class="d-flex flex-column flex-column-fluid py-3 py-lg-6">
            <div id="kt_app_content" class="app-content flex-column-fluid">
                <div id="kt_app_content_container" class="app-container container-xxl">
                   
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
                                <!-- Search Input -->
                                <div class="col-lg-5">
                                    <label class="form-label fw-bold">Search Case Number</label>
                                    <input type="text" id="searchReport" class="form-control form-control-solid" placeholder="Enter keyword..." />
                                </div>

                                  <!--begin::Date Range Picker-->
                                <div class="col-lg-5">
                                    <label for="dateFilter" class="form-label fw-bold">Date Range</label>
                                    <input type="text" id="dateFilter" class="form-control form-control-solid" placeholder="Pick a date range" />
                                </div>
                                <!--end::Date Range Picker-->

                                <!-- Apply Button -->
                                <div class="col-lg-2">
                                    <label class="form-label fw-bold text-white">.</label>
                                    <button id="applyFilter" class="btn btn-primary w-100">
                                        <i class="fa-solid fa-filter me-1"></i> Apply
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{-- Filter --}}
                    </div>
                    <!--end::Navbar-->
                   
                    {{-- Table --}}
                    <div class="card">
                        <div class="card-header card-header-stretch justify-content-between align-items-center">
                            <div class="card-title d-flex align-items-center">
                                <h3 class="fw-bold m-0 text-gray-800">@yield('title') - @yield('subtitle')</h3>
                            </div>
                            {{-- <div class="card-toolbar">
                                <button type="button" class="btn btn-sm btn-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#modalCreatePosition">
                                    <i class="bi bi-plus-circle fs-5 me-2"></i> Add New Position
                                </button>
                            </div> --}}
                        </div>

                        <!--begin::Table-->
                        <div class="card-body py-0">
                            <div class="table-responsive">
                                <table id="kt_datatable_both_scrolls" class="table table-striped table-row-bordered gy-5 gs-7">
                                    <thead>
                                        <tr class="fw-semibold fs-6 text-gray-800 text-start">
                                            <th class="min-w-250px">Case No</th>
                                            <th class="min-w-200px">Case Name</th>
                                            <th class="min-w-200px">Created By</th>
                                            <th class="min-w-150px">Department</th>
                                            <th class="min-w-100px">Status</th>
                                            <th class="min-w-150px">Created Date</th>
                                            <th class="min-w-100px">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($cases as $case)
                                            <tr>
                                                <td class="text-start text-primary fw-semibold">{{ $case->Case_No }}</td>
                                                <td class="fw-semibold">{{ $case->Case_Name }}</td>
                                                <td class="fw-semibold">{{ $case->creator->Fullname }}</td>
                                                <td class="fw-semibold">
                                                    {{ $case->creator->position->department->dept_name ?? '-' }}
                                                </td>
                                                <td class="text-start">
                                                    <span class="badge 
                                                        @if(in_array($case->Case_Status, ['AP1', 'AP2', 'DONE'])) badge-success
                                                        @elseif($case->Case_Status === 'REJECT') badge-danger
                                                        @elseif(in_array($case->Case_Status, ['INPROGRESS', 'SUBMIT'])) badge-info text-white
                                                        @else badge-warning
                                                        @endif">
                                                        {{ $case->Case_Status }}
                                                    </span>
                                                </td>
                                                <td class="fw-semibold">{{ $case->created_at->format('d/m/y H:i:s') }}</td>
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
                                                <td colspan="5" class="text-center text-muted">No cases found for this month.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!--end::Table-->
                    </div>
                </div>
            </div>
        </div>
    </div>

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
                <div class="modal-body px-4 py-5">
                    <div class="stepper-wrapper d-flex align-items-center justify-content-start">

                        @php
                            $steps = [
                                ['label' => 'CASE CREATED',        'icon' => 'fa-folder-plus'],
                                ['label' => 'CASE APPROVED',       'icon' => 'fa-thumbs-up'],
                                ['label' => 'WORK ORDER CREATED',  'icon' => 'fa-briefcase'],
                                ['label' => 'MATERIAL REQUEST',    'icon' => 'fa-box-open'],
                                ['label' => 'MR APPROVED',         'icon' => 'fa-check-circle'],
                                ['label' => 'WOC CREATED',         'icon' => 'fa-file-signature'],
                                ['label' => 'WOC APPROVED',        'icon' => 'fa-stamp'],
                                ['label' => 'DONE',                'icon' => 'fa-flag-checkered'],
                            ];
                        @endphp

                        @foreach($steps as $index => $step)
                            <div class="d-flex flex-column align-items-center text-center step-item flex-shrink-0 mx-2"
                                id="step-wrapper-{{ $index }}">
                                <div class="step-circle mb-2 d-flex justify-content-center align-items-center text-white"
                                    id="step-icon-{{ $index }}">
                                    <i class="fas {{ $step['icon'] }}"></i>
                                </div>
                                <div class="step-label text-muted fw-semibold small text-nowrap">
                                    {{ $step['label'] }}
                                </div>
                            </div>

                            @if($index < count($steps) - 1)
                                <div class="step-line d-none d-md-block"></div>
                            @endif
                        @endforeach
                    </div>

                    <div id="no-mr-note" class="text-danger small fst-italic fs-6" style="display: none;">
                        <i class="fas fa-info-circle me-1 text-danger"></i> Material Request tidak dibutuhkan untuk case ini.
                    </div>

                </div>
            </div>
        </div>
    </div> --}}

    <!-- Tracking Case Modal -->
    <div class="modal fade" id="trackModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content rounded-4 shadow-lg border-0">

                <!-- Header -->
                <div class="modal-header bg-primary text-white py-3 px-4">
                    <h5 class="modal-title fw-bold text-white">
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

                    <!-- Details Grid (langsung di Blade) -->
                    <div class="row g-4">
                        <!-- CASE INFO -->
                        <div class="col-md-4">
                            <div class="border rounded p-3 bg-light h-100">
                                <h6 class="fw-bold text-primary mb-3">📄 Case Info</h6>
                                <ul class="list-unstyled mb-0 small lh-lg">
                                    <li><strong>Case No:</strong> <span id="case-no" class="text-dark">-</span></li>
                                    <li><strong>Created By:</strong> <span id="created-by" class="text-dark">-</span></li>
                                    <li><strong>Case Status:</strong> <span id="case-status" class="text-dark">-</span></li>
                                    <li><strong>Case AP1:</strong> <span id="case_ap1" class="text-dark">-</span></li>
                                    <li><strong>Case AP2:</strong> <span id="case_ap2" class="text-dark">-</span></li>
                                </ul>
                            </div>
                        </div>

                        <!-- WORK ORDER -->
                        <div class="col-md-4">
                            <div class="border rounded p-3 bg-light h-100">
                                <h6 class="fw-bold text-primary mb-3">🛠️ Work Order</h6>
                                <ul class="list-unstyled mb-0 small lh-lg">
                                    <li><strong>WO No:</strong> <span id="wo-no" class="text-dark">-</span></li>
                                    <li><strong>WO Status:</strong> <span id="wo-status" class="text-dark">-</span></li>
                                    <li><strong>WO CR BY:</strong> <span id="wo-created_by" class="text-dark">-</span></li>
                                    <li><strong>Need Material:</strong> <span id="need_mat" class="text-dark">-</span></li>
                                    <li><strong>WOC AP1:</strong> <span id="woc_ap1" class="text-dark">-</span></li>
                                    <li><strong>WOC AP2:</strong> <span id="woc_ap2" class="text-dark">-</span></li>
                                </ul>
                            </div>
                        </div>

                        <!-- MATERIAL REQUEST -->
                        <div class="col-md-4">
                            <div class="border rounded p-3 bg-light h-100">
                                <h6 class="fw-bold text-primary mb-3">📦 Material Request</h6>
                                <ul class="list-unstyled mb-0 small lh-lg">
                                    <li><strong>MR No:</strong> <span id="mr-no" class="text-dark">-</span></li>
                                    <li><strong>MR Status:</strong> <span id="mr-status" class="text-dark">-</span></li>
                                    <li><strong>MR AP1:</strong> <span id="mr_ap1" class="text-dark">-</span></li>
                                    <li><strong>MR AP2:</strong> <span id="mr_ap2" class="text-dark">-</span></li>
                                    <li><strong>MR AP3:</strong> <span id="mr_ap3" class="text-dark">-</span></li>
                                    <li><strong>MR AP4:</strong> <span id="mr_ap4" class="text-dark">-</span></li>
                                    <li><strong>MR AP5:</strong> <span id="mr_ap5" class="text-dark">-</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div> <!-- End modal-body -->
            </div>
        </div>
    </div>


    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>

    <!-- DataTables Init -->
    {{-- <script>
        $(document).ready(function () {
            $('#kt_datatable_both_scrolls').DataTable({
                "scrollX": true,
                "pageLength": 10,
                "language": {
                    "search": "Search User:",
                    "lengthMenu": "Show _MENU_ entries",
                    "info": "Showing _START_ to _END_ of _TOTAL_ users",
                }
            });
        });
    </script> --}}

    {{-- Script Tracking Case (Step+Detail) --}}
    {{-- <script>
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
                        const wrapper3 = document.getElementById('step-wrapper-3');
                        const wrapper4 = document.getElementById('step-wrapper-4');
                        if (wrapper3) wrapper3.style.display = 'none';
                        if (wrapper4) wrapper4.style.display = 'none';
                    } else {
                        const wrapper3 = document.getElementById('step-wrapper-3');
                        const wrapper4 = document.getElementById('step-wrapper-4');
                        if (wrapper3) wrapper3.style.display = '';
                        if (wrapper4) wrapper4.style.display = '';
                    }

                    const note = document.getElementById('no-mr-note');
                    if (note) note.style.display = skipMR ? 'block' : 'none';


                })
                .catch(err => {
                    alert('Error loading tracking data');
                    console.error(err);
                });
        }
    </script> --}}

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

                    // Detail Data
                        // Case
                        document.getElementById('case-no').textContent = data.case_no           || '-';
                        document.getElementById('created-by').textContent = data.created_by     || '-';
                        document.getElementById('case-status').textContent = data.case_status   || '-';
                        document.getElementById('case_ap1').textContent = data.case_ap1         || '-';
                        document.getElementById('case_ap2').textContent = data.case_ap2         || '-';

                        // WO/WOC
                        document.getElementById('wo-no').textContent = data.wo_no                   || '-';
                        document.getElementById('wo-status').textContent = data.wo_status           || '-';
                        document.getElementById('wo-created_by').textContent = data.wo_created_by   || '-';
                        document.getElementById('woc_ap1').textContent = data.woc_ap1               || '-';
                        document.getElementById('woc_ap2').textContent = data.woc_ap2               || '-';

                        // MR
                        document.getElementById('mr-no').textContent = data.mr_no || '-';
                        document.getElementById('mr-status').textContent = data.mr_status || '-';
                        document.getElementById('need_mat').textContent = data.need_mat     || '-';
                        document.getElementById('mr_ap1').textContent = data.mr_ap1         || '-';
                        document.getElementById('mr_ap2').textContent = data.mr_ap2         || '-';
                        document.getElementById('mr_ap3').textContent = data.mr_ap3         || '-';
                        document.getElementById('mr_ap4').textContent = data.mr_ap4         || '-';
                        document.getElementById('mr_ap5').textContent = data.mr_ap5         || '-';
                })
                .catch(err => {
                    alert('Error loading tracking data');
                    console.error(err);
                });
        }
    </script>

    {{-- Script Tracking untuk modal --}}
    <script>
        function highlightSteps(step, skipMatReq = false) {
            const totalSteps = 8;
            for (let i = 0; i < totalSteps; i++) {
                const icon = document.getElementById(`step-icon-${i}`);
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

            new bootstrap.Modal(document.getElementById('trackModal')).show();
        }
    </script>

    <script>
        $(document).ready(function () {
            // const table = $('#kt_datatable_both_scrolls').DataTable({
            //     scrollX: true,
            //     pageLength: 10,
            //     order: [[3, "asc"]],
            //     language: {
            //         search: "",
            //         lengthMenu: "Show _MENU_ entries",
            //         info: "Showing _START_ to _END_ of _TOTAL_ cases",
            //     },
            //     dom: 'lrtip' 
            // });

            // Search Case No
            $('#searchReport').on('keyup', function () {
                table.columns(0).search(this.value).draw(); 
            });

            // Date Range Picker
            $('#dateFilter').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    cancelLabel: 'Clear',
                    format: 'DD/MM/YYYY'
                }
            });

            $('#dateFilter').on('apply.daterangepicker', function (ev, picker) {
                $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('YYYY-MM-DD'));

                $.fn.dataTable.ext.search.push(function (settings, data) {
                    const start = picker.startDate;
                    const end = picker.endDate;
                    const createdDate = moment(data[3], 'DD/MM/YYYY HH:mm:ss'); 

                    return createdDate.isBetween(start, end, undefined, '[]');
                });

                table.draw();
            });

            $('#dateFilter').on('cancel.daterangepicker', function () {
                $(this).val('');
                $.fn.dataTable.ext.search.pop();
                table.draw();
            });
        });
    </script>


@endsection



