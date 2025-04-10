{{-- <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css"/>
<script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script> --}}

{{-- Date Time --}}
<script>
$("#date").flatpickr({
    enableTime: true,
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

                fetch(`/get-subcategories/${categoryId}`)
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

        subCategorySelect.addEventListener("change", function() {
            const subCategoryId = this.value;

            if (subCategoryId) {
                pageLoader.style.display = "flex";

                setTimeout(() => {
                    pageLoader.style.display = "none";
                }, 2000);
            }
        });
    });
</script>

{{-- Validatation --}}
{{-- <script>
    $(document).ready(function () {
        const form = document.getElementById('caseForm');

        var validator = FormValidation.formValidation(
            form,
            {
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
            }
        );

        // Dropzone setup
        Dropzone.autoDiscover = false;
        let uploadedFiles = [];
        var myDropzone = new Dropzone("#case-dropzone", {
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
                });

                this.on("removedfile", function (file) {
                    uploadedFiles = uploadedFiles.filter(f => f !== file);
                });

                this.on("thumbnail", function (file) {
                    file.previewElement.addEventListener("click", function () {
                        $('#modal-image').attr('src', file.dataURL);
                        $('#imageModal').modal('show');
                    });
                });
            }
        });

        // Tombol Submit
        const submitButton = document.getElementById('kt_docs_formvalidation_text_submit');
        submitButton.addEventListener('click', function (e) {
            e.preventDefault();

            validator.validate().then(function (status) {
                if (status === 'Valid') {
                    let formData = new FormData(form);

                    // Tambahkan file dari Dropzone ke FormData
                    uploadedFiles.forEach((file) => {
                        formData.append('photos[]', file);
                    });

                    submitButton.setAttribute('data-kt-indicator', 'on');
                    submitButton.disabled = true;

                    // Eksekusi Save ke Backend
                    saveCase(formData);
                } else {
                    Swal.fire({
                        text: "Please fill in all required fields correctly.",
                        icon: "warning",
                        confirmButtonText: "Ok, I understand",
                        customClass: { 
                            confirmButton: "btn btn-warning" 
                        }
                    });
                }
            });
        });

        // AJAX Save Case ke Backend
        function saveCase(formData) {
            $.ajax({
                url: "{{ route('SaveCase') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    submitButton.removeAttribute('data-kt-indicator');
                    submitButton.disabled = false;

                    if (response.success) {
                        Swal.fire({
                            title: 'Success!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'OK',
                            customClass: { 
                            confirmButton: "btn btn-success" 
                        }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                let encodedCaseNo = encodeURIComponent(response.case_no);
                                window.location.href = "/Case/Edit?case_no=" + encodedCaseNo;
                            }
                        });
                    }
                },
                error: function (xhr) {
                    submitButton.removeAttribute('data-kt-indicator');
                    submitButton.disabled = false;
                    Swal.fire({
                        title: 'warning',
                        text: 'Failed to save case. Please try again.',
                        icon: 'error',
                        confirmButtonText: 'OK',
                        customClass: { 
                            confirmButton: "btn btn-warning" 
                        }
                    });
                }
            });
        }

        $('.form-control, .form-select').on('input change', function () {
            $(this).removeClass('is-invalid');
            $('#error-' + $(this).attr('id')).text('');
        });
    });
</script> --}}

