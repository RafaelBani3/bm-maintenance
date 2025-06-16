    <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <script src="{{ asset('assets/plugins/custom/fslightbox/fslightbox.bundle.js')}}"></script>

    {{-- Date Time --}}
    <script>
        $("#date").flatpickr({
            enableTime: true, 
            time_24hr: true,  
            altInput: true,
            altFormat: "d/m/Y H:i", 
            dateFormat: "Y-m-d H:i", 
        });
    </script>

    {{-- Category dan SubCategory --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const categorySelect = document.getElementById("category");
            const subCategorySelect = document.getElementById("sub_category");
            const pageLoader = document.getElementById("page_loader");

            categorySelect.addEventListener("change", function() {
                const categoryId = this.value;

                if (categoryId) {
                    pageLoader.style.display = "flex";

                    subCategorySelect.innerHTML = `<option value="">Loading...</option>`;
                    subCategorySelect.disabled = true;
                    setTimeout(function() {
                        KTApp.hidePageLoading();
                        loadingEl.remove();
                    }, 3000);
                    
                    fetch(`${BASE_URL}/get-subcategories/${categoryId}`)
                    // fetch(`/get-subcategories/${categoryId}`)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Failed to fetch sub-categories');
                            }
                            return response.json();
                        })
                        .then(data => {
                            pageLoader.style.display = "none";

                            subCategorySelect.innerHTML = `<option value="">Select Sub Category</option>`;
                            data.forEach(subCat => {
                                subCategorySelect.innerHTML += `<option value="${subCat.Scat_No}">${subCat.Scat_Name}</option>`;
                            });

                            subCategorySelect.disabled = false;
                        })
                        .catch(error => {
                            console.error("Error fetching subcategories:", error);
                            pageLoader.style.display = "none";

                            Swal.fire({
                                icon: 'warning',
                                title: 'Warning',
                                text: 'Failed to load sub-categories. Please try again!',
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-warning"
                                }
                            });
                        });
                } else {
                    subCategorySelect.innerHTML = `<option value="">You Should Choose Category First</option>`;
                    subCategorySelect.disabled = true;

                    Swal.fire({
                        icon: 'warning',
                        title: 'Warning',
                        text: 'You Should Choose Category First!',
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });
                }
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
                    title: "Are you sure you want to delete this photo?",
                    text: "This photo will be permanently removed from the system.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, delete it",
                    cancelButtonText: "Cancel",
                    customClass: {
                        confirmButton: "btn btn-danger",
                        cancelButton: "btn btn-secondary"
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('cases.deleteImage') }}",
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                img_id: imgId
                            },
                            success: function (response) {
                                if (response.success) {
                                    imageContainer.fadeOut(300, function () { $(this).remove(); });
                                    Swal.fire("Deleted!", "The photo has been successfully removed.", "success");
                                } else {
                                    Swal.fire("Failed", response.message || "Unable to delete the photo.", "error");
                                }
                            },
                            error: function () {
                                Swal.fire("Error", "An unexpected error occurred while trying to delete the photo.", "error");
                            }
                        });
                    }
                });

            });
        });
    </script>

    {{-- Save Draft --}}
    {{-- <script>
    $(document).ready(function () {
        $('#kt_docs_formvalidation_text_save').on('click', function (e) {
            e.preventDefault();

            let form = $('#caseForm')[0]; 
            let formData = new FormData(form);

            // Tampilkan spinner
            $(this).prop('disabled', true);
            $(this).find('.indicator-label').hide();
            $(this).find('.indicator-progress').show();

            $.ajax({
                url: "{{ route('case.saveDraft') }}", 
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (res) {
                    if (res.success) {
                        Swal.fire('Success!', res.message, 'success');
                    } else {
                        Swal.fire('Failed!', res.message, 'error');
                    }
                },
                error: function (xhr) {
                    let errMsg = 'An error occurred.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errMsg = xhr.responseJSON.message;
                    }
                    Swal.fire('Error', errMsg, 'error');
                },
                complete: function () {
                    $('#kt_docs_formvalidation_text_save').prop('disabled', false);
                    $('#kt_docs_formvalidation_text_save .indicator-label').show();
                    $('#kt_docs_formvalidation_text_save .indicator-progress').hide();
                }
            });

        });
    });
    </script> --}}

    {{-- Validation & Update Case --}}
    {{-- Save Draft & Submit Case --}}
    {{-- <script>
    $(document).ready(function () {
        Dropzone.autoDiscover = false;
        let uploadedFiles = [];
        let isDraftSaved = false;

        var myDropzone = new Dropzone("#case-dropzone", {
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
                });

                this.on("removedfile", function (file) {
                    uploadedFiles = uploadedFiles.filter(f => f !== file);
                });
            }
        });

        const form = document.getElementById('caseForm');
        const btnSaveDraft = $('#kt_docs_formvalidation_text_save');
        const btnSubmitCase = $('#kt_docs_formvalidation_text_submit');
        const pageLoader = document.getElementById("page_loader");

        var validator = FormValidation.formValidation(form, {
            fields: {
                'cases': { validators: { notEmpty: { message: 'Case Name is required' } } },
                'date': { validators: { notEmpty: { message: 'Date is required' } } },
                'category': { validators: { notEmpty: { message: 'Category is required' } } },
                'sub_category': { validators: { notEmpty: { message: 'Sub Category is required' } } },
                'chronology': { validators: { notEmpty: { message: 'Chronology is required' } } },
                'impact': { validators: { notEmpty: { message: 'Outcome is required' } } },
                'suggestion': { validators: { notEmpty: { message: 'Suggestion is required' } } },
                'action': { validators: { notEmpty: { message: 'Action is required' } } }
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

        btnSaveDraft.on('click', function (e) {
            e.preventDefault();

            let formData = new FormData(form);
            uploadedFiles.forEach(file => formData.append('new_images[]', file));


            btnSaveDraft.prop('disabled', true);
            btnSaveDraft.find('.indicator-label').hide();
            btnSaveDraft.find('.indicator-progress').show();

            $.ajax({
                url: "{{ route('case.saveDraft') }}",
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (res) {
                    if (res.success) {
                        Swal.fire('Success!', 'Save draft successfully.', 'success').then(() => {
                            isDraftSaved = true;
                            btnSaveDraft.hide();
                            btnSubmitCase.show();
                        });
                    } else {
                        Swal.fire('Failed!', res.message || 'Failed to save draft.', 'error');
                    }
                },
                error: function (xhr) {
                    let errMsg = 'An error occurred.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errMsg = xhr.responseJSON.message;
                    }
                    Swal.fire('Error', errMsg, 'error');
                },
                complete: function () {
                    btnSaveDraft.prop('disabled', false);
                    btnSaveDraft.find('.indicator-label').show();
                    btnSaveDraft.find('.indicator-progress').hide();
                }
            });
        });

        // Submit Case button click
        btnSubmitCase.on('click', function (e) {
            e.preventDefault();

            if (!isDraftSaved) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Warning',
                    text: 'Please save draft before submitting the case.',
                    confirmButtonText: 'OK',
                    customClass: { 
                        confirmButton: "btn btn-warning" 
                    }
                });
                return;
            }

            validator.validate().then(function (status) {
                if (status === 'Valid') {
                    const formData = new FormData(form);
                    uploadedFiles.forEach(file => formData.append('new_images[]', file));

                    btnSubmitCase.attr('data-kt-indicator', 'on');
                    btnSubmitCase.prop('disabled', true);
                    pageLoader.style.display = "flex";

                    setTimeout(function () {
                        $.ajax({
                            url: "{{ route('cases.update') }}",
                            type: "POST",
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function (response) {
                                pageLoader.style.display = "none";
                                btnSubmitCase.removeAttr('data-kt-indicator');
                                btnSubmitCase.prop('disabled', false);

                                if (response.success) {
                                    Swal.fire({
                                        title: 'Success!',
                                        text: 'Your case has been successfully submitted.',
                                        icon: 'success',
                                        confirmButtonText: 'OK',
                                        customClass: { confirmButton: "btn btn-success" }
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            window.location.href = "{{ route('ViewCase') }}";
                                        }
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'Failed',
                                        text: response.message || 'Failed to update case.'
                                    });
                                }
                            },
                            error: function () {
                                pageLoader.style.display = "none";
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'An error occurred. Please try again.'
                                });
                            }
                        });
                    }, 800);
                } else {
                    Swal.fire({
                        text: "Please fill in all required fields correctly.",
                        icon: "warning",
                        confirmButtonText: "OK",
                        customClass: { confirmButton: "btn btn-warning" }
                    });
                }
            });
        });

        $('#existing-photos').on('click', 'img', function () {
            const imgSrc = $(this).attr('src');
            $('#modal-image').attr('src', imgSrc);
            $('#imageModal').modal('show');
        });

        $('.form-control, .form-select').on('input change', function () {
            $(this).removeClass('is-invalid');
            $('#error-' + $(this).attr('id')).text('');
        });

    });
    </script> --}}

    {{-- <script>
        $(document).ready(function () {
            Dropzone.autoDiscover = false;
            let uploadedFiles = [];

            var myDropzone = new Dropzone("#case-dropzone", {
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
                    });

                    this.on("removedfile", function (file) {
                        uploadedFiles = uploadedFiles.filter(f => f !== file);
                    });
                }
            });

            const form = document.getElementById('caseForm');
            const btnSaveDraft = $('#kt_docs_formvalidation_text_save');
            const btnSubmitCase = $('#kt_docs_formvalidation_text_submit');
            const pageLoader = document.getElementById("page_loader");

            var validator = FormValidation.formValidation(form, {
                fields: {
                    'cases': { validators: { notEmpty: { message: 'Case Name is required' } } },
                    'date': { validators: { notEmpty: { message: 'Date is required' } } },
                    'category': { validators: { notEmpty: { message: 'Category is required' } } },
                    'sub_category': { validators: { notEmpty: { message: 'Sub Category is required' } } },
                    'chronology': { validators: { notEmpty: { message: 'Chronology is required' } } },
                    'impact': { validators: { notEmpty: { message: 'Outcome is required' } } },
                    'suggestion': { validators: { notEmpty: { message: 'Suggestion is required' } } },
                    'action': { validators: { notEmpty: { message: 'Action is required' } } }
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

            // SAVE CASE BUTTON
            btnSaveDraft.on('click', function (e) {
                e.preventDefault();

                let formData = new FormData(form);
                uploadedFiles.forEach(file => formData.append('new_images[]', file));

                btnSaveDraft.prop('disabled', true);
                btnSaveDraft.find('.indicator-label').hide();
                btnSaveDraft.find('.indicator-progress').show();

                $.ajax({
                    url: "{{ route('case.saveDraft') }}",
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (res) {
                        if (res.success) {
                            Swal.fire({
                                title: 'Success!',
                                text: 'Draft saved successfully.',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Failed!', res.message || 'Failed to save draft.', 'error');
                        }
                    },
                    error: function (xhr) {
                        let errMsg = 'An error occurred.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errMsg = xhr.responseJSON.message;
                        }
                        Swal.fire('Error', errMsg, 'error');
                    },
                    complete: function () {
                        btnSaveDraft.prop('disabled', false);
                        btnSaveDraft.find('.indicator-label').show();
                        btnSaveDraft.find('.indicator-progress').hide();
                    }
                });
            });

            // SUBMIT CASE BUTTON
            btnSubmitCase.on('click', function (e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Submit Case?',
                    text: 'This will not save or update any data. Do you want to continue?',
                    icon: 'warning',
                    showCancelButton: true,
                    showDenyButton: true,
                    confirmButtonText: 'Submit Anyway',
                    denyButtonText: 'Save Case',
                    cancelButtonText: 'Cancel',
                    customClass: {
                        confirmButton: 'btn btn-danger',
                        denyButton: 'btn btn-warning',
                        cancelButton: 'btn btn-secondary'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Submit without saving
                        validator.validate().then(function (status) {
                            if (status === 'Valid') {
                                const formData = new FormData(form);
                                uploadedFiles.forEach(file => formData.append('new_images[]', file));

                                btnSubmitCase.attr('data-kt-indicator', 'on');
                                btnSubmitCase.prop('disabled', true);
                                pageLoader.style.display = "flex";

                                setTimeout(function () {
                                    $.ajax({
                                        url: "{{ route('cases.update') }}",
                                        type: "POST",
                                        data: formData,
                                        processData: false,
                                        contentType: false,
                                        success: function (response) {
                                            pageLoader.style.display = "none";
                                            btnSubmitCase.removeAttr('data-kt-indicator');
                                            btnSubmitCase.prop('disabled', false);

                                            if (response.success) {
                                                Swal.fire({
                                                    title: 'Success!',
                                                    text: 'Your case has been successfully submitted.',
                                                    icon: 'success',
                                                    confirmButtonText: 'OK'
                                                }).then(() => {
                                                    window.location.href = "{{ route('ViewCase') }}";
                                                });
                                            } else {
                                                Swal.fire('Failed', response.message || 'Failed to submit case.', 'error');
                                            }
                                        },
                                        error: function () {
                                            pageLoader.style.display = "none";
                                            Swal.fire('Error', 'An error occurred. Please try again.', 'error');
                                        }
                                    });
                                }, 800);
                            } else {
                                Swal.fire({
                                    text: "Please fill in all required fields correctly.",
                                    icon: "warning"
                                });
                            }
                        });
                    } else if (result.isDenied) {
                        btnSaveDraft.trigger('click'); // Trigger save case
                    }
                });
            });

            $('#existing-photos').on('click', 'img', function () {
                const imgSrc = $(this).attr('src');
                $('#modal-image').attr('src', imgSrc);
                $('#imageModal').modal('show');
            });

            $('.form-control, .form-select').on('input change', function () {
                $(this).removeClass('is-invalid');
                $('#error-' + $(this).attr('id')).text('');
            });
        });
    </script>


    <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Cek apakah form dalam mode view-only
        const form = document.querySelector('.view-only');
        if (form) {
            // Disable semua input, textarea, dan select
            const fields = form.querySelectorAll('input, textarea, select, button[type="submit"]');

            fields.forEach(field => {
                // Hanya disable input yang bukan CSRF atau hidden (jangan disable CSRF!)
                if (field.name !== '_token' && field.type !== 'hidden') {
                    field.setAttribute('disabled', true);
                }
            });

            // Optional: Disable dropzone
            const dropzone = document.getElementById('case-dropzone');
            if (dropzone) {
                dropzone.classList.add('disabled');
                dropzone.style.pointerEvents = 'none';
                dropzone.style.opacity = '0.6';
            }

            // Optional: Hide buttons
            document.querySelectorAll('.delete-photo').forEach(btn => btn.style.display = 'none');
        }
    });
