@extends('layouts.Master')

@section('title', 'BM-Maintenance')
@section('subtitle', 'BM Maintenance - List Material Request')

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
<<<<<<< HEAD
                                    <label class="form-label fw-bold text-white">.</label> <!-- agar tetap sejajar -->
=======
                                    <label class="form-label fw-bold text-white">.</label> 
>>>>>>> ff25b43 (Update)
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
<<<<<<< HEAD
                                <h3 class="fw-bold m-0 text-gray-800">Case List</h3>
                            </div>
                            <!--end::Title-->
=======
                                <h3 class="fw-bold m-0 text-gray-800">Material Request List</h3>
                            </div>
                          
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

>>>>>>> ff25b43 (Update)
                        </div>
                
                        <div class="card-body">
                            <div class="row g-5 align-items-end">
                                <div class="tab-content">
                                    <div id="kt_billing_months" class="card-body p-0 tab-pane fade show active" role="tabpanel" aria-labelledby="kt_billing_months">
                                        <div class="table-responsive">
                                            <table class="table table-row-bordered align-middle gy-5 gs-9" id="matreq_table"> 
                                                <thead>
                                                    <tr class="fw-semibold fs-6 text-gray-800">
<<<<<<< HEAD
                                                        <th class="min-w-150px ">MR No</th>
                                                        <th class="min-w-150px ">WO No</th>
                                                        <th class="min-w-150px ">Case No</th>
                                                        <th class="min-w-150px ">Created Date</th>
                                                        <th class="min-w-150px ">Status</th>
                                                        <th class="min-w-100px ">Urgent</th>
                                                        <th class="min-w-200px ">Created By</th>
                                                        <th class="min-w-100px ">Action</th>
=======
                                                        <th class="min-w-140px ">MR No</th>
                                                        <th class="min-w-140px ">WO No</th>
                                                        <th class="min-w-150px ">Case No</th>
                                                        <th class="min-w-130px ">Created Date</th>
                                                        <th class="min-w-50px ">Status</th>
                                                        <th class="min-w-30px ">Urgent</th>
                                                        <th class="min-w-90px ">Created By</th>
                                                        <th class="min-w-50px ">Action</th>
>>>>>>> ff25b43 (Update)
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
<<<<<<< HEAD
                        
=======
>>>>>>> ff25b43 (Update)
                    </div>
                    <!--end::Navbar-->
                </div>
            </div>
        </div>
    </div>
<<<<<<< HEAD

{{-- DESIGN LAMA --}}
    {{-- <div id="kt_app_content" class="app-content flex-column-fluid">
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
            <!--end::Filter  Card-->

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
                        <table id="matreq_table" class="table table-striped table-row-bordered gy-5 gs-7" style="width:100%;">
                            <thead>
                                <tr class="fw-semibold fs-6 text-gray-800">
                                    <th class="min-w-150px text-center">MR No</th>
                                    <th class="min-w-150px text-center">WO No</th>
                                    <th class="min-w-150px text-center">Case No</th>
                                    <th class="min-w-150px text-center">Created Date</th>
                                    <th class="min-w-150px text-center">Status</th>
                                    <th class="min-w-100px text-center">Urgent</th>
                                    <th class="min-w-200px text-center">Created By</th>
                                    <th class="min-w-100px text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!--end::Table Card-->
        </div>
    </div> --}}

                
    <div class="page-loader flex-column bg-dark bg-opacity-50">
        <span class="spinner-border text-primary" role="status"></span>
        <span class="text-gray-800 fs-6 fw-semibold mt-5">Loading...</span>
=======
                
    <div class="page-loader flex-column d-flex position-fixed top-0 start-0 w-100 h-100 d-none justify-content-center align-items-center bg-dark bg-opacity-25" style="z-index: 1055;">
        <div class="text-center">
            <span class="spinner-border text-primary" role="status"></span>
            <div class="mt-3 text-white fw-semibold">Loading...</div>
        </div>
>>>>>>> ff25b43 (Update)
    </div>

    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>

<<<<<<< HEAD

=======
>>>>>>> ff25b43 (Update)
    <script>
        const BASE_URL = "{{ url('/') }}";
    </script>

    {{-- Ambil Data MR ke Table --}}
