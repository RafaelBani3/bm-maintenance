@extends('layouts.Master')

@section('title', 'BM-Maintenance')
@section('subtitle', 'BM Maintenance - View Work Order Details')

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
                                <a href="#" class="btn btn-lg btn-flex btn-secondary fw-bold" data-bs-toggle="modal" data-bs-target="#kt_modal_log">
                                    <i class="ki-duotone ki-chart fs-1 text-muted me-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    LOG
                                </a>
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
                                            case 'OPEN_COMPLETION':
                                            case 'INPROGRESS':
                                                $badgeClass = 'badge-light-info';
                                                break;
                                            case 'SUBMIT':
                                            case 'SUBMIT_COMPLETION':
                                                $badgeClass = 'badge-light-primary fw-bold ';
                                                break;
                                            case 'AP1':
                                                $badgeClass = 'badge-light-primary fw-bold';
                                                break;
                                            case 'AP2':
                                                $badgeClass = 'badge-light-primary fw-bold';
                                                break;  
                                            case 'AP3':
                                                $badgeClass = 'badge-light-primary fw-bold';
                                                break;
                                            case 'AP4':
                                                $badgeClass = 'badge-light-primary fw-bold';
                                                break;
                                            case 'CLOSE':
                                            case 'DONE':
                                                $badgeClass = 'badge badge-light-success';
                                                break;
                                            case 'REJECT':
                                            case 'REJECT_COMPLETION':
                                                $badgeClass = 'badge badge-light-danger';
                                            
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
                                <label class="col-lg-2 fw-semibold text-muted fs-5">Work Order Description?</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-10">
                                    <textarea class="form-control form-control-lg form-control-solid" rows="3" readonly>{{ $workOrder->WO_Narative }}</textarea>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row Need Material-->

                            {{-- WO Attachment --}}
                            <div id="wo_attachment_section" class="row mb-7 pb-4">
                                <label class="col-lg-2 col-form-label fw-semibold fs-5 text-muted">
                                    <span class="required">WorkOrder Attachment</span>
                                </label>                                                
                                <div class="col-lg-10 fv-row">
                                    <div name="wo_attachment" class="dropzone dropzone-queue mb-2" id="kt_dropzonejs_example_3">
                                        
                                        @php
                                            $folder = str_replace(['/', '\\'], '-', $workOrder->WO_No);
                                            $filePath = 'wo_attachments/' . $folder . '/' . $workOrder->WO_Filename;
                                        @endphp

                                        @if (!empty($workOrder->WO_Filename))
                                            @if (Storage::disk('public')->exists($filePath))
                                                <div class="d-flex flex-column gap-3 mt-5 mb-5">
                                                    <div class="d-flex align-items-center p-4 border rounded bg-light shadow-sm">
                                                        <div class="symbol symbol-50px me-4">
                                                            @php
                                                                $ext = strtolower(pathinfo($workOrder->WO_Filename, PATHINFO_EXTENSION));
                                                                $icon = match($ext) {
                                                                    'pdf' => 'bi bi-file-earmark-pdf-fill text-danger',
                                                                    'xls', 'xlsx' => 'bi bi-file-earmark-excel-fill text-success',
                                                                    'jpg', 'jpeg', 'png' => 'bi bi-file-earmark-image-fill text-primary',
                                                                    default => 'bi bi-file-earmark-fill text-secondary',
                                                                };
                                                            @endphp
                                                            <i class="{{ $icon }} fs-2x"></i>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <div class="fw-bold text-dark">{{ $workOrder->WO_Realname }}</div>
                                                            <a href="{{ asset('storage/' . $filePath) }}" class="btn btn-sm btn-light-primary mt-2" download>
                                                                <i class="bi bi-download me-1"></i> Download
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="alert alert-warning d-flex align-items-center p-4 mt-4">
                                                    <i class="bi bi-exclamation-triangle-fill text-warning fs-2x me-3"></i>
                                                    <div>
                                                        <strong>File tidak ditemukan.</strong><br>
                                                        File <code>{{ $workOrder->WO_Filename }}</code> tidak ada di <code>storage/app/public/wo_attachments/{{ $folder }}/</code>.
                                                    </div>
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                            {{-- End WO Attachment --}}

                            <!--begin::Row WO Need Mat?-->
                            <div class="row mb-7 pb-4">
                                <!--begin::Label-->
                                <label class="col-lg-2 fw-semibold text-muted fs-5">Material Required?</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-10">
                                    @if ($workOrder->WO_NeedMat == 'Y')
                                        <span class="badge badge-light-danger fs-6 fw-bold">Yes – Material is required for this work</span>
                                    @elseif ($workOrder->WO_NeedMat == 'N')
                                        <span class="badge badge-light-success fs-6 fw-bold">No – Work does not require material</span>
                                    @else
                                        <span class="badge badge-light-warning fs-6 fw-bold">Unknown</span>
                                    @endif
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row WO Need Mat?-->


                            <!--begin::Row WO Completed Date-->
                        <div class="row mb-7 pb-4">
                            <!--begin::Label-->
                            <label class="col-lg-2 fw-semibold text-muted fs-5">Completion Status</label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-10">
                                @if ($workOrder->WO_CompDate)
                                    <span class="badge badge-light-primary fs-6 fw-bold">
                                        Completed on {{ \Carbon\Carbon::parse($workOrder->WO_CompDate)->format('d M Y, H:i') }}
                                    </span>
                                @else
                                    <span class="badge badge-light-warning fs-6 fw-bold">Not yet completed</span>
                                @endif
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Row WO Completed Date-->


                           
                        </div>
                        {{-- End Detail Work Order  --}}
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
                    <h3 class="modal-title text-primary fw-bold">Log History - Case {{ $workOrder->WO_No }}</h3>
                    <button type="button" class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </button>
                </div>
    
                <div class="modal-body">
                    @php
                        $allowedStatuses = ['CREATED', 'SUBMITTED', 'APPROVED1', 'APPROVED2', 'INPROGRESS', 'CLOSE', 'REJECT'];
                        $statusColors = [
                            'CREATED'    => 'bg-light-warning text-warning',
                            'SUBMITTED'  => 'bg-light-primary text-primary',
                            'APPROVED1'  => 'bg-light-primary text-primary',
                            'APPROVED2'  => 'bg-light-primary text-primary',
                            'INPROGRESS' => 'bg-light-info text-info',
                            'CLOSE'      => 'bg-light-success text-success',
                            'REJECT'     => 'bg-light-danger text-danger',
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
    
    <script>
        const BASE_URL = "{{ url('/') }}";
    </script>
 

@endsection

