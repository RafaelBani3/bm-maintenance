@extends('layouts.Master')

@section('title', 'BM-Maintenance')
@section('subtitle', 'List Approval Work Order Complition')

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

    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>

    <script>
        const BASE_URL = "{{ url('/') }}";
    </script>

    {{-- <script>
    $(document).ready(function () {
        $('#statusFilter').select2({
            placeholder: "Pilih Status",
            allowClear: true,
            width: 'resolve'
        });

        let table = $("#woc_table").DataTable({
            ajax: {
                url: '/WorkOrder-Complition/getApprovalWOC',
                dataSrc: "",
                error: function (xhr, error, thrown) {
                    console.log("AJAX Error:", xhr.responseText);
                    alert("Gagal mengambil data Work Order Completion. Silakan cek console untuk detail.");
                }
            },
            columns: [
                { data: "WOC_No", className: "text-primary fw-semibold text-start align-middle" },
                { data: "WO_No", className: "text-primary fw-semibold text-start align-middle" },
                { 
                    data: "case.Case_Name", 
                    className: "fw-semibold text-start align-middle",
                    render: function (data) {
                        return data ?? '-';
                    }
                },
                { 
                    data: "created_by.Fullname", 
                    className: "fw-semibold text-start align-middle",
                    render: function (data) {
                        return data ?? '-';
                    }
                },
                { 
                    data: "created_by.position.Position_Name", 
                    className: "fw-semibold text-start align-middle",
                    render: function (data) {
                        return data ?? '-';
                    }
                },
                {
                    data: "WO_Compdate",
                    className: "fw-semibold text-start align-middle",
                    render: function (data) {
                        if (!data) return '-';
                        const date = new Date(data);
                        const day = date.getDate().toString().padStart(2, '0');
                        const month = (date.getMonth() + 1).toString().padStart(2, '0');
                        const year = date.getFullYear();
                        return `${day}/${month}/${year}`;
                    }
                },
                {
                    data: "WO_CompBy",
                    className: "fw-semibold text-start align-middle",
                    render: function (data) {
                        return data ?? '-';
                    }
                },
                {
                    data: "WO_Status",
                    className: "fw-semibold text-start align-middle",
                    render: function (data) {
                        return `<span class="badge badge-light-primary">${data}</span>`;
                    }
                },
                {
                    data: "WOC_No",
                    className: "text-start align-middle",
                    render: function (data) {
                        const baseUrl = window.location.origin + "/BmMaintenance/public";
                        const encoded = btoa(data);
                        return `
                            <a href="${baseUrl}/WorkOrder-Complition/Approval-Detail/${encoded}" class="btn btn-secondary hover-scale">
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
            scrollY: "300px",
            scrollX: true,
            scrollCollapse: true,
            fixedColumns: {
                left: 2,
                right: 1
            }
        });

        $('#applyFilter').on('click', function () {
            $('#page_loader').css('display', 'flex');

            setTimeout(function () {
                let statusFilter = $('#statusFilter').val();
                table.column(7).search(statusFilter === 'all' || statusFilter === null ? '' : statusFilter).draw();

                $('#page_loader').css('display', 'none');
            }, 500);
        });
    });
</script> --}}

    
    <script>
        $(document).ready(function () {
            $('#WOCTable').DataTable({
                destroy: true,
                scrollY: "300px",
                scrollX: true,
                scrollCollapse: true,
                fixedColumns: {
                    leftColumns: 2,
                    rightColumns: 1
                },
                ajax: {
                    url: "{{ url('/WorkOrder-Complition/getApprovalWOC') }}",
                    type: "GET",
                    dataSrc: "data"
                },
                columns: [
                    {
                        data: 'WOC_No',
                        render: function (data) {
                            return `<span class="fw-bold text-primary fs-6">${data}</span>`;
                        }
                    },
                    {
                        data: 'WO_No',
                        render: function (data) {
                            return `<span class="fw-bold fs-6">${data}</span>`;
                        }
                    },
                    {
                        data: 'case.Case_Name',
                        render: function (data) {
                            return `<span class="fw-bold fs-6">${data}</span>`;
                        }
                    },
                    {
                        data: 'created_by.Fullname',
                        render: function (data) {
                            return `<span class="fw-bold fs-6">${data}</span>`;
                        }
                    },
                    {
                        data: 'created_by.position.PS_Name',
                        render: function (data) {
                            return `<span class="fw-bold fs-6">${data}</span>`;
                        }
                    },
                    {
                        // data: 'WO_CompDate',
                        // render: function (data) {
                        //     return `<span class="fw-bold fs-6">${data}</span>`;
                        // }
                         data: 'WO_CompDate',
                        render: function (data) {
                            if (!data) return ''; 
                            const dateObj = new Date(data);
                            const day = String(dateObj.getDate()).padStart(2, '0');
                            const month = String(dateObj.getMonth() + 1).padStart(2, '0');
                            const year = dateObj.getFullYear();
                            const hours = String(dateObj.getHours()).padStart(2, '0');
                            const minutes = String(dateObj.getMinutes()).padStart(2, '0');
                            return `<span class="fw-bold fs-6">${day}/${month}/${year} ${hours}:${minutes}</span>`;
                        }
                    },
                    {
                        data: 'created_by.Fullname',
                        render: function (data) {
                            return `<span class="fw-bold fs-6">${data}</span>`;
                        }
                    },
                    {
                        data: 'WO_Status',
                        render: function (data) {
                            let badgeClass = 'badge badge-light-secondary text-gray-900'; 

                            switch (data) {
                                case 'OPEN':
                                case 'INPROGRESS':
                                    badgeClass = 'badge badge-light-info text-info';
                                    break;
                                case 'Open_Completion':
                                    badgeClass = 'badge badge-light-warning text-warning';
                                    break;
                                case 'Submit':
                                case 'SUBMIT_COMPLETION':
                                case 'AP1':
                                case 'AP2':
                                case 'AP3':
                                case 'AP4':
                                    badgeClass = 'badge badge-light-primary text-primary';
                                    break;
                                case 'Reject':
                                    badgeClass = 'badge badge-light-danger text-danger';
                                    break;
                                case 'DONE':
                                    badgeClass = 'badge badge-light-success text-success';
                                    break;
                                case 'CLOSE':
                                    badgeClass = 'badge badge-light-dark text-dark';
                                    break;
                            }

                            return `<span class="badge badge-${badgeClass} fw-bold fs-6">${data}</span>`;
                        }
                    },
                    {
                        data: "WO_No",
                        render: function (data, type, row) {
                            const safeEncoded = data ? btoa(data) : '';
                            return `<a href="${BASE_URL}/WorkOrder-Complition/DetailApprovalWOC/${safeEncoded}" class="btn btn-secondary hover-scale">
                                        <i class="ki-duotone ki-eye">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>
                                        View
                                    </a>`;
                        }
                    }
                ]
            });
        });
    </script>
@endsection



