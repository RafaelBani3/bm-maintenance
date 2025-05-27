@extends('layouts.Master')

@section('title', 'BM-Maintenance')
@section('subtitle', 'Case - Approval Case')

@section('content')

<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
        <!--begin::Content wrapper-->
        <div class="d-flex flex-column flex-column-fluid py-3 py-lg-6">
            <div id="kt_app_content" class="app-content flex-column-fluid">
                <!--begin::Content container-->
                <div id="kt_app_content_container" class="app-container container-xxl">
                    <!--begin::Navbar-->
                    <div class="card mb-5 mb-xl-10">
                        <div class="card-header card-header-stretch">
                        <!--begin::Title-->
                            <div class="card-title d-flex justify-content-between align-items-center w-100">
                                <h3 class="fw-bold m-0 text-primary">Case Approval Detail : {{ $case->Case_No }}</h3>

                            </div>
                            <!--end::Title-->                          
                        </div>

                        {{-- Detail Case --}}
                        <div class="card-body p-9">
                            <!--begin::Row CASE NO-->
                            <div class="row mb-7 pb-4">
                                <!--begin::Label-->
                                <label class="col-lg-2 fw-semibold text-muted fs-5">Case No</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-10">
                                    <span class="fw-bold fs-5 text-primary">{{ $case->Case_No }}</span>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row CASE NO-->

                            <!--begin::Row CASE Name-->
                            <div class="row mb-7 pb-4">
                                <!--begin::Label-->
                                <label class="col-lg-2 fw-semibold text-muted fs-5">Case Name</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-10">
                                    <span class="fw-bold fs-5 text-gray-900">{{ $case->Case_Name }}</span>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row CASE Name-->

                            <!--begin::Row CASE Date-->
                            <div class="row mb-7 pb-4">
                                <!--begin::Label-->
                                <label class="col-lg-2 fw-semibold text-muted fs-5">Case Date</label>
                                <!--end::Label-->

                                <!--begin::Col-->
                                <div class="col-lg-10">
                                    <span class="fw-bold fs-5 text-gray-900">
                                        {{ \Carbon\Carbon::parse($case->CR_DT)->format('d/m/Y, H:m') }}</span>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row CASE Date-->


                            <!--begin::Row CASE Category-->
                            <div class="row mb-7 pb-4">
                                <!--begin::Label-->
                                <label class="col-lg-2 fw-semibold text-muted fs-5">Case Category</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-10">
                                    <span class="fw-bold fs-5 text-gray-900">{{ $case->Category }}</span>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row CASE category-->

                            <!--begin::Row CASE subCategory-->
                            <div class="row mb-7 pb-4">
                                <!--begin::Label-->
                                <label class="col-lg-2 fw-semibold text-muted fs-5">Case Sub-Category</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-10">
                                    <span class="fw-bold fs-5 text-gray-900">{{ $case->SubCategory }}</span>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row CASE sub category-->

                            <!--begin::Row CASE Created By-->
                            <div class="row mb-7 pb-4">
                                <!--begin::Label-->
                                <label class="col-lg-2 fw-semibold text-muted fs-5">Case Created By</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-10">
                                    <span class="fw-bold fs-5 text-gray-900">{{ $case->CreatedBy }}</span>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row CASE Created By-->


                            <!--begin::Row CASE Status-->
                            <div class="row mb-7 pb-4">
                                <!--begin::Label-->
<<<<<<< HEAD
                                <label class="col-lg-2 fw-semibold text-muted fs-5">Case Created By</label>
=======
                                <label class="col-lg-2 fw-semibold text-muted fs-5">Case Status</label>
