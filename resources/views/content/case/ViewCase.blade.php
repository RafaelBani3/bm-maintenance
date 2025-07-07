@extends('layouts.Master')

@section('title', 'BM Maintenance')
@section('subtitle', '  Case List')

@section('content')

        <style>
    table.ttd {
        width: 100%;
        border-collapse: collapse;
        font-family: Arial, sans-serif;
        font-size: 13px;
    }

    table.ttd, table.ttd th, table.ttd td {
        border: 1px solid #000;
    }

    table.ttd th {
        text-align: center;
        font-weight: normal;
        padding: 5px;
    }

    table.ttd td {
        vertical-align: top;
        padding: 5px;
        height: 60px;
    }

    .ttd-title {
        text-align: center;
        font-weight: bold;
    }

    .ttd-subtitle {
        font-weight: bold;
    }
</style>
 
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
                                        <option value="INPROGRESS">INPROGRESS</option>
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

                    <div class="card mb-5 mb-xl-10">
                        <div class="card-header card-header-stretch">
                            <!--begin::Title-->
                            <div class="card-title d-flex align-items-center">
                                <h3 class="fw-bold m-0 text-gray-800">Case List</h3>
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
                              
                            <!--end::Title-->
                        </div>
            
                        <!-- HTML Table -->
                        <div class="card-body">
                            <div class="row g-5 align-items-end">
                                <div class="tab-content">
                                    <div id="kt_billing_months" class="card-body p-0 tab-pane fade show active" role="tabpanel" aria-labelledby="kt_billing_months">
                                        <div class="table-responsive">
                                            <table class="table table-row-bordered align-middle gy-5 gs-9" id="casesTable">
                                                <thead>
                                                    <tr class="fw-bold text-muted text-center">
                                                        <th class="min-w-150px text-start sortable fs-6" data-column="Case_No">Case Id</th>
                                                        <th class="min-w-140px text-start sortable fs-6" data-column="Case_Date">Case Date</th>
                                                        <th class="min-w-120px text-start fs-6">Case Name</th>
                                                        <th class="min-w-120px text-start fs-6">Case Category</th>
                                                        <th class="min-w-120px text-start fs-6">Created By</th>
                                                        <th class="min-w-120px text-start fs-6">Position</th>
                                                        <th class="min-w-120px text-start fs-6">Status</th>
                                                        <th class="min-w-100px text-start fs-6">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="fw-semibold text-gray-600 text-center">
                                                    <tr>
                                                        <td colspan="8" class="text-center">Loading data...</td>
                                                    </tr>
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

   
    <div id="page_loader" class="page-loader flex-column bg-dark bg-opacity-25" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 9999; align-items: center; justify-content: center;">
        <span class="spinner-border text-primary" role="status"></span>
        <span class="text-white-800 fs-6 fw-semibold mt-5 text-white">Loading...</span>
    </div>

    @include('content.case.partial.CaseListJs')
    
    <script>
        const BASE_URL = "{{ url('/') }}";
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

    <script> 
        // Declare Route
        const exportUrl = "{{ route('cases.export') }}";
        $('#exportExcel').on('click', function () {
            let status = $('#statusFilter').val() || 'all';
            let search = $('#searchReport').val() || '';

            let url = new URL(exportUrl);
            url.searchParams.append('status', status);
            url.searchParams.append('search', search);

            window.open(url.toString(), '_blank');  
        }); 
    </script>

@endsection
