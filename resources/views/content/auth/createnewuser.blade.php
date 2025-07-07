@extends('layouts.Master')

@section('title', 'BM Maintenance')
@section('subtitle', 'Users List')

@section('content')
<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
    <div class="d-flex flex-column flex-column-fluid py-3 py-lg-6">
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-xxl">

                <!--begin::Navbar-->
                <div class="card mb-5 mb-xl-10">
                    <div class="card-header card-header-stretch">
                        <!--begin::Title-->
                        <div class="card-title d-flex align-items-center">
                            <h3 class="fw-bold m-0 text-gray-800">Filter</h3>
                        </div>
                        <!--end::Title-->
                    </div>
            
                    {{-- Filter --}}
                    <div class="card-body">
                        <div class="row g-5 align-items-end">
                            <!-- Search Input -->
                            <div class="col-lg-6">
                                <label class="form-label fw-bold">Search Fullname / Username</label>
                                <input type="text" id="searchReport" class="form-control form-control-solid" placeholder="Enter keyword..." />
                            </div>

                            <!-- Position Filter -->
                            <div class="col-lg-4">
                                <label class="form-label fw-bold">Filter by Position</label>
                                <select id="statusFilter" class="form-select form-select-solid">
                                    <option value="">All Positions</option>
                                    @foreach ($positions as $position)
                                        <option value="{{ $position->PS_Name }}">{{ $position->PS_Name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            

                            <!-- Apply Button -->
                            <div class="col-lg-2">
                                <label class="form-label fw-bold text-white">.</label>
                                <button id="applyFilter" class="btn btn-primary w-100">
                                    <i class="fa-solid fa-filter me-1"></i> Apply
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Filter --}}
                </div>
                <!--end::Navbar-->

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
                                            <td data-order="{{ $user->created_at }}">{{ $user->created_at->format('d M Y') }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('EditUser', $user->id) }}" class="btn btn-sm btn-light-primary me-1" data-bs-toggle="tooltip" title="Edit">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>

                                                <button class="btn btn-sm btn-light-danger" data-bs-toggle="tooltip" title="Delete"
                                                    onclick="deleteUser('{{ route('DeleteUser', $user->id) }}')">
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

    {{-- Page Loader --}}
    <div id="page_loader" class="page-loader flex-column bg-dark bg-opacity-25" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 9999; align-items: center; justify-content: center;">
        <span class="spinner-border text-primary" role="status"></span>
        <span class="text-white-800 fs-6 fw-semibold mt-5 text-white">Loading...</span>
    </div>

    <script>
        function deleteUser(deleteUrl) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This user will be permanently deleted. This action cannot be undone!",
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
                    // Submit via form
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

        // Inisialisasi Tooltip
        document.addEventListener('DOMContentLoaded', function () {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>

    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>

    <!-- DataTables Init -->
    <script>
        let table;

        $(function () {
            if ($.fn.DataTable.isDataTable('#kt_datatable_horizontal_scroll')) {
                $('#kt_datatable_horizontal_scroll').DataTable().destroy();
            }

            $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                const keyword = $('#searchReport').val().toLowerCase();
                const position = $('#statusFilter').val().toLowerCase();

                const fullname = data[0].toLowerCase(); // Fullname column
                const username = data[1].toLowerCase(); // Username column
                const positionData = data[2].toLowerCase(); // Position column

                const keywordMatch = keyword === '' || fullname.includes(keyword) || username.includes(keyword);

                const positionMatch = position === '' || positionData === position;

                return keywordMatch && positionMatch;
            });

            table = $('#kt_datatable_horizontal_scroll').DataTable({
                scrollX: true,
                pageLength: 10,
                order: [[4, "desc"]],
                language: {
                    search: "Search:",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ positions",
                    emptyTable: "" 
                }
            });

            $('#applyFilter').on('click', function () {
                $('#page_loader').css('display', 'flex');

                setTimeout(function () {
                    table.draw();  

                    const info = table.page.info();
                    if (info.recordsDisplay === 0) {
                        if (!$('.no-data-row').length) {
                            const noDataRowHtml = `<tr class="no-data-row">
                                <td colspan="6" style="text-align:center; font-style: italic; color: #6c757d;">
                                </td>
                            </tr>`;
                            $('#kt_datatable_horizontal_scroll tbody').append(noDataRowHtml);
                        }
                    } else {
                        $('.no-data-row').remove();
                    }

                    $('#page_loader').css('display', 'none');
                }, 300);
            });
        });
    </script>

    {{-- SweetAlert Popups --}}
    @if(session('duplicate_user'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Ducplicate User!',
                text: 'User dengan Username dan Posisi tersebut sudah ada.',
                confirmButtonText: 'OK',
            });
        </script>
    @endif

    @if(session('validation_error'))
        @if ($errors->any())
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Validasi Gagal!',
                    html: `{!! implode('<br>', $errors->all()) !!}`,
                    confirmButtonText: 'OK',
                });
            </script>
        @endif
    @endif

@endsection



