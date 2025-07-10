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
    <script>
        $(document).ready(function () {
            const listMRUrl = "{{ route('ListMR') }}";
            const form = document.getElementById('MrForm');
            const pageLoader = document.getElementById('page_loader');
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
                // const unit = row.querySelector('select[name*="[unit]"]'); 
                // const code = row.querySelector('input[name*="[code]"]');
                const name = row.querySelector('input[name*="[name]"]');
                const desc = row.querySelector('input[name*="[desc]"]');

                [qty, name, desc].forEach(el => el?.classList.remove('is-invalid'));

                if (!qty?.value || qty.value <= 0) {
                    qty?.classList.add('is-invalid');
                    isValid = false;
                }
                // if (!unit?.value.trim()) {
                //     unit?.classList.add('is-invalid');
                //     isValid = false;
                // }
                // if (!code?.value.trim()) {
                //     code?.classList.add('is-invalid');
                //     isValid = false;
                // }
                if (!name?.value.trim()) {
                    name?.classList.add('is-invalid');
                    isValid = false;
                }
                if (!desc?.value.trim()) {
                    desc?.classList.add('is-invalid');
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
                        reference_number: { validators: { notEmpty: { message: 'Reference is required' } } },
                        case_no: { validators: { notEmpty: { message: 'Case No is required' } } },
                        date: { validators: { notEmpty: { message: 'Date is required' } } },
                        created_by: { validators: { notEmpty: { message: 'Created BY is required' } } },
                        department: { validators: { notEmpty: { message: 'Department is required' } } },
                        Designation: { validators: { notEmpty: { message: 'Designation is required' } } }
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

            // === SAVE DRAFT BUTTON ===
            $(document).on('click', '#kt_docs_formvalidation_text_save', function (e) {
                e.preventDefault();
                const saveButton = $(this);

                validator.validate().then(function (status) {
                    if (status === 'Valid') {
                        if (!validateMaterialTable()) return;

                        pageLoader.style.display = "flex";
                        saveButton.prop('disabled', true);

                        const formData = new FormData(form);

                        $.ajax({
                            url: "{{ route('MR.SaveDraft') }}",
                            type: "POST",
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function (response) {
                                pageLoader.style.display = "none";
                                saveButton.prop('disabled', false);

                                if (response.success) {
                                    Swal.fire({
                                        title: 'Success!',
                                        text: response.message || 'Draft saved successfully.',
                                        icon: 'success',
                                        confirmButtonText: 'OK',
                                        customClass: { confirmButton: "btn btn-success" }
                                    }).then(() => {
                                        saveButton.hide();
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
                            error: function (xhr) {
                                pageLoader.style.display = "none";
                                saveButton.prop('disabled', false);

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

            // === FORM SUBMIT / UPDATE BUTTON ===
            $('#MrForm').on('submit', function (e) {
                e.preventDefault();

                if (!isDraftSaved) {
                    Swal.fire({
                        title: 'Warning!',
                        text: 'You must save the Material Request draft first before submitting.',
                        icon: 'warning',
                        confirmButtonText: 'OK',
                        customClass: { confirmButton: "btn btn-warning" }
                    });
                    return;
                }

                validator.validate().then(function (status) {
                    if (status === 'Valid') {
                        if (!validateMaterialTable()) return;

                        const submitButton = $('#kt_docs_formvalidation_text_submit');
                        const formData = new FormData(form);

                        pageLoader.style.display = "flex";
                        submitButton.find(".indicator-label").hide();
                        submitButton.find(".indicator-progress").show();
                        submitButton.prop('disabled', true);

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
                                        submitButton.find(".indicator-label").show();
                                        submitButton.find(".indicator-progress").hide();
                                        submitButton.prop('disabled', false);

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
                                        submitButton.find(".indicator-label").show();
                                        submitButton.find(".indicator-progress").hide();
                                        submitButton.prop('disabled', false);

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
        });
    </script>

    {{-- Script Add Row --}}
    <script>
        let uomData = [];

        $(document).ready(function () {
            $.ajax({
                url: "http://10.10.10.86:8088/erp_api/api/ifca/get/uom",
                type: "GET",
                headers: { "accept": "application/json" },
                success: function (response) {
                    if (response.success && response.data.uom.length > 0) {
                        uomData = response.data.uom;
                        initSelect2Unit(); 
                    } else {
                        console.error('No UOM data found');
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Failed to load UOM data:", error);
                }
            });

            // Fungsi inisialisasi Select2 Unit
            function initSelect2Unit() {
                $('.select2-unit').each(function () {
                    const select = $(this);
                    const selectedCode = select.data('selected-code');

                    select.empty().append('<option value="">Select Unit</option>');
                    $.each(uomData, function (index, item) {
                        const isSelected = item.uom_cd === selectedCode;
                        select.append('<option value="' + item.descs + '" data-code="' + item.uom_cd + '"' + (isSelected ? ' selected' : '') + '>' + item.descs + '</option>');
                    });

                    select.select2({
                        placeholder: "Select Unit",
                        allowClear: true,
                        width: '100%'
                    });

                    if (selectedCode) {
                        select.closest('td').find('input[name$="[unit_cd]"]').val(selectedCode);
                    }
                });
            }

            $(document).on('change', '.select2-unit', function () {
                const code = $(this).find(':selected').data('code') ?? '';
                $(this).closest('td').find('input[name$="[unit_cd]"]').val(code);
            });

            // Tombol Add Row
            $('#add-row').on('click', function () {
                const rowCount = $('#material-body tr').length;

                const newRow = $(`
                    <tr>
                        <td class="text-center">${rowCount + 1}</td>
                        <td>
                            <input type="number" name="items[${rowCount}][qty]" class="form-control form-control-lg">
                        </td>
                        <td>
                            <select name="items[${rowCount}][unit]" class="form-select select2-unit w-100" style="min-width: 150px;"></select>
                            <input type="hidden" name="items[${rowCount}][unit_cd]" class="unit-code">
                        </td>
                        <td>
                            <input type="text" name="items[${rowCount}][code]" class="form-control form-control-lg" >
                        </td>
                        <td>
                            <input type="text" name="items[${rowCount}][name]" class="form-control form-control-lg" >
                        </td>
                        <td>
                            <input type="text" name="items[${rowCount}][desc]" class="form-control form-control-lg">
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-danger remove-row">
                                <i class="ki-duotone ki-trash fs-2x text-white">
                                    <span class="path1"></span><span class="path2"></span><span class="path3"></span>
                                    <span class="path4"></span><span class="path5"></span>
                                </i>
                            </button>
                        </td>
                    </tr>
                `);

                $('#material-body').append(newRow);
                updateRowNumbers();
                initSelect2Unit();
            });

            // Delete Row
            $(document).on('click', '.remove-row', function () {
                const row = $(this).closest('tr');
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
            });

            // Update name fields saat reorder row
            function updateRowNumbers() {
                $('#material-body tr').each(function (index) {
                    $(this).find('td:first').text(index + 1);

                    $(this).find('input, select').each(function () {
                        const name = $(this).attr('name');
                        if (name) {
                            const newName = name.replace(/items\[\d+\]/, `items[${index}]`);
                            $(this).attr('name', newName);
                        }
                    });
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

