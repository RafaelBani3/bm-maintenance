@extends('layouts.Master')

@section('title', 'BM-Maintenance')
@section('subtitle', 'BM Maintenance - List Approval Case')

@section('content')

<div id="kt_app_content" class="app-content flex-column-fluid">
    <div id="kt_app_content_container" class="app-container container-fluid">
        <div class="card mb-5 mb-xl-10 p-4">
            < class="container">
                <h1 class="mb-4 text-primary fw-bold display-6">Case Approval - {{ $case->Case_No }}</h1>
            
                <div class="separator my-5"></div>

                <div class="row">
                    <!-- Left Column -->
                    <div class="col-md-6">
                        <div class="mb-4">
                            <label class="form-label text-muted"><strong>Case Name</strong></label>
                            <p class="fs-5 fw-bold text-dark">{{ $case->Case_Name }}</p>
                        </div>
                        <div class="mb-4">
                            <label class="form-label text-muted"><strong>Case Date</strong></label>
                            <p class="fs-5 fw-bold text-dark">{{ $case->CR_DT }}</p>
                        </div>
                        <div class="mb-4">
                            <label class="form-label text-muted"><strong>Category</strong></label>
                            <p class="fs-5 fw-bold text-dark">{{ $case->Category }}</p>
                        </div>
                    </div>
                    <!-- Right Column -->
                    <div class="col-md-6">
                        <div class="mb-4">
                            <label class="form-label text-muted"><strong>SubCategory</strong></label>
                            <p class="fs-5 fw-bold text-dark">{{ $case->SubCategory }}</p>
                        </div>
                        <div class="mb-4">
                            <label class="form-label text-muted"><strong>Created By</strong></label>
                            <p class="fs-5 fw-bold text-dark">{{ $case->CreatedBy }}</p>
                        </div>
                        <div class="mb-4">
                            <label class="form-label text-muted"><strong>Case Status</strong></label>
                            <p class="fs-5 fw-bold text-dark">
                                <span class="badge 
                                    {{ $case->Case_Status == 'OPEN' ? 'bg-primary' : 
                                    ($case->Case_Status == 'SUBMIT' ? 'bg-info' : 
                                    ($case->Case_Status == 'CLOSE' ? 'bg-success' : 
                                    ($case->Case_Status == 'REJECT' ? 'bg-danger' : 'bg-secondary'))) }}">
                                    {{ $case->Case_Status == 'OPEN' ? 'Open' : 
                                    ($case->Case_Status == 'SUBMIT' ? 'Submitted' : 
                                    ($case->Case_Status == 'CLOSE' ? 'Closed' : 
                                    ($case->Case_Status == 'REJECT' ? 'Rejected' : 'Unknown')))}}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Case Details (TextArea Inputs for Chronology, Outcome, Suggest, Action) -->
                    <div class="col-md-12">
                        <div class="mb-4">
                            <label class="form-label text-muted"><strong>Case Chronology</strong></label>
                            <textarea class="form-control" rows="4" readonly>{{ $case->Case_Chronology ?? 'N/A' }}</textarea>
                        </div>
                        <div class="mb-4">
                            <label class="form-label text-muted"><strong>Case Outcome</strong></label>
                            <textarea class="form-control" rows="4" readonly>{{ $case->Case_Outcome ?? 'N/A' }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-4">
                            <label class="form-label text-muted"><strong>Case Suggest</strong></label>
                            <textarea class="form-control" rows="4" readonly>{{ $case->Case_Suggest ?? 'N/A' }}</textarea>
                        </div>
                        <div class="mb-4">
                            <label class="form-label text-muted"><strong>Case Action</strong></label>
                            <textarea class="form-control" rows="4" readonly>{{ $case->Case_Action ?? 'N/A' }}</textarea>
                        </div>
                    </div>
    

                <!-- Case Photos -->
                <div class="card-body">
                    <h4 class="mb-3 text-primary fw-bold">Case Photos</h4>
                    @if($images->isNotEmpty())
                        <div class="row">
                            @foreach($images as $image)
                                <div class="col-md-3 col-sm-4 col-6 mb-3">
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal" data-img="{{ asset('storage/case_photos/' . str_replace('/', '-', $image->IMG_RefNo) . '/' . $image->IMG_Filename) }}">
                                        <img src="{{ asset('storage/case_photos/' . str_replace('/', '-', $image->IMG_RefNo) . '/' . $image->IMG_Filename) }}" 
                                            alt="{{ $image->IMG_Realname }}" 
                                            class="img-thumbnail rounded shadow-sm" 
                                            style="width: 100%; height: 150px; object-fit: cover;">
                                    </a>
                                    <p class="text-center small mt-1">{{ $image->IMG_Realname }}</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">No photos available for this case.</p>
                    @endif
                </div>

                <!-- Manager Approval Form -->
                <div class="card col-xl-11 mx-auto mt-4">
                    <div class="card-header align-items-center border-0 mt-4">
                        <h3 class="card-title fw-bold text-gray-900">Manager Approval</h3>
                        <span class="text-muted mt-1 fw-semibold fs-7">Provide approval or rejection with notes</span>
                    </div>
                    <div class="card-body pt-3"> 
                        <form action="{{ route('cases.approveReject', $case->Case_No) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="approvalNotes" class="form-label fw-bold">Approval Notes</label>
                                <div id="kt_docs_quill_basic">
                                    <input type="hidden" id="approvalNotes" name="approvalNotes">
                                    <p>Enter the approval notes here...</p>
                                  
                                    <ul>
                                        <li>List item 1</li>
                                        <li>List item 2</li>
                                        <li>List item 3</li>
                                        <li>List item 4</li>
                                    </ul>
                                </div>
                            </div>
                            {{-- <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-success me-2" value="approve">Approve</button>
                                <button type="submit" class="btn btn-danger" value="reject">Reject</button>
                            </div> --}}
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-success me-2 approve-reject-btn" data-action="approve">Approve</button>
                                <button type="button" class="btn btn-danger approve-reject-btn" data-action="reject">Reject</button>
                            </div>
                            
                        </form>                            
                    </div>
                </div>

            </div>
        </div>  
    </div>

    <!-- Image Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Preview Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" class="img-fluid rounded shadow">
                </div>
            </div>
        </div>
    </div>
</div>


    @include('content.case.partial.DetailApprovalJs')

@endsection
