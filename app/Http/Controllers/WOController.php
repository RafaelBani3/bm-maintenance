<?php

namespace App\Http\Controllers;

use App\Models\Cases;
use App\Models\Logs;
use App\Models\technician;
use App\Models\User;
use App\Models\WorkOrder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class WOController extends Controller
{
    // Page Create WO
    public function CreateWO(){   

        return view('content.wo.CreateWO');
    }

    // Get Case_No jadi reference no Buat Create WO
    public function getCases(Request $request)
    {
        $user = Auth::user();
    
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }
    
        $cases = Cases::select('Case_No', 'CR_BY', 'Case_Date', 'Case_ApStep', 'Case_ApMaxStep')
            ->where('CR_BY', $user->id) 
            ->where('Case_Status', 'AP2')
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

    // Get Case No untuk Detail Case Pada Page Create
    public function getCaseDetails($caseNo)
    {
        
        $decodedCaseNo = base64_decode($caseNo);
    
        Log::info('Decoded Case No: ' . $decodedCaseNo);
    
        $case = Cases::with(['user', 'category', 'subCategory', 'images'])
            ->where('Case_No', $decodedCaseNo)
            ->first();
    
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

    // Ambil Data Technician 
    public function getTechnicians()
    {
        // $technicians = DB::table('technician')
        //     ->select('technician_id', 'technician_Name')
        //     ->orderBy('technician_Name', 'asc')
        //     ->get();

        // return response()->json($technicians);
        $technicians = Technician::with('position')->get();

        $grouped = $technicians->groupBy(function ($tech) {
            return $tech->position->PS_Name ?? 'Unknown';
        });

        $result = [];
        foreach ($grouped as $position => $group) {
            $children = $group->map(function ($tech) {
                return [
                    'id' => $tech->technician_id,
                    'text' => "{$tech->technician_id} - {$tech->technician_Name}"
                ];
            })->toArray();

            $result[] = [
                'text' => $position,
                'children' => $children
            ];
        }

        return response()->json($result);
    }

    // Ambil Data User 
    public function getIntendedUsers(Request $request)
    {
        $user = Auth::user();
        $position = $user->position->PS_Name;
    
        Log::info('Fetching intended users for position: ' . $position . ' by user: ' . $user->Fullname);
    
        $users = [];
    
        switch ($position) {
            case 'Spv Engineering':
            case 'Adm Engineering':
            case 'Security & Parking':
            case 'HSE Koordinator':
            case 'Finance':
            case 'Fitout':
                $users = User::where('Fullname', 'Istifar Adi Saputra')->get();
                break;
            case 'HR Admin':
                $users = User::where('Fullname', 'Aisyah Nuraini')->get();
                break;
            case 'TR':
                $users = User::whereIn('Fullname', ['Cece Bayu Muttaqin', 'Puti Amelia','Samuel Yugo Partomo'])->get();
                break;
            case 'Store Keeper':
                $users = User::where('Fullname', 'Rizqhan Fajar Pramudita')->get();
                break;
            case 'Creator':
                $users = User::where('Fullname', 'SUPER ADMIN CREATOR')->get();
                break;
            case 'IT Leader':
                $users = User::where('Fullname', 'Naswan Nusih')->get();
                break;
            case 'Housekeeping':
                $users = User::where('Fullname', ['M. Dina', 'Eni Novianti'])->get();
                break;
    
            default:
                $users = collect();
        }
    
        Log::info('Intended users fetched: ', $users->pluck('Fullname')->toArray());
    
        return response()->json($users);
    }

    // Save WO
    public function SaveWO(Request $request)
    {
        try {
            $request->validate([
            'reference_number' => 'required|string',
            'start_date' => 'required|date_format:d/m/Y H:i',
            'end_date' => 'required|date_format:d/m/Y H:i|after_or_equal:start_date',
            'work_description' => 'required|string|max:255',
            'assigned_to' => 'nullable|array',
        ]);

        $user = Auth::user(); 
        $woNumber = (new WorkOrder)->getIncrementWONo();

        $startDate = Carbon::createFromFormat('d/m/Y H:i', $request->start_date)->format('Y-m-d H:i:s');
        $endDate = Carbon::createFromFormat('d/m/Y H:i', $request->end_date)->format('Y-m-d H:i:s');

        Log::info('The Work Order creation process is initiated by the user ID:' . $user->id);

        $workOrder = new WorkOrder();
        $workOrder->WO_No = $woNumber;
        $workOrder->Case_No = $request->reference_number;
        $workOrder->WO_Start = $startDate;
        $workOrder->WO_End = $endDate;
        $workOrder->WO_Status = 'OPEN';
        $workOrder->WO_Narative = $request->work_description;
        $workOrder->WO_NeedMat = $request->require_material === 'yes' ? 'Y' : 'N';
        $workOrder->WO_MR = $request->intended_for;
        $workOrder->WO_IsComplete = 'N';
        $workOrder->CR_BY = $user->id;
        $workOrder->CR_DT = now();
        $workOrder->Update_Date = now();
        $workOrder->save();

        $case = Cases::where('Case_No', $request->reference_number)->first();
            if ($case) {
                $case->Case_Status = 'INPROGRESS';
                $case->save();
                Log::info("Case {$request->reference_number} status updated to INPROGRESS by user ID: {$user->id}");
            
                Logs::create([
                    'Logs_No' => Logs::generateLogsNo(),
                    'LOG_Type' => 'BA',
                    'LOG_RefNo' => $request->reference_number,
                    'LOG_Status' => 'INPROGRESS',
                    'LOG_User' => $user->id,
                    'LOG_Date' => now(),
                    'LOG_Desc' => 'Sent and Case Inprogress.',
                ]);
        
            }

        Session::put('latest_wo_no', $woNumber);

        if ($request->has('assigned_to') && is_array($request->assigned_to)) {
            foreach ($request->assigned_to as $technicianId) {
                $exists = DB::table('WO_DoneBy')
                    ->where('WO_No', $woNumber)
                    ->where('technician_id', $technicianId)
                    ->exists();
            
                if (!$exists) {
                    DB::table('WO_DoneBy')->insert([
                        'WO_No' => $woNumber,
                        'technician_id' => $technicianId,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
            
                    Logs::create([
                        'Logs_No' => Logs::generateLogsNo(),
                        'LOG_Type' => 'WO',
                        'LOG_RefNo' => $woNumber,
                        'LOG_Status' => 'TECH_ASSIGNED',
                        'LOG_User' => $user->id,
                        'LOG_Date' => now(),
                        'LOG_Desc' => "Technician ID $technicianId was assigned to Work Order.",
                    ]);
                }
            }
        }

            Logs::create([
                'Logs_No' => Logs::generateLogsNo(),                
                'LOG_Type' => 'WO',
                'LOG_RefNo' => $woNumber,
                'LOG_Status' => 'CREATED',
                'LOG_User' => $user->id,
                'LOG_Date' => now(),
                'LOG_Desc' => 'Created New Work Order',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Work Order successfully saved!',
                'wo_no' => $woNumber 
            ]);
        } catch (\Exception $e) {
            Log::error(message: 'Failed to create Work Order. Error: ' . $e->getMessage());

            Logs::create([
                'Logs_No' => Logs::generateLogsNo(),
                'LOG_Type' => 'WO',
                'LOG_RefNo' =>  $woNumber ?? '',    
                'LOG_Status' => 'FAILED',
                'LOG_User' => Auth::id(),
                'LOG_Date' => now(),
                'LOG_Desc' => Str::limit('Failed to create work order. ERROR: ' . $e->getMessage(), 255),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    // View Page Edit WO
    public function EditWO($wo_no)
    {
        $wo_no = base64_decode($wo_no);
        
        if (!$wo_no) {
            return redirect('/Work-Order/Create')->with('error', 'No Work Order selected.');
        }
    
        $wo = WorkOrder::with('case')->where('WO_No', $wo_no)->firstOrFail();
        $user = Auth::user();
        $position = $user->position->PS_Name;
    
        Log::info('Fetching intended users for position: ' . $position . ' by user: ' . $user->Fullname);
    
        $users = match ($position) {
            'Spv Engineering', 'Adm Engineering', 'Security & Parking', 'HSE Koordinator','Finance','Fitout' =>
                User::where('Fullname', 'Istifar Adi Saputra')->get(),
    
            'HR Admin' =>
                User::where('Fullname', 'Aisyah Nuraini')->get(),
    
            'TR' =>
                User::whereIn('Fullname', ['Cece Bayu Muttaqin', 'Puti Amelia','Samuel Yugo Partomo'])->get(),
    
            'Store Keeper' =>
                User::where('Fullname', 'Rizqhan Fajar Pramudita')->get(),
            
            'Creator' => 
                User::where('Fullname', 'SUPER ADMIN CREATOR')->get(),
  
            'IT Leader' =>
                  User::where('Fullname', 'Naswan Nusih')->get(),

            'Housekeeping' =>
                User::where('Fullname', ['M. Dina', 'Eni Novianti'])->get(),
    
            default => collect()
        };
    
        $case = Cases::where('Case_No', $wo->Case_No)->with(['user.position'])->first();
    
        $allTechnicians = technician::all();
    
        $selectedTechnicians = DB::table('WO_DoneBy')
            ->where('WO_No', $wo_no)
            ->pluck('technician_id')
            ->toArray();
    
        return view('content.wo.EditWO', [
            'wo' => $wo,
            'case' => $case,
            'users' => $users,
            'technicians' => $allTechnicians,
            'selectedTechnicians' => $selectedTechnicians,
        ]);
    }

    // Remove/Hapus Data Teknisi yang sudah dipilih/tersimpan didatabase (di Page Edit)
    public function removeTechnician(Request $request)
    {
        $request->validate([
            'wo_no' => 'required',
            'technician_id' => 'required'
        ]);

        DB::table('WO_DoneBy')
            ->where('WO_No', $request->wo_no)
            ->where('technician_id', $request->technician_id)
            ->delete();

        return response()->json(['status' => 'success']);
    }

    // SAVE DRAFT WORK Order
    public function SaveDraftWO(Request $request)
    {
        $user = auth::user();
        $request->validate([
            'wo_no' => 'required|string',
            'reference_number' => 'required|string',
            'start_date' => 'required|string',
            'end_date' => 'required|string',
            'work_description' => 'required|string',
            'assigned_to' => 'nullable|array',
            'require_material' => 'nullable|string',
        ]);

        try {
            $wo = WorkOrder::where('WO_No', $request->wo_no)->firstOrFail();

            $startDate = Carbon::createFromFormat('d/m/Y H:i', $request->start_date)->format('Y-m-d H:i:s');
            $endDate = Carbon::createFromFormat('d/m/Y H:i', $request->end_date)->format('Y-m-d H:i:s');

            $wo->Case_No = $request->reference_number;
            $wo->WO_Start = $startDate;
            $wo->WO_End = $endDate;
            $wo->WO_Narative = $request->work_description;
            $wo->Update_Date = now();

            if ($request->has('require_material') && $request->require_material === 'yes') {
                $wo->WO_NeedMat = 'Y';
                $wo->WO_MR = $request->intended_for ?? $wo->WO_MR;
                $wo->WO_Status = 'OPEN';
            } else {
                $wo->WO_NeedMat = 'N';
                $wo->WO_MR = null;
                $wo->WO_Status = 'OPEN';
            }

            $wo->save();


            

            // Handle Teknisi
            if ($request->has('assigned_to')) {
                $existingTechnicians = DB::table('WO_DoneBy')
                    ->where('WO_No', $request->wo_no)
                    ->pluck('technician_id')
                    ->toArray();
    
                foreach ($request->assigned_to as $tech_id) {
                    if (!in_array($tech_id, $existingTechnicians)) {
                        DB::table('WO_DoneBy')->insert([
                            'WO_No' => $request->wo_no,
                            'technician_id' => $tech_id,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
    
                        Log::info("Technician {$tech_id} added to WO {$request->wo_no} by {$user->Fullname}");
                    }
                }
            }

            DB::table('Logs')->insert([
                'Logs_No' => Logs::generateLogsNo(),
                'LOG_Type' => 'WO',
                'LOG_RefNo' => $wo->WO_No,
                'LOG_Status' => 'DRAFT_SAVED',
                'LOG_User' => Auth::id(),
                'LOG_Date' => now(),
                'LOG_Desc' => 'Successfully Saved Work Order Draft.',
            ]);

            return response()->json(['success' => true, 'message' => 'Work Order Draft Saved Successfully.']);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }

    // Update WO
    public function UpdateWO(Request $request)
    {
        $user = Auth::user();   
    
        try {
            // Validasi data
            $request->validate([
                'wo_no' => 'required|string',
                // 'reference_number' => 'required|string',
                // 'start_date' => 'required|string',
                // 'end_date' => 'required|string',
                // 'work_description' => 'required|string',
                // 'assigned_to' => 'nullable|array',
                'require_material' => 'nullable|string',
            ]);
    
            $wo = WorkOrder::where('WO_No', $request->wo_no)->firstOrFail();
             
            // $startDate = Carbon::createFromFormat('d/m/Y H:i', $request->start_date)->format('Y-m-d H:i:s');
            // $endDate = Carbon::createFromFormat('d/m/Y H:i', $request->end_date)->format('Y-m-d H:i:s');

            // Log::info("Work Order update process {$request->wo_no} started by user ID: {$user->id}");
    
            // $wo->Case_No = $request->reference_number;
            // $wo->WO_Start = $startDate;
            // $wo->WO_End = $endDate;
            // $wo->WO_Narative = $request->work_description;
            $wo->Update_Date = now();

            if ($request->has('require_material') && $request->require_material === 'yes') {
                $wo->WO_NeedMat = 'Y';
                $wo->WO_MR = $request->intended_for ?? $wo->WO_MR; 
                $wo->WO_Status = 'Submit';
            } else {
                $wo->WO_NeedMat = 'N';   
                $wo->WO_MR = null;
                $wo->WO_Status = 'INPROGRESS';
            }
            
            $wo->save();
    
            // $case = Cases::where('Case_No', $request->reference_number)->first();
            // if ($case) {
            //     $case->Case_Status = 'INPROGRESS';
            //     $case->save();
            //     Log::info("Case {$request->reference_number} status updated to INPROGRESS by user ID: {$user->id}");
            
            //     Logs::create([
            //         'Logs_No' => Logs::generateLogsNo(),
            //         'LOG_Type' => 'BA',
            //         'LOG_RefNo' => $request->reference_number,
            //         'LOG_Status' => 'INPROGRESS',
            //         'LOG_User' => $user->id,
            //         'LOG_Date' => now(),
            //         'LOG_Desc' => 'Sent and Case Inprogress.',
            //     ]);
        
            // }

            // if ($request->has('assigned_to')) {
            //     $existingTechnicians = DB::table('WO_DoneBy')
            //         ->where('WO_No', $request->wo_no)
            //         ->pluck('technician_id')
            //         ->toArray();
    
            //     foreach ($request->assigned_to as $tech_id) {
            //         if (!in_array($tech_id, $existingTechnicians)) {
            //             DB::table('WO_DoneBy')->insert([
            //                 'WO_No' => $request->wo_no,
            //                 'technician_id' => $tech_id,
            //                 'created_at' => now(),
            //                 'updated_at' => now(),
            //             ]);
    
            //             Log::info("Technician {$tech_id} added to WO {$request->wo_no} by {$user->Fullname}");
            //         }
            //     }
            // }
    
            Logs::create([
                'Logs_No' => Logs::generateLogsNo(),
                'LOG_Type' => 'WO',
                'LOG_RefNo' => $request->wo_no,
                'LOG_Status' => 'SUBMITTED',
                'LOG_User' => $user->id,
                'LOG_Date' => now(),
                'LOG_Desc' => 'Succesfully Submitted a Work Order.',
            ]);
    
            return response()->json([
                'success' => true,
                'message' => 'Work Order successfully Submitted!'
            ]);
    
        } catch (\Exception $e) {
            Log::error('Failed to update Work Order. Error: ' . $e->getMessage());
    
            Logs::create([
                'Logs_No' => Logs::generateLogsNo(),
                'LOG_Type' => 'WO',
                'LOG_RefNo' => $request->wo_no,
                'LOG_Status' => 'FAILED',
                'LOG_User' => $user->id,
                'LOG_Date' => now(),
                'LOG_Desc' => 'FAILED TO SUBMITTED WORK ORDER. Error: ' . $e->getMessage(),
            ]);
    
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    // Mengambil data WO dari Database dan tampilkan pada table WO
    // public function getWorkOrders(Request $request)
    // {
    //     $userId = Auth::id();
    
    //     $workOrders = WorkOrder::with(['createdBy','completedBy'])  
    //         ->where('CR_BY', $userId)
    //         ->get()
    //         ->map(function ($wo) {
    //             return [
    //                 'WO_No' => $wo->WO_No,
    //                 'Case_No' => $wo->Case_No,
    //                 'created_by_fullname' => $wo->createdBy ? $wo->createdBy->Fullname : '-',
    //                 'CR_DT' => $wo->CR_DT,
    //                 'WO_Start' => $wo->WO_Start,
    //                 'WO_End' => $wo->WO_End,
    //                 'WO_Status' => $wo->WO_Status,
    //                 'WO_Narative' => $wo->WO_Narative,
    //                 'WO_NeedMat' => $wo->WO_NeedMat,
    //                 'WO_CompDate' => $wo->WO_CompDate,
    //                 'WO_CompBy' => $wo->WO_CompBy,
    //                 'completed_by_fullname' => $wo->completedBy ? $wo->completedBy->Fullname : '-', 

    //             ];
    //         });
    
    //     return response()->json($workOrders);
    // }

    public function getWorkOrders(Request $request)
    {
        try {
            $userId = Auth::id();
            $user = Auth::user(); 
            $userId = $user->id;
            $userPosition = $user->position?->PS_Name ?? null;
            Log::info('User position: ' . $userPosition);


            $workOrders = WorkOrder::with(['createdBy', 'completedBy'])  
                // ->where('CR_BY', $userId)
                ->when($userPosition !== 'Creator', function ($query) use ($userId) {
                    $query->where('CR_BY', $userId); 
                })
                ->get()
                ->map(function ($wo) {
                    return [
                        'WO_No' => $wo->WO_No,
                        'Case_No' => $wo->Case_No,
                        'created_by_fullname' => $wo->createdBy ? $wo->createdBy->Fullname : '-',
                        'CR_DT' => $wo->CR_DT,
                        'WO_Start' => $wo->WO_Start,
                        'WO_End' => $wo->WO_End,
                        'WO_Status' => $wo->WO_Status,
                        'WO_Narative' => $wo->WO_Narative,
                        'WO_NeedMat' => $wo->WO_NeedMat,
                        'WO_CompDate' => $wo->WO_CompDate,
                        'WO_CompBy' => $wo->WO_CompBy,
                        'completed_by_fullname' => $wo->completedBy ? $wo->completedBy->Fullname : '-', 
                    ];
                });

            return response()->json($workOrders);
        } catch (\Exception $e) {
            Log::error('Error fetching WO data: ' . $e->getMessage());
            return response()->json(['error' => 'Server error occurred.'], 500);
        }
    }


    public function DeleteWO($encoded_wo_no)
    {
        $woNo = base64_decode($encoded_wo_no);
        $userPosition = strtoupper(Auth::user()->position->PS_Name ?? '');

        if (!in_array($userPosition, ['CREATOR', 'APPROVER'])) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin menghapus Work Order ini.');
        }

        $wo = WorkOrder::where('WO_No', $woNo)->firstOrFail();
        $wo->delete();

        return redirect()->back()->with('success', 'Work Order berhasil dihapus.');
    }




    // Get WO NO    
    public function GetWorkOrderNo(Request $request)
    {
        $wo_no = $request->wo_no;

        if (!$wo_no) {
            return redirect()->back()->with('error', 'Work Order number is required.');
        }

        $request->session()->put('wo_no', $wo_no);
        return redirect()->route('WorkOrderDetail');
    }

    public function showDetailWO($encodedWONo)
    {
        $wo_no = base64_decode($encodedWONo); 

        if (!$wo_no) {
            return redirect()->back()->with('error', 'Work Order not found.');
        }

        $workOrder = DB::table('Work_Orders')
            ->select(
                'Work_Orders.WO_No',
                'Work_Orders.Case_No',
                'Work_Orders.WOC_No',
                'Work_Orders.CR_DT',
                'Work_Orders.WO_Start',
                'Work_Orders.WO_End',
                'Work_Orders.WO_Status',
                'Work_Orders.WO_Narative',
                'Work_Orders.WO_NeedMat',
                'Work_Orders.WO_IsComplete',
                'Work_Orders.WO_CompDate',
                'Work_Orders.WO_IsReject',
                'Work_Orders.WO_RejGroup',
                'Work_Orders.WO_RejDate',
                'Work_Orders.WO_APStep',
                'Work_Orders.WO_APMaxStep',
                'Work_Orders.WO_RMK1',
                'Work_Orders.WO_RMK2',
                'Work_Orders.WO_RMK3',
                'Work_Orders.WO_RMK4',
                'Work_Orders.WO_RMK5',
                'Work_Orders.Update_Date',
                'cr.Fullname as Creator_Name',
                'mr.Fullname as MR_Requestor'
            )
            ->leftJoin('users as cr', 'Work_Orders.CR_BY', '=', 'cr.id')
            ->leftJoin('users as mr', 'Work_Orders.WO_MR', '=', 'mr.id')
            ->where('Work_Orders.WO_No', $wo_no)
            ->first();

        if (!$workOrder) {
            return redirect()->back()->with('error', 'Work Order not found.');
        }

        $logs = DB::table('Logs')
            ->join('users', 'Logs.LOG_User', '=', 'users.id')
            ->select('Logs.*', 'users.Fullname as user_name')
            ->where('LOG_Type', 'WO') 
            ->where('LOG_RefNo', $workOrder->WO_No)
            ->orderBy('LOG_Date', 'desc')
            ->get();

        return view('content.wo.DetailWO', compact('workOrder','logs'));
    }

    


}

