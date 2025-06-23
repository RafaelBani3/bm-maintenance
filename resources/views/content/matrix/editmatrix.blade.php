@extends('layouts.Master')

@section('title', 'Matrix Management')
@section('subtitle', 'Edit Matrix')

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
                        <form method="POST" action="{{ route('UpdateMatrix', $matrix->Mat_No) }}">
                            @csrf
                            <div class="row mb-5">
                                <div class="col-md-6">
                                    <label class="form-label">Position</label>
                                    <select name="Position" class="form-select" data-control="select2" required>
                                        <option value="">-- Select Position --</option>
                                        @foreach ($positions as $pos)
                                            <option value="{{ $pos->id }}" {{ $matrix->Position == $pos->id ? 'selected' : '' }}>{{ $pos->PS_Name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Matrix Type</label>
                                    <select name="Mat_Type" id="matrixType" class="form-select" required>
                                        <option value="CR" {{ $matrix->Mat_Type == 'CR' ? 'selected' : '' }}>CR</option>
                                        <option value="MR" {{ $matrix->Mat_Type == 'MR' ? 'selected' : '' }}>MR</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-5">
                                <label class="form-label">Maximum Approval</label>
                                <input type="number" name="Mat_Max" id="matMax" class="form-control" value="{{ $matrix->Mat_Max }}" readonly />
                            </div>

                            <div class="row g-4 mb-5">
                                @for ($i = 1; $i <= 4; $i++)
                                    <div class="col-md-6" id="approver{{ $i }}">
                                        <label class="form-label">Approver {{ $i }}</label>
                                        <select name="AP{{ $i }}" class="form-select" data-control="select2">
                                            <option value="">-- Select --</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}" {{ $matrix->{'AP' . $i} == $user->id ? 'selected' : '' }}>
                                                    {{ $user->Fullname }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endfor
                            </div>

                            <div class="text-end">
                                <a href="{{ route('CreateNewMatrix') }}" class="btn btn-light me-2">Cancel</a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save"></i> Update
                                </button>
                            </div>
                        </form>
                    </div> <!-- end card-body -->
                </div> <!-- end card -->

            </div>
        </div>
    </div>
</div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const typeSelect = document.getElementById("matrixType");
            const maxInput = document.getElementById("matMax");

            function updateFields() {
                const type = typeSelect.value;
                if (type === 'CR') {
                    maxInput.value = 2;
                    maxInput.readOnly = true;
                    $('#approver3, #approver4').hide();
                } else if (type === 'MR') {
                    maxInput.value = 4;
                    maxInput.readOnly = true;
                    $('#approver3, #approver4').show();
                } else {
                    maxInput.value = '';
                    maxInput.readOnly = false;
                    $('#approver3, #approver4').hide();
                }
            }

            typeSelect.addEventListener('change', updateFields);
            updateFields();

            if (typeof $ !== 'undefined') {
                $('[data-control="select2"]').select2({
                    width: '100%',
                    dropdownParent: $('#kt_app_main')
                });
            }
        });
    </script>
@endsection
