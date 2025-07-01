
    <script>
        const BASE_URL = "{{ url('/') }}";
    </script>

    <script src="{{ asset('assets/plugins/custom/fslightbox/fslightbox.bundle.js')}}"></script>

     {{-- Script untuk Assigned To --}}
    <script>
        $(document).ready(function () {
            const routeGetTechnician = "{{ route('GetTechnician') }}";

            // Ambil teknisi dari serverg
            $.ajax({
                url: routeGetTechnician,
                type: "GET",
                success: function (technicians) {
                    const select = $('#assigned_to');
                    select.empty();

                    technicians.forEach(group => {
                        const optgroup = $('<optgroup>').attr('label', group.text);
                        group.children.forEach(tech => {
                            const isSelected = @json($selectedTechnicians).includes(tech.id);
                            optgroup.append(`<option value="${tech.id}" ${isSelected ? 'selected' : ''}>${tech.text}</option>`);
                        });
                        select.append(optgroup);
                    });

                    select.trigger('change'); 
                },
                error: function (xhr) {
                    console.error("Gagal mengambil data teknisi:", xhr.responseText);
                }
            });
        });
    </script>

    {{-- Script Date --}}
    <script>
        flatpickr("#work_order_date", {
            enableTime: true,
            altInput: true,
            altFormat: "d/m/Y H:i",
            dateFormat: "Y-m-d H:i",
            time_24hr: true,
            minDate: "today",
        });

        flatpickr("#start_date", {
            enableTime: true,
            altInput: true,
            altFormat: "d/m/Y H:i",
            dateFormat: "Y-m-d H:i",
            time_24hr: true,
            minDate: "today",
        });

        flatpickr("#end_date", {
            enableTime: true,
            altInput: true,
            altFormat: "d/m/Y H:i",
            dateFormat: "Y-m-d H:i",
            time_24hr: true,
            minDate: "today",
        });
    </script>