>>>>>>> ff25b43 (Update)
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-10">
                                    <p class="fs-5 fw-bold">
                                        <span class="badge
                                        {{ 
                                            $case->Case_Status == 'OPEN' ? 'bg-light-warning text-bold fs-6' :  
                                            ($case->Case_Status == 'SUBMIT' ? 'bg-light-primary text-primary text-bold fs-5' : 
                                            ($case->Case_Status == 'AP1' ? 'bg-light-primary text-primary text-bold fs-6' : 
                                            ($case->Case_Status == 'AP2' ? 'bg-light-primary text-primary text-bold fs-6' : 
                                            ($case->Case_Status == 'CLOSE' ? 'bg-light-success text-bold fs-6' :
                                            ($case->Case_Status == 'REJECT' ? 'bg-light-danger text-bold fs-6' : 'bg-secondary fs-6'))))) 
                                        }}">
                                            {{
                                                $case->Case_Status == 'AP1' ? 'Approved 1' :
                                                ($case->Case_Status == 'SUBMIT' ? 'SUBMITTED' :
                                                ($case->Case_Status == 'AP2' ? 'Approved 2' :
                                                $case->Case_Status))
                                            }}
                                        </span>
                                    </p>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row CASE Status-->

                            <!--begin::Row CASE chronology-->
                            <div class="row mb-7 pb-4">
                                <!--begin::Label-->
                                <label class="col-lg-2 fw-semibold text-muted fs-5">Case Chronology</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-10">
<<<<<<< HEAD
                                    <textarea class="form-control form-control-solid fw-bold fs-5 text-gray-900" rows="3" name="impact" id="impact" placeholder="Input Case Impact">{{ $case->Case_Chronology }}</textarea>
=======
                                    <textarea class="form-control form-control-solid fw-bold fs-5 text-gray-900" rows="3" name="chronology" id="chronology" placeholder="Input Case Impact">{{ $case->Case_Chronology }}</textarea>
>>>>>>> ff25b43 (Update)
                                    </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row CASE chronology-->

                            <!--begin::Row CASE OUTCOME-->
                            <div class="row mb-7 pb-4">
                                <!--begin::Label-->
                                <label class="col-lg-2 fw-semibold text-muted fs-5">Case Outcome</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-10">
<<<<<<< HEAD
                                    <textarea class="form-control form-control-solid fw-bold fs-5 text-gray-900" rows="3" name="impact" id="impact" placeholder="Input Case Impact">{{ $case->Case_Chronology }}</textarea>
=======
                                    <textarea class="form-control form-control-solid fw-bold fs-5 text-gray-900" rows="3" name="impact" id="impact" placeholder="Input Case Impact">{{ $case->Case_Outcome }}</textarea>
>>>>>>> ff25b43 (Update)
                                    </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row CASE OUTCOME-->

                            <!--begin::Row CASE SUGGEST-->
                            <div class="row mb-7 pb-4">
                                <!--begin::Label-->
                                <label class="col-lg-2 fw-semibold text-muted fs-5">Case Suggestion</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-10">
<<<<<<< HEAD
                                    <textarea class="form-control form-control-solid fw-bold fs-5 text-gray-900" rows="3" name="impact" id="impact" placeholder="Input Case Impact">{{ $case->Case_Chronology }}</textarea>
=======
                                    <textarea class="form-control form-control-solid fw-bold fs-5 text-gray-900" rows="3" name="suggest" id="suggest" placeholder="Input Case Impact">{{ $case->Case_Suggest }}</textarea>
>>>>>>> ff25b43 (Update)
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row CASE SUGGEST-->

                            <!--begin::Row CASE ACTION-->
                            <div class="row mb-7 pb-5   ">
                                <!--begin::Label-->
                                <label class="col-lg-2 fw-semibold text-muted fs-5">Case Action</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-10">
<<<<<<< HEAD
                                    <textarea class="form-control form-control-solid fw-bold fs-5 text-gray-900" rows="3" name="impact" id="impact" placeholder="Input Case Impact">{{ $case->Case_Chronology }}</textarea>
=======
                                    <textarea class="form-control form-control-solid fw-bold fs-5 text-gray-900" rows="3" name="action" id="action" placeholder="Input Case Impact">{{ $case->Case_Action }}</textarea>
>>>>>>> ff25b43 (Update)
                                    </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row CASE ACTION-->

<<<<<<< HEAD
                            <div class="row mb-5 pb-4">
