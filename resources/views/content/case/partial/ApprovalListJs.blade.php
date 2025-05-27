{{-- 
<link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script> 
--}}

    {{-- Data Range --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            flatpickr("#dateFilter", {
                mode: "range",
                dateFormat: "Y-m-d"
            });
        });
    </script>

    {{-- Get Case untuk table --}}
    <script>
        $(document).ready(function () {
            const table = $('#casesTable').DataTable({
                ajax: {
                    url: window.location.origin + "/BmMaintenance/public/api/Aproval-cases",
                    dataSrc: ''
                },
                columns: [
                    { data: "Case_No", className: "text-start text-primary align-middle" },
                    { 
                        data: "Case_Date", 
                        className: "text-start align-middle", 
                        render: function(data) {
                            const date = new Date(data);
                            const day = String(date.getDate()).padStart(2, '0');
                            const month = String(date.getMonth() + 1).padStart(2, '0');
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
                            else if (data.startsWith("AP")) badgeClass = "badge-light-primary";

                            let label = data.startsWith("AP") ? `Approve ${data.substring(2)}` : data;
                            return `<span class="badge ${badgeClass}">${label}</span>`;
                        }
                    },
                    {
                        data: "Case_No",
                        className: "text-start align-middle",
                        render: function (data) {
                            const encodedCaseNo = btoa(data); 
                            const baseUrl = window.location.origin + "/BmMaintenance/public";
                            return `
                                <div class="d-flex align-items-center">
                                    <a href="${baseUrl}/Case/Approval/Detail/${encodedCaseNo}" class="btn btn-secondary hover-scale d-flex align-items-center gap-1">
                                        <i class="ki-duotone ki-eye fs-5">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>
                                        <span>View</span>
                                    </a>
                                </div>`;
                        }
                    }
                ],
                scrollY: "350px",
                scrollCollapse: true,
                fixedColumns: {
                    left: 2
                }
            });

            $('#applyFilter').on('click', function () {
                const searchQuery = $('#searchReport').val().toLowerCase();
                const statusFilter = $('#statusFilter').val();
                const dateRange = $('#dateFilter').val();

                table.search(searchQuery).draw();

                table.column(6).search(statusFilter === 'all' ? '' : statusFilter).draw();

                $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
                    if (!dateRange) return true;

                    const [start, end] = dateRange.split(' to ');
                    const caseDate = new Date(data[1]); 

                    const startDate = new Date(start);
                    const endDate = new Date(end);

                    return caseDate >= startDate && caseDate <= endDate;
                });

                table.draw();
            });
        });
    </script>

{{-- Script Untuk Menampilkan data Case Pada Table --}}
{{-- <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Inisialisasi tanggal
        flatpickr("#dateFilter", {
            mode: "range",
            dateFormat: "Y-m-d"
        });

        // Trigger apply filter
        document.getElementById('applyFilter').addEventListener('click', function () {
            const status = document.getElementById('statusFilter').value;
            const keyword = document.getElementById('searchReport').value.trim().toLowerCase();
            const dateRange = document.getElementById('dateFilter').value;

            fetchCases({ status, keyword, dateRange });
        });

        // Fetch awal saat halaman load
        fetchCases();
    });

    function fetchCases(filters = {}) {
        const { status = '', keyword = '', dateRange = '' } = filters;
        const url = `/api/Aproval-cases${status && status !== 'all' ? '?status=' + status : ''}`;

        fetch(url)
            .then(response => response.json())
            .then(data => {
                let filtered = data;

                // Filter berdasarkan keyword
                if (keyword) {
                    filtered = filtered.filter(item =>
                        item.Case_No.toLowerCase().includes(keyword) ||
                        item.Case_Name.toLowerCase().includes(keyword) ||
                        item.Category.toLowerCase().includes(keyword) ||
                        item.User.toLowerCase().includes(keyword)
                    );
                }

                // Filter berdasarkan date range
                if (dateRange) {
                    const [startDate, endDate] = dateRange.split(" to ").map(date => new Date(date));
                    filtered = filtered.filter(item => {
                        const caseDate = new Date(item.Case_Date);
                        return caseDate >= startDate && caseDate <= endDate;
                    });
                }

                renderTable(filtered);
            })
            .catch(error => console.error("Error fetching cases:", error));
    }

    // Ubah Format Case_Date Jadi m/d/Y
    function formatDate(dateString) {
        const date = new Date(dateString);
        const day = String(date.getDate()).padStart(2, '0');
        const month = String(date.getMonth() + 1).padStart(2, '0'); 
        const year = date.getFullYear();
        return `${day}/${month}/${year}`;
    }


    function renderTable(data) {
        const tbody = document.querySelector('#casesTable tbody');
        let tableBody = '';

        if (data.length === 0) {
            tableBody = `
                <tr>
                    <td colspan="8" class="text-center text-muted py-5 bg-secondary text-dark">
                        No data available in table
                    </td>
                </tr>`;
        } else {
            data.forEach(caseItem => {
                const statusBadge = getStatusBadge(caseItem.Case_Status);

                tableBody += `<tr>
                    <td class="text-center align-middle min-w-150px">${caseItem.Case_No}</td>
                    <td class="text-center align-middle min-w-140px">${formatDate(caseItem.Case_Date)}</td>
                    <td class="text-center align-middle min-w-120px">${caseItem.Case_Name}</td>
                    <td class="text-center align-middle min-w-120px">${caseItem.Category}</td>
                    <td class="text-center align-middle min-w-120px">${caseItem.User}</td>
                    <td class="text-center align-middle min-w-120px">${caseItem.PS_Name}</td>
                    <td class="text-center align-middle min-w-120px">${statusBadge}</td>
                    <td class="text-end align-middle min-w-100px">
                        <form action="/Case/Approval/Detail" method="POST" style="display:inline;">
                            @csrf
                            <input type="hidden" name="case_no" value="${caseItem.Case_No}">
                            <button type="submit" class="btn btn-secondary">
                                <i class="ki-duotone ki-eye">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                </i>
                                View
                            </button>
                        </form>
                    </td>
                </tr>`;
            });
        }

        tbody.innerHTML = tableBody;
    }


    function getStatusBadge(status) {
        let label = status;
        let badgeClass = 'badge-secondary';

        switch (status) {
            case 'OPEN':
                badgeClass = 'badge-warning';
                break;
            case 'SUBMIT':
                badgeClass = 'badge-info';
                break;
            case 'CLOSE':
                badgeClass = 'badge-success';
                break;
            case 'REJECT':
                badgeClass = 'badge-danger';
                break;
            case 'AP1':
            case 'AP2':
            case 'AP3':
            case 'AP4':
            case 'AP5':
                badgeClass = 'badge-primary';
                label = `Approve ${status.replace('AP', '')}`;
                break;
        }

        return `<span class="badge ${badgeClass}">${label}</span>`;
    }
</script> --}}

