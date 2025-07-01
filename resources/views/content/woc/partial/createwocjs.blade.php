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
            // Flatpickr untuk tanggal mulai dan selesai
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

            // Route Laravel
            const routeGetWoDataforWOC = "{{ route('GetWoDataforWOC') }}";
            const routeGetWoDetail = "{{ route('GetWoDetail', ['encoded' => 'ENCODED_PLACEHOLDER']) }}";
            const routeRemoveTechnician = "{{ route('work-order.remove-technician') }}";

            // Load daftar WO ke select Reference
            $.ajax({
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

            // Saat Reference No dipilih
            $('#reference_number').on('change', function () {
                const encoded = $(this).val();
                if (!encoded) return;

                const ajaxUrl = routeGetWoDetail.replace('ENCODED_PLACEHOLDER', encoded);
                const select = $('#assigned_to');

                $.ajax({
                    url: ajaxUrl,
                    type: 'GET',
                    success: function (data) {
                        // Isi form WO
                        $('#case_no').val(data.Case_No);
                        $('#case_name').val(data.Case_Name);
                        $('#work_order_date').val(data.CR_DT);
                        $('#created_by').val(data.Created_By);
                        $('#position').val(data.Position);
                        $('#work_description').val(data.WO_Narative);

                        startPicker.setDate(data.WO_Start, true, "Y-m-d H:i:S");
                        endPicker.setDate(data.WO_End, true, "Y-m-d H:i:S");

                        $.ajax({
                            url: "{{ route('GetTechnician') }}",
                            type: "GET",
                            success: function (technicians) {
                                const select = $('#assigned_to');
                                select.empty(); 

                                technicians.forEach(group => {
                                    const optgroup = $('<optgroup>').attr('label', group.text);

                                    group.children.forEach(tech => {
                                        optgroup.append(`<option value="${tech.id}">${tech.text}</option>`);
                                    });

                                    select.append(optgroup);
                                });

                                const selectedIds = data.Assigned_To.map(t => t.id);
                                select.val(selectedIds).trigger('change');
                            },
                            error: function (xhr) {
                                console.error("Gagal mengambil data teknisi:", xhr.responseText);
                            }
                        });

                    },
                    error: function (xhr) {
                        console.error("Failed to get WO Detail:", xhr);
                    }
                });
            });

            $('#assigned_to').on('select2:unselect', function (e) {
                const technician_id = e.params.data.id;
                const technician_name = e.params.data.text;
                const encoded_wo_no = $('#reference_number').val();

                if (!encoded_wo_no) return;

                const wo_no = decodeURIComponent(escape(atob(encoded_wo_no)));

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
                        $(".page-loader").fadeIn();

                        setTimeout(() => {
                            $.ajax({
                                url: routeRemoveTechnician,
                                method: "POST",
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    wo_no: wo_no,
                                    technician_id: technician_id
                                },
                                success: function (response) {
                                    Swal.fire('Removed!', 'Technician has been removed.', 'success');
                                },
                                error: function (xhr) {
                                    console.error('Error removing technician:', xhr.responseText);
                                    Swal.fire('Error', 'Failed to remove technician from database.', 'error');

                                    const $select = $('#assigned_to');
                                    const option = new Option(technician_name, technician_id, true, true);
                                    $select.append(option).trigger('change');
                                },
                                complete: function () {
                                    $(".page-loader").fadeOut();
                                }
                            });
                        }, 800);
                    } else {
                        // Batal, tambahkan kembali teknisi ke select
                        const $select = $('#assigned_to');
                        const option = new Option(technician_name, technician_id, true, true);
                        $select.append(option).trigger('change');
                    }
                });
            });
        });
    </script>

    {{-- Script validate dan save WOC --}}
    <script>
        // Declare Route Name
        const editWocUrlTemplate = @json(route('EditWOC', ['wo_no' => 'ENCODED_PLACEHOLDER']));

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
                                        // let baseUrl = window.location.origin + "/BmMaintenance/public";
                                        // window.location.href = baseUrl + "/WorkOrder-Complition/Edit/" + encodedWoNo;
                                        let redirectUrl = editWocUrlTemplate.replace('ENCODED_PLACEHOLDER', encodedWoNo);
                                        window.location.href = redirectUrl;
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
