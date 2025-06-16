
    {{-- Get All Case Data --}}
    {{-- <script>
        // Declare Route untuk page Edit dan Detail Page
        const routeEditCase = "{{ route('EditCase', ['encoded_case_no' => 'case_no']) }}";
        const routeCaseDetail = "{{ route('case.detail', ['case_no' => 'case_no']) }}";
        
        const canEditCase = @json(auth()->user()->can('view cr'));
        
        $(document).ready(function () {
            $('#statusFilter').select2({
                placeholder: "Pilih Status",
                allowClear: true,
                width: 'resolve' 
            });

            let table = $("#casesTable").DataTable({
                ajax: {
                    // url: window.location.origin + "/BmMaintenance/public/api/cases",
                    url: "{{ route('GetCasesDataTable') }}", 
                    dataSrc: "",
                    error: function (xhr, error, thrown) {
                        console.log("AJAX Error:", xhr.responseText);
                        alert("Gagal mengambil data kasus. Silakan cek console untuk detail.");
                    }
                },
                columns: [
                    { data: "Case_No", className: "text-start text-primary align-middle" },
                    {
                        data: "Case_Date",
                        className: "text-start align-middle",
                        render: function (data) {
                            const date = new Date(data);
                            const day = date.getDate().toString().padStart(2, '0');
                            const month = (date.getMonth() + 1).toString().padStart(2, '0');
                            const year = date.getFullYear();
                            return `${day}/${month}/${year}`;
                        }
                    },
                    { data: "Case_Name", className: "text-start align-middle" },
                    { data: "Category", className: "text-start align-middle" },
                    { data: "User", className: "text-start align-middle" },
                    { data: "PS_Name", className: "text-start align-middle" },
                    {
                        data: "Case_Status",
                        className: "text-start align-middle",
                        render: function (data) {
                            let badgeClass = "badge-light-secondary";
                            if (data === "OPEN") badgeClass = "badge-light-warning";
                            else if (data === "SUBMIT") badgeClass = "badge-light-primary";
                            else if (data === "CLOSE") badgeClass = "badge-light-success";
                            else if (data === "REJECT") badgeClass = "badge-light-danger";
                            else if (data === "INPROGRESS") badgeClass = "badge-light-info";
                            else if (data.startsWith("AP")) badgeClass = "badge-light-primary";
                            else if (data.startsWith("DONE")) badgeClass = "badge-light-success";


                            let statusText = data.startsWith("AP") ? `Approve ${data.substring(2)}` : data;
                            return `<span class="badge ${badgeClass}">${statusText}</span>`;
                        }
                    },
                    {
                        data: "Case_No",
                        className: "text-start align-middle",
                        render: function (data, type, row) {
                            if (!data) return '-';

                            const encodedCaseNo = btoa(data);

                            const editUrl = routeEditCase.replace('case_no', encodedCaseNo);
                            const detailUrl = routeCaseDetail.replace('case_no', encodedCaseNo);

                            let buttons = '<div class="d-flex gap-2">';

                            // Tombol Edit hanya jika user punya permission `view-cr` DAN status OPEN/REJECT
                            if ((row.Case_Status === "OPEN" || row.Case_Status === "REJECT") && typeof canEditCase !== 'undefined' && canEditCase) {
                                buttons += `
                                    <a href="${editUrl}" 
                                    class="btn bg-light-warning d-flex align-items-center justify-content-center p-2" 
                                    style="width: 40px; height: 40px;" 
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Case">
                                        <i class="ki-duotone ki-pencil fs-3 text-warning">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </a>
                                `;
                            }

                            // Tombol View bisa diakses semua user
                            buttons += `
                                <a href="${detailUrl}" 
                                class="btn bg-light-primary d-flex align-items-center justify-content-center p-2" 
                                style="width: 40px; height: 40px;" 
                                data-bs-toggle="tooltip" data-bs-placement="top" title="View Case">
                                    <i class="ki-duotone ki-eye fs-3 text-primary">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                    </i>
                                </a>
                            </div>`;

                            return buttons;
                        }


                      }
                ],
                scrollY: "350px",
                scrollCollapse: false,
                fixedColumns: {
                    left: 2
                }
            });

            $('#applyFilter').on('click', function () {
                $('#page_loader').css('display', 'flex');

                setTimeout(function () {
                    let searchQuery = $('#searchReport').val().toLowerCase();
                    let statusFilter = $('#statusFilter').val();

                    table.search(searchQuery).draw();
                    table.column(6).search(statusFilter === 'all' || statusFilter === null ? '' : statusFilter).draw();

                    $('#page_loader').css('display', 'none');
                }, 500); 
            });
        });
    </script> --}}

    <script>
        const routeEditCase = "{{ route('EditCase', ['encoded_case_no' => 'case_no']) }}";
        const routeCaseDetail = "{{ route('case.detail', ['case_no' => 'case_no']) }}";
        const canEditCase = @json(auth()->user()->can('view cr'));

        $(document).ready(function () {
            $('#statusFilter').select2({
                placeholder: "Pilih Status",
                allowClear: true,
                width: 'resolve'
            });

            let table = $("#casesTable").DataTable({
                ajax: {
                    url: "{{ route('GetCasesDataTable') }}",
                    dataSrc: "",
                    error: function (xhr) {
                        console.error("AJAX Error:", xhr.responseText);
                        alert("Error: Terjadi kendala pada saat mengambil data kasus. Segera hubungi IT Admin.");
                    }
                },
                columns: [
                    { data: "Case_No", className: "text-start text-primary align-middle" },
                    {
                        data: "Case_Date",
                        className: "text-start align-middle",
                        render: function (data) {
                            const date = new Date(data);
                            return date.toLocaleDateString('id-ID'); 
                        }
                    },
                    { data: "Case_Name", className: "text-start align-middle" },
                    { data: "Category", className: "text-start align-middle" },
                    { data: "User", className: "text-start align-middle" },
                    { data: "PS_Name", className: "text-start align-middle" },
                    {
                        data: "Case_Status",
                        className: "text-start align-middle",
                        render: function (data) {
                            let badgeClass = "badge-light-secondary";
                            if (data === "OPEN") badgeClass = "badge-light-warning";
                            else if (data === "SUBMIT") badgeClass = "badge-light-primary";
                            else if (data === "CLOSE") badgeClass = "badge-light-success";
                            else if (data === "REJECT") badgeClass = "badge-light-danger";
                            else if (data === "INPROGRESS") badgeClass = "badge-light-info";
                            else if (data.startsWith("AP")) badgeClass = "badge-light-primary";
                            else if (data.startsWith("DONE")) badgeClass = "badge-light-success";

                            let statusText = data.startsWith("AP") ? `Approve ${data.substring(2)}` : data;
                            return `<span class="badge ${badgeClass}">${statusText}</span>`;
                        }
                    },
                    {
                        data: "Case_No",
                        className: "text-start align-middle",
                        render: function (data, type, row) {
                            if (!data) return '-';
                            const encoded = btoa(data);
                            const editUrl = routeEditCase.replace('case_no', encoded);
                            const detailUrl = routeCaseDetail.replace('case_no', encoded);

                            let buttons = '<div class="d-flex gap-2">';
                            if ((row.Case_Status === "OPEN" || row.Case_Status === "REJECT") && canEditCase) {
                                buttons += `
                                    <a href="${editUrl}" class="btn bg-light-warning d-flex align-items-center justify-content-center p-2" title="Edit Case">
                                        <i class="ki-duotone ki-pencil fs-2 align-middle text-center">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </a>`;
                            }
                            buttons += `
                                <a href="${detailUrl}" class="btn bg-light-primary d-flex align-items-center justify-content-center p-2" title="View Case">
                                    <i class="ki-duotone ki-eye fs-2 align-middle text-center">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                    </i>
                                </a>`;
                            buttons += '</div>';
                            return buttons;
                        }
                    }
                ],
                order: [[1, 'desc']], 
                language: {
                    emptyTable: "No data available in table",
                    loadingRecords: "Loading...",
                    zeroRecords: "No matching cases found",
                },
                scrollY: "350px",
                scrollCollapse: true,
                fixedColumns: {
                    left: 2
                }
            });

            $('#applyFilter').on('click', function () {
                $('#page_loader').css('display', 'flex');
                setTimeout(function () {
                    let searchQuery = $('#searchReport').val().toLowerCase();
                    let statusFilter = $('#statusFilter').val();

                    table.search(searchQuery).draw();
                    table.column(6).search(statusFilter === 'all' || statusFilter === null ? '' : statusFilter).draw();

                    $('#page_loader').css('display', 'none');
                }, 500);
            });
        });
    </script>

    {{-- Script Choose Date Range --}}
    <script>
        $('#dateFilter').daterangepicker({
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear',
                format: 'YYYY-MM-DD'
            }
        });
        $('#dateFilter').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
        });
        $('#dateFilter').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });
    </script>

