@extends('layouts.Master')

@section('title', 'Work Order Management')
@section('subtitle', 'Edit Work Order')

@section('content')

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
                                                        <select class="form-select form-select-lg form-select-solid flex-grow-1" 
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
                                                    <input type="text" id="created_by" name="created_by" class="form-control form-control-lg form-control-solid" 
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
                                                    <input type="text" id="department" name="department" class="form-control form-control-lg form-control-solid" 
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
                                                    <input type="text" id="date" name="date" class="form-control form-control-lg form-control-solid" 
                                                        value="{{ $case->created_at->format('d/m/Y') }}" disabled />
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
                                                        value="{{ Carbon\Carbon::parse($wo->WO_Start)->format('Y/m/d H:i') }}" />
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
                                                    <input class="form-control form-control-lg form-control-solid" id="end_date" name="end_date" placeholder="Pick a date" value="{{ old('end_date', \Carbon\Carbon::parse($wo->WO_End)->format('Y-m-d')) }}" />

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
                                                    <select class="form-select form-select-sm form-select-solid" 
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
                                                </select></select>
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
                                                    <input class="form-check-input me-3" name="require_material" type="checkbox" 
                                                    value="yes" id="require_material_checkbox" {{ $wo->WO_NeedMat == 'Y' ? 'checked' : '' }} />
                                                
                                                    <label class="form-check-label" for="require_material_checkbox">
                                                        <div class="fw-semibold text-gray-800">Yes, I need materials for this work</div>
                                                    </label>
                                                </div>
                                            </div>
                                            <!--end::Input Work Description-->

                                            <!--begin::Input Work Description-->
                                            <div id="intended_for_section" class="fv-row row mb-10 {{ $wo->WO_NeedMat == 'Y' ? '' : 'd-none' }}"">
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
                                                        @foreach($users as $user)
                                                            <option value="{{ $user->id }}" {{ $user->id == $wo->WO_MR ? 'selected' : '' }}>
                                                                {{ $user->Fullname }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <!--end::Input Work Description-->
                                        </div>
                                        <!--end::Card body-->
                                        

                                        <!--begin::Actions-->
                                        <div class="card-footer d-flex justify-content-end py-6 px-9">
                                            {{-- <button type="reset" class="btn btn-light btn-active-light-primary me-2">Discard</button>
                                            <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">Save Changes</button>
                                             --}}
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




{{-- 
    <div id="app_content" class="app-content flex-column-fluid">
        <div id="app_content_container" class="app-container container-fluid">
            <div class="card shadow-sm rounded-3 border-0">
                <div class="card-header text-white py-5 mb-2 text-center">
                    <h3 class="fw-bold m-0 mt-3">@yield('title') - @yield('subtitle')</h3>
                </div>

                <div id="work_order_form" class="card-body p-5">
                    <form id="kt_docs_formvalidation_text" enctype="multipart/form-data" method="POST">
                        @csrf
                        <input type="hidden" name="wo_no" value="{{ $wo->WO_No }}">                    
                        
                        <!-- Reference Number -->
                        <div class="fv-row mb-3">
                            <label class="form-label fw-semibold">Reference No.</label>
                            <div class="d-flex gap-5">
                                <select class="form-select form-select-lg form-select-solid flex-grow-1" 
                                    id="reference_number" name="reference_number" data-control="select2" 
                                    data-placeholder="Select Reference">
                                    <option value="{{ $case->Case_No }}" selected>{{ $case->Case_No }}</option>
                                </select>

                                <button type="button" class="btn btn-info" style="height: 45px; width: 150px;" id="btnViewDetails">
                                    View Details
                                </button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="fv-row col-md-6 mb-3">
                                <label class="form-label fw-semibold">Created By</label>
                                <input type="text" id="created_by" name="created_by" class="form-control form-control-solid" 
                                value="{{ $case->user->Fullname }}" disabled />
                            </div>
                            <div class="fv-row col-md-6 mb-3">
                                <label class="form-label fw-semibold">Departement</label>
                                <input type="text" id="department" name="department" class="form-control form-control-solid" 
                                     value="{{ $case->user->position->PS_Name }}" disabled />

                            </div>
                        </div>
                    
                        <div class="fv-row mb-3">
                            <label class="form-label fw-semibold">Date</label>
                            <input type="text" id="date" name="date" class="form-control form-control-solid" 
                                value="{{ $case->created_at->format('d/m/Y') }}" disabled />
                        </div>
                    
                        <hr>
                      
                        <div class="mb-10">
                            <label for="start_date" class="form-label fw-semibold">Start Date</label>
                            <input class="form-control" id="start_date" name="start_date" placeholder="Pick a date"
                            value="{{ Carbon\Carbon::parse($wo->WO_Start)->format('Y/m/d H:i') }}" />
                        
                        </div>

                        <div class="mb-10">
                            <label for="end_date" class="form-label fw-semibold">End Date</label>
                            <input class="form-control" id="end_date" name="end_date" placeholder="Pick a date" value="{{ old('end_date', \Carbon\Carbon::parse($wo->WO_End)->format('Y-m-d')) }}" />
                        </div>
                        
                        <div class="fv-row mb-3">
                            <label class="form-label fw-semibold">Assigned To</label>
                            <select class="form-select form-select-sm form-select-solid" 
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

                        <div class="fv-row mb-3">
                            <label class="form-label fw-semibold">Work Description</label>
                            <textarea name="work_description" class="form-control form-control-solid" rows="4" 
                                placeholder="Describe the work...">{{ old('work_description', $wo->WO_Narative) }}</textarea>

                        </div>
                    
                        <!-- Material Request Checkbox -->
                        <div class="fv-row mb-10">
                            <label class="fw-semibold fs-6 mb-3">Do you require a Material Request?</label>
                            <div class="form-check form-check-custom form-check-solid">
                                <input class="form-check-input me-3" name="require_material" type="checkbox" 
                                value="yes" id="require_material_checkbox" {{ $wo->WO_NeedMat == 'Y' ? 'checked' : '' }} />
                            
                                <label class="form-check-label" for="require_material_checkbox">
                                    <div class="fw-semibold text-gray-800">Yes, I need materials for this work</div>
                                </label>
                            </div>
                        </div>

                        <!-- Intended For Section -->
                        <div id="intended_for_section" class="fv-row col-md-6 mb-5 {{ $wo->WO_NeedMat == 'Y' ? '' : 'd-none' }}">
                            <label class="form-label fs-7">Intended for <span class="text-danger">*</span></label>
                            <select name="intended_for" class="form-select" id="intended_for">
                                <option value="">Choose User</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ $user->id == $wo->WO_MR ? 'selected' : '' }}>
                                        {{ $user->Fullname }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Submit Button -->
                        <div class="text-end mt-4">
                            <button type="submit" class="btn btn-lg btn-primary shadow-sm px-5" id="kt_docs_formvalidation_text_submit">
                                Submit Work Order
                            </button>
                        </div>
                    </form>                    
                </div>
            </div>
        </div>
    </div> --}}

    <!-- Page Loader -->
    <div class="page-loader flex-column bg-dark bg-opacity-25" style="display:none;">
        <span class="spinner-border text-primary" role="status"></span>
        <span class="text-gray-800 fs-6 fw-semibold mt-5">Loading...</span>
    </div>

    <div id="material_loader" class="page-loader flex-column bg-dark bg-opacity-50 position-fixed top-0 start-0 w-100 h-100 justify-content-center align-items-center d-none" style="z-index: 9999;">
        <span class="spinner-border text-primary" role="status"></span>
        <span class="text-white fs-6 fw-semibold mt-5">Loading...</span>
    </div>


    <script>
        const BASE_URL = "{{ url('/') }}";
    </script>

    @include('content.wo.partial.EditWOJs')


@endsection
