{{-- <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script> --}}

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
        fetch('/api/Aproval-cases')
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
                            <form action="/Case/Approval/Detail" method="POST" style="display:inline;">
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

<script>
    document.addEventListener("DOMContentLoaded", function() {
        fetchCases();

        // Event listener untuk filter status
        document.getElementById("statusFilter").addEventListener("change", function() {
            let selectedStatus = this.value;
            fetchCases(selectedStatus);
        });

        // Event listener untuk checkbox "Select All"
        document.getElementById("selectAll").addEventListener("change", function() {
            let checkboxes = document.querySelectorAll(".caseCheckbox");
            checkboxes.forEach(checkbox => checkbox.checked = this.checked);
        });
    });

    function fetchCases(status = '') {
        fetch(`/api/Aproval-cases?status=${status}`)
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
                            <form action="/Case/Approval/Detail" method="POST" style="display:inline;">
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
</script>
