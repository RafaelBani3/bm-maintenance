<link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css"/>
<script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>

   {{-- Script Date  --}}
    <script>
        $("#start_date").flatpickr({
            altInput: true,
            altFormat: "d/m/Y",
            dateFormat: "Y-m-d",
        });

        $("#end_date").flatpickr({
            altInput: true,
            altFormat: "d/m/Y",
            dateFormat: "Y-m-d",
        });
    </script>

    {{-- Script Validation dan Update WO --}}
    <script>
<<<<<<< HEAD
        $(document).ready(function () {
            $('#kt_docs_formvalidation_text').on('submit', function (e) {
                e.preventDefault();

                let isValid = true;
                const requiredFields = ['#reference_number', '#start_date', '#end_date', 'textarea[name="work_description"]'];

                requiredFields.forEach(function (selector) {
                    if (!$(selector).val()) {
                        isValid = false;
                        $(selector).addClass('is-invalid');
                    } else {
                        $(selector).removeClass('is-invalid');
                    }
                });

                if (!isValid) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Please fill all required fields.'
                    });
                    return;
                }

                const loadingEl = document.createElement("div");
                document.body.prepend(loadingEl);
                loadingEl.classList.add("page-loader", "flex-column", "bg-dark", "bg-opacity-25");
                loadingEl.innerHTML = `
                        <span class="spinner-border text-primary" role="status"></span>
                        <span class="text-gray-800 fs-6 fw-semibold mt-5">Loading...</span>
                    `;

                KTApp.showPageLoading();

                setTimeout(() => {
                    $.ajax({
                        url: "{{ route('WorkOrder.Update') }}",
                        type: "POST",
                        data: $(this).serialize(),
                        success: function (response) {
                            KTApp.hidePageLoading();  
                            loadingEl.remove();
                            
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success!',
                                    text: response.message
                                }).then(() => {
                                    window.location.href = `${BASE_URL}/Work-Order/Create`;  
                                    // window.location.href = "/Work-Order/Create";
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Failed!',
                                    text: response.message
                                });
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
                        }
                    });
                }, 500); 
            });
        });
    </script>
=======
    $(document).ready(function () {
        $('#kt_docs_formvalidation_text_submit').on('click', function (e) {
            e.preventDefault();

            const $btn = $(this);
            $btn.attr("data-kt-indicator", "on"); 
            $btn.prop("disabled", true); 

            let isValid = true;
            const requiredFields = ['#reference_number', '#start_date', '#end_date', 'textarea[name="work_description"]'];

            requiredFields.forEach(function (selector) {
                if (!$(selector).val()) {
                    isValid = false;
                    $(selector).addClass('is-invalid');
                } else {
                    $(selector).removeClass('is-invalid');
                }
            });

            if (!isValid) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Please fill all required fields.'
                });

                $btn.removeAttr("data-kt-indicator");
                $btn.prop("disabled", false);
                return;
            }

            const loadingEl = document.createElement("div");
            document.body.prepend(loadingEl);
            loadingEl.classList.add("page-loader", "flex-column", "bg-dark", "bg-opacity-25");
            loadingEl.innerHTML = `
                <span class="spinner-border text-primary" role="status"></span>
                <span class="text-gray-800 fs-6 fw-semibold mt-5">Loading...</span>
            `;

            KTApp.showPageLoading();

            setTimeout(() => {
                $.ajax({
                    url: "{{ route('WorkOrder.Update') }}",
                    type: "POST",
                    data: $('#kt_docs_formvalidation_text').serialize(),
                    success: function (response) {
                        KTApp.hidePageLoading();  
                        loadingEl.remove();

                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: response.message,
                                customClass: { confirmButton: "btn btn-success" }
                            }).then(() => {
                                const isNeedMaterial = $('#require_material_checkbox').is(':checked');
                                const redirectUrl = isNeedMaterial 
                                    ? "http://localhost/BmMaintenance/public/Material-Request/Create"
                                    : "http://localhost/BmMaintenance/public/Work-Order/list";
                                window.location.href = redirectUrl;
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Failed!',
                                text: response.message
                            });

                            // Reset tombol
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

                        // Reset tombol
                        $btn.removeAttr("data-kt-indicator");
                        $btn.prop("disabled", false);
                    }
                });
            }, 500);
        });
    });
</script>
>>>>>>> ff25b43 (Update)

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
