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

                        </div>
                
                        <div class="card-body">
                            <div class="row g-5 align-items-end">
                                <div class="tab-content">
                                    <div id="kt_billing_months" class="card-body p-0 tab-pane fade show active" role="tabpanel" aria-labelledby="kt_billing_months">
                                        <div class="table-responsive">
                                            <table class="table table-row-bordered align-middle gy-5 gs-9" id="matreq_table"> 
                                                <thead>
                                                    <tr class="fw-semibold fs-6 text-gray-800">
                                                        <th class="min-w-140px ">MR No</th>
                                                        <th class="min-w-140px ">WO No</th>
                                                        <th class="min-w-150px ">Case No</th>
                                                        <th class="min-w-130px ">Created Date</th>
                                                        <th class="min-w-50px ">Status</th>
                                                        <th class="min-w-30px ">Urgent</th>
                                                        <th class="min-w-90px ">Created By</th>
                                                        <th class="min-w-50px ">Action</th>
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

    {{-- GET DAT MR to Table --}}
    {{-- versi 24 juni
    <script>
        // Declare Script untuk Menuju Page Detail MR
        // const mrDetailRoute = @json(route('MaterialRequest.Detail', ['encodedMRNo' => 'PLACEHOLDER']));
        const mrDetailRoute = "{{ route('MaterialRequest.Detail', ['encodedMRNo' => 'PLACEHOLDER']) }}";
        const mrEditRoute = "{{ route('EditMR', ['mr_no' => 'PLACEHOLDER']) }}";

        const canEditMR = @json(auth()->user()->can('view mr'));

        $(document).ready(function () {
            const baseUrl = "{{ url('/') }}";

            const table = $("#matreq_table").DataTable({
                ajax: {
                    url: "{{ route('GetDataMR') }}",
                    method: "GET",
                    dataSrc: function (json) {
                        if (!Array.isArray(json)) {
                            console.warn("Invalid response format:", json);
                            alert("Data tidak valid dari server. Silakan hubungi administrator.");
                            return [];
                        }
                        return json;
                    },
                    error: function (xhr, status, error) {
                        console.error("AJAX Error:", {
                            status: xhr.status,
                            response: xhr.responseText,
                            error: error
                        });

                        let msg = "Terjadi kesalahan saat memuat data. Silakan cek console.";

                        if (xhr.status === 500) {
                            msg = "Server error (500). Mungkin ada masalah di backend.";
                        } else if (xhr.status === 404) {
                            msg = "Data tidak ditemukan (404).";
                        }

                        alert(msg);
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
                        render: data => {
                            if (!data) return 'N/A';
                            try {
                                return new Date(data).toLocaleDateString('en-CA'); // YYYY-MM-DD
                            } catch {
                                return 'Invalid date';
                            }
                        }
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
                            return `<span class="badge ${badgeClass} fw-semibold">${status ?? '-'}</span>`;
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
                        className: "",
                        render: function (data, type, row) {
                            const encoded = btoa(data); 
                            const detailUrl = mrDetailRoute.replace('PLACEHOLDER', encoded); 
                            const editUrl = mrEditRoute.replace('PLACEHOLDER', encoded); 

                            let buttons = '<div class="d-flex gap-2">';

                            if (row.MR_Status === "OPEN" || row.MR_Status === "REJECT" && typeof canEditMR !== 'undefined' && canEditMR) {
                                buttons += `
                                    <a href="${editUrl}" 
                                    class="btn bg-light-warning d-flex align-items-center justify-content-center p-2" 
                                    style="width: 40px; height: 40px;" 
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Case">
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
                                data-bs-toggle="tooltip" data-bs-placement="top" title="View Case">
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
                scrollCollapse: true,
                language: {
                    emptyTable: "Data tidak tersedia",
                    loadingRecords: "Memuat...",
                    processing: "Memproses...",
                    search: "Cari:"
                }
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
                const keyword = $('#searchReport').val().trim().toLowerCase();
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

    {{-- versi ada data range --}}
    <script>
        const mrDetailRoute = "{{ route('MaterialRequest.Detail', ['encodedMRNo' => 'PLACEHOLDER']) }}";
        const mrEditRoute = "{{ route('EditMR', ['mr_no' => 'PLACEHOLDER']) }}";
        const canEditMR = @json(auth()->user()->can('view mr'));
        const exportPDFRoute = "{{ route('ExportMRPDF', 'PLACEHOLDER') }}";
        const userPosition = @json(auth()->user()->Position->PS_Name);
        const deleteMRRoute = "{{ route('DeleteMR', 'PLACEHOLDER') }}"; 


        // Global variables for date range
        let startDate = null;
        let endDate = null;

        $(document).ready(function () {
            // Init Date Range Picker
            $('#dateFilter').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    cancelLabel: 'Clear',
                    format: 'YYYY-MM-DD'
                }
            });

            $('#dateFilter').on('apply.daterangepicker', function (ev, picker) {
                startDate = picker.startDate.format('YYYY-MM-DD');
                endDate = picker.endDate.format('YYYY-MM-DD');
                $(this).val(startDate + ' - ' + endDate);
            });

            $('#dateFilter').on('cancel.daterangepicker', function () {
                $(this).val('');
                startDate = null;
                endDate = null;
            });

            const table = $("#matreq_table").DataTable({
                ajax: {
                    url: "{{ route('GetDataMR') }}",
                    method: "GET",
                    dataSrc: function (json) {
                        if (!Array.isArray(json)) {
                            console.warn("Invalid response format:", json);
                            alert("Data tidak valid dari server. Silakan hubungi administrator.");
                            return [];
                        }
                        return json;
                    },
                    error: function (xhr, status, error) {
                        console.error("AJAX Error:", { status: xhr.status, response: xhr.responseText, error: error });
                        let msg = "Terjadi kesalahan saat memuat data. Silakan cek console.";
                        if (xhr.status === 500) msg = "Server error (500). Mungkin ada masalah di backend.";
                        else if (xhr.status === 404) msg = "Data tidak ditemukan (404).";
                        alert(msg);
                    }
                },
                columns: [
                    {
                        data: "MR_No",
                        className: "text-start",
                        render: data => `<span class="text-primary fw-bold">${data ?? 'N/A'}</span>`
                    },
                    {
                        data: "WO_No",
                        className: "text-start",
                        render: data => `<span class="text-primary fw-bold">${data ?? 'N/A'}</span>`
                    },
                    {
                        data: "Case_No",
                        className: "text-start",
                        render: data => `<span class="text-primary fw-bold">${data ?? 'N/A'}</span>`
                    },
                    {
                        data: "MR_Date",
                        className: "text-start",
                        render: data => {
                            if (!data) return 'N/A';
                            try {
                                return new Date(data).toLocaleDateString('en-CA'); // YYYY-MM-DD
                            } catch {
                                return 'Invalid date';
                            }
                        }
                    },
                    {
                        data: "MR_Status",
                        className: "text-start",
                        render: function (status) {
                            let badgeClass = "badge-light-secondary text-gray-800";
                            switch (status) {
                                case "OPEN": badgeClass = "badge-light-warning text-warning"; break;
                                case "SUBMIT":
                                case "AP1": case "AP2": case "AP3": case "AP4": case "AP5":
                                    badgeClass = "badge-light-primary text-primary"; break;
                                case "INPROGRESS": badgeClass = "badge-light-info text-info"; break;
                                case "CLOSE":
                                case "DONE": badgeClass = "badge-light-success text-success"; break;
                                case "REJECT": badgeClass = "badge-light-danger text-danger"; break;
                            }
                            return `<span class="badge ${badgeClass} fw-semibold">${status ?? '-'}</span>`;
                        }
                    },
                    {
                        data: "MR_IsUrgent",
                        className: "text-start",
                        render: val => val === 'Y'
                            ? '<span class="badge bg-light-danger text-danger fs-7">Urgent</span>'
                            : '<span class="badge bg-secondary fs-7">No</span>'
                    },
                    {
                        data: "CreatedBy",
                        className: "text-start",
                        render: data => data ?? '-'
                    },
                    // {
                    //     data: "MR_No",
                    //     className: "",
                    //     render: function (data, type, row) {
                    //         const encoded = btoa(data);
                    //         const detailUrl = mrDetailRoute.replace('PLACEHOLDER', encoded);
                    //         const editUrl = mrEditRoute.replace('PLACEHOLDER', encoded);

                    //         let buttons = '<div class="d-flex gap-2">';
                    //         if ((row.MR_Status === "OPEN" || row.MR_Status === "REJECT") && canEditMR) {
                    //             buttons += `
                    //                 <a href="${editUrl}" class="btn bg-light-warning d-flex align-items-center justify-content-center p-2" 
                    //                 style="width: 40px; height: 40px;" title="Edit Case">
                    //                     <i class="ki-duotone ki-pencil fs-3 text-warning">
                    //                         <span class="path1"></span>
                    //                         <span class="path2"></span>
                    //                     </i>
                    //                 </a>`;
                    //         }

                    //          // Tambahkan tombol Print PDF jika status DONE
                    //         if (row.MR_Status === "DONE") {
                    //             const exportPdfUrl = exportPDFRoute.replace('PLACEHOLDER', encoded);
                    //             buttons += `
                    //                 <a href="${exportPdfUrl}" target="_blank" class="btn bg-light-danger d-flex align-items-center justify-content-center p-2" title="Export PDF">
                    //                     <i class="ki-duotone ki-printer fs-2 text-danger">
                    //                         <span class="path1"></span>
                    //                         <span class="path2"></span>
                    //                     </i>
                    //                 </a>`;
                    //         }


                    //         buttons += `
                    //             <a href="${detailUrl}" class="btn bg-light-primary d-flex align-items-center justify-content-center p-2" 
                    //             style="width: 40px; height: 40px;" title="View Case">
                    //                 <i class="ki-duotone ki-eye fs-3 text-primary">
                    //                     <span class="path1"></span>
                    //                     <span class="path2"></span>
                    //                     <span class="path3"></span>
                    //                 </i>
                    //             </a>
                    //         </div>`;
                    //         return buttons;
                    //     }
                    // }
                    {
                        data: "MR_No",
                        className: "",
                        render: function (data, type, row) {
                            const encoded = btoa(data);
                            const detailUrl = mrDetailRoute.replace('PLACEHOLDER', encoded);
                            const editUrl = mrEditRoute.replace('PLACEHOLDER', encoded);
                            const exportPdfUrl = exportPDFRoute.replace('PLACEHOLDER', encoded);
                            const deleteUrl = deleteMRRoute.replace('PLACEHOLDER', encoded);

                            let buttons = '<div class="d-flex gap-2">';

                            // Tombol edit jika status OPEN atau REJECT
                            if ((row.MR_Status === "OPEN" || row.MR_Status === "REJECT") && canEditMR) {
                                buttons += `
                                    <a href="${editUrl}" class="btn bg-light-warning d-flex align-items-center justify-content-center p-2" 
                                    style="width: 40px; height: 40px;" title="Edit Case">
                                        <i class="ki-duotone ki-pencil fs-3 text-warning">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </a>`;
                            }

                            // Tombol export PDF jika DONE
                            if (row.MR_Status === "DONE") {
                                buttons += `
                                    <a href="${exportPdfUrl}" target="_blank" class="btn bg-light-info d-flex align-items-center justify-content-center p-2" title="Export PDF">
                                        <i class="ki-duotone ki-printer fs-2 text-info">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </a>`;
                            }

                            // Tombol delete jika PS_Name = Creator atau Approver
                                if (userPosition === "Creator" || userPosition === "Approver") {
                                    buttons += `
                                        <button class="btn bg-light-danger d-flex align-items-center justify-content-center p-2 btn-delete-mr"
                                            data-url="${deleteUrl}" style="width: 40px; height: 40px;" title="Delete MR">
                                            <i class="ki-duotone ki-trash fs-2 text-danger"><span class="path1"></span><span class="path2"></span></i>
                                        </button>`;
                                }

                            // Tombol detail (selalu tampil)
                            buttons += `
                                <a href="${detailUrl}" class="btn bg-light-primary d-flex align-items-center justify-content-center p-2" 
                                style="width: 40px; height: 40px;" title="View Case">
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
                scrollCollapse: true,
                language: {
                    emptyTable: "Data tidak tersedia",
                    loadingRecords: "Memuat...",
                    processing: "Memproses...",
                    search: "Cari:"
                }
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
                const keyword = $('#searchReport').val().trim().toLowerCase();
                const status = $('#statusFilter').val();

                showPageLoading();

                setTimeout(() => {
                    table.search(keyword).draw();
                    table.column(4).search(status === 'all' ? '' : status).draw();

                    // Filter berdasarkan date range
                    if (startDate && endDate) {
                        table.rows().every(function () {
                            const rowData = this.data();
                            const mrDate = new Date(rowData.MR_Date).toISOString().split('T')[0];
                            const inRange = mrDate >= startDate && mrDate <= endDate;
                            $(this.node()).toggle(inRange);
                        });
                    } else {
                        table.rows().every(function () {
                            $(this.node()).show();
                        });
                    }

                    hidePageLoading();
                }, 300);
            });
        });

        // Konfirmasi Delete MR
        $(document).on('click', '.btn-delete-mr', function () {
            const deleteUrl = $(this).data('url');

            Swal.fire({
                title: 'Yakin ingin menghapus MR ini?',
                text: "Data yang sudah dihapus tidak bisa dikembalikan.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#aaa',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.action = deleteUrl;
                    form.method = 'POST';

                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '_token';
                    csrfInput.value = $('meta[name="csrf-token"]').attr('content');

                    form.appendChild(csrfInput);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });

        
    </script>


    

    {{-- Script Button Export --}}
    <script> 
        // DECLARE Route
        const exportMRUrl = "{{ route('matreq.export') }}";

        $('#exportExcel').on('click', function () {     
            let status = $('#statusFilter').val() || 'all'; 
            let search = $('#searchReport').val() || ''; 
            let url = new URL(exportMRUrl); 
            url.searchParams.append('status', status); 
            url.searchParams.append('search', search); 
            window.open(url.toString(), '_blank');  
        });  
    </script>

@endsection
