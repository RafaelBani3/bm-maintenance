@extends('layouts.Master')

@section('title', 'BM Maintenance')
@section('subtitle', 'List Tecnician')

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
                                <button type="button" class="btn btn-sm btn-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#modalCreateTechnician">
                                    <i class="bi bi-plus-circle fs-5 me-2"></i> Add New Tecnician
                                </button>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="kt_datatable_horizontal_scroll" class="table table-striped table-row-bordered gy-5 gs-7">
                                    <thead>
                                        <tr class="fw-semibold fs-6 text-gray-800 text-nowrap">
                                            <th class="min-w-200px">Technician ID</th>
                                            <th class="min-w-200px">Technician Name</th>
                                            <th class="min-w-200px">Position</th>
                                            <th class="min-w-200px">Created At</th>
                                            <th class="min-w-150px text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($technicians as $tech)
                                            <tr>
                                                <td class="text-primary">{{ $tech->technician_id }}</td>
                                                <td>{{ $tech->technician_Name }}</td>
                                                <td>{{ $tech->position->PS_Name ?? '-' }}</td> 
                                                <td>{{ $tech->created_at->format('d-m-Y H:i') }}</td>
                                                <td class="text-center">
                                                    <button class="btn btn-sm btn-light-primary me-1" data-bs-toggle="tooltip" title="Edit"
                                                        onclick="edittechnician('{{ $tech->technician_id }}', '{{ $tech->technician_Name }}', '{{ $tech->PS_ID }}')">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </button>

                                                    <button class="btn btn-sm btn-light-danger btn-delete-technician"
                                                            data-id="{{ $tech->technician_id }}"
                                                            data-name="{{ $tech->technician_Name }}"
                                                            title="Delete">
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

                    <!-- Modal Create Technician -->
                    <div class="modal fade" id="modalCreateTechnician" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered mw-650px">
                            <form class="modal-content" method="POST" action="{{ route('SaveTechnician') }}">
                                @csrf
                                <div class="modal-header">
                                    <h2>Add New Technician</h2>
                                    <div class="btn btn-sm btn-icon btn-active-light-primary" data-bs-dismiss="modal">
                                        <i class="bi bi-x fs-2"></i>
                                    </div>
                                </div>

                                <div class="modal-body py-10 px-lg-17">
                                    <div class="mb-5">
                                        <label class="form-label">Technician Name</label>
                                        <input type="text" class="form-control" name="Technician_Name" required />
                                    </div>

                                    <!-- Select Position -->
                                    <div class="mb-5">
                                        <label class="form-label">Select Position</label>
                                        <select class="form-select" name="Position_ID" id="selectPosition" data-control="select2" data-placeholder="Select a Position" required>
                                            <option></option>
                                            @foreach($positions as $position)
                                                <option value="{{ $position->id }}">{{ $position->PS_Name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Modal Edit Technician -->
                    <div class="modal fade" id="edittechnician" tabindex="-1" aria-labelledby="modalEditTechnicianLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <form id="editTechnicianForm" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Technician</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="technician_id" id="edit_id">
                                        <div class="mb-3">
                                            <label for="edit_name" class="form-label">Technician Name</label>
                                            <input type="text" class="form-control" name="Technician_Name" id="edit_name" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Select Position</label>
                                            <select class="form-select" name="Position_ID" id="edit_position" data-control="select2" required>
                                                @foreach($positions as $position)
                                                    <option value="{{ $position->id }}">{{ $position->PS_Name }}</option>
                                                @endforeach
                                            </select>
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

    <script>
        $(function () {
            $('#kt_datatable_horizontal_scroll').DataTable({
                scrollX: true,
                pageLength: 10,
                language: {
                    search: "Search:",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ Technicians",
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#selectPosition').select2({
                dropdownParent: $('#modalCreateTechnician'),
                width: '100%',
                placeholder: "Select a Position",
                allowClear: true
            });
        });
    </script>

    {{-- Script Update Technician --}}
    <script>
        function edittechnician(id, name, positionId) {
            $('#edit_id').val(id);
            $('#edit_name').val(name);
            $('#edit_position').val(positionId).trigger('change');

            // Set action form-nya
            let updateUrl = "{{ route('UpdateTechnician', ['id' => '__id__']) }}".replace('__id__', id);
            $('#editTechnicianForm').attr('action', updateUrl);

            // Tampilkan modal
            $('#edittechnician').modal('show');
        }

        $(document).ready(function () {
            $('#edit_position').select2({
                dropdownParent: $('#edittechnician'),
                width: '100%',
                placeholder: "Select a Position"
            });
        });
    </script>

    {{-- Hapus Technician --}}
    <script>
        $(document).on('click', '.btn-delete-technician', function () {
            $('.btn-delete-technician').click(function () {
                const id = $(this).data('id');
                const name = $(this).data('name');
                const token = "{{ csrf_token() }}";

                let url = "{{ route('DeleteTechnician', ['id' => '__ID__']) }}";
                url = url.replace('__ID__', id);

                Swal.fire({
                    title: `Delete Technician "${name}"?`,
                    text: "This action cannot be canceled!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Delete',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: 'DELETE',
                            data: { _token: token },
                            success: function (response) {
                                if (response.status === 'success') {
                                    Swal.fire('Deleted!', response.message, 'success')
                                        .then(() => location.reload());
                                } else {
                                    Swal.fire(' Failed!', response.message, 'error');
                                }
                            },
                            error: function () {
                                Swal.fire('Failed!', 'Terjadi kesalahan saat menghapus.', 'error');
                            }
                        });
                    }
                });
            });
        });
    </script>



@endsection



