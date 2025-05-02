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

                                    <span id="mr_status_display" class="fw-bold fs-5 {{ $statusClass }}">
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

                            {{-- Approver Material-Request --}}
                            {{-- <div class="row mb-5">
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
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="material-body">
                                            @foreach($details as $index => $detail)
                                            <tr>
                                                <td class="text-center">{{ $detail->MR_Line }}</td>
                                                <td>
                                                    <input type="hidden" name="items[{{ $index }}][mr_line]" value="{{ $detail->MR_Line }}">
                                                    <input style="width: 100px" type="number" name="items[{{ $index }}][qty]" class="form-control" value="{{ $detail->Item_Oty }}">
                                                </td>
                                                <td style="width: 140px"><input type="text" name="items[{{ $index }}][unit]" class="form-control uom-name" placeholder="Input Unit"></td>
                                                <td style="width: 190px">
                                                    <select name="items[{{ $index }}][code]" class="form-control item-code"></select>
                                                </td>
                                                <td style="width: 230px"><input type="text" name="items[{{ $index }}][name]" class="form-control item-name" placeholder="Material's Name" readonly></td>
                                                <td><input type="text" name="items[{{ $index }}][stock]" class="form-control item-stock" placeholder="Material's Stock"></td>
                                                <td><input type="text" name="items[{{ $index }}][desc]" class="form-control item-desc" value=""></td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-danger remove-row">X</button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div> --}}

                            @if($materialRequest->MR_APStep == 1 && $materialRequest->MR_Status == 'SUBMITTED' && is_null($materialRequest->MR_RMK1))
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
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="material-body">
                                                @foreach($details as $index => $detail)
                                                <tr>
                                                    <td class="text-center">{{ $detail->MR_Line }}</td>
                                                    <td>
                                                        <input type="hidden" name="items[{{ $index }}][mr_line]" value="{{ $detail->MR_Line }}">
                                                        <input style="width: 100px" type="number" name="items[{{ $index }}][qty]" class="form-control" value="{{ $detail->Item_Oty }}">
                                                    </td>
                                                    <td style="width: 140px"><input type="text" name="items[{{ $index }}][unit]" class="form-control uom-name" placeholder="Input Unit"></td>
                                                    <td style="width: 190px">
                                                        <select name="items[{{ $index }}][code]" class="form-control item-code"></select>
                                                    </td>
                                                    <td style="width: 230px"><input type="text" name="items[{{ $index }}][name]" class="form-control item-name" placeholder="Material's Name" readonly></td>
                                                    <td><input type="text" name="items[{{ $index }}][stock]" class="form-control item-stock" placeholder="Material's Stock"></td>
                                                    <td><input type="text" name="items[{{ $index }}][desc]" class="form-control item-desc" value=""></td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-danger remove-row">X</button>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif


                            <div class="row card-footer mb-5 pb-5 ">
                                <!--begin::Label-->
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
    {{-- <script>
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
                                        item_stock: 'Input Material Stock',
                                        item_desc: item.item_remark ?? '-'
                                    };
                                })
                            };
                        },
                        cache: true
                    }
                }).on('select2:select', function(e) {
                    let data = e.params.data;
                    let row = $(this).closest('tr');
    
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
    </script> --}}

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
    
    {{-- Get Case No Untuk Reference No --}}
    <script>
        $(document).ready(function () {
            $('#reference_number').select2({
                placeholder: 'Select Reference',
                allowClear: true,
                ajax: {
                    url: "{{ route('api.getCases') }}",
                    dataType: 'json',
                    delay: 250,
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (item) {
                                return {
                                    id: item.Case_No,
                                    text: item.Case_No
                                }
                            })
                        };
                    },
                    cache: true
                }
            });
    
            $('#reference_number').on('change', function () {
                let caseNo = $(this).val();
                if (!caseNo) return;

                let encoded = btoa(caseNo);
                let url = "http://localhost/BmMaintenance/public/get-case-details/" + encoded;

                $('#page_loader').removeClass('d-none');

                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function (data) {
                        $('#page_loader').addClass('d-none');

                        if (data) {
                            $('#mr_no_display').text(data.MR_No ?? '-');
                            $('#wo_no_display').text(data.WO_No ?? '-');
                            $('#Created_By').text(data.Created_By ?? '-');
                            $('#Departement').text(data.PS_Name ?? '-');
                            $('#RequestDate').text(data.CR_DT ?? '-');
                            $('#mr_allotment').text(data.MR_Allotment ?? '-');
                            
                            let statusClass = '';
                            switch (data.MR_Status) {
                                case 'OPEN':
                                    statusClass = 'bg-light-warning';
                                    break;
                                case 'SUBMITTED':
                                    statusClass = 'bg-light-primary text-primary';
                                    break;
                                case 'CLOSE':
                                    statusClass = 'bg-light-success';
                                    break;
                                case 'REJECT':
                                    statusClass = 'bg-light-danger';
                                    break;
                                default:
                                    statusClass = 'bg-light-secondary text-primary fs-6';
                            }

                            let statusText = '';
                            switch (data.MR_Status) {
                                case 'AP1': statusText = 'Approved 1'; break;
                                case 'AP2': statusText = 'Approved 2'; break;
                                case 'AP3': statusText = 'Approved 3'; break;
                                case 'AP4': statusText = 'Approved 4'; break;
                                case 'AP5': statusText = 'Approved 5'; break;
                                default: statusText = data.MR_Status ? data.MR_Status.toUpperCase() : '-';
                            }

                            $('#mr_status').addClass(`fw-bold fs-5 ${statusClass}`).text(statusText);
                            
                        } else {
                            alert('Data not found or not eligible.');
                        }
                    },
                    error: function () {
                        $('#page_loader').addClass('d-none');
                        alert('Failed to retrieve data.');
                    }
                });
            });
        });
    </script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

