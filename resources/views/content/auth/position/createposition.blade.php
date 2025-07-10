@extends('layouts.Master')

@section('title', 'BM Maintenance')
@section('subtitle', 'Position List')

@section('content')

    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
        <div class="d-flex flex-column flex-column-fluid py-3 py-lg-6">
            <div id="kt_app_content" class="app-content flex-column-fluid">
                <div id="kt_app_content_container" class="app-container container-xxl">
                    
                    {{-- Table Department --}}
                    <div class="card">
                        <div class="card-header card-header-stretch justify-content-between align-items-center">
                            <div class="card-title d-flex align-items-center">
                                <h3 class="fw-bold m-0 text-gray-800">@yield('title') - Department</h3>
                            </div>

                            <div class=" d-flex align-items-center gap-5">
                                <!-- Search Input -->
                                <div class="col-lg-6">
                                    <input type="text" id="searchDepartment" class="form-control form-control-solid" placeholder="Enter keyword..." />
                                </div>

                                <div class="card-toolbar">
                                    <button type="button" class="btn btn-sm btn-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#modalCreateDepartment">
                                        <i class="bi bi-plus-circle fs-5 me-2"></i> Add New Department
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="kt_datatable_horizontal_scroll_departement" class="table table-striped table-row-bordered gy-5 gs-7">
                                    <thead>
                                        <tr class="fw-semibold fs-6 text-gray-800 text-nowrap">
                                            <th class="min-w-200px">Department No</th>
                                            <th class="min-w-300px">Department Name</th>
                                            <th class="min-w-300px">Department Code</th>
                                            <th class="min-w-150px">Created At</th>
                                            <th class="min-w-150px text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($departments as $dept)
                                            <tr>
                                                <td>{{ $dept->dept_no }}</td>
                                                <td>{{ $dept->dept_name }}</td>
                                                <td>{{ $dept->dept_desc }}</td>
                                                <td>{{ $dept->created_at}}</td>
                                                <td class="text-center">
                                                    <button class="btn btn-sm btn-light-primary me-1" data-bs-toggle="modal" title="Edit"
                                                            onclick="editDepartment('{{ $dept->dept_no }}', '{{ $dept->dept_name }}', '{{ $dept->dept_desc }}', '{{ $dept->dept_code }}')">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </button>

                                                    {{-- <form action="{{ route('DestroyDepartment', $dept->dept_no) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-light-danger" data-bs-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure to delete this department?')">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form> --}}
                                                    <form id="delete-dept-{{ $dept->dept_no }}" action="{{ route('DestroyDepartment', $dept->dept_no) }}" method="POST" style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>

                                                    <button type="button" class="btn btn-sm btn-light-danger" data-bs-toggle="tooltip" title="Delete"
                                                        onclick="confirmDeleteDepartment('{{ $dept->dept_no }}')">
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

                    <br>
                    <br>

                    {{-- Table Position --}}
                    <div class="card">
                        <div class="card-header card-header-stretch justify-content-between align-items-center">
                            <div class="card-title d-flex align-items-center">
                                <h3 class="fw-bold m-0 text-gray-800">@yield('title') - @yield('subtitle')</h3>
                            </div>

                            <div class=" d-flex align-items-center gap-5">
                                <!-- Search Input -->
                                <div class="col-lg-6">
                                    <input type="text" id="searchPosition" class="form-control form-control-solid" placeholder="Enter keyword..." />
                                </div>

                                <div class="card-toolbar">
                                    <button type="button" class="btn btn-sm btn-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#modalCreatePosition">
                                        <i class="bi bi-plus-circle fs-5 me-2"></i> Add New Position
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="kt_datatable_horizontal_scroll" class="table table-striped table-row-bordered gy-5 gs-7">
                                    <thead>
                                        <tr class="fw-semibold fs-6 text-gray-800 text-nowrap">
                                            <th class="min-w-200px">Position Name</th>
                                            <th class="min-w-300px">Description</th>
                                            <th class="min-w-300px">Department</th>
                                            <th class="min-w-150px">Created At</th>
                                            <th class="min-w-150px text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($positions as $pos)
                                            <tr>
                                                <td>{{ $pos->PS_Name }}</td>
                                                <td>{{ $pos->PS_Desc }}</td>
                                                <td>{{ $pos->department->dept_name ?? "-" }}</td>
                                                <td>{{ $pos->created_at}}</td>
                                                <td class="text-center">
                                                
                                                    <button class="btn btn-sm btn-light-primary me-1" data-bs-toggle="tooltip" title="Edit"
                                                            onclick="editPosition('{{ $pos->id }}', '{{ $pos->PS_Name }}', '{{ $pos->PS_Desc }}', '{{ $pos->dept_no }}')">
                                                       <i class="bi bi-pencil-square"></i>
                                                    </button>

                                                    <button class="btn btn-sm btn-light-danger" data-bs-toggle="tooltip" title="Delete" onclick="deletePosition('{{ route('DeletePosition', $pos->id) }}')">
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

                    <!-- Modal Create Position -->
                    <div class="modal fade" id="modalCreatePosition" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered mw-650px">
                            <form class="modal-content" method="POST" action="{{ route('SavePosition') }}">
                                @csrf
                                <div class="modal-header">
                                    <h2>Add New Position</h2>
                                    <div class="btn btn-sm btn-icon btn-active-light-primary" data-bs-dismiss="modal">
                                        <i class="bi bi-x fs-2"></i>
                                    </div>
                                </div>
                                <div class="modal-body py-10 px-lg-17">
                                    <div class="mb-5">
                                        <label class="form-label">Department</label>
                                        <select class="form-select" name="dept_no" id="deptSelect" required>
                                            <option value="">-- Select Department --</option>
                                            @foreach ($departments as $dept)
                                                <option value="{{ $dept->dept_no }}">{{ $dept->dept_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-5">
                                        <label class="form-label">Position Name</label>
                                        <input type="text" class="form-control" name="PS_Name" required />
                                    </div>
                                    <div class="mb-5">
                                        <label class="form-label">Description</label>
                                        <textarea class="form-control" name="PS_Desc" required></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- End Modal -->

                    {{-- MOodal Edit Position --}}
                    <div class="modal fade" id="modalEditPosition" tabindex="-1" aria-labelledby="modalEditPositionLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <form id="editPositionForm" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Position</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="id" id="edit_id">

                                        <div class="mb-3">
                                            <label for="edit_dept" class="form-label">Department</label>
                                            <select class="form-select" name="dept_no" id="edit_dept" required>
                                                <option value="">-- Select Department --</option>
                                                @foreach ($departments as $dept)
                                                    <option value="{{ $dept->dept_no }}">{{ $dept->dept_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label for="edit_name" class="form-label">Position Name</label>
                                            <input type="text" class="form-control" name="PS_Name" id="edit_name" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="edit_desc" class="form-label">Description</label>
                                            <input type="text" class="form-control" name="PS_Desc" id="edit_desc" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Modal Create Department -->
                    <div class="modal fade" id="modalCreateDepartment" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered mw-650px">
                            <form class="modal-content" method="POST" action="{{ route('SaveDepartment') }}">
                                @csrf
                                <div class="modal-header">
                                    <h5 class="modal-title">Add New Department</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>

                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="dept_name" class="form-label">Department Name</label>
                                        <input type="text" name="dept_name" id="dept_name" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="dept_desc" class="form-label">Department Description</label>
                                        <input type="text" name="dept_desc" id="dept_desc" class="form-control">
                                    </div>

                                    <div class="mb-3">
                                        <label for="dept_code" class="form-label">Department Code</label>
                                        <input type="text" name="dept_code" id="dept_code" class="form-control" required>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Create Department</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- End Modal -->

                    <!-- Modal Edit Department -->
                    <div class="modal fade" id="modalEditDepartment" tabindex="-1" aria-labelledby="modalEditDepartmentLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <form id="editDepartmentForm" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Department</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" id="edit_dept_no" name="dept_no">
                                        <div class="mb-3">
                                            <label for="edit_dept_name" class="form-label">Department Name</label>
                                            <input type="text" class="form-control" id="edit_dept_name" name="dept_name" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="edit_dept_desc" class="form-label">Department Description</label>
                                            <input type="text" class="form-control" id="edit_dept_desc" name="dept_desc">
                                        </div>
                                        <div class="mb-3">
                                            <label for="edit_dept_code" class="form-label">Department Code</label>
                                            <input type="text" class="form-control" id="edit_dept_code" name="dept_code" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>

    {{-- Modal Create Position --}}
    <script>
        $(document).ready(function () {
            $('#deptSelect').select2({
                dropdownParent: $('#modalCreatePosition'),
                width: '100%'
            });
        });
    </script>

    {{-- Modal Edit Position --}}
    <script>
        $(document).ready(function() {
            $('#edit_dept').select2({
                dropdownParent: $('#modalEditPosition') 
            });
        });
    </script>

    {{-- Script Table dan Atur Button--}}
    <script>
        function deletePosition(url) {
            Swal.fire({
                title: 'Delete this position?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!',
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.action = url;
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

        $(function () {
            const table = $('#kt_datatable_horizontal_scroll').DataTable({
                scrollX: true,
                pageLength: 10,
                order: [[3, "desc"]],
                language: {
                    search: "", 
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ positions",
                },
                dom: 'rtip' 
            });

            // External search binding
            $('#searchPosition').on('keyup', function () {
                table.search(this.value).draw();
            });
        });
    </script>

    {{-- Script untuk Update Data Position --}}
    <script>
        const routeUpdatePosition = "{{ route('UpdatePosition', ['id' => '__ID__']) }}";

        function editPosition(id, name, desc, dept_no) {
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_desc').value = desc;

            // Set department select
            const deptSelect = document.getElementById('edit_dept');
            deptSelect.value = dept_no;

            // Kalau pakai select2, trigger juga:
            $('#edit_dept').val(dept_no).trigger('change');

            const url = routeUpdatePosition.replace('__ID__', id);
            document.getElementById('editPositionForm').action = url;

            const modal = new bootstrap.Modal(document.getElementById('modalEditPosition'));
            modal.show();
        }

    </script>

    {{-- Table departement --}}
    <script>
        $(function () {
            const table = $('#kt_datatable_horizontal_scroll_departement').DataTable({
                scrollX: true,
                pageLength: 5,
                order: [[3, "desc"]],
                language: {
                    search: "", 
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ Departments",
                },
                dom: 'rtip' 
            });

            $('#searchPosition').on('keyup', function () {
                table.search(this.value).draw();
            });
        });
    </script>

    {{-- Script Modal Create Department --}}
    <script>
        const createModal = document.getElementById('modalCreateDepartment');
        createModal.addEventListener('hidden.bs.modal', function () {
            createModal.querySelector('form').reset();
        });
    </script>

    {{-- Edit Department --}}
    <script>
        const routeUpdateDepartment = "{{ route('UpdateDepartment', ['dept_no' => '__DEPTNO__']) }}";

        function editDepartment(dept_no, dept_name, dept_desc, dept_code) {
            document.getElementById('edit_dept_no').value = dept_no;
            document.getElementById('edit_dept_name').value = dept_name;
            document.getElementById('edit_dept_desc').value = dept_desc;
            document.getElementById('edit_dept_code').value = dept_code;

            const url = routeUpdateDepartment.replace('__DEPTNO__', dept_no);
            document.getElementById('editDepartmentForm').action = url;

            const modal = new bootstrap.Modal(document.getElementById('modalEditDepartment'));
            modal.show();
        }
    </script>

    {{-- Modal Delete Department --}}
    <script>
        function confirmDeleteDepartment(dept_no) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This action cannot be undone!",
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
                    document.getElementById('delete-dept-' + dept_no).submit();
                }
            });
        }
    </script>
@endsection



