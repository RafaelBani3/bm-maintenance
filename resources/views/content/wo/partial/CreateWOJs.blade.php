<link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css"/>
<script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>


{{-- FlatPicker Date --}}
<script>
    $("#start_date").flatpickr();

    $("#end_date").flatpickr();

    $(document).ready(function() {
        $('[data-control="select2"]').select2();
    });
</script>


{{-- Validation & Save Work Order--}}
{{-- <script>
    $(function () {
        const form = document.getElementById('kt_docs_formvalidation_text');
        const submitButton = document.getElementById('kt_docs_formvalidation_text_submit');
        const pageLoader = $("#page-loader");

        if (!form || !submitButton) return;

        let validator = FormValidation.formValidation(form, {
            fields: {
                'reference_number': { validators: { notEmpty: { message: 'Reference No. is required' } } },
                'start_date': { validators: { notEmpty: { message: 'Start Date is required' } } },
                'end_date': { validators: { notEmpty: { message: 'End Date is required' } } },
                'work_completion': { validators: { notEmpty: { message: 'Work Completion is required' } } },
                'work_status': { validators: { notEmpty: { message: 'Work Status is required' } } },
                'assigned_to': { validators: { notEmpty: { message: 'Assigned To is required' } } },
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

        $("#kt_docs_formvalidation_text").on("submit", function (e) {
            e.preventDefault();

            validator.validate().then(function (status) {
                if (status === 'Valid') {
                    pageLoader.fadeIn();

                    setTimeout(() => {
                        let formData = new FormData(form);

                        submitButton.setAttribute('data-kt-indicator', 'on');
                        submitButton.disabled = true;

                        $.ajax({
                            url: "{{ route('SaveWO') }}", 
                            type: "POST",
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function (response) {
                                submitButton.removeAttribute('data-kt-indicator');
                                submitButton.disabled = false;
                                pageLoader.fadeOut();

                                if (response.success) {
                                    Swal.fire({
                                        title: 'Success!',
                                        text: response.message,
                                        icon: 'success',
                                        confirmButtonText: 'OK'
                                    }).then(() => {
                                        window.location.href = "/Work-Order/Edit"; 
                                    });

                                } else {
                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'Failed',
                                        text: response.message || 'Failed to submit Work Order.'
                                    });
                                }
                            },

                            error: function (xhr) {
                                submitButton.removeAttribute('data-kt-indicator');
                                submitButton.disabled = false;
                                pageLoader.fadeOut();

                                let errorMessage = xhr.responseJSON?.message || 'An error occurred. Please try again.';
                                Swal.fire({ icon: 'error', title: 'Error', text: errorMessage });
                            }
                        });
                    }, 3000); 
                } else {
                    Swal.fire({
                        text: "Please fill in all required fields correctly.",
                        icon: "warning",
                        confirmButtonText: "OK"
                    });
                }
            });
        });

        $('.form-control, .form-select').on('input change', function () {
            $(this).removeClass('is-invalid');
            $('#error-' + $(this).attr('id')).text('');
        });
    });
</script> --}}

<script>
    $(function () {
        const form = document.getElementById('kt_docs_formvalidation_text');
        const submitButton = document.getElementById('kt_docs_formvalidation_text_submit');

        if (!form || !submitButton) return;

        let validator = FormValidation.formValidation(form, {
            fields: {
                'reference_number': { validators: { notEmpty: { message: 'Reference No. is required' } } },
                'start_date': { validators: { notEmpty: { message: 'Start Date is required' } } },
                'end_date': { validators: { notEmpty: { message: 'End Date is required' } } },
                'work_completion': { validators: { notEmpty: { message: 'Work Completion is required' } } },
                'work_status': { validators: { notEmpty: { message: 'Work Status is required' } } },
                'assigned_to': { validators: { notEmpty: { message: 'Assigned To is required' } } },
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

        $("#kt_docs_formvalidation_text").on("submit", function (e) {
            e.preventDefault();

            validator.validate().then(function (status) {
                if (status === 'Valid') {
                    const loadingEl = document.createElement("div");
                    loadingEl.classList.add("page-loader", "flex-column", "bg-dark", "bg-opacity-25");
                    loadingEl.innerHTML = `
                        <span class="spinner-border text-primary" role="status"></span>
                        <span class="text-gray-800 fs-6 fw-semibold mt-5">Loading...</span>
                    `;
                    document.body.prepend(loadingEl);

                    KTApp.showPageLoading();

                    setTimeout(() => {
                        let formData = new FormData(form);

                        submitButton.setAttribute('data-kt-indicator', 'on');
                        submitButton.disabled = true;

                        $.ajax({
                            url: "{{ route('SaveWO') }}",
                            type: "POST",
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function (response) {
                                submitButton.removeAttribute('data-kt-indicator');
                                submitButton.disabled = false;

                                KTApp.hidePageLoading();
                                loadingEl.remove();

                                if (response.success) {
                                    Swal.fire({
                                        title: 'Success!',
                                        text: response.message,
                                        icon: 'success',
                                        confirmButtonText: 'OK'
                                    }).then(() => {
                                        window.location.href = "/Work-Order/Edit";
                                    });

                                } else {
                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'Failed',
                                        text: response.message || 'Failed to submit Work Order.'
                                    });
                                }
                            },

                            error: function (xhr) {
                                submitButton.removeAttribute('data-kt-indicator');
                                submitButton.disabled = false;

                                // Sembunyikan loader
                                KTApp.hidePageLoading();
                                loadingEl.remove();

                                let errorMessage = xhr.responseJSON?.message || 'An error occurred. Please try again.';
                                Swal.fire({ icon: 'error', title: 'Error', text: errorMessage });
                            }
                        });
                    }, 3000); 
                } else {
                    Swal.fire({
                        text: "Please fill in all required fields correctly.",
                        icon: "warning",
                        confirmButtonText: "OK"
                    });
                }
            });
        });

        $('.form-control, .form-select').on('input change', function () {
            $(this).removeClass('is-invalid');
            $('#error-' + $(this).attr('id')).text('');
        });
    });
</script>


{{-- Case No / Reference No --}}
<script>
    $(document).ready(function () {
        function showPageLoader() {
            const loadingEl = document.createElement("div");
            loadingEl.classList.add("page-loader", "flex-column", "bg-dark", "bg-opacity-25");
            loadingEl.innerHTML = `
                <span class="spinner-border text-primary" role="status"></span>
                <span class="text-muted fs-6 fw-semibold mt-5">Loading...</span>
            `;
            document.body.prepend(loadingEl);

            if (typeof KTApp !== "undefined") {
                KTApp.showPageLoading();
            }

            return loadingEl;
        }

        function hidePageLoader(loader) {
            setTimeout(() => {
                if (typeof KTApp !== "undefined") {
                    KTApp.hidePageLoading();
                }
                if (loader) loader.remove();
            }, 300);
        }

        function formatDate(dateStr) {
            if (!dateStr) return "";

            let date = new Date(dateStr);
            let options = { day: "numeric", month: "long", year: "numeric" };
            return date.toLocaleDateString("id-ID", options);
        }

        function loadCases() {
            let loader = showPageLoader();

            $.ajax({
                url: "{{ route('get.cases') }}",
                type: "GET",
                dataType: "json",
                success: function (data) {
                    let select = $('#reference_number');
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

                    hidePageLoader(loader);
                },
                error: function (xhr) {
                    console.log("Error fetching cases: ", xhr);
                    hidePageLoader(loader);
                }
            });
        }

        loadCases();

        $('#reference_number').change(function () {
            let selectedOption = $(this).find(':selected');
            let loader = showPageLoader();

            setTimeout(() => {
                $('#created_by').val(selectedOption.data('created'));
                $('#department').val(selectedOption.data('department'));
                $('#date').val(formatDate(selectedOption.data('date')));

                hidePageLoader(loader);
            }, 500);
        });

        $('#reference_number').select2({
            placeholder: "Select Reference",
            allowClear: true
        });
    });
</script>

{{-- Tampilan Start & End Date --}}
{{-- <script>
    $(document).ready(function () {
        $('#btnViewDetails').on('click', function () {
            let caseNo = $('#reference_number').val();

            if (!caseNo) {
                alert('Please select a Case No first.');
                return;
            }

            $.ajax({
                url: '/case-details/' + encodeURIComponent(caseNo),
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    $('#modal_case_no').text(data.Case_No);
                    $('#modal_case_name').text(data.Case_Name);
                    $('#modal_case_date').text(data.Case_Date);
                    $('#modal_chronology').text(data.Case_Chronology);
                    $('#modal_outcome').text(data.Case_Outcome);
                    $('#modal_suggest').text(data.Case_Suggest);
                    $('#modal_action').text(data.Case_Action);
                    $('#modal_status').text(data.Case_Status);
                    $('#modal_location').text(data.Location);
                },
                error: function () {
                    $('#caseDetailsModal .modal-body').html('<p class="text-danger">Failed to load case details.</p>');
                }
            });
        });
    });
</script> --}}

{{-- <script>
    $(document).ready(function () {
        $('#btnViewDetails').on('click', function () {
            let caseNo = $('#reference_number').val();

            if (!caseNo) {
                alert('Please select a Case No first.');
                return;
            }

            $.ajax({
                url: '/case-details/' + encodeURIComponent(caseNo),
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    $('#modal_case_no').text(data.Case_No);
                    $('#modal_case_name').text(data.Case_Name);
                    $('#modal_case_date').text(data.Case_Date);
                    $('#modal_chronology').val(data.Case_Chronology ?? 'N/A');
                    $('#modal_outcome').val(data.Case_Outcome ?? 'N/A');
                    $('#modal_suggest').val(data.Case_Suggest ?? 'N/A');
                    $('#modal_action').val(data.Case_Action ?? 'N/A');

                    // Set Badge Status with Class
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

                    // Show the modal
                    $('#caseDetailsModal').modal('show');
                },
                error: function () {
                    $('#caseDetailsModal .modal-body').html('<p class="text-danger">Failed to load case details.</p>');
                    $('#caseDetailsModal').modal('show');
                }
            });
        });
    });
</script> --}}

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
                        window.location.href = '/Work-Order/Create';  
                    }
                });
                return;
            }

            $.ajax({
                url: '/case-details/' + encodeURIComponent(caseNo),
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    // Set Case Details
                    $('#modal_case_no').text(data.Case_No);
                    $('#modal_case_name').text(data.Case_Name);
                    $('#modal_case_date').text(data.Case_Date);
                    $('#modal_category').text(data.Category);
                    $('#modal_subcategory').text(data.SubCategory);
                    $('#modal_created_by').text(data.Created_By);
                    $('#modal_department').text(data.Department);
                    $('#modal_chronology').val(data.Case_Chronology ?? 'N/A');
                    $('#modal_outcome').val(data.Case_Outcome ?? 'N/A');
                    $('#modal_suggest').val(data.Case_Suggest ?? 'N/A');
                    $('#modal_action').val(data.Case_Action ?? 'N/A');

                    // Set Case Status with Badge
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

                    // Set Approval Status Table
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

                    // Set Image Gallery
                    let imageGallery = '';
                    if (data.Images && data.Images.length > 0) {
                        imageGallery = '<div class="d-flex flex-wrap justify-content-start">'; // Mulai flex container

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

                        imageGallery += '</div>'; // Tutup flex container
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
