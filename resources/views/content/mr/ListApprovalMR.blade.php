@extends('layouts.Master')

@section('title', 'BM-Maintenance')
@section('subtitle', 'Material Reqeust - List Approval Material Request')

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

                    {{-- Table --}}
                    <div class="card mb-5 mb-xl-10">
                        <div class="card-header card-header-stretch">
                            <!--begin::Title-->
                            <div class="card-title d-flex align-items-center">
                                <h3 class="fw-bold m-0 text-gray-800">Material Request List</h3>
                            </div>
                            <!--end::Title-->
                        </div>
                
                        <div class="card-body">
                            <div class="row g-5 align-items-end">
                                <div class="tab-content">
                                    <div id="kt_billing_months" class="card-body p-0 tab-pane fade show active" role="tabpanel" aria-labelledby="kt_billing_months">
                                        <div class="table-responsive">
                                            <table class="table table-row-bordered align-middle gy-5 gs-9" id="matreq_table"> 
                                                <thead>
                                                    <tr class="fw-semibold fs-6 text-gray-800">
                                                        <th class="min-w-150px text-dark">MR No</th>
                                                        <th class="min-w-150px text-dark">WO No</th>
                                                        <th class="min-w-150px text-dark">Case No</th>
                                                        <th class="min-w-150px text-dark">Created Date</th>
                                                        <th class="min-w-150px text-dark">Status</th>
                                                        <th class="min-w-100px text-dark">Urgent</th>
                                                        <th class="min-w-200px text-dark">Created By</th>
                                                        <th class="min-w-100px text-dark">Action</th>
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
                        {{-- End Table --}}    
                    </div>
                    <!--end::Navbar-->
                </div>
            </div>
        </div>
    </div>
                
    <div class="page-loader flex-column bg-dark bg-opacity-50">
        <span class="spinner-border text-primary" role="status"></span>
        <span class="text-gray-800 fs-6 fw-semibold mt-5">Loading...</span>
    </div>

    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>


    <script>
        const BASE_URL = "{{ url('/') }}";
    </script>

    {{-- Get Data MR dan tampilkan didalam table --}}
    <script>
        $(document).ready(function () {
            $('#statusFilter').select2({
                placeholder: "Pilih Status",
                allowClear: true,
                width: 'resolve' 
            });

            let table = $("#matreq_table").DataTable({
                ajax: {
                    url: '{{ route('matreq.list') }}',
                    dataSrc: "",
                    error: function (xhr, error, thrown) {
                        console.log("AJAX Error:", xhr.responseText);
                        alert("Gagal mengambil data Material Request. Silakan cek console untuk detail.");
                    }
                },
                columns: [
                    { data: "MR_No", className: "text-primary fw-semibold text-start align-middle" },
                    { data: "WO_No", className: "text-primary fw-semibold text-start align-middle" },
                    { data: "Case_No", className: "text-primary fw-semibold text-start align-middle" },
                    { 
                        data: "MR_Date", 
                        className: "fw-semibold text-start align-middle",
                        render: function (data) {
                            const date = new Date(data);
                            const day = date.getDate().toString().padStart(2, '0');
                            const month = (date.getMonth() + 1).toString().padStart(2, '0');
                            const year = date.getFullYear();
                            return `${day}/${month}/${year}`;
                        }
                    },
                    { 
                        data: "MR_Status", 
                        className: "fw-semibold text-start align-middle",
                        render: function (data) {
                            return `<span class="badge badge-primary">${data}</span>`;
                        }
                    },
                    { 
                        data: "MR_IsUrgent", 
                        className: "fw-semibold text-start align-middle",
                        render: function (data) {
                            return data === 'Y' 
                                ? '<span class="badge badge-danger">Urgent</span>' 
                                : '<span class="badge badge-secondary">Normal</span>';
                        }
                    },
                    { 
                        data: "CreatedBy", 
                        className: "fw-semibold text-start align-middle",
                        render: function (data) {
                            return data ?? '-';
                        }
                    },
                    { 
                        data: "MR_No",
                        className: "text-start align-middle",
                        render: function (data) {
                            const baseUrl = window.location.origin + "/BmMaintenance/public";
                            const encodedMRNo = btoa(data);
                            return `
                            <a href="${baseUrl}/Material-Request/Approval-Detail/${encodedMRNo}" class="btn btn-secondary hover-scale">
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
                scrollX:        true,
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
                    table.column(4).search(statusFilter === 'all' || statusFilter === null ? '' : statusFilter).draw();

                    $('#page_loader').css('display', 'none');
                }, 500); 
            });
        });
    </script>

    {{-- Script Data Range --}}
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
    
    

@endsection
