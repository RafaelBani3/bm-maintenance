@extends('layouts.Master')

@section('title', 'Work Order Complition Management')
@section('subtitle', 'Create Work Order Complition')

@section('content')

    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
        <!--begin::Content wrapper-->
        <div class="d-flex flex-column flex-column-fluid py-3 py-lg-6">
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
                                <!--begin::Card body-->
                                <div class="card-body p-2">
                                    <!--begin::Input Cases-->
                                    <div class="fv-row row mb-10">
                                        <!--begin::Label-->
                                        <label class="col-lg-4 col-form-label fw-semibold fs-5 text-muted">
                                            <span>Reference No.</span>
                                            <span class="ms-1" data-bs-toggle="tooltip" title="Select a Work Order No to be used as the reference for this Work Order Complition.">
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
                                                <!-- Reference No -->
                                                <select class="form-select form-select-lg form-select-solid flex-grow-1" 
                                                    id="reference_number" name="reference_number" data-control="select2" data-placeholder="Select Reference">
                                                    <option></option>
                                                    {{-- @foreach ($workOrder as $wo) --}}
                                                        <option value="{{ $workOrder->WO_No }}" {{ $workOrder->WO_No == $workOrder->WO_No ? 'selected' : '' }}>
                                                            {{ $workOrder->WO_No }}
                                                        </option>
                                                    {{-- @endforeach --}}
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <!--End::Input Cases-->

                                    <!--begin::Input date-->
                                    <div class="fv-row row mb-10">
                                        <!--begin::Label-->
                                        <label class="col-lg-4 col-form-label required fw-semibold fs-6 text-muted">Work Order Date</label>
                                        <!--end::Label-->
                                        <div class="col-lg-8 fv-row">
                                            <input type="text" id="work_order_date" name="work_order_date" 
                                                class="form-control form-control-lg form-control-solid" 
                                                placeholder="Work Order Date" 
                                                value="{{ $workOrder->CR_DT }}" disabled /></div>
                                        </div>
                                    <!--end::Input date-->

                                    <!--begin::Input Created By-->
                                    <div class="fv-row row mb-10">
                                        <!--begin::Label--> 
                                        <label class="col-lg-4 col-form-label required fw-semibold fs-6 text-muted">Created By</label>
                                        <!--end::Label-->
                                        <div class="col-lg-8 fv-row">
                                            <input type="text" id="created_by" name="created_by" 
                                            class="form-control form-control-lg form-control-solid" 
                                            value="{{ $workOrder->createdBy->Fullname ?? '' }}" disabled />
                                        </div>
                                    </div>
                                    <!--end::Input Craeted By-->

                                    <!--begin::Input Position-->
                                    <div class="fv-row row mb-10">
                                        <!--begin::Label-->
                                        <label class="col-lg-4 col-form-label required fw-semibold fs-6 text-muted">Position</label>
                                        <!--end::Label-->
                                        <div class="col-lg-8 fv-row">
                                            <input type="text" id="position" name="position" 
                                            class="form-control form-control-lg form-control-solid" 
                                            value="{{ $workOrder->CreatedBy->position->PS_Name ?? '' }}" disabled />
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
                                            <input type="text" id="start_date" name="start_date" 
                                            class="form-control form-control-lg form-control-solid" 
                                            value="{{ $workOrder->WO_Start }}" />                                
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
                                            <input type="text" id="end_date" name="end_date" 
                                            class="form-control form-control-lg form-control-solid" 
                                            value="{{ $workOrder->WO_End }}" />                                
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
                                                data-control="select2" data-close-on-select="false" data-placeholder="Select technician" data-allow-clear="true">
                                                <option></option>
                                                @foreach($allTechnicians as $tech)
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
                                            <textarea class="form-control form-control-solid" rows="4" name="work_description" id="work_description"
                                            placeholder="Describe the work...">{{ $workOrder->WO_Narative }}</textarea>
                                        </div>
                                    </div>
                                    <!--end::Input Work Description-->

                                    <!--begin::Input Existing Image Dropzone-->
                                    <div class="row mb-5">
                                        <!--begin::Label-->
                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                            <span class="required">Existing Image</span>
                                            <span class="ms-1" data-bs-toggle="tooltip" title="This is the currently uploaded image. You can keep or replace it.">
                                                <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                </i>
                                            </span>
                                        </label>
                                        <!--end::Label-->
                                        <div id="existing-photos" class="d-flex flex-row flex-wrap gap-4">
                                            @foreach($wocImages as $index => $image)
                                                <div class="d-flex flex-column align-items-center" id="image-container-{{ $image->IMG_No }}">
                                                    <!-- Gambar + Overlay -->
                                                    <a class="d-block overlay position-relative rounded shadow-sm" data-fslightbox="lightbox-case-images" 
                                                        href="{{ asset('storage/woc_photos/' . str_replace(['/', '\\'], '-', $workOrder->WO_No) . '/' . $image->IMG_Filename) }}">
                                                        <div class="overlay-wrapper card-rounded bgi-no-repeat bgi-position-center bgi-size-cover"
                                                            style="background-image:url('{{ asset('storage/woc_photos/' . str_replace(['/', '\\'], '-', $workOrder->WO_No) . '/' . $image->IMG_Filename) }}'); width: 100px; height: 120px; border-radius: 0.65rem;">
                                                        </div>
                                                        <div class="overlay-layer card-rounded bg-dark bg-opacity-50 shadow d-flex align-items-center justify-content-center position-absolute top-0 start-0 w-100 h-100 rounded"
                                                            style="transition: all 0.3s ease;">
                                                            <i class="bi bi-eye-fill text-white fs-2x"></i>
                                                        </div>
                                                    </a>
                                                    <button type="button" class="btn btn-icon btn-sm btn-danger mt-2 delete-photo" data-img-id="{{ $image->IMG_No }}" title="Hapus Foto">
                                                        <i class="ki-duotone ki-trash">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                            <span class="path3"></span>
                                                            <span class="path4"></span>
                                                            <span class="path5"></span>
                                                        </i>
                                                    </button>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <!--end::Input Existing Image Dropzone-->
                                </div>
                                <!--end::Card body-->

                                <!-- Submit Button -->
                                <div class="text-end mt-4">
                                    <button id="kt_docs_formvalidation_text_submit" type="submit" class="btn btn-primary shadow-sm px-5">
                                        <span class="indicator-label">
                                        Submit Work Order Complition
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
        </div>
    </div>

    <div id="page_loader" style="
        display: none;
        position: fixed;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background: rgba(88, 88, 88, 0.7);
        z-index: 9999;
        display: none;
        justify-content: center;
        align-items: center;
        flex-direction: column;">
        <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
            <span class="visually-hidden">Loading...</span>
        </div>
        <div style="margin-top: 15px; color: #fff; font-size: 1.25rem;">Loading...</div>
    </div>


    <script>
        const BASE_URL = "{{ url('/') }}";
    </script>

    <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/fslightbox/fslightbox.bundle.js') }}"></script>

    {{-- Script Date --}}
    <script>
        flatpickr("#work_order_date", {
            enableTime: true,
            altInput: true,
            altFormat: "d/m/Y H:i",
            dateFormat: "Y-m-d H:i",
            time_24hr: true
        });

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

    {{-- Script Validate & Update WOC --}}
    <script>
        $(document).ready(function () {
            const form = document.getElementById('WOCFrom');

            const validator = FormValidation.formValidation(form, {
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
                            notEmpty: { message: 'End Date is required' }
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

            $('#WOCFrom').on('submit', function (e) {
                e.preventDefault();

                validator.validate().then(function (status) {
                    if (status === 'Valid') {
                        Swal.fire({
                            title: 'Are you sure?',
                            text: "Do you want to submit this Work Order Completion?",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Yes, Submit WOC!',
                            cancelButtonText: 'Cancel',
                            customClass: {
                                confirmButton: 'btn btn-success',
                                cancelButton: 'btn btn-danger'
                            },
                            buttonsStyling: false,
                            reverseButtons: true
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $('#page_loader')
                                    .css('display', 'flex')
                                    .addClass('d-flex justify-content-center align-items-center');

                                $('#kt_docs_formvalidation_text_submit .indicator-label').hide();
                                $('#kt_docs_formvalidation_text_submit .indicator-progress').show();
                                $('#kt_docs_formvalidation_text_submit').prop('disabled', true);

                                let formData = new FormData(form);

                                setTimeout(() => {
                                    $.ajax({
                                        url: "{{ url('/WorkOrder-Complition/UpdateWOC') }}",
                                        type: 'POST',
                                        data: formData,
                                        processData: false,
                                        contentType: false,
                                        success: function (response) {
                                            $('#page_loader').hide().removeClass('d-flex justify-content-center align-items-center');
                                            Swal.fire({
                                                icon: 'success',
                                                title: 'Success',
                                                text: 'Work Order Completion has been submitted!',
                                                confirmButtonText: 'OK'
                                            }).then(() => {
                                                window.location.href = "{{ url('/WorkOrder-Complition/List') }}";
                                            });
                                        },
                                        error: function () {
                                            $('#page_loader').hide().removeClass('d-flex justify-content-center align-items-center');
                                            $('#kt_docs_formvalidation_text_submit .indicator-label').show();
                                            $('#kt_docs_formvalidation_text_submit .indicator-progress').hide();
                                            $('#kt_docs_formvalidation_text_submit').prop('disabled', false);

                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Error',
                                                text: 'Something went wrong. Please check the input or try again.'
                                            });
                                        }
                                    });
                                }, 800); 
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Form Incomplete',
                            text: 'Please fill out all required fields before submitting.'
                        });
                    }
                });
            });

        });
    </script>
   
    {{-- Delete Foto --}}
    <script>
        $(document).ready(function () {
            // Hapus foto
            $('#existing-photos').on('click', '.delete-photo', function () {
                let imgId = $(this).data('img-id');
                let imageContainer = $('#image-container-' + imgId);

                Swal.fire({
                    title: "Yakin ingin menghapus foto ini?",
                    text: "Foto akan dihapus permanen dari sistem!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Ya, Hapus",
                    cancelButtonText: "Batal",
                    customClass: {
                        confirmButton: "btn btn-danger",
                        cancelButton: "btn btn-secondary"
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('WOC.deleteImage') }}",
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                img_id: imgId
                            },
                            success: function (response) {
                                if (response.success) {
                                    imageContainer.fadeOut(300, function () { $(this).remove(); });
                                    Swal.fire("Deleted!", response.message, "success");
                                } else {
                                    Swal.fire("Error", response.message, "error");
                                }
                            },
                            error: function () {
                                Swal.fire("Error", "Terjadi kesalahan saat menghapus foto.", "error");
                            }
                        });
                    }
                });
            });
        });
    </script>

    {{-- Hapus Teknisi yang sudah dipipilih/Tersimpan didatabase --}}
    <script>
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
    </script>

@endsection
