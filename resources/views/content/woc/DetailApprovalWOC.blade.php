@extends('layouts.Master')

@section('title', 'BM-Maintenance')
@section('subtitle', 'Approval Work Order Complition')

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
                                <h3 class="fw-bold m-0 text-primary">Approval Work Order Detail : {{ $workOrder->WO_No }} </h3>
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
                                    <span class="fw-bold fs-5 text-dark">{{ $workOrder->Created_By }}</span>
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
                                            case 'Submit':
                                            case 'SUBMIT_COMPLETION' :
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
                                            case 'DONE' :
                                                $badgeClass = 'badge-success';
                                                break;
                                        }
                                    @endphp
                            
                                    <span class="badge {{ $badgeClass }} fw-semibold fs-6">{{ $status }}</span>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row WO Status-->

                            <!--begin::Row WO Completed-->
                            <div class="row mb-7 pb-4">
                                <!--begin::Label-->
                                <label class="col-lg-2 fw-semibold text-muted fs-5">Completed By</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-10">
                                    <span class="fw-bold fs-5 text-dark">{{ $workOrder->Created_By }}</span>
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

                            <div class="row mb-5 pb-5">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                    <span class="required">Existing Image</span>
                                    <span class="ms-1" data-bs-toggle="tooltip" title="This is the currently uploaded image. You can keep or replace it.">
                                        <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>
                                    </span>
                                </label>

                                <div id="existing-photos" class="d-flex flex-row flex-wrap gap-4">
                                    @foreach($wocImages as $index => $image)
                                        <div class="d-flex flex-column align-items-center" id="image-container-{{ $image->IMG_No }}">
                                            <!-- Gambar + Overlay -->
                                            <a class="d-block overlay position-relative rounded shadow-sm"
                                            data-fslightbox="lightbox-case-images"
                                            href="{{ asset('storage/woc_photos/' . str_replace(['/', '\\'], '-', $workOrder->WO_No) . '/' . $image->IMG_Filename) }}">
                                            
                                                <div class="overlay-wrapper card-rounded bgi-no-repeat bgi-position-center bgi-size-cover"
                                                    style="background-image:url('{{ asset('storage/woc_photos/' . str_replace(['/', '\\'], '-', $workOrder->WO_No) . '/' . $image->IMG_Filename) }}'); width: 100px; height: 120px; border-radius: 0.65rem;">
                                                </div>

                                                <div class="overlay-layer card-rounded bg-dark bg-opacity-50 shadow d-flex align-items-center justify-content-center position-absolute top-0 start-0 w-100 h-100 rounded"
                                                    style="transition: all 0.3s ease;">
                                                    <i class="bi bi-eye-fill text-white fs-2x"></i>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!--TABLE MATERIAL Request-->
                            @foreach ($matReqs as $mr)
                                <div class="mt-5 pt-5">
                                    <div class="row pb-5">
                                        <!--begin::Label-->
                                        <label class="col-lg-2 fw-semibold text-muted fs-5">MR No | Status </label>
                                        <!--end::Label-->
                                        <!--begin::Col-->
                                        <div class="col-lg-10">
                                            <span class="fw-bold fs-5 text-dark">{{ $mr->MR_No }} |
                                        <span class="badge badge-light-{{ $mr->MR_Status == 'Approved' ? 'success' : ($mr->MR_Status == 'Rejected' ? 'danger' : 'success') }}">
                                            {{ $mr->MR_Status }}
                                        </span></span>
                                        </div>
                                        <!--end::Col-->
                                    </div>

                                    <h4 class="fw-bold mb-4">Material Request</h4>

                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered gy-5 gs-7">
                                            <thead>
                                                <tr class="fw-semibold fs-6 text-gray-800">
                                                    <th class="pe-7">Line</th>
                                                    <th>Item Code</th>
                                                    <th>Item Name</th>
                                                    <th>Qty</th>
                                                    <th>UOM</th>
                                                    <th>Description</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($matReqChildren[$mr->MR_No] ?? [] as $child)
                                                    <tr>
                                                        <td>{{ $child->MR_Line }}</td>
                                                        <td>{{ $child->Item_Code }}</td>
                                                        <td>{{ $child->Item_Name }}</td>
                                                        <td>{{ $child->Item_Oty }}</td>
                                                        <td>{{ $child->UOM_Name }}</td>
                                                        <td>{{ $child->Remark }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endforeach

                            <!--TABLE TEKNISI-->
                            <div class="mt-10">
                                <h4 class="fw-bold mb-4">Technicians Assigned</h4>
                                @if ($technicians->isEmpty())
                                    <p class="text-muted">No technicians assigned for this Work Order.</p>
                                @else
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered gy-5 gs-7">
                                            <thead>
                                                <tr class="fw-semibold fs-6 text-gray-800">
                                                    <th class="pe-7">Technician ID</th>
                                                    <th>Name</th>
                                                    <th>Specialization</th>
                                                    <th>Phone</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($technicians as $tech)
                                                    <tr>
                                                        <td>{{ $tech->technician_id }}</td>
                                                        <td>{{ $tech->technician_Name }}</td>
                                                        <td>{{ $tech->specialization ?? '-' }}</td>
                                                        <td>{{ $tech->phone ?? '-' }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>

                                        </table>
                                    </div>
                                @endif
                            </div>

                            <!--Approval-->
                            <div class="timeline timeline-border-dashed pt-10">
                                <div class="row pb-5">
                                    <!--begin::Label-->
                                    <label class="col-lg-2 fw-semibold text-muted fs-5">Approval & Remark </label>
                                    <!--end::Label-->
                                </div>
                                @php
                                    $logs = $logs instanceof Collection ? $logs : collect($logs);

                                    $approvalSteps = [
                                        1 => ['label' => 'Approval 1', 'status' => 'APPROVED 1', 'remark' => 'WO_RMK1', 'approver' => $workOrder->Approver1 ?? 'Unknown User'],
                                        2 => ['label' => 'Approval 2', 'status' => 'APPROVED 2', 'remark' => 'WO_RMK2', 'approver' => $workOrder->Approver2 ?? 'Unknown User'],
                                    ];
                                    $userId = Auth::id();
                                @endphp

                                @foreach($approvalSteps as $step => $info)
                                    @php
                                        $log = $logs->first(fn($log) => $log->LOG_Status === $info['status'] && $log->LOG_Type === 'WO');
                                    @endphp

                                    <div class="timeline-item">
                                        <div class="timeline-line"></div>
                                        <div class="timeline-icon">
                                            <i class="ki-duotone {{ $step === $workOrder->WO_APStep ? 'ki-notepad-edit text-gray-900' : 'ki-folder-added text-gray-500' }} fs-2">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>                                        
                                        </div>

                                        <div class="timeline-content mb-10 mt-n1">
                                            <div class="pe-3 mb-5">
                                                <div class="fs-5 fw-semibold mb-2">
                                                    @if($workOrder->WO_APStep == $step)
                                                        Require Your Approval ({{ $info['label'] }})
                                                    @elseif($step < $workOrder->WO_APStep)
                                                        Approved by {{ $info['approver'] }}
                                                    @else
                                                        Waiting for Approval ({{ $info['label'] }})
                                                    @endif
                                                </div>

                                                <div class="d-flex align-items-center mt-1 fs-6">
                                                    <div class="text-muted me-2 fs-7">
                                                        @if($log)
                                                            Approved at {{ \Carbon\Carbon::parse($log->LOG_Date)->format('d/m/Y H:i') }}
                                                        @elseif($step < $workOrder->WO_APStep)
                                                            Log not found.
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            @if($step < $workOrder->WO_APStep)
                                                <div class="border border-dashed border-primary dashed-2 rounded px-7 py-3 bg-light-primary">
                                                    <h5 class="text-gray-700 fw-bold mb-2">Remark:</h5>
                                                    <div class="text-gray-600">
                                                        {{ strip_tags($workOrder->{$info['remark']}) ?: 'No remark provided.' }}
                                                    </div>
                                                </div>
                                            @elseif($step === $workOrder->WO_APStep && (
                                                ($step === 1 && $userId === $workOrder->WO_AP1) ||
                                                ($step === 2 && $userId === $workOrder->WO_AP2) ||
                                                ($step === 3 && $userId === $workOrder->WO_AP3) ||
                                                ($step === 4 && $userId === $workOrder->WO_AP4)
                                            ))
                                                <div class="col-lg-12"> 
                                                    <form action="" method="POST">
                                                        @csrf
                                                        <input type="hidden" id="approvalNotes" name="approvalNotes">
                                                        <div id="kt_docs_quill_basic" name="kt_docs_quill_basic" style="height: 100px">
                                                            <p class="text-muted fw-semibold">Input Your Remark or Notes Here</p>                                
                                                        </div>
                                                        <div class="d-flex justify-content-end mt-4">
                                                            <button type="button" class="btn btn-success me-2 approve-reject-btn" data-action="approve">Approve</button>
                                                            <button type="button" class="btn btn-danger approve-reject-btn" data-action="reject">Reject</button>
                                                        </div>
                                                    </form>   
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                        </div>
                        {{-- End Detail Work Order  --}}    
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Page loader --}}
    <div id="page_loader" style="
        display: none;
        position: fixed;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background: rgba(88, 88, 88, 0.7);
        z-index: 9999;
        justify-content: center;
        align-items: center;
        flex-direction: column;">
        <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
            <span class="visually-hidden">Loading...</span>
        </div>
        <div style="margin-top: 15px; color: #fff; font-size: 1.25rem;">Loading...</div>
    </div>

    
    <script>
        const BASE_URL = "{{ url('/') }}";
    </script>
    
    <script src="{{ asset('assets/plugins/custom/fslightbox/fslightbox.bundle.js') }}"></script>

    {{-- Script Approve & Remark --}}
    {{-- <script>
        $(document).ready(function () {
            $(".approve-reject-btn").click(function (e) {
                e.preventDefault();

                let action = $(this).data("action");
                let woNo = encodeURIComponent(btoa("{{ $workOrder->WO_No }}"));
                let quillContent = quill.root.innerHTML;    

                $("#page_loader").css("display", "flex");

                setTimeout(() => {
                    $("#page_loader").hide();

                    Swal.fire({
                        title: (action === "approve") ? "Approve Work Order?" : "Reject Work Order?",
                        text: (action === "approve") ? "Are you sure you want to approve this work order?" : "Are you sure you want to reject this work order?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: (action === "approve") ? "Yes, Approve" : "Yes, Reject",
                        cancelButtonText: "Cancel"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $("#page_loader").css("display", "flex");

                            $.ajax({
                                url: `/WorkOrder-Complition/approve-reject/${woNo}`,
                                type: "POST",
                                data: {
                                    _token: "{{ csrf_token() }}",
                                    action: action,
                                    approvalNotes: quillContent
                                },
                                success: function (response) {
                                    $("#page_loader").hide();
                                    Swal.fire({
                                        title: "Success!",
                                        text: response.message,
                                        icon: "success"
                                    }).then(() => {
                                        window.location.href = `${BASE_URL}/WorkOrder/Approval-list`;
                                    });
                                },
                                error: function (xhr) {
                                    $("#page_loader").hide();
                                    Swal.fire("Error", xhr.responseJSON?.message || "An error occurred while processing", "error");
                                    console.log('Error');
                                }
                            });
                        }
                    });
                }, 1000);
            });
        });
    </script> --}}

    <script>
       var quill = new Quill('#kt_docs_quill_basic', {
            theme: 'snow'
        });

        document.querySelectorAll('.approve-reject-btn').forEach(button => {
            button.addEventListener('click', function () {
                const action = this.getAttribute('data-action');
                const notes = quill.root.innerHTML.trim();

                if (
                    notes === '' ||
                    notes === '<p><br></p>' ||
                    notes.includes('Input Your Remark or Notes Here')
                ) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Empty Note',
                        text: 'Please enter your note or remark before proceeding.',
                    });
                    return;
                }

                Swal.fire({
                    title: `Are you sure you want to ${action.toUpperCase()} this Work Order Completion?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#198754',
                    cancelButtonColor: '#dc3545',
                    confirmButtonText: 'Yes!',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        const formData = {
                            _token: '{{ csrf_token() }}',
                            approvalNotes: notes,
                            action: action
                        };

                        fetch("{{ route('workorder.approveReject', ['wo_no' => base64_encode($workOrder->WO_No)]) }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify(formData)
                        })
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('HTTP error ' + response.status);
                                }
                                return response.json();
                            })
                            .then(data => {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: data.message,
                                confirmButtonColor: '#198754'
                            }).then(() => {
                                document.getElementById("page_loader").style.display = "flex";

                                setTimeout(() => {
                                    window.location.href = "http://localhost/BmMaintenance/public/WorkOrder-Complition/List-Approval";
                                }, 1000);
                            });
                        })
                    }
                });
            });
        });
    </script>

  
@endsection

