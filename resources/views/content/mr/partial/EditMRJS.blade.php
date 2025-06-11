    {{-- Date --}}
    <script>
        $("#date").flatpickr({
            enableTime: true, 
            time_24hr: true,  
            altInput: true,
            altFormat: "d/m/Y H:i", 
            dateFormat: "Y-m-d H:i", 
        });
    </script>
    
    {{-- Script Untuk Update MR + Validatation --}}
    {{-- <script>
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
                                            window.location.href = "http://localhost/BmMaintenance/public/Material-Request/list";
                                        });
                                    } else {
                                        Swal.fire({
                                            title: 'Failed!',
                                            text: response.message || 'Failed to save Material Request.',
                                            icon: 'error',
                                              confirmButtonText: 'OK',
                                            customClass: { confirmButton: "btn btn-danger" }
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

    </script> --}}
 
    <script>
        // DECLARE ROUTE KE MR LIST
        const listMRUrl = "{{ route('ListMR') }}";

        const form = document.getElementById('MrForm');
        const pageLoader = document.getElementById('page_loader');
        const submitButton = document.getElementById('kt_docs_formvalidation_text_submit');
        const saveButton = document.getElementById('kt_docs_formvalidation_text_save');

        let isDraftSaved = false; 

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

            rows.forEach((row) => {
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

        // Fungsi untuk Save Draft MR
        saveButton.addEventListener('click', function(e) {
            e.preventDefault();

            validator.validate().then(function(status) {
                if (status === 'Valid') {
                    if (!validateMaterialTable()) return;

                    pageLoader.style.display = "flex";
                    saveButton.disabled = true;

                    const formData = new FormData(form);

                    $.ajax({
                        url: "{{ route('MR.SaveDraft') }}",
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            pageLoader.style.display = "none";
                            saveButton.disabled = false;

                            if (response.success) {
                                Swal.fire({
                                    title: 'Success!',
                                    text: response.message || 'Draft saved successfully.',
                                    icon: 'success',
                                    confirmButtonText: 'OK',
                                    customClass: { confirmButton: "btn btn-success" }
                                }).then(() => {
                                    // Setelah sukses, sembunyikan tombol Save MR
                                    saveButton.style.display = 'none';
                                    isDraftSaved = true;
                                });
                            } else {
                                Swal.fire({
                                    title: 'Failed!',
                                    text: response.message || 'Failed to save draft.',
                                    icon: 'error',
                                    confirmButtonText: 'OK',
                                    customClass: { confirmButton: "btn btn-danger" }
                                });
                            }
                        },
                        error: function(xhr) {
                            pageLoader.style.display = "none";
                            saveButton.disabled = false;

                            Swal.fire({
                                title: 'Error!',
                                text: xhr.responseJSON?.message || 'Failed to save draft. Please try again.',
                                icon: 'warning',
                                confirmButtonText: 'OK',
                                customClass: { confirmButton: "btn btn-warning" }
                            });
                        }
                    });
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

        // Submit / Update MR
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            // Cek apakah draft sudah disimpan dulu
            if (!isDraftSaved) {
                Swal.fire({
                    title: 'Warning!',
                    text: 'You must save the Material Request draft first before submitting.',
                    icon: 'warning',
                    confirmButtonText: 'OK',
                    customClass: { confirmButton: "btn btn-warning" }
                });
                return; // Stop proses submit
            }

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
                                            window.location.href = listMRUrl;
                                        });

                                    } else {
                                        Swal.fire({
                                            title: 'Failed!',
                                            text: response.message || 'Failed to save Material Request.',
                                            icon: 'error',
                                            confirmButtonText: 'OK',
                                            customClass: { confirmButton: "btn btn-danger" }
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