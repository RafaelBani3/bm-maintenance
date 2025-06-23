@extends('layouts.Master')

@section('title', 'BM Maintenance')
@section('subtitle', 'Create New Users')

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
                            <button type="button" class="btn btn-sm btn-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#modalCreateUser">
                                <i class="bi bi-plus-circle fs-5 me-2"></i> Add New User
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="kt_datatable_horizontal_scroll" class="table table-striped table-row-bordered gy-5 gs-7">
                                <thead>
                                    <tr class="fw-semibold fs-6 text-gray-800 text-nowrap">
                                        <th class="min-w-200px">Fullname</th>
                                        <th class="min-w-150px">Username</th>
                                        <th class="min-w-200px">Position</th>
                                        <th class="min-w-200px">Roles</th>
                                        <th class="min-w-150px">Created At</th>
                                        <th class="min-w-150px text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{ $user->Fullname }}</td>
                                            <td>{{ $user->Username }}</td>
                                            <td>{{ $user->position->PS_Name ?? '-' }}</td>
                                            <td>
                                                @foreach ($user->getRoleNames() as $role)
                                                    <span class="badge bg-light-success text-success fs-7">{{ strtoupper($role) }}</span>
                                                @endforeach
                                            </td>
                                            <td>{{ $user->created_at->format('d M Y') }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('EditUser', $user->id) }}" class="btn btn-sm btn-light-primary">
                                                    <i class="bi bi-pencil-square"></i> Edit
                                                </a>
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


    {{-- Modal --}}
    <div class="modal fade" id="modalCreateUser" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content shadow-lg">
                <form action="{{ route('SaveNewUser') }}" method="POST">
                    @csrf
                    <div class="modal-header border-0 pb-0">
                        <h2 class="fw-bold text-primary">👤 Add New User</h2>
                        <button type="button" class="btn btn-sm btn-icon btn-light" data-bs-dismiss="modal" aria-label="Close">
                            <i class="ki-duotone ki-cross fs-2 text-danger">
                                <span class="path1"></span><span class="path2"></span>
                            </i>
                        </button>
                    </div>

                    <div class="modal-body py-5 px-lg-10">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Full Name</label>
                                <input type="text" name="Fullname" class="form-control form-control-solid" placeholder="Enter full name" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Username</label>
                                <input type="text" name="Username" class="form-control form-control-solid" placeholder="Unique username" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Password 
                                    <span class="text-muted fw-normal fs-8">(Leave empty for default: admin123)</span>
                                </label>
                                <input type="password" name="Password" class="form-control form-control-solid" placeholder="Optional">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Position</label>
                                <select name="PS_ID" class="form-select form-select-solid" required>
                                    <option value="">-- Select Position --</option>
                                    @foreach ($positions as $position)
                                        <option value="{{ $position->id }}">{{ $position->PS_Name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold mb-2">Assign Roles</label>
                                <div class="d-flex flex-wrap gap-3">
                                    @foreach ($roles as $role)
                                        <div class="form-check form-check-custom form-check-solid">
                                            <input class="btn-check" type="checkbox" name="roles[]" value="{{ $role->name }}" id="role_{{ $loop->index }}">
                                            <label class="btn btn-outline btn-outline-dashed btn-active-primary" for="role_{{ $loop->index }}">
                                                {{ strtoupper($role->name) }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="form-text mt-1">Click to select one or more roles</div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-1"></i> Save User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
      

    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>

    <!-- DataTables Init -->
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
    </script>
@endsection



