@extends('layouts.Master')

@section('title', 'Material Request Management')
@section('subtitle', 'Create New Material Request')

@section('content')

    {{-- Optional styling --}}
    <style>
        table input,
        table select {
            min-width: 100px;
        }

        .table td,
        .table th {
            vertical-align: middle !important;
        }

        .is-invalid {
            border-color: #f1416c !important;
        }

        .flatpickr-day.today {
            background: #6099ee !important; /* Bootstrap Primary Blue */
            color: #fff !important;
            border-radius: 6px;
        }


    </style>



    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
        <!--begin::Content wrapper-->
        <div class="d-flex flex-column flex-column-fluid py-3 py-lg-6">
            <!--begin::Content-->
            <div id="kt_app_content" class="app-content flex-column-fluid">
                <!--begin::Content container-->
                <div id="kt_app_content_container" class="app-container container-xxl">
                    <!--begin::Timeline-->
                    <div class="card">
                        <!--begin::Card head-->
                        <div class="card-header card-header-stretch">
                            <!--begin::Title-->
                            <div class="card-title d-flex align-items-center">
                                <h3 class="fw-bold m-0 text-gray-800">@yield('title') - @yield('subtitle')</h3>
                            </div>
                            <!--end::Title-->
                        </div>
                        <!--end::Card head-->

                        <!--begin::Card body-->
                        <div class="card-body">
                            <!--begin::Tab Content-->
                            <div class="tab-content">
                                <!--begin::Tab panel-->
                                <div id="kt_activity_today" class="card-body p-0 tab-pane fade show active" role="tabpanel" aria-labelledby="kt_activity_today_tab">
                                    
                                    <div id="kt_account_settings_profile_details" class="collapse show">
                                        <!--begin::Form-->
                                        <form action="" method="POST" id="MrForm" enctype="multipart/form-data" class="form">
                                            @csrf
                                            <!--begin::Card body-->
                                            <div class="card-body p-2">
                                        
                                                <!--begin::Reference No (WO No)-->
                                                <div class="row mb-10">
                                                    <!--begin::Label-->
                                                    <label class="col-lg-4 col-form-label required fw-semibold fs-5 text-muted">
                                                        <span>Reference No.</span>
                                                        <span class="ms-1" data-bs-toggle="tooltip" title="This is the current Work Order reference number.">
                                                            <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                                <span class="path3"></span>
                                                            </i>
                                                        </span>
                                                    </label>
                                                    <!--end::Label-->

                                                    <!--begin::Input-->
                                                    <div class="col-lg-8 fv-row">
                                                        <select class="form-select form-select-lg form-select-solid" 
                                                                id="reference_number" name="reference_number" 
                                                                data-control="select2" data-placeholder="Select Reference">
                                                            <option></option>
                                                        </select>
                                                    </div>
                                                    <!--end::Input-->
                                                </div>
                                                <!--end::Reference No (WO No)-->
                                                
                                                <!--begin::Input Case No-->
                                                <div class="row mb-10">
                                                    <!--begin::Label-->
                                                    <label class="col-lg-4 col-form-label required fw-semibold fs-5 text-muted">
                                                        Case No
                                                    </label>
                                                    <!--end::Label-->
                                                    
                                                    <div class="col-lg-8">
                                                        <div class="col-lg-20 fv-row">
                                                            <input type="text" id="case_no" name="case_no" class="form-control form-control-lg form-control-solid" readonly placeholder="Auto-generated Case No" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--end::Input Case No-->

                                                <!--begin::Input Created By-->
                                                <div class="row mb-10">
                                                    <!--begin::Label-->
                                                    <label class="col-lg-4 col-form-label required fw-semibold fs-5 text-muted">
                                                        Created By
                                                    </label>
                                                    <!--end::Label-->
                                                    
                                                    <div class="col-lg-8">
                                                        <div class="col-lg-20 fv-row">
                                                            <input type="text" id="created_by" name="created_by" 
                                                                class="form-control form-control-solid" disabled placeholder="Auto-generated Creator" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--end::Input Created By-->
                                                
                                                <!--begin::Input Created By-->
                                                <div class="row mb-10">
                                                    <!--begin::Label-->
                                                    <label class="col-lg-4 col-form-label required fw-semibold fs-5 text-muted">
                                                        Department
                                                    </label>
                                                    <!--end::Label-->
                                                    
                                                    <div class="col-lg-8">
                                                        <div class="col-lg-20 fv-row">
                                                            <input type="text" id="department" name="department" 
                                                                class="form-control form-control-solid" disabled placeholder="Input Position" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--end::Input Created By-->

                                                <!--begin::Input Date-->
                                                <div class="row mb-10">
                                                    <!--begin::Label-->
                                                    <label class="col-lg-4 col-form-label required fw-semibold fs-5 text-muted">
                                                        Material Request Date
                                                    </label>
                                                    <!--end::Label-->
                                                    
                                                    <div class="col-lg-8">
                                                        <div class="col-lg-20 fv-row">
                                                            <input type="date" class="form-control form-control-solid" id="date" name="date" placeholder="Select the work order date" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--end::Input Wo Date-->

                                                <!--begin:: Designation-->
                                                <div class="row mb-10">
                                                    <!--begin::Label-->
                                                    <label class="col-lg-4 col-form-label required fw-semibold fs-5 text-muted">
                                                        <span>Material Allocation Purpose </span>
                                                        <span class="ms-1" data-bs-toggle="tooltip" title="Please specify the intended use of this material to ensure accurate allocation and procurement.">
                                                            <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                                <span class="path3"></span>
                                                            </i>
                                                        </span>
                                                    </label>
                                                    <!--end::Label-->
                                                    
                                                    <div class="col-lg-8">
                                                        <div class="col-lg-20 fv-row">
                                                            <textarea name="Designation" class="form-control form-control-solid" 
                                                            rows="4" placeholder="What it is intended for..."></textarea>   
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--end::Input Designation-->

                                                
                                                @php $rowCount = 1; @endphp

                                                <div class="row mb-10">
                                                    <!--begin::Label-->
                                                    <label class="col-lg-4 col-form-label required fw-semibold fs-5 text-muted">
                                                        Material List
                                                    </label>
                                                    <!--end::Label-->
                                                    <div class="table-responsive">
                                                        <table class="table table-rounded table-striped border gy-7 gs-7" id="material-table">
                                                            <thead>
                                                                <tr class="fw-semibold fs-6 text-gray-800 border-bottom border-gray-200">
                                                                    <th>No</th>
                                                                    <th>Quantity</th>
                                                                    <th>Unit</th>
                                                                    <th>Item Code</th>
                                                                    <th>Item Name</th>
                                                                    <th>Description</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="material-body">
                                                                <tr>
                                                                    <td class="text-center">1</td>
                                                                    <td><input type="number" name="items[0][qty]" class="fv-row form-control" ></td>
                                                                    {{-- <td><input type="text" name="items[0][unit]" class="form-control"></td> --}}
                                                                    <td>
                                                                        <select name="items[0][unit]" class="form-select select2-unit" style="width: 100%;">
                                                                            <option value="pcs">pcs (pieces)</option>
                                                                            <option value="unit">unit (digunakan untuk alat/mesin)</option>
                                                                            <option value="box">box</option>
                                                                            <option value="pack">pack</option>
                                                                            <option value="liter">liter</option>
                                                                            <option value="kg">kg (kilogram)</option>
                                                                            <option value="meter">meter</option>
                                                                            <option value="dozen">dozen</option>
                                                                            <option value="roll">roll</option>
                                                                            <option value="set">set</option>
                                                                            <option value="can">can (kaleng)</option>
                                                                            <option value="bottle">bottle</option>
                                                                            <option value="sheet">sheet</option>
                                                                            <option value="pair">pair</option>
                                                                        </select>
                                                                    </td>
                                                                    
                                                                    <td><input type="text" name="items[0][code]" class="fv-row form-control"></td>
                                                                    <td><input type="text" name="items[0][name]" class="fv-row form-control" ></td>
                                                                    <td><input type="text" name="items[0][desc]" class="fv-row form-control"></td>
                                                                    <td class="text-center text-white">
                                                                        <button type="button" class="btn btn-danger remove-row text-center text-white">
                                                                            <i class="ki-duotone ki-trash fs-2 text-center text-white" style="color: white">
                                                                                <span class="path1"></span>
                                                                                <span class="path2"></span>
                                                                                <span class="path3"></span>
                                                                                <span class="path4"></span>
                                                                                <span class="path5"></span>
                                                                            </i>
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                          
                                                        </table>
                                                    </div>

                                                    <div class="col-lg-8">
                                                        <div class="col-lg-20 fv-row">
                                                            <button type="button" id="add-row" class="btn btn-primary mb-5 col-md-2 text-center hover-scale">+ Add Row</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end::Card body-->

                                            <!--begin::Actions-->
                                            <div class="card-footer d-flex justify-content-end py-6 px-9">
                                                <button id="kt_docs_formvalidation_text_submit" type="submit" class="btn btn-primary">
                                                    <span class="indicator-label">
                                                    Save Material Request
                                                    </span>
                                                    <span class="indicator-progress">
                                                        Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                                    </span>
                                                </button>
                                            </div>
                                            <!--end::Actions-->        
                                        </form>
                                        <!--end::Form-->
                                    </div>
                                    <!--end::Content-->
                                </div>
                                <!--end::Basic info-->
                            </div>
                            <!--end::Tab Content-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Timeline-->
                </div>
                <!--end::Content container-->
            </div>
            <!--end::Content-->
        </div>
        <!--end::Content wrapper-->
    </div>

    <div id="page_loader" class="page-loader flex-column bg-dark bg-opacity-25" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 9999; align-items: center; justify-content: center;">
        <span class="spinner-border text-primary" role="status"></span>
        <span class="text-white-800 fs-6 fw-semibold mt-5 text-white">Loading...</span>
    </div>

    <script>
        const BASE_URL = "{{ url('') }}";
    </script>

    @include('content.mr.partial.CreateMRJS')


@endsection

