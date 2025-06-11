    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    
    
    {{-- GET DATA FOR TABLE --}}
    <script>
    // Declare Route untuk Ke page Edit dan Detail WO
    const editWORoute = "{{ route('EditWO', ['wo_no' => 'PLACEHOLDER']) }}";
    const detailWORoute = "{{ route('WorkOrderDetail', ['wo_no' => 'PLACEHOLDER']) }}";
    $(document).ready(function () {
        const baseUrl = "{{ url('/') }}"; 

        const table = $("#WoTable").DataTable({
            ajax: {
                url: "{{ route('GetWODataTable') }}",
                dataSrc: ""
            },
            columns: [
                {
                    data: "WO_No",
                    className: "text-start",
                    render: data => `<span class="text-primary fw-bold">${data ?? 'N/A'}</span>`
                },
                {
                    data: "Case_No",
                    className: "text-start",
                    render: data => `<span class="text-primary fw-bold">${data ?? 'N/A'}</span>`
                },
                {
                    data: "created_by_fullname",
                    className: "text-start",
                    render: data => `<span class="text-gray">${data ?? 'N/A'}</span>`
                },
                {
                    data: "CR_DT",
                    className: "text-start",
                    render: data => {
                        if (!data) return "-";
                        const dateObj = new Date(data);
                        const day = String(dateObj.getDate()).padStart(2, '0');
                        const month = String(dateObj.getMonth() + 1).padStart(2, '0');
                        const year = dateObj.getFullYear();
                        return `${day}/${month}/${year}`;
                    }

                },
                {
                    data: "WO_Start",
                    className: "text-start",
                    render: data => {
                        if (!data) return "-";
                        const dateObj = new Date(data);
                        const day = String(dateObj.getDate()).padStart(2, '0');
                        const month = String(dateObj.getMonth() + 1).padStart(2, '0');
                        const year = dateObj.getFullYear();
                        return `${day}/${month}/${year}`;
                    }
                },
                {
                    data: "WO_End",
                    className: "text-start",
                    render: data => {
                        if (!data) return "-";
                        const dateObj = new Date(data);
                        const day = String(dateObj.getDate()).padStart(2, '0');
                        const month = String(dateObj.getMonth() + 1).padStart(2, '0');
                        const year = dateObj.getFullYear();
                        return `${day}/${month}/${year}`;
                    }
                },
                {
                    data: "WO_Status",
                    className: "text-start",
                    render: function (data) {
                        let badgeClass = "badge-light-secondary";
                        switch (data) {
                            case "Pending": badgeClass = "badge-light-secondary text-success"; break;
                            case "OPEN":
                            case "Open_Completion":
                                badgeClass = "badge-light-warning text-warning"; 
                                break;
                            case "INPROGRESS": 
                                badgeClass = "badge-light-info text-info"; 
                                break;
                            case "SUBMIT": 
                            case "Submit_Complition":
                            case "AP1":
                            case "AP2":
                            case "AP3":
                            case "AP4":
                            case "AP5": badgeClass = "badge-light-primary text-primary"; break;
                            case "REJECT": badgeClass = "badge-light-danger text-danger"; break;
                            case "CLOSE": badgeClass = "badge-light-dark text-dark"; break;
                            case "DONE": badgeClass = "badge-light-success text-success"; break;
                        }
                        return `<span class="badge ${badgeClass} fw-semibold">${data ?? 'N/A'}</span>`;
                    }
                },
                {
                    data: "WO_Narative",
                    className: "text-start",
                    render: data => data ?? "-"
                },
                {
                    data: "WO_NeedMat",
                    className: "text-start",
                    render: data => data ?? "-"
                },
                {
                    data: "WO_CompDate",
                    className: "text-center",
                    render: data => {
                        if (!data) return "-";
                        const dateObj = new Date(data);
                        const day = String(dateObj.getDate()).padStart(2, '0');
                        const month = String(dateObj.getMonth() + 1).padStart(2, '0');
                        const year = dateObj.getFullYear();
                        return `${day}/${month}/${year}`;
                    }
                },
                {
                    data: "completed_by_fullname",
                    className: "text-center",
                    render: data => data ?? "N/A"
                },
                
               
                {
                    data: "WO_No",
                    className: "text-start",
                    render: function (data, type, row) {
                        if (!data) return '-';

                        try {
                            const encodedWONo = btoa(data);
                            let buttons = '<div class="d-flex gap-2 justify-content-center">';

                            // Ganti placeholder dengan encoded WO_No
                            const editUrl = editWORoute.replace('PLACEHOLDER', encodedWONo);
                            const detailUrl = detailWORoute.replace('PLACEHOLDER', encodedWONo);

                            // Tombol Edit (jika status OPEN atau REJECT)
                            if (row.WO_Status === "OPEN" || row.WO_Status === "REJECT") {
                                buttons += `
                                    <a href="${editUrl}" 
                                    class="btn bg-light-warning d-flex align-items-center justify-content-center p-2" 
                                    style="width: 40px; height: 40px;" 
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Work Order">
                                        <i class="ki-duotone ki-pencil fs-3 text-warning">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </a>
                                `;
                            }

                            // Tombol View (selalu muncul)
                            buttons += `
                                <a href="${detailUrl}" 
                                class="btn bg-light-primary d-flex align-items-center justify-content-center p-2" 
                                style="width: 40px; height: 40px;" 
                                data-bs-toggle="tooltip" data-bs-placement="top" title="View Work Order">
                                    <i class="ki-duotone ki-eye fs-3 text-primary">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                    </i>
                                </a>
                            </div>`;

                            return buttons;
                        } catch (err) {
                            console.error("Encoding error:", err);
                            return '-';
                        }
                    }
                }
            ],

            destroy: true,
            scrollY: "300px",
            scrollX: true,
            scrollCollapse: true,
            fixedColumns: {
                left: 2,
                right: 1,
            }
        });

        setInterval(() => {
            table.ajax.reload(null, false);
        }, 10000);

        function showPageLoading() {
            $('.page-loader').removeClass('d-none').fadeIn(200);
        }

        function hidePageLoading() {
            setTimeout(() => {
                $('.page-loader').fadeOut(200, function () {
                    $(this).addClass('d-none');
                });
            }, 800);
        }


        $('#applyFilter').on('click', function () {
            const keyword = $('#searchReport').val().toLowerCase();
            const status = $('#statusFilter').val();

            showPageLoading();

            setTimeout(() => {
                table.search(keyword).draw();
                table.column(6).search(status === 'all' ? '' : status).draw();

                hidePageLoading();
            }, 300);    
        });

    });
    </script>
    
    <script>
        const BASE_URL = "{{ url('/') }}";
    </script>
        
    <script> 
        // Declare Route 
        const exportWOUrl = "{{ route('wo.export') }}";

        $('#exportExcel').on('click', function () { 
            let status = $('#statusFilter').val() || 'all'; 
            let search = $('#searchReport').val() || ''; 

            let url = new URL(exportWOUrl); 
            url.searchParams.append('status', status); 
            url.searchParams.append('search', search); 

            window.open(url.toString(), '_blank');  
        }); 
    </script>
