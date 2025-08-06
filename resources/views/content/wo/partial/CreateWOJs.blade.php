

    {{-- FlatPicker Date --}}
    <script>
        $("#start_date").flatpickr({
            enableTime: true,
            altInput: true,
            altFormat: "d/m/Y H:i", 
            dateFormat: "d/m/Y H:i",
            minDate: "today",
            defaultDate: new Date(), 
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

        $("#end_date").flatpickr({
            enableTime: true,
            altInput: true,
            altFormat: "d/m/Y H:i", 
            dateFormat: "d/m/Y H:i",
            minDate: "today",
            defaultDate: new Date(), 
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

        $(document).ready(function() {
            $('[data-control="select2"]').select2();
        });
    </script>

    {{-- Validation & Save Work Order--}}
    {{-- <script>
        $(function () {
            const form = document.getElementById('kt_docs_formvalidation_text');
            const submitButton = document.getElementById('kt_docs_formvalidation_text_submit');
    
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
    
            $("#kt_docs_formvalidation_text").on("submit", function (e) {
                e.preventDefault();
    
                validator.validate().then(function (status) {
                    const checkbox = document.getElementById('require_material_checkbox');
                    const intendedFor = document.getElementById('intended_for');

                    // Validasi tambahan: jika checkbox dicentang, dropdown harus tidak kosong
                    if (checkbox.checked && !intendedFor.value) {
                        Swal.fire({
                            icon: "warning",
                            title: "Incomplete Input",
                            text: "Please select a user in the 'Intended for' field.",
                            confirmButtonText: "OK",
                            customClass: {
                                confirmButton: "btn btn-warning"
                            }
                        });
                        return;
                    }
                    
                    if (status === 'Valid') {
                        const loadingEl = document.createElement("div");
                        loadingEl.classList.add("page-loader", "flex-column", "bg-dark", "bg-opacity-25");
                        loadingEl.innerHTML = `
                            <span class="spinner-border text-primary" role="status"></span>
                            <span class="text-white fs-6 fw-semibold mt-5">Loading...</span>
                        `;
                        document.body.prepend(loadingEl);
    
                        KTApp.showPageLoading();
    
                        let formData = new FormData(form);
                        submitButton.setAttribute('data-kt-indicator', 'on');
    
                        $.ajax({
                            url: "{{ route('SaveWO') }}", 
                            type: "POST",
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function (response) {
                                submitButton.removeAttribute('data-kt-indicator');
                                KTApp.hidePageLoading();
                                Swal.fire({
                                    icon: "success",
                                    title: "Success!",
                                    text: "Work Order has been saved successfully.",
                                    confirmButtonText: "OK",
                                    customClass: {
                                        confirmButton: "btn btn-primary"
                                    }
                                }).then(() => {
                                    let encodedWoNo = btoa(response.wo_no); 
                                    let url = "{{ route('EditWO', ['wo_no' => '__WONO__']) }}".replace('__WONO__', encodedWoNo);
                                    window.location.href = url;
                                });
                            },
                            error: function (xhr, status, error) {
                                submitButton.removeAttribute('data-kt-indicator');
                                KTApp.hidePageLoading();
                                Swal.fire({
                                    icon: "error",
                                    title: "Error!",
                                    text: "Something went wrong. Please try again.",
                                    confirmButtonText: "OK",
                                    customClass: {
                                        confirmButton: "btn btn-danger"
                                    }
                                });
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Validation Error",
                            text: "Please fill in all required fields.",
                            confirmButtonText: "OK",
                            customClass: {
                                confirmButton: "btn btn-danger"
                            }
                        });
                    }
                });
            });
        });
    </script> --}}
    <script>
        $(function () {
            const form = document.getElementById('kt_docs_formvalidation_text');
            const submitButton = document.getElementById('kt_docs_formvalidation_text_submit');

            if (!form || !submitButton) return;

            // === Dropzone Setup ===
            const id = "#kt_dropzonejs_example_3";
            const dropzone = document.querySelector(id);

            let myDropzone;

            if (dropzone) {
                Dropzone.autoDiscover = false;

                // Template setup
                let previewNode = dropzone.querySelector(".dropzone-item");
                previewNode.id = "";
                let previewTemplate = previewNode.parentNode.innerHTML;
                previewNode.parentNode.removeChild(previewNode);

                // Initialize Dropzone
                myDropzone = new Dropzone(id, {
                    url: "{{ route('SaveWO') }}",
                    autoProcessQueue: false,
                    maxFilesize: 2,
                    maxFiles: 1,
                    acceptedFiles: 'application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/pdf,image/jpeg',
                    previewTemplate: previewTemplate,
                    previewsContainer: id + " .dropzone-items",
                    clickable: id + " .dropzone-select",
                    addRemoveLinks: true,
                    dictDefaultMessage: 'Drop file here or click to upload.',
                    dictMaxFilesExceeded: 'Only 1 file is allowed.',
                    init: function () {
                        this.on("addedfile", function (file) {
                            if (this.files.length > 1) {
                                this.removeFile(this.files[0]);
                            }

                            const allowedTypes = [
                                'application/vnd.ms-excel',
                                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                                'application/pdf',
                                'image/jpeg'
                            ];

                            if (!allowedTypes.includes(file.type)) {
                                this.removeFile(file);
                                Swal.fire({
                                    icon: "warning",
                                    title: "Invalid File Type",
                                    text: "Only Excel, PDF, and JPEG files are allowed.",
                                    confirmButtonText: "OK",
                                    customClass: { confirmButton: "btn btn-warning" }
                                });
                            }

                            if (file.size > 2 * 1024 * 1024) {
                                this.removeFile(file);
                                Swal.fire({
                                    icon: "warning",
                                    title: "File Too Large",
                                    text: "Max file size is 2MB.",
                                    confirmButtonText: "OK",
                                    customClass: { confirmButton: "btn btn-warning" }
                                });
                            }

                            const items = dropzone.querySelectorAll('.dropzone-item');
                            items.forEach(item => item.style.display = '');
                        });
                    }
                });

                myDropzone.on("totaluploadprogress", function (progress) {
                    dropzone.querySelectorAll('.progress-bar').forEach(pb => pb.style.width = progress + "%");
                });

                myDropzone.on("sending", function () {
                    dropzone.querySelectorAll('.progress-bar').forEach(pb => pb.style.opacity = "1");
                });

                myDropzone.on("complete", function () {
                    setTimeout(() => {
                        dropzone.querySelectorAll('.dz-complete .progress-bar, .dz-complete .progress').forEach(el => el.style.opacity = "0");
                    }, 300);
                });
            }

            // === Form Validation Setup ===
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

            // === Submit Handler ===
            form.addEventListener("submit", function (e) {
                e.preventDefault();

                validator.validate().then(function (status) {
                    const checkbox = document.getElementById('require_material_checkbox');
                    const intendedFor = document.getElementById('intended_for');

                    if (checkbox.checked && !intendedFor.value) {
                        Swal.fire({
                            icon: "warning",
                            title: "Incomplete Input",
                            text: "Please select a user in the 'Intended for' field.",
                            confirmButtonText: "OK",
                            customClass: { confirmButton: "btn btn-warning" }
                        });
                        return;
                    }

                    if (status === 'Valid') {
                        const loadingEl = document.createElement("div");
                        loadingEl.classList.add("page-loader", "flex-column", "bg-dark", "bg-opacity-25");
                        loadingEl.innerHTML = `
                            <span class="spinner-border text-primary" role="status"></span>
                            <span class="text-white fs-6 fw-semibold mt-5">Loading...</span>
                        `;
                        document.body.prepend(loadingEl);
                        KTApp.showPageLoading();

                        let formData = new FormData(form);
                        submitButton.setAttribute('data-kt-indicator', 'on');

                        // Append file from Dropzone
                        if (myDropzone && myDropzone.files.length > 0) {
                            formData.append('wo_attachment', myDropzone.files[0]);
                        }

                        $.ajax({
                            url: "{{ route('SaveWO') }}",
                            type: "POST",
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function (response) {
                                submitButton.removeAttribute('data-kt-indicator');
                                KTApp.hidePageLoading();
                                Swal.fire({
                                    icon: "success",
                                    title: "Success!",
                                    text: "Work Order has been saved successfully.",
                                    confirmButtonText: "OK",
                                    customClass: { confirmButton: "btn btn-primary" }
                                }).then(() => {
                                    let encodedWoNo = btoa(response.wo_no);
                                    let url = "{{ route('EditWO', ['wo_no' => '__WONO__']) }}".replace('__WONO__', encodedWoNo);
                                    window.location.href = url;
                                });
                            },
                            error: function (xhr) {
                                submitButton.removeAttribute('data-kt-indicator');
                                KTApp.hidePageLoading();
                                Swal.fire({
                                    icon: "error",
                                    title: "Error!",
                                    text: xhr.responseJSON?.message || "Something went wrong. Please try again.",
                                    confirmButtonText: "OK",
                                    customClass: { confirmButton: "btn btn-danger" }
                                });
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Validation Error",
                            text: "Please fill in all required fields.",
                            confirmButtonText: "OK",
                            customClass: { confirmButton: "btn btn-danger" }
                        });
                    }
                });
            });
        });
    </script>




    
    {{-- Case No / Reference No --}}
    <script>
        $(document).ready(function () {

                function formatDate(dateStr) {
                    if (!dateStr) return "";

                    let date = new Date(dateStr);
                    let options = { day: "numeric", month: "long", year: "numeric" };
                    return date.toLocaleDateString("id-ID", options);
                }

                function centerPageLoader() {
                    const loader = $('#page_loader');
                    loader.css({
                        display: 'flex',
                        position: 'fixed',
                        top: 0,
                        left: 0,
                        width: '100%',
                        height: '100%',
                        background: 'dark',
                        'z-index': 9999,
                        'justify-content': 'center',
                        'align-items': 'center'
                    });
                }

                function showPageLoader() {
                    centerPageLoader();
                    $('#page_loader').fadeIn(100);
                }

                function hidePageLoader() {
                    $('#page_loader').fadeOut(200);
                }

                function loadCases() {
                    let select = $('#reference_number');
                    select.empty().append('<option>Loading...</option>');

                    $.ajax({
                        url: "{{ route('get.cases') }}",
                        type: "GET",
                        dataType: "json",
                        success: function (data) {
                            select.empty().append('<option></option>');

                            data.forEach(function (item) {
                                select.append(`
                                    <option value="${item.case_no}"
                                        data-created="${item.created_by}"
                                        data-department="${item.department}"
                                        data-date="${item.date}">
                                        ${item.case_no}
                                    </option>
                                `);
                            });
                        },
                        error: function (xhr) {
                            select.empty().append('<option>Error loading data</option>');
                            console.log("Error fetching cases: ", xhr);
                        }
                    });
                }

                loadCases();

                $('#reference_number').change(function () {
                    let selectedOption = $(this).find(':selected');

                    showPageLoader(); 

                    setTimeout(() => {
                        $('#created_by').val(selectedOption.data('created'));
                        $('#department').val(selectedOption.data('department'));
                        $('#date').val(formatDate(selectedOption.data('date')));

                        hidePageLoader(); 
                    }, 1000);
                });

                $('#reference_number').select2({
                    placeholder: "Select Reference",
                    allowClear: true
        });
    });

    </script>
    
    {{-- Assigned To (Teknisi) --}}
    <script>
        $(document).ready(function () {
             $('#assigned_to').select2({
            ajax: {
                url: "{{ route('GetTechnician') }}",
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {
                        results: data 
                    };
                },
                cache: true
            },
            placeholder: 'Select technician(s)',
            minimumInputLength: 0,
            allowClear: true
        });
            
        });
    </script>
  
    {{-- View Details Case --}}
    <script>
        $(document).ready(function () {
            $('#btnViewDetails').on('click', function () {
                let caseNo = $('#reference_number').val();

                if (!caseNo) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Please select a Case No first.',
                        text: 'You need to select a Case No before proceeding.',
                        confirmButtonText: 'OK',
                        willClose: () => {
                            window.location.href = `${BASE_URL}/Work-Order/Create`;  
                        }
                    });
                    return;
                }

                let caseNoEncoded = btoa(unescape(encodeURIComponent(caseNo))); 
                let url = BASE_URL + '/case-details/' + caseNoEncoded;
                $.ajax({
                    url: url,
                    // url: 'case-details/' + encodeURIComponent(caseNo),
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        $('#modal_case_no').text(data.Case_No);
                        $('#modal_case_name').text(data.Case_Name);
                        $('#modal_case_date').text(data.Case_Date);
                        $('#modal_category').text(data.Category);
                        $('#modal_subcategory').text(data.SubCategory);
                        $('#modal_created_by').text(data.Created_By);
                        $('#modal_department').text(data.Departement);
                        $('#modal_chronology').val(data.Case_Chronology ?? 'N/A');
                        $('#modal_outcome').val(data.Case_Outcome ?? 'N/A');
                        $('#modal_suggest').val(data.Case_Suggest ?? 'N/A');
                        $('#modal_action').val(data.Case_Action ?? 'N/A');

                        let badgeClass = 'bg-secondary';
                        switch (data.Case_Status) {
                            case 'OPEN': badgeClass = 'bg-light-primary'; break;
                            case 'SUBMIT': badgeClass = 'bg-light-info'; break;
                            case 'CLOSE': badgeClass = 'bg-light-success'; break;
                            case 'REJECT': badgeClass = 'bg-light-danger'; break;
                        }
                        $('#modal_status')
                            .removeClass()
                            .addClass('badge ' + badgeClass)
                            .text(data.Case_Status);

                        let approvalRows = '';
                        data.Approval_Status.forEach(function (item) {
                            let statusClass = 'bg-warning';
                            if (item.status === 'Approved') statusClass = 'bg-success text-white';
                            else if (item.status === 'Rejected') statusClass = 'bg-danger';

                            approvalRows += `
                                <tr>
                                    <td>${item.approver}</td>
                                    <td>${item.remark}</td>
                                    <td><span class="badge ${statusClass}">${item.status}</span></td>
                                </tr>
                            `;
                        });
                        $('#approval_status_table tbody').html(approvalRows);

                        let imageGallery = '';
                        if (data.Images && data.Images.length > 0) {
                            imageGallery = '<div class="d-flex flex-wrap justify-content-start">'; 

                            data.Images.forEach(function (image) {
                                let imageUrl = "{{ asset('storage/case_photos') }}/" + image.IMG_RefNo.replace(/\//g, '-') + "/" + image.IMG_Filename;

                                imageGallery += `
                                    <div class="col-md-3 col-sm-4 col-6 mb-3">
                                        <a href="#" class="image-thumbnail" data-bs-toggle="modal" data-bs-target="#imageModal" data-img="${imageUrl}">
                                            <img src="${imageUrl}" alt="${image.IMG_Realname}" class="img-thumbnail rounded shadow-sm" style="width: 100%; height: 150px; object-fit: cover;">
                                        </a>
                                        <p class="text-center small mt-1">${image.IMG_Realname}</p>
                                    </div>
                                `;
                            });

                            imageGallery += '</div>';
                        } else {
                            imageGallery = '<p class="text-muted">No photos available for this case.</p>';
                        }

                        $('#case_photos').html(imageGallery);

                        $(document).on('click', '.image-thumbnail', function (e) {
                            e.preventDefault();
                            var imgSrc = $(this).attr('data-img');
                            $('#modal-image').attr('src', imgSrc);
                        });

                        $('#caseDetailsModal').modal('show');
                    },
                    error: function () {
                        $('#caseDetailsModal .modal-body').html('<p class="text-danger">Failed to load case details.</p>');
                        $('#caseDetailsModal').modal('show');
                    }
                });
            });
        });
    </script>


    {{-- Form Ditunjukan untuk --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const checkbox = document.getElementById('require_material_checkbox');
            const loader = document.getElementById('material_loader');
            const intendedForSection = document.getElementById('intended_for_section');
            const intendedForSelect = document.getElementById('intended_for');
            const woAttachmentSection = document.getElementById('wo_attachment_section');

            checkbox.addEventListener('change', function () {
                if (this.checked) {
                    loader.classList.remove('d-none');
                    loader.classList.add('d-flex');

                    setTimeout(() => {
                        fetch("{{ route('get.intended.users') }}")
                            .then(response => response.json())
                            .then(data => {
                                intendedForSelect.innerHTML = '<option value="">Choose User</option>';
                                
                                data.forEach(user => {
                                    const option = document.createElement('option');
                                    option.value = user.id;
                                    option.textContent = user.Fullname;
                                    intendedForSelect.appendChild(option);
                                });

                                loader.classList.add('d-none');
                                loader.classList.remove('d-flex');
                                intendedForSection.classList.remove('d-none');
                                woAttachmentSection.classList.remove('d-none');
                            });
                    }, 1000);
                } else {
                    intendedForSection.classList.add('d-none');
                    intendedForSelect.innerHTML = '<option value="">Choose User</option>';
                    woAttachmentSection.classList.add('d-none');
                }
            });
        });
    </script>




