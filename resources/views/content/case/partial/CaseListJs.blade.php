
    {{-- Get All Case Data --}}
    <script>
        const routeEditCase = "{{ route('EditCase', ['encoded_case_no' => 'case_no']) }}";
        const routeCaseDetail = "{{ route('case.detail', ['case_no' => 'case_no']) }}";
        const canEditCase = @json(auth()->user()->can('view cr'));
        const routeExportPDF = "{{ route('case.exportPDF', 'case_no') }}";
        const routeDeleteCase = "{{ route('DeleteCase', ['encoded_case_no' => 'case_no']) }}";
        const userPosition = @json(auth()->user()->position); 



        // Ambil parameter dari URL
        function getUrlParam(name) {
            const url = new URL(window.location.href);
            return url.searchParams.get(name);
        }

        let defaultStatus = getUrlParam('status');
        let defaultSearch = getUrlParam('search');
        let defaultStart = getUrlParam('start');
        let defaultEnd = getUrlParam('end');

        let startDate = defaultStart || null;
        let endDate = defaultEnd || null;

        const validStatuses = [
            'OPEN', 'SUBMIT', 'AP1', 'AP2', 'AP3', 'AP4', 'AP5',
            'CLOSE', 'REJECT', 'INPROGRESS', 'DONE'
        ];

        $(document).ready(function () {
            $('#statusFilter').select2({
                placeholder: "Pilih Status",
                allowClear: true,
                width: 'resolve'
            });

            if (defaultStatus && validStatuses.includes(defaultStatus)) {
                $('#statusFilter').val(defaultStatus).trigger('change');
            }

            $('#dateFilter').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    cancelLabel: 'Clear',
                    format: 'YYYY-MM-DD'
                }
            });

            if (startDate && endDate) {
                $('#dateFilter').val(`${startDate} - ${endDate}`);
            }

            $('#dateFilter').on('apply.daterangepicker', function (ev, picker) {
                startDate = picker.startDate.format('YYYY-MM-DD');
                endDate = picker.endDate.format('YYYY-MM-DD');
                $(this).val(startDate + ' - ' + endDate);
            });

            $('#dateFilter').on('cancel.daterangepicker', function () {
                $(this).val('');
                startDate = null;
                endDate = null;
            });

            // Inisialisasi DataTable
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
                            const deleteUrl = routeDeleteCase.replace('case_no', encoded);
                            
                            let buttons = '<div class="d-flex gap-2">';
                            if ((row.Case_Status === "OPEN" || row.Case_Status === "REJECT") && canEditCase) {
                                buttons += `
                                    <a href="${editUrl}" class="btn bg-light-warning d-flex align-items-center justify-content-center p-2" title="Edit Case">
                                        <i class="ki-duotone ki-pencil fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        </i>
                                    </a>`;
                            }

                            // Tambahkan tombol Print PDF jika status DONE
                            if (row.Case_Status === "DONE") {
                                const exportPdfUrl = routeExportPDF.replace('case_no', encoded);
                                buttons += `
                                    <a href="${exportPdfUrl}" target="_blank" class="btn bg-light-info d-flex align-items-center justify-content-center p-2" title="Export PDF">
                                        <i class="ki-duotone ki-printer fs-2 text-info">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </a>`;
                            }

                            // tombol Delete Case
                            console.log("User Position:", userPosition);

                            if (row.PS_Name === "Creator" || row.PS_Name === "Approver") {
                                buttons += `
                                    <form action="${deleteUrl}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kasus ini?');">
                                        <input type="hidden" name="_token" value="${$('meta[name="csrf-token"]').attr('content')}">
                                        <button type="submit" class="btn bg-light-danger d-flex align-items-center justify-content-center p-2" title="Delete Case">
                                            <i class="ki-duotone ki-trash fs-2 text-danger">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                        </button>
                                    </form>`;
                            }

                            // tombol View Case
                            buttons += `
                                <a href="${detailUrl}" class="btn bg-light-primary d-flex align-items-center justify-content-center p-2" title="View Case">
                                    <i class="ki-duotone ki-eye fs-2">
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
                order: [[1, "desc"]],
                
                language: {
                    emptyTable: "No data available in table",
                    loadingRecords: "Loading...",
                    zeroRecords: "No matching cases found",
                },
                scrollY: "350px",
                scrollCollapse: true,
                fixedColumns: {
                    left: 2
                },
                initComplete: function () {
                    if (defaultSearch) {
                        table.search(defaultSearch.toLowerCase()).draw();
                        $('#searchReport').val(defaultSearch);
                    }

                    if (defaultStatus && validStatuses.includes(defaultStatus)) {
                        table.column(6).search(defaultStatus).draw();
                    }

                    if (startDate && endDate) {
                        table.rows().every(function () {
                            const rowData = this.data();
                            const caseDate = new Date(rowData.Case_Date).toISOString().split('T')[0];
                            const inRange = caseDate >= startDate && caseDate <= endDate;
                            $(this.node()).toggle(inRange);
                        });
                    }
                }
            });

            // Manual Apply Filter (Button)
            $('#applyFilter').on('click', function () {
                $('#page_loader').css('display', 'flex');
                setTimeout(function () {
                    let searchQuery = $('#searchReport').val().toLowerCase();
                    let statusFilter = $('#statusFilter').val();

                    table.search(searchQuery).draw();
                    table.column(6).search(statusFilter === 'all' || statusFilter === null ? '' : statusFilter).draw();

                    if (startDate && endDate) {
                        table.rows().every(function () {
                            const rowData = this.data();
                            const caseDate = new Date(rowData.Case_Date).toISOString().split('T')[0];
                            const inRange = caseDate >= startDate && caseDate <= endDate;
                            $(this.node()).toggle(inRange);
                        });
                    } else {
                        table.rows().every(function () {
                            $(this.node()).show();
                        });
                    }

                    $('#page_loader').css('display', 'none');
                }, 500);
            });
        });
    </script>
