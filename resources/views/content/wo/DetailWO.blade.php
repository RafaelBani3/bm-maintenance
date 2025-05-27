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
                                            case 'Open_Completion':
                                            case 'OnProgress':
                                                $badgeClass = 'badge-light-info';
                                                break;
                                            case 'Submit':
<<<<<<< HEAD
                                                $badgeClass = 'badge-warning';
                                                break;
                                            case 'AP1':
                                            case 'AP2':
                                            case 'AP3':
                                            case 'AP4':
                                                $badgeClass = 'badge-primary';
                                                break;
                                            case 'CLOSE':
                                                $badgeClass = 'badge-dark';
=======
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
                                                $badgeClass = 'badge badge-light-success';
>>>>>>> ff25b43 (Update)
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
                                <label class="col-lg-2 fw-semibold text-muted fs-5">Need Material?</label>
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
                                    <label class="col-lg-2 fw-semibold text-muted fs-5">Completed By</label>
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

                                {{-- <!--begin::Row WO REject By-->
                                <div class="row mb-7 pb-4">
                                    <!--begin::Label-->
                                    <label class="col-lg-2 fw-semibold text-muted fs-5">Rejected By</label>
                                    <!--end::Label-->
                                    <!--begin::Col-->
                                    <div class="col-lg-10">
                                        <span class="fw-bold fs-5 text-dark">{{ $workOrder->WO_IsReject }}</span>
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Row WO Rejected_By-->

                                 <!--begin::Row WO REject By-->
                                 <div class="row mb-7 pb-4">
                                    <!--begin::Label-->
                                    <label class="col-lg-2 fw-semibold text-muted fs-5">Rejection Date</label>
                                    <!--end::Label-->
                                    <!--begin::Col-->
                                    <div class="col-lg-10">
                                        <span class="fw-bold fs-5 text-dark">{{ $workOrder->WO_RejDate }}</span>
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Row WO Rejected_By--> --}}
<<<<<<< HEAD


