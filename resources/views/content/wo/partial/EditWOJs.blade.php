<link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css"/>
<script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>

    {{-- Script Date  --}}
    <script>
        $("#start_date").flatpickr({
            enableTime: true,
            altInput: true,
            altFormat: "d/m/Y H:i", 
            dateFormat: "d/m/Y H:i",
            minDate: "today",
        });

        $("#end_date").flatpickr({
            enableTime: true,
            altInput: true,
            altFormat: "d/m/Y H:i", 
            dateFormat: "d/m/Y H:i",
            minDate: "today",
        });

        $(document).ready(function() {
            $('[data-control="select2"]').select2();
        });
    </script>

    @php
        $currentUserId = auth()->user()->id;
        $userPermissions = auth()->user()->getAllPermissions()->pluck('name')->toArray();
    @endphp

    <script>
        const currentUserId = {{ $currentUserId }};
        const userPermissions = @json($userPermissions);
        const woMRUserId = {{ $wo->WO_MR ?? 'null' }}; 
    </script>

    {{-- Script Validation dan Update WO --}}
    <script>
    $(document).ready(function () {
        const form = $('#kt_docs_formvalidation_text');
        const btnEdit = $('#btnEditWO');
        const btnSave = $('#kt_docs_formvalidation_text_save');
        const btnSubmit = $('#kt_docs_formvalidation_text_submit');

        const requiredFields = [
            { selector: '#reference_number', message: 'Reference Number is required' },
            { selector: '#start_date', message: 'Start Date is required' },
            { selector: '#end_date', message: 'End Date is required' },
            { selector: 'textarea[name="work_description"]', message: 'Work Description is required' }
        ];

        // Initial State
        form.find('input, textarea, select').not('.exclude-disable, [type="hidden"], .readonly-select, .readonly-checkbox').prop('disabled', true);

        // Simulasikan readonly untuk select
        form.find('.readonly-select').each(function () {
            $(this).on('mousedown', function (e) {
                e.preventDefault(); 
                this.blur();       
            }).addClass('select-readonly');
        });

        form.find('.readonly-checkbox').each(function () {
            $(this).on('click.readonly', function (e) {
                e.preventDefault();
                return false;
            }).addClass('checkbox-readonly');
        });

        btnSave.addClass('d-none');
        btnEdit.removeClass('d-none');
        btnSubmit.removeClass('d-none');

        // ===== HANDLE EDIT CASE =====
        btnEdit.on('click', function () {
            let isEmpty = false;

            form.find('.invalid-feedback').remove();
            form.find('.is-invalid').removeClass('is-invalid');

            requiredFields.forEach(field => {
                const input = $(field.selector);
                const container = input.closest('.fv-row');
                if (!input.val()) {
                    isEmpty = true;
                    input.addClass('is-invalid');
                    if (container.find('.invalid-feedback').length === 0) {
                        container.append(`<div class="invalid-feedback d-block">${field.message}</div>`);
                    }
                }
            });

            if (isEmpty) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Warning!',
                    text: 'There are required fields that are still empty. Please complete them before editing.',
                    confirmButtonText: 'OK'
                });
                return;
            }

            const loadingEl = document.createElement("div");
            loadingEl.classList.add("page-loader", "flex-column", "bg-dark", "bg-opacity-25", "position-fixed", "w-100", "h-100", "top-0", "start-0", "d-flex", "justify-content-center", "align-items-center");
            loadingEl.innerHTML = `
                <span class="spinner-border text-primary" role="status"></span>
                <span class="text-gray-800 fs-6 fw-semibold mt-5">Loading...</span>
            `;
            document.body.prepend(loadingEl);

            setTimeout(() => {
                loadingEl.remove();
                form.find('input, textarea, select').not('.exclude-disable, [type="hidden"]').prop('disabled', false);
                form.find('.readonly-select').off('mousedown').removeClass('select-readonly');
                form.find('.readonly-checkbox').off('click.readonly').removeClass('checkbox-readonly');

                btnSave.removeClass('d-none');
                btnEdit.addClass('d-none');
                btnSubmit.addClass('d-none');
            }, 800);
        });

        // ===== HANDLE SAVE CASE =====
        btnSave.on('click', function (e) {
            e.preventDefault();
            handleSaveWO($(this));
        });

        // ===== HANDLE SUBMIT CASE =====
        btnSubmit.on('click', function (e) {
            e.preventDefault();

            Swal.fire({
                title: 'Submit Work Order?',
                text: "Make sure all information is correct before submitting this Work Order.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, Submit WO',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    submitWorkOrder();
                } else if (result.isDenied) {
                    handleSaveWO(btnSave);
                }
            });
        });

        // ====== SAVE WO FUNCTION ======
        function handleSaveWO($btn) {
        $btn.attr("data-kt-indicator", "on");
        $btn.prop("disabled", true);

        let isValid = true;

        // Reset error state
        form.find('.invalid-feedback').remove();
        form.find('.is-invalid').removeClass('is-invalid');

        requiredFields.forEach(field => {
            const input = $(field.selector);
            const container = input.closest('.fv-row');
            if (!input.val()) {
                isValid = false;
                input.addClass('is-invalid');
                if (container.find('.invalid-feedback').length === 0) {
                    container.append(`<div class="invalid-feedback d-block">${field.message}</div>`);
                }
            }
        });

        if (!isValid) {
            Swal.fire({
                icon: 'warning',
                title: 'Validation Error!',
                text: 'Please complete all required fields before saving.',
                confirmButtonText: 'OK'
            });
            $btn.removeAttr("data-kt-indicator");
            $btn.prop("disabled", false);
            return;
        }

        // Konfirmasi sebelum menyimpan
        Swal.fire({
            title: 'Save Work Order?',
            text: "Are you sure you want to save the changes?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, Save',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loader
                const loadingEl = document.createElement("div");
                loadingEl.classList.add("page-loader", "flex-column", "bg-dark", "bg-opacity-25", "position-fixed", "w-100", "h-100", "top-0", "start-0", "d-flex", "justify-content-center", "align-items-center");
                loadingEl.innerHTML = `
                    <span class="spinner-border text-primary" role="status"></span>
                    <span class="text-gray-800 fs-6 fw-semibold mt-5">Saving...</span>
                `;
                document.body.prepend(loadingEl);

                setTimeout(() => {
                    $.ajax({
                        url: "{{ route('WorkOrder.SaveDraft') }}",
                        type: "POST",
                        data: form.serialize(),
                        success: function (response) {
                            loadingEl.remove();

                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Saved!',
                                    text: response.message,
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    location.reload(); 
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Failed!',
                                    text: response.message
                                });
                                $btn.removeAttr("data-kt-indicator");
                                $btn.prop("disabled", false);
                            }
                        },
                        error: function (xhr) {
                            loadingEl.remove();
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: xhr.responseJSON?.message || 'Something went wrong.'
                            });
                            $btn.removeAttr("data-kt-indicator");
                            $btn.prop("disabled", false);
                        }
                    });
                }, 500);
            } else {
                $btn.removeAttr("data-kt-indicator");
                $btn.prop("disabled", false);
            }
        });
    }

        // ====== SUBMIT WO FUNCTION ======
        function submitWorkOrder() {
            const $btn = btnSubmit;
            $btn.attr("data-kt-indicator", "on");
            $btn.prop("disabled", true);

            const loadingEl = document.createElement("div");
            loadingEl.classList.add("page-loader", "flex-column", "bg-dark", "bg-opacity-25", "position-fixed", "w-100", "h-100", "top-0", "start-0", "d-flex", "justify-content-center", "align-items-center");
            loadingEl.innerHTML = `
                <span class="spinner-border text-primary" role="status"></span>
                <span class="text-gray-800 fs-6 fw-semibold mt-5">Submitting...</span>
            `;
            document.body.prepend(loadingEl);
            KTApp.showPageLoading();

            setTimeout(() => {
                $.ajax({
                    url: "{{ route('WorkOrder.Update') }}",
                    type: "POST",
                    data: form.serialize(),
                    success: function (response) {
                        KTApp.hidePageLoading();
                        loadingEl.remove();

                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: response.message
                            }).then(() => {
                                const isChecked = $('#require_material_checkbox').is(':checked');

                                const hasMRPermission = userPermissions.includes('view mr') && userPermissions.includes('create mr');

                                let redirectUrl;

                                if (isChecked) {
                                    if (!hasMRPermission) {
                                        redirectUrl = "{{ route('ListWO') }}";
                                    } else {
                                        if (woMRUserId === currentUserId) {
                                            redirectUrl = "{{ route('CreateMR') }}";
                                        } else {
                                            redirectUrl = "{{ route('ListWO') }}";
                                        }
                                    }
                                } else {
                                    redirectUrl = "{{ route('ListWO') }}";
                                }

                                window.location.href = redirectUrl;
                            });

                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Failed!',
                                text: response.message
                            });
                            $btn.removeAttr("data-kt-indicator");
                            $btn.prop("disabled", false);
                        }
                    },
                    error: function (xhr) {
                        KTApp.hidePageLoading();
                        loadingEl.remove();

                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: xhr.responseJSON?.message || 'Something went wrong.'
                        });

                        $btn.removeAttr("data-kt-indicator");
                        $btn.prop("disabled", false);
                    }
                });
            }, 600);
        }
    });
    </script>

    {{-- Checkbox Ditujukan Oleh --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const checkbox = document.getElementById('require_material_checkbox');
            const loader = document.getElementById('material_loader');
            const intendedForSection = document.getElementById('intended_for_section');

            checkbox.addEventListener('change', function () {
                loader.classList.remove('d-none');
                loader.classList.add('d-flex');

                setTimeout(() => {
                    loader.classList.add('d-none');
                    loader.classList.remove('d-flex');

                    if (checkbox.checked) {
                        intendedForSection.classList.remove('d-none');
                    } else {
                        intendedForSection.classList.add('d-none');
                    }
                }, 1000);
            });
        });
    </script>

    {{-- Hapus Teknisi yang sudah dipipilih/Tersimpan didatabase --}}
    <script>
        $(document).ready(function () {
            const wo_no = "{{ $wo->WO_No }}";

            $('select[name="assigned_to[]"]').on('select2:unselect', function (e) {
                const technician_id = e.params.data.id;
                const technician_name = e.params.data.text;

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
                        // Tampilkan loader
                        $(".page-loader").fadeIn();

                        // Delay 1 detik sebelum kirim AJAX
                        setTimeout(function () {
                            $.ajax({
                                url: "{{ route('work-order.remove-technician') }}",
                                method: "POST",
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    wo_no: wo_no,
                                    technician_id: technician_id
                                },
                                success: function(response) {
                                    Swal.fire('Removed!', 'Technician has been removed.', 'success');
                                },
                                error: function(xhr) {
                                    console.error('Error removing technician:', xhr.responseText);
                                    Swal.fire('Error', 'Failed to remove technician from database.', 'error');
                                },
                                complete: function () {
                                    $(".page-loader").fadeOut();
                                }
                            });
                        }, 800);
                    } else {
                        const $select = $('select[name="assigned_to[]"]');
                        const option = new Option(technician_name, technician_id, true, true);
                        $select.append(option).trigger('change');
                    }
                });
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
                
                const caseDetailsRoute = @json(route('case.details', ['caseNo' => 'PLACEHOLDER']));
                let caseNoEncoded = btoa(unescape(encodeURIComponent(caseNo)));
                let url = caseDetailsRoute.replace('PLACEHOLDER', caseNoEncoded);
                // let caseNoEncoded = btoa(unescape(encodeURIComponent(caseNo))); 
                // let url = BASE_URL + '/case-details/' + caseNoEncoded;
                $.ajax({
                    url: url,
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

