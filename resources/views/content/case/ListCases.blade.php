@extends('layouts.Master')

@section('title', 'List Cases Reports')
@section('subtitle', 'View Case')

@section('content')
    @include('layouts.partial.breadcrumbs')

    {{-- Table BA/CR/Cases --}}
    <div class="table-responsive mt-5">
        <div class="card shadow-sm">
            <div class="card-header text-white" style="background-color:crimson ">
                <h4 class="mb-0" style="padding: 20px 20px 20px 0" >Cases List</h4>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-responsive table-bordered table-hover" id="casesTable">
                    <thead class="table-dark text-center">
                        <tr>
                            <th><input type="checkbox" id="selectAll" style="width: 22px; height: 22px;"></th>
                            <th>Case No</th>
                            <th>Case Name</th>
                            <th>Case Date</th>
                            <th>Case Category</th>
                            <th>Created By</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            fetchCases();
            setInterval(fetchCases, 5000);

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
                            <td class="text-center"><input type="checkbox" class="caseCheckbox" style="width: 22px; height: 22px;"></td>
                            <td class="text-center">${caseItem.Case_No}</td>
                            <td class="text-center">${caseItem.Case_Name}</td>
                            <td class="text-center">${caseItem.Case_Date}</td>
                            <td class="text-center">${caseItem.Category}</td>
                            <td class="text-center">${caseItem.User}</td>


                            <td class="text-center"><button class="btn btn-primary">View</button></td>
                        </tr>`;
                    });
                    document.querySelector('#casesTable tbody').innerHTML = tableBody;
                });
        }
    </script>
    
@endsection