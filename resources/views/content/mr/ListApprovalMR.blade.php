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
                                <div class="col-lg-5">
                                    <label for="searchReport" class="form-label fw-bold">Search Report</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">
                                            <i class="fa-solid fa-magnifying-glass text-muted"></i>
                                        </span>
                                        <input type="text" id="searchReport" class="form-control form-control-solid" placeholder="Input your Case No" aria-describedby="basic-addon1" />
                                    </div>
                                </div>
                                <!--end::Search-->
                        
                                <!--begin::Date Range Picker-->
                                <div class="col-lg-5">
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
                                                        <th class="min-w-200px text-dark">Case No</th>
                                                        <th class="min-w-100px text-dark">Created Date</th>
                                                        <th class="min-w-100px text-dark">Status</th>
                                                        <th class="min-w-100px text-dark">Urgent</th>
                                                        <th class="min-w-100px text-dark">Created By</th>
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
                
    <div id="page_loader" class="page-loader d-none flex-column bg-dark bg-opacity-25" style="
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;">
        <div class="text-center">
            <span class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;"></span>
            <div class="fs-6 fw-semibold mt-4 text-white">Loading...</div>
        </div>
    </div>

    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>

    <script>
        const BASE_URL = "{{ url('/') }}";
    </script>

    {{-- Get Data MR dan tampilkan didalam table --}}
    {{-- <script>
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
                            return `<span class="badge badge-light-primary">${data}</span>`;
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
    </script> --}}
    {{-- <script>
        $(document).ready(function () {
            $('#statusFilter').select2({
                placeholder: "Pilih Status",
                allowClear: true,
                width: 'resolve'
            });

            function safeBtoa(str) {
                return btoa(unescape(encodeURIComponent(str)));
            }

            const baseUrl = window.location.origin + "/BmMaintenance/public";

            const table = $("#matreq_table").DataTable({
                ajax: {
                    url: '{{ route('matreq.list') }}',
                    dataSrc: "",
                    error: function (xhr, error, thrown) {
                        console.error("AJAX Error:", xhr.responseText);
                        $('#page_loader').hide();
                        alert("Gagal mengambil data Material Request. Silakan cek console.");
                    }
                },
                columns: [
                    { 
                        data: "MR_No", 
                        className: "text-primary fw-semibold text-start align-middle",
                        width: "150px"
                    },
                    { 
                        data: "WO_No", 
                        className: "text-primary fw-semibold text-start align-middle",
                        width: "150px"
                    },
                    { 
                        data: "Case_No", 
                        className: "text-primary fw-semibold text-start align-middle",
                        width: "150px"
                    },
                    { 
                        data: "MR_Date", 
                        className: "fw-semibold text-start align-middle",
                        width: "120px",
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
                        width: "120px",
                        render: function (data) {
                            return `<span class="badge badge-light-primary">${data}</span>`;
                        }
                    },
                    { 
                        data: "MR_IsUrgent", 
                        className: "fw-semibold text-start align-middle",
                        width: "100px",
                        render: function (data) {
                            return data === 'Y'
                                ? '<span class="badge badge-danger">Urgent</span>'
                                : '<span class="badge badge-secondary">Normal</span>';
                        }
                    },
                    { 
                        data: "CreatedBy", 
                        className: "fw-semibold text-start align-middle",
                        width: "150px",
                        render: function (data) {
                            return data ?? '-';
                        }
                    },
                    { 
                        data: "MR_No",
                        className: "text-start align-middle",
                        orderable: false,
                        width: "120px",
                        render: function (data) {
                            const encodedMRNo = safeBtoa(data);
                            return `
                                <a href="${baseUrl}/Material-Request/Approval-Detail/${encodedMRNo}" 
                                class="btn btn-secondary hover-scale">
                                    <i class="ki-duotone ki-eye">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                    </i> View
                                </a>`;
                        }
                    }
                ],
                language: {
                    emptyTable: "Tidak ada data Material Request.",
                    zeroRecords: "Tidak ditemukan data sesuai filter.",
                    loadingRecords: "Memuat data...",
                    processing: "Memproses...",
                    search: "Cari:",
                },
                scrollY: "300px",
                scrollX: true,
                scrollCollapse: true,
                fixedColumns: {
                    left: 2,
                    right: 1
                }
            });

            $('#applyFilter').on('click', function () {
                $('#page_loader').show();

                setTimeout(() => {
                    const selectedStatus = $('#statusFilter').val();
                    const searchValue = (selectedStatus === 'all' || selectedStatus === null) ? '' : selectedStatus;
                    table.column(4).search(searchValue).draw();

                    $('#page_loader').hide();
                }, 500);
            });
        });
    </script> --}}
    {{-- <script>
        $(document).ready(function () {
            function safeBtoa(str) {
                return btoa(unescape(encodeURIComponent(str)));
            }

            const baseUrl = window.location.origin + "/BmMaintenance/public";

            const table = $("#matreq_table").DataTable({
                ajax: {
                    url: '{{ route('matreq.list') }}',
                    dataSrc: "",
                    error: function (xhr, error, thrown) {
                        console.error("AJAX Error:", xhr.responseText);
                        $('#page_loader').hide();
                        alert("Gagal mengambil data Material Request. Silakan cek console.");
                    }
                },
                columns: [
                    { 
                        data: "MR_No", 
                        className: "text-primary fw-semibold text-start align-middle",
                        width: "150px"
                    },
                    { 
                        data: "WO_No", 
                        className: "text-primary fw-semibold text-start align-middle",
                        width: "150px"
                    },
                    { 
                        data: "Case_No", 
                        className: "text-primary fw-semibold text-start align-middle",
                        width: "150px"
                    },
                    { 
                        data: "MR_Date", 
                        className: "fw-semibold text-start align-middle",
                        width: "120px",
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
                        width: "120px",
                        render: function (data) {
                            return `<span class="badge badge-light-primary">${data}</span>`;
                        }
                    },
                    { 
                        data: "MR_IsUrgent", 
                        className: "fw-semibold text-start align-middle",
                        width: "100px",
                        render: function (data) {
                            return data === 'Y'
                                ? '<span class="badge badge-danger">Urgent</span>'
                                : '<span class="badge badge-secondary">Normal</span>';
                        }
                    },
                    { 
                        data: "CreatedBy", 
                        className: "fw-semibold text-start align-middle",
                        width: "150px",
                        render: function (data) {
                            return data ?? '-';
                        }
                    },
                    { 
                        data: "MR_No",
                        className: "text-start align-middle",
                        orderable: false,
                        width: "120px",
                        render: function (data) {
                            const encodedMRNo = safeBtoa(data);
                            return `
                                <a href="${baseUrl}/Material-Request/Approval-Detail/${encodedMRNo}" 
                                class="btn btn-secondary hover-scale">
                                    <i class="ki-duotone ki-eye">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                    </i> View
                                </a>`;
                        }
                    }
                ],
                language: {
                    emptyTable: "Tidak ada data Material Request.",
                    zeroRecords: "Tidak ditemukan data sesuai filter.",
                    loadingRecords: "Memuat data...",
                    processing: "Memproses...",
                    search: "Cari:",
                },
                scrollY: "300px",
                scrollX: true,
                scrollCollapse: true,
                fixedColumns: {
                    left: 2,
                    right: 1
                }
            });

            $('#applyFilter').on('click', function () {
                $('#page_loader').removeClass('d-none'); 

                setTimeout(() => {
                    const keyword = $('#searchReport').val().trim().toLowerCase();

                    $.fn.dataTable.ext.search = [];
                    $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
                        const mrNo = data[0].toLowerCase(); 
                        const woNo = data[1].toLowerCase();
                        const caseNo = data[2].toLowerCase(); 

                        return mrNo.includes(keyword) || woNo.includes(keyword) || caseNo.includes(keyword);
                    });

                    table.draw();
                    $('#page_loader').addClass('d-none');  

                }, 300);
            });
        });
    </script> --}}

    <script>
        const materialRequestDetailUrl = "{{ route('MaterialRequest.Detail', ['encodedMRNo' => 'ENCODED_PLACEHOLDER']) }}";

        $(document).ready(function () {
            function safeBtoa(str) {
                return btoa(unescape(encodeURIComponent(str)));
            }

            // const baseUrl = window.location.origin + "/BmMaintenance/public";

            const table = $("#matreq_table").DataTable({
                ajax: {
                    url: "{{ route('matreq.list') }}",
                    dataSrc: "",
                    error: function (xhr, error, thrown) {
                        console.error("AJAX Error:", xhr.status, xhr.responseText);
                        alert("Gagal mengambil data Material Request.\n" + xhr.responseJSON?.message || "Server Error");
                        $('#page_loader').hide();
                    }
                },
                columns: [
                    { data: "MR_No", className: "text-primary fw-semibold text-start align-middle", width: "150px" },
                    { data: "WO_No", className: "text-primary fw-semibold text-start align-middle", width: "150px" },
                    { data: "Case_No", className: "text-primary fw-semibold text-start align-middle", width: "150px" },
                    { 
                        data: "MR_Date", className: "fw-semibold text-start align-middle", width: "120px",
                        render: function (data) {
                            if (!data) return "-";
                            const date = new Date(data);
                            return `${date.getDate().toString().padStart(2, '0')}/${(date.getMonth()+1).toString().padStart(2, '0')}/${date.getFullYear()}`;
                        }
                    },
                    { 
                        data: "MR_Status", className: "fw-semibold text-start align-middle", width: "120px",
                        render: function (data) {
                            return `<span class="badge badge-light-primary">${data}</span>`;
                        }
                    },
                    { 
                        data: "MR_IsUrgent", className: "fw-semibold text-start align-middle", width: "100px",
                        render: function (data) {
                            return data === 'Y'
                                ? '<span class="badge badge-danger">Urgent</span>'
                                : '<span class="badge badge-secondary">Normal</span>';
                        }
                    },
                    { 
                        data: "CreatedBy", className: "fw-semibold text-start align-middle", width: "150px",
                        render: function (data) {
                            return data ?? '-';
                        }
                    },
                    { 
                        // data: "MR_No", className: "text-start align-middle", orderable: false, width: "120px",
                        // render: function (data) {
                        //     const encodedMRNo = safeBtoa(data);
                        //     return `
                        //         <a href="${baseUrl}/Material-Request/Approval-Detail/${encodedMRNo}" 
                        //         class="btn btn-secondary hover-scale">
                        //             <i class="ki-duotone ki-eye"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i> View
                        //         </a>`;
                        // }
                        data: "MR_No",
                        className: "text-start align-middle",
                        orderable: false,
                        width: "120px",
                        render: function (data) {
                            const encodedMRNo = safeBtoa(data);
                            const detailUrl = materialRequestDetailUrl.replace('ENCODED_PLACEHOLDER', encodedMRNo);

                            return `
                                <a href="${detailUrl}" class="btn btn-secondary hover-scale">
                                    <i class="ki-duotone ki-eye">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                    </i> View
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
                },
                language: {
                    emptyTable: "Tidak ada data Material Request.",
                    zeroRecords: "Tidak ditemukan data sesuai filter.",
                    loadingRecords: "Memuat data...",
                    processing: "Memproses...",
                    search: "Cari:",
                }
            });

            $('#applyFilter').on('click', function () {
                $('#page_loader').removeClass('d-none'); 

                setTimeout(() => {
                    const keyword = $('#searchReport').val().trim().toLowerCase();
                    $.fn.dataTable.ext.search = [];
                    $.fn.dataTable.ext.search.push(function (settings, data) {
                        return data[0].toLowerCase().includes(keyword) || 
                            data[1].toLowerCase().includes(keyword) ||
                            data[2].toLowerCase().includes(keyword);
                    });
                    table.draw();
                    $('#page_loader').addClass('d-none');  
                }, 300);
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
    	
    @if(session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Akses Ditolak',
                text: '{{ session('error') }}',
                confirmButtonText: 'OK'
            });
        </script>
    @endif
    

@endsection