{{-- <script>
    $(document).ready(function() {
        $(".approve-reject-btn").click(function(e) {
            e.preventDefault();
            
            let action = $(this).data("action");
            let caseNo = btoa("{{ $materialRequest->MR_No }}"); 
    
            let quillContent = quill.root.innerHTML;
            $("#approvalNotes").val(quillContent);
    
            Swal.fire({
                title: (action === "approve") ? "Approve Case?" : "Reject Case?",
                text: (action === "approve") ? "Are you sure you want to approve this case?" : "Are you sure you want to reject this case?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: (action === "approve") ? "Yes, Approve" : "Yes, Reject",
                cancelButtonText: "Cancel"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/BmMaintenance/public/Material-Request/${caseNo}/approve-reject`,
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            action: action,
                            approvalNotes: quillContent
                        },
                        success: function(response) {
                            Swal.fire({
                                title: "Success!",
                                text: response.message,
                                icon: "success"
                            }).then(() => {
                                window.location.href = `${BASE_URL}/Material-Request/List-Approval`;
                    
                            });
                        },
                        error: function(xhr) {
                            Swal.fire("Error", xhr.responseJSON?.message || "Terjadi kesalahan saat memproses", "error");
                            console.log();
                        }
                    });
                }
            });
        });
    });
</script> --}}

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    document.querySelectorAll('.approve-reject-btn').forEach(button => {
        button.addEventListener('click', function () {
            const action = this.getAttribute('data-action');
            const mr_no_encoded = "{{ base64_encode($materialRequest->MR_No) }}"; 
            const baseUrl = "http://localhost/BmMaintenance/public";
            const url = `${baseUrl}/material-request/approve/${mr_no_encoded}`;

            const quillContent = document.querySelector('#kt_docs_quill_basic .ql-editor')?.innerHTML || '';
            document.getElementById('approvalNotes').value = quillContent;

            const formData = new FormData();
            formData.append('approvalNotes', quillContent);
            formData.append('action', action);
            formData.append('_token', '{{ csrf_token() }}');

            const rows = document.querySelectorAll('#material-body tr');
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

            axios.post(url, formData)
                .then(response => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.data.message,
                    }).then(() => {
                        window.location.href = `${BASE_URL}/Material-Request/List-Approval`;
                    });
                })
                .catch(error => {
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
        });
    });
</script>

    
   
@endsection
