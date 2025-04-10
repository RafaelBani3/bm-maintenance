<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CaseController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\WOController;
use Illuminate\Support\Facades\Route;

    // Default
    Route::get('/', function () {
        return redirect()->route('Login.page');
    });


    // Login Routes
    Route::get('/Login', [AuthController::class, 'LoginPage'])->name('Login.page');
    Route::post('/Login', [AuthController::class, 'LoginCheck'])->name('Login.post');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('Logout');


    // All can Access
    Route::get('/Dashboard', function () {
        return view('content.dashboard.Dashboard');
    })->name('Dashboard');

    Route::group(['middleware' => ['permission:view cr']], function () { 
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
        Route::get('/cases/filter', [CaseController::class, 'filter'])->name('cases.filter');
        Route::get('/api/cases/filter', [CaseController::class, 'getCasesData'])->name('api.getCasesData');


        // Detail Case
        // Route::get('/Case/Detail/{caseNo}', [CaseController::class, 'viewDetailCase'])->where('caseNo','.*')->name('case.detail');
        Route::post('/Case/Detail', [CaseController::class, 'storeCaseNoViewBA']);
        Route::get('/Case/Detail', [CaseController::class, 'showDetailPage']);
    // End List Case Table
    });

    Route::group(['middleware' => ['permission:view cr_ap']], function () { 
    // Approval Page
        // Approval List Case
        Route::get('/Case/Approval-list', [CaseController::class, 'ApprovalListBA'])->name('ApprovalCase');
        Route::get('/api/Aproval-cases', [CaseController::class, 'getApprovalCases']);

        // Detail Approval Case
        // Route::get('/Case/Approval/{caseNo}', [CaseController::class, 'ApprovalDetailCase'])->where('caseNo','.*')->name('case.detail');
        Route::post('/Case/Approval/Detail', [CaseController::class, 'storeCaseNoApprovalList']);
        Route::get('/Case/Approval/Detail', [CaseController::class, 'ApprovalDetailCase']);

        // Approve or Reject Cases
        // Route::post('/cases/{caseNo}/approve-reject', [CaseController::class, 'approveReject'])->name('cases.approveReject');
        Route::post('/cases/{caseNo}/approve-reject', [CaseController::class, 'approveReject'])
            ->where('caseNo', '.*') 
            ->name('cases.approveReject');
    });

    // View Create WO Page
    Route::get('/Work-Order/Create', [WOController::class, 'CreateWO'])->name('CreateWO');
    // Get Reference No (Case No)
    Route::get('/get-cases', [WOController::class, 'getCases'])->name('get.cases');
    // View List WO Page
    Route::get('/Work-Order/List', [WOController::class, 'ListWO'])->name('ListWO');
    // View Details Case di Page Create WO
    Route::get('/case-details/{caseNo}', [WOController::class, 'getCaseDetails'])
    ->where('caseNo', '.*'); 
    // Save Work Order
    Route::post('/Work-Order/Save', [WOController::class, 'SaveWO'])->name('SaveWO');
    // Page Edit WO
    Route::get('/Work-Order/Edit', [WOController::class, 'EditWO'])->name('EditWO');

    // Route Update WO 
    Route::post('/Work-Order/Update', [WOController::class, 'UpdateWO'])->name('WorkOrder.Update');

    // List WO Table
    Route::get('/work-orders', [WOController::class, 'getWorkOrders'])->name('workOrders.index');






    Route::get('/notifications', [NotificationController::class, 'fetchNotifications'])->name('Notifications');
