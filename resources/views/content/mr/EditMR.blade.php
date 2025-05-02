@extends('layouts.Master')

@section('title', 'Material Request Management')
@section('subtitle', 'Create Edit Material Request')

@section('content')

    <style>
        table input,
        table select {
            min-width: 100px;
        }

        .table td,
        .table th {
            vertical-align: middle !important;
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
                                            <input type="hidden" name="wo_no" value="{{ $matReq->WO_No }}">
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
                                                    <h5 class="mb-1 text-gray-900">Review Your Material Request Data Before Proceeding</h5>
                                                    <!--end::Title-->

                                                    <!--begin::Content-->
                                                    <span class="text-gray-600">Please double-check the saved Material Request data. Make sure all information is accurate before moving on to the next process.</span>
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
                                                                id="reference_number" name="reference_number" data-control="select2" 
                                                                data-placeholder="Select Reference">
                                                            <option value="{{ $matReq->WO_No }}" 
                                                                {{ $matReq->WO_No == old('reference_number', $matReq->WO_No) ? 'selected' : '' }}>
                                                                {{ $matReq->WO_No }}
                                                            </option>
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
                                                            <input type="text" id="case_no" name="case_no" class="form-control form-control-lg form-control-solid" readonly placeholder="Auto-generated Case No"   value="{{ $matReq->Case_No }}" />
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
                                                                class="form-control form-control-solid" disabled placeholder="Auto-generated Creator" 
                                                                value="{{ $matReq->createdBy->Fullname ?? '-' }}"/>
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
                                                                class="form-control form-control-solid" disabled placeholder="Creator's Position" value="{{ $matReq->createdBy->position->PS_Name ?? '-' }}" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--end::Input Created By-->

                                                <!--begin::Input Date-->
                                                <div class="row mb-10">
                                                    <!--begin::Label-->
                                                    <label class="col-lg-4 col-form-label required fw-semibold fs-5 text-muted">
                                                        Work Order Date
                                                    </label>
                                                    <!--end::Label-->
                                                    
                                                    <div class="col-lg-8">
                                                        <div class="col-lg-20 fv-row">
                                                            <input type="date" class="form-control form-control-solid" id="date" name="date" placeholder="Select the work order date"
                                                            value="{{ \Carbon\Carbon::parse($matReq->MR_Date)->format('d/m/Y H:m') }}" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--end::Input Wo Date-->

                                                <!--begin:: Designation-->
                                                <div class="row mb-10">
                                                    <!--begin::Label-->
                                                    <label class="col-lg-4 col-form-label required fw-semibold fs-5 text-muted">
                                                        Work Order Designation
                                                    </label>
                                                    <!--end::Label-->
                                                    
                                                    <div class="col-lg-8">
                                                        <div class="col-lg-20 fv-row">
                                                            <textarea name="Designation" class="form-control form-control-solid" 
                                                            rows="4" placeholder="What it is intended for...">{{ $matReq->MR_Allotment }}</textarea>   
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
                                                                @forelse ($matReqChilds as $index => $child)
                                                                    <tr>
                                                                        <td class="text-center">{{ $index + 1 }}</td>
                                                                        <td>
                                                                            <input type="number" name="items[{{ $index }}][qty]" class="fv-row form-control form-control-lg" 
                                                                                value="{{ $child->Item_Oty }}" >
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" name="items[{{ $index }}][unit]" class="fv-row form-control form-control-lg" 
                                                                                value="{{ $child->CR_ITEM_SATUAN }}">
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" name="items[{{ $index }}][code]" class="fv-row form-control form-control-lg" 
                                                                                value="{{ $child->CR_ITEM_CODE }}">
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" name="items[{{ $index }}][name]" class="fv-row form-control form-control-lg" 
                                                                                value="{{ $child->CR_ITEM_NAME }}" >
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" name="items[{{ $index }}][desc]" class="fv-row form-control form-control-lg" 
                                                                                value="{{ $child->Remark }}">
                                                                        </td>

                                                                        <td class="text-center text-white">
                                                                            <button type="button" class="btn btn-danger remove-row text-center text-white delete-material"
                                                                                data-mrno="{{ $child->MR_No }}" data-mrline="{{ $child->MR_Line }}">
                                                                                <i class="ki-duotone ki-trash fs-2x text-center text-white">
                                                                                    <span class="path1"></span>
                                                                                    <span class="path2"></span>
                                                                                    <span class="path3"></span> 
                                                                                    <span class="path4"></span>
                                                                                    <span class="path5"></span>
                                                                                </i>
                                                                            </button>
                                                                        </td>

                                                                    </tr>
                                                                    @endforeach
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
                                                    Submit Material Request
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


    {{-- Design Lama --}}
    {{-- <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">
            <div class="card mb-5 shadow-sm rounded-3">
                <div class="card-header border-0 pt-5 pb-3">
                    <h3 class="fw-bold fs-1">@yield('title') - @yield('subtitle')</h3>
                </div>

                <div id="kt_account_settings_profile_details" class="collapse show">
                    <div class="card-body border-top p-5">
                        <form method="POST" id="MrForm" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="wo_no" value="{{ $matReq->WO_No }}">

                            <div class="fv-row mb-5">
                                <label class="form-label fw-semibold">References No.</label>
                                <select class="form-select form-select-lg form-select-solid" 
                                        id="reference_number" name="reference_number" data-control="select2" 
                                        data-placeholder="Select Reference">
                                    <option value="{{ $matReq->WO_No }}" 
                                        {{ $matReq->WO_No == old('reference_number', $matReq->WO_No) ? 'selected' : '' }}>
                                        {{ $matReq->WO_No }}
                                    </option>
                                </select>
                            </div>

                            <div class="row mb-5">
                                <div class="fv-row  col-md-6">
                                    <label class="form-label fw-semibold">Case No</label>
                                    <input type="text" id="case_no" name="case_no" 
                                        class="form-control form-control-solid" 
                                        value="{{ $matReq->Case_No }}" readonly />
                                </div>
                                <div class="fv-row  col-md-6">
                                    <label class="form-label fw-semibold">Date</label>
                                    <input type="date" class="form-control form-control-solid" 
                                        id="date" name="date" 
                                        value="{{ \Carbon\Carbon::parse($matReq->MR_Date)->format('Y-m-d') }}" />
                                </div>
                            </div>

                            <div class="row mb-5">
                                <div class="fv-row  col-md-6">
                                    <label class="form-label fw-semibold">Created By</label>
                                    <input type="text" class="form-control form-control-solid" 
                                        value="{{ $matReq->createdBy->Fullname ?? '-' }}" disabled />
                                </div>
                                <div class="fv-row  col-md-6">
                                    <label class="form-label fw-semibold">Department</label>
                                    <input type="text" class="form-control form-control-solid" 
                                        value="{{ $matReq->createdBy->position->PS_Name ?? '-' }}" disabled />
                                </div>
                            </div>

                            <div class="fv-row  mb-6">
                                <label class="form-label fw-semibold">Designation</label>
                                <textarea name="Designation" class="form-control form-control-solid" rows="4" 
                                    placeholder="What it is intended for...">{{ $matReq->MR_Allotment }}</textarea>
                            </div>

                            

                            <h4 class="fw-bold mb-4">Add Material List</h4>

                            <div class="table-responsive mb-4">
                                <table class="table table-bordered table-striped align-middle" id="material-table">
                                    <thead class="table-light text-center align-middle">
                                        <tr>
                                            <th style="width: 50px;">No</th>
                                            <th style="width: 120px;">Quantity</th>
                                            <th style="width: 100px;">Unit</th>
                                            <th style="width: 150px;">Item Code</th>
                                            <th>Item Name</th>
                                            <th>Description</th>
                                            <th style="width: 80px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="material-body">
                                        @forelse ($matReqChilds as $index => $child)
                                            <tr>
                                                <td class="text-center">{{ $index + 1 }}</td>
                                                <td>
                                                    <input type="number" name="items[{{ $index }}][qty]" class="form-control form-control-sm" 
                                                        value="{{ $child->Item_Oty }}" required>
                                                </td>
                                                <td>
                                                    <input type="text" name="items[{{ $index }}][unit]" class="form-control form-control-sm" 
                                                        value="{{ $child->CR_ITEM_SATUAN }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="items[{{ $index }}][code]" class="form-control form-control-sm" 
                                                        value="{{ $child->CR_ITEM_CODE }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="items[{{ $index }}][name]" class="form-control form-control-sm" 
                                                        value="{{ $child->CR_ITEM_NAME }}" required>
                                                </td>
                                                <td>
                                                    <input type="text" name="items[{{ $index }}][desc]" class="form-control form-control-sm" 
                                                        value="{{ $child->Remark }}">
                                                </td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-sm btn-danger remove-row" title="Remove row">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td class="text-center">1</td>
                                                <td><input type="number" name="items[0][qty]" class="form-control form-control-sm" ></td>
                                                <td><input type="text" name="items[0][unit]" class="form-control form-control-sm"></td>
                                                <td><input type="text" name="items[0][code]" class="form-control form-control-sm"></td>
                                                <td><input type="text" name="items[0][name]" class="form-control form-control-sm" ></td>
                                                <td><input type="text" name="items[0][desc]" class="form-control form-control-sm"></td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-sm btn-danger remove-row" title="Remove row">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                    
                                </table>
                            </div>

                            <div class="mb-5">
                                <button type="button" id="add-row" class="btn btn-sm btn-primary">+ Add Row</button>
                            </div>

                            <div class="d-flex justify-content-end">
                                <button id="kt_docs_formvalidation_text_submit" type="submit" class="btn btn-lg btn-success">
                                    <span class="indicator-label">Submit Material Request</span>
                                    <span class="indicator-progress">Please wait...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <div id="page_loader" class="page-loader flex-column bg-dark bg-opacity-25" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 9999; align-items: center; justify-content: center;">
        <span class="spinner-border text-primary" role="status"></span>
        <span class="text-white-800 fs-6 fw-semibold mt-5 text-white">Loading...</span>
    </div>

    {{-- Date --}}
    <script>
        $("#date").flatpickr({
            altInput: true,
            altFormat: "d/m/Y",
            dateFormat: "Y-m-d",
        });
    </script>
    
    {{-- Script Untuk Update MR + Validatation --}}
    <script>
        const form = document.getElementById('MrForm');
        const pageLoader = document.getElementById('page_loader');
        const submitButton = document.getElementById('kt_docs_formvalidation_text_submit');
    
        function validateMaterialTable() {
            const rows = document.querySelectorAll('#material-body tr');
            let isValid = true;
    
            if (rows.length === 0) {
                Swal.fire({
                    title: 'Validation Error!',
                    text: 'Material List cannot be empty. Please add at least one item.',
                    icon: 'warning',
                    confirmButtonText: 'OK',
                    customClass: { confirmButton: "btn btn-warning" }
                });
                return false;
            }
    
            rows.forEach((row, index) => {
                const qty = row.querySelector('input[name*="[qty]"]');
                const unit = row.querySelector('input[name*="[unit]"]');
                const code = row.querySelector('input[name*="[code]"]');
                const name = row.querySelector('input[name*="[name]"]');
                const desc = row.querySelector('input[name*="[desc]"]');
    
                [qty, unit, code, name, desc].forEach(el => {
                    if (el) el.classList.remove('is-invalid');
                });
    
                if (!qty?.value || qty.value <= 0) {
                    qty.classList.add('is-invalid');
                    isValid = false;
                }
                if (!unit?.value.trim()) {
                    unit.classList.add('is-invalid');
                    isValid = false;
                }
                if (!code?.value.trim()) {
                    code.classList.add('is-invalid');
                    isValid = false;
                }
                if (!name?.value.trim()) {
                    name.classList.add('is-invalid');
                    isValid = false;
                }
                if (!desc?.value.trim()) {
                    desc.classList.add('is-invalid');
                    isValid = false;
                }
            });
    
            if (!isValid) {
                Swal.fire({
                    title: 'Validation Error!',
                    text: 'Please fill in the required fields in the Material List table.',
                    icon: 'warning',
                    confirmButtonText: 'OK',
                    customClass: { confirmButton: "btn btn-warning" }
                });
            }
    
            return isValid;
        }
    
        const validator = FormValidation.formValidation(
            form,
            {
                fields: {
                    reference_number: {
                        validators: { notEmpty: { message: 'Reference is required' } }
                    },
                    case_no: {
                        validators: { notEmpty: { message: 'Case No is required' } }
                    },
                    date: {
                        validators: { notEmpty: { message: 'Date is required' } }
                    },
                    created_by: {
                        validators: { notEmpty: { message: 'Created BY is required' } }
                    },
                    department: {
                        validators: { notEmpty: { message: 'Department is required' } }
                    },
                    Designation: {
                        validators: { notEmpty: { message: 'Designation is required' } }
                    }
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap5: new FormValidation.plugins.Bootstrap5({
                        rowSelector: '.fv-row',
                        eleInvalidClass: '',
                        eleValidClass: ''
                    })
                }
            }
        );
    
        form.addEventListener('submit', function (e) {
            e.preventDefault();
    
            validator.validate().then(function (status) {
                if (status === 'Valid') {
                    if (!validateMaterialTable()) return;
    
                    pageLoader.style.display = "flex";
                    submitButton.querySelector(".indicator-label").style.display = "none";
                    submitButton.querySelector(".indicator-progress").style.display = "inline-block";
                    submitButton.disabled = true;
    
                    const formData = new FormData(form);
    
                    setTimeout(function () {
                        $.ajax({
                            url: "{{ route('update.mr') }}",
                            type: "POST",
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function (response) {
                                setTimeout(function () {
                                    pageLoader.style.display = "none";
                                    submitButton.querySelector(".indicator-label").style.display = "inline-block";
                                    submitButton.querySelector(".indicator-progress").style.display = "none";
                                    submitButton.disabled = false;
    
                                    if (response.success) {
                                        Swal.fire({
                                            title: 'Success!',
                                            text: response.message || 'Material Request has been saved successfully.',
                                            icon: 'success',
                                            confirmButtonText: 'OK',
                                            customClass: { confirmButton: "btn btn-success" }
                                        }).then(() => {
                                            const encodedMRNo = btoa(response.mr_no);
                                            window.location.href = `${BASE_URL}/Material-Request/Edit/${encodedMRNo}`;
                                        });
                                    }
                                }, 800);
                            },
                            error: function (xhr) {
                                setTimeout(function () {
                                    pageLoader.style.display = "none";
                                    submitButton.querySelector(".indicator-label").style.display = "inline-block";
                                    submitButton.querySelector(".indicator-progress").style.display = "none";
                                    submitButton.disabled = false;
    
                                    Swal.fire({
                                        title: 'Error!',
                                        text: xhr.responseJSON?.message || 'Failed to save Material Request. Please try again.',
                                        icon: 'warning',
                                        confirmButtonText: 'OK',
                                        customClass: { confirmButton: "btn btn-warning" }
                                    });
                                }, 800);
                            }
                        });
                    }, 800);
                } else {
                    Swal.fire({
                        title: 'Validation Error!',
                        text: 'Please fill all required fields properly.',
                        icon: 'warning',
                        confirmButtonText: 'OK',
                        customClass: { confirmButton: "btn btn-warning" }
                    });
                }
            });
        });
    </script>
    
    {{-- Table --}}
    <script>    
        function updateRowNumbers() {
            const rows = document.querySelectorAll('#material-body tr');
            rows.forEach((row, index) => {
                row.querySelector('td:first-child').textContent = index + 1;
                const inputs = row.querySelectorAll('input');
                if (inputs.length >= 5) {
                    inputs[0].setAttribute('name', `items[${index}][qty]`);
                    inputs[1].setAttribute('name', `items[${index}][unit]`);
                    inputs[2].setAttribute('name', `items[${index}][code]`);
                    inputs[3].setAttribute('name', `items[${index}][name]`);
                    inputs[4].setAttribute('name', `items[${index}][desc]`);
                }
            });
        }
    
        document.getElementById('add-row').addEventListener('click', () => {
            const table = document.getElementById('material-body');
            const rowCount = table.querySelectorAll('tr').length;
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td class="text-center">${rowCount + 1}</td>
                <td><input type="number" class="form-control" ></td>
                <td><input type="text" class="form-control"></td>
                <td><input type="text" class="form-control"></td>
                <td><input type="text" class="form-control" ></td>
                <td><input type="text" class="form-control"></td>
                <td class="text-center text-white">
                    <button type="button" class="btn btn-danger remove-row text-center text-white">
                        <i class="ki-duotone ki-trash fs-2x text-center text-white">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                            <span class="path4"></span>
                            <span class="path5"></span>
                        </i>
                    </button>
                </td>            
            `;
            table.appendChild(newRow);
            updateRowNumbers(); 
        });

    
        document.addEventListener('click', function(e) {
            if (e.target.closest('.remove-row')) {
                var button = e.target.closest('.remove-row');
                var row = button.closest('tr');
                
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This material will be permanently deleted!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!',
                    customClass: {
                        confirmButton: "btn btn-danger",
                        cancelButton: "btn btn-secondary"
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        row.remove();
                        updateRowNumbers();
                        Swal.fire({
                            title: 'Deleted!',
                            text: 'The material has been deleted.',
                            icon: 'success',
                            confirmButtonText: 'OK',
                            customClass: {
                                confirmButton: "btn btn-success"
                            }
                        });
                    }
                });
            }
        });
    </script>

    {{-- Delete Baris Material-Request --}}
    <script>
        $(document).on('click', '.delete-material', function () {
            var mrNo = $(this).data('mrno');
            var mrLine = $(this).data('mrline');
            var button = $(this);

            var row = button.closest('tr');

            Swal.fire({
                title: 'Are you sure?',
                text: "This material will be permanently deleted!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
                customClass: {
                    confirmButton: "btn btn-danger",
                    cancelButton: "btn btn-secondary"
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: BASE_URL + '/Material-Request/Delete-Material', 
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            mr_no: mrNo,
                            mr_line: mrLine
                        },
                        success: function(response) {
                            if (response.success) {
                                row.fadeOut();
                                Swal.fire({
                                    title: 'Deleted!',
                                    text: response.message,
                                    icon: 'success',
                                    confirmButtonText: 'OK',
                                    customClass: {
                                        confirmButton: "btn btn-success"
                                    }
                                });
                            } else {
                                Swal.fire({
                                    title: 'Error!',
                                    text: response.message,
                                    icon: 'error',
                                    confirmButtonText: 'OK',
                                    customClass: {
                                        confirmButton: "btn btn-warning"
                                    }
                                });
                            }
                        },
                        error: function(xhr) {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Failed to delete material.',
                                icon: 'error',
                                confirmButtonText: 'OK',
                                customClass: {
                                    confirmButton: "btn btn-warning"
                                }
                            });
                        }
                    });
                }
            });
        });
    </script>

    <script>
        const BASE_URL = "{{ url('') }}";
    </script>
                      
@endsection


