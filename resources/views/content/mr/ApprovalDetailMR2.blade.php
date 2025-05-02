@extends('layouts.Master')

@section('title', 'BM-Maintenance')
@section('subtitle', 'Material Request - Approval Detail Material Request')

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
                                            @foreach($details as $detail)
                                            <tr>
                                                <td class="text-center">         
                                                   {{ $detail->MR_Line }}
                                                </td>
                                                <td><input type="number" name="items[0][qty]" class="form-control" value="{{ $detail->Item_Oty }}"></td>
                                                <td><input type="text" name="items[0][unit]" class="form-control" value="{{ $detail->CR_ITEM_SATUAN }}"></td>
                                                <td>
                                                    <select name="items[0][code]" class="form-control item-code"></select>
                                                </td>
                                                <td><input type="text" name="items[0][name]" class="form-control item-name" value="{{ $detail->CR_ITEM_NAME }}" readonly></td>
                                                <td><input type="text" name="items[0][stock]" class="form-control item-stock" readonly></td>
                                                <td><input type="text" name="items[0][desc]" class="form-control item-desc" readonly value="{{ $detail->Remark }}"></td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-danger remove-row">
                                                        X
                                                    </button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    
                                </div>
                            </div>

                            {{-- Approval --}}
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
                            {{-- Approval --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        const BASE_URL = "{{ url('/') }}";
    </script>

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
                                        text: item.item_cd + ' - ' + item.item_descs,
                                        item_name: item.item_descs,
                                        item_stock: item.item_stock ?? '0',
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
    


@endsection
