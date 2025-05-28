<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CaseController;
use App\Http\Controllers\MRController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\WocController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\WOController;
use Illuminate\Support\Facades\Route;

    // Default
    Route::get('/', function () {
        return redirect()->route('login');
    });

    // Login Routes
    Route::get('/Login', [AuthController::class, 'LoginPage'])->name('login');
    Route::post('/Login', [AuthController::class, 'LoginCheck'])->name('Login.post');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('Logout');


    // All can Access
    // Dashboard
    Route::get('/Dashboard', [DashboardController::class, 'PageDashboard'])->name('Dashboard');

    // Ambil Data Case
    Route::get('/dashboard/case-summary', [DashboardController::class, 'caseSummary'])->name('dashboard.case-summary');
    
    Route::get('/dashboard/wo-summary', [DashboardController::class, 'GetWOSummary'])->name('dashboard.wo-summary');

    Route::get('/dashboard/material-request-summary', [DashboardController::class, 'getMRSummary']);

    // Approval
    // Route::get('/ajax/pending-case-count', [DashboardController::class, 'getPendingCaseCount'])->name('ajax.pendingCaseCount');
    Route::get('/dashboard/pending-woc-count', [DashboardController::class, 'getPendingWOCCount'])->name('ajax.pendingWOCCount');

    Route::get('/dashboard/case-approval-progress', [DashboardController::class, 'getCaseApprovalProgress'])->name('dashboard.case-approval-progress');

    Route::get('/ajax/pending-mr-count', [DashboardController::class, 'getPendingMRCount'])->name('ajax.pendingMRCount');

    Route::get('/dashboard/case-wo-summary', [DashboardController::class, 'getCaseWOSummary'])->name('dashboard.case-wo-summary');


    Route::group(['middleware' => ['auth', 'CatchUnauthorizedException' , 'permission:view cr']], function () {
    // PAGE CREATE CASE
        // Create Cases
        Route::get('/Case-Report/Create', [CaseController::class, 'CreateCase'])->name('CreateCase');
        // SubCategories
        Route::get('/get-subcategories/{cat_no}', [CaseController::class, 'getSubCategories']);
        // Validation
        Route::post('/validate-case', [CaseController::class, 'validateCase'])->name('case.validate');
        // Create and Save Cases
        Route::post('/Case/Create/Save', [CaseController::class, 'SaveCase'])->name('SaveCase');
        // Edit Case Setelah Save Case
        Route::get('/Case/Edit', [CaseController::class, 'EditCase'])->name('EditCase');

        Route::post('/cases/delete-image', [CaseController::class, 'deleteImage'])->name('cases.deleteImage');

        // Update Hasil Update Case
        Route::post('/Case/Update', [CaseController::class, 'UpdateCase'])->name('cases.update');
    // End Create Case

    // List/View Case Table Page
        //List/View Cases
        Route::get('/Case/List', [CaseController::class, 'viewListBA'])->name('ViewCase');
        Route::get('/api/cases', [CaseController::class, 'getCases']);
 
        // Detail Case
        Route::get('/Case/Detail/{case_no}', [CaseController::class, 'showDetailPage'])
        ->where('case_no', '.*') 
        ->name('case.detail');
        
        // EXPORT
        Route::get('/export-cases', [ExportController::class, 'exportCase'])->name('cases.export');
    
    // End List Case Table
    });


    Route::middleware(['auth','CatchUnauthorizedException' ,'permission:view cr_ap'])->group(function() {
    // Approval Page
        // Approval List Case
        Route::get('/Case/Approval-list', [CaseController::class, 'ApprovalListBA'])->name('ApprovalCase');
        Route::get('/api/Aproval-cases', [CaseController::class, 'getApprovalCases']);

        // Detail Approval Case
        Route::post('/Case/Approval/Detail', [CaseController::class, 'storeCaseNoApprovalList']);
       
        // Ambil Detail Case Berdasarkan Case No
        Route::get('/Case/Approval/Detail/{case_no}', [CaseController::class, 'ApprovalDetailCase'])
        ->where('case_no', '.*');

        // Approve or Reject Cases
        Route::post('/cases/{caseNo}/approve-reject', [CaseController::class, 'approveReject'])
            ->where('caseNo', '.*') 
            ->name('cases.approveReject');
    });

    // Page WO
    Route::group(['middleware' => ['auth','CatchUnauthorizedException' ,'permission:view wo']], function () { 
        // View Create WO Page
        Route::get('/Work-Order/Create', [WOController::class, 'CreateWO'])->name('CreateWO');
        // Get Reference No (Case No)
        Route::get('/get-cases', [WOController::class, 'getCases'])->name('get.cases');
        // View List WO Page
        Route::get('/Work-Order/List', [WOController::class, 'ListWO'])->name('ListWO');
        // View Details Case di Page Create WO
        Route::get('/case-details/{caseNo}', [WOController::class, 'getCaseDetails'])
        ->where('caseNo', '.*'); 

        // Ambil Data Technician di page Create WO
        Route::get('/api/technicians', [WOController::class, 'getTechnicians']);

        // Save Work Order
        Route::post('/Work-Order/Save', [WOController::class, 'SaveWO'])->name('SaveWO');
        
        // Page Edit WO
        Route::get('/Work-Order/Edit/{wo_no}', [WOController::class, 'EditWO'])->name('EditWO');

        // Route Update WO 
        Route::post('/Work-Order/Update', [WOController::class, 'UpdateWO'])->name('WorkOrder.Update');

        // List WO Table
        Route::get('/work-orders', [WOController::class, 'getWorkOrders'])->name('GetWODataTable');

        Route::get('/get-intended-users', [WOController::class, 'getIntendedUsers'])->name('get.intended.users');
    
        Route::post('/Work-Order/Detail', [WOController::class, 'GetWorkOrderNo']);
        
        Route::get('/Work-Order/Detail/{wo_no}', [WOController::class, 'showDetailWO'])
        ->where('case_no', '.*') 
        ->name('WorkOrderDetail');

        Route::post('/work-order/remove-technician', [WOController::class, 'removeTechnician'])->name('work-order.remove-technician');
    
        Route::get('/wo/export', [ExportController::class, 'exportWO'])->name('wo.export');

    });


    // Page MR  
    Route::group(['middleware' => ['auth','CatchUnauthorizedException' ,'permission:view mr']], function () { 

        Route::get('/Material-Request/Create', [MRController::class, 'CreateMR'])->name('CreateMR');

        Route::get('/Material-Request/Get-WO-By-User', [MRController::class, 'getWOByUser']);
        
        Route::get('/Material-Request/Get-WO-Details', [MRController::class, 'getWODetails']);

        Route::post('/Material-Request/save', [MRController::class, 'SaveMR'])->name('SaveMR');

        Route::get('/Material-Request/Edit/{mr_no}', [MRController::class, 'edit'])->name('EdiMRphp ');

        Route::post('/Material-Request/Update', [MRController::class, 'UpdateMR'])->name('update.mr');

        Route::get('/Material-Request/list', [MRController::class, 'PageListMR'])->name('ListMR');
        
        Route::get('/Material-Request/get-data-list', [MRController::class, 'GetDataMr'])->name('GetDataMR');
        
        Route::get('/Material-Request/Detail/{encodedMRNo}', [MRController::class, 'detail'])->name('MaterialRequest.Detail');
        
        Route::post('/Material-Request/Delete-Material', [MRController::class, 'deleteMaterial'])->name('DeleteMaterial');
    
        Route::get('/Material-Request/Export', [ExportController::class, 'exportMR'])->name('matreq.export');
    });

    // ROLE MR AP
    Route::group(['middleware' => ['auth', 'CatchUnauthorizedException' ,'permission:view mr_ap']], function () { 
        // View Page MR AP
        Route::get('/Material-Request/List-Approval', [MRController::class, 'ApprovalListMR'])->name('ApprovalListMR');
        
        // Get Data MR untuk Approvel
        Route::get('/Api/List-MR-Approval', [MRController::class, 'getApprovalMR'])->name('matreq.list');
        
        // Get Case Data dari table WO untuk Create MR
        Route::get('/Api/List-MR-Approval/get-cases', [MRController::class, 'getCases'])->name('api.getCases');

        // Route::get('/get-case-details/{caseNo}', [MRController::class, 'getCaseDetails'])->name('api.getCaseDetails');
        Route::get('/get-case-details/{encodedCaseNo}', [MRController::class, 'getCaseDetails']);
        Route::get('/get-case-details/{encodedCaseNo}', [MRController::class, 'getCaseDetails']);


        Route::get('/Material-Request/Approval-Detail/{encodedMRNo}', [MRController::class, 'ApprovalDetailMR'])->name('ApprovalDetailMR');

        // Approve or Reject MR        
        Route::post('/material-request/approve/{mr_no}', [MRController::class, 'approveReject']);

    }); 


    Route::group(['middleware' => ['auth', 'CatchUnauthorizedException' ,'permission:view cr']], function () { 

        // WOC
        Route::get('/WorkOrder-Complition/Create', [WocController::class, 'CreateWOC'])->name('CreateWOC');

        // List WOC
        Route::get('/WorkOrder-Complition/List', [WocController::class, 'ListWOCPage'])->name('ListWOCPage');

        Route::get('/get-work-orders', [WocController::class, 'getWorkOrders']);
        Route::get('/get-work-order-details/{encoded}', [WocController::class, 'getWorkOrderDetails']);

        // Save WOC
        Route::post('/WorkOrder-Complition/Save', [WocController::class, 'saveCompletion'])->name('SaveWOC');

        Route::post('/WorkOrder-Complition/delete-image', [WocController::class, 'deleteImage'])->name('WOC.deleteImage');

        Route::get('/WorkOrder-Complition/Edit/{wo_no}', [WocController::class, 'EditWOC'])->name('EditWOC');

        Route::post('/WorkOrder-Complition/remove-technician', [WocController::class, 'removeTechnician'])->name('WOC.remove-technician');
        
        Route::post('/WorkOrder-Complition/UpdateWOC', [WocController::class, 'UpdateWOC'])->name('UpdateWOC');

        Route::get('/WorkOrder-Complition/GetSubmittedData', [WocController::class, 'getSubmittedData']);

        Route::get('/WorkOrder-Complition/Detail/{wo_no}', [WocController::class, 'showDetailWO'])->name('WocDetail');
    
        Route::get('/WorkOrder-Complition/Export', [ExportController::class, 'exportWOC'])->name('woc.export');

    });

    Route::group(['middleware' => ['auth', 'CatchUnauthorizedException' ,'permission:view cr_ap']], function () { 

        // Page List Approval WOC
        Route::get('/WorkOrder-Complition/List-Approval', [WocController::class, 'ApprovalListWOC'])->name('ApprovalListWOC');

        // Ambil Data WOC dgn Status "SBUMIT" untuk ditampilkan pada page List Approval WOC
        Route::get('/WorkOrder-Complition/getApprovalWOC', [WocController::class, 'getApprovalWOC']);

        // Page Detail Approval WOC
        // Route::get('/WorkOrder-Complition/Detail-ApprovalWOC', [WocController::class, 'DetailApprovalWOC'])->name('DetailApprovalWOC');

        Route::get('/WorkOrder-Complition/DetailApprovalWOC/{encodedWO}', [WocController::class, 'DetailApprovalWOC']);
        
        // Route::post('/WorkOrder-Complition/approve-reject/{wo_no}', [WocController::class, 'approveReject'])->name('workorder.approveReject');
        
        // Route::post('/WorkOrder-Complition/approve-reject/{woNo}', [WocController::class, 'approveReject']);
        Route::post('/workorder/approval/{wo_no}', [WocController::class, 'approveReject'])->name('workorder.approveReject');

    }); 



















    // Notifikasi
    Route::get('/notifications', [NotificationController::class, 'fetchNotifications'])->name('Notifications');
    Route::post('/notification/read/{id}', [NotificationController::class, 'markAsRead']);