</script> --}}

{{-- Script: Lock Form Saat Halaman Dibuka --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('.view-only');
    const fields = form.querySelectorAll('input, textarea, select, button:not(#btn-edit-case):not(#kt_docs_formvalidation_text_submit)');
    const dropzone = document.getElementById('case-dropzone');

    const btnEdit = document.getElementById('btn-edit-case');
    const btnSave = document.getElementById('kt_docs_formvalidation_text_save');
    const btnSubmit = document.getElementById('kt_docs_formvalidation_text_submit');

    // Saat pertama masuk: mode view-only
    function setViewMode() {
        fields.forEach(field => {
            if (field.name !== '_token' && field.type !== 'hidden') {
                field.setAttribute('disabled', true);
            }
        });

        if (dropzone) {
            dropzone.classList.add('disabled');
            dropzone.style.pointerEvents = 'none';
            dropzone.style.opacity = '0.6';
        }

        btnEdit.style.display = 'inline-block';
        btnSubmit.style.display = 'inline-block';
        btnSave.style.display = 'none';
    }

    // Mode edit aktif
    function setEditMode() {
        fields.forEach(field => {
            field.removeAttribute('disabled');
        });

        if (dropzone) {
            dropzone.classList.remove('disabled');
            dropzone.style.pointerEvents = 'auto';
            dropzone.style.opacity = '1';
        }

        btnEdit.style.display = 'none';
        btnSubmit.style.display = 'none';
        btnSave.style.display = 'inline-block';
    }

    // Saat klik Edit Case
    btnEdit.addEventListener('click', function () {
        setEditMode();
    });

    // Reset ke mode view setelah refresh
    setViewMode();
});
</script>

