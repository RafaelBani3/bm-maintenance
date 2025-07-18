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
    <div class="modal fade" id="trackModal" tabindex="-1" aria-hidden="true">
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



