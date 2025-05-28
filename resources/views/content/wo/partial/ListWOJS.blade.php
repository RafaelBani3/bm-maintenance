    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    
    
    {{-- GET DATA FOR TABLE --}}
    <script>
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
                    className: "text-center align-middle",
                    render: data => `<span class="text-primary fw-bold">${data ?? 'N/A'}</span>`
                },
                {
                    data: "Case_No",
                    className: "text-center align-middle",
                    render: data => `<span class="text-primary fw-bold">${data ?? 'N/A'}</span>`
                },
                {
                    data: "created_by_fullname",
                    className: "text-center align-middle",
                    render: data => `<span class="text-gray">${data ?? 'N/A'}</span>`
                },
                {
                    data: "CR_DT",
                    className: "text-center align-middle",
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
                    className: "text-center align-middle",
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
                    className: "text-center align-middle",
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
                    className: "text-center align-middle",
                    render: function (data) {
                        let badgeClass = "badge-light-secondary";
                        switch (data) {
                            case "Pending": badgeClass = "badge-light-secondary text-success"; break;
                            case "OPEN":
                            case "Open_Completion":
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
                    className: "text-center align-middle",
                    render: data => data ?? "-"
                },
                {
                    data: "WO_NeedMat",
                    className: "text-center align-middle",
                    render: data => data ?? "-"
                },
                {
                    data: "WO_CompDate",
                    className: "text-center align-middle",
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
                    className: "text-center align-middle",
                    render: data => data ?? "N/A"
                },
                {
                    data: "WO_No",
                    className: "text-center align-middle",
                    render: function (data) {
                        if (!data) return '-';
                        try {
                            const safeEncoded = btoa(data);
                            return `
                                <a href="${baseUrl}/Work-Order/Detail/${safeEncoded}" class="btn btn-secondary hover-scale">
                                    <i class="ki-duotone ki-eye">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                    </i>
                                    View
                                </a>`;
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
        $('#exportExcel').on('click', function () { 
            let status = $('#statusFilter').val() || 'all'; 
            let search = $('#searchReport').val() || ''; 
            let url = new URL(window.location.origin + "/BmMaintenance/public/wo/export"); 
            url.searchParams.append('status', status); url.searchParams.append('search', search); 
            window.open(url, '_blank');  
        }); 
    </script>