{{-- Script: Mode Edit + Save + Submit --}}
<script>
$(document).ready(function () {
    Dropzone.autoDiscover = false;
    let uploadedFiles = [];

    const form = document.getElementById('caseForm');
    const btnSave = $('#kt_docs_formvalidation_text_save');
    const btnSubmit = $('#kt_docs_formvalidation_text_submit');
    const pageLoader = document.getElementById("page_loader");

    var myDropzone = new Dropzone("#case-dropzone", {
        url: "https://keenthemes.com/scripts/void.php",
        autoProcessQueue: false,
        addRemoveLinks: true,
        maxFiles: 5,
        maxFilesize: 2,
        acceptedFiles: 'image/jpeg,image/png,image/jpg',
        dictDefaultMessage: 'Drop files here or click to upload.',
        init: function () {
            this.on("addedfile", function (file) {
                if (!['image/jpeg', 'image/png', 'image/jpg'].includes(file.type) || file.size > 2 * 1024 * 1024 || uploadedFiles.length >= 5) {
                    this.removeFile(file);
                    Swal.fire({ icon: 'warning', title: 'Invalid File', text: 'File must be JPG/PNG, < 2MB, max 5 files.' });
                } else {
                    uploadedFiles.push(file);
                }
            });
            this.on("removedfile", function (file) {
                uploadedFiles = uploadedFiles.filter(f => f !== file);
            });
        }
    });

    const validator = FormValidation.formValidation(form, {
        fields: {
            'cases': { validators: { notEmpty: { message: 'Case Name is required' } } },
            'date': { validators: { notEmpty: { message: 'Date is required' } } },
            'category': { validators: { notEmpty: { message: 'Category is required' } } },
            'sub_category': { validators: { notEmpty: { message: 'Sub Category is required' } } },
            'chronology': { validators: { notEmpty: { message: 'Chronology is required' } } },
            'impact': { validators: { notEmpty: { message: 'Outcome is required' } } },
            'suggestion': { validators: { notEmpty: { message: 'Suggestion is required' } } },
            'action': { validators: { notEmpty: { message: 'Action is required' } } }
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

    // SAVE BUTTON
    btnSave.on('click', function (e) {
        e.preventDefault();

        Swal.fire({
            title: 'Save Case?',
            text: 'Are you sure you want to save the case?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, Save',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                const formData = new FormData(form);
                uploadedFiles.forEach(file => formData.append('new_images[]', file));

                btnSave.prop('disabled', true);
                btnSave.find('.indicator-label').hide();
                btnSave.find('.indicator-progress').show();

                $.ajax({
                    url: "{{ route('case.saveDraft') }}",
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (res) {
                        if (res.success) {
                            Swal.fire({
                                title: 'Success!',
                                text: 'Case saved successfully.',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => location.reload());
                        } else {
                            Swal.fire('Failed!', res.message || 'Failed to save draft.', 'error');
                        }
                    },
                    error: function (xhr) {
                        let errMsg = xhr.responseJSON?.message || 'An error occurred.';
                        Swal.fire('Error', errMsg, 'error');
                    },
                    complete: function () {
                        btnSave.prop('disabled', false);
                        btnSave.find('.indicator-label').show();
                        btnSave.find('.indicator-progress').hide();
                    }
                });
            }
        });
    });

    // SUBMIT BUTTON
    btnSubmit.on('click', function (e) {
        e.preventDefault();

        Swal.fire({
            title: 'Submit Case?',
            text: 'Are you sure all data is correct before submitting?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Submit',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                validator.validate().then(function (status) {
                    if (status === 'Valid') {
                        const formData = new FormData(form);
                        uploadedFiles.forEach(file => formData.append('new_images[]', file));

                        btnSubmit.attr('data-kt-indicator', 'on').prop('disabled', true);
                        pageLoader.style.display = "flex";

                        setTimeout(() => {
                            $.ajax({
                                url: "{{ route('cases.update') }}",
                                type: "POST",
                                data: formData,
                                processData: false,
                                contentType: false,
                                success: function (response) {
                                    pageLoader.style.display = "none";
                                    btnSubmit.removeAttr('data-kt-indicator').prop('disabled', false);

                                    if (response.success) {
                                        Swal.fire({
                                            title: 'Success!',
                                            text: 'Case submitted successfully.',
                                            icon: 'success',
                                            confirmButtonText: 'OK'
                                        }).then(() => window.location.href = "{{ route('ViewCase') }}");
                                    } else {
                                        Swal.fire('Failed', response.message || 'Failed to submit case.', 'error');
                                    }
                                },
                                error: function () {
                                    pageLoader.style.display = "none";
                                    Swal.fire('Error', 'An error occurred. Please try again.', 'error');
                                }
                            });
                        }, 800);
                    } else {
                        Swal.fire({
                            text: "Please fill in all required fields correctly.",
                            icon: "warning"
                        });
                    }
                });
            }
        });
    });

    // Show image modal
    $('#existing-photos').on('click', 'img', function () {
        const imgSrc = $(this).attr('src');
        $('#modal-image').attr('src', imgSrc);
        $('#imageModal').modal('show');
    });

    $('.form-control, .form-select').on('input change', function () {
        $(this).removeClass('is-invalid');
        $('#error-' + $(this).attr('id')).text('');
    });
});
</script>


