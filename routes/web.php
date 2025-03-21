<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CaseController;
use App\Http\Controllers\NotificationController;
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
        // Update Hasil Update Case
        Route::post('/Case/Update', [CaseController::class, 'UpdateCase'])->name('cases.update');
    // End Create Case

    // List/View Case Table Page
        //List/View Cases
        Route::get('/Case/List', [CaseController::class, 'viewListBA'])->name('ViewCase');
        Route::get('/api/cases', [CaseController::class, 'getCases']);
        Route::get('/cases/filter', [CaseController::class, 'filter'])->name('cases.filter');

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


    Route::get('/notifications', [NotificationController::class, 'fetchNotifications'])->name('Notifications');
