@extends('layouts.Master')

@section('title', 'BM-Maintenance')
@section('subtitle', 'BM Maintenance - View List Case')

@section('content')
    
<div id="kt_app_content" class="app-content flex-column-fluid">
    <div id="kt_app_content_container" class="app-container container-fluid">
        <div class="card p-4">
            <h1 class="mb-4 mt-5 text-primary fw-bold text-center">Case Details - {{ $case->Case_No }}</h1>

            <hr>
            <div class="row">
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
                <div class="col-md-6">
                    <div class="mb-4">
                        <label class="form-label text-muted"><strong>SubCategory</strong></label>
                        <p class="fs-5 fw-bold text-dark">{{ $case->SubCategory }}</p>
                    </div>
                    <div class="mb-4">
                        <label class="form-label text-muted"><strong>Created By</strong></label>
                        <p class="fs-5 fw-bold text-dark">{{ $case->User }}</p>
                    </div>
                    <div class="mb-4">
                        <label class="form-label text-muted"><strong>Case Status</strong></label>
                        <p class="fs-5 fw-bold text-dark">
                            <span class="badge
                                {{ $case->Case_Status == 'OPEN' ? 'bg-light-primary' : 
                                ($case->Case_Status == 'SUBMIT' ? 'bg-light-info' : 
                                ($case->Case_Status == 'CLOSE' ? 'bg-light-success' : 
                                ($case->Case_Status == 'REJECT' ? 'bg-light-danger' : 'bg-secondary'))) }}">
                                {{ $case->Case_Status }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Chronology, Outcome, Suggest, and Action (Text Area) -->
            <div class="mb-3">
                <label class="form-label"><strong>Case Chronology</strong></label>
                <textarea class="form-control" rows="3" readonly>{{ $case->Case_Chronology ?? 'N/A' }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label"><strong>Case Outcome</strong></label>
                <textarea class="form-control" rows="3" readonly>{{ $case->Case_Outcome ?? 'N/A' }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label"><strong>Case Suggest</strong></label>
                <textarea class="form-control" rows="3" readonly>{{ $case->Case_Suggest ?? 'N/A' }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label"><strong>Case Action</strong></label>
                <textarea class="form-control" rows="3" readonly>{{ $case->Case_Action ?? 'N/A' }}</textarea>
            </div>

            <!-- Image Gallery -->
            <div class="mb-3">
                <h4 class="text-primary fw-bold">Case Photos</h4>
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

            <!-- Approval Status Table -->
            <div class="mb-3">
                <label class="form-label"><strong>Approval Status</strong></label>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Approver</th>
                            <th>Case Remark</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for($i = 1; $i <= $case->Case_ApMaxStep; $i++)
                            <tr>
                                <td>AP{{ $i }}</td>
                                <td>{{ $case['Case_RMK' . $i] ?? 'Pending' }}</td>
                                {{-- <td>
                                    <span class="badge {{ $case['Case_RMK' . $i] == 'Approved' ? 'bg-success' : ($case['Case_RMK' . $i] == 'Rejected' ? 'bg-danger' : 'bg-warning') }}">
                                        {{ $case['Case_RMK' . $i] ?? 'Pending' }}
                                    </span>
                                </td> --}}
                                <td>
                                    @php
                                        $status = 'Pending'; 
                                        $badgeClass = 'bg-warning';
                                
                                        if (in_array($case->Case_Status, ['AP1', 'AP2', 'AP3', 'AP4', 'AP5'])) {
                                            $status = 'Approved';
                                            $badgeClass = 'bg-success text-white';
                                        } elseif ($case->Case_Status == 'Reject') {
                                            $status = 'Rejected';
                                            $badgeClass = 'bg-danger';
                                        }
                                    @endphp
                                
                                    <span class="badge {{ $badgeClass }}">{{ $status }}</span>
                                </td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

    <!-- Modal for Image Preview -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered"> <!-- changed to modal-xl -->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Preview Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" class="img-fluid rounded shadow" style="max-height: 80vh; object-fit: contain;">
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

