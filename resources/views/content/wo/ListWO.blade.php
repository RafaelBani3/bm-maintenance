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

<<<<<<< HEAD
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
=======
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
                                            <th class="min-w-150px text-center">WO No</th>
                                            <th class="min-w-150px text-center">Case No</th>
                                            <th class="min-w-150px text-center">Requested By</th>
                                            <th class="min-w-150px text-center">Created Date</th>
                                            <th class="min-w-150px text-center">WO Start</th>
                                            <th class="min-w-150px text-center">WO End</th>
                                            <th class="min-w-150px text-center">Status</th>
                                            <th class="min-w-250px text-center">Narrative</th>
                                            <th class="min-w-150px text-center">Need Material</th>
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

>>>>>>> ff25b43 (Update)



    <script>
        const BASE_URL = "{{ url('/') }}";
    </script>

@endsection



