    {{-- Date Time --}}
    <script>
        $("#date").flatpickr({
            enableTime: true,
            dateFormat: "d/m/Y H:i",
            minDate: "today",
            defaultDate: new Date(), // Set default to now
            onDayCreate: function(dObj, dStr, fp, dayElem) {
                const today = new Date();
                const date = dayElem.dateObj;

                if (
                    date.getDate() === today.getDate() &&
                    date.getMonth() === today.getMonth() &&
                    date.getFullYear() === today.getFullYear()
                ) {
                    dayElem.classList.add("today-highlight");
                }
            }
        });
    </script>

    {{-- Category dan SubCategory --}}
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const categorySelect = document.getElementById("category");
            const subCategorySelect = document.getElementById("sub_category");
            const pageLoader = document.getElementById("page_loader");

            $(categorySelect).select2({
                placeholder: "Select Category",
                allowClear: true
            });

            $(subCategorySelect).select2({
                placeholder: "You Should Choose Category First",
                allowClear: true
            });

            $(categorySelect).on("change", function () {
                const categoryId = this.value;

                if (categoryId) {
                    pageLoader.style.display = "flex";

                    subCategorySelect.innerHTML = `<option value="">Loading...</option>`;
                    $(subCategorySelect).prop("disabled", true).trigger("change");

                    fetch(`${BASE_URL}/get-subcategories/${categoryId}`)
                        .then(response => {
                            if (!response.ok) throw new Error('Failed to fetch sub-categories');
                            return response.json();
                        })
                        .then(data => {
                            pageLoader.style.display = "none";

                            subCategorySelect.innerHTML = `<option value="">Select Sub Category</option>`;
                            data.forEach(subCat => {
                                const option = document.createElement("option");
                                option.value = subCat.Scat_No;
                                option.textContent = subCat.Scat_Name;
                                subCategorySelect.appendChild(option);
                            });

                            $(subCategorySelect).prop("disabled", false).trigger("change");
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
                    $(subCategorySelect).prop("disabled", true).trigger("change");

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

            $(subCategorySelect).on("change", function () {
                const subCategoryId = this.value;

                if (subCategoryId) {
                    pageLoader.style.display = "flex";
                    setTimeout(() => {
                        pageLoader.style.display = "none";
                    }, 800);
                }
            });
        });
    </script>

    {{-- Validatation + Save Case--}}
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
                        'action': { validators: { notEmpty: { message: 'Action is required' } } },
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

            // Submit Button
            submitButton.addEventListener('click', function (e) {
                e.preventDefault();

                validator.validate().then(function (status) {
                    if (status === 'Valid') {
                        if (uploadedFiles.length === 0) {
                            Swal.fire({
                                text: "Please upload at least one image.",
                                icon: "warning",
                                confirmButtonText: "OK",
                                customClass: { confirmButton: "btn btn-warning" }
                            });
                            return; 
                        }

                        let formData = new FormData(form);

                        uploadedFiles.forEach((file) => {
                            formData.append('photos[]', file);
                        });

                        pageLoader.style.display = "flex";
                        submitButton.querySelector(".indicator-label").style.display = "none";
                        submitButton.querySelector(".indicator-progress").style.display = "inline-block";
                        submitButton.disabled = true;

                        saveCase(formData);
                    } else {
                        Swal.fire({
                            text: "Please fill in all required fields correctly.",
                            icon: "warning",
                            confirmButtonText: "Ok, I understand",
                            customClass: { confirmButton: "btn btn-warning" }
                        });
                    }
                });
            });
            
            // Declare Route untuk Ke Edit Page
            const editCaseRoute = @json(route('EditCase', ':encoded_case_no'));

            // AJAX Save
            function saveCase(formData) {
                $.ajax({
                    url: "{{ route('SaveCase') }}",
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
                                    text: response.message,
                                    icon: 'success',
                                    confirmButtonText: 'OK',
                                    customClass: { confirmButton: "btn btn-success" }
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        const encodedCaseNo = btoa(response.case_no); 
                                        const finalUrl = editCaseRoute.replace(':encoded_case_no', encodedCaseNo);
                                        window.location.href = finalUrl; 
                                    }                           
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
                                text: 'Failed to save case. Please try again.',
                                icon: 'error',
                                confirmButtonText: 'OK',
                                customClass: { confirmButton: "btn btn-warning" }
                            });
                        }, 800);
                    }
                });
            }

            $('.form-control, .form-select').on('input change', function () {
                $(this).removeClass('is-invalid');
                $('#error-' + $(this).attr('id')).text('');
            });
        }); 
    </script>
    {{-- End script --}}

    <style>
        .dz-preview {
            cursor: pointer;
        }
    </style>

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


   