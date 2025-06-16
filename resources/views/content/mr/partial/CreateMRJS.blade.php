    {{-- Date --}}
    <script>    
        $("#date").flatpickr({
            enableTime: true,
            altInput: true,
            time_24hr: true,
            altFormat: "d/m/Y H:i",
            dateFormat: "Y-m-d H:i",
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

    {{-- Script Validatation & Save MR --}}
    <script>
        const form = document.getElementById('MrForm');
        const pageLoader = document.getElementById('page_loader');
        const submitButton = document.getElementById('kt_docs_formvalidation_text_submit');
        // Declare Route untuk ke Edit MR
        const editMRRouteTemplate = "{{ route('EditMR', ['mr_no' => '__MR_NO__']) }}";

    
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
                    wo_no: {
                        validators: {
                            notEmpty: {
                                message: 'Work Order No is required'
                            }
                        }
                    },
                    wo_no: {
                        validators: {
                            notEmpty: {
                                message: 'Work Order No is required'
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
                                            // const encodedMRNo = btoa(response.mr_no);                                             
                                            // window.location.href = `${BASE_URL}/Material-Request/Edit/${encodedMRNo}`;
                                            const encodedMRNo = btoa(response.mr_no);
                                            const editMRUrl = editMRRouteTemplate.replace('__MR_NO__', encodedMRNo);
                                            window.location.href = editMRUrl;
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

    {{-- Script Untuk Ambil data WO --}}
    <script>
        $(document).ready(function () {
            const userId = `{{ auth()->user()->id }}`;
            const baseUrl = `{{ url('/') }}`;

            function showPageLoader() {
                $('#page_loader')
                    .css({
                        'position': 'fixed',
                        'top': '0',
                        'left': '0',
                        'width': '100%',
                        'height': '100%',
                        'z-index': '9999',
                        'background-color': 'rgba(0, 0, 0, 0.25)',
                        'display': 'flex',
                        'justify-content': 'center',
                        'align-items': 'center',
                        'flex-direction': 'column',
                    })
                    .fadeIn(300);
            }

            function hidePageLoader() {
                setTimeout(() => {
                    $('#page_loader').fadeOut(300);
                }, 1000);
            }

            $.ajax({
                url: "{{ route('getwodataformr') }}",
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
                    alert('Gagal mengambil data Case!');
                }
            });
    
            $('#reference_number').on('change', function () {
                let woNo = $(this).val();
                if (woNo) {
                    showPageLoader();
                    $.ajax({
                        url: "{{ route('getwodetailsformr') }}",
                        type: 'GET',
                        data: { wo_no: woNo }, 
                        success: function (data) {
                            $('#case_no').val(data.Case_No ?? '');
                            $('#case_name').val(data.Case_Name ?? '');
                            $('#created_by').val(data.created_by ?? '');
                            $('#department').val(data.department ?? '');
                        },
                        error: function () {
                            alert('Gagal mengambil detail WO!');
                        },
                        complete: function () {
                            hidePageLoader();
                        }
                    });
                }
            });

        });
    </script>
        
    {{-- Script Add Row Table --}}
    {{-- <script>
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
                        <i class="ki-duotone ki-trash fs-2 text-center text-white">
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
    
    </script> --}}

    {{-- <script>
    let uomOptionsHtml = '';

    // Fetch UOM once when the page loads
    async function fetchUOMOptions() {
        try {
            const response = await fetch('http://10.10.10.86:8088/erp_api/api/ifca/get/uom', {
                headers: {
                    'Accept': 'application/json'
                }
            });

            const data = await response.json();
            if (data.success && Array.isArray(data.data.uom)) {
                uomOptionsHtml = data.data.uom.map(uom => {
                    return `<option value="${uom.uom_cd}">${uom.uom_cd} - ${uom.descs}</option>`;
                }).join('');
            }
        } catch (error) {
            console.error('Failed to load UOM:', error);
        }
    }

    // Call it on page load
    fetchUOMOptions();

    // Update numbering and input name attributes
    function updateRowNumbers() {
        const rows = document.querySelectorAll('#material-body tr');
        rows.forEach((row, index) => {
            row.querySelector('td:first-child').textContent = index + 1;
            const inputs = row.querySelectorAll('input');
            const select = row.querySelector('select');
            if (inputs.length >= 4 && select) {
                inputs[0].setAttribute('name', `items[${index}][qty]`);
                select.setAttribute('name', `items[${index}][unit]`);
                inputs[1].setAttribute('name', `items[${index}][code]`);
                inputs[2].setAttribute('name', `items[${index}][name]`);
                inputs[3].setAttribute('name', `items[${index}][desc]`);
            }
        });
    }

    // Add Row Button
    document.getElementById('add-row').addEventListener('click', () => {
        const table = document.getElementById('material-body');
        const rowCount = table.querySelectorAll('tr').length;

        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td class="text-center">${rowCount + 1}</td>
            <td><input type="number" name="items[${rowCount}][qty]" class="form-control"></td>
            <td>
                <select name="items[${rowCount}][unit]" class="form-select select2-unit w-100" style="min-width: 150px;">
                    ${uomOptionsHtml}</select>
                <input type="hidden" name="items[${rowCount}][unit_cd]">
            </td>
            <td><input type="text" name="items[${rowCount}][code]" class="form-control"></td>
            <td><input type="text" name="items[${rowCount}][name]" class="form-control"></td>
            <td><input type="text" name="items[${rowCount}][desc]" class="form-control"></td>
            <td class="text-center text-white">
                <button type="button" class="btn btn-danger remove-row text-white">
                    <i class="ki-duotone ki-trash fs-2 text-white">
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

    // Remove Row
    document.addEventListener('click', function (e) {
        if (e.target.closest('.remove-row')) {
            e.target.closest('tr').remove();
            updateRowNumbers();
        }
    });
</script> --}}

<script>
    let uomOptionsHtml = '';

    // Ambil UOM saat halaman dimuat
    async function fetchUOMOptions() {
        try {
            const response = await fetch('http://10.10.10.86:8088/erp_api/api/ifca/get/uom', {
                headers: { 'Accept': 'application/json' }
            });

            const data = await response.json();
            if (data.success && Array.isArray(data.data.uom)) {
                uomOptionsHtml = data.data.uom.map(uom => {
                    return `<option value="${uom.descs}" data-code="${uom.uom_cd}">${uom.uom_cd} - ${uom.descs}</option>`;
                }).join('');
                initializeSelect2();
            }
        } catch (error) {
            console.error('Failed to load UOM:', error);
        }
    }

    fetchUOMOptions(); // Panggil saat load

    // Init select2 untuk elemen dengan .select2-unit
    function initializeSelect2() {
        document.querySelectorAll('.select2-unit').forEach(select => {
            if (!select.dataset.loaded) {
                select.innerHTML = '<option value="">Select Unit</option>' + uomOptionsHtml;
                $(select).select2({ placeholder: "Select Unit", allowClear: true, width: '100%' });
                select.dataset.loaded = true;
            }
        });
    }

    // Update nomor dan name input tiap baris
    function updateRowNumbers() {
        document.querySelectorAll('#material-body tr').forEach((row, index) => {
            row.querySelector('td:first-child').textContent = index + 1;
            row.querySelector('input[name$="[qty]"]').setAttribute('name', `items[${index}][qty]`);
            row.querySelector('select').setAttribute('name', `items[${index}][unit]`);
            row.querySelector('input[name$="[unit_cd]"]').setAttribute('name', `items[${index}][unit_cd]`);
            row.querySelector('input[name$="[code]"]').setAttribute('name', `items[${index}][code]`);
            row.querySelector('input[name$="[name]"]').setAttribute('name', `items[${index}][name]`);
            row.querySelector('input[name$="[desc]"]').setAttribute('name', `items[${index}][desc]`);
        });
    }

    // Tombol tambah row
    document.getElementById('add-row').addEventListener('click', () => {
        const tbody = document.getElementById('material-body');
        const rowCount = tbody.querySelectorAll('tr').length;

        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td class="text-center">${rowCount + 1}</td>
            <td><input type="number" name="items[${rowCount}][qty]" class="form-control" /></td>
            <td>
                <select name="items[${rowCount}][unit]" class="form-select select2-unit w-100" style="min-width:150px;"></select>
                <input type="hidden" name="items[${rowCount}][unit_cd]">
            </td>
            <td><input type="text" name="items[${rowCount}][code]" class="form-control" /></td>
            <td><input type="text" name="items[${rowCount}][name]" class="form-control" /></td>
            <td><input type="text" name="items[${rowCount}][desc]" class="form-control" /></td>
            <td class="text-center">
                <button type="button" class="btn btn-danger remove-row text-white">
                    <i class="ki-duotone ki-trash fs-2">
                        <span class="path1"></span><span class="path2"></span><span class="path3"></span>
                        <span class="path4"></span><span class="path5"></span>
                    </i>
                </button>
            </td>
        `;
        tbody.appendChild(newRow);
        updateRowNumbers();
        initializeSelect2();
    });

    // Tombol hapus row
    document.addEventListener('click', function (e) {
        if (e.target.closest('.remove-row')) {
            e.target.closest('tr').remove();
            updateRowNumbers();
        }
    });

    // Saat unit berubah, isi hidden input unit_cd
    document.addEventListener('change', function (e) {
        if (e.target.classList.contains('select2-unit')) {
            const selected = e.target.options[e.target.selectedIndex];
            const code = selected.dataset.code || '';
            const hiddenInput = e.target.parentElement.querySelector('input[type="hidden"]');
            hiddenInput.value = code;
        }
    });
</script>
