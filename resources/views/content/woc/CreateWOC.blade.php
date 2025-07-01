@extends('layouts.Master')

@section('title', 'Work Order Complition Management')
@section('subtitle', 'Create Work Order Complition')

@section('content')
    
    <style>
        .flatpickr-day.today {
            background: #979797 !important; 
            color: #fff !important;
            border-radius: 6px;
        }
    </style>

    <div id="app_content" class="app-content flex-column-fluid">
        <div id="app_content_container" class="app-container container-xxl">
            <div class="card shadow-sm rounded-3 border-0">
                <!--begin::Card head-->
                <div class="card-header card-header-stretch">
                    <!--begin::Title-->
                    <div class="card-title d-flex align-items-center">
                        <h3 class="fw-bold m-0 text-gray-800">@yield('subtitle')</h3>
                    </div>
                    <!--end::Title-->
                </div>
                <!--end::Card head-->

                <div id="work_order_complition_form" class="card-body p-5">
                    <form id="WOCFrom" enctype="multipart/form-data" method="POST">
                        @csrf
                        <input type="hidden" id="wo_no" value="{{ $woNo }}">
                        <input type="hidden" id="wo_no" name="wo_no" value="{{ $woNo }}">

                        <!--begin::Card body-->
                        <div class="card-body p-2">
                           
                            <!--begin::Refeerence Cases-->
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
                                    </div>
                                </div>
                                
                            </div>
                            <!--End::Refeerence Cases-->

                            <!--begin::Input Case No-->
                            <div class="fv-row row mb-10">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label fw-semibold fs-6 text-muted">Case No</label>
                                <!--end::Label-->
                                <div class="col-lg-8 fv-row">
                                    <input type="text" id="case_no" name="case_no" class="form-control form-control-lg form-control-solid" placeholder="Work Order Date" disabled />
                                </div>
                            </div>
                            <!--end::Input Case No-->

                            <!--begin::Input Case Name-->
                            <div class="fv-row row mb-10">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label fw-semibold fs-6 text-muted">Case Name</label>
                                <!--end::Label-->
                                <div class="col-lg-8 fv-row">
                                    <input type="text" id="case_name" name="case_name" class="form-control form-control-lg form-control-solid" placeholder="Work Order Date" disabled />
                                </div>
                            </div>
                            <!--end::Input Case Name-->

                            <!--begin::Input date-->
                            <div class="fv-row row mb-10">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label fw-semibold fs-6 text-muted">Work Order Date</label>
                                <!--end::Label-->
                                <div class="col-lg-8 fv-row">
                                    <input type="text" id="work_order_date" name="work_order_date" class="form-control form-control-lg form-control-solid" placeholder="Work Order Date" disabled />
                                </div>
                            </div>
                            <!--end::Input date-->

                            <!--begin::Input Created By-->
                            <div class="fv-row row mb-10">
                                <!--begin::Label--> 
                                <label class="col-lg-4 col-form-label fw-semibold fs-6 text-muted">Created By</label>
                                <!--end::Label-->
                                <div class="col-lg-8 fv-row">
                                    <input type="text" id="created_by" name="created_by" class="form-control form-control-lg form-control-solid" placeholder="Creator's Name" disabled />
                                </div>
                            </div>
                            <!--end::Input Craeted By-->

                            <!--begin::Input Position-->
                            <div class="fv-row row mb-10">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label fw-semibold fs-6 text-muted">Position</label>
                                <!--end::Label-->
                                <div class="col-lg-8 fv-row">
                                    <input type="text" id="position" name="position" class="form-control form-control-lg form-control-solid" placeholder="Creator's Position" disabled />
                                </div>
                            </div>
                            <!--end::Input Position-->

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
                                    <span class="required">Complete Date</span>
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
                                    <select id="assigned_to" name="assigned_to[]" multiple="multiple"
                                        class="form-select form-select-lg form-select-solid"
                                        data-control="select2" data-close-on-select="false"
                                        data-placeholder="Select technician" data-allow-clear="true">
                                        @foreach($selectedTechnicians as $technician)
                                            <option value="{{ $technician->technician_id }}"
                                                {{ in_array($technician->technician_id, $selectedTechnicians) ? 'selected' : '' }}>
                                                {{ $technician->technician_name }}
                                            </option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                            <!--end::Input assingned to-->

                            <!--begin::Input Work Description-->
                            <div class="fv-row row mb-10">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label required fw-semibold fs-6 text-muted">Work Order Description</label>
                                <!--end::Label-->
                                <div class="col-lg-8 fv-row">
                                    <textarea class="form-control form-control-solid" rows="4" name="work_description" id="work_description" placeholder="Describe the work..."></textarea>
                                </div>
                            </div>
                            <!--end::Input Work Description-->

                            <!--begin::Input Image Dropzone-->
                            <div class="row mb-5">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label required fw-semibold fs-6">Upload Image</label>
                                <!--end::Label-->
                                <div class="fv-row mt-3">
                                    <div class="dropzone" id="case-dropzone" name="photos[]">
                                        <div class="dz-message needsclick">
                                            <i class="ki-duotone ki-file-up text-primary fs-3x">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                            <div class="ms-4">
                                                <h3 class="fs-5 fw-bold text-gray-900 mb-1">Drop files here or click to upload.</h3>
                                                <span class="fs-7 fw-semibold text-gray-500">Upload up to 5 files</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Input Image Dropzone-->

                        </div>
                        <!--end::Card body-->

                        <!-- Submit Button -->
                        <div class="text-end mt-4">
                            <button id="kt_docs_formvalidation_text_submit" type="submit" class="btn btn-primary shadow-sm px-5">
                                <span class="indicator-label">
                                  Create Work Order Complition
                                </span>
                                <span class="indicator-progress">
                                    Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>
                        </div>
                      
                    </form>    
                </div>
            </div>
        </div>
    </div>

    <div class="page-loader flex-column bg-dark bg-opacity-50" id="page-loader">
        <span class="spinner-border text-primary" role="status"></span>
        <span class="text-gray-800 fs-6 fw-semibold mt-5">Loading...</span>
    </div>


    @include('content.woc.partial.createwocjs')


@endsection
