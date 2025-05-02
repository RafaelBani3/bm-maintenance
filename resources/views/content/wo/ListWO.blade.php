@extends('layouts.Master')

@section('title', 'BM-Maintenance')
@section('subtitle', 'BM Maintenance - List Work Order')

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
                    <table id="kt_datatable_fixed_columns" class="table table-striped table-row-bordered gy-5 gs-7" style="width:100%;">
                        <thead>
                            <tr class="fw-semibold fs-6 text-gray-800">
                                <th class="min-w-150px text-center">WO No</th>
                                <th class="min-w-150px text-center">Case No</th>
                                <th class="min-w-200px text-center">Requested By</th>
                                <th class="min-w-150px text-center">Created Date</th>
                                <th class="min-w-150px text-center">WO Start</th>
                                <th class="min-w-150px text-center">WO End</th>
                                <th class="min-w-150px text-center">Status</th>
                                <th class="min-w-250px text-center">Narrative</th>
                                <th class="min-w-150px text-center">Need Material</th>
                                <th class="min-w-150px text-center">Completed Date</th>
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
        <!--end::Table Card-->
        
        <div class="page-loader flex-column bg-dark bg-opacity-50">
            <span class="spinner-border text-primary" role="status"></span>
            <span class="text-gray-800 fs-6 fw-semibold mt-5">Loading...</span>
        </div>

    </div>
