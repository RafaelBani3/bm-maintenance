@extends('layouts.Master')

@section('title', 'BM Maintenance')
@section('subtitle', 'Change Password')

@section('content')

  <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
    <div class="d-flex flex-column flex-column-fluid py-3 py-lg-6">
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-xxl">
                <div class="card">
                    <div class="card-header card-header-stretch">
                        <div class="card-title d-flex align-items-center">
                            <h3 class="fw-bold m-0 text-gray-800">@yield('title') - @yield('subtitle')</h3>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="tab-content">
                            <div id="kt_activity_today" class="card-body p-0 tab-pane fade show active">
                                <div id="kt_account_settings_profile_details" class="collapse show">

                                    <form method="POST" id="changePasswordForm" action="{{ route('password.change') }}" class="form">
                                        @csrf

                                        @if(session('success'))
                                            <div class="alert alert-success">{{ session('success') }}</div>
                                        @endif

                                        {{-- Current Password --}}
                                        <div class="mb-5">
                                            <label class="form-label required">Current Password</label>
                                            <div class="input-group">
                                                <input type="password" name="current_password" id="current_password"
                                                       class="form-control @error('current_password') is-invalid @enderror" required>
                                                <button type="button" class="btn btn-light" onclick="togglePassword('current_password')">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                            </div>
                                            @error('current_password') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                                        </div>

                                        {{-- New Password --}}
                                        <div class="mb-5">
                                            <label class="form-label required">New Password</label>
                                            <div class="input-group">
                                                <input type="password" name="new_password" id="new_password"
                                                       class="form-control @error('new_password') is-invalid @enderror" required
                                                       pattern="(?=.*[A-Z])(?=.*\d).{5,}" title="Minimal 5 karakter, 1 huruf besar, dan 1 angka">
                                                <button type="button" class="btn btn-light" onclick="togglePassword('new_password')">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                            </div>
                                            @error('new_password') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                                        </div>

                                        {{-- Confirm New Password --}}
                                        <div class="mb-5">
                                            <label class="form-label required">Confirm New Password</label>
                                            <div class="input-group">
                                                <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                                                       class="form-control" required>
                                                <button type="button" class="btn btn-light" onclick="togglePassword('new_password_confirmation')">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-end">
                                            <button type="button" class="btn btn-primary" onclick="confirmChange()">
                                                <i class="bi bi-save me-2"></i>Change Password
                                            </button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    function togglePassword(fieldId) {
        const field = document.getElementById(fieldId);
        if (field.type === "password") {
            field.type = "text";
        } else {
            field.type = "password";
        }
    }

    function confirmChange() {
        const form = document.getElementById('changePasswordForm');

        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to update your password?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, change it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(form.action, {
                    method: 'POST',
                    body: new FormData(form),
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.text())
                .then(html => {
                    if (html.includes('Password updated successfully')) {
                        Swal.fire('Success', 'Password changed successfully', 'success')
                        .then(() => window.location.reload());
                    } else {
                        Swal.fire('Error', 'Password update failed. Please check your current password.', 'error');
                    }
                })
                .catch(() => Swal.fire('Error', 'An error occurred. Please try again.', 'error'));
            }
        });
    }
</script>
@endsection
