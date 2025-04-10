
{{-- <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script> --}}

{{-- Get All Case Data --}}
{{-- <script>
    document.addEventListener("DOMContentLoaded", function() {
        fetchCases();
        setInterval(fetchCases, 50000);

        document.getElementById("selectAll").addEventListener("change", function() {
            let checkboxes = document.querySelectorAll(".caseCheckbox");
            checkboxes.forEach(checkbox => checkbox.checked = this.checked);
        });
    });

    function fetchCases() {
        fetch('/api/cases')
            .then(response => response.json())
            .then(data => {
                let tableBody = '';
                data.forEach(caseItem => {
                    tableBody += `<tr>
                        <td class="text-center align-middle">
                            <input type="checkbox" class="caseCheckbox" style="width: 22px; height: 22px;">
                        </td>
                        <td class="text-center align-middle min-w-150px ">${caseItem.Case_No}</td>
                        <td class="text-center align-middle min-w-140px ">${caseItem.Case_Date}</td>
                        <td class="text-center align-middle min-w-120px ">${caseItem.Case_Name}</td>
                        <td class="text-center align-middle min-w-120px ">${caseItem.Category}</td>
                        <td class="text-center align-middle min-w-120px ">${caseItem.User}</td>
                        <td class="text-center align-middle min-w-120px ">${caseItem.PS_Name}</td>
                        <td class="text-center align-middle min-w-120px">
                            <span class="badge 
                                ${caseItem.Case_Status === 'OPEN' ? 'badge-primary' : 
                                caseItem.Case_Status === 'SUBMIT' ? 'badge-warning' : 
                                caseItem.Case_Status === 'CLOSE' ? 'badge-success' : 
                                caseItem.Case_Status === 'REJECT' ? 'badge-danger' : 
                                (caseItem.Case_Status.startsWith('AP') ? 'badge-info' : 'badge-secondary')}">
                                ${caseItem.Case_Status === 'AP1' ? 'Approve 1' :
                                caseItem.Case_Status === 'AP2' ? 'Approve 2' :
                                caseItem.Case_Status === 'AP3' ? 'Approve 3' :     
                                caseItem.Case_Status === 'AP4' ? 'Approve 4' :
                                caseItem.Case_Status === 'AP5' ? 'Approve 5' :
                                caseItem.Case_Status}
                            </span>
                        </td>   
                
                        <td class="text-end align-middle min-w-100px">
                            <form action="/Case/Detail" method="POST" style="display:inline;">
                                @csrf
                                <input type="hidden" name="case_no" value="${caseItem.Case_No}">
                                <button type="submit" class="btn btn-primary btn-sm">View Details</button>
                            </form>
                        </td>
                    </tr>`;
                });
                document.querySelector('#casesTable tbody').innerHTML = tableBody;
            })
        .catch(error => console.error("Error fetching cases:", error));
    }
</script> --}}

{{-- <script>
    document.addEventListener("DOMContentLoaded", function() {
        fetchCases();
        setInterval(fetchCases, 50000);

        document.getElementById("selectAll").addEventListener("change", function() {
            let checkboxes = document.querySelectorAll(".caseCheckbox");
            checkboxes.forEach(checkbox => checkbox.checked = this.checked);
        });
    });

    function fetchCases() {
        fetch('/api/cases')
            .then(response => response.json())
            .then(data => {
                let tableBody = '';

                if (data.length === 0) {
                    tableBody = `<tr>
                        <td colspan="9" class="text-center align-middle">
                            <strong>No data available</strong>
                        </td>
                    </tr>`;
                } else {
                    data.forEach(caseItem => {
                        tableBody += `<tr>
                            <td class="text-center align-middle">
                                <input type="checkbox" class="caseCheckbox" style="width: 22px; height: 22px;">
                            </td>
                            <td class="text-center align-middle min-w-150px ">${caseItem.Case_No}</td>
                            <td class="text-center align-middle min-w-140px ">${caseItem.Case_Date}</td>
                            <td class="text-center align-middle min-w-120px ">${caseItem.Case_Name}</td>
                            <td class="text-center align-middle min-w-120px ">${caseItem.Category}</td>
                            <td class="text-center align-middle min-w-120px ">${caseItem.User}</td>
                            <td class="text-center align-middle min-w-120px ">${caseItem.PS_Name}</td>
                            <td class="text-center align-middle min-w-120px">
                                <span class="badge 
                                    ${caseItem.Case_Status === 'OPEN' ? 'badge-primary' : 
                                    caseItem.Case_Status === 'SUBMIT' ? 'badge-warning' : 
                                    caseItem.Case_Status === 'CLOSE' ? 'badge-success' : 
                                    caseItem.Case_Status === 'REJECT' ? 'badge-danger' : 
                                    (caseItem.Case_Status.startsWith('AP') ? 'badge-info' : 'badge-secondary')}">
                                    ${caseItem.Case_Status === 'AP1' ? 'Approve 1' :
                                    caseItem.Case_Status === 'AP2' ? 'Approve 2' :
                                    caseItem.Case_Status === 'AP3' ? 'Approve 3' :     
                                    caseItem.Case_Status === 'AP4' ? 'Approve 4' :
                                    caseItem.Case_Status === 'AP5' ? 'Approve 5' :
                                    caseItem.Case_Status}
                                </span>
                            </td>   
                    
                            <td class="text-end align-middle min-w-100px">
                                <form action="/Case/Detail" method="POST" style="display:inline;">
                                    @csrf
                                    <input type="hidden" name="case_no" value="${caseItem.Case_No}">
                                    <button type="submit" class="btn btn-primary btn-sm">View Details</button>
                                </form>
                            </td>
                        </tr>`;
                    });
                }

                document.querySelector('#casesTable tbody').innerHTML = tableBody;
            })
            .catch(error => console.error("Error fetching cases:", error));
    }
</script> --}}


