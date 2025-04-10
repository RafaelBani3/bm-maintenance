@extends('layouts.Master')

@section('title', 'Work Order Management')
@section('subtitle', 'Create New Work Order')

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
                    
                        <!-- Reference Number -->
                        <div class="fv-row mb-5">
                            <label class="form-label fw-semibold">Reference No.</label>
                            <div class="d-flex gap-5">
                                <select class="form-select form-select-lg form-select-solid flex-grow-1" 
                                    id="reference_number" name="reference_number" data-control="select2" 
                                    data-placeholder="Select Reference">
                                    <option></option>
                                </select>
                                <button type="button" class="btn btn-info" style="height: 45px; width: 150px;" id="btnViewDetails">
                                    View Details
                                </button>
                            </div>
                        </div>
                    
                        <div class="row">
                            <div class="fv-row col-md-6 mb-5">
                                <label class="form-label fw-semibold">Created By</label>
                                <input type="text" id="created_by" name="created_by" class="form-control form-control-solid" value="" disabled />
                            </div>
                            <div class="fv-row col-md-6 mb-3">
                                <label class="form-label fw-semibold">Departement</label>
                                <input type="text" id="department" name="department" class="form-control form-control-solid" value="" disabled />
                            </div>
                        </div>
                    
                        <div class="fv-row mb-5">
                            <label class="form-label fw-semibold">Date</label>
                            <input type="text" id="date" name="date" class="form-control form-control-solid" value="" disabled />
                        </div>
                    
                        <hr>
                    
                        <div class="fv-row mb-5">
                            <label class="form-label fw-semibold">Start Date</label>
                            <input class="form-control form-control-solid" id="start_date" name="start_date" placeholder="Pick a date" />
                        </div>
                        
                        <div class="fv-row mb-5">
                            <label class="form-label fw-semibold">End Date</label>
                            <input class="form-control form-control-solid" id="end_date" name="end_date" placeholder="Pick a date" />
                        </div>

                        {{-- Assigned To --}}
                        <div class="fv-row mb-5">
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

                    
                        <div class="fv-row mb-5">
                            <label class="form-label fw-semibold">Work Description</label>
                            <textarea name="work_description" class="form-control form-control-solid" rows="4" placeholder="Describe the work..."></textarea>
                        </div>
                    
                        <!-- Material Request Checkbox -->
                        <div class="fv-row mb-10">
                            <label class="fw-semibold fs-6 mb-3">Do you require a Material Request?</label>
                            <div class="form-check form-check-custom form-check-solid">
                                <input class="form-check-input me-3" name="require_material" type="checkbox" value="yes" id="require_material_checkbox" />
                                <label class="form-check-label" for="require_material_checkbox">
                                    <div class="fw-semibold text-gray-800">Yes, I need materials for this work</div>
                                </label>
                            </div>
                        </div>
                    
                        <!-- Material Request Section (Hidden by default) -->
                        <div id="material_section" class="mb-10" style="display: none;">
                            <label class="form-label fw-semibold">Material List</label>
                            <textarea name="material_list" class="form-control form-control-solid" rows="4" placeholder="List the materials needed..."></textarea>
                        </div>
                    
                        <!-- Submit Button -->
                        <div class="text-end mt-4">
                            <button type="submit" class="btn btn-lg btn-primary shadow-sm px-5" id="kt_docs_formvalidation_text_submit">
                                Save Work Order
                            </button>
                        </div>
                    </form>                    
                </div>
            </div>
        </div>
    </div>


    <div class="page-loader flex-column bg-dark bg-opacity-50">
        <span class="spinner-border text-primary" role="status"></span>
        <span class="text-gray-800 fs-6 fw-semibold mt-5">Loading...</span>
    </div>

    <div id="page_loader" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(255,255,255,0.7); z-index:9999; justify-content:center; align-items:center;">
        <div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>
    </div>

    <!-- Modal Case Details -->
    <div class="modal fade" id="caseDetailsModal" tabindex="-1" aria-labelledby="caseDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="caseDetailsModalLabel">Case Details - <span id="modal_case_no"></span></h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- Left Column: Case Information -->
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label class="form-label text-muted"><strong>Category</strong></label>
                                <p class="fs-5 text-dark" id="modal_category"></p>
                            </div>
                            <div class="mb-4">
                                <label class="form-label text-muted"><strong>SubCategory</strong></label>
                                <p class="fs-5 text-dark" id="modal_subcategory"></p>
                            </div>
                            <div class="mb-4">
                                <label class="form-label text-muted"><strong>Created By</strong></label>
                                <p class="fs-5 text-dark" id="modal_created_by"></p>
                            </div>
                            <div class="mb-4">
                                <label class="form-label text-muted"><strong>Department</strong></label>
                                <p class="fs-5 text-dark" id="modal_department"></p>
                            </div>
                        </div>

                        <!-- Right Column: Approval Status Table -->
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label class="form-label"><strong>Approval Status</strong></label>
                                <table class="table table-bordered table-hover" id="approval_status_table">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Approver</th>
                                            <th>Case Remark</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label"><strong>Case Chronology</strong></label>
                            <textarea class="form-control" id="modal_chronology" rows="4" readonly></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><strong>Case Outcome</strong></label>
                            <textarea class="form-control" id="modal_outcome" rows="4" readonly></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><strong>Case Suggest</strong></label>
                            <textarea class="form-control" id="modal_suggest" rows="4" readonly></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><strong>Case Action</strong></label>
                            <textarea class="form-control" id="modal_action" rows="4" readonly></textarea>
                        </div>
                    </div>

                    {{-- Image --}}
                    <div class="col-md-12">
                        <div class="mb-4" id="case_photos">
                            <div class="d-flex flex-wrap justify-content-start">
                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@include('content.wo.partial.CreateWOJs')

@endsection


                   {{-- <div class="fv-row mb-3">
                            <label class="form-label fw-semibold">Work Completion</label>
                            <select class="form-select" name="work_completion" data-control="select2" data-placeholder="Select an option">
                                <option></option>
                                <option value="1">Option 1</option>
                                <option value="2">Option 2</option>
                                <option value="3">Option 3</option>
                                <option value="4">Option 4</option>
                            </select>
                        </div> --}}
                    
                        {{-- <div class="fv-row mb-3">
                            <label class="form-label fw-semibold">Work Status</label>
                            <select class="form-select" name="work_status" data-control="select2" data-placeholder="Select an option">
                                <option></option>
                                <option value="1">Option 1</option>
                                <option value="2">Option 2</option>
                                <option value="3">Option 3</option>
                                <option value="4">Option 4</option>
                            </select>
                        </div> --}}