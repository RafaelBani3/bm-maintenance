
{{-- <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script> --}}

<<<<<<< HEAD
{{-- Get All Case Data --}}
{{-- <script>
    $(document).ready(function() {
        let table = $("#casesTable").DataTable({
            ajax: {
                url: "/api/cases",
                dataSrc: "data"
            },
            columns: [
                { data: "Case_No", className: "text-start align-middle" },
                { 
                    data: "Case_Date", 
                    className: "text-start align-middle", 
                    render: function(data) {
                        const date = new Date(data);
                        const day = date.getDate();
                        const month = date.getMonth() + 1;
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
                    render: function(data) {
                        let badgeClass = "badge-light-secondary";
                        if (data === "OPEN") badgeClass = "badge-light-primary";
                        else if (data === "SUBMIT") badgeClass = "badge-light-warning";
                        else if (data === "CLOSE") badgeClass = "badge-light-success";
                        else if (data === "REJECT") badgeClass = "badge-light-danger";
                        else if (data.startsWith("AP")) badgeClass = "badge-light-info";
                        
                        let statusText = data.startsWith("AP") ? `Approve ${data.substring(2)}` : data;
                        return `<span class="badge ${badgeClass}">${statusText}</span>`;
                    }
                },
                {
                    data: "Case_No",
                    className: "text-start align-middle",
                    render: function(data) {
                        const encodedCaseNo = encodeURIComponent(data);
                        return `
                            <a href="/Case/Detail/${encodedCaseNo}" class="btn btn-secondary">
                                <i class="ki-duotone ki-eye">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                </i>
                                View
                            </a>`;
=======
    {{-- Get All Case Data --}}
    <script>
        $(document).ready(function () {
            $('#statusFilter').select2({
                placeholder: "Pilih Status",
                allowClear: true,
                width: 'resolve' 
            });

            let table = $("#casesTable").DataTable({
                ajax: {
                    url: window.location.origin + "/BmMaintenance/public/api/cases",
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
                            if (data === "OPEN") badgeClass = "badge-light-primary";
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
                        render: function (data) {
                            const encodedCaseNo = btoa(data); 
                            const baseUrl = window.location.origin + "/BmMaintenance/public";
                            return `
                                <a href="${baseUrl}/Case/Detail/${encodedCaseNo}" class="btn btn-secondary hover-scale d-flex align-items-center">
                                    <i class="ki-duotone ki-eye">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                    </i>
                                    View
                                </a>`;
                        }
>>>>>>> ff25b43 (Update)
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
<<<<<<< HEAD
    });
</script> --}}

{{-- <script>
    $(document).ready(function() {
        let table = $("#casesTable").DataTable({
            ajax: {
                url: window.location.origin + "/BmMaintenance/public/api/cases",
                // url: "api/cases",
                dataSrc: "", 
                error: function(xhr, error, thrown) {
                    console.log("AJAX Error:", xhr.responseText);
                    alert("Gagal mengambil data kasus. Silakan cek console untuk detail.");
                }
            },
            columns: [
                { data: "Case_No", className: "text-start align-middle" },
                { 
                    data: "Case_Date", 
                    className: "text-start align-middle", 
                    render: function(data) {
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
                    render: function(data) {
                        let badgeClass = "badge-light-secondary";
                        if (data === "OPEN") badgeClass = "badge-light-primary";
                        else if (data === "SUBMIT") badgeClass = "badge-light-primary";
                        else if (data === "CLOSE") badgeClass = "badge-light-success";
                        else if (data === "REJECT") badgeClass = "badge-light-danger";
                        else if (data.startsWith("AP")) badgeClass = "badge-light-info";
                        
                        let statusText = data.startsWith("AP") ? `Approve ${data.substring(2)}` : data;
                        return `<span class="badge ${badgeClass}">${statusText}</span>`;
                    }
                },
                {
                    data: "Case_No",
                    className: "text-start align-middle",
          
                    render: function(data) {
                        const encodedCaseNo = encodeURIComponent(data);
                        const baseUrl = window.location.origin + window.location.pathname.split('/public')[0] + '/public';
                        return `
                            <a href="${baseUrl}/Case/Detail/${encodedCaseNo}" class="btn btn-secondary">
                                <i class="ki-duotone ki-eye">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                </i>
                                View
                            </a>`;
                    }

                }
            ],
            scrollY: "300px",
            scrollCollapse: true,
            fixedColumns: {
                left: 2
            }
        });

        $('#applyFilter').on('click', function() {
            let searchQuery = $('#searchReport').val().toLowerCase();
            let statusFilter = $('#statusFilter').val();
            
            table.search(searchQuery).draw();
            table.column(6).search(statusFilter === 'all' ? '' : statusFilter).draw();
        });
    });
</script> --}}

{{-- <script>
    $(document).ready(function () {
        let table = $("#casesTable").DataTable({
            ajax: {
                url: window.location.origin + "/BmMaintenance/public/api/cases",
                dataSrc: "",
                error: function (xhr, error, thrown) {
                    console.log("AJAX Error:", xhr.responseText);
                    alert("Gagal mengambil data kasus. Silakan cek console untuk detail.");
                }
            },
            columns: [
                { data: "Case_No", className: "text-start align-middle" },
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
                        if (data === "OPEN") badgeClass = "badge-light-primary";
                        else if (data === "SUBMIT") badgeClass = "badge-light-primary";
                        else if (data === "CLOSE") badgeClass = "badge-light-success";
                        else if (data === "REJECT") badgeClass = "badge-light-danger";
                        else if (data.startsWith("AP")) badgeClass = "badge-light-primary";

                        let statusText = data.startsWith("AP") ? `Approve ${data.substring(2)}` : data;
                        return `<span class="badge ${badgeClass}">${statusText}</span>`;
                    }
                },
                {
                    data: "Case_No",
                    className: "text-start align-middle",
                    render: function (data) {
                        const encodedCaseNo = btoa(data); 
                        const baseUrl = window.location.origin + "/BmMaintenance/public";
                        return `
                            <a href="${baseUrl}/Case/Detail/${encodedCaseNo}" class="btn btn-secondary">
                                <i class="ki-duotone ki-eye">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                </i>
                                View
                            </a>`;
                    }

                }
            ],
            scrollY: "300px",
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
                table.column(6).search(statusFilter === 'all' ? '' : statusFilter).draw();

                $('#page_loader').css('display', 'none');
            }, 500); 
        });


    });
</script> --}}

    <script>
        $(document).ready(function () {
            $('#statusFilter').select2({
                placeholder: "Pilih Status",
                allowClear: true,
                width: 'resolve' 
            });

            let table = $("#casesTable").DataTable({
                ajax: {
                    url: window.location.origin + "/BmMaintenance/public/api/cases",
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
                            if (data === "OPEN") badgeClass = "badge-light-primary";
                            else if (data === "SUBMIT") badgeClass = "badge-light-primary";
                            else if (data === "CLOSE") badgeClass = "badge-light-success";
                            else if (data === "REJECT") badgeClass = "badge-light-danger";
                            else if (data.startsWith("AP")) badgeClass = "badge-light-primary";

                            let statusText = data.startsWith("AP") ? `Approve ${data.substring(2)}` : data;
                            return `<span class="badge ${badgeClass}">${statusText}</span>`;
                        }
                    },
                    {
                        data: "Case_No",
                        className: "text-start align-middle",
                        render: function (data) {
                            const encodedCaseNo = btoa(data); 
                            const baseUrl = window.location.origin + "/BmMaintenance/public";
                            return `
                                <a href="${baseUrl}/Case/Detail/${encodedCaseNo}" class="btn btn-secondary hover-scale d-flex align-items-center">
                                    <i class="ki-duotone ki-eye">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                    </i>
                                    View
                                </a>`;
                        }
                    }
                ],
                scrollY: "200px",
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

=======
        $('#dateFilter').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });
>>>>>>> ff25b43 (Update)
    </script>