<script>
    const updateWOCUrl = "{{ route('UpdateWOC') }}";
    const listWOCPageUrl = "{{ route('ListWOCPage') }}";
    const saveWOCUrl = "{{ route('WOC.SaveDraft') }}";

    Dropzone.autoDiscover = false;
    let uploadedFiles = [];

    const myDropzone = new Dropzone("#case-dropzone", {
        url: "https://keenthemes.com/scripts/void.php",
        autoProcessQueue: false,
        addRemoveLinks: true,
        maxFiles: 5,
        maxFilesize: 2,
        acceptedFiles: 'image/jpeg,image/png,image/jpg',
        dictDefaultMessage: 'Drop files here or click to upload.',
        dictMaxFilesExceeded: 'Maximum 5 files allowed.',
        dictFileTooBig: 'File size must not exceed 2MB.',
        dictInvalidFileType: 'Only JPG, JPEG, and PNG files are allowed.',
        init: function () {
            this.on("addedfile", function (file) {
                if (!['image/jpeg', 'image/png', 'image/jpg'].includes(file.type) || file.size > 2 * 1024 * 1024) {
                    this.removeFile(file);
                    Swal.fire({ icon: 'warning', title: 'Invalid File', text: 'Only JPG, JPEG, PNG under 2MB are allowed.' });
                    return;
                }

                if (uploadedFiles.length >= 5) {
                    this.removeFile(file);
                    Swal.fire({ icon: 'warning', title: 'Max Files', text: 'You can upload up to 5 images.' });
                    return;
                }

                uploadedFiles.push(file);
            });

            this.on("removedfile", function (file) {
                uploadedFiles = uploadedFiles.filter(f => f !== file);
            });
        }
    });

    $(document).ready(function () {
        const form = document.getElementById('WOCFrom');

        // Default: semua field readonly dan disable
        $('#WOCFrom input, #WOCFrom textarea, #WOCFrom select').prop('readonly', true);
        // $('#WOCFrom select').prop('disabled', true);
        $('#start_date, #end_date').prop('readonly', true).css('pointer-events', 'none');


        $('#kt_docs_formvalidation_text_save').hide();
        $('#btn-edit-woc').show();
        $('#kt_docs_formvalidation_text_submit').show();
        myDropzone.disable();
        $('#case-dropzone').addClass('dz-disabled');
        $('#case-dropzone .dz-message').css('pointer-events', 'none');
        $('.delete-photo').hide();

        const validator = FormValidation.formValidation(form, {
            fields: {
                'reference_number': { validators: { notEmpty: { message: 'Reference No. is required' } } },
                'start_date': { validators: { notEmpty: { message: 'Start Date is required' } } },
                'end_date': { validators: { notEmpty: { message: 'End Date is required' } } },
                'assigned_to[]': { validators: { notEmpty: { message: 'Assigned To is required' } } },
                'work_description': { validators: { notEmpty: { message: 'Work Description is required' } } }
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

        // === Button Edit ===
        $('#btn-edit-woc').on('click', function () {
            $('#page_loader').css('display', 'flex').addClass('d-flex justify-content-center align-items-center');

            setTimeout(() => {
                $('#page_loader').hide().removeClass('d-flex justify-content-center align-items-center');

                // Enable all inputs except yang ingin tetap readonly
                $('#WOCFrom input, #WOCFrom textarea, #WOCFrom select').prop('readonly', false).prop('disabled', false);
                $('#reference_number').prop('readonly', true);
                $('#start_date, #end_date').prop('readonly', true).css('pointer-events', 'none');
                
                $('#btn-edit-woc').hide();
                $('#kt_docs_formvalidation_text_submit').hide();
                $('#kt_docs_formvalidation_text_save').show();

                myDropzone.enable();
                $('#case-dropzone').removeClass('dz-disabled');
                $('#case-dropzone .dz-message').css('pointer-events', 'auto');
                $('.delete-photo').show();
            }, 800);
        });

        // === Button Save Draft ===
        $('#kt_docs_formvalidation_text_save').on('click', function (e) {
            e.preventDefault();

            validator.validate().then(function (status) {
                if (status === 'Valid') {
                    Swal.fire({
                        title: 'Confirm Save',
                        text: 'Are you sure you want to save the changes?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, Save it',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $('#page_loader').css('display', 'flex').addClass('d-flex justify-content-center align-items-center');
                            $('#kt_docs_formvalidation_text_save .indicator-label').hide();
                            $('#kt_docs_formvalidation_text_save .indicator-progress').show();
                            $('#kt_docs_formvalidation_text_save').prop('disabled', true);

                            const formData = new FormData(form);
                            uploadedFiles.forEach(file => formData.append('new_images[]', file));

                            $.ajax({
                                url: saveWOCUrl,
                                type: 'POST',
                                data: formData,
                                processData: false,
                                contentType: false,
                                success: function (response) {
                                    setTimeout(() => {
                                        $('#page_loader').hide().removeClass('d-flex justify-content-center align-items-center');
                                        $('#kt_docs_formvalidation_text_save .indicator-label').show();
                                        $('#kt_docs_formvalidation_text_save .indicator-progress').hide();

                                        if (response.success) {
                                            Swal.fire({
                                                icon: 'success',
                                                title: 'Saved',
                                                text: response.message,
                                                confirmButtonText: 'OK'
                                            }).then(() => {
                                                // Tampilkan loader
                                                $('#page_loader').css('display', 'flex').addClass('d-flex justify-content-center align-items-center');

                                                // Kembalikan form ke readonly
                                                $('#WOCFrom input, #WOCFrom textarea, #WOCFrom select').prop('readonly', true);
                                                $('#WOCFrom select').prop('disabled', true);
                                                $('#start_date, #end_date').prop('readonly', true).css('pointer-events', 'none');

                                                $('#kt_docs_formvalidation_text_save').hide();
                                                $('#btn-edit-woc').show();
                                                $('#kt_docs_formvalidation_text_submit').show();
                                                $('#kt_docs_formvalidation_text_save').prop('disabled', false);

                                                // Refresh halaman setelah delay 800ms
                                                setTimeout(() => {
                                                    location.reload();
                                                }, 800);
                                            });
                                        } else {
                                            $('#kt_docs_formvalidation_text_save').prop('disabled', false);
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Error',
                                                text: response.message
                                            });
                                        }

                                    }, 800);
                                },
                                error: function () {
                                    $('#page_loader').hide().removeClass('d-flex justify-content-center align-items-center');
                                    $('#kt_docs_formvalidation_text_save .indicator-label').show();
                                    $('#kt_docs_formvalidation_text_save .indicator-progress').hide();
                                    $('#kt_docs_formvalidation_text_save').prop('disabled', false);

                                    Swal.fire({ icon: 'error', title: 'Error', text: 'Something went wrong while saving.' });
                                }
                            });
                        }
                    });
                } else {
                    Swal.fire({ icon: 'warning', title: 'Form Incomplete', text: 'Please fill out all required fields before saving.' });
                }
            });
        });

        // === Button Submit ===
        $('#WOCFrom').on('submit', function (e) {
            e.preventDefault();

            Swal.fire({
                title: 'Submit Work Order Completion?',
                text: 'Are you sure all data is correct before submitting?',
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
                    validator.validate().then(function (status) {
                        if (status === 'Valid') {
                            $('#page_loader').css('display', 'flex').addClass('d-flex justify-content-center align-items-center');
                            $('#kt_docs_formvalidation_text_submit .indicator-label').hide();
                            $('#kt_docs_formvalidation_text_submit .indicator-progress').show();
                            $('#kt_docs_formvalidation_text_submit').prop('disabled', true);

                            const formData = new FormData(form);

                            $.ajax({
                                url: updateWOCUrl,
                                type: 'POST',
                                data: formData,
                                processData: false,
                                contentType: false,
                                success: function () {
                                    $('#page_loader').hide().removeClass('d-flex justify-content-center align-items-center');
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success',
                                        text: 'Work Order Completion has been submitted!',
                                        confirmButtonText: 'OK'
                                    }).then(() => {
                                        window.location.href = listWOCPageUrl;
                                    });
                                },
                                error: function () {
                                    $('#page_loader').hide().removeClass('d-flex justify-content-center align-items-center');
                                    $('#kt_docs_formvalidation_text_submit .indicator-label').show();
                                    $('#kt_docs_formvalidation_text_submit .indicator-progress').hide();
                                    $('#kt_docs_formvalidation_text_submit').prop('disabled', false);

                                    Swal.fire({ icon: 'error', title: 'Error', text: 'Something went wrong. Please check the input or try again.' });
                                }
                            });
                        } else {
                            Swal.fire({ icon: 'warning', title: 'Form Incomplete', text: 'Please fill out all required fields before submitting.' });
                        }
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