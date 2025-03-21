@extends('layouts.Master')

@section('title', 'BM-Maintenance')
@section('subtitle', 'BM Maintenance - View List Case')

@section('content')
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">
            <div class="card mb-5 mb-xl-10 p-4">
                <div id="kt_account_settings_profile_details" class="collapse show">
                    <div class="container">
                        <div class="card-body">
                            <h1 class="mb-4 text-primary fw-bold display-6">Case Details - {{ $case->Case_No }}</h1>
                            <div class="separator my-5"></div>  
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="fs-5"><strong>Case Name:</strong> {{ $case->Case_Name }}</p>
                                    <p class="fs-5"><strong>Case Date:</strong> {{ $case->CR_DT }}</p>
                                    <p class="fs-5"><strong>Category:</strong> {{ $case->Category }}</p>
                                    <p class="fs-5"><strong>SubCategory:</strong> {{ $case->SubCategory }}</p>
                                    <p class="fs-5"><strong>Created By:</strong> {{ $case->User }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="fs-5"><strong>Case Chronology:</strong> {{ $case->Case_Chronology ?? 'N/A' }}</p>
                                    <p class="fs-5"><strong>Case Outcome:</strong> {{ $case->Case_Outcome ?? 'N/A' }}</p>
                                    <p class="fs-5"><strong>Case Suggest:</strong> {{ $case->Case_Suggest ?? 'N/A' }}</p>
                                    <p class="fs-5"><strong>Case Action:</strong> {{ $case->Case_Action ?? 'N/A' }}</p>
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
                                    </p>
                                    
                                </div>
                            </div>
                        </div>

                        <div class="separator"></div>
                       
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
                    </div>
                </div>
                
                <div class="card col-xl-10 mx-auto">
                    <div class="card-header align-items-center border-0 mt-4">
                        <h3 class="card-title fw-bold text-gray-900">Approval Status</h3>
                        <span class="text-muted mt-1 fw-semibold fs-7">Approval by AP1 - AP5</span>
                    </div>
                    <div class="card-body pt-3">
                        @for($i = 1; $i <= $case->Case_ApMaxStep; $i++)
                            <div class="d-flex align-items-sm-center mb-3 border-bottom pb-2">
                                <div class="symbol symbol-50px me-4">
                                    <span class="symbol-label bg-light-primary text-primary fw-bold rounded-circle fs-4">AP{{ $i }}</span>
                                </div>
                                <div class="d-flex flex-row-fluid flex-wrap align-items-center">
                                    <div class="flex-grow-1 me-2">
                                        <span class="text-gray-800 fw-bold fs-6">Approver {{ $i }}</span>
                                    </div>
                                    <span class="badge display-2
                                        {{ $case['Case_RMK' . $i] == 'Approved' ? 'badge-success' : 
                                        ($case['Case_RMK' . $i] == 'Rejected' ? 'badge-danger' : '') }} 
                                        fs-4 fw-bold">
                                        {{ $case['Case_RMK' . $i] ?? 'Pending' }}
                                    </span>
                                </div>
                            </div>
                        @endfor
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

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var imageModal = document.getElementById("imageModal");
            imageModal.addEventListener("show.bs.modal", function (event) {
                var button = event.relatedTarget;
                var imageUrl = button.getAttribute("data-img");
                document.getElementById("modalImage").src = imageUrl;
            });
        });
    </script>


@endsection