</div>

    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>

    {{-- <script>
        $(document).ready(function () {
            let table = $("#kt_datatable_fixed_columns").DataTable({
                ajax: {
                    url: "{{ route('workOrders.index') }}",
                    dataSrc: ""
                },
                columns: [
                    {
                        data: "WO_No",
                        className: "text-center align-middle",
                        render: function (data) {
                            return `<span class="text-primary fw-bold">${data}</span>`;
                        }
                    },
                    {
                        data: "Case_No",
                        className: "text-center align-middle",
                        render: function (data) {
                            return `<span class="text-primary fw-bold">${data}</span>`;
                        }
                    },
                  
                    {
                        data: "created_by_fullname",
                        className: "text-center align-middle",
                        render: function (data) {
                            return `<span class="text-gray">${data}</span>`;
                        }
                    },
                    {
                        data: "CR_DT",
                        className: "text-center align-middle",
                        render: function (data) {
                            return data ? new Date(data).toLocaleDateString('en-CA') : "N/A";
                        }
                    },
                    {
                        data: "WO_Start",
                        className: "text-center align-middle",
                        render: function (data) {
                            return data ? new Date(data).toLocaleDateString('en-CA') : "N/A";
                        }
                    },
                    {
                        data: "WO_End",
                        className: "text-center align-middle",
                        render: function (data) {
                            return data ? new Date(data).toLocaleDateString('en-CA') : "N/A";
                        }
                    },
                    {
                        data: "WO_Status",
                        className: "text-center align-middle",
                        render: function (data) {
                            let badgeClass = "badge-light-secondary";
                            switch (data) {
                                case "Pending": badgeClass = "badge-secondary"; break;
                                case "OPEN": case "Open_Completion": case "OnProgress": badgeClass = "badge-info"; break;
                                case "AP1":
                                case "AP2":
                                case "AP3":
                                case "AP4":
                                case "AP5": badgeClass = "badge-primary"; break;
                                case "REJECT": badgeClass = "badge-danger"; break;
                                case "CLOSE": badgeClass = "badge-dark"; break;
                                case "Completed": badgeClass = "badge-success"; break;
                            }
                            return `<span class="badge ${badgeClass} fw-semibold">${data}</span>`;
                        }
                    },
                    {
                        data: "WO_Narative",
                        className: "text-center align-middle",
                        defaultContent: "-"
                    },
                    {
                        data: "WO_NeedMat",
                        className: "text-center align-middle",
                        defaultContent: "-"
                    },
                    {
                        data: "WO_CompDate",
                        className: "text-center align-middle",
                        render: function (data) {
                            return data ? new Date(data).toLocaleDateString('en-CA') : "N/A";
                        }
                    },
                    {
                        data: "WO_CompBy",
                        className: "text-center align-middle",
                        defaultContent: "N/A"
                    },
                    {
                        data: "WO_No",
                        className: "text-center align-middle",
                        render: function (data) {
                            const encodedWONo = btoa(data);
                            const baseUrl = window.location.origin + "/BmMaintenance/public"; 
                            return `
                                <a href="${baseUrl}/Work-Order/Detail/${encodedWONo}" class="btn btn-secondary">
                                    <i class="ki-duotone ki-eye">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                    </i>
                                    View
                                </a>`;
                        }
                    }

                ],
                destroy: true,
                scrollY: "300px",
                scrollX: true,
                scrollCollapse: true,
                fixedColumns: {
                    left: 2,
                    right: 1,
                }
            });

            setInterval(function () {
                table.ajax.reload(null, false);
            }, 5000);
    
            function showPageLoading() {
                const loadingEl = document.createElement("div");
                document.body.prepend(loadingEl);
                loadingEl.classList.add("page-loader");
                loadingEl.classList.add("flex-column");
                loadingEl.classList.add("bg-dark");
                loadingEl.classList.add("bg-opacity-25");
                loadingEl.innerHTML = `
                    <span class="spinner-border text-primary" role="status"></span>
                    <span class="text-gray-800 fs-6 fw-semibold mt-5">Loading...</span>
                `;
                $(".page-loader").fadeIn();
            }
    
            function hidePageLoading() {
                $(".page-loader").fadeOut();
            }
    
            $('#applyFilter').on('click', function () {
                let keyword = $('#searchReport').val().toLowerCase();
                let status = $('#statusFilter').val();
                
                showPageLoading();
    
                table.search(keyword).draw();
                table.column(6).search(status === 'all' ? '' : status).draw();
    
                setTimeout(function () {
                    hidePageLoading();
                }, 800);
            });
        });
    </script> --}}

    <script>
        $(document).ready(function () {
            const baseUrl = "{{ url('/') }}"; 

            let table = $("#kt_datatable_fixed_columns").DataTable({
                ajax: {
                    url: "{{ route('workOrders.index') }}",
                    dataSrc: ""
                },
                columns: [
                    {
                        data: "WO_No",
                        className: "text-center align-middle",
                        render: data => `<span class="text-primary fw-bold">${data || 'N/A'}</span>`
                    },
                    {
                        data: "Case_No",
                        className: "text-center align-middle",
                        render: data => `<span class="text-primary fw-bold">${data || 'N/A'}</span>`
                    },
                    {
                        data: "created_by_fullname",
                        className: "text-center align-middle",
                        render: data => `<span class="text-gray">${data || 'N/A'}</span>`
                    },
                    {
                        data: "CR_DT",
                        className: "text-center align-middle",
                        render: data => data ? new Date(data).toLocaleDateString('en-CA') : "N/A"
                    },
                    {
                        data: "WO_Start",
                        className: "text-center align-middle",
                        render: data => data ? new Date(data).toLocaleDateString('en-CA') : "N/A"
                    },
                    {
                        data: "WO_End",
                        className: "text-center align-middle",
                        render: data => data ? new Date(data).toLocaleDateString('en-CA') : "N/A"
                    },
                    {
                        data: "WO_Status",
                        className: "text-center align-middle",
                        render: function (data) {
                            let badgeClass = "badge-light-secondary";
                            switch (data) {
                                case "Pending": badgeClass = "badge-secondary"; break;
                                case "OPEN":
                                case "Open_Completion":
                                case "OnProgress": badgeClass = "badge-info"; break;
                                case "AP1":
                                case "AP2":
                                case "AP3":
                                case "AP4":
                                case "AP5": badgeClass = "badge-primary"; break;
                                case "REJECT": badgeClass = "badge-danger"; break;
                                case "CLOSE": badgeClass = "badge-dark"; break;
                                case "Completed": badgeClass = "badge-success"; break;
                            }
                            return `<span class="badge ${badgeClass} fw-semibold">${data}</span>`;
                        }
                    },
                    {
                        data: "WO_Narative",
                        className: "text-center align-middle",
                        defaultContent: "-"
                    },
                    {
                        data: "WO_NeedMat",
                        className: "text-center align-middle",
                        defaultContent: "-"
                    },
                    {
                        data: "WO_CompDate",
                        className: "text-center align-middle",
                        render: data => data ? new Date(data).toLocaleDateString('en-CA') : "N/A"
                    },
                    {
                        data: "WO_CompBy",
                        className: "text-center align-middle",
                        defaultContent: "N/A"
                    },
                    {
                        data: "WO_No",
                        className: "text-center align-middle",
                        render: function (data) {
                            const safeEncoded = data ? btoa(data) : '';
                            return data ? `
                                <a href="${baseUrl}/Work-Order/Detail/${safeEncoded}" class="btn btn-secondary">
                                    <i class="ki-duotone ki-eye">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                    </i>
                                    View
                                </a>` : '-';
                        }
                    }
                ],
                destroy: true,
                scrollY: "300px",
                scrollX: true,
                scrollCollapse: true,
                fixedColumns: {
                    left: 2,
                    right: 1,
                }
            });

            setInterval(function () {
                table.ajax.reload(null, false);
            }, 10000);

            // Page loader
            function showPageLoading() {
                $(".page-loader").fadeIn();
            }

            function hidePageLoading() {
                $(".page-loader").fadeOut();
            }

            $('#applyFilter').on('click', function () {
                let keyword = $('#searchReport').val().toLowerCase();
                let status = $('#statusFilter').val();

                showPageLoading();

                table.search(keyword).draw();
                table.column(6).search(status === 'all' ? '' : status).draw();

                setTimeout(() => hidePageLoading(), 3000);
            });
        });
    </script>



    <script>
        const BASE_URL = "{{ url('/') }}";
    </script>

@endsection