<<<<<<< HEAD
    <script>
        $(document).ready(function () {
            $.ajax({
                url: '{{ route("GetDataMR") }}',
                method: 'GET',
                dataType: 'json',
                success: function (data) {
                    let tableBody = '';
                    const baseUrl = window.location.origin + "/BmMaintenance/public";
                    
                    data.forEach(item => {
                        const encodedMRNo = btoa(item.MR_No); 
                        tableBody += `
                            <tr>
                                <td class="text-start text-primary">${item.MR_No}</td>
                                <td class="text-start text-primary">${item.WO_No}</td>
                                <td class="text-start text-primary">${item.Case_No}</td>
                                <td class="text-start">${item.MR_Date}</td>
                                <td class="text-start">${item.MR_Status}</td>
                                <td class="text-start">
                                    ${item.MR_IsUrgent === 'Y' 
                                        ? '<span class="badge bg-danger">Yes</span>' 
                                        : '<span class="badge bg-secondary">No</span>'
                                    }
                                </td>
                                <td class="text-start">${item.CreatedBy ?? '-'}</td>
                                <td class="text-start">
                                    <a href="${baseUrl}/Material-Request/Detail/${encodedMRNo}" class="btn btn-sm btn-secondary fs-5 hover-scale d-flex align-items-center">
=======
    {{-- <script>
        $(document).ready(function () {
            const baseUrl = "{{ url('/') }}";

            const table = $("#matreq_table").DataTable({
                ajax: {
                    url: "{{ route('GetDataMR') }}",
                    method: "GET",
                    dataSrc: "",
                    error: function (xhr, status, error) {
                        console.error("AJAX Load Error:", {
                            status: xhr.status,
                            response: xhr.responseText,
                            error: error
                        });

                        alert("Terjadi kesalahan saat memuat data. Silakan cek console atau hubungi admin.");
                    }
                },

                columns: [
                    {
                        data: "MR_No",
                        className: "text-center align-middle",
                        render: data => `<span class="text-primary fw-bold">${data ?? 'N/A'}</span>`
                    },
                    {
                        data: "WO_No",
                        className: "text-center align-middle",
                        render: data => `<span class="text-primary fw-bold">${data ?? 'N/A'}</span>`
                    },
                    {
                        data: "Case_No",
                        className: "text-center align-middle",
                        render: data => `<span class="text-primary fw-bold">${data ?? 'N/A'}</span>`
                    },
                    {
                        data: "MR_Date",
                        className: "text-center align-middle",
                        render: data => data ? new Date(data).toLocaleDateString('en-CA') : 'N/A'
                    },
                    {
                        data: "MR_Status",
                        className: "text-center align-middle",
                        render: function (status) {
                            let badgeClass = "badge-light-secondary text-gray-800";
                            switch (status) {
                                case "OPEN": badgeClass = "badge-light-warning text-warning"; break;
                                case "SUBMIT":
                                case "AP1":
                                case "AP2":
                                case "AP3":
                                case "AP4":
                                case "AP5": badgeClass = "badge-light-primary text-primary"; break;
                                case "INPROGRESS": badgeClass = "badge-light-info text-info"; break;
                                case "CLOSE":
                                case "DONE": badgeClass = "badge-light-success text-success"; break;
                                case "REJECT": badgeClass = "badge-light-danger text-danger"; break;
                            }
                            return `<span class="badge ${badgeClass} fw-semibold">${status}</span>`;
                        }
                    },
                    {
                        data: "MR_IsUrgent",
                        className: "text-center align-middle",
                        render: val => val === 'Y'
                            ? '<span class="badge bg-danger fs-7">Yes</span>'
                            : '<span class="badge bg-secondary fs-7">No</span>'
                    },
                    {
                        data: "CreatedBy",
                        className: "text-center align-middle",
                        render: data => data ?? '-'
                    },
                    {
                        data: "MR_No",
                        className: "text-center align-middle",
                        render: function (data) {
                            if (!data) return '-';
                            try {
                                const encoded = btoa(data);
                                return `
                                    <a href="${baseUrl}/Material-Request/Detail/${encoded}" class="btn btn-sm btn-secondary hover-scale">
>>>>>>> ff25b43 (Update)
                                        <i class="ki-duotone ki-eye">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
<<<<<<< HEAD
                                        </i>
                                        View
                                    </a>
                                </td>
                            </tr>`;
                    });
                    $('#matreq_table tbody').html(tableBody);
                },
                error: function (xhr, status, error) {
                    console.error("Gagal memuat data MR:", error);
                }
=======
                                        </i> View
                                    </a>`;
                            } catch (err) {
                                console.error("Encoding error:", err);
                                return '-';
                            }
                        }
                    }
                ],
                destroy: true,
                scrollY: "300px",
                scrollX: true,
                scrollCollapse: true,    
            });

            setInterval(() => {
                table.ajax.reload(null, false);
            }, 10000);

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
                    table.column(4).search(status === 'all' ? '' : status).draw(); 
                    hidePageLoading();
                }, 300);
            });
        });
    </script> --}}
    <script>
        $(document).ready(function () {
            const baseUrl = "{{ url('/') }}";

            const table = $("#matreq_table").DataTable({
                ajax: {
                    url: "{{ route('GetDataMR') }}",
                    method: "GET",
                    dataSrc: "",
                    error: function (xhr, status, error) {
                        console.error("AJAX Error:", {
                            status: xhr.status,
                            response: xhr.responseText,
                            error: error
                        });
                        alert("Terjadi kesalahan saat memuat data. Silakan cek console.");
                    }
                },
                columns: [
                    {
                        data: "MR_No",
                        className: "text-center align-middle",
                        render: data => `<span class="text-primary fw-bold">${data ?? 'N/A'}</span>`
                    },
                    {
                        data: "WO_No",
                        className: "text-center align-middle",
                        render: data => `<span class="text-primary fw-bold">${data ?? 'N/A'}</span>`
                    },
                    {
                        data: "Case_No",
                        className: "text-center align-middle",
                        render: data => `<span class="text-primary fw-bold">${data ?? 'N/A'}</span>`
                    },
                    {
                        data: "MR_Date",
                        className: "text-center align-middle",
                        render: data => data ? new Date(data).toLocaleDateString('en-CA') : 'N/A'
                    },
                    {
                        data: "MR_Status",
                        className: "text-center align-middle",
                        render: function (status) {
                            let badgeClass = "badge-light-secondary text-gray-800";
                            switch (status) {
                                case "OPEN": badgeClass = "badge-light-warning text-warning"; break;
                                case "SUBMIT":
                                case "AP1":
                                case "AP2":
                                case "AP3":
                                case "AP4":
                                case "AP5": badgeClass = "badge-light-primary text-primary"; break;
                                case "INPROGRESS": badgeClass = "badge-light-info text-info"; break;
                                case "CLOSE":
                                case "DONE": badgeClass = "badge-light-success text-success"; break;
                                case "REJECT": badgeClass = "badge-light-danger text-danger"; break;
                            }
                            return `<span class="badge ${badgeClass} fw-semibold">${status}</span>`;
                        }
                    },
                    {
                        data: "MR_IsUrgent",
                        className: "text-center align-middle",
                        render: val => val === 'Y'
                            ? '<span class="badge bg-danger fs-7">Yes</span>'
                            : '<span class="badge bg-secondary fs-7">No</span>'
                    },
                    {
                        data: "CreatedBy",
                        className: "text-center align-middle",
                        render: data => data ?? '-'
                    },
                    {
                        data: "MR_No",
                        className: "text-center align-middle",
                        render: function (data) {
                            if (!data) return '-';
                            try {
                                const encoded = btoa(unescape(encodeURIComponent(data)));
                                return `
                                    <a href="${baseUrl}/Material-Request/Detail/${encoded}" class="btn btn-sm btn-secondary hover-scale">
                                        <i class="ki-duotone ki-eye">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i> View
                                    </a>`;
                            } catch (err) {
                                console.error("Encoding error:", err);
                                return '-';
                            }
                        }
                    }
                ],
                destroy: true,
                scrollY: "300px",
                scrollX: true,
                scrollCollapse: true
            });

            setInterval(() => {
                table.ajax.reload(null, false);
            }, 10000);

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
                    table.column(4).search(status === 'all' ? '' : status).draw();
                    hidePageLoading();
                }, 300);
>>>>>>> ff25b43 (Update)
            });
        });
    </script>

<<<<<<< HEAD
    


=======
    {{-- Script Button Export --}}
    <script> 
        $('#exportExcel').on('click', function () {     
            let status = $('#statusFilter').val() || 'all'; 
            let search = $('#searchReport').val() || ''; 
            let url = new URL(window.location.origin + "/BmMaintenance/public/Material-Request/Export"); 
            url.searchParams.append('status', status); 
            url.searchParams.append('search', search); 
            window.open(url, '_blank');  
        }); 
    </script>

    {{-- Script Choose Date Range --}}
    <script>
        $('#dateFilter').daterangepicker({
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear',
                format: 'YYYY-MM-DD'
            }
        });
        $('#dateFilter').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
        });
        $('#dateFilter').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });
    </script>
>>>>>>> ff25b43 (Update)

@endsection
