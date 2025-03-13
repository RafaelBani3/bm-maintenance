<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
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



Route::get('/Dashboard', function () {
    return view('content.dashboard.Dashboard');
})->name('Dashboard');
// ->middleware('role:Admin')

// Create Cases
Route::get('/Case-Report/Create', [CaseController::class, 'CreateCase'])->name('CreateCase');

// SubCategories
Route::get('/get-subcategories/{cat_no}', [CaseController::class, 'getSubCategories']);

// Validation
Route::post('/validate-case', [CaseController::class, 'validateCase'])->name('case.validate');

// Create and Save Cases
Route::post('/Case-Report/Create/Save', [CaseController::class, 'SaveCase'])->name('SaveCase');

// Submit Cases
// Route::post('/submit-case', [CaseController::class, 'SubmitCase'])->name('SubmitCase');
// Route::get('/Case-Report/Edit/{case_no}', [CaseController::class, 'edit'])->name('EditCase');
Route::get('/Case-Report/Edit', [CaseController::class, 'EditCase'])->name('EditCase');

// Update Hasil Update Case
Route::post('/Case-Report/Update', [CaseController::class, 'UpdateCase'])->name('cases.update');

// Route::post('/cases/delete-image', [CaseController::class, 'deleteImage'])->name('case.delete.image');
// Route::post('/update-case-image', [CaseController::class, 'updateCaseImage'])->name('update.case.image');


// // List/View Cases
Route::get('/Case-Report/List', [CaseController::class, 'viewListBA'])->name('ViewCase');
Route::get('/api/cases', [CaseController::class, 'getCases']);

// Approval List Page
Route::get('/Case-Report/ApprovalCase', [CaseController::class, 'ApprovalListPage'])->name('ApprovalCase');
Route::get('/cases/pending', [CaseController::class, 'getApprovalCases'])->name('cases.pending');

// View Details Cases
Route::get('/cases/{Case_No}', [CaseController::class, 'show'])->where('Case_No', '.*')->name('cases.show');
