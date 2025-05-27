@extends('layouts.Master')

@section('title', 'BM-Maintenance')
@section('subtitle', 'Material Request- Detail Material Request')

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
                            <div class="card-title d-flex flex-wrap justify-content-between align-items-center w-100 gap-3">
                                <!-- Title -->
                                <h3 class="fw-bold m-0 text-primary flex-grow-1">
                                    Material Request Detail : {{ $materialRequest->MR_No }}
                                </h3>
                            
                                <!-- Tombol Aksi -->
                                <div class="d-flex gap-2">
                                    <!-- Button Log -->
                                    <a href="#" class="btn btn-lg btn-flex btn-secondary fw-bold" data-bs-toggle="modal" data-bs-target="#kt_modal_scrollable_2">
                                        <i class="ki-duotone ki-chart fs-1 text-muted me-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                        LOG
                                    </a>
    
                                    @if($materialRequest->MR_Status == 'REJECT')
                                        <button 
                                            type="button" 
                                            class="btn btn-warning btn-lg btn-flex fw-bold" 
                                            id="btnRevisi">
                                            <i class="fas fa-edit me-2"></i> Revisi
                                        </button>
                                    @endif
                                </div>
                            </div>
                        
                            <!--end::Title-->                          
                        </div>

                        {{-- Detail Case --}}
                        <div class="card-body p-9">
                            
                            <!--begin::Row Mterial NO-->
                            <div class="row mb-7 pb-4">
                                <!--begin::Label-->
                                <label class="col-lg-2 fw-semibold text-muted fs-5">Material Request No</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-10">
                                    <span class="fw-bold fs-5 text-primary">{{ $materialRequest->MR_No }}</span>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row Mterial NO-->

                            <!--begin::Row Work Order NO-->
                            <div class="row mb-7 pb-4">
                                <!--begin::Label-->
                                <label class="col-lg-2 fw-semibold text-muted fs-5">Work Order No</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-10">
                                    <span class="fw-bold fs-5 text-primary">{{ $materialRequest->WO_No }}</span>
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
                                    <span class="fw-bold fs-5 text-primary">{{ $materialRequest->Case_No }}</span>
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
                                    <span class="fw-bold fs-5 text-dark">{{ $materialRequest->createdBy->Fullname }}</span>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row Created By-->

                            <!--begin::Row Created Date-->
                            <div class="row mb-7 pb-4">
                                <!--begin::Label-->
                                <label class="col-lg-2 fw-semibold text-muted fs-5">Request Date</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-10">
                                    <span class="fw-bold fs-5 text-dark">
                                        {{ \Carbon\Carbon::parse($materialRequest->CR_DT)->format('d/m/Y H:m') }}
                                    </span>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row Created Date-->

                            <!--begin::Row Status-->
                            <div class="row mb-7 pb-4">
                                <!--begin::Label-->
                                <label class="col-lg-2 fw-semibold text-muted fs-5">MR Status</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-10">
                                    @php
                                        // Define status class based on MR_Status
                                        $statusClass = '';
                                        switch ($materialRequest->MR_Status) {
                                            case 'OPEN':
                                                $statusClass = 'bg-light-warning text-warning';
                                                break;
                                            case 'SUBMIT':
                                                $statusClass = 'bg-light-primary text-primary ';
                                                break;
                                            case 'DONE':
                                            case 'CLOSE':
                                                $statusClass = 'bg-light-success text-success';
                                                break;
                                            case 'REJECT':
                                                $statusClass = 'bg-light-danger text-danger';
                                                break;
                                            default:
                                                $statusClass = 'bg-light-secondary text-gray-800';
                                        }

                                        // Define status text based on MR_Status
                                        $statusText = '';
                                        switch ($materialRequest->MR_Status) {
                                            case 'AP1':
                                                $statusText = 'Approved 1';
                                                break;
                                            case 'AP2':
                                                $statusText = 'Approved 2';
                                                break;
                                            case 'AP3':
                                                $statusText = 'Approved 3';
                                                break;
                                            case 'AP4':
                                                $statusText = 'Approved 4';
                                                break;
                                            case 'AP5':
                                                $statusText = 'Approved 5';
                                                break;
                                            default:
                                                $statusText = strtoupper($materialRequest->MR_Status);
                                        }
                                    @endphp

                                    <span class="fw-bold p-2 fs-7 rounded {{ $statusClass }}">
                                        {{ $statusText }}
                                    </span>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row Status-->

                            <!--begin::Row MR Allotment-->
                            <div class="row mb-7 pb-4">
                                <!--begin::Label-->
                                <label class="col-lg-2 fw-semibold text-muted fs-5">Case Suggestion</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-10">
                                    <textarea class="form-control form-control-solid fw-bold fs-5 text-gray-900" rows="3" name="suggest" id="suggest" readonly>{{ $materialRequest->MR_Allotment}}</textarea>
                                    </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row MR Allotment-->


                            {{-- Table --}}
                            <div class="row mb-10">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label fw-semibold fs-5 text-muted">
                                    Material Request List
                                </label>
                                <!--end::Label-->
                                <div class="table-responsive">
                                    <table class="table table-rounded table-striped border gy-7 gs-7" id="material-table">
                                        <thead>
                                            <tr class="fw-semibold fs-6 text-gray-800 border-bottom border-gray-200">
                                                <th style="width: 20%;">Item</th>
                                                <th style="width: 20%;">Qty</th>
                                                <th style="width: 20%;">Unit</th>
                                                <th style="width: 25%;">Description</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($details as $detail)
                                                <tr>
                                                    <td>{{ $detail->CR_ITEM_NAME }}</td>
                                                    <td>{{ $detail->Item_Oty }}</td>
                                                    <td>{{ $detail->CR_ITEM_SATUAN }}</td>
                                                    <td>{{ $detail->Remark }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        {{-- End Detail Case --}}
                            {{-- Approval remark --}}
                            <div class="row mb-5 ">
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
                                    @for($i = 1; $i <= $materialRequest->MR_APMaxStep; $i++)
                                        @php
                                            $remark = strip_tags($materialRequest['MR_RMK' . $i] ?? '');
                                            $stepCode = 'AP' . $i;
                                            $isRejected = $materialRequest->MR_Status === 'REJECT';

                                            // Ambil log sesuai status dan step
                                            $logStatus = [
                                                'approve' => 'APPROVED ' . $i,
                                                'reject' => 'REJECTED ' . $i,
                                            ];

                                            $approvedLog = $logs->first(function($log) use ($logStatus, $stepCode) {
                                                return in_array($log->LOG_Status, $logStatus) && $log->LOG_Type === 'MR';
                                            });

                                            if ($remark) {
                                                $status = $isRejected ? 'Rejected' : 'Approved';
                                                $badgeClass = $isRejected ? 'badge badge-light-danger' : 'badge badge-light-success';
                                                $icon = $isRejected ? 'bi-x-circle-fill text-danger' : 'bi-check-circle-fill text-success';
                                            } else {
                                                $status = 'Pending';
                                                $badgeClass = 'badge badge-light-warning text-dark';
                                                $icon = 'bi-hourglass-split';
                                            }

                                            $bgClass = match($status) {
                                                'Approved' => 'bg-success bg-opacity-10',
                                                'Rejected' => 'bg-danger bg-opacity-10',
                                                default => 'bg-secondary bg-opacity-10'
                                            };
                                        @endphp

                                        <!--begin::Timeline item-->
                                        <div class="timeline-item align-items-start">
                                            <div class="timeline-line w-40px"></div>
                                            <div class="timeline-icon symbol symbol-circle symbol-40px">
                                                <div class="symbol-label bg-light">
                                                    <i class="ki-duotone ki-document fs-2">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                </div>
                                            </div>

                                            <div class="timeline-content ps-3 mb-10 mt-n1">
                                                <!--begin::Timeline heading-->                                                   
                                                <div class="pe-3 mb-5">
                                                    <div class="fs-5 fw-semibold mb-2">Approval Step {{ $i }} - {{ $materialRequest->{'approver'.$i}->Fullname ?? 'Unknown User' }}</div>
                                                    <div class="d-flex align-items-center mt-1 fs-6">
                                                        <div class="text-muted me-2 fs-7">
                                                            @if($approvedLog)
                                                                {{ $approvedLog->LOG_Status }} on {{ \Carbon\Carbon::parse($approvedLog->LOG_Date)->format('d/m/Y H:i') }}
                                                            @else
                                                                Waiting for Approval...
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--end::Timeline heading-->

                                                <!--begin::Timeline details-->
                                                <div class="overflow-auto pb-5">
                                                    <div class="notice d-flex bg-light-primary card-rounded border-3 border-primary border-dashed min-w-lg-600px flex-shrink-0 p-4 p-lg-5 align-items-center gap-4">
                                                        <i class="bi {{ $icon }} fs-3tx text-gray-800"></i>
                                                        
                                                        <div class="d-flex flex-grow-1 justify-content-between align-items-center">
                                                            <div class="fw-semibold">
                                                                <h5 class="text-gray-900 fw-bold mb-2 fs-4">Remark:</h5>
                                                                <p class="text-gray-700 fs-5 mb-0">{{ $remark ?: 'No remark provided.' }}</p>
                                                            </div>
                                                            <span class="{{ $badgeClass }} px-3 py-2 d-inline-flex align-items-center gap-1 fs-5">
                                                                <i class="bi {{ $icon }}"></i> {{ $status }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--end::Timeline details-->
                                            </div>
                                        </div>
                                        <!--end::Timeline item-->
                                    @endfor
                                </div>
                            </div>
                        </div>
                        {{-- End Detail Case --}}   
                    </div>
                </div>
            </div>
        </div>
    </div>

<<<<<<< HEAD
{{-- <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">
            <div class="card p-4">
                <div class="d-flex justify-content-between align-items-center mb-4 mt-5">
                    <h1 class="text-primary fw-bold mb-0">Material Request Details: {{ $materialRequest->MR_No }}</h1>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-4">
                            <label class="form-label text-muted"><strong>Work Order No</strong></label>
                            <p class="fs-5 fw-bold text-dark">{{ $materialRequest->WO_No }}</p>
                        </div>
                        <div class="mb-4">
                            <label class="form-label text-muted"><strong>Case No</strong></label>
                            <p class="fs-5 fw-bold text-dark">{{ $materialRequest->Case_No }}</p>
                        </div>
                        <div class="mb-4">
                            <label class="form-label text-muted"><strong>Request Date</strong></label>
                            <p class="fs-5 fw-bold text-dark">{{ $materialRequest->MR_Date }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-4">
                            <label class="form-label text-muted"><strong>Urgent</strong></label>
                            <p class="fs-5 fw-bold text-dark">{{ $materialRequest->MR_IsUrgent == 'Y' ? 'Yes' : 'No' }}</p>
                        </div>
                        <div class="mb-4">
                            <label class="form-label text-muted"><strong>Status</strong></label>
                            <p class="fs-5 fw-bold">
                                <span class="badge 
                                    {{
                                        $materialRequest->MR_Status == 'Open' ? 'bg-light-warning' :
                                        ($materialRequest->MR_Status == 'Close' ? 'bg-light-success' :
                                        ($materialRequest->MR_Status == 'Reject' ? 'bg-light-danger' : 'bg-light-primary text-primary fs-6'))
                                    }}">
                                    {{
                                        $materialRequest->MR_Status == 'AP1' ? 'Approved 1' :
                                        ($materialRequest->MR_Status == 'AP2' ? 'Approved 2' :
                                        ($materialRequest->MR_Status == 'AP3' ? 'Approved 3' :
                                        ($materialRequest->MR_Status == 'AP4' ? 'Approved 4' :
                                        ($materialRequest->MR_Status == 'AP5' ? 'Approved 5' :
                                        strtoupper($materialRequest->MR_Status)))))
                                    }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="mb-3">
                    <h4 class="text-primary fw-bold">Material Items</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 40%;">Item</th>
                                    <th style="width: 15%;">Qty</th>
                                    <th style="width: 15%;">Unit</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($details as $detail)
                                    <tr>
                                        <td>{{ $detail->CR_ITEM_NAME }}</td>
                                        <td>{{ $detail->Item_Oty }}</td>
                                        <td>{{ $detail->CR_ITEM_SATUAN }}</td>
                                        <td>{{ $detail->Remark }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div> --}}
=======
    {{-- LOG Modal --}}
    <div class="modal fade" tabindex="-1" id="kt_modal_scrollable_2">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                
                <div class="modal-header">
                    <h3 class="modal-title text-primary fw-bold">Log History - Case {{ $materialRequest->MR_No }}</h3>
                    <button type="button" class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </button>
                </div>
    
                {{-- <div class="modal-body"> --}}
                    <div class="modal-body" style="max-height: 500px; overflow-y: auto;">
                    @php
                        $allowedStatuses = ['CREATED', 'SUBMITTED', 'APPROVED 1', 'APPROVED 2', 'APPROVED 3', 'APPROVED 4', 'APPROVED 5', 'INPROGRESS', 'CLOSE', 'REJECTED 1', 'REJECTED 2', 'REJECTED 3', 'REJECTED 4', 'REJECTED 5', 'REJECT_RESET', 'DONE' ];
                        $statusColors = [
                            'CREATED'    => 'bg-light-warning text-warning',
                            'SUBMITTED'  => 'bg-light-primary text-primary',
                            'APPROVED 1'  => 'bg-light-primary text-primary',
                            'APPROVED 2'  => 'bg-light-primary text-primary',
                            'APPROVED 3'  => 'bg-light-primary text-primary',
                            'APPROVED 4'  => 'bg-light-primary text-primary',
                            'APPROVED 5'  => 'bg-light-primary text-primary',
                            'REJECTED 1'  => 'bg-light-danger text-danger',
                            'REJECTED 2'  => 'bg-light-danger text-danger',
                            'REJECTED 3'  => 'bg-light-danger text-danger',
                            'REJECTED 4'  => 'bg-light-danger text-danger',
                            'REJECTED 5'  => 'bg-light-danger text-danger',
                            'INPROGRESS' => 'bg-light-info text-info',
                            'CLOSE'      => 'bg-light-success text-success',
                            'DONE'      => 'bg-light-success text-success',
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
                                            <div class="text-muted fs-7">{{ \Carbon\Carbon::parse($log->LOG_Date)->format('d M Y, H:m') }}</div>
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
                            const mrNo = "{{ base64_encode($materialRequest->MR_No) }}";
                            window.location.href = `http://localhost/BmMaintenance/public/Material-Request/Edit/${mrNo}`;
                        }
                    });
                });
            }
        });
    </script>
>>>>>>> ff25b43 (Update)

    <script>
        const BASE_URL = "{{ url('/') }}";
    </script>
<<<<<<< HEAD

        {{-- LOG Modal --}}
        <div class="modal fade" tabindex="-1" id="kt_modal_log">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    
                    <div class="modal-header">
                        <h3 class="modal-title text-primary fw-bold">Log History - Case {{ $materialRequest->MR_No }}</h3>
                        <button type="button" class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                        </button>
                    </div>
        
                    <div class="modal-body">
                        @php
                            $allowedStatuses = ['OPEN','SUBMITTED','AP1','AP2','AP3','AP4','AP5','CLOSE','REJECT','INPROGRESS'];
                            $statusColors = [
                                'OPEN'    => 'bg-light-warning text-warning',
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
                                                <div class="text-muted fs-7">{{ \Carbon\Carbon::parse($log->LOG_Date)->format('d M Y, H:m') }}</div>
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
=======
>>>>>>> ff25b43 (Update)
@endsection

