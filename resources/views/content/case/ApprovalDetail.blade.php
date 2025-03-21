@extends('layouts.Master')

@section('title', 'BM-Maintenance')
@section('subtitle', 'BM Maintenance - List Approval Case')

@section('content')
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">
            <div class="card mb-5 mb-xl-10 p-4">
                
                <div class="container">
                    <h1 class="mb-4 text-primary fw-bold display-6">Case Approval - {{ $case->Case_No }}</h1>
                    
                    <div class="separator my-5"></div>

                    <div class="row">
                        <div class="col-md-6">
                            <p class="fs-5"><strong>Case Name:</strong> {{ $case->Case_Name }}</p>
                            <p class="fs-5"><strong>Case Date:</strong> {{ $case->CR_DT }}</p>
                            <p class="fs-5"><strong>Category:</strong> {{ $case->Category }}</p>
                            <p class="fs-5"><strong>SubCategory:</strong> {{ $case->SubCategory }}</p>
                            <p class="fs-5"><strong>Created By:</strong> {{ $case->CreatedBy }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="fs-5"><strong>Case Chronology:</strong> {{ $case->Case_Chronology }}</p>
                            <p class="fs-5"><strong>Case Outcome:</strong> {{ $case->Case_Outcome }}</p>
                            <p class="fs-5"><strong>Case Suggest:</strong> {{ $case->Case_Suggest }}</p>
                            <p class="fs-5"><strong>Case Action:</strong> {{ $case->Case_Action }}</p>
                            <p class="fs-5">
                                <strong>Case Status:</strong> 
                                <span class="badge
                                    {{ $case->Case_Status == 'OPEN' ? 'badge-primary' : 
                                       ($case->Case_Status == 'SUBMIT' ? 'badge-info' : 
                                       (str_starts_with($case->Case_Status, 'AP') ? 'badge-warning' : 
                                       ($case->Case_Status == 'CLOSE' ? 'badge-success' : 
                                       ($case->Case_Status == 'REJECT' ? 'badge-danger' : 'badge-secondary')))) }} 
                                    fs-8 fw-bold">
                                    {{ $case->Case_Status == 'OPEN' ? 'Open' : 
                                       ($case->Case_Status == 'SUBMIT' ? 'Submitted' : 
                                       (str_starts_with($case->Case_Status, 'AP') ? 'Approval ' . substr($case->Case_Status, 2) : 
                                       ($case->Case_Status == 'CLOSE' ? 'Closed' : 
                                       ($case->Case_Status == 'REJECT' ? 'Rejected' : 'Unknown')))) }}
                                </span>
                            </p>                        </div>
                    </div>

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
                                    <textarea id="approvalNotes" class="form-control mb-2" placeholder="Input Notes..." required></textarea>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-success me-2 approve-reject-btn" value="approve">Approve</button>
                                    <button type="button" class="btn btn-danger approve-reject-btn" value="reject">Reject</button>
                                </div>
                            </form>                            
                        </div>
                    </div>  
                </div>
            </div>  
        </div>
    </div>

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

    @include('content.case.partial.DetailApprovalJs')

@endsection
