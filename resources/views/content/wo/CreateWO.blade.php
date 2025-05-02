@extends('layouts.Master')

@section('title', 'Work Order Management')
@section('subtitle', 'Create Work Order')

@section('content')


    <div id="app_content" class="app-content flex-column-fluid">
        <div id="app_content_container" class="app-container container-xxl">
            <div class="card shadow-sm rounded-3 border-0">
                <!--begin::Card head-->
                <div class="card-header card-header-stretch">
                    <!--begin::Title-->
                    <div class="card-title d-flex align-items-center">
                        <h3 class="fw-bold m-0 text-gray-800">@yield('title') - @yield('subtitle')</h3>
                    </div>
                    <!--end::Title-->
                </div>
                <!--end::Card head-->

                <div id="work_order_form" class="card-body p-5">
                    <form id="kt_docs_formvalidation_text" enctype="multipart/form-data" method="POST">
                        @csrf
                    
                        <!--begin::Card body-->
                        <div class="card-body p-2">
                            <!--begin::Input Cases-->
                            <div class="fv-row row mb-10">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label fw-semibold fs-5 text-muted">
                                    <span>Reference No.</span>
                                    <span class="ms-1" data-bs-toggle="tooltip" title="Select a Case No to be used as the reference for this work order.">
                                        <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>
                                    </span>
                                </label>
                                <!--end::Label-->

                                <div class="fv-row col-lg-8">
                                    <div class="d-flex align-items-center gap-5">
                                        <select class="form-select form-select-lg form-select-solid flex-grow-1" 
                                            id="reference_number" name="reference_number" data-control="select2" 
                                            data-placeholder="Select Reference">
                                            <option></option>
                                        </select>
                                        <button type="button" class="btn btn-info" id="btnViewDetails" style="height: 45px; min-width: 160px;">
                                            View Details
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!--End::Input Cases-->

                            <!--begin::Input Created By-->
                            <div class="fv-row row mb-10">
                                <!--begin::Label--> 
                                <label class="col-lg-4 col-form-label required fw-semibold fs-6 text-muted">Created By</label>
                                <!--end::Label-->
                                <div class="col-lg-8 fv-row">
                                    <input type="text" id="created_by" name="created_by" class="form-control form-control-lg form-control-solid" placeholder="Creator's Name" disabled />
                                </div>
                            </div>
                            <!--end::Input Craeted By-->

                            <!--begin::Input Position-->
                            <div class="fv-row row mb-10">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label required fw-semibold fs-6 text-muted">Position</label>
                                <!--end::Label-->
                                <div class="col-lg-8 fv-row">
                                    <input type="text" id="department" name="department" class="form-control form-control-lg form-control-solid" placeholder="Creator's Position" disabled />
                                </div>
                            </div>
                            <!--end::Input Position-->
                                    
                            <!--begin::Input date-->
                            <div class="fv-row row mb-10">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label required fw-semibold fs-6 text-muted">Date</label>
                                <!--end::Label-->
                                <div class="col-lg-8 fv-row">
                                    <input type="text" id="date" name="date" class="form-control form-control-lg form-control-solid" placeholder="Work Order Date" disabled />
                                </div>
                            </div>
                            <!--end::Input date-->

                            <!--begin::Input start date-->
                            <div class="fv-row row mb-10">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label fw-semibold fs-5 text-muted">
                                    <span class="required">Start Date</span>
                                    <span class="ms-1" data-bs-toggle="tooltip" title="Select the start date for this Work Order.">
                                        <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>
                                    </span>
                                </label>                                                
                                <!--end::Label-->
                                <div class="col-lg-8 fv-row">
                                    <input type="text" id="start_date" name="start_date" class="form-control form-control-lg form-control-solid" placeholder="Pick a date" />
                                </div>
                            </div>
                            <!--end::Input start date-->

                            <!--begin::Input end date-->
                            <div class="fv-row row mb-10">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label fw-semibold fs-5 text-muted">
                                    <span class="required">End Date</span>
                                    <span class="ms-1" data-bs-toggle="tooltip" title="Select the expected completion date for this Work Order.">
                                        <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>
                                    </span>
                                </label>
                                <!--end::Label-->
                                <div class="col-lg-8 fv-row">
                                    <input type="text" id="end_date" name="end_date" class="form-control form-control-lg form-control-solid" placeholder="Pick a date" />
                                </div>
                            </div>
                            <!--end::Input end date-->

                            <!--begin::Input assigned to-->
                            <div class="fv-row row mb-10">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label fw-semibold fs-5 text-muted">
                                    <span class="required">Assigned To</span>
                                    <span class="ms-1" data-bs-toggle="tooltip" title="Select the technician or team responsible for this Work Order.">
                                        <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>
                                    </span>
                                </label>
                                <!--end::Label-->
                                <div class="col-lg-8 fv-row">
                                    <select id="assigned_to" class="form-control form-control-lg form-control-solid" name="assigned_to[]" data-control="select2" data-close-on-select="false" data-placeholder="Select technician(s)" data-allow-clear="true" multiple="multiple">
                                </select>
                                </div>
                            </div>
                            <!--end::Input assingned to-->

                            <!--begin::Input Work Description-->
                            <div class="fv-row row mb-10">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label required fw-semibold fs-6 text-muted">Work Description</label>
                                <!--end::Label-->
                                <div class="col-lg-8 fv-row">
                                    <textarea class="form-control form-control-solid" rows="4" name="work_description" id="work_description" placeholder="Describe the work..."></textarea>
                                </div>
                            </div>
                            <!--end::Input Work Description-->

                            <!--begin::Input Work Description-->
                            <div class="fv-row row mb-10">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label fw-semibold fs-5 text-muted">
                                    <span class="required">Material Request</span>
                                    <span class="ms-1" data-bs-toggle="tooltip" title="Check this if materials are required to complete the Work Order.">
                                        <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>
                                    </span>
                                </label>
                                <!--end::Label-->
                                <div class="col-lg-8 fv-row">
                                    <input class="form-check-input me-3" name="require_material" type="checkbox" value="yes" id="require_material_checkbox" />
                                    <label class="form-check-label" for="require_material_checkbox">
                                        <div class="fw-semibold text-gray-800">Yes, I need materials for this work</div>
                                    </label>
                                </div>
                            </div>
                            <!--end::Input Work Description-->

                            <!--begin::Input Work Description-->
                            <div id="intended_for_section" class="fv-row row mb-10 d-none">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label fw-semibold fs-5 text-muted">
                                    <span class="required">Intended for</span>
                                    <span class="ms-1" data-bs-toggle="tooltip" title="Check this if materials are required to complete the Work Order.">
                                        <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>
                                    </span>
                                </label>
                                <!--end::Label-->
                                <div class="col-lg-8 fv-row">
                                    <select name="intended_for" class="form-select" id="intended_for">
                                        <option value="">Choose User</option>
                                    </select>
                                </div>
                            </div>
                            <!--end::Input Work Description-->
                        </div>
                        <!--end::Card body-->
                
                        <!-- Submit Button -->
                        <div class="text-end mt-4">
                            <button type="submit" class="btn btn-lg btn-primary shadow-sm px-5" id="kt_docs_formvalidation_text_submit">
                                Save Work Order
                            </button>
                        </div>
                    </form>                    
                </div>
            </div>
        </div>
    </div>




    {{-- <div id="app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="app_content_container" class="app-container container-xxl">
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
                            
                            <div id="work_order_form" class="collapse show">
                                <!--begin::Form-->
                                <form action="" id="kt_d                                                                                                             cs_formvalidation_text" enctype="multipart/form-data" method="POST">
                                    @csrf
                                    <!--begin::Card body-->
                                    <div class="card-body p-2">
                                
                                        <!--begin::Input Cases-->
                                        <div class="fv-row row mb-10">
                                            <!--begin::Label-->
                                            <label class="col-lg-4 col-form-label fw-semibold fs-5 text-muted">
                                                <span>Reference No.</span>
                                                <span class="ms-1" data-bs-toggle="tooltip" title="Select a Case No to be used as the reference for this work order.">
                                                    <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                    </i>
                                                </span>
                                            </label>
                                            <!--end::Label-->

                                            <div class="fv-row col-lg-8">
                                                <div class="d-flex align-items-center gap-5">
                                                    <select class="form-select form-select-lg form-select-solid flex-grow-1" 
                                                        id="reference_number" name="reference_number" data-control="select2" 
                                                        data-placeholder="Select Reference">
                                                        <option></option>
                                                    </select>
                                                    <button type="button" class="btn btn-info" id="btnViewDetails" style="height: 45px; min-width: 160px;">
                                                        View Details
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <!--End::Input Cases-->

                                        <!--begin::Input Created By-->
                                        <div class="fv-row row mb-10">
                                            <!--begin::Label--> 
                                            <label class="col-lg-4 col-form-label required fw-semibold fs-6 text-muted">Created By</label>
                                            <!--end::Label-->
                                            <div class="col-lg-8 fv-row">
                                                <input type="text" id="created_by" name="created_by" class="form-control form-control-lg form-control-solid" value="" disabled />
                                            </div>
                                        </div>
                                        <!--end::Input Craeted By-->

                                        <!--begin::Input Position-->
                                        <div class="fv-row row mb-10">
                                            <!--begin::Label-->
                                            <label class="col-lg-4 col-form-label required fw-semibold fs-6 text-muted">Position</label>
                                            <!--end::Label-->
                                            <div class="col-lg-8 fv-row">
                                                <input type="text" id="department" name="department" class="form-control form-control-lg form-control-solid" value="" disabled />
                                            </div>
                                        </div>
                                        <!--end::Input Position-->
                                                
                                        <!--begin::Input date-->
                                        <div class="fv-row row mb-10">
                                            <!--begin::Label-->
                                            <label class="col-lg-4 col-form-label required fw-semibold fs-6 text-muted">Date</label>
                                            <!--end::Label-->
                                            <div class="col-lg-8 fv-row">
                                                <input type="text" id="date" name="date" class="form-control form-control-lg form-control-solid" value="" disabled />
                                            </div>
                                        </div>
                                        <!--end::Input date-->

                                        <!--begin::Input start date-->
                                        <div class="fv-row row mb-10">
                                            <!--begin::Label-->
                                            <label class="col-lg-4 col-form-label fw-semibold fs-5 text-muted">
                                                <span class="required">Start Date</span>
                                                <span class="ms-1" data-bs-toggle="tooltip" title="Select the start date for this Work Order.">
                                                    <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                    </i>
                                                </span>
                                            </label>                                                
                                            <!--end::Label-->
                                            <div class="col-lg-8 fv-row">
                                                <input type="text" id="start_date" name="start_date" class="form-control form-control-lg form-control-solid" placeholder="Pick a date" />
                                            </div>
                                        </div>
                                        <!--end::Input start date-->

                                        <!--begin::Input end date-->
                                        <div class="fv-row row mb-10">
                                            <!--begin::Label-->
                                            <label class="col-lg-4 col-form-label fw-semibold fs-5 text-muted">
                                                <span class="required">End Date</span>
                                                <span class="ms-1" data-bs-toggle="tooltip" title="Select the expected completion date for this Work Order.">
                                                    <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                    </i>
                                                </span>
                                            </label>
                                            <!--end::Label-->
                                            <div class="col-lg-8 fv-row">
                                                <input type="text" id="end_date" name="end_date" class="form-control form-control-lg form-control-solid" placeholder="Pick a date" />
                                            </div>
                                        </div>
                                        <!--end::Input end date-->

                                        <!--begin::Input assigned to-->
                                        <div class="fv-row row mb-10">
                                            <!--begin::Label-->
                                            <label class="col-lg-4 col-form-label fw-semibold fs-5 text-muted">
                                                <span class="required">Assigned To</span>
                                                <span class="ms-1" data-bs-toggle="tooltip" title="Select the technician or team responsible for this Work Order.">
                                                    <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                    </i>
                                                </span>
                                            </label>
                                            <!--end::Label-->
                                            <div class="col-lg-8 fv-row">
                                                <select id="assigned_to" class="form-control form-control-lg form-control-solid" name="assigned_to[]" data-control="select2" data-close-on-select="false" data-placeholder="Select technician(s)" data-allow-clear="true" multiple="multiple">
                                            </select>
                                            </div>
                                        </div>
                                        <!--end::Input assingned to-->

                                        <!--begin::Input Work Description-->
                                        <div class="fv-row row mb-10">
                                            <!--begin::Label-->
                                            <label class="col-lg-4 col-form-label required fw-semibold fs-6 text-muted">Work Description</label>
                                            <!--end::Label-->
                                            <div class="col-lg-8 fv-row">
                                                <textarea class="form-control form-control-solid" rows="4" name="work_description" id="work_description" placeholder="Describe the work..."></textarea>
                                            </div>
                                        </div>
                                        <!--end::Input Work Description-->

                                        <!--begin::Input Work Description-->
                                        <div class="fv-row row mb-10">
                                            <!--begin::Label-->
                                            <label class="col-lg-4 col-form-label fw-semibold fs-5 text-muted">
                                                <span class="required">Material Request</span>
                                                <span class="ms-1" data-bs-toggle="tooltip" title="Check this if materials are required to complete the Work Order.">
                                                    <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                    </i>
                                                </span>
                                            </label>
                                            <!--end::Label-->
                                            <div class="col-lg-8 fv-row">
                                                <input class="form-check-input me-3" name="require_material" type="checkbox" value="yes" id="require_material_checkbox" />
                                                <label class="form-check-label" for="require_material_checkbox">
                                                    <div class="fw-semibold text-gray-800">Yes, I need materials for this work</div>
                                                </label>
                                            </div>
                                        </div>
                                        <!--end::Input Work Description-->

                                        <!--begin::Input Work Description-->
                                        <div id="intended_for_section" class="fv-row row mb-10 d-none">
                                            <!--begin::Label-->
                                            <label class="col-lg-4 col-form-label fw-semibold fs-5 text-muted">
                                                <span class="required">Intended for</span>
                                                <span class="ms-1" data-bs-toggle="tooltip" title="Check this if materials are required to complete the Work Order.">
                                                    <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                    </i>
                                                </span>
                                            </label>
                                            <!--end::Label-->
                                            <div class="col-lg-8 fv-row">
                                                <select name="intended_for" class="form-select" id="intended_for">
                                                    <option value="">Choose User</option>
                                                </select>
                                            </div>
                                        </div>
                                        <!--end::Input Work Description-->
                                    </div>
                                    <!--end::Card body-->

                                    <!--begin::Actions-->
                                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                                        <button id="kt_docs_formvalidation_text_submit" type="submit" class="btn btn-primary">
                                            <span class="indicator-label">
                                            Save Case
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
        <!--end::Content container--> --}}

    <!-- Page Loader -->
    <div id="material_loader" class="page-loader flex-column bg-dark bg-opacity-50 position-fixed top-0 start-0 w-100 h-100 justify-content-center align-items-center d-none" style="z-index: 9999;">
        <span class="spinner-border text-primary" role="status"></span>
        <span class="text-white fs-6 fw-semibold mt-5">Loading...</span>
    </div>

    <div class="page-loader flex-column bg-dark bg-opacity-50" id="page-loader">
        <span class="spinner-border text-primary" role="status"></span>
        <span class="text-gray-800 fs-6 fw-semibold mt-5">Loading...</span>
    </div>

    <div id="page_loader" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(88, 88, 88, 0.7); z-index:9999; justify-content:center; align-items:center;">
        <div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>
    </div>

    <!-- Modal Case Details -->
    <div class="modal fade" id="caseDetailsModal" tabindex="-1" aria-labelledby="caseDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="caseDetailsModalLabel">Case Details - <span id="modal_case_no"></span></h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- Left Column: Case Information -->
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label class="form-label text-muted"><strong>Category</strong></label>
                                <p class="fs-5 text-dark" id="modal_category"></p>
                            </div>
                            <div class="mb-4">
                                <label class="form-label text-muted"><strong>SubCategory</strong></label>
                                <p class="fs-5 text-dark" id="modal_subcategory"></p>
                            </div>
                            <div class="mb-4">
                                <label class="form-label text-muted"><strong>Created By</strong></label>
                                <p class="fs-5 text-dark" id="modal_created_by"></p>
                            </div>
                            <div class="mb-4">
                                <label class="form-label text-muted"><strong>Department</strong></label>
                                <p class="fs-5 text-dark" id="modal_department"></p>
                            </div>
                        </div>

                        <!-- Right Column: Approval Status Table -->
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label class="form-label"><strong>Approval Status</strong></label>
                                <table class="table table-bordered table-hover" id="approval_status_table">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Approver</th>
                                            <th>Case Remark</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label"><strong>Case Chronology</strong></label>
                            <textarea class="form-control" id="modal_chronology" rows="4" readonly></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><strong>Case Outcome</strong></label>
                            <textarea class="form-control" id="modal_outcome" rows="4" readonly></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><strong>Case Suggest</strong></label>
                            <textarea class="form-control" id="modal_suggest" rows="4" readonly></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><strong>Case Action</strong></label>
                            <textarea class="form-control" id="modal_action" rows="4" readonly></textarea>
                        </div>
                    </div>

                    {{-- Image --}}
                    <div class="col-md-12">
                        <div class="mb-4" id="case_photos">
                            <div class="d-flex flex-wrap justify-content-start">
                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('content.wo.partial.CreateWOJs')

    <script>
        const BASE_URL = "{{ url('/') }}";
    </script>
@endsection

