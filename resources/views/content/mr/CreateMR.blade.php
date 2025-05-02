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
                                                        Work Order Date
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
                                                        Work Order Designation
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
                                                                    <td class="text-center text-white"><button type="button" class="btn btn-danger remove-row text-center text-white">
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
    
    {{-- Design Lama --}}
    {{-- <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">
            <div class="card mb-5 shadow-sm rounded-3">
                <div class="card-header border-0 pt-5 pb-3">
                    <div class="card-title m-0">
                        <h3 class="fw-bold fs-1">@yield('title') - @yield('subtitle')</h3>
                    </div>
                </div>
    
                <div id="kt_account_settings_profile_details" class="collapse show">
                    <div class="card-body border-top p-5">
                        <form method="POST" id="MrForm" enctype="multipart/form-data">
                            @csrf
    
                            <div class="fv-row mb-6">
                                <label class="form-label fw-semibold">Reference No.</label>
                                <select class="form-select form-select-lg form-select-solid" 
                                        id="reference_number" name="reference_number" data-control="select2" 
                                        data-placeholder="Select Reference">
                                    <option></option>
                                </select>
                            </div>

                            <div class="fv-row mb-6">
                                <label class="form-label fw-semibold">Case No</label>
                                <input type="text" id="case_no" name="case_no" class="form-control form-control-solid" readonly />
                            </div>
              
                            <div class="fv-row row mb-6">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Created By</label>
                                    <input type="text" id="created_by" name="created_by" 
                                           class="form-control form-control-solid" disabled />
                                
                                        </div>

                                <div class="fv-row col-md-6">
                                    <label class="form-label fw-semibold">Department</label>
                                    <input type="text" id="department" name="department" 
                                           class="form-control form-control-solid" disabled />
                                
                                        </div>
                            </div>
    
                            <div class="fv-row mb-6">
                                <label class="form-label fw-semibold">Date</label>
                                <input type="date" class="form-control form-control-solid" id="date" name="date" />
                            </div>
    
                            <div class="fv-row mb-8">
                                <label class="form-label fw-semibold">Designation</label>
                                <textarea name="Designation" class="form-control form-control-solid" 
                                          rows="4" placeholder="What it is intended for..."></textarea>
                            </div>
    
                            @php $rowCount = 1; @endphp

                            <h4 class="fw-bold mb-4">Material List</h4>
                        
                            <div class="table-responsive">
                                <table class="table align-middle table-bordered table-striped" id="material-table">
                                    <thead class="table-light text-center">
                                        <tr>
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
                                            <td><input type="number" name="items[0][qty]" class="form-control" ></td>
                                            <td><input type="text" name="items[0][unit]" class="form-control"></td>
                                            <td><input type="text" name="items[0][code]" class="form-control"></td>
                                            <td><input type="text" name="items[0][name]" class="form-control" ></td>
                                            <td><input type="text" name="items[0][desc]" class="form-control"></td>
                                            <td><button type="button" class="btn btn-danger remove-row">X</button></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <button type="button" id="add-row" class="btn btn-primary">+ Add Row</button>

                            
                            <div class="d-flex justify-content-end mt-6">
                                <button id="kt_docs_formvalidation_text_submit" type="submit" class="btn btn-lg btn-primary">
                                    <span class="indicator-label">Save Case</span>
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

    <script>
        const BASE_URL = "{{ url('') }}";
    </script>

    {{-- Script Validatation & Save MR --}}
    {{-- <script>
        const form = document.getElementById('MrForm');
        const pageLoader = document.getElementById('page_loader');
        const submitButton = document.getElementById('kt_docs_formvalidation_text_submit');
    
        const validator = FormValidation.formValidation(
            form,
            {
                fields: {
                    reference_number: {
                        validators: {
                            notEmpty: {
                                message: 'Reference is required'
                            }
                        }
                    },
                    case_no: {
                        validators: {
                            notEmpty: {
                                message: 'Case No is required'
                            }
                        }
                    },
                    date: {
                        validators: {
                            notEmpty: {
                                message: 'Date is required'
                            }
                        }
                    },
                    Designation: {
                        validators: {
                            notEmpty: {
                                message: 'Designation is required'
                            }
                        }
                    }
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap5({
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
                    pageLoader.style.display = "flex"; 
                    submitButton.querySelector(".indicator-label").style.display = "none";
                    submitButton.querySelector(".indicator-progress").style.display = "inline-block";
                    submitButton.disabled = true;
    
                    const formData = new FormData(form);
    
                    setTimeout(function () {
                        $.ajax({
                            url: "{{ route('SaveMR') }}",
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
                                }, 1000); 
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
                                        icon: 'error',
                                        confirmButtonText: 'OK',
                                        customClass: { confirmButton: "btn btn-warning" }
                                    });
                                }, 1000); 
                            }
                        });
                    }, 800); 
                } else {
                    Swal.fire({
                        title: 'Validation Error!',
                        text: 'Please fill all required fields properly.',
                        icon: 'error',
                        confirmButtonText: 'OK',
                        customClass: { confirmButton: "btn btn-warning" }
                    });
                }
            });
        });
    </script> --}}
    <script>
        const form = document.getElementById('MrForm');
        const pageLoader = document.getElementById('page_loader');
        const submitButton = document.getElementById('kt_docs_formvalidation_text_submit');
    
        function validateMaterialTable() {
            const rows = document.querySelectorAll('#material-body tr');
            let isValid = true;

            rows.forEach((row, index) => {
                const qty = row.querySelector('input[name*="[qty]"]');
                const unit = row.querySelector('select[name*="[unit]"]');
                const code = row.querySelector('input[name*="[code]"]');
                const name = row.querySelector('input[name*="[name]"]');
                const desc = row.querySelector('input[name*="[desc]"]');

                [qty, unit, code, name, desc].forEach(el => {
                    if (el) el.classList.remove('is-invalid');
                });

                if (!qty.value || qty.value <= 0) {
                    qty.classList.add('is-invalid');
                    isValid = false;
                }
                if (!unit.value.trim()) {
                    unit.classList.add('is-invalid');
                    isValid = false;
                }
                if (!code.value.trim()) {
                    code.classList.add('is-invalid');
                    isValid = false;
                }
                if (!name.value.trim()) {
                    name.classList.add('is-invalid');
                    isValid = false;
                }
                if (!desc.value.trim()) {
                    desc.classList.add('is-invalid');
                    isValid = false;
                }
            });

            return isValid;
        }

        const validator = FormValidation.formValidation(
            form,
            {
                fields: {
                    reference_number: {
                        validators: {
                            notEmpty: {
                                message: 'Reference is required'
                            }
                        }
                    },
                    case_no: {
                        validators: {
                            notEmpty: {
                                message: 'Case No is required'
                            }
                        }
                    },
                    date: {
                        validators: {
                            notEmpty: {
                                message: 'Date is required'
                            }
                        }
                    },
                    created_by: {
                        validators: {
                            notEmpty: {
                                message: 'Created BY is required'
                            }
                        }
                    },  
                    department: {
                        validators: {
                            notEmpty: {
                                message: 'Department is required'
                            }
                        }
                    },  
                    Designation: {
                        validators: {
                            notEmpty: {
                                message: 'Designation is required'
                            }
                        }
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
                    if (!validateMaterialTable()) {
                        Swal.fire({
                            title: 'Validation Error!',
                            text: 'Please fill in the required fields in the Material List table.',
                            icon: 'warning',
                            confirmButtonText: 'OK',
                            customClass: { confirmButton: "btn btn-warning" }
                        });
                        return;
                    }
    
                    pageLoader.style.display = "flex"; 
                    submitButton.querySelector(".indicator-label").style.display = "none";
                    submitButton.querySelector(".indicator-progress").style.display = "inline-block";
                    submitButton.disabled = true;
    
                    const formData = new FormData(form);
    
                    setTimeout(function () {
                        $.ajax({
                            url: "{{ route('SaveMR') }}",
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
    
    {{-- Date --}}
    <script>
        $("#date").flatpickr({
            altInput: true,
            altFormat: "d/m/Y",
            dateFormat: "Y-m-d",
        });
    </script>
    
    {{-- Script Untuk Ambil data WO --}}
    <script>
        $(document).ready(function () {
            const userId = `{{ auth()->user()->id }}`;
            const baseUrl = `{{ url('/') }}`; 
    
            // Ambil data WO berdasarkan user
            $.ajax({
                url: `${baseUrl}/Material-Request/Get-WO-By-User`,
                type: 'GET',
                data: { user_id: userId },
                success: function (data) {
                    $('#reference_number').empty().append('<option></option>');
                    $.each(data, function (key, value) {
                        $('#reference_number').append(
                            `<option value="${value.WO_No}">${value.WO_No}</option>`
                        );
                    });
                },
                error: function () {
                    alert('Gagal mengambil data WO!');
                }
            });
    
            $('#caseForm').submit(function (e) {
                if ($('#case_no').val() === '') {
                    e.preventDefault();
                    alert('Case No is required!');
                }
            });
    
            $('#reference_number').on('change', function () {
                let woNo = $(this).val();
                if (woNo) {
                    $.ajax({
                        url: `${baseUrl}/Material-Request/Get-WO-Details`,
                        type: 'GET',
                        data: { wo_no: woNo },
                        success: function (data) {
                            if (data.case_no) {
                                $('#case_no').val(data.case_no);
                            } else {
                                alert('Case No not found!');
                            }
                            $('#created_by').val(data.created_by);
                            $('#department').val(data.department);
                        },
                        error: function () {
                            alert('Gagal mengambil detail WO!');
                        }
                    });
                }
            });
        });
    </script>
    
    {{-- Table --}}
    {{-- <script>
        let rowIndex = 1;
        document.getElementById('add-row').addEventListener('click', () => {
            const table = document.getElementById('material-body');
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td class="text-center">${rowIndex + 1}</td>
                <td><input type="number" name="items[${rowIndex}][qty]" class="form-control" required></td>
                <td><input type="text" name="items[${rowIndex}][unit]" class="form-control"></td>
                <td><input type="text" name="items[${rowIndex}][code]" class="form-control"></td>
                <td><input type="text" name="items[${rowIndex}][name]" class="form-control" required></td>
                <td><input type="text" name="items[${rowIndex}][desc]" class="form-control"></td>
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
                </td>            `;
            table.appendChild(newRow);
            rowIndex++;
        });
    
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-row')) {
                e.target.closest('tr').remove();
            }
        });

    </script>--}}
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
                <td><input type="number" name="items[${rowCount}][qty]" class="form-control" ></td>
                <td>
                    <select name="items[${rowCount}][unit]" class="form-select select2-unit" style="width: 100%;">
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

                
                <td><input type="text" name="items[${rowCount}][code]" class="form-control"></td>
                <td><input type="text" name="items[${rowCount}][name]" class="form-control" ></td>
                <td><input type="text" name="items[${rowCount}][desc]" class="form-control"></td>
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
                e.target.closest('tr').remove();
                updateRowNumbers();
            }
        });
    
    </script>
    
@endsection

