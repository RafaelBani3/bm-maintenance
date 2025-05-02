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
                            <div class="card-title d-flex justify-content-between align-items-center w-100">
                                <h3 class="fw-bold m-0 text-primary">Material Request Detail : {{ $materialRequest->MR_No }} </h3>
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
                                        {{ \Carbon\Carbon::parse($materialRequest    ->CR_DT)->format('d/m/Y H:m') }}
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
                                <div class="col-lg-10 fs-5">
                                    @php
                                        // Define status class based on MR_Status
                                        $statusClass = '';
                                        switch ($materialRequest->MR_Status) {
                                            case 'OPEN':
                                                $statusClass = 'bg-light-warning';
                                                break;
                                            case 'SUBMITTED':
                                                $statusClass = 'bg-light-primary text-primary ';
                                                break;
                                            case 'CLOSE':
                                                $statusClass = 'bg-light-success';
                                                break;
                                            case 'REJECT':
                                                $statusClass = 'bg-light-danger';
                                                break;
                                            default:
                                                $statusClass = 'bg-light-secondary text-primary fs-6';
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

                                    <span class="fw-bold fs-5 {{ $statusClass }}">
                                        {{ $statusText }}
                                    </span>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row Status-->

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
                    </div>
                </div>
            </div>
        </div>
    </div>

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

    <script>
        const BASE_URL = "{{ url('/') }}";
    </script>

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
@endsection

