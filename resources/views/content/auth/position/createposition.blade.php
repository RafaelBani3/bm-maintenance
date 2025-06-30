@extends('layouts.Master')

@section('title', 'BM Maintenance')
@section('subtitle', 'List Users')

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
                                <button type="button" class="btn btn-sm btn-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#modalCreatePosition">
                                    <i class="bi bi-plus-circle fs-5 me-2"></i> Add New Position
                                </button>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="kt_datatable_horizontal_scroll" class="table table-striped table-row-bordered gy-5 gs-7">
                                    <thead>
                                        <tr class="fw-semibold fs-6 text-gray-800 text-nowrap">
                                            <th class="min-w-200px">Position Name</th>
                                            <th class="min-w-300px">Description</th>
                                            <th class="min-w-150px">Created At</th>
                                            <th class="min-w-150px text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($positions as $pos)
                                            <tr>
                                                <td>{{ $pos->PS_Name }}</td>
                                                <td>{{ $pos->PS_Desc }}</td>
                                                <td>{{ $pos->created_at}}</td>
                                                <td class="text-center">
                                                    <button class="btn btn-sm btn-light-primary me-1" data-bs-toggle="tooltip" title="Edit"
                                                        onclick="editPosition({{ $pos->id }}, '{{ $pos->PS_Name }}', '{{ $pos->PS_Desc }}')">
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

                    <!-- Modal Create -->
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

                    {{-- MOodal Edit --}}
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
            

                </div>
            </div>
        </div>
    </div>

    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>

    {{-- <!-- DataTables Init -->
    <script>
        $(document).ready(function () {
            $('#kt_datatable_horizontal_scroll').DataTable({
                "scrollX": true,
                "pageLength": 10,
                "language": {
                    "search": "Search User:",
                    "lengthMenu": "Show _MENU_ entries",
                    "info": "Showing _START_ to _END_ of _TOTAL_ users",
                }
            });
        });
    </script> --}}

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
            $('#kt_datatable_horizontal_scroll').DataTable({
                scrollX: true,
                pageLength: 10,
                language: {
                    search: "Search:",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ positions",
                }
            });
        });
    </script>

    {{-- Script untuk Update Data Position --}}
    <script>
        const routeUpdatePosition = "{{ route('UpdatePosition', ['id' => '__ID__']) }}";

        function editPosition(id, name, desc) {
            // Set form values
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_desc').value = desc;

            // Replace placeholder ID in route URL
            const url = routeUpdatePosition.replace('__ID__', id);

            // Set action
            document.getElementById('editPositionForm').action = url;

            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('modalEditPosition'));
            modal.show();
        }
    </script>


@endsection



