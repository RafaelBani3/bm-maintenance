<?php

namespace App\Http\Controllers;

use App\Models\Cases;
use App\Models\Logs;
use App\Models\User;
use App\Models\WorkOrder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Str;

class WOController extends Controller
{
    // Page Create WO
    public function CreateWO(){   

        return view('content.wo.CreateWO');
    }

    // Get Case_No Buat Create WO
    public function getCases(Request $request)
    {
        $user = Auth::user();
    
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }
    
        $cases = Cases::select('Case_No', 'CR_BY', 'Case_Date', 'Case_ApStep', 'Case_ApMaxStep')
            ->where('CR_BY', $user->id) 
            ->whereColumn('Case_ApStep', 'Case_ApMaxStep')
            ->with([
                'user:id,Fullname,PS_ID',
                'user.position:id,PS_Name'
            ])
            ->get();
        
        $formattedCases = $cases->map(function ($case) {
            return [
                'case_no' => $case->Case_No,
                'created_by' => $case->user ? $case->user->Fullname : 'Unknown',
                'department' => $case->user && $case->user->position ? $case->user->position->PS_Name : 'Unknown',
                'date' => $case->Case_Date,
            ];
        });
    
        return response()->json($formattedCases);
    }
    
    // View Page List WO
    public function ListWO(){   

        return view('content.wo.ListWO');
    }

    // Get Case No untuk Detail Case
    public function getCaseDetails($caseNo)
    {
        Log::info('Case No received: ' . $caseNo); 
        $case = Cases::with(['user', 'category', 'subCategory', 'images'])->where('Case_No', $caseNo)->first();

        if (!$case) {
            return response()->json(['error' => 'Case not found'], 404);
        }

        $approvalStatus = [];
        for ($i = 1; $i <= $case->Case_ApMaxStep; $i++) {
            $approvalStatus[] = [
                'approver' => 'AP' . $i,
                'remark' => $case['Case_RMK' . $i] ?? 'Pending',
                'status' => $case['Case_RMK' . $i] ?? 'Pending',
            ];
        }

        return response()->json([   
            'Case_No' => $case->Case_No,
            'Case_Name' => $case->Case_Name,
            'Case_Date' => $case->Case_Date,
            'Category' => $case->category->Cat_Name ?? 'N/A',
            'SubCategory' => $case->subCategory->Scat_Name ?? 'N/A',
            'Created_By' => $case->user->Fullname ?? 'N/A',
            'Departement' => $case->user && $case->user->position ? $case->user->position->PS_Name : 'Unknown',
            'Case_Chronology' => $case->Case_Chronology,
            'Case_Outcome' => $case->Case_Outcome,
            'Case_Suggest' => $case->Case_Suggest,
            'Case_Action' => $case->Case_Action,
            'Case_Status' => $case->Case_Status,
            'Images' => $case->images,
            'Approval_Status' => $approvalStatus,
        ]);
    }

    // Save WO
    public function SaveWO(Request $request)
    {
        try {
            
            // Validasi 
            $request->validate([
                'reference_number' => 'required|string',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'work_description' => 'required|string|max:255',
                'assigned_to' => 'nullable|array',
      
            ]);

            $user = Auth::user(); 
            $woNumber = (new WorkOrder)->getIncrementWONo();
            Log::info('The Work Order creation process is initiated by the user ID:' . $user->id);

            $workOrder = new WorkOrder();
            $workOrder->WO_No = $woNumber;
            $workOrder->Case_No = $request->reference_number;
            $workOrder->WO_Start = $request->start_date;
            $workOrder->WO_End = $request->end_date;
            $workOrder->WO_Status = $request->work_status;
            $workOrder->WO_Narative = $request->work_description;
            $workOrder->WO_NeedMat = $request->require_material === 'yes' ? 'Y' : 'N';
            $workOrder->WO_MR = $user->id;
            $workOrder->WO_IsComplete = 'N';
            $workOrder->CR_BY = $user->id;
            $workOrder->CR_DT = now();
            $workOrder->Update_Date = now();
            $workOrder->WO_Status = 'OPEN';
            $workOrder->save();

            Session::put('latest_wo_no', $woNumber);

            Log::info("Work Order {$woNumber} was successfully created by user ID: {$user->id}");

            Logs::create([
                'LOG_Type' => 'WO',
                'LOG_RefNo' => $woNumber,
                'LOG_Status' => 'SUCCESS',
                'LOG_User' => $user->id,
                'LOG_Date' => now(),
                'LOG_Desc' => 'Work Order was successfully created.',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Work Order successfully saved!',
                'wo_no' => $woNumber 
            ]);
        } catch (\Exception $e) {

            Log::error('Failed to create Work Order. Error: ' . $e->getMessage());
            
            Logs::create([
                'LOG_Type' => 'WO',
                'LOG_RefNo' => null,
                'LOG_Status' => 'FAILED',
                'LOG_User' => Auth::id(),
                'LOG_Date' => now(),
                'LOG_Desc' => 'Failed to create Work Order. Error: ' . $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    // Edit WO
    public function EditWO(Request $request)
    {
        $wo_no = session('latest_wo_no');

        if (!$wo_no) {
            return redirect('/Work-Order/Create')->with('error', 'No Work Order selected.');
        }

        $wo = WorkOrder::where('WO_No', $wo_no)->firstOrFail();

        $case = Cases::where('Case_No', $wo->Case_No)
            ->with(['user.position'])
            ->first();

        return view('content.wo.EditWO', [
            'wo' => $wo,
            'case' => $case
        ]);
    }

    public function UpdateWO(Request $request)
    {
        try {
            // Validasi data
            $request->validate([
                'wo_no' => 'required|string',
                'reference_number' => 'required|string',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'work_description' => 'required|string',
                'assigned_to' => 'nullable|array',
                'require_material' => 'nullable|string',
            ]);

            $user = Auth::user();
            $wo = WorkOrder::where('WO_No', $request->wo_no)->firstOrFail();

            Log::info("Work Order update process {$request->wo_no} started by user ID: {$user->id}");
            
            // Update data
            $wo->Case_No = $request->reference_number;
            $wo->WO_Start = $request->start_date;
            $wo->WO_End = $request->end_date;
            $wo->WO_Narative = $request->work_description;
            $wo->WO_NeedMat = $request->require_material === 'yes' ? 'Y' : 'N';
            $wo->WO_Status = 'OnProgress';
            $wo->Update_Date = now();
            $wo->save();

            Log::info("Work Order {$request->wo_no} successfully updated by user ID: {$user->id}");

            Logs::create([
                'LOG_Type' => 'WO',
                'LOG_RefNo' => $request->wo_no,
                'LOG_Status' => 'SUCCESS',
                'LOG_User' => $user->id,
                'LOG_Date' => now(),
                'LOG_Desc' => 'Work Order Successfully Updated.',
            ]);
            

            return response()->json([
                'success' => true,
                'message' => 'Work Order successfully updated!'
            ]);
        } catch (\Exception $e) {

            Log::error('Failed to Updated Work Order. Error:' . $e->getMessage());

            Logs::create([
                'Log_Type' => 'WO',
                'Log_RefNo' => $request->wo_no,
                'Log_Status' => 'FAILED',
                'Log_User' => $user->id,
                'Log_Date' => now(),
                'Log_Desc' => 'Failed to Update Work Order. Error: ',
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }


    public function getWorkOrders(Request $request)
    {
        $userId = Auth::id();

        $workOrders = WorkOrder::where('CR_BY', $userId)->get();

        return response()->json($workOrders);
    }

}