=======
                            {{-- Dropzone --}}
                            {{-- <div class="row mb-5 pb-4">
>>>>>>> ff25b43 (Update)
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label fw-semibold fs-5 text-muted">
                                    <span>Existing Image</span>
                                    <span class="ms-1" data-bs-toggle="tooltip" title="This is the currently uploaded image. You can keep or replace it.">
                                        <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>
                                    </span>
                                </label>
                                <!--end::Label-->
                                <div id="existing-photos" class="d-flex flex-row flex-wrap gap-4">
                                    @if($images->isNotEmpty())
                                        <div class="row">
                                            @foreach($images as $image)
                                                @php
                                                    $imgPath = asset('storage/case_photos/' . str_replace('/', '-', $image->IMG_RefNo) . '/' . $image->IMG_Filename);
                                                @endphp
                                                <div class="col-md-3 col-sm-4 col-6 mb-3">
                                                    <!--begin::Overlay-->
                                                    <a class="d-block overlay" data-fslightbox="lightbox-basic" href="{{ $imgPath }}">
                                                        <!--begin::Image-->
                                                        <div class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded min-h-175px"
                                                            style="background-image:url('{{ $imgPath }}')">
                                                        </div>
                                                        <!--end::Image-->
                                    
                                                        <!--begin::Action-->
                                                        <div class="overlay-layer card-rounded bg-dark bg-opacity-25 shadow d-flex align-items-center justify-content-center">
                                                            <i class="bi bi-eye-fill text-white fs-3x"></i>
                                                        </div>
                                                        <!--end::Action-->
                                                    </a>
                                                    <!--end::Overlay-->
                                    
                                                    <p class="text-center small mt-1">{{ $image->IMG_Realname }}</p>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="text-muted">No photos available for this case.</p>
                                    @endif
                                </div>
<<<<<<< HEAD
                            </div>
                            
                            <div class="row mb-5 pb-5">
                               <!--begin::Label-->
=======
                            </div> --}}
                            
                             <!--Start::Row Exiciting Image-->
                            <div class="row mb-5 pb-4">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label fw-semibold fs-5 text-muted">
                                    <span>Existing Image</span>
                                    <span class="ms-1" data-bs-toggle="tooltip" title="This is the currently uploaded image. You can keep or replace it.">
                                        <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>
                                    </span>
                                </label>
                                <!--end::Label-->
                                <div class="notice d-flex bg-light-primary card-rounded border-3 border-primary border-dashed flex-shrink-0 p-4 p-lg-5 align-items-center">
                                    @if($images->isNotEmpty())
                                        <div class="row gap-5">
                                            @foreach($images as $image)
                                                @php
                                                    $imgPath = asset('storage/case_photos/' . str_replace('/', '-', $image->IMG_RefNo) . '/' . $image->IMG_Filename);
                                                @endphp
                                                <div class="col-xl-2 col-lg-3 col-md-3 col-sm-4 col-6">
                                                    <a href="{{ $imgPath }}" data-fslightbox="lightbox-basic" class="d-block overlay text-center">
                                                        <!-- Gambar ukuran kecil -->
                                                        <div class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded mx-auto"
                                                            style="width: 100px; height: 100px; background-image: url('{{ $imgPath }}');">
                                                        </div>
                                                        <!-- Efek overlay -->
                                                        <div class="overlay-layer card-rounded bg-dark bg-opacity-25 shadow d-flex align-items-center justify-content-center"
                                                            style="width: 100px; height: 100px;">
                                                            <i class="bi bi-eye-fill text-white fs-2"></i>
                                                        </div>
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="text-muted m-0">No photos available for this case.</p>
                                    @endif
                                </div>


                            </div>
                            <!--end::Row Exciting Image-->
                            
                            {{-- Remark --}}
                            <div class="row mb-5 pb-5">
                                <!--begin::Label-->
>>>>>>> ff25b43 (Update)
                                <label class="col-lg-4 col-form-label fw-semibold fs-5 text-muted">
                                    <span>Manager Approval & Remarks</span>
                                    <span class="ms-1" data-bs-toggle="tooltip" title="Provide your formal remarks or decision (approve/reject) regarding this case.">
                                        <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>
                                    </span>
                                </label>
                                <!--end::Label-->

