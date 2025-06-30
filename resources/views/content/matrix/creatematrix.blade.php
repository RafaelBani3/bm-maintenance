@extends('layouts.Master')

@section('title', 'BM Maintenance')
@section('subtitle', 'Matrix List')

@section('content')

    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
        <div class="d-flex flex-column flex-column-fluid py-3 py-lg-6">
            <div id="kt_app_content" class="app-content flex-column-fluid">
                <div id="kt_app_content_container" class="app-container container-xxl">

                    <div class="card">
                        <div class="card-header card-header-stretch justify-content-between align-items-center">
                            <div class="card-title d-flex align-items-center">
                                <h3 class="fw-bold m-0 text-gray-800">@yield('title') - @yield('subtitle')</h3>
                            </div>

                            <div class="card-toolbar">
                                <button type="button" class="btn btn-sm btn-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#modalCreateMatrix">
                                    <i class="bi bi-plus-circle fs-5 me-2"></i> Add New Matrix
                                </button>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="kt_datatable_horizontal_scroll" class="table table-striped table-row-bordered gy-5 gs-7">
                                    <thead>
                                        <tr class="fw-semibold fs-6 text-gray-800 text-nowrap">
                                            <th class="min-w-100px">Mat No</th>
                                            <th class="min-w-150px">Position ID</th>
                                            <th class="min-w-150px">Position</th>
                                            <th class="min-w-100px">Type</th>
                                            <th class="min-w-100px">Max</th>
                                            <th class="min-w-300px">Approver 1</th>
                                            <th class="min-w-300px">Approver 2</th>
                                            <th class="min-w-300px">Approver 3</th>
                                            <th class="min-w-300px">Approver 4</th>
                                            <th class="min-w-300px">Approver 5</th>
                                            <th class="min-w-150px">Created At</th>
                                            <th class="min-w-150px text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($matrices as $matrix)
                                            <tr>
                                                <td>{{ $matrix->Mat_No }}</td>
                                                <td>{{ $matrix->Position }}</td>
                                                <td>{{ $matrix->position->PS_Name }}</td>
                                                <td>
                                                    <span class="badge 
                                                        {{ $matrix->Mat_Type === 'CR' ? 'bg-info text-white' : '' }}
                                                        {{ $matrix->Mat_Type === 'MR' ? 'bg-success text-white' : '' }}
                                                        {{ $matrix->Mat_Type === 'WO' ? 'bg-warning text-dark' : '' }}
                                                    ">
                                                        {{ $matrix->Mat_Type }}
                                                    </span>
                                                </td>
                                                <td>{{ $matrix->Mat_Max }}</td>
                                                <td>
                                                    {{ $matrix->approver1?->Fullname ?? '-' }}
                                                </td>
                                                <td>
                                                    {{ $matrix->approver2?->Fullname ?? '-' }}
                                                </td>
                                                <td>
                                                    {{ $matrix->approver3?->Fullname ?? '-' }}
                                                </td>
                                                <td>
                                                    {{ $matrix->approver4?->Fullname ?? '-' }}
                                                </td>
                                                <td>
                                                    {{ $matrix->approver5?->Fullname ?? '-' }}
                                                </td>

                                                <td>{{ $matrix->created_at->format('d M Y') }}</td>
                                                {{-- <td class="text-center">
                                                    <a href="{{ route('EditMatrix', $matrix->Mat_No) }}" class="btn btn-sm btn-light-primary">
                                                        <i class="bi bi-pencil-square"></i> Edit
                                                    </a>
                                                </td> --}}
                                                <td class="text-center">
                                                    <a href="{{ route('EditMatrix', $matrix->Mat_No) }}" class="btn btn-sm btn-light-primary me-1" data-bs-toggle="tooltip" title="Edit">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </a>

                                                    <button class="btn btn-sm btn-light-danger" data-bs-toggle="tooltip" title="Delete"
                                                        onclick="deleteMatrix('{{ route('DeleteMatrix', $matrix->Mat_No) }}')">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Create Matrix --}}
    <div class="modal fade" id="modalCreateMatrix" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content shadow-lg">
                <form action="{{ route('SaveMatrix') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h2 class="fw-bold">Add New Matrix</h2>
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal">
                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                    </div>

                    <div class="modal-body py-5 px-lg-10">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Position</label>
                                <select name="Position" class="form-select" data-control="select2" data-placeholder="Select Position" required>
                                    <option></option>
                                    @foreach ($positions as $position)
                                        <option value="{{ $position->id }}">{{ $position->PS_Name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Matrix Type</label>
                                <select name="Mat_Type" class="form-select" id="matrixType" required>
                                    <option value="">-- Select Type --</option>
                                    <option value="CR">CR/WO</option>
                                    <option value="MR">MR</option>
                                </select>
                            </div>
                        </div>

                        {{-- <div class="mb-3">
                            <label class="form-label">Maximum Approval</label>
                            <input type="number" name="Mat_Max" id="maxApproval" class="form-control" required />
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Approvers</label>
                            <div class="row g-2">
                                @for ($i = 1; $i <= 5; $i++)
                                    <div class="col-md-6" id="approver{{ $i }}">
                                        <select name="AP{{ $i }}" class="form-select" data-control="select2">
                                            <option value="">-- Select Approver {{ $i }} --</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->Fullname }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endfor

                            </div>
                        </div> --}}

                        <div class="mb-3">
                            <label class="form-label">Maximum Approval <small class="text-muted">You Can Custom Maximum Approval</small></label>
                            <input type="number" name="Mat_Max" id="maxApproval" class="form-control" min="1" max="5" required />
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Approvers</label>
                            <div class="row g-2" id="approversContainer">
                                @for ($i = 1; $i <= 5; $i++)
                                    <div class="col-md-6 approver-select" id="approver{{ $i }}">
                                        <select name="AP{{ $i }}" class="form-select" data-control="select2">
                                            <option value="">-- Select Approver {{ $i }} --</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->Fullname }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endfor
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-1"></i> Save Matrix
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>

    {{-- Script Table --}}
    <script>
        $(document).ready(function () {
            $('#kt_datatable_horizontal_scroll').DataTable({
                "scrollX": true,
                "pageLength": 10,
                "fixedColumns" : {
                    "left": "2",
                    "right": "1",
                },
                "language": {
                    "search": "Search Matrix:",
                    "lengthMenu": "Show _MENU_ entries",
                    "info": "Showing _START_ to _END_ of _TOTAL_ matrices",
                },
                
            });
        });
    </script>

    {{-- Script Modal Add Matrix --}}
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const matrixType = document.getElementById('matrixType');
            const maxApprovalInput = document.getElementById('maxApproval');
            const approverContainer = document.getElementById('approversContainer');

            function updateApproverFieldsFromMax() {
                const maxVal = parseInt(maxApprovalInput.value) || 0;
                for (let i = 1; i <= 5; i++) {
                    const approverDiv = document.getElementById(`approver${i}`);
                    approverDiv.style.display = i <= maxVal ? 'block' : 'none';
                }
            }

            function handleMatrixTypeChange() {
                const type = matrixType.value;
                if (type === 'CR') {
                    maxApprovalInput.value = 2;
                } else if (type === 'MR') {
                    maxApprovalInput.value = 4;
                } else {
                    maxApprovalInput.value = '';
                }
                maxApprovalInput.readOnly = false;
                updateApproverFieldsFromMax();
            }

            matrixType.addEventListener('change', handleMatrixTypeChange);
            maxApprovalInput.addEventListener('input', updateApproverFieldsFromMax);

            // Init Select2
            if (typeof $ !== 'undefined') {
                $('[data-control="select2"]').select2({
                    dropdownParent: $('#modalCreateMatrix'),
                    width: '100%'
                });
            }

            // Initial Setup
            handleMatrixTypeChange();
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const maxApprovalInput = document.getElementById('maxApproval');

            function updateApproverFieldsFromMax() {
                const maxVal = parseInt(maxApprovalInput.value) || 0;
                for (let i = 1; i <= 5; i++) {
                    const approverDiv = document.getElementById(`approver${i}`);
                    if (approverDiv) {
                        approverDiv.style.display = i <= maxVal ? 'block' : 'none';
                    }
                }
            }

            maxApprovalInput.addEventListener('input', updateApproverFieldsFromMax);

            $('#modalCreateMatrix').on('shown.bs.modal', function () {
                $('[data-control="select2"]').select2({
                    dropdownParent: $('#modalCreateMatrix'),
                    width: '100%'
                });

                updateApproverFieldsFromMax(); 
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function deleteMatrix(deleteUrl) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This matrix will be permanently deleted. This action cannot be undone!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!',
            customClass: {
                confirmButton: 'btn btn-danger',
                cancelButton: 'btn btn-secondary'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                // Kirim form DELETE manual
                const form = document.createElement('form');
                form.action = deleteUrl;
                form.method = 'POST';

                const csrf = document.createElement('input');
                csrf.type = 'hidden';
                csrf.name = '_token';
                csrf.value = '{{ csrf_token() }}';

                const method = document.createElement('input');
                method.type = 'hidden';
                method.name = '_method';
                method.value = 'DELETE';

                form.appendChild(csrf);
                form.appendChild(method);
                document.body.appendChild(form);
                form.submit();
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>




@endsection

