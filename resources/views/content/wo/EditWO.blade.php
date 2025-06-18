@extends('layouts.Master')

@section('title', 'Work Order Management')
@section('subtitle', 'Edit Work Order')

@section('content')
    
    <style>
        .flatpickr-day.today {
            background: #979797 !important; 
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
                                        <form action="" method="POST" id="kt_docs_formvalidation_text" enctype="multipart/form-data" class="form">
                                            @csrf
                                            <input type="hidden" name="wo_no" value="{{ $wo->WO_No }}">                    
                                            <!--begin::Card body-->
                                            <div class="card-body p-2">

                                                <!--begin::Alert-->
                                                <div class="alert alert-dismissible bg-light-warning border-dashed border-warning d-flex flex-column flex-sm-row p-5 mb-10" >
                                                    <!--begin::Icon-->
                                                    <i class="ki-duotone ki-notepad-edit fs-2hx text-gray-700 me-4 mb-5 mb-sm-0">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>  
                                                    <!--end::Icon-->

                                                    <!--begin::Wrapper-->
                                                    <div class="d-flex flex-column pe-0 pe-sm-10">
                                                        <!--begin::Title-->
                                                        <h5 class="mb-1 text-gray-900">Review Your Work Orders Data Before Proceeding</h5>
                                                        <!--end::Title-->

                                                        <!--begin::Content-->
                                                        <span class="text-gray-600">Please double-check the saved Work Orders data. Make sure all information is accurate before moving on to the next process.</span>
                                                        <!--end::Content-->
                                                    </div>
                                                    <!--end::Wrapper-->

                                                    <!--begin::Close-->
                                                    <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
                                                        <i class="ki-duotone ki-cross fs-1 text-success"><span class="path1"></span><span class="path2"></span></i>
                                                    </button>
                                                    <!--end::Close-->
                                                </div>
                                                <!--end::Alert-->

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
                                                            <select class="form-select form-select-lg form-select-solid flex-grow-1 exclude-disable" 
                                                                id="reference_number" name="reference_number" data-control="select2" 
                                                                data-placeholder="Select Reference">
                                                                <option value="{{ $case->Case_No }}" selected>{{ $case->Case_No }}</option>
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
                                                        <input type="text" id="created_by" name="created_by" class="form-control form-control-lg form-control-solid exclude-disable" 
                                                        value="{{ $case->user->Fullname }}" disabled />
                                                    </div>
                                                </div>
                                                <!--end::Input Craeted By-->

                                                <!--begin::Input Position-->
                                                <div class="fv-row row mb-10">
                                                    <!--begin::Label-->
                                                    <label class="col-lg-4 col-form-label required fw-semibold fs-6 text-muted">Position</label>
                                                    <!--end::Label-->
                                                    <div class="col-lg-8 fv-row">
                                                        <input type="text" id="department" name="department" class="exclude-disable form-control form-control-lg form-control-solid" 
                                                        value="{{ $case->user->position->PS_Name }}" disabled />
                                                    </div>
                                                </div>
                                                <!--end::Input Position-->
                                                        
                                                <!--begin::Input date-->
                                                <div class="fv-row row mb-10">  
                                                    <!--begin::Label-->
                                                    <label class="col-lg-4 col-form-label required fw-semibold fs-6 text-muted">Date</label>
                                                    <!--end::Label-->
                                                    <div class="col-lg-8 fv-row">
                                                        <input type="text" id="date" name="date" class="exclude-disable form-control form-control-lg form-control-solid" 
                                                            value="{{ $case->created_at->format('d/m/Y H:i') }}" disabled />
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
                                                        <input class="form-control form-control-lg form-control-solid" id="start_date" name="start_date" placeholder="Pick a date"
                                                            value="{{ Carbon\Carbon::parse($wo->WO_Start)->format('d/m/Y H:i') }}" />
                                                    </div>
                                                </div>
                                                <!--end::Input start date-->

                                                <!--begin::Input end date-->
                                                <div class="fv-row row mb-10">
                                                    <!--begin::Label-->
                                                    <label class="col-lg-4 col-form-label fw-semibold fs-5 text-muted">
                                                        <span class="required">Estimate Date</span>
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
                                                        <input class="form-control form-control-lg form-control-solid" id="end_date" name="end_date" placeholder="Pick a date" value="{{ old('end_date', \Carbon\Carbon::parse($wo->WO_End)->format('d/m/Y H:i')) }}" />
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
                                                        <select class="form-select form-select-lg form-select-solid" 
                                                        name="assigned_to[]" 
                                                        data-control="select2" 
                                                        data-close-on-select="false" 
                                                        data-placeholder="Select technician" 
                                                        data-allow-clear="true" 
                                                        multiple="multiple">
                                                        
                                                        <option></option>
                                                        @foreach($technicians as $tech)
                                                            <option value="{{ $tech->technician_id }}" 
                                                                {{ in_array($tech->technician_id, $selectedTechnicians) ? 'selected' : '' }}>
                                                                {{ $tech->technician_id }} - {{ $tech->technician_Name }}
                                                            </option>
                                                        @endforeach
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
                                                        <textarea name="work_description" class="form-control form-control-solid" rows="4" id="work_description"
                                                        placeholder="Describe the work...">{{ old('work_description', $wo->WO_Narative) }}</textarea>
                        
                                                    </div>
                                                </div>
                                                <!--end::Input Work Description-->

                                                <!--begin::Input CHECKBOX MR-->
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
                                                        <input class="form-check-input me-3 readonly-checkbox" name="require_material" type="checkbox" 
                                                        value="yes" id="require_material_checkbox" {{ $wo->WO_NeedMat == 'Y' ? 'checked' : '' }} />
                                                    
                                                        <label class="form-check-label" for="require_material_checkbox">
                                                            <div class="fw-semibold text-gray-800">Yes, I need materials for this work</div>
                                                        </label>
                                                    </div>
                                                </div>
                                                <!--end::Input checkbox mr-->

                                                <!--begin::Input Itended For-->
                                                <div id="intended_for_section" class="fv-row row mb-10 {{ $wo->WO_NeedMat == 'Y' ? '' : 'd-none' }} readonly-select">
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
                                                        <select name="intended_for" class="form-select readonly-select" id="intended_for">
                                                            <option value="">Choose User</option>
                                                            @foreach($users as $user)
                                                                <option value="{{ $user->id }}" {{ $user->id == $wo->WO_MR ? 'selected' : '' }}>
                                                                    {{ $user->Fullname }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <!--end::Input Itended For-->
                                            </div>
                                            <!--end::Card body-->
                                            
                                            <!--begin::Actions-->
                                            <div class="card-footer d-flex justify-content-end py-6 px-9 gap-4">
                                                <button id="btnEditWO" type="button" class="btn btn-warning">
                                                    Edit Work Order
                                                </button>
                                                
                                                <button id="kt_docs_formvalidation_text_save" type="submit" class="btn btn-info" name="save_case" value="1">
                                                    <span class="indicator-label text">
                                                      Save Work Order
                                                    </span>
                                                    <span class="indicator-progress">
                                                        Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                                    </span>
                                                </button>
                                                
                                                <button id="kt_docs_formvalidation_text_submit" type="submit" class="btn btn-primary">
                                                    <span class="indicator-label">
                                                    Submit Work Order
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

    <!-- Page Loader -->
    <div class="page-loader flex-column bg-dark bg-opacity-25" style="display:none;">
        <span class="spinner-border text-primary" role="status"></span>
        <span class="text-gray-800 fs-6 fw-semibold mt-5">Loading...</span>
    </div>

    <div id="material_loader" class="page-loader flex-column bg-dark bg-opacity-50 position-fixed top-0 start-0 w-100 h-100 justify-content-center align-items-center d-none" style="z-index: 9999;">
        <span class="spinner-border text-primary" role="status"></span>
        <span class="text-white fs-6 fw-semibold mt-5">Loading...</span>
    </div>

    <!-- Modal Case Details -->
    <div class="modal fade" id="caseDetailsModal" tabindex="-1" aria-labelledby="caseDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="caseDetailsModalLabel">
                    Case Details – <span id="modal_case_no"></span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <!-- Bagian Informasi Utama (Category, Subcategory, Created By, Department) -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <dl class="row mb-2">
                            <dt class="col-sm-4 text-muted">Category</dt>
                            <dd class="col-sm-8 fw-semibold" id="modal_category"></dd>
                            </dl>
                            <dl class="row mb-0">
                            <dt class="col-sm-4 text-muted">SubCategory</dt>
                            <dd class="col-sm-8 fw-semibold" id="modal_subcategory"></dd>
                            </dl>
                        </div>

                        <div class="col-md-6">
                            <dl class="row mb-2">
                            <dt class="col-sm-4 text-muted">Created By</dt>
                            <dd class="col-sm-8 fw-semibold" id="modal_created_by"></dd>
                            </dl>
                            <dl class="row mb-0">
                            <dt class="col-sm-4 text-muted">Department</dt>
                            <dd class="col-sm-8 fw-semibold" id="modal_department"></dd>
                            </dl>
                        </div>
                    </div>

                    <hr class="my-3">

                    <!-- Bagian Detail Textareas (Chronology, Outcome, Suggest, Action) -->
                    <div class="row gx-3 gy-3">
                    <div class="col-lg-6">
                        <label for="modal_chronology" class="form-label text-muted">Case Chronology</label>
                        <textarea
                        class="form-control form-control-sm"
                        id="modal_chronology"
                        rows="2"
                        readonly
                        ></textarea>
                    </div>

                    <div class="col-lg-6">
                        <label for="modal_outcome" class="form-label text-muted">Case Outcome</label>
                        <textarea
                        class="form-control form-control-sm"
                        id="modal_outcome"
                        rows="2"
                        readonly
                        ></textarea>
                    </div>

                    <div class="col-lg-6">
                        <label for="modal_suggest" class="form-label text-muted">Case Suggest</label>
                        <textarea
                        class="form-control form-control-sm"
                        id="modal_suggest"
                        rows="2"
                        readonly
                        ></textarea>
                    </div>

                    <div class="col-lg-6">
                        <label for="modal_action" class="form-label text-muted">Case Action</label>
                        <textarea
                        class="form-control form-control-sm"
                        id="modal_action"
                        rows="2"
                        readonly
                        ></textarea>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const BASE_URL = "{{ url('/') }}";
    </script>

    @include('content.wo.partial.EditWOJs')

        <script>
        $(document).ready(function () {
             $('#assigned_to').select2({
            ajax: {
                url: "{{ route('GetTechnician') }}",
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {
                        results: data 
                    };
                },
                cache: true
            },
            placeholder: 'Select technician(s)',
            minimumInputLength: 0,
            allowClear: true
        });
            
        });
    </script>
@endsection