<<<<<<< HEAD
                                <div class="col-lg-12"> 
                                    <form action="{{ route('cases.approveReject', $case->Case_No) }}" method="POST">
                                        @csrf
                                        <div id="kt_docs_quill_basic" name="kt_docs_quill_basic" style="height: 100px">
                                            <p class="text-muted fw-semibold">Input Your Remark or Notes Here</p>                                
                                        </div>
                                        <div class="d-flex justify-content-end mt-4">
                                            <button type="button" class="btn btn-success me-2 approve-reject-btn" data-action="approve">Approve</button>
                                            <button type="button" class="btn btn-danger approve-reject-btn" data-action="reject">Reject</button>
                                        </div>
                                    </form>                            
                                </div>
                            </div>                            
=======
                                <div class="timeline timeline-border-dashed">
                                    <!-- Approval 1 -->
                                    <div class="timeline-item">
                                        <div class="timeline-line"></div>
                                        <div class="timeline-icon">
                                            <i class="ki-duotone ki-folder-added text-gray-500 fs-2">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>                                        
                                        </div>
                                        <div class="timeline-content mb-10 mt-n1">
                                            @php
                                                $logAp1 = $logs->first(function($log) {
                                                    return $log->LOG_Status === 'APPROVED 1' && $log->LOG_Type === 'BA';
                                                });
                                            @endphp
                                            
                                            <div class="pe-3 mb-5">
                                                <div class="fs-5 fw-semibold mb-2">Approval by {{ $case->Approver1 ?? 'Unknown User' }}</div>
                                                <div class="d-flex align-items-center mt-1 fs-6">
                                                    <div class="text-muted me-2 fs-7">
                                                        @if($logAp1)
                                                            Approved at {{ \Carbon\Carbon::parse($logAp1->LOG_Date)->format('d/m/Y   H:i') }}
                                                        @else
                                                            Approval date not found.
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            @if($case->Case_Status === 'SUBMIT' && $case->Case_ApStep == 1)
                                                <div class="col-lg-12"> 
                                                    <form action="{{ route('cases.approveReject', $case->Case_No) }}" method="POST">
                                                        @csrf
                                                        <div id="kt_docs_quill_basic" name="kt_docs_quill_basic" style="height: 100px">
                                                            <p class="text-muted fw-semibold">Input Your Remark or Notes Here</p>                                
                                                        </div>
                                                        <div class="d-flex justify-content-end mt-4">
                                                            <button type="button" class="btn btn-success me-2 approve-reject-btn" data-action="approve">Approve</button>
                                                            <button type="button" class="btn btn-danger approve-reject-btn" data-action="reject">Reject</button>
                                                        </div>
                                                    </form>                            
                                                </div>
                                            @else
                                                <div class="border border-dashed border-primary rounded px-7 py-3 bg-light-primary align-item-center">
                                                    <h5 class="text-gray-900 fw-bold mb-2 fs-4">Remark:</h5>
                                                    <div class="text-gray-700 fs-5">{{ strip_tags($case->Case_RMK1) ?: 'No remark provided.' }}</div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    @if($case->Case_Status === 'AP1' && $case->Case_ApStep == 2)
                                        <div class="timeline-item">
                                            <div class="timeline-line"></div>
                                            <div class="timeline-icon">
                                                <i class="ki-duotone ki-notepad-edit text-gray-900 fs-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>                                        
                                            </div>
                                            <div class="timeline-content mb-10 mt-n1">
                                                <div class="pe-3 mb-5">
                                                    <div class="fs-5 fw-semibold mb-2">Require Your Approval</div>
                                                </div>
                                                <div class="col-lg-12"> 
                                                    <form action="{{ route('cases.approveReject', $case->Case_No) }}" method="POST">
                                                        @csrf
                                                        <div id="kt_docs_quill_basic" name="kt_docs_quill_basic" style="height: 100px">
                                                            <p class="text-muted fw-semibold">Input Your Remark or Notes Here</p>                                
                                                        </div>
                                                        <div class="d-flex justify-content-end mt-4">
                                                            <button type="button" class="btn btn-success me-2 approve-reject-btn" data-action="approve">Approve</button>
                                                            <button type="button" class="btn btn-danger approve-reject-btn" data-action="reject">Reject</button>
                                                        </div>
                                                    </form>                            
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