{{-- <script>
    let sortColumn = null;
    let sortDirection = 'ASC';

    $(document).ready(function() {
        fetchCases(); 
        setInterval(fetchCases, 50000); 

        $("#statusFilter").change(function() {
            fetchCases();
        });

        $("#selectAll").change(function() {
            $(".caseCheckbox").prop("checked", this.checked);
        });

        // Event listener untuk sorting
        $(".sortable").click(function() {
            let column = $(this).data("column");

            if (sortColumn === column) {
                sortDirection = sortDirection === 'ASC' ? 'DESC' : 'ASC';
            } else {
                sortColumn = column;
                sortDirection = 'ASC';
            }

            fetchCases();
        });
    });

    function fetchCases() {
        let selectedStatus = $("#statusFilter").val();

        $.ajax({
            url: "/api/cases",
            type: "GET",
            data: { 
                status: selectedStatus,
                sortColumn: sortColumn,
                sortDirection: sortDirection
            },
            dataType: "json",
            success: function(data) {
                let tableBody = '';

                if (data.length === 0) {
                    tableBody = `<tr>
                        <td colspan="9" class="text-center align-middle">
                            <strong>No data available</strong>
                        </td>
                    </tr>`;
                } else {
                    data.forEach(caseItem => {
                        tableBody += `<tr>
                            <td class="text-center align-middle min-w-150px ">${caseItem.Case_No}</td>
                            <td class="text-center align-middle min-w-140px ">${caseItem.Case_Date}</td>
                            <td class="text-center align-middle min-w-120px ">${caseItem.Case_Name}</td>
                            <td class="text-center align-middle min-w-120px ">${caseItem.Category}</td>
                            <td class="text-center align-middle min-w-120px ">${caseItem.User}</td>
                            <td class="text-center align-middle min-w-120px ">${caseItem.PS_Name}</td>
                            <td class="text-center align-middle min-w-120px">
                                <span class="badge 
                                    ${caseItem.Case_Status === 'OPEN' ? 'badge-primary' : 
                                    caseItem.Case_Status === 'SUBMIT' ? 'badge-warning' : 
                                    caseItem.Case_Status === 'CLOSE' ? 'badge-success' : 
                                    caseItem.Case_Status === 'REJECT' ? 'badge-danger' : 
                                    (caseItem.Case_Status.startsWith('AP') ? 'badge-info' : 'badge-secondary')}">
                                    ${caseItem.Case_Status === 'AP1' ? 'Approve 1' :
                                    caseItem.Case_Status === 'AP2' ? 'Approve 2' :
                                    caseItem.Case_Status === 'AP3' ? 'Approve 3' :     
                                    caseItem.Case_Status === 'AP4' ? 'Approve 4' :
                                    caseItem.Case_Status === 'AP5' ? 'Approve 5' :
                                    caseItem.Case_Status}
                                </span>
                            </td>   
                    
                            <td class="text-end align-middle min-w-100px">
                                <form action="/Case/Detail" method="POST" style="display:inline;">
                                    @csrf
                                    <input type="hidden" name="case_no" value="${caseItem.Case_No}">
                                    <button type="submit" class="btn btn-primary btn-sm">View Details</button>
                                </form>
                            </td>
                        </tr>`;
                    });
                }

                $("#casesTable tbody").html(tableBody);
            },
            error: function(error) {
                console.error("Error fetching cases:", error);
            }
        });
    }
</script> --}}

<script>
    $(document).ready(function() {
        let table = $("#casesTable").DataTable({
            ajax: {
                url: "/api/cases",
                dataSrc: ""
            },
            columns: [
                { data: "Case_No", className: "text-center align-middle" },
                { 
                    data: "Case_Date", 
                    className: "text-center align-middle", 
                    render: function(data) {
                        return new Date(data).toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' });
                    }
                },
                { data: "Case_Name", className: "text-center align-middle" },
                { data: "Category", className: "text-center align-middle" },
                { data: "User", className: "text-center align-middle" },
                { data: "PS_Name", className: "text-center align-middle" },
                { 
                    data: "Case_Status", 
                    className: "text-center align-middle",
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
                    className: "text-end align-middle",
                    render: function(data) {
                        return `
                            <form action="/Case/Detail" method="POST" style="display:inline;">
                                @csrf
                                <input type="hidden" name="case_no" value="${data}">
                                <button type="submit" class="btn btn-secondary">
                                    <i class="ki-duotone ki-eye">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                    </i>
                                    View
                                </button>
                            </form>`;
                    }
                }
            ],
            scrollY: "300px",
            scrollCollapse: true,
            fixedColumns: {
                left: 2
            }
        });

        // Apply filter
        $('#applyFilter').on('click', function() {
            let searchQuery = $('#searchReport').val().toLowerCase();
            let statusFilter = $('#statusFilter').val();
            
            table.search(searchQuery).draw();
            table.column(6).search(statusFilter === 'all' ? '' : statusFilter).draw();
        });
    });
</script>

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


