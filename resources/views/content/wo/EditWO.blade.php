@extends('layouts.Master')

@section('title', 'Work Order Management')
@section('subtitle', 'Edit New Work Order')

@section('content')

    <div id="app_content" class="app-content flex-column-fluid">
        <div id="app_content_container" class="app-container container-fluid">
            <div class="card shadow-sm rounded-3 border-0">
                <div class="card-header text-white py-5 mb-2 text-center">
                    <h3 class="fw-bold m-0 mt-3">@yield('title') - @yield('subtitle')</h3>
                </div>

                <div id="work_order_form" class="card-body p-5">
                    <form id="kt_docs_formvalidation_text" enctype="multipart/form-data" method="POST">
                        @csrf
                        <input type="hidden" name="wo_no" value="{{ $wo->WO_No }}">                    
                        
                        <!-- Reference Number -->
                        <div class="fv-row mb-3">
                            <label class="form-label fw-semibold">Reference No.</label>
                            <div class="d-flex gap-5">
                                <select class="form-select form-select-lg form-select-solid flex-grow-1" 
                                    id="reference_number" name="reference_number" data-control="select2" 
                                    data-placeholder="Select Reference">
                                    <option value="{{ $case->Case_No }}" selected>{{ $case->Case_No }}</option>
                                </select>

                                <button type="button" class="btn btn-info" style="height: 45px; width: 150px;" id="btnViewDetails">
                                    View Details
                                </button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="fv-row col-md-6 mb-3">
                                <label class="form-label fw-semibold">Created By</label>
                                <input type="text" id="created_by" name="created_by" class="form-control form-control-solid" 
                                value="{{ $case->user->Fullname }}" disabled />
                            </div>
                            <div class="fv-row col-md-6 mb-3">
                                <label class="form-label fw-semibold">Departement</label>
                                <input type="text" id="department" name="department" class="form-control form-control-solid" 
                                     value="{{ $case->user->position->PS_Name }}" disabled />

                            </div>
                        </div>
                    
                        <div class="fv-row mb-3">
                            <label class="form-label fw-semibold">Date</label>
                            <input type="text" id="date" name="date" class="form-control form-control-solid" 
                                value="{{ $case->created_at->format('d-m-Y') }}" disabled />
                        </div>
                    
                        <hr>

                        <div class="mb-10">
                            <label for="start_date" class="form-label fw-semibold">Start Date</label>
                            <input class="form-control" id="start_date" name="start_date" placeholder="Pick a date" value="{{ old('start_date', $wo->WO_Start) }}" />
                        </div>
                        
                        <div class="mb-10">
                            <label for="end_date" class="form-label fw-semibold">End Date</label>
                            <input class="form-control" id="end_date" name="end_date" placeholder="Pick a date" value="{{ old('end_date', $wo->WO_End) }}" />
                        </div>
                        

                        {{-- Assigned To --}}
                        <div class="fv-row mb-3">
                            <label class="form-label fw-semibold">Assigned To</label>
                            <select class="form-select form-select-sm form-select-solid" name="assigned_to[]" data-control="select2" data-close-on-select="false" data-placeholder="Select an option" data-allow-clear="true" multiple="multiple">
                                <option></option>
                                <option value="1">1 - Kevin Hartono</option>
                                <option value="2">2 - Maria Lestari</option>
                                <option value="3">3 - Daniel Nugroho</option>
                                <option value="4">4 - Sarah Putri</option>
                                <option value="5">5 - Ahmad Rizky</option>
                                <option value="6">6 - Clara Wijaya</option>
                                <option value="7">7 - Budi Santoso</option>
                                <option value="8">8 - Vina Maharani</option>
                            </select>
                        </div>

                    
                        <div class="fv-row mb-3">
                            <label class="form-label fw-semibold">Work Description</label>
                            <textarea name="work_description" class="form-control form-control-solid" rows="4" 
                                placeholder="Describe the work...">{{ old('work_description', $wo->WO_Narative) }}</textarea>

                        </div>
                    
                        <!-- Material Request Checkbox -->
                        <div class="fv-row mb-10">
                            <label class="fw-semibold fs-6 mb-3">Do you require a Material Request?</label>
                            <div class="form-check form-check-custom form-check-solid">
                                <input class="form-check-input me-3" name="require_material" type="checkbox" 
                                value="yes" id="require_material_checkbox" {{ $wo->WO_NeedMat == 'Y' ? 'checked' : '' }} />
                            
                                <label class="form-check-label" for="require_material_checkbox">
                                    <div class="fw-semibold text-gray-800">Yes, I need materials for this work</div>
                                </label>
                            </div>
                        </div>
                    
                        <!-- Submit Button -->
                        <div class="text-end mt-4">
                            <button type="submit" class="btn btn-lg btn-primary shadow-sm px-5" id="kt_docs_formvalidation_text_submit">
                                Update Work Order
                            </button>
                        </div>
                    </form>                    
                </div>
            </div>
        </div>
    </div>

    
    <script>
        $("#start_date").flatpickr();
        $("#end_date").flatpickr();

    </script>

    <!-- Page Loader -->
    <div class="page-loader flex-column bg-dark bg-opacity-25" style="display:none;">
        <span class="spinner-border text-primary" role="status"></span>
        <span class="text-gray-800 fs-6 fw-semibold mt-5">Loading...</span>
    </div>

    <script>
        $(document).ready(function () {
            $('#kt_docs_formvalidation_text').on('submit', function (e) {
                e.preventDefault();

                let isValid = true;
                const requiredFields = ['#reference_number', '#start_date', '#end_date', 'textarea[name="work_description"]'];

                requiredFields.forEach(function (selector) {
                    if (!$(selector).val()) {
                        isValid = false;
                        $(selector).addClass('is-invalid');
                    } else {
                        $(selector).removeClass('is-invalid');
                    }
                });

                if (!isValid) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Please fill all required fields.'
                    });
                    return;
                }

                const loadingEl = document.createElement("div");
                document.body.prepend(loadingEl);
                loadingEl.classList.add("page-loader", "flex-column", "bg-dark", "bg-opacity-25");
                loadingEl.innerHTML = `
                        <span class="spinner-border text-primary" role="status"></span>
                        <span class="text-gray-800 fs-6 fw-semibold mt-5">Loading...</span>
                    `;

                KTApp.showPageLoading();

                setTimeout(() => {
                    $.ajax({
                        url: "{{ route('WorkOrder.Update') }}",
                        type: "POST",
                        data: $(this).serialize(),
                        success: function (response) {
                            KTApp.hidePageLoading();  
                            loadingEl.remove();
                            
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success!',
                                    text: response.message
                                }).then(() => {
                                    window.location.href = "/Work-Order/Create";
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Failed!',
                                    text: response.message
                                });
                            }
                        },
                        error: function (xhr) {
                            KTApp.hidePageLoading();  
                            loadingEl.remove();  
                            
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: xhr.responseJSON?.message || 'Something went wrong.'
                            });
                        }
                    });
                }, 3000); 
            });
        });
    </script>

    
@endsection