=======
>>>>>>> ff25b43 (Update)
                        </div>
                        {{-- End Detail Work Order  --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
<<<<<<< HEAD
    
     {{-- <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">
            <div class="card p-4 shadow-sm">
                <h1 class="mb-3 mt-5 text-primary fw-bold text-start">
                    Work Order Details : {{ $workOrder->WO_No }}
                </h1>

                <hr>
                
                <div class="row mb-5 fs-5">
                    <div class="col-md-6">
                        <label class="fw-bold text-dark">Work Order No</label>
                        <input type="text" class="form-control form-control-solid" value="{{ $workOrder->WO_No }}" readonly/>
                    </div>
                    <div class="col-md-6">
                        <label class="fw-bold text-dark">Work Order No</label>
                        <input type="text" class="form-control form-control-solid" value="{{ $workOrder->Case_No }}" readonly/>
                    </div>
                </div>
                
                <div class="row mb-5 fs-5">
                    <div class="col-md-6">
                        <label class="fw-bold text-dark">Created By</label>
                        <input type="text" class="form-control form-control-solid" value="{{ $workOrder->Creator_Name }}" readonly/>
                    </div>
                    <div class="col-md-6">
                        <label class="fw-bold text-dark">Created Date</label>
                        <input type="text" class="form-control form-control-solid" value="{{ \Carbon\Carbon::parse($workOrder->CR_DT)->format('d M Y H:i') }}" readonly/>
                    </div>
                </div>
    
                <div class="row mb-5 fs-5">
                    <div class="col-md-6">
                        <label class="fw-bold text-dark">Start Date</label>
                        <input type="text" class="form-control form-control-solid" value="{{ \Carbon\Carbon::parse($workOrder->WO_Start)->format('d M Y H:i') }}" readonly/>
                    </div>
                    <div class="col-md-6">
                        <label class="fw-bold text-dark">End Date</label>
                        <input type="text" class="form-control form-control-solid" value="{{ \Carbon\Carbon::parse($workOrder->WO_End)->format('d M Y H:i') }}" readonly/>
                    </div>
                </div>

                <div class="row mb-5 fs-5">
                    <div class="col-md-6">
                        <label class="fw-bold text-dark">WO Status</label>
                        <div class="mt-1">
                            @php
                                $status = $workOrder->WO_Status;
                                $badgeClass = 'badge-light-secondary';
                    
                                switch ($status) {
                                    case 'OPEN':
                                    case 'Open_Completion':
                                    case 'OnProgress':
                                        $badgeClass = 'badge-info';
                                        break;
                                    case 'Submit':
                                        $badgeClass = 'badge-warning';
                                        break;
                                    case 'AP1':
                                    case 'AP2':
                                    case 'AP3':
                                    case 'AP4':
                                        $badgeClass = 'badge-primary';
                                        break;
                                    case 'CLOSE':
                                        $badgeClass = 'badge-dark';
                                        break;
                                }
                            @endphp
                    
                            <span class="badge {{ $badgeClass }} fw-semibold">{{ $status }}</span>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="fw-bold text-dark">Needs Material?</label>
                        <div>{{ $workOrder->WO_NeedMat == 'Y' ? 'Yes' : 'No' }}</div>
                    </div>
                </div>
    
                <div class="row mb-5">
                    <div class="col-md-12">
                        <label class="fw-bold text-dark">Narrative</label>
                        <textarea class="form-control form-control-solid" rows="4" readonly>{{ $workOrder->WO_Narative }}</textarea>
                    </div>
                </div>
    
                @if($workOrder->WO_IsComplete == 'Y')
                <div class="row mb-5">
                    <div class="col-md-6">
                        <label class="fw-bold text-muted">Completed By</label>
                        <div>{{ $workOrder->Completed_By }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="fw-bold text-muted">Completion Date</label>
                        <div>{{ \Carbon\Carbon::parse($workOrder->WO_CompDate)->format('d M Y H:i') }}</div>
                    </div>
                </div>
                @endif
    
                @if($workOrder->WO_IsReject == 'Y')
                <div class="row mb-5">
                    <div class="col-md-6">
                        <label class="fw-bold text-muted">Rejected By</label>
                        <div>{{ $workOrder->Rejected_By }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="fw-bold text-muted">Rejection Date</label>
                        <div>{{ \Carbon\Carbon::parse($workOrder->WO_RejDate)->format('d M Y H:i') }}</div>
                    </div>
                </div>
                @endif
    
                <div class="row mb-5">
                    <div class="col-md-12">
                        <label class="fw-bold text-muted">Approval Remarks</label>
                        <ul class="list-group">
                            @for ($i = 1; $i <= 5; $i++)
                                @php $rmk = 'WO_RMK' . $i; @endphp
                                @if (!empty($workOrder->$rmk))
                                    <li class="list-group-item">
                                        <strong>RMK{{ $i }}:</strong> {{ $workOrder->$rmk }}
                                    </li>
                                @endif
                            @endfor
                        </ul>
                    </div>
                </div>
    
                <div class="text-end mt-4">
                    <a href="{{ url('/Work-Orders') }}" class="btn btn-secondary">Back</a>
                </div>
            </div>
        </div>
    </div> --}}

    {{-- <div id="kt_app_content" class="app-content flex-column-fluid mt-5">
        <div id="kt_app_content_container" class="app-container container-fluid">
            <div class="card p-4 shadow-sm">
                <h1 class="mb-3 mt-5 text-primary fw-bold text-start">
                    Work Order Details : {{ $workOrder->WO_No }}
                </h1>

                <hr>
                
                <div class="row mb-5 fs-5">
                    <div class="col-md-6">
                        <label class="fw-bold text-dark">Work Order No</label>
                        <div class="mt-1">{{ $workOrder->WO_No }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="fw-bold text-dark">Work Order No</label>
                        <div class="mt-1">{{ $workOrder->Case_No }}</div>
                    </div>
                </div>
                
                <div class="row mb-5 fs-5">
                    <div class="col-md-6">
                        <label class="fw-bold text-dark">Created By</label>
                        <div class="mt-1">{{ $workOrder->Creator_Name }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="fw-bold text-dark">Created Date</label>
                        <div class="mt-1">{{ \Carbon\Carbon::parse($workOrder->CR_DT)->format('d M Y H:i') }}</div>
                    </div>
                </div>
    
                <div class="row mb-5 fs-5">
                    <div class="col-md-6">
                        <label class="fw-bold text-dark">Start Date</label>
                        <div class="mt-1">{{ \Carbon\Carbon::parse($workOrder->WO_Start)->format('d M Y H:i') }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="fw-bold text-dark">End Date</label>
                        <div class="mt-1">{{ \Carbon\Carbon::parse($workOrder->WO_End)->format('d M Y H:i') }}</div>
                    </div>
                </div>

                <div class="row mb-5 fs-5">
                    <div class="col-md-6">
                        <label class="fw-bold text-dark">WO Status</label>
                        <div class="mt-1">
                            @php
                                $status = $workOrder->WO_Status;
                                $badgeClass = 'badge-light-secondary';
                    
                                switch ($status) {
                                    case 'OPEN':
                                    case 'Open_Completion':
                                    case 'OnProgress':
                                        $badgeClass = 'badge-info';
                                        break;
                                    case 'Submit':
                                        $badgeClass = 'badge-warning';
                                        break;
                                    case 'AP1':
                                    case 'AP2':
                                    case 'AP3':
                                    case 'AP4':
                                        $badgeClass = 'badge-primary';
                                        break;
                                    case 'CLOSE':
                                        $badgeClass = 'badge-dark';
                                        break;
                                }
                            @endphp
                    
                            <span class="badge {{ $badgeClass }} fw-semibold">{{ $status }}</span>
                        </div>
                    </div>
                    
                   
                    <div class="col-md-6">
                        <label class="fw-bold text-dark">Needs Material?</label>
                        <div class="mt-1">{{ $workOrder->WO_NeedMat == 'Y' ? 'Yes' : 'No' }}</div>
                    </div>
                </div>
    
                <div class="row mb-5">
                    <div class="col-md-12">
                        <label class="fw-bold text-dark">Narrative</label>
                        <textarea class="form-control form-control-solid" rows="4" readonly>{{ $workOrder->WO_Narative }}</textarea>
                    </div>
                </div>
    
                @if($workOrder->WO_IsComplete == 'Y')
                <div class="row mb-5">
                    <div class="col-md-6">
                        <label class="fw-bold text-muted">Completed By</label>
                        <div>{{ $workOrder->Completed_By }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="fw-bold text-muted">Completion Date</label>
                        <div>{{ \Carbon\Carbon::parse($workOrder->WO_CompDate)->format('d M Y H:i') }}</div>
                    </div>
                </div>
                @endif
    
                @if($workOrder->WO_IsReject == 'Y')
                <div class="row mb-5">
                    <div class="col-md-6">
                        <label class="fw-bold text-muted">Rejected By</label>
                        <div>{{ $workOrder->Rejected_By }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="fw-bold text-muted">Rejection Date</label>
                        <div>{{ \Carbon\Carbon::parse($workOrder->WO_RejDate)->format('d M Y H:i') }}</div>
                    </div>
                </div>
                @endif
    
            </div>
        </div>
    </div> --}}
=======
>>>>>>> ff25b43 (Update)

    {{-- LOG Modal --}}
    <div class="modal fade" tabindex="-1" id="kt_modal_log">
        <div class="modal-dialog modal-lg modal-dialog-centered">
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

