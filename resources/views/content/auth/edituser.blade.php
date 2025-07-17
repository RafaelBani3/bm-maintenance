@extends('layouts.Master')

@section('title', 'BM Maintenance')
@section('subtitle', 'Edit User')

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
                        </div>

                        <div class="card-body">
                            <form action="{{ route('UpdateUser', $user->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label class="form-label">Fullname</label>
                                    <input type="text" name="Fullname" class="form-control" value="{{ $user->Fullname }}" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Username</label>
                                    <input type="text" name="Username" class="form-control" value="{{ $user->Username }}" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Position</label>
                                    <select name="Position" class="form-select" data-control="select2" data-placeholder="Select Position">
                                        <option></option>
                                        @foreach($positions as $position)
                                            <option value="{{ $position->id }}" 
                                                @if(old('Position', $user->PS_ID) == $position->id) selected @endif>
                                                {{ $position->PS_Name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>


                                <div class="mb-3">
                                    <label class="form-label">Roles</label>
                                    <select name="roles[]" class="form-select" multiple data-control="select2" data-placeholder="Select Roles">
                                        @foreach($roles as $role)
                                            <option value="{{ $role->name }}" {{ $user->roles->contains('name', $role->name) ? 'selected' : '' }}>
                                                {{ strtoupper($role->name) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-save"></i> Update User
                                    </button>
                                </div>
                            </form>
                               
                            {{-- Reset Password --}}
                            <div class="text-end mt-4">
                                <button type="button" class="btn btn-warning" id="resetPasswordBtn">
                                    <i class="bi bi-key"></i> Reset Password
                                </button>

                                <form id="resetPasswordForm" action="{{ route('ResetUserPassword', $user->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('PUT')
                                </form>
                            </div>

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- Reset Password --}}
    <script>
        document.getElementById('resetPasswordBtn').addEventListener('click', function () {
            Swal.fire({
                title: 'Reset Password?',
                text: 'Are you sure you want to reset this user\'s password to "admin123"?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, reset it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('resetPasswordForm').submit();
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('[data-control="select2"]').select2({
                dropdownParent: $('#kt_app_content_container'),
                width: '100%'
            });
        });
    </script>

@endsection