<script>
    $(document).ready(function () {
        const form = document.getElementById('caseForm');
        const submitButton = document.getElementById('kt_docs_formvalidation_text_submit');
        const pageLoader = document.getElementById("page_loader");

        var validator = FormValidation.formValidation(
            form,
            {
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
            }
        );

        // Dropzone setup
        Dropzone.autoDiscover = false;
        let uploadedFiles = [];
        var myDropzone = new Dropzone("#case-dropzone", {
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
                });

                this.on("removedfile", function (file) {
                    uploadedFiles = uploadedFiles.filter(f => f !== file);
                });
            }
        });

        // Tombol Submit
        submitButton.addEventListener('click', function (e) {
            e.preventDefault();

            validator.validate().then(function (status) {
                if (status === 'Valid') {
                    let formData = new FormData(form);

                    // Tambahkan file dari Dropzone ke FormData
                    uploadedFiles.forEach((file) => {
                        formData.append('photos[]', file);
                    });

                    // Tampilkan loading indicator & page loader
                    pageLoader.style.display = "flex";
                    submitButton.querySelector(".indicator-label").style.display = "none";
                    submitButton.querySelector(".indicator-progress").style.display = "inline-block";
                    submitButton.disabled = true;

                    // Eksekusi Save ke Backend
                    saveCase(formData);
                } else {
                    Swal.fire({
                        text: "Please fill in all required fields correctly.",
                        icon: "warning",
                        confirmButtonText: "Ok, I understand",
                        customClass: { 
                            confirmButton: "btn btn-warning" 
                        }
                    });
                }
            });
        });

        // AJAX Save Case ke Backend
        function saveCase(formData) {
            $.ajax({
                url: "{{ route('SaveCase') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    setTimeout(function() { // Biarkan page loader tampil selama 5 detik
                        pageLoader.style.display = "none"; 
                        submitButton.querySelector(".indicator-label").style.display = "inline-block";
                        submitButton.querySelector(".indicator-progress").style.display = "none";
                        submitButton.disabled = false;

                        if (response.success) {
                            Swal.fire({
                                title: 'Success!',
                                text: response.message,
                                icon: 'success',
                                confirmButtonText: 'OK',
                                customClass: { 
                                    confirmButton: "btn btn-success" 
                                }
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    let encodedCaseNo = encodeURIComponent(response.case_no);
                                    window.location.href = "/Case/Edit?case_no=" + encodedCaseNo;
                                }
                            });
                        }
                    }, 5000);
                },
                error: function (xhr) {
                    setTimeout(function() { // Page loader tetap muncul selama 5 detik
                        pageLoader.style.display = "none";
                        submitButton.querySelector(".indicator-label").style.display = "inline-block";
                        submitButton.querySelector(".indicator-progress").style.display = "none";
                        submitButton.disabled = false;

                        Swal.fire({
                            title: 'Error!',
                            text: 'Failed to save case. Please try again.',
                            icon: 'error',
                            confirmButtonText: 'OK',
                            customClass: { 
                                confirmButton: "btn btn-warning" 
                            }
                        });
                    }, 5000);
                }
            });
        }

        // Hapus error saat input berubah
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



{{-- function saveCase(formData) {
            $.ajax({
                url: '/your-save-case-url',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Data berhasil disimpan.'
                    });
                    $('#caseForm')[0].reset();
                    myDropzone.removeAllFiles(true);
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: 'Terjadi kesalahan saat menyimpan data.'
                    });
                }
            });
        } --}}


{{-- Dropzone.autoDiscover = false;
    let uploadedFiles = [];
    
    var myDropzone = new Dropzone("#case-dropzone", {
        url: "https://keenthemes.com/scripts/void.php", // Tidak dipakai, karena upload saat submit
        autoProcessQueue: false,
        addRemoveLinks: true,
        maxFiles: 5,
        acceptedFiles: 'image/*',
        dictDefaultMessage: 'Drop files here or click to upload.',
        init: function() {
            this.on("addedfile", function(file) {
                uploadedFiles.push(file);
            });
            this.on("removedfile", function(file) {
                uploadedFiles = uploadedFiles.filter(f => f !== file);
            });
        }
    });
  
    $('#caseForm').submit(function(e) {
        e.preventDefault();
        let formData = new FormData(this);
    
        // Append file dari dropzone ke formData
        uploadedFiles.forEach((file) => {
            formData.append('photos[]', file);
        });
    
        saveCase(formData);
    }); --}}

   
        
