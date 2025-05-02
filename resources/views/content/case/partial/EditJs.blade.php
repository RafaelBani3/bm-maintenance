<link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css"/>
<script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>

{{-- Date Time --}}
<script>
    $("#date").flatpickr({
        altInput: true,
        altFormat: "d/m/Y",
        dateFormat: "Y-m-d",
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
                        url: "{{ route('cases.deleteImage') }}",
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

{{-- Validation & Update Case --}}
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
    const submitButton = document.getElementById('kt_docs_formvalidation_text_submit');

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

    submitButton.addEventListener('click', function (e) {
        e.preventDefault();

        validator.validate().then(function (status) {
            if (status === 'Valid') {
                const formData = new FormData(form);

                uploadedFiles.forEach((file, index) => {
                    formData.append('new_images[]', file);
                });

                $('#page-loader').removeClass('d-none');

                setTimeout(function () {    
                    $.ajax({
                        url: "{{ route('cases.update') }}",
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (response) {
                            $('#page-loader').addClass('d-none');
                            submitButton.removeAttribute('data-kt-indicator');
                            submitButton.disabled = false;

                            if (response.success) {
                                Swal.fire({
                                    title: 'Success!',
                                    text: response.message,
                                    icon: 'success',
                                    confirmButtonText: 'OK',
                                    customClass: { confirmButton: "btn btn-success" }
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = "/Case-Report/Create";
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
                            $('#page-loader').addClass('d-none');
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'An error occurred. Please try again.'
                            });
                        }
                    });
                }, 3000);
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

    // Preview Image
    $('#existing-photos').on('click', 'img', function () {
        const imgSrc = $(this).attr('src');
        $('#modal-image').attr('src', imgSrc);
        $('#imageModal').modal('show');
    });

    // Hapus error saat user mengetik ulang
    $('.form-control, .form-select').on('input change', function () {
        $(this).removeClass('is-invalid');
        $('#error-' + $(this).attr('id')).text('');
    });
});

</script> --}}

<script>
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
        const submitButton = document.getElementById('kt_docs_formvalidation_text_submit');
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

        submitButton.addEventListener('click', function (e) {
            e.preventDefault();

            validator.validate().then(function (status) {
                if (status === 'Valid') {
                    const formData = new FormData(form);

                    uploadedFiles.forEach((file, index) => {
                        formData.append('new_images[]', file);
                    });

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
                                submitButton.removeAttribute('data-kt-indicator');
                                submitButton.disabled = false;

                                if (response.success) {
                                    Swal.fire({
                                        title: 'Success!',
                                        text: response.message,
                                        icon: 'success',
                                        confirmButtonText: 'OK',
                                        customClass: { confirmButton: "btn btn-success" }
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            window.location.href = `${BASE_URL}/Case-Report/Create`;
                                            // window.location.href = "/Case-Report/Create";
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

        // Preview Image
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

@if(session('success'))
    <script>
        Swal.fire({
            title: "Success!",
            text: "{{ session('success') }}",
            icon: "success",
            timer: 2000,
            showConfirmButton: false
        });
    </script>
@endif
