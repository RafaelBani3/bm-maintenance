@extends('layouts.Master')

@section('title', 'BM-Maintenance')
@section('subtitle', 'Detail Work Order Complition')

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
                                <h3 class="fw-bold m-0 text-primary">Work Order Detail : {{ $workOrder->WO_No }} </h3>
                                
                                <div class="d-flex gap-2">
                                    <a href="#" class="btn btn-lg btn-flex btn-secondary fw-bold" data-bs-toggle="modal" data-bs-target="#kt_modal_scrollable_2">
                                        <i class="ki-duotone ki-chart fs-1 text-muted me-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                        LOG
                                    </a>
                                    
                                    @if(auth()->user()->hasAnyPermission(['view cr']))
                                        @if($workOrder->WO_Status == 'REJECT')
                                            <button 
                                                type="button" 
                                                class="btn btn-warning btn-lg btn-flex fw-bold" 
                                                id="btnRevisi">
                                                <i class="fas fa-edit me-2"></i> Revisi
                                            </button>
                                        @endif
                                    @endif
                                </div>
                       
                            </div>
                            <!--end::Title-->                          
                        </div>

                        {{-- Detail Work Order --}}
                        <div class="card-body p-9">
                            <!--begin::Row Work Order NO-->
                            <div class="row mb-7 pb-4">
                                <!--begin::Label-->
                                <label class="col-lg-2 fw-semibold text-muted fs-5">Work Order No</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-10">
                                    <span class="fw-bold fs-5 text-primary">{{ $workOrder->WO_No }}</span>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row Work Order NO-->

                            <!--begin::Row Case NO-->
                            <div class="row mb-7 pb-4">
                                <!--begin::Label-->
                                <label class="col-lg-2 fw-semibold text-muted fs-5">Case No</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-10">
                                    <span class="fw-bold fs-5 text-primary">{{ $workOrder->Case_No }}</span>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row Case NO-->

                            <!--begin::Row Created By-->
                            <div class="row mb-7 pb-4">
                                <!--begin::Label-->
                                <label class="col-lg-2 fw-semibold text-muted fs-5">Created By</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-10">
                                    <span class="fw-bold fs-5 text-dark">{{ $workOrder->Creator_Name }}</span>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row Created By-->

                            <!--begin::Row Created date-->
                            <div class="row mb-7 pb-4">
                                <!--begin::Label-->
                                <label class="col-lg-2 fw-semibold text-muted fs-5">Created Date</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-10">
                                    <span class="fw-bold fs-5 text-dark">{{ \Carbon\Carbon::parse($workOrder->CR_DT)->format('d/m/Y H:m') }}</span>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row Created Date-->

                            <!--begin::Row Start date-->
                            <div class="row mb-7 pb-4">
                                <!--begin::Label-->
                                <label class="col-lg-2 fw-semibold text-muted fs-5">Start Date</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-10">
                                    <span class="fw-bold fs-5 text-dark">{{ \Carbon\Carbon::parse($workOrder->WO_Start)->format('d/m/Y H:m') }}</span>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row Start Date-->

                             <!--begin::Row end date-->
                            <div class="row mb-7 pb-4">
                                <!--begin::Label-->
                                <label class="col-lg-2 fw-semibold text-muted fs-5">End Date</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-10">
                                    <span class="fw-bold fs-5 text-dark">{{ \Carbon\Carbon::parse($workOrder->WO_End)->format('d/m/Y H:m') }}</span>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row End Date-->

                            <!--begin::Row Wo Status-->
                            <div class="row mb-7 pb-4">
                                <!--begin::Label-->
                                <label class="col-lg-2 fw-semibold text-muted fs-5">WO Status</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-10">
                                    @php
                                        $status = $workOrder->WO_Status;
                                        $badgeClass = 'badge-light-secondary';
                            
                                        switch ($status) {
                                            case 'OPEN':
                                            case 'Open_Completion':
                                            case 'INPROGRESS':
                                                $badgeClass = 'badge-light-info';
                                                break;
                                            case 'SUBMIT':
                                            case 'SUBMIT_COMPLETION':
                                                $badgeClass = 'badge-light-primary fw-bold fs-5';
                                                break;
                                            case 'AP1':
                                                $badgeClass = 'badge-light-primary fw-bold fs-5';
                                                break;
                                            case 'AP2':
                                                $badgeClass = 'badge-light-primary fw-bold fs-5';
                                                break;  
                                            case 'AP3':
                                                $badgeClass = 'badge-light-primary fw-bold fs-5';
                                                break;
                                            case 'AP4':
                                                $badgeClass = 'badge-light-primary fw-bold fs-5';
                                                break;
                                            case 'CLOSE':
                                            case 'DONE':
                                                $badgeClass = 'badge-light-success text-success';
                                                break;
                                            case 'REJECT':
                                                $badgeClass = 'badge-light-danger text-danger';
                                                break;
                                        }
                                    @endphp
                            
                                    <span class="badge {{ $badgeClass }} fw-semibold fs-6">{{ $status }}</span>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row WO Status-->

                            <!--begin::Row Need Material-->
                            <div class="row mb-7 pb-4">
                                <!--begin::Label-->
                                <label class="col-lg-2 fw-semibold text-muted fs-5">Work Narrative</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-10">
                                    <textarea class="form-control form-control-lg form-control-solid" rows="3" readonly>{{ $workOrder->WO_Narative }}</textarea>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row Need Material-->

                            <!--begin::Row WO Completed-->
                            <div class="row mb-7 pb-4">
                                <!--begin::Label-->
                                <label class="col-lg-2 fw-semibold text-muted fs-5">Need Material?</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-10">
                                    <span class="fw-bold fs-5 text-dark">{{ $workOrder->WO_IsComplete }}</span>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row WO Completed-->

                            <!--begin::Row WO Completed Date-->
                            <div class="row mb-7 pb-4">
                                <!--begin::Label-->
                                <label class="col-lg-2 fw-semibold text-muted fs-5">Completion Date</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-10">
                                    <span class="fw-bold fs-5 text-dark">{{ $workOrder->WO_CompDate }}</span>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row WO Completed-->

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

                                <div class="notice bg-light-primary card-rounded border-3 border-primary border-dashed p-4 p-lg-5 w-100">
                                    @if($wocImages->isNotEmpty())
                                        <div class="row">
                                            @foreach($wocImages as $image)
                                                @php
                                                    $imgPath = asset('storage/woc_photos/' . str_replace('/', '-', $image->IMG_RefNo) . '/' . $image->IMG_Filename);
                                                @endphp
                                                <div class="col-xl-2 col-lg-3 col-md-3 col-sm-4 col-6">
                                                    <!--begin::Overlay-->
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
                                                    <!--end::Overlay-->
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="text-muted">No photos available for this case.</p>
                                    @endif
                                </div>
                            </div>
                            <!--end::Row Exciting Image-->
                            
                            {{-- APPROVAL STATUS --}}
                            <div class="row mb-5 ">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label fw-semibold fs-5 text-muted mb-5">
                                    <span>Work Order Completion Approval Status</span>
                                    <span class="ms-1" data-bs-toggle="tooltip" title="This section shows the current approval progress and status at each step.">
                                        <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>
                                    </span>
                                </label>
                                <!--end::Label-->

                                <!--Approval dan Remark Status-->
                                <div class="timeline timeline-border-dashed">
                                    @for($i = 1; $i <= $workOrder->WO_APMaxStep; $i++)
                                        @php
                                            $remark = strip_tags($workOrder->{'WO_RMK' . $i} ?? '');

                                            $stepCode = 'AP' . $i;

                                            $logStatus = [
                                                'approve' => 'APPROVED ' . $i,
                                                'reject' => 'REJECTED ' . $i,
                                            ];

                                            $approvedLog = $approvalLogs->first(function($log) use ($logStatus, $stepCode) {
                                                return in_array($log->LOG_Status, $logStatus) && $log->LOG_Type === 'WO';
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
                            
                        </div>  
                        {{-- End Detail Work Order  --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/plugins/custom/fslightbox/fslightbox.bundle.js') }}"></script>

    {{-- LOG Modal --}}
    <div class="modal fade" tabindex="-1" id="kt_modal_scrollable_2">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                
                <div class="modal-header">
                    <h3 class="modal-title text-primary fw-bold">Log History WOC - {{ $workOrder->WOC_No }}</h3>
                    <button type="button" class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </button>
                </div>
    
                <div class="modal-body">
                    @php
                        $allowedStatuses = ['CREATED', 'SUBMITTED', 'APPROVED 1', 'APPROVED 2', 'INPROGRESS', 'CLOSE', 'REJECTED 1', 'REJECTED 2', 'REVISION','DONE'];
                        $statusColors = [
                            'CREATED'    => 'bg-light-warning text-warning',
                            'SUBMITTED'  => 'bg-light-primary text-primary',
                            'APPROVED 1'  => 'bg-light-primary text-primary',
                            'APPROVED 2'  => 'bg-light-primary text-primary',
                            'INPROGRESS' => 'bg-light-info text-info',
                            'CLOSE'      => 'bg-light-success text-success',
                            'REJECTED 1'     => 'bg-light-danger text-danger',
                            'REJECTED 2'     => 'bg-light-danger text-danger',
                            'REVISION'   => 'bg-light-info text-info',
                            'DONE'       => 'bg-light-success text-success',
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
                                            <i class="ki-duotone ki-document fs-2">
                                                <span class="path1"></span><span class="path2"></span>
                                            </i>
                                        </div>
                                    </div>
    
                                    <div class="timeline-content mb-5">
                                        <div class="d-flex flex-wrap justify-content-between align-items-center mb-1">
                                            <span class="badge {{ $colorClass }} fw-semibold">{{ $log->LOG_Status }}</span>
                                            <div class="text-muted fs-7">{{ \Carbon\Carbon::parse($log->LOG_Date)->format('d M Y, H:i') }}</div>
                                        </div>
                                        <div class="fw-semibold text-primary mb-1">{{ $log->user_name }}</div>
                                        <div class="text-gray-700">{{ $log->LOG_Desc }}</div>
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
        document.addEventListener('DOMContentLoaded', function () {
            const btnRevisi = document.getElementById('btnRevisi');
            if (btnRevisi) {
                btnRevisi.addEventListener('click', function () {
                    Swal.fire({
                        title: 'Revision Confirmation',
                        text: 'Are you sure you want to revise this Material Request?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Revision'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const woNo = "{{ base64_encode($workOrder->WO_No) }}";
                            window.location.href = `http://localhost/BmMaintenance/public/WorkOrder-Complition/Edit/${woNo}`;
                        }
                    });
                });
            }
        });
    </script>
    
    <script>
        const BASE_URL = "{{ url('/') }}";
    </script>

@endsection

