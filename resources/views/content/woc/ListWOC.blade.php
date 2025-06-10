@extends('layouts.Master')

@section('title', 'BM-Maintenance')
@section('subtitle', 'List Work Order Complition')

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
                                <h3 class="fw-bold m-0 text-gray-800">@yield('subtitle')</h3>
                            </div>
                            <!--end::Title-->
                            <div class=" d-flex align-items-center">
                                <!--begin::Export-->
                                <button type="button" class="btn btn-light-primary me-3" id="exportExcel">
                                        <i class="ki-duotone ki-exit-up fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>Export
                                </button>
                                <!--end::Export-->
                            </div>
                        </div>
                
                        <div class="card-body">
                            <div class="row g-5 align-items-end">
                                <div class="tab-content">
                                    <div id="kt_billing_months" class="card-body p-0 tab-pane fade show active" role="tabpanel" aria-labelledby="kt_billing_months">
                                        <div class="table-responsive">
                                            <table class="table table-row-bordered align-middle gy-5 gs-9" id="WOCTable"> 
                                                <thead>
                                                    <tr class="fw-bold text-dark">
                                                        <th class="min-w-200px text-start text-dark align-middle sortable fs-6" data-column="WOC_No">WOC No</th>
                                                        <th class="min-w-120px text-start align-middle sortable fs-6" data-column="WO_No">WO No</th>
                                                        <th class="min-w-120px text-start align-middle fs-6">Case Name</th>
                                                        <th class="min-w-120px text-start align-middle fs-6">Created By</th>
                                                        <th class="min-w-120px text-start align-middle fs-6">Position</th>
                                                        <th class="min-w-120px text-start align-middle fs-6">Complet Date</th>
                                                        <th class="min-w-120px text-start align-middle fs-6">Complete By</th>
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
        </div>
    </div>

    <div class="page-loader flex-column d-flex position-fixed top-0 start-0 w-100 h-100 d-none justify-content-center align-items-center bg-dark bg-opacity-25" style="z-index: 1055;">
        <div class="text-center">
            <span class="spinner-border text-primary" role="status"></span>
            <div class="mt-3 text-white fw-semibold">Loading...</div>
        </div>
    </div>

    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>

    <script>
        const BASE_URL = "{{ url('/') }}";
    </script>
    
    {{-- Get Data --}}
    <script>
        // Declare Route untuk ke Edit dan Detail Page
        const routeEditWOC = "{{ route('EditWOC', ['wo_no' => 'wo_no']) }}";
        const routeWocDetail = "{{ route('WocDetail', ['wo_no' => 'wo_no']) }}";

        const canEditCase = @json(auth()->user()->can('view cr'));

        $(document).ready(function () {
            const baseUrl = "{{ url('/') }}";

            const table = $("#WOCTable").DataTable({
                ajax: {
                    url: "{{ url('/WorkOrder-Complition/GetSubmittedData') }}",
                    method: "GET",
                    dataSrc: "data",
                    error: function (xhr, status, error) {
                        console.error("AJAX Error:", {
                            status: xhr.status,
                            response: xhr.responseText,
                            error: error
                        });
                        alert("Gagal memuat data Work Order Completion. Cek console untuk detail.");
                    }
                },
                columns: [
                    {
                        data: "WOC_No",
                        className: "text-center align-middle",
                        render: data => `<span class="fw-bold text-primary fs-6">${data ?? 'N/A'}</span>`
                    },
                    {
                        data: "WO_No",
                        className: "text-center align-middle",
                        render: data => `<span class="fw-bold fs-6">${data ?? 'N/A'}</span>`
                    },
                    {
                        data: "case.Case_Name",
                        className: "text-center align-middle",
                        render: data => `<span class="fw-bold fs-6">${data ?? 'N/A'}</span>`
                    },
                    {
                        data: "created_by.Fullname",
                        className: "text-center align-middle",
                        render: data => `<span class="fw-bold fs-6">${data ?? 'N/A'}</span>`
                    },
                    {
                        data: "created_by.position.PS_Name",
                        className: "text-center align-middle",
                        render: data => `<span class="fw-bold fs-6">${data ?? 'N/A'}</span>`
                    },
                    {
                        data: "WO_CompDate",
                        className: "text-center align-middle",
                        render: data => {
                            if (!data) return 'N/A';
                            const d = new Date(data);
                            const formatted = `${String(d.getDate()).padStart(2, '0')}/${String(d.getMonth() + 1).padStart(2, '0')}/${d.getFullYear()} ${String(d.getHours()).padStart(2, '0')}:${String(d.getMinutes()).padStart(2, '0')}`;
                            return `<span class="fw-bold fs-6">${formatted}</span>`;
                        }
                    },
                    {
                        data: "created_by.Fullname",
                        className: "text-center align-middle",
                        render: data => `<span class="fw-bold fs-6">${data ?? 'N/A'}</span>`
                    },
                    {
                        data: "WO_Status",
                        className: "text-center align-middle",
                        render: status => {
                            let badgeClass = "badge-light-secondary text-gray-800";
                            switch (status) {
                                case "OPEN":
                                case "INPROGRESS":
                                    badgeClass = "badge-light-info text-info"; break;
                                case "OPEN_COMPLETION":
                                    badgeClass = "badge-light-warning text-warning"; break;
                                case "SUBMIT":
                                case "SUBMIT_COMPLETION":
                                case "AP1":
                                case "AP2":
                                case "AP3":
                                case "AP4":
                                    badgeClass = "badge-light-primary text-primary"; break;
                                case "REJECT":
                                    badgeClass = "badge-light-danger text-danger"; break;
                                case "DONE":
                                    badgeClass = "badge-light-success text-success"; break;
                                case "CLOSE":
                                    badgeClass = "badge-light-dark text-dark"; break;
                            }
                            return `<span class="badge ${badgeClass} fw-semibold">${status}</span>`;
                        }
                    },
                    {
                        data: "WO_No",
                        className: "text-start align-middle",
                        render: function (data, type, row) {
                            if (!data) return '-';

                            const encodedWONo = btoa(data);

                            // Replace placeholder with actual encoded WO_No
                            const editUrl = routeEditWOC.replace('wo_no', encodedWONo);
                            const detailUrl = routeWocDetail.replace('wo_no', encodedWONo);

                            let buttons = '<div class="d-flex gap-2">';

                            // Tombol Edit
                            if ((row.WO_Status === "OPEN_COMPLETION" || row.WO_Status === "REJECT") && typeof canEditCase !== 'undefined' && canEditCase) {
                            // if (row.WO_Status === "OPEN_COMPLETION" || row.WO_Status === "REJECT") {
                                buttons += `
                                    <a href="${editUrl}" 
                                    class="btn bg-light-warning d-flex align-items-center justify-content-center p-2" 
                                    style="width: 40px; height: 40px;" 
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Work Order">
                                        <i class="ki-duotone ki-pencil fs-3 text-warning">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </a>
                                `;
                            }

                            // Tombol View
                            buttons += `
                                <a href="${detailUrl}" 
                                class="btn bg-light-primary d-flex align-items-center justify-content-center p-2" 
                                style="width: 40px; height: 40px;" 
                                data-bs-toggle="tooltip" data-bs-placement="top" title="View Work Order">
                                    <i class="ki-duotone ki-eye fs-3 text-primary">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                    </i>
                                </a>
                            </div>`;

                            return buttons;
                        }

                    }
                ],
                destroy: true,
                scrollY: "300px",
                scrollX: true,
                scrollCollapse: true
            });

            function showPageLoading() {
                $('.page-loader').removeClass('d-none').fadeIn(200);
            }

            function hidePageLoading() {
                setTimeout(() => {
                    $('.page-loader').fadeOut(200, function () {
                        $(this).addClass('d-none');
                    });
                }, 800);
            }

            $('#applyFilter').on('click', function () {
                const keyword = $('#searchReport').val().toLowerCase();
                const status = $('#statusFilter').val();

                showPageLoading();

                setTimeout(() => {
                    table.search(keyword).draw();
                    table.column(7).search(status === 'all' ? '' : status).draw();
                    hidePageLoading();
                }, 300);
            });

            // Optional: Auto reload
            setInterval(() => {
                table.ajax.reload(null, false);
            }, 10000);
        });
    </script>

   <script> 
        $('#exportExcel').on('click', function () {     
            let status = $('#statusFilter').val() || 'all'; 
            let search = $('#searchReport').val() || ''; 
            let url = new URL(window.location.origin + "/BmMaintenance/public/WorkOrder-Complition/Export"); 
            url.searchParams.append('status', status); 
            url.searchParams.append('search', search); 
            window.open(url, '_blank');  
        }); 
    </script>

@endsection

