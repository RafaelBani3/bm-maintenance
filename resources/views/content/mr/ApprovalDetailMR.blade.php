@extends('layouts.Master')

@section('title', 'BM-Maintenance')
@section('subtitle', 'Material Request - Approval Detail Material Request')

@section('content')

    {{-- <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
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
                                <h3 class="fw-bold m-0 text-primary">Approval Material Request Detail</h3>
                        
                            </div>
                            <!--end::Title-->                          
                        </div>

                        <div class="card-body p-9">
                            
                            <!--begin::Reference No (Case No)-->
                            <div class="row mb-10 pb-4">
                                <!--begin::Label-->
                                <label class="col-lg-2 col-form-label required fw-semibold fs-5 text-muted">
                                    <span>Reference No.</span>
                                    <span class="ms-1" data-bs-toggle="tooltip" title="This is the current Case reference number.">
                                        <i class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>
                                    </span>
                                </label>
                                <!--end::Label-->

                                <!--begin::Input-->
                                <div class="col-lg-10 fv-row">
                                    <select class="form-select form-select-lg form-select-solid" 
                                            id="reference_number" name="reference_number" 
                                            data-control="select2" data-placeholder="Select Reference No">
                                        <option></option>
                                    </select>
                                </div>
                                <!--end::Input-->
                            </div>
                            <!--end::Reference No (Case No)-->

                            <!--begin::Row Material NO-->
                            <div class="row mb-7 pb-4">
                                <!--begin::Label-->
                                <label class="col-lg-2 fw-semibold text-muted fs-5">Material Request No</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-10">
                                    <span id="mr_no_display" class="fw-bold fs-5 text-primary">-</span>
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
                                    <span id="wo_no_display" class="fw-bold fs-5 text-primary">-</span>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row Work Order NO-->

                            <!--begin::Row Created By-->
                            <div class="row mb-7 pb-4">
                                <!--begin::Label-->
                                <label class="col-lg-2 fw-semibold text-muted fs-5">Created By</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-10">
                                    <span id="Created_By" class="fw-bold fs-5 text-dark">-</span>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row Created By-->

                            <!--begin::Row Departement-->
                            <div class="row mb-7 pb-4">
                                <!--begin::Label-->
                                <label class="col-lg-2 fw-semibold text-muted fs-5">Departement</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-10">
                                    <span id="Departement" class="fw-bold fs-5 text-dark">-</span>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row Departement-->

                            <!--begin::Row Created Date-->
                            <div class="row mb-7 pb-4">
                                <!--begin::Label-->
                                <label class="col-lg-2 fw-semibold text-muted fs-5">Request Date</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-10">
                                    <span id="RequestDate" class="fw-bold fs-5 text-dark">-</span>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row Created Date-->

                            <!--begin::Row MR Allotment-->
                            <div class="row mb-7 pb-4">
                                <label class="col-lg-2 fw-semibold text-muted fs-5">MR Allotment</label>
                                <div class="col-lg-10">
                                    <span id="mr_allotment" class="fw-bold fs-5 text-dark">-</span>
                                </div>
                            </div>

                            <!--begin::Row Status-->
                            <div class="row mb-7 pb-4">
                                <!--begin::Label-->
                                <label class="col-lg-2 fw-semibold text-muted fs-5">MR Status</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-10 fs-5">
                                    <span id="mr_status" class="fw-bold fs-5">-</span>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row Status-->

                            <div class="row mb-10">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label fw-semibold fs-5 text-muted">
                                    Creator's Material Requests
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
                    </div>
                </div>
            </div>
        </div>
    </div> --}}


    {{-- Design 2 --}}
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
                                <h3 class="fw-bold m-0 text-primary">Approval Material Request Detail : {{ $materialRequest->MR_No }} </h3>
                           
                            </div>
                            <!--end::Title-->                          
                        </div>

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

                            <!--begin::Row Allotment-->
                            <div class="row mb-7 pb-4">
                                <!--begin::Label-->
                                <label class="col-lg-2 fw-semibold text-muted fs-5">MR_Allotement</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-10">
                                    <span class="fw-bold fs-5 text-dark">
                                        {{ $materialRequest->MR_Allotment }}
                                    </span>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row Allotment-->

                            <!--begin::Row Status-->
                            <div class="row mb-7 pb-4">
                                <!--begin::Label-->
                                <label class="col-lg-2 fw-semibold text-muted fs-5">MR Status</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                
                                <div class="col-lg-10 fs-5">
                                    @php
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

                                    <span id="mr_status_display" class="fw-bold p-1 fs-7 rounded {{ $statusClass }}">
                                        {{ $statusText }}
                                    </span>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row Status-->

                            <div class="row mb-10">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label fw-semibold fs-5 text-muted">
                                    Creator's Material Requests
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

                            {{-- Table Material --}}
                            @if($materialRequest->MR_APStep == 1 && $materialRequest->MR_Status == 'SUBMIT' && is_null($materialRequest->MR_RMK1))
                                {{-- Approver Material-Request --}}
                                <div class="row mb-5">
                                    <!--begin::Label-->
                                    <label class="col-lg-4 col-form-label required fw-semibold fs-5 text-muted">
                                        Add Material List
                                    </label>
                                    <!--end::Label-->
                                    
                                    <div class="table-responsive">
                                        <table class="table table-rounded table-striped border gy-7 gs-7" id="material-table">
                                            <thead>
                                                <tr class="fw-semibold fs-6 text-gray-800 border-bottom border-gray-200">
                                                    <th>No</th>
                                                    <th>Quantity</th>
                                                    <th>Unit</th>
                                                    <th>Item Code</th>
                                                    <th>Item Name</th>
                                                    <th>Stock</th>
                                                    <th>Description</th>
                                                </tr>
                                            </thead>
                                            <tbody id="material-body">
                                                @foreach($details as $index => $detail)
                                                <tr>
                                                    <td class="text-center">{{ $detail->MR_Line }}</td>
                                                    <td>
                                                        <input type="hidden" name="items[{{ $index }}][mr_line]" value="{{ $detail->MR_Line }}">
                                                        <input style="width: 100px" type="number" name="items[{{ $index }}][qty]" class="form-control" value="{{ $detail->Item_Oty }}" readonly>
                                                    </td>
                                                    <td style="width: 140px"><input type="text" name="items[{{ $index }}][unit]" class="form-control uom-name" placeholder="Input Unit" readonly></td>
                                                    <td style="width: 190px">
                                                        <select name="items[{{ $index }}][code]" class="form-control item-code"></select>
                                                    </td>
                                                    <td style="width: 230px"><input type="text" name="items[{{ $index }}][name]" class="form-control item-name" placeholder="Material's Name" readonly></td>
                                                    <td><input type="text" name="items[{{ $index }}][stock]" class="form-control item-stock" placeholder="Material's Stock"></td>
                                                    <td><input type="text" name="items[{{ $index }}][desc]" class="form-control item-desc" placeholder="Material's Description" value=""></td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif

                            {{-- Approval --}}
                            <div class="timeline timeline-border-dashed">
                                <!--begin::Label-->
                                    <label class="col-lg-4 col-form-label required fw-semibold fs-5 pb-5 text-muted">
                                        Approval & Remark Manager
                                    </label>
                                    <!--end::Label-->
                                @php
                                    $logs = $logs instanceof Collection ? $logs : collect($logs);

                                    $approvalSteps = [
                                        1 => ['label' => 'Approval 1', 'status' => 'APPROVED 1', 'remark' => 'MR_RMK1', 'approver' => $materialRequest->Approver1->Fullname ?? 'Unknown User'],
                                        2 => ['label' => 'Approval 2', 'status' => 'APPROVED 2', 'remark' => 'MR_RMK2', 'approver' => $materialRequest->Approver2->Fullname ?? 'Unknown User'],
                                        3 => ['label' => 'Approval 3', 'status' => 'APPROVED 3', 'remark' => 'MR_RMK3', 'approver' => $materialRequest->Approver3->Fullname ?? 'Unknown User'],
                                        4 => ['label' => 'Approval 4', 'status' => 'APPROVED 4', 'remark' => 'MR_RMK4', 'approver' => $materialRequest->Approver4->Fullname ?? 'Unknown User'],
                                    ];
                                        $userId = Auth::id();
                                @endphp

                                @foreach($approvalSteps as $step => $info)
                                    @php
                                        $log = $logs->first(fn($log) => $log->LOG_Status === $info['status'] && $log->LOG_Type === 'MR');
                                    @endphp
                                    
                                    <div class="timeline-item">
                                        <div class="timeline-line"></div>
                                        <div class="timeline-icon">
                                            <i class="ki-duotone {{ $step === $materialRequest->MR_APStep ? 'ki-notepad-edit text-gray-900' : 'ki-folder-added text-gray-500' }} fs-2">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>                                        
                                        </div>

                                        <div class="timeline-content mb-10 mt-n1">
                                            <div class="pe-3 mb-5">
                                                <div class="fs-5 fw-semibold mb-2">
                                                    @if($materialRequest->MR_APStep == $step)
                                                        Require Your Approval ({{ $info['label'] }})
                                                    @elseif($step < $materialRequest->MR_APStep)
                                                        Approved by {{ $info['approver'] }}
                                                    @else
                                                        Waiting for Approval ({{ $info['label'] }})
                                                    @endif
                                                </div>

                                                <div class="d-flex align-items-center mt-1 fs-6">
                                                    <div class="text-muted me-2 fs-7">
                                                        @if($log)
                                                            Approved at {{ \Carbon\Carbon::parse($log->LOG_Date)->format('d/m/Y H:i') }}
                                                        @elseif($step < $materialRequest->MR_APStep)
                                                            Log not found.
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            @if($step < $materialRequest->MR_APStep)
                                                <div class="border border-dashed border-primary rounded px-7 py-3 bg-light-primary">
                                                    <h5 class="text-gray-900 fs-5 fw-bold mb-2">Remark:</h5>
                                                    <div class="text-gray-800 fs-6">
                                                        {{ strip_tags($materialRequest->{$info['remark']}) ?: 'No remark provided.' }}
                                                    </div>
                                                </div>
                                            @elseif($step === $materialRequest->MR_APStep && (
                                                ($step === 1 && $userId === $materialRequest->MR_AP1) ||
                                                ($step === 2 && $userId === $materialRequest->MR_AP2) ||
                                                ($step === 3 && $userId === $materialRequest->MR_AP3) ||
                                                ($step === 4 && $userId === $materialRequest->MR_AP4)
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
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Page pageLoader --}}
    <div id="page_loader" class="page-loader flex-column bg-dark bg-opacity-25" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 9999; align-items: center; justify-content: center;">
        <span class="spinner-border text-primary" role="status"></span>
        <span class="text-white-800 fs-6 fw-semibold mt-5 text-white">Loading...</span>
    </div>

    <script>
        const BASE_URL = "{{ url('/') }}";
    </script>

    <meta name="base-url" content="{{ url('/') }}">

    {{-- Script API Item Code KPN --}}
    <script>
        $(document).ready(function() {
            function initializeSelect2(row) {
                row.find('.item-code').select2({
                    placeholder: "Select item",
                    minimumInputLength: 1,
                    ajax: {
                        url: 'http://10.10.10.86:8088/erp_api/api/ifca/get/item',
                        dataType: 'json',
                        delay: 250,
                        headers: {
                            'Accept': 'application/json'
                        },
                        data: function(params) {
                            return {
                                search: params.term
                            };
                        },
                        processResults: function(data) {
                            return {
                                results: data.data.item.map(function(item) {
                                    return {
                                        id: item.item_cd,
                                        item_name: item.item_descs,
                                        text: item.item_cd + ' - ' + item.item_descs,
                                        // item_stock: 'Input Material Stock',
                                        // item_desc: item.item_remark ?? '-'
                                        uom_name : item.uom,
                                    };
                                })
                            };
                        },
                        cache: true
                    },
                    templateResult: function(item) {
                        return item.text; 
                    },
                    templateSelection: function(item) {
                        return item.id || item.text;
                    }
                }).on('select2:select', function(e) {
                    let data = e.params.data;
                    let row = $(this).closest('tr');
                    
                    row.find('.uom-name').val(data.uom_name);
                    row.find('.item-name').val(data.item_name);
                    row.find('.item-stock').val(data.item_stock);
                    row.find('.item-desc').val(data.item_desc);
                });
            }
    
            function updateRowNumbers() {
                $('#material-body tr').each(function(index, row) {
                    $(row).find('td:first-child').text(index + 1);
                    $(row).find('input, select').each(function() {
                        let name = $(this).attr('name');
                        if (name) {
                            let newName = name.replace(/\d+/, index);
                            $(this).attr('name', newName);
                        }
                    });
                });
            }
    
            $('#add-row').click(function() {
                let rowCount = $('#material-body tr').length;
                let newRow = $(`
                    <tr>
                        <td class="text-center">${rowCount + 1}</td>
                        <td><input type="number" name="items[${rowCount}][qty]" class="form-control"></td>
                        <td><input type="text" name="items[${rowCount}][unit]" class="form-control"></td>
                        <td>
                            <select name="items[${rowCount}][code]" class="form-control item-code"></select>
                        </td>
                        <td><input type="text" name="items[${rowCount}][name]" class="form-control item-name" readonly></td>
                        <td><input type="text" name="items[${rowCount}][stock]" class="form-control item-stock" readonly></td>
                        <td><input type="text" name="items[${rowCount}][desc]" class="form-control item-desc" readonly></td>
                        <td class="text-center">
                            <button type="button" class="btn btn-danger remove-row">
                                X
                            </button>
                        </td>
                    </tr>
                `);
                
                $('#material-body').append(newRow);
                initializeSelect2(newRow);
                updateRowNumbers();
            });
    
            $(document).on('click', '.remove-row', function() {
                $(this).closest('tr').remove();
                updateRowNumbers();
            });
    
            initializeSelect2($('#material-body tr'));
        });
    </script>
    
    {{-- Quil untuk Remark  Approval dan Reject --}}
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
            theme: 'snow' // or 'bubble'
        });
    </script>
    
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Approve & Reject MR --}}
    <script>
        document.querySelectorAll('.approve-reject-btn').forEach(button => {
            button.addEventListener('click', function () {
                const action = this.getAttribute('data-action');
                const actionText = action === 'approve' ? 'Approve' : 'Reject';
                const mr_no_encoded = "{{ base64_encode($materialRequest->MR_No) }}"; 
                const baseUrl = "http://localhost/BmMaintenance/public";
                const url = `${baseUrl}/material-request/approve/${mr_no_encoded}`;

                const quillContentRaw = document.querySelector('#kt_docs_quill_basic .ql-editor')?.innerText.trim() || '';
                const quillContentHTML = document.querySelector('#kt_docs_quill_basic .ql-editor')?.innerHTML || '';

                if (!quillContentRaw || quillContentRaw === 'Input Your Remark or Notes Here') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Remark Required',
                        text: 'Please input your remark before continuing!',
                    });
                    return;
                }

                const rows = document.querySelectorAll('#material-body tr');
                let isValid = true;

                document.querySelectorAll('#material-body input, #material-body select').forEach(el => {
                    el.classList.remove('is-invalid');
                    const next = el.nextElementSibling;
                    if (next && next.classList.contains('invalid-feedback')) {
                        next.remove();
                    }
                });

                rows.forEach((row, index) => {
                    ['unit', 'code', 'name', 'stock', 'desc'].forEach(field => {
                        const el = row.querySelector(`[name$="[${field}]"]`);
                        if (el && el.value.trim() === '') {
                            isValid = false;
                            el.classList.add('is-invalid');

                            if (!el.nextElementSibling || !el.nextElementSibling.classList.contains('invalid-feedback')) {
                                const error = document.createElement('div');
                                error.className = 'invalid-feedback';
                                error.innerText = 'This field is required';
                                el.parentNode.appendChild(error);
                            }
                        }
                    });
                });

                if (!isValid) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Incomplete Material Data',
                        text: 'Please fill in all required fields before proceeding.',
                    });
                    return;
                }

                Swal.fire({
                    title: `Are you sure you want to ${actionText}?`,
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: `Yes, ${actionText}`,
                    cancelButtonText: 'Cancel',
                    reverseButtons: true,
                    customClass: { 
                        confirmButtonText: "btn btn-primary",
                        cancelButtonText: "btn btn-danger",
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        const loader = document.getElementById('page_loader');
                        loader.style.display = 'flex';
                        loader.style.opacity = 0;
                        setTimeout(() => loader.style.opacity = 1, 50);

                        document.getElementById('approvalNotes').value = quillContentHTML;

                        const formData = new FormData();
                        formData.append('approvalNotes', quillContentHTML);
                        formData.append('action', action);
                        formData.append('_token', '{{ csrf_token() }}');

                        rows.forEach((row, index) => {
                            const prefix = `items[${index}]`;
                            formData.append(`${prefix}[mr_line]`, row.querySelector('input[name$="[mr_line]"]').value);
                            formData.append(`${prefix}[qty]`, row.querySelector('input[name$="[qty]"]').value);
                            formData.append(`${prefix}[unit]`, row.querySelector('input[name$="[unit]"]').value);
                            formData.append(`${prefix}[code]`, row.querySelector('select[name$="[code]"]').value);
                            formData.append(`${prefix}[name]`, row.querySelector('input[name$="[name]"]').value);
                            formData.append(`${prefix}[stock]`, row.querySelector('input[name$="[stock]"]').value);
                            formData.append(`${prefix}[desc]`, row.querySelector('input[name$="[desc]"]').value);
                        });

                        setTimeout(() => {
                            axios.post(url, formData)
                                .then(response => {
                                    loader.style.display = 'none';
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success',
                                        text: response.data.message,
                                    }).then(() => {
                                        window.location.href = `${baseUrl}/Material-Request/List-Approval`;
                                    });
                                })
                                .catch(error => {
                                    loader.style.display = 'none';
                                    let message = "An error occurred";
                                    if (error.response && error.response.data && error.response.data.error) {
                                        message = error.response.data.error;
                                    }
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Failed',
                                        text: message,
                                    });
                                });
                        }, 1000);
                    }
                });
            });
        });
    </script>

   
@endsection
