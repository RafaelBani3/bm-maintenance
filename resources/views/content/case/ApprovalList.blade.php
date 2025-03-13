@extends('layouts.Master')

@section('title', 'Approval Cases Reports')
@section('subtitle', 'Approval Case')

@section('content')
    @include('layouts.partial.breadcrumbs')

    <div class="card mt-5">
        <div class="card-header bg-primary text-white" style="height:60px">
            <h4 class="mb-0 mt-3">Cases Pending Approval</h4>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-bordered mb-0">
                    <thead class="thead-dark text-center">
                        <tr>
                            <th>No</th>
                            <th class="sortable" data-column="Case_No" style="cursor:pointer;">Case ID ▲▼</th>
                            <th>Case Name</th>
                            <th>Created By</th>
                            <th class="sortable" data-column="created_at" style="cursor:pointer;">Created At ▲▼</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Pagination -->
        <div class="card-footer bg-white d-flex justify-content-between align-items-center">
            <div>
                Showing <span id="showingFrom">0</span> to 
                <span id="showingTo">0</span> of 
                <span id="totalEntries">0</span> entries
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            let sortBy = 'created_at';  
            let sortOrder = 'asc';     
    
            function fetchPendingCases() {
                $.ajax({
                    url: "{{ route('cases.pending') }}",
                    type: "GET",
                    data: { sortBy: sortBy, sortOrder: sortOrder },
                    dataType: "json",
                    success: function (data) {
                        let rows = '';
                        if (data.data.length > 0) {
                            $.each(data.data, function (index, caseItem) {
                                rows += `
                                    <tr class="text-center">
                                        <td>${data.from + index}</td>
                                        <td>${caseItem.Case_No}</td>
                                        <td>${caseItem.Case_Name}</td>
                                        <td>${caseItem.user ? caseItem.user.Fullname : 'Unknown'}</td>
                                        <td>${new Date(caseItem.created_at).toLocaleString()}</td>
                                        <td>
                                            <a href="#" class="btn btn-success text-white fw-bold px-4 py-2 shadow-lg fs-6 detail-btn" 
                                            data-case-no="${encodeURIComponent(caseItem.Case_No)}">
                                                <i class="mdi mdi-eye me-1"></i> Detail
                                            </a>
                                        </td>
                                    </tr>
                                `;
                            });
                        } else {
                            rows = `<tr><td colspan="6" class="text-center">No cases pending approval</td></tr>`;
                        }
    
                        $("tbody").html(rows);
    
                        $("#showingFrom").text(data.from || 0);
                        $("#showingTo").text(data.to || 0);
                        $("#totalEntries").text(data.total || 0);
                    },
                    error: function () {
                        console.error("Failed to fetch data.");
                    }
                });
            }
    
            // Sorting function
            $(".sortable").click(function () {
                let column = $(this).data("column");
                if (sortBy === column) {
                    sortOrder = sortOrder === "asc" ? "desc" : "asc"; 
                } else {
                    sortBy = column;
                    sortOrder = "asc"; 
                }
                fetchPendingCases();
            });
    
            setInterval(fetchPendingCases, 5000);
    
            fetchPendingCases();
        });

        $(document).on("click", ".detail-btn", function () {
            let caseNo = $(this).data("case-no");
            window.location.href = `/cases/${caseNo}`;
        });
    </script>


    
@endsection

