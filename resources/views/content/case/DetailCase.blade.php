@extends('layouts.Master')

@section('title', 'BM-Maintenance')
@section('subtitle', 'Case - Detail Case')

@section('content')

    <style>
        .log-timeline {
            position: relative;
            padding-left: 30px; 
        }
        .log-entry {
            position: relative;
            padding-left: 20px; 
        }
        .log-dot {
            width: 12px; 
            height: 12px; 
            border-radius: 50%;
            position: absolute;
            left: -6px; 
            margin-top: 2px;
            top: 0;
        }
        .log-bar {
            position: absolute;
            left: 5px;
            top: 10px; 
            width: 2px;
            height: 100%;
        }
    </style>

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
                                <h3 class="fw-bold m-0 text-primary">
                                    Case Detail : {{ $case->Case_No }}
                                </h3>
                        
                                <div class="d-flex gap-2">
                                    <!-- Button LOG -->
                                    <a href="#" 
                                       class="btn btn-lg btn-flex btn-secondary fw-bold" 
                                       data-bs-toggle="modal" 
                                       data-bs-target="#kt_modal_log">
                                        <i class="ki-duotone ki-chart fs-1 text-muted me-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                        LOG
                                    </a>
                        
                                    <!-- Button Revisi (hanya muncuk ketika status = REJECTED) -->
                                    @if(auth()->user()->hasAnyPermission(['view cr']))
                                        @if($case->Case_Status == 'REJECT')
                                            <button 
                                                type="button" 
                                                class="btn btn-warning btn-lg btn-flex fw-bold" 
                                                onclick="confirmRevision('{{ $case->Case_No }}')">
                                                <i class="fas fa-edit me-2"></i> Revisi
                                            </button>
                                        @endif
                                    @endif
                                </div>
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
                                    <span class="fw-bold fs-5 text-gray-900">{{ $case->User }}</span>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row CASE Created By-->


                            <!--begin::Row CASE Status-->
                            <div class="row mb-7 pb-4">
                                <!--begin::Label-->
                                <label class="col-lg-2 fw-semibold text-muted fs-5">Case Status</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-10">
                                    <p class="fw-bold">
                                        @php
                                            $status = $case->Case_Status;
                                            $statusLabels = [
                                                'OPEN' => ['bg-light-warning text-warning', 'OPEN'],
                                                'SUBMIT' => ['bg-light-primary text-primary', 'SUBMITTED'],
                                                'AP1' => ['bg-light-primary text-primary', 'Approved 1'],
                                                'AP2' => ['bg-light-primary text-primary', 'Approved 2'],
                                                'CLOSE' => ['bg-light-success text-success', 'CLOSE'],
                                                'INPROGRESS' => ['bg-light-info text-info', 'INPROGRESS'],
                                                'REJECT' => ['bg-light-danger text-danger', 'REJECT'],
                                                'DONE' => ['bg-light-success text-success', 'DONE'],

                                            ];
                                            [$badgeClass, $label] = $statusLabels[$status] ?? ['bg-secondary', $status];
                                        @endphp

                                        <span class="badge {{ $badgeClass }} fs-6 fw-bold">
                                            {{ $label }}
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
                                    <textarea class="form-control form-control-solid fw-bold fs-5 text-gray-900" rows="3" name="impact" id="impact" readonly>{{ $case->Case_Chronology }}</textarea>
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
                                    <textarea class="form-control form-control-solid fw-bold fs-5 text-gray-900" rows="3" name="outcome" id="outcome" readonly>{{ $case->Case_Outcome }}</textarea>
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
                                    <textarea class="form-control form-control-solid fw-bold fs-5 text-gray-900" rows="3" name="suggest" id="suggest" readonly>{{ $case->Case_Suggest}}</textarea>
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
                                    <textarea class="form-control form-control-solid fw-bold fs-5 text-gray-900" rows="3" name="action" id="action" readonly>{{ $case->Case_Action }}</textarea>
                                    </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row CASE ACTION-->
                            
                            <!--Start::Row Existing Image-->
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

                                <!--begin::Image Container-->
                                <div class="notice bg-light-primary card-rounded border-3 border-primary border-dashed p-4 p-lg-5 w-100">
                                    @if($images->isNotEmpty())
                                        <div class="row">
                                            @foreach($images as $image)
                                                @php
                                                    $imgPath = asset('storage/case_photos/' . str_replace('/', '-', $image->IMG_RefNo) . '/' . $image->IMG_Filename);
                                                @endphp
                                                <div class="col-xl-2 col-lg-3 col-md-3 col-sm-4 col-6">
                                                    <a href="{{ $imgPath }}" data-fslightbox="lightbox-basic" class="d-block overlay text-center">
                                                        <!-- Gambar thumbnail -->
                                                        <div class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded"
                                                            style="width: 100%; height: 100px; background-image: url('{{ $imgPath }}');">
                                                        </div>
                                                        <!-- Efek overlay -->
                                                        <div class="overlay-layer card-rounded bg-dark bg-opacity-25 shadow d-flex align-items-center justify-content-center"
                                                            style="width: 100%; height: 100px;">
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
                                <!--end::Image Container-->
                            </div>
                            <!--end::Row Existing Image-->

                            <!--Start::Row Approval & Remark Status-->
                            <div class="row mb-5">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label fw-semibold fs-5 text-muted">
                                    <span>Approval Status</span>
                                    <span class="ms-1" data-bs-toggle="tooltip" title="This section shows the current approval progress and status at each step.">
                                        <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>
                                    </span>
                                </label>
                                <!--end::Label-->

                                <div class="timeline timeline-border-dashed">
                                    @for($i = 1; $i <= $case->Case_ApMaxStep; $i++)
                                        @php
                                            $remark = strip_tags($case['Case_RMK' . $i] ?? '');
                                            $stepCode = 'AP' . $i;

                                            $logStatus = [
                                                'approve' => 'APPROVED ' . $i,
                                                'reject' => 'REJECTED ' . $i,
                                            ];

                                            $approvedLog = $approvalLogs->first(function($log) use ($logStatus, $stepCode) {
                                                return in_array($log->LOG_Status, $logStatus) && $log->LOG_Type === 'BA';
                                            });

                                            if ($approvedLog) {
                                                $status = str_contains($approvedLog->LOG_Status, 'REJECTED') ? 'Rejected' : 'Approved';
                                                $badgeClass = $status === 'Rejected' ? 'badge badge-light-danger' : 'badge badge-light-success';
                                                $icon = $status === 'Rejected' ? 'bi-x-circle-fill text-danger' : 'bi-check-circle-fill text-success';
                                            } else {
                                                $status = 'Pending';
                                                $badgeClass = 'badge badge-light-warning text-dark';
                                                $icon = 'bi-hourglass-split';
                                            }
                                            
                                        @endphp

                                        <!--begin::Timeline item-->
                                        <div class="timeline-item align-items-start">
                                            <!--line-->
                                            <div class="timeline-line w-40px"></div>

                                            <!--icon-->
                                            <div class="timeline-icon symbol symbol-circle symbol-40px">
                                                <div class="symbol-label bg-light">
                                                    <i class="ki-duotone ki-pencil fs-2 text-gray-500">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                </div>
                                            </div>

                                            <!--content-->
                                            <div class="timeline-content ps-3 mb-10 mt-n1">
                                                <!--heading-->
                                                <div class="pe-3 mb-5">
                                                    <div class="fs-5 fw-semibold mb-2">
                                                        Approval Step {{ $i }} - {{ is_object($approvers[$i]) ? $approvers[$i]->Fullname : $approvers[$i] }}
                                                    </div>
                                                    <div class="d-flex align-items-center mt-1 fs-6">
                                                        <div class="text-muted me-2 fs-7">
                                                            @if($approvedLog)
                                                                {{ $logStatus[strtolower(str_contains($approvedLog->LOG_Status, 'REJECTED') ? 'reject' : 'approve')] }}
                                                                on {{ \Carbon\Carbon::parse($approvedLog->LOG_Date)->format('d/m/Y H:i') }}
                                                            @else
                                                                Waiting for Approval...
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                                <!--details-->
                                                <div class="overflow-auto pb-5">
                                                    <div class="notice d-flex bg-light-primary card-rounded border-3 border-primary border-dashed min-w-lg-600px flex-shrink-0 p-4 p-lg-5 align-items-center">
                                                        <i class="bi {{ $icon }} fs-2tx text-gray-800 me-4"></i>

                                                        <div class="flex-grow-1 d-flex justify-content-between align-items-center">
                                                            <div class="mb-3 mb-md-0 fw-semibold">
                                                                <h5 class="text-gray-900 fw-bold mb-2 fs-4">Remark:</h5>
                                                                <p class="text-gray-700 fs-5">{{ $remark ?: 'No remark provided.' }}</p>
                                                            </div>
                                                        </div>

                                                        <div>
                                                            <span class="{{ $badgeClass }} px-3 py-2 d-inline-flex align-items-center gap-1 fs-5">
                                                                <i class="bi {{ $icon }}"></i> {{ $status }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end::Timeline content-->
                                        </div>
                                        <!--end::Timeline item-->
                                    @endfor
                                </div>
                            </div>
                            <!--End::Row Approval & Remark Status-->                                
                        </div>
                        {{-- End Detail Case --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    {{-- LOG Modal --}}
    <div class="modal fade" tabindex="-1" id="kt_modal_log">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">

            <div class="modal-content">
                
                <div class="modal-header">
                    <h3 class="modal-title text-primary fw-bold">Log History - Case {{ $case->Case_No }}</h3>
                    <button type="button" class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </button>
                </div>
    
                <div class="modal-body" style="max-height: 500px; overflow-y: auto;">
                    @php
                        $allowedStatuses = ['CREATED', 'SUBMITTED', 'APPROVED 1', 'APPROVED 2', 'INPROGRESS', 'CLOSE', 'REJECTED 1', 'REJECTED 2','REVISION','DONE'];
                        $statusColors = [
                            'CREATED'    => 'bg-light-warning text-warning',
                            'SUBMITTED'  => 'bg-light-primary text-primary',
                            'APPROVED 1'  => 'bg-light-primary text-primary',
                            'APPROVED 2'  => 'bg-light-primary text-primary',
                            'REJECTED 1'  => 'bg-light-danger text-danger',
                            'REJECTED 2'  => 'bg-light-danger text-danger',
                            'INPROGRESS' => 'bg-light-info text-info',
                            'CLOSE'      => 'bg-light-success text-success',
                            'REJECT'     => 'bg-light-danger text-danger',
                            'REVISION'   => 'bg-light-info text-info',
                            'DONE'       => 'bg-light-success text-success'
                        ];
                    @endphp
    
                    <div class="timeline timeline-border-dashed">
                        @foreach ($logs as $log)
                            @if(in_array($log->LOG_Status, $allowedStatuses))
                                @php
                                    $colorClass = $statusColors[$log->LOG_Status] ?? 'bg-secondary text-dark';
                                @endphp
    
                                <div class="timeline-item">
                                    <div class="timeline-line"></div>
                                    <div class="timeline-icon">
                                        <div class="symbol symbol-circle symbol-40px {{ $colorClass }}">
                                            <i class="ki-duotone ki-document fs-2 {{ $colorClass }}">
                                                <span class="path1"></span><span class="path2"></span>
                                            </i>
                                        </div>
                                    </div>
    
                                    <div class="timeline-content mb-5">
                                        <div class="d-flex flex-wrap justify-content-between align-items-center mb-1">
                                            <span class="badge {{ $colorClass }} fw-semibold">{{ $log->LOG_Status }}</span>
                                            <div class="text-muted fs-7">{{ \Carbon\Carbon::parse($log->LOG_Date)->format('d M Y, H:m') }}</div>
                                        </div>
                                        <div class="fw-semibold text-primary mb-1">{{ strtoupper($log->user_name) }}</div>
                                        <div class="text-gray-700">{{ strtoupper($log->LOG_Desc) }}</div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
    
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Button Revisi --}}
    <script>
        // Declare Route untuk Ke Edit Page
        const editCaseRoute = @json(route('EditCase', ':encoded_case_no'));

        function confirmRevision(caseNo) {
            Swal.fire({
                title: 'Confirm Revision',
                text: 'Are you sure you want to revise this case?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Revision',
                cancelButtonText: 'Cancle'
            }).then((result) => {   
                if (result.isConfirmed) {
                    // const encodedCaseNo = encodeURIComponent(caseNo);
                    // const url =  window.location.origin + `/BmMaintenance/public/Case/Edit/${encodedCaseNo}`;

                    // window.location.href = url;
                    const encodedCaseNo = btoa(caseNo); 
                    const finalUrl = editCaseRoute.replace(':encoded_case_no', encodedCaseNo);
                    window.location.href = finalUrl; 
                }
            });
        }
    </script>

    <script src="{{ asset('assets/plugins/custom/fslightbox/fslightbox.bundle.js') }}"></script>

@endsection