>>>>>>> ff25b43 (Update)
                        </div>
                        {{-- End Detail Case --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
<<<<<<< HEAD
    
    <script>
        var quill = new Quill('#kt_docs_quill_basic', {
            modules: {
                toolbar: [
                    [{
                    header: [1, 2, false]
                    }],
                    ['bold', 'italic', 'underline'],
                    ['image', 'code-block']
                ]
            },
            placeholder: 'Type your text here...',
            theme: 'snow' 
        });
    </script>


    {{-- Desaign Lama --}}
    {{-- <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">
            <div class="card mb-5 mb-xl-10 p-4">
                <div class="container">
                    <h1 class="mb-3 text-primary fw-bold display-8 mt-3">Case Approval - {{ $case->Case_No }}</h1>
                
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
                                    @php
                                        $statusBadge = [
                                            'OPEN' => ['label' => 'OPEN', 'class' => 'bg-info fs-6'],
                                            'SUBMIT' => ['label' => 'SUBMITTED', 'class' => 'bg-light-primary text-primary fs-6'],
                                            'AP1' => ['label' => 'APPROVED 1', 'class' => 'bg-light-primary text-primary fs-6'],
                                            'AP2' => ['label' => 'APPROVED 2', 'class' => 'bg-light-primary text-primary fs-6'],
                                            'AP3' => ['label' => 'APPROVED 3', 'class' => 'bg-light-primary text-primary fs-6'],
                                            'AP4' => ['label' => 'APPROVED 4', 'class' => 'bg-light-primary text-primary fs-6'],
                                            'AP5' => ['label' => 'APPROVED 5', 'class' => 'bg-light-primary text-primary fs-6'],
                                            'CLOSE' => ['label' => 'CLOSED', 'class' => 'bg-light-success text-success fs-6'],
                                            'REJECT' => ['label' => 'REJECTED', 'class' => 'bg-light-danger text-danger fs-6'],
                                        ];
                            
                                        $status = $case->Case_Status;
                                        $badgeClass = $statusBadge[$status]['class'] ?? 'bg-dark';
                                        $badgeLabel = $statusBadge[$status]['label'] ?? 'Unknown';
                                    @endphp
                            
                                    <span class="badge {{ $badgeClass }}">{{ $badgeLabel }}</span>
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
                                    <!--begin::Overlay-->
                                    <a class="d-block overlay" data-fslightbox="lightbox-basic" 
                                    href="{{ asset('storage/case_photos/' . str_replace('/', '-', $image->IMG_RefNo) . '/' . $image->IMG_Filename) }}">
                                        <!--begin::Image-->
                                        <div class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded min-h-175px" 
                                            style="background-image:url('{{ asset('storage/case_photos/' . str_replace('/', '-', $image->IMG_RefNo) . '/' . $image->IMG_Filename) }}')">
                                        </div>
                                        <!--end::Image-->
                                
                                        <!--begin::Action-->
                                        <div class="overlay-layer card-rounded bg-dark bg-opacity-25 shadow">
                                            <i class="bi bi-eye-fill text-white fs-3x"></i>
                                        </div>
                                        <!--end::Action-->
                                    </a>
                                    <!--end::Overlay-->
                                
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
    </div> --}}
=======
>>>>>>> ff25b43 (Update)

    {{-- Page Loader --}}
    <div id="page_loader" class="page-loader flex-column bg-dark bg-opacity-25" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 9999; align-items: center; justify-content: center;">
        <span class="spinner-border text-primary" role="status"></span>
        <span class="text-white-800 fs-6 fw-semibold mt-5 text-white">Loading...</span>
    </div>

    @include('content.case.partial.DetailApprovalJs')
    <script>
        const BASE_URL = "{{ url('/') }}";
    </script>
@endsection
