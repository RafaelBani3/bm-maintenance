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
                        {{-- <input type="text" name="wo_no" value="{{ $workOrder->WO_No }}"> --}}

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
                                    </div>
                                </div>
                                
                            </div>
                            <!--End::Input Cases-->

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
                                    <select id="assigned_to" name="assigned_to[]" multiple="multiple" class="form-select form-select-lg form-select-solid"
                                        data-control="select2" data-close-on-select="false" data-placeholder="Select technician" data-allow-clear="true">
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

    <script>
        const BASE_URL = "{{ url('/') }}";
    </script>

    <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>

    {{-- Script Date --}}
    <script>
        flatpickr("#start_date", {
            enableTime: true,
            altInput: true,
            altFormat: "d/m/Y H:i",
            dateFormat: "Y-m-d H:i",
            time_24hr: true
        });

        flatpickr("#end_date", {
            enableTime: true,
            altInput: true,
            altFormat: "d/m/Y H:i",
            dateFormat: "Y-m-d H:i",
            time_24hr: true
        });
    </script>

    {{-- Script Get WO_No dan WO Detail --}}
    <script>
        $(document).ready(function () {
            // Declare Time
            const startPicker = flatpickr("#start_date", {
                enableTime: true,
                dateFormat: "d/m/Y H:i",
                time_24hr: true
            });
    
            const endPicker = flatpickr("#end_date", {
                enableTime: true,
                dateFormat: "d/m/Y H:i",
                time_24hr: true
            });
            // End Time

            // Declare Route untuk ambil data WO_No yang sesuai untuk Create WOC
            const routeGetWoDataforWOC = "{{ route('GetWoDataforWOC') }}";
            // Deklare Route untuk Get WO Detail
            const routeGetWoDetail = "{{ route('GetWoDetail', ['encoded' => 'ENCODED_PLACEHOLDER']) }}";

            $.ajax({
                // url: '/BmMaintenance/public/get-work-orders',
                url: routeGetWoDataforWOC,
                type: 'GET',
                success: function (data) {
                    let select = $('#reference_number');
                    data.forEach(item => {
                        const encoded = btoa(unescape(encodeURIComponent(item.WO_No)));
                        select.append(`<option value="${encoded}">${item.WO_No}</option>`);
                    });
                },
                error: function (xhr) {
                    console.error("Failed to get Work Orders:", xhr);
                }
            });
    
            $('#reference_number').on('change', function () {
                const encoded = $(this).val();
                if (!encoded) return;

                // Ambil Routenya dan masukan WO_No 
                const ajaxUrl = routeGetWoDetail.replace('ENCODED_PLACEHOLDER', encoded);
    
                $.ajax({
                    url: ajaxUrl,
                    type: 'GET',
                    success: function (data) {
                        $('#case_no').val(data.Case_No);
                        $('#case_name').val(data.Case_Name);
                        $('#work_order_date').val(data.CR_DT);
                        $('#created_by').val(data.Created_By);
                        $('#position').val(data.Position);
                        $('#work_description').val(data.WO_Narative);
    
                        startPicker.setDate(data.WO_Start, true, "Y-m-d H:i:S");
                        endPicker.setDate(data.WO_End, true, "Y-m-d H:i:S");
    
                        const select = $('#assigned_to');
                        select.empty();
                        data.All_Technicians.forEach(tech => {
                            select.append(`<option value="${tech.id}">${tech.fullname}</option>`);
                        });
    
                        const selectedIds = data.Assigned_To.map(t => t.id);
                        select.val(selectedIds).trigger('change');
                    }
                });
            });
        });
    </script>

    {{-- Script Hapus Teknisi --}}
    {{-- <script>
    $(document).ready(function () {
        const wo_no = "{{ $workOrder->WO_No }}";

        $('select[name="assigned_to[]"]').on('select2:unselect', function (e) {
            const technician_id = e.params.data.id;
            const technician_name = e.params.data.text;

            Swal.fire({
                title: 'Are you sure?',
                text: `Do you want to remove "${technician_name}" from this Work Order?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, remove it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Tampilkan loader
                    $(".page-loader").fadeIn();

                    // Delay 1 detik sebelum kirim AJAX
                    setTimeout(function () {
                        $.ajax({
                            url: "{{ route('work-order.remove-technician') }}",
                            method: "POST",
                            data: {
                                _token: '{{ csrf_token() }}',
                                wo_no: wo_no,
                                technician_id: technician_id
                            },
                            success: function(response) {
                                Swal.fire('Removed!', 'Technician has been removed.', 'success');
                            },
                            error: function(xhr) {
                                console.error('Error removing technician:', xhr.responseText);
                                Swal.fire('Error', 'Failed to remove technician from database.', 'error');
                            },
                            complete: function () {
                                $(".page-loader").fadeOut();
                            }
                        });
                    }, 800);
                } else {
                    const $select = $('select[name="assigned_to[]"]');
                    const option = new Option(technician_name, technician_id, true, true);
                    $select.append(option).trigger('change');
                }
            });
        });
    });
    </script> --}}

    {{-- Script validate dan save WOC --}}
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const form = document.getElementById('WOCFrom');
            const submitButton = document.getElementById('kt_docs_formvalidation_text_submit');
            const loader = document.getElementById('page-loader');

            if (!form || !submitButton) return;

            let validator = FormValidation.formValidation(form, {
                fields: {
                    'reference_number': {
                        validators: {
                            notEmpty: { message: 'Reference No. is required' }
                        }
                    },
                    'start_date': {
                        validators: {
                            notEmpty: { message: 'Start Date is required' }
                        }
                    },
                    'end_date': {
                        validators: {
                            notEmpty: { message: 'Complete Date is required' }
                        }
                    },
                    'assigned_to[]': {
                        validators: {
                            notEmpty: { message: 'Assigned To is required' }
                        }
                    },
                    'work_description': {
                        validators: {
                            notEmpty: { message: 'Work Description is required' }
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
            });

            // Dropzone setup
            Dropzone.autoDiscover = false;
            let uploadedFiles = [];
            let myDropzone = new Dropzone("#case-dropzone", {
                url: "https://keenthemes.com/scripts/void.php",
                autoProcessQueue: false,
                addRemoveLinks: true,
                maxFiles: 5,
                acceptedFiles: 'image/jpeg,image/png,image/jpg',
                dictDefaultMessage: 'Drop files here or click to upload.',
                dictMaxFilesExceeded: 'Maximum 5 files allowed.',
                init: function () {
                    this.on("addedfile", function (file) {
                        if (!['image/jpeg', 'image/png', 'image/jpg'].includes(file.type)) {
                            this.removeFile(file);
                            Swal.fire({ icon: 'warning', title: 'Invalid File', text: 'Only JPG, JPEG, and PNG files are allowed' });
                            return;
                        }
                        if (file.size > 2 * 1024 * 1024) {
                            this.removeFile(file);
                            Swal.fire({ icon: 'warning', title: 'File size too large', text: 'Max file size is 2MB.' });
                            return;
                        }
                        if (uploadedFiles.length >= 5) {
                            this.removeFile(file);
                            Swal.fire({ icon: 'warning', title: 'Max Files', text: 'You can upload up to 5 images.' });
                            return;
                        }

                        uploadedFiles.push(file);

                        file.previewElement.addEventListener("click", function () {
                            if (file.type.startsWith("image/")) {
                                const reader = new FileReader();
                                reader.onload = function (e) {
                                    $('#modal-image').attr('src', e.target.result);
                                    $('#imageModal').modal('show');
                                };
                                reader.readAsDataURL(file);
                            }
                        });
                    });

                    this.on("removedfile", function (file) {
                        uploadedFiles = uploadedFiles.filter(f => f !== file);
                    });
                }
            });

            form.addEventListener('submit', function (e) {
                e.preventDefault();

                validator.validate().then(function (status) {
                    if (status === 'Valid') {
                        if (uploadedFiles.length === 0) {
                            Swal.fire({
                                title: 'File Required',
                                text: 'Please upload at least 1 image before submitting.',
                                icon: 'warning',
                                confirmButtonText: 'OK'
                            });
                            return;
                        }

                        submitButton.disabled = true;
                        submitButton.querySelector('.indicator-label').classList.add('d-none');
                        submitButton.querySelector('.indicator-progress').classList.remove('d-none');
                        submitButton.querySelector('.indicator-progress').style.display = 'inline-block';

                        loader.style.display = 'flex';
                        loader.classList.remove('d-none');
                            loader.style.display = 'flex';
                            loader.style.alignItems = 'center';
                            loader.style.justifyContent = 'center';
                            loader.style.position = 'fixed';
                            loader.style.top = '0';
                            loader.style.left = '0';
                            loader.style.width = '100%';
                            loader.style.height = '100%';
                            loader.style.zIndex = '9999';


                        const formData = new FormData(form);
                    uploadedFiles.forEach((file, index) => {
                            formData.append(`photos[${index}]`, file); 
                        });

                        setTimeout(() => {
                            fetch("{{ route('SaveWOC') }}", {
                                method: "POST",
                                headers: {
                                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                                },
                                body: formData,
                                credentials: 'same-origin'
                            })
                            .then(response => response.json())
                            .then(data => {
                                loader.classList.remove('d-flex');
                                loader.classList.add('d-none');

                                submitButton.disabled = false;
                                submitButton.querySelector('.indicator-label').classList.remove('d-none');
                                submitButton.querySelector('.indicator-progress').classList.add('d-none');

                                if (data.success) {
                                    Swal.fire({
                                        title: 'Success!',
                                        text: data.message ?? 'Work Order Completion saved successfully.',
                                        icon: 'success',
                                        confirmButtonText: 'OK',
                                        customClass: {
                                            confirmButton: "btn btn-success",
                                        }
                                    }).then(() => {
                                        let encodedWoNo = btoa(data.wo_no);
                                        let baseUrl = window.location.origin + "/BmMaintenance/public";
                                        window.location.href = baseUrl + "/WorkOrder-Complition/Edit/" + encodedWoNo;
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Failed!',
                                        text: data.message ?? 'Failed to save Work Order Completion.',
                                        icon: 'warning',
                                        confirmButtonText: 'OK',
                                        customClass: {
                                            confirmButton: "btn btn-warning",
                                        }
                                    });
                                }
                            })
                            .catch(error => {
                                loader.classList.remove('d-flex');
                                loader.classList.add('d-none');

                                submitButton.disabled = false;
                                submitButton.querySelector('.indicator-label').classList.remove('d-none');
                                submitButton.querySelector('.indicator-progress').classList.add('d-none');
                                
                                console.error("Exception:", error);
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'An unexpected error occurred. Please try again.',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            });
                        }, 1000);
                    } else {
                        Swal.fire({
                            title: 'Incomplete Form',
                            text: 'Please complete all required fields before submitting.',
                            icon: 'warning',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });
        });
    </script>



@endsection
