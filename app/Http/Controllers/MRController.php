<?php

namespace App\Http\Controllers;

use App\Models\Logs;
use App\Models\material;
use App\Models\MatReq;
use App\Models\MatReqChild;
use App\Models\Matrix;
use App\Models\Notification;
use App\Models\User;
use App\Models\WorkOrder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class MRController extends Controller
{
    //View Page Create MR
    public function createMR(){

        $materials = material::all();

        return view('content.mr.CreateMR', compact('materials'));
    }

    // Ambil Data WO untuk Create MR
    public function getWOByUser(Request $request)
    {
        $userId = $request->user_id;

        // $data = DB::table('Work_Orders as wo')
        //     ->join('users as u', 'wo.CR_BY', '=', 'u.id')
        //     ->leftJoin('Positions as p', 'u.PS_ID', '=', 'p.id')
        //     ->select(
        //         'wo.Case_No',
        //         'wo.WO_No',
        //         'u.Fullname as created_by',
        //         'p.PS_Name as department'
        //     )
        //     ->where('wo.CR_BY', $userId)
        //     ->where('wo.WO_Status', 'SUBMIT')
        //     ->where('wo.WO_NeedMat','Y')
        //     ->groupBy('wo.Case_No', 'wo.WO_No', 'u.Fullname', 'p.PS_Name')
        //     ->get();

        $data = DB::table('Work_Orders as wo')
            ->join('users as u', 'wo.CR_BY', '=', 'u.id')
            ->leftJoin('Positions as p', 'u.PS_ID', '=', 'p.id')
            ->select(
                'wo.Case_No',
                'wo.WO_No',
                'u.Fullname as created_by',
                'p.PS_Name as department'
            )
            ->where(function ($query) use ($userId) {
                $query->where('wo.WO_MR', $userId);
                    // ->orWhere('wo.WO_MR', $userId);
            })
            ->where('wo.WO_Status', 'SUBMIT')
            ->where('wo.WO_NeedMat', 'Y')
            ->groupBy('wo.Case_No', 'wo.WO_No', 'u.Fullname', 'p.PS_Name')
            ->get();


        return response()->json($data);
    }

    // Ambil Detail WO, Berdasarkan WO yang dipilih Oleh user untuk ditampilkan di FIeld Create
    public function getWODetails(Request $request)
    {
        $woNo = $request->wo_no;

        $data = DB::table('Work_Orders as wo')
            ->join('users as u', 'wo.CR_BY', '=', 'u.id')
            ->leftJoin('Positions as p', 'u.PS_ID', '=', 'p.id')
            ->leftJoin('cases as c', 'wo.Case_No', '=', 'c.Case_No')
            ->select(
                'wo.WO_No',
                'wo.Case_No',
                 'c.Case_Name',
                'u.Fullname as created_by',
                'p.PS_Name as department'
            )
            ->where('wo.WO_No', $woNo)
            ->first();

        return response()->json($data);
    }

    // Proses Save MR 
    public function SaveMR(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'reference_number' => 'required',
                'date' => 'required|date',
                'Designation' => 'required|string',
                'items' => 'required|array|min:1',
                'items.*.qty' => 'required|numeric|min:1',
                'items.*.name' => 'required|string',
                'items.*.code' => 'nullable|string',
            ]);

            $newMRNo = MatReq::generateMRNo();
            // $MrDate = Carbon::createFromFormat('d/m/Y H:i', $request->date)->format('Y-m-d H:i:s');
            $MrDate = Carbon::createFromFormat('Y-m-d H:i', $request->date)->format('Y-m-d H:i:s');

            $matReq = MatReq::create([
                'MR_No' => $newMRNo,
                'WO_No' => $request->reference_number,
                'MR_IsUrgent' => $request->has('is_urgent') ? 'Y' : 'N',
                'Case_No' => $request->case_no,
                'MR_Date' => $MrDate,
                'MR_Allotment' => $request->Designation,
                'CR_BY' => Auth::id(),
                'CR_DT' => now(),
                'MR_Status' => 'Open',
                'MR_IsReject' => 'N',
                'MR_APStep' => 0,
                'MR_APMaxStep' => 5,
            ]);

            $line = 1;
            foreach ($request->items as $item) {
                MatReqChild::create([
                    'MR_No' => $newMRNo,
                    'MR_Line' => $line++,
                    'Item_Oty' => $item['qty'],
                    'CR_ITEM_SATUAN' => $item['unit'] ?? '-',
                    'CR_ITEM_CODE' => $item['code'] ?? '-',
                    'CR_ITEM_NAME' => $item['name'],
                    'Remark' => $item['desc'] ?? '-',
                    'UOM_Code' => $item['unit_cd'] ?? '-',
                    'UOM_Name' => $item['unit'] ?? '-'
                ]);
            }

            // Update Work Order status to OnProgress
            $wo_no = $request->reference_number;
            WorkOrder::where('WO_No', $wo_no)->update(['WO_Status' => 'INPROGRESS']);
            
            DB::commit();

            Log::info("Material Request $newMRNo saved successfully by user ID " . Auth::id());
            $userName = Auth::user()->Fullname;

            Logs::create([
                'Logs_No' => Logs::generateLogsNo(),
                'LOG_Type' => 'MR',
                'LOG_RefNo' => $newMRNo,
                'LOG_Status' => 'CREATED',
                'LOG_User' => Auth::id(),
                'LOG_Date' => now(),
                'LOG_Desc' => $userName . ' CREATED NEW MATERIAL REQUEST',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Your material request has been successfully saved.',
                'mr_no' => $newMRNo,
                'wo_no' => $request->reference_number
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error("Failed to save Material Request: " . $e->getMessage());

            Logs::create([
                'Logs_No' => Logs::generateLogsNo(),
                'LOG_Type' => 'MR',
                'LOG_RefNo' => $request->reference_number ?? 'UNKNOWN',
                'LOG_Status' => 'FAILED',
                'LOG_User' => Auth::id(),
                'LOG_Date' => now(),
                'LOG_Desc' => 'FAILED TO CREATED NEW MATERIAL REQUEST',
            ]);

            return response()->json(['message' => 'Failed to save: ' . $e->getMessage()], 500);
        }
    }

    // Page Edit Material Request 
    public function EditMR($mr_no)
    {
        $mr_no = base64_decode($mr_no);
        $userId = Auth::id();

        if (!$mr_no) {
            return redirect('/Material-Request/Create')->with('error', 'No Material Request selected.');
        }
    
        $matReq = MatReq::with(['createdBy.position', 'workOrder', 'children'])
                        ->where('MR_No', $mr_no)
                        ->first();
    
        if (!$matReq) {
            return redirect('/Material-Request/Create')->with('error', 'Material Request not found.');
        }

        if ($matReq->MR_Status === 'REJECT') {
            $matReq->update(['MR_Status' => 'OPEN']);
            
            Logs::create([
                'Logs_No' => Logs::generateLogsNo(),
                'LOG_Type' => 'MR',
                'LOG_RefNo' => $mr_no,
                'LOG_Status' => 'REVISION',
                'LOG_User' => $userId,
                'LOG_Date' => now(),
                'LOG_Desc' => 'A revision was made to the MR data due to the rejection of the previous submission.',
            ]);
        }

        return view('content.mr.EditMR', [
            'matReq' => $matReq,
            'matReqChilds' => $matReq->children,
        ]);
    }

    public function SaveDraftMR(Request $request){
        
        $userId = Auth::id();

        $request->validate([
                'mr_no' => 'required|string',
                'reference_number' => 'required',
                'date' => 'required|date',
                'Designation' => 'required|string',
                'items' => 'required|array|min:1',
                'items.*.qty' => 'required|numeric|min:1',
                'items.*.name' => 'required|string',
                'items.*.code' => 'nullable|string',
        ]);

        try{
            $mr = MatReq::where('MR_No', $request->mr_no)->first();

            if (!$mr) {
                return response()->json([
                    'success' => false,
                    'message' => 'Material Request tidak ditemukan. Pastikan data sudah pernah disimpan.'
                ]);
            }

            $MrDate = Carbon::createFromFormat('Y-m-d H:i', $request->date)->format('Y-m-d H:i:s');
            
            $mr->MR_Date = $MrDate;
            $mr->MR_Allotment = $request->Designation;
            $mr->MR_IsUrgent = $request->has('is_urgent') ? 'Y' : 'N';
            $mr->Update_Date = now();
            $mr->MR_Status = 'OPEN';
            $mr->save();

            MatReqChild::where('MR_No', $mr->MR_No)->delete();

            foreach ($request->items as $index => $item) {
                MatReqChild::create([
                    'MR_No' => $mr->MR_No,
                    'MR_Line' => $index + 1,
                    'CR_ITEM_CODE' => $item['code'],
                    'CR_ITEM_NAME' => $item['name'],
                    'CR_ITEM_SATUAN' => $item['unit'],
                    'Item_Oty' => $item['qty'],
                    'Remark' => $item['desc'],
                    'UOM_Code' => $item['unit_cd'] ?? '-',
                    'UOM_Name' => $item['unit'] ?? '-'
                ]);
            }

            Logs::create([
                'Logs_No' => Logs::generateLogsNo(),
                'LOG_Type'   => 'MR',
                'LOG_RefNo'  => $mr->MR_No,
                'LOG_Status' => 'DRAFT_SAVED',
                'LOG_User'   => $userId,
                'LOG_Date'   => now(),
                'LOG_Desc'   => 'Material Request has been successfully saved as a draft.',
            ]);
            
            return response()->json(['success' => true, 'message' => 'Your material request has been successfully saved as a draft.']);

        }catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }

    public function UpdateMR(Request $request)
    {
        $userId = Auth::id();
        $wo_no = $request->wo_no;

        DB::beginTransaction();

        try {
            $mr = MatReq::where('WO_No', $wo_no)->firstOrFail();

            if ($mr->MR_IsReject === 'Y') {
                $mr->MR_IsReject = 'N';
                $mr->MR_RejGroup = null;
                $mr->MR_RejBy = null;
                $mr->MR_RejDate = null;
                $mr->MR_RMK1 = null;
                $mr->MR_RMK2 = null;
                $mr->MR_RMK3 = null;
                $mr->MR_RMK4 = null;
                $mr->MR_RMK5 = null;

                Log::info('Update MR: Reset status REJECT karena user melakukan revisi', [
                    'MR_No' => $mr->Case_No
                ]);       
            }

            $mr->MR_Date = $request->date;
            $mr->MR_Allotment = $request->Designation;

                // $matrix = collect([
                //     ['Mat_No' => 9, 'Position' => 5, 'Mat_Type' => 'MR', 'Mat_Max' => 4 ,'AP1' => 10, 'AP2' => 12, 'AP3' => 15, 'AP4' => 16],
                //     ['Mat_No' => 10, 'Position' => 3, 'Mat_Type' => 'MR', 'Mat_Max' => 4 ,'AP1' => 10, 'AP2' => 12, 'AP3' => 15, 'AP4' => 16],
                //     ['Mat_No' => 11, 'Position' => 8, 'Mat_Type' => 'MR', 'Mat_Max' => 4 ,'AP1' => 10, 'AP2' => 12, 'AP3' => 15, 'AP4' => 16],
                //     ['Mat_No' => 12, 'Position' => 2, 'Mat_Type' => 'MR', 'Mat_Max' => 4 ,'AP1' => 10, 'AP2' => 12, 'AP3' => 15, 'AP4' => 16],
                //     ['Mat_No' => 14, 'Position' => 14, 'Mat_Type' => 'MR', 'Mat_Max' => 4 ,'AP1' => 18, 'AP2' => 18, 'AP3' => 18, 'AP4' => 18],

                // ]);

            $userPosition = Auth::user()->Position->id;

            $matrixRow = Matrix::where('Mat_Type', 'MR')
                ->where('Position', $userPosition)
                ->first();

            // $userPosition = Auth::user()->Position->id;
            // $matrixRow = $matrix->firstWhere('Position', $userPosition);

            // if ($matrixRow) {
            //     $mr->MR_AP1 = $matrixRow['AP1'] ?? null;
            //     $mr->MR_AP2 = $matrixRow['AP2'] ?? null;
            //     $mr->MR_AP3 = $matrixRow['AP3'] ?? null;
            //     $mr->MR_AP4 = $matrixRow['AP4'] ?? null;
            //     $mr->MR_AP5 = $matrixRow['AP5'] ?? null;
            //     $mr->MR_APStep = 1;
            //     $mr->MR_APMaxStep = $matrixRow['Mat_Max'];
            // }

            if ($matrixRow) {
                $mr->MR_AP1 = $matrixRow->AP1 ?? null;
                $mr->MR_AP2 = $matrixRow->AP2 ?? null;
                $mr->MR_AP3 = $matrixRow->AP3 ?? null;
                $mr->MR_AP4 = $matrixRow->AP4 ?? null;
                $mr->MR_AP5 = $matrixRow->AP5 ?? null;
                $mr->MR_APStep = 1;
                $mr->MR_APMaxStep = $matrixRow->Mat_Max;
            }


            $mr->Update_Date = now();
            $mr->MR_Status = 'SUBMIT';
            $mr->save();

            MatReqChild::where('MR_No', $mr->MR_No)->delete();

            foreach ($request->items as $index => $item) {
                MatReqChild::create([
                    'MR_No' => $mr->MR_No,
                    'MR_Line' => $index + 1,
                    'CR_ITEM_CODE' => $item['code'],
                    'CR_ITEM_NAME' => $item['name'],
                    'CR_ITEM_SATUAN' => $item['unit'],
                    'Item_Oty' => $item['qty'],
                    'Remark' => $item['desc'],
                    'UOM_Code' => $item['unit_cd'] ?? '-',
                    'UOM_Name' => $item['unit'] ?? '-'
                ]);
            }

            Notification::create([
                'Notif_No' => Notification::generateNotificationNo(),
                'Notif_Title' => 'Material Request Approval ',
                'Reference_No' => $mr->MR_No,
                'Notif_Text' => 'A Material Request has been submitted and requires your approval.',
                'Notif_IsRead' => 'N',
                'Notif_From' => Auth::id(),
                'Notif_To' => $mr->MR_AP1,  
                'Notif_Date' => now(),
                'Notif_Type' => 'MR',
            ]);
            $userName = Auth::user()->Fullname;

            Logs::create([
                'Logs_No' => Logs::generateLogsNo(),
                'LOG_Type'   => 'MR',
                'LOG_RefNo'  => $mr->MR_No,
                'LOG_Status' => 'SUBMITTED',
                'LOG_User'   => $userId,
                'LOG_Date'   => now(),
                'LOG_Desc'   => $userName . ' SUBMITTED MATERIAL REQUEST',
            ]);
    
            Log::info('Material Request submitted successfully by user_id: ' . $userId);
            DB::commit();

            return response()->json(['success' => true, 'message' => 'Your material request has been submitted successfully.']);

        } catch (\Exception $e) {
            DB::rollBack();

            Logs::create([
                'Logs_No' => Logs::generateLogsNo(),
                'LOG_Type'   => 'MR',
                'LOG_RefNo'  => $mr->MR_No,
                'LOG_Status' => 'FAILED',
                'LOG_User'   => $userId,
                'LOG_Date'   => now(),
                'LOG_Desc'   => substr('FAILED TO SUBMIT Material Request. Error: ' . $e->getMessage(), 0, 255),
            ]);

            Log::error('Material Request update failed by user_id: ' . $userId . ', Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

// Page List MR
    public function PageListMR(){
        return view('content.mr.ListMR');
    }

// Ambil data MR untuk ditampilkan dalam table
    // public function GetDataMr(Request $request)
    // {
    //     $userId = Auth::id(); 
    //     $status = $request->query('status'); 
    //     $sortColumn = $request->query('sortColumn', 'MR_No'); 
    //     $sortDirection = $request->query('sortDirection', 'ASC');
    
    //     $validColumns = ['MR_No', 'MR_Date'];
    //     if (!in_array($sortColumn, $validColumns)) {
    //         $sortColumn = 'MR_No'; 
    //     }
    
    //     $query = MatReq::select(
    //             'Mat_Req.MR_No',
    //             'Mat_Req.WO_No',
    //             'Mat_Req.Case_No',
    //             'Mat_Req.MR_Date',
    //             'Mat_Req.MR_Status',
    //             'Mat_Req.MR_IsUrgent',
    //             'Mat_Req.CR_BY',
    //             'users.Fullname as CreatedBy'
    //         )
    //         ->leftJoin('users', 'Mat_Req.CR_BY', '=', 'users.id')
    //         ->where('Mat_Req.CR_BY', $userId);
    
    //     if (!empty($status)) {
    //         $query->where('Mat_Req.MR_Status', $status);
    //     }
    
    //     $matReqs = $query->orderBy($sortColumn, $sortDirection)->get();
    
    //     return response()->json($matReqs);
    // }

    public function GetDataMr(Request $request)
    {
        $userId = Auth::id(); 
        $status = $request->query('status'); 
        $sortColumn = $request->query('sortColumn', 'MR_No'); 
        $sortDirection = $request->query('sortDirection', 'ASC');
       
        $user = Auth::user();
        $userId = $user->id;
        $userPosition = $user->position?->PS_Name ?? null;

        $validColumns = ['MR_No', 'MR_Date'];
        if (!in_array($sortColumn, $validColumns)) {
            $sortColumn = 'MR_No'; 
        }

        // $query = MatReq::select(
        //     'Mat_Req.MR_No',
        //     'Mat_Req.WO_No',
        //     'Mat_Req.Case_No',
        //     'Mat_Req.MR_Date',
        //     'Mat_Req.MR_Status',
        //     'Mat_Req.MR_IsUrgent',
        //     'Mat_Req.CR_BY',
        //     'users.Fullname as CreatedBy'
        // )
        // ->leftJoin('users', 'Mat_Req.CR_BY', '=', 'users.id')
        // ->where(function ($q) use ($userId) {
        //     $q->where('Mat_Req.CR_BY', $userId)
        //     ->orWhere('Mat_Req.MR_AP1', $userId)
        //     ->orWhere('Mat_Req.MR_AP2', $userId)
        //     ->orWhere('Mat_Req.MR_AP3', $userId)
        //     ->orWhere('Mat_Req.MR_AP4', $userId);
        // });
        $query = MatReq::select(
            'Mat_Req.MR_No',
            'Mat_Req.WO_No',
            'Mat_Req.Case_No',
            'Mat_Req.MR_Date',
            'Mat_Req.MR_Status',
            'Mat_Req.MR_IsUrgent',
            'Mat_Req.CR_BY',
            'users.Fullname as CreatedBy'
        )
        ->leftJoin('users', 'Mat_Req.CR_BY', '=', 'users.id')
        ->when($userPosition !== 'Creator', function ($q) use ($userId) {
            $q->where(function ($q2) use ($userId) {
                $q2->where('Mat_Req.CR_BY', $userId)
                    ->orWhere('Mat_Req.MR_AP1', $userId)
                    ->orWhere('Mat_Req.MR_AP2', $userId)
                    ->orWhere('Mat_Req.MR_AP3', $userId)
                    ->orWhere('Mat_Req.MR_AP4', $userId);
            });
        });

        if (!empty($status)) {
            $query->where('Mat_Req.MR_Status', $status);
        }

        if ($sortColumn) {
        $query->orderBy($sortColumn, $sortDirection);
        } else {
            $query->orderBy('Mat_Req.MR_Date', 'DESC')
                ->orderBy('Mat_Req.MR_No', 'DESC');
        }

        $matReqs = $query->orderBy($sortColumn, $sortDirection)->get();

        return response()->json($matReqs);
    }

    // Delete MR Page List MR
    public function DestroyMR($encoded)
    {
        $mrNo = base64_decode($encoded);
        $mr = MatReq::where('MR_No', $mrNo)->firstOrFail();
        $mr->delete();

        return redirect()->back()->with('success', 'Material Request berhasil dihapus.');
    }




    
    
// PAGE Details MR 
    public function detail($encodedMRNo)
    {
        $mrNo = base64_decode($encodedMRNo);

        // $materialRequest = MatReq::where('MR_No', $mrNo)
        // ->with('createdBy')
        // ->first();
        $materialRequest = MatReq::with(['approver1', 'approver2', 'approver3', 'approver4', 'approver5','createdBy'])->where('MR_No', $mrNo)->first();

        if (!$materialRequest) {
            return redirect()->back()->with('error', 'Material Request not found.');
        }

        $materialRequestDetails = MatReqChild::where('MR_No', $mrNo)->get();

        $logs = DB::table('Logs')
        ->join('users', 'Logs.LOG_User', '=', 'users.id')
        ->select('Logs.*', 'users.Fullname as user_name')
        ->where('LOG_Type', 'MR') 
        ->where('LOG_RefNo', $materialRequest->MR_No)
        ->orderBy('LOG_Date', 'asc')
        ->get();

        $approvers = [];

        for ($i = 1; $i <= $materialRequest->MR_APMaxStep; $i++) {
            $approverId = $materialRequest->{'MR_AP' . $i} ?? null;

            if ($approverId) {
                $user = User::find($approverId);
                $approvers[$i] = $user ? $user->Fullname : 'Unknown User';
            } else {
                $approvers[$i] = 'Unknown User';
            }
        }

        $lastResetLog = $logs->last(function ($log) {
            return in_array($log->LOG_Status, ['SUBMITTED', 'REVISION']);
        });

        $resetTime = $lastResetLog ? $lastResetLog->LOG_Date : null;

        $approvalLogs = $logs->filter(function ($log) use ($resetTime) {
            return $resetTime &&
                $log->LOG_Date > $resetTime &&
                (
                    Str::startsWith($log->LOG_Status, 'APPROVED') ||
                    Str::startsWith($log->LOG_Status, 'REJECTED')
                );
        });

        return view('content.mr.DetailMR', [
            'materialRequest' => $materialRequest,
            'details' => $materialRequestDetails,
            'logs' => $logs,
            'approvers' => $approvers,
            'approvalLogs' => $approvalLogs,
        ]);
    }

// Hapus Baris Material Req di page edit 
    public function deleteMaterial(Request $request)
    {
        $mrNo = $request->input('mr_no');
        $mrLine = $request->input('mr_line');

        try {
            $deleted = DB::table('Mat_Req_Child')
                ->where('MR_No', $mrNo)
                ->where('MR_Line', $mrLine)
                ->delete();

            if ($deleted) {
                return response()->json([
                    'success' => true,
                    'message' => 'Material deleted successfully!'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Material not found or already deleted.'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete material: ' . $e->getMessage()
            ]);
        }
    }


// PAGE MR APPROVAL
    // View Page Approval
    public function ApprovalListMR(Request $request){
        return view('content.mr.ListApprovalMR');
    }

    // Get Case No Untuk Reference No Page Approval
    public function getCases(Request $request)
    {
        $cases = DB::table('Mat_Req')
            ->select('Case_No')
            ->where('MR_Status', 'SUBMIT')
            ->where('MR_APStep', 1)
            ->distinct()
            ->get();

        return response()->json($cases);
    }

    public function getCaseDetails($encodedCaseNo)
    {
        $caseNo = base64_decode($encodedCaseNo);

        $data = DB::table('Mat_Req as mr')
            ->join('users as u', 'u.id', '=', 'mr.CR_BY')
            ->join('cases as c', 'c.Case_No', '=', 'mr.Case_No')
            ->join('Positions as p', 'p.id', '=', 'u.PS_ID')
            ->select(
                'mr.MR_No',
                'mr.WO_No',
                'mr.CR_DT',
                'mr.MR_Allotment',
                'mr.MR_Status',
                'u.Fullname as Created_By', 
                'p.PS_Name' 
            )
            ->where('mr.Case_No', $caseNo)
            ->where('mr.MR_Status', 'SUBMIT')
            ->where('mr.MR_APStep', 1)
            ->first();

        return response()->json($data);
    }


    // Ambil data MR yang hendak di approval dan tampilkan di table 
    // Versi 26 May
    // public function getApprovalMR(Request $request)
    // {
    //     $userId = Auth::id();
    //     $status = $request->query('status');
    //     $sortColumn = $request->query('sortColumn', 'MR_No');
    //     $sortDirection = $request->query('sortDirection', 'ASC');

    //     $validColumns = ['MR_No', 'WO_No', 'Case_No', 'MR_Date', 'MR_Status'];
    //     if (!in_array($sortColumn, $validColumns)) {
    //         $sortColumn = 'MR_No'; 
    //     }

    //     $query = MatReq::select(
    //             'Mat_Req.MR_No',
    //             'Mat_Req.WO_No',
    //             'Mat_Req.Case_No',
    //             'Mat_Req.MR_Date',
    //             'Mat_Req.MR_Status',
    //             'Mat_Req.MR_IsUrgent',
    //             'Mat_Req.CR_BY',
    //             'users.Fullname as CreatedBy'
    //         )
    //         ->leftJoin('users', 'Mat_Req.CR_BY', '=', 'users.id')
    //         ->where(function($q) use ($userId) {
    //             $q->where(function($sub) use ($userId) {
    //                 $sub->where('Mat_Req.MR_APStep', 1)
    //                     ->where('Mat_Req.MR_Status', 'SUBMIT')
    //                     ->where('Mat_Req.MR_AP1', $userId);
    //             })
    //             ->orWhere(function($sub) use ($userId) {
    //                 $sub->where('Mat_Req.MR_APStep', 2)
    //                     ->where('Mat_Req.MR_Status', 'AP1')
    //                     ->where('Mat_Req.MR_AP2', $userId);
    //             })
    //             ->orWhere(function($sub) use ($userId) {
    //                 $sub->where('Mat_Req.MR_APStep', 3)
    //                     ->where('Mat_Req.MR_Status', 'AP2')
    //                     ->where('Mat_Req.MR_AP3', $userId);
    //             })
    //             ->orWhere(function($sub) use ($userId) {
    //                 $sub->where('Mat_Req.MR_APStep', 4)
    //                     ->where('Mat_Req.MR_Status', 'AP3')
    //                     ->where('Mat_Req.MR_AP4', $userId);
    //             })
    //             ->orWhere(function($sub) use ($userId) {
    //                 $sub->where('Mat_Req.MR_APStep', 5)
    //                     ->where('Mat_Req.MR_Status', 'AP4')
    //                     ->where('Mat_Req.MR_AP5', $userId);
    //             });
    //         });

    //     if (!empty($status)) {
    //         $query->where('Mat_Req.MR_Status', $status);
    //     }

    //     $matreq = $query->orderBy($sortColumn, $sortDirection)->get();

    //     return response()->json($matreq);
    // }

    public function getApprovalMR(Request $request)
    {
        try {
            $userId = Auth::id();
            $status = $request->query('status');
            $sortColumn = $request->query('sortColumn', 'MR_No');
            $sortDirection = $request->query('sortDirection', 'ASC');

            $validColumns = ['MR_No', 'WO_No', 'Case_No', 'MR_Date', 'MR_Status'];
            if (!in_array($sortColumn, $validColumns)) {
                $sortColumn = 'MR_No'; 
            }

            $query = MatReq::select(
                    'Mat_Req.MR_No',
                    'Mat_Req.WO_No',
                    'Mat_Req.Case_No',
                    'Mat_Req.MR_Date',
                    'Mat_Req.MR_Status',
                    'Mat_Req.MR_IsUrgent',
                    'Mat_Req.CR_BY',
                    DB::raw('COALESCE(users.Fullname, "Unknown") as CreatedBy')
                )
                ->leftJoin('users', 'Mat_Req.CR_BY', '=', 'users.id')
                ->where(function($q) use ($userId) {
                    $q->where(function($sub) use ($userId) {
                        $sub->where('Mat_Req.MR_APStep', 1)
                            ->where('Mat_Req.MR_Status', 'SUBMIT')
                            ->where('Mat_Req.MR_AP1', $userId);
                    })
                    ->orWhere(function($sub) use ($userId) {
                        $sub->where('Mat_Req.MR_APStep', 2)
                            ->where('Mat_Req.MR_Status', 'AP1')
                            ->where('Mat_Req.MR_AP2', $userId);
                    })
                    ->orWhere(function($sub) use ($userId) {
                        $sub->where('Mat_Req.MR_APStep', 3)
                            ->where('Mat_Req.MR_Status', 'AP2')
                            ->where('Mat_Req.MR_AP3', $userId);
                    })
                    ->orWhere(function($sub) use ($userId) {
                        $sub->where('Mat_Req.MR_APStep', 4)
                            ->where('Mat_Req.MR_Status', 'AP3')
                            ->where('Mat_Req.MR_AP4', $userId);
                    })
                    ->orWhere(function($sub) use ($userId) {
                        $sub->where('Mat_Req.MR_APStep', 5)
                            ->where('Mat_Req.MR_Status', 'AP4')
                            ->where('Mat_Req.MR_AP5', $userId);
                    });
                });

            if (!empty($status)) {
                $query->where('Mat_Req.MR_Status', $status);
            }

            $matreq = $query->orderBy($sortColumn, $sortDirection)->get();

            return response()->json($matreq);

        } catch (\Exception $e) {
            Log::error('Error getApprovalMR: ' . $e->getMessage());
            return response()->json(['message' => 'Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    // Page Approval Detail
    public function ApprovalDetailMR($encodedMRNo)
    {
        $mrNo = base64_decode($encodedMRNo);

        $materialRequest = MatReq::with(['approver1', 'approver2', 'approver3', 'approver4', 'approver5','createdBy'])->where('MR_No', $mrNo)->first();

        if (!$materialRequest) {
            return abort(404, 'Material Request not found.');
        }

        $materialRequestDetails = MatReqChild::where('MR_No', $mrNo)->get();

        // Ambil waktu terakhir REVISION atau SUBMITTED
        $lastCycleLog = DB::table('Logs')
            ->where('LOG_Type', 'MR')
            ->where('LOG_RefNo', $materialRequest->MR_No)
            ->whereIn('LOG_Status', ['REVISION', 'SUBMITTED'])
            ->orderBy('LOG_Date', 'desc')
            ->first();

        $cycleStartDate = $lastCycleLog ? $lastCycleLog->LOG_Date : null;

        // Ambil semua log setelah tanggal REVISION atau SUBMITTED terakhir
        $logs = DB::table('Logs')
            ->join('users', 'Logs.LOG_User', '=', 'users.id')
            ->select('Logs.*', 'users.Fullname as user_name')
            ->where('LOG_Type', 'MR')
            ->where('LOG_RefNo', $materialRequest->MR_No)
            ->when($cycleStartDate, function ($query, $cycleStartDate) {
                return $query->where('LOG_Date', '>=', $cycleStartDate);
            })
            ->orderBy('LOG_Date', 'desc')
            ->get();


        return view('content.mr.ApprovalDetailMR', [
            'materialRequest' => $materialRequest,
            'details' => $materialRequestDetails,
            'logs' => $logs,
        ]);
    }

    // Function Approve & Reject
    public function approveReject(Request $request, $mr_no)
    {
        $mr_no = base64_decode($mr_no); 
        $mr = MatReq::where('MR_No', $mr_no)->firstOrFail();

        $hasChild = MatReqChild::where('MR_No', $mr_no)->exists();
        if (!$hasChild) {
            return response()->json(['error' => 'Material Request has no items'], 400);
        }

        $user = Auth::user();
        $notes = $request->input('approvalNotes');
        $action = $request->input('action');
    
        if ($action == 'approve') {
            if ($mr->MR_APStep == 1) {
                $mr->MR_Status = 'AP1'; 
                $mr->MR_RMK1 = $notes;
                $mr->MR_APStep = 2;

                if ($request->has('items')) {
                    foreach ($request->items as $item) {
                        if (isset($item['mr_line']) && isset($item['code'])) {
                            MatReqChild::where('MR_No', $mr_no)
                                ->where('MR_Line', $item['mr_line'])
                                ->update([
                                    'Item_Code' => $item['code'] ?? null,
                                    'Item_Name' => $item['name'] ?? null,
                                    'Item_Stock' => $item['stock'] ?? null,
                                    'UOM_Name' => $item['unit'] ?? null,
                                    'Item_Oty' => $item['qty'] ?? null,
                                    'Remark' => $item['desc'] ?? null,
                                ]);
                        }
                    }
                }

                Logs::create([
                    'Logs_No' => Logs::generateLogsNo(),
                    'LOG_Type'   => 'MR',
                    'LOG_RefNo'  => $mr_no,
                    'LOG_Status' => 'APPROVED 1',
                    'LOG_User'   => $user->id,
                    'LOG_Date'   => Carbon::now(),
                    'LOG_Desc'   => $user->Fullname . ' APPROVED MR',
                ]);
    
                Notification::create([
                    'Notif_No'      => Notification::generateNotificationNo(),
                    'Notif_Title'   => 'Material Request Approved',
                    'Reference_No'  => $mr->MR_No,
                    'Notif_Text'    => 'MR ' . $mr->MR_No . ' approved by ' . $user->Fullname,
                    'Notif_IsRead'  => 'N',
                    'Notif_From'    => $user->id,
                    'Notif_To'      => $mr->MR_AP2, 
                    'Notif_Date'    => Carbon::now(),
                    'Notif_Type'    => 'MR',
                ]);
    
            } elseif ($mr->MR_APStep == 2) {
                $mr->MR_Status = 'AP2'; 
                $mr->MR_RMK2 = $notes;
                $mr->MR_APStep = 3;
    
                Logs::create([
                    'Logs_No' => Logs::generateLogsNo(),
                    'LOG_Type'   => 'MR',
                    'LOG_RefNo'  => $mr_no,
                    'LOG_Status' => 'APPROVED 2',
                    'LOG_User'   => $user->id,
                    'LOG_Date'   => Carbon::now(),
                    'LOG_Desc'   => $user->Fullname . ' APPROVED MR',
                ]);
    
                Notification::create([
                    'Notif_No'      => Notification::generateNotificationNo(),
                    'Notif_Title'   => 'Material Request Approved',
                    'Reference_No'  => $mr->MR_No,
                    'Notif_Text'    => 'MR ' . $mr->MR_No . ' approved by ' . $user->Fullname,
                    'Notif_IsRead'  => 'N',
                    'Notif_From'    => $user->id,
                    'Notif_To'      => $mr->MR_AP3, 
                    'Notif_Date'    => Carbon::now(),
                    'Notif_Type'    => 'MR',
                ]);
            } elseif ($mr->MR_APStep == 3) {
                $mr->MR_Status = 'AP3'; 
                $mr->MR_RMK3 = $notes;
                $mr->MR_APStep = 4;
    
                Logs::create([
                    'Logs_No' => Logs::generateLogsNo(),
                    'LOG_Type'   => 'MR',
                    'LOG_RefNo'  => $mr_no,
                    'LOG_Status' => 'APPROVED 3',
                    'LOG_User'   => $user->id,
                    'LOG_Date'   => Carbon::now(),
                    'LOG_Desc'   => $user->Fullname . ' APPROVED MR',
                ]);
    
                Notification::create([
                    'Notif_No'      => Notification::generateNotificationNo(),
                    'Notif_Title'   => 'Material Request Approved',
                    'Reference_No'  => $mr->MR_No,
                    'Notif_Text'    => 'MR ' . $mr->MR_No . ' approved by ' . $user->Fullname,
                    'Notif_IsRead'  => 'N',
                    'Notif_From'    => $user->id,
                    'Notif_To'      => $mr->MR_AP4, 
                    'Notif_Date'    => Carbon::now(),
                    'Notif_Type'    => 'MR',
                ]);
            } elseif ($mr->MR_APStep == 4) {
                $mr->MR_Status = 'AP4'; 
                $mr->MR_RMK4 = $notes;
                $mr->MR_APStep = 4;
    
                Logs::create([
                    'Logs_No' => Logs::generateLogsNo(),
                    'LOG_Type'   => 'MR',
                    'LOG_RefNo'  => $mr_no,
                    'LOG_Status' => 'APPROVED 4',
                    'LOG_User'   => $user->id,
                    'LOG_Date'   => Carbon::now(),
                    'LOG_Desc'   => $user->Fullname . ' APPROVED MR',
                ]);

                Logs::create([
                    'Logs_No' => Logs::generateLogsNo(),
                    'LOG_Type'   => 'MR',
                    'LOG_RefNo'  => $mr_no,
                    'LOG_Status' => 'DONE',
                    'LOG_User'   => $user->id,
                    'LOG_Date'   => Carbon::now(),
                    'LOG_Desc'   => 'Material Request Successfuly Done',
                ]);
    
                Notification::create([
                    'Notif_No'      => Notification::generateNotificationNo(),
                    'Notif_Title'   => 'Material Request has been successfully approved.',
                    'Reference_No'  => $mr->MR_No,
                    'Notif_Text'    => 'MR ' . $mr->MR_No . ' approved by ' . $user->Fullname,
                    'Notif_IsRead'  => 'N',
                    'Notif_From'    => $user->id,
                    'Notif_To'      => $mr->CR_BY, 
                    'Notif_Date'    => Carbon::now(),
                    'Notif_Type'    => 'MR',
                ]);
            } else {
                return response()->json(['error' => 'Invalid approval step'], 400);
            }
    
            $mr->save();
    
            return response()->json(['message' => 'Material Request Approved Successfully']);
        } else {
            if ($mr->MR_APStep == 1) {
                $mr->MR_Status = 'REJECT';
                $mr->MR_IsReject = 'Y';
                $mr->MR_RejGroup = 'AP1';
                $mr->MR_RejBy = $user->id;
                $mr->MR_RejDate = Carbon::now();
                $mr->MR_RMK1 = $notes;
    
                Notification::create([
                    'Notif_No'      => Notification::generateNotificationNo(),
                    'Notif_Title'   => 'Material Request Rejected',
                    'Reference_No'  => $mr->MR_No,
                    'Notif_Text'    => 'MR ' . $mr->MR_No . ' rejected by ' . $user->Fullname,
                    'Notif_IsRead'  => 'N',
                    'Notif_From'    => $user->id,
                    'Notif_To'      => $mr->CR_BY,
                    'Notif_Date'    => Carbon::now(),
                    'Notif_Type'    => 'MR',
                ]);
    
                Logs::create([
                    'Logs_No' => Logs::generateLogsNo(),
                    'LOG_Type'   => 'MR',
                    'LOG_RefNo'  => $mr_no,
                    'LOG_Status' => 'REJECTED 1',
                    'LOG_User'   => $user->id,
                    'LOG_Date'   => Carbon::now(),
                    'LOG_Desc'   => $user->Fullname . ' REJECTED MR ' . $notes,
                ]);
    
            } elseif ($mr->MR_APStep == 2) {
                $mr->MR_Status = 'REJECT';
                $mr->MR_IsReject = 'Y';
                // $mr->MR_APStep = 1;
                $mr->MR_RejGroup = 'AP2';
                $mr->MR_RejBy = $user->id;
                $mr->MR_RejDate = Carbon::now();
                $mr->MR_RMK2 = $notes;
    
                Notification::create([
                    'Notif_No'      => Notification::generateNotificationNo(),
                    'Notif_Title'   => 'Material Request Rejected',
                    'Reference_No'  => $mr->MR_No,
                    'Notif_Text'    => 'MR ' . $mr->MR_No . ' rejected by ' . $user->Fullname,
                    'Notif_IsRead'  => 'N',
                    'Notif_From'    => $user->id,
                    'Notif_To'      => $mr->MR_AP1,
                    'Notif_Date'    => Carbon::now(),
                    'Notif_Type'    => 'MR',
                ]);
    
                Notification::create([
                    'Notif_No'      => Notification::generateNotificationNo(),
                    'Notif_Title'   => 'Material Request Rejected',
                    'Reference_No'  => $mr->MR_No,
                    'Notif_Text'    => 'MR ' . $mr->MR_No . ' rejected by ' . $user->Fullname,
                    'Notif_IsRead'  => 'N',
                    'Notif_From'    => $user->id,
                    'Notif_To'      => $mr->CR_BY,
                    'Notif_Date'    => Carbon::now(),
                    'Notif_Type'    => 'MR',
                ]);
    
                Logs::create([
                    'Logs_No' => Logs::generateLogsNo(),
                    'LOG_Type'   => 'MR',
                    'LOG_RefNo'  => $mr_no,
                    'LOG_Status' => 'REJECTED 2',
                    'LOG_User'   => $user->id,
                    'LOG_Date'   => Carbon::now(),
                    'LOG_Desc'   => $user->Fullname . ' REJECTED MR ' . $notes,
                ]);
            } elseif ($mr->MR_APStep == 3) {
                $mr->MR_Status = 'REJECT';
                $mr->MR_IsReject = 'Y';
                // $mr->MR_APStep = 1;
                $mr->MR_RejGroup = 'AP3';
                $mr->MR_RejBy = $user->id;
                $mr->MR_RejDate = Carbon::now();
                $mr->MR_RMK3 = $notes;
    
                Notification::create([
                    'Notif_No'      => Notification::generateNotificationNo(),
                    'Notif_Title'   => 'Material Request Rejected',
                    'Reference_No'  => $mr->MR_No,
                    'Notif_Text'    => 'MR ' . $mr->MR_No . ' rejected by ' . $user->Fullname,
                    'Notif_IsRead'  => 'N',
                    'Notif_From'    => $user->id,
                    'Notif_To'      => $mr->MR_AP1,
                    'Notif_Date'    => Carbon::now(),
                    'Notif_Type'    => 'MR',
                ]);
    
                Notification::create([
                    'Notif_No'      => Notification::generateNotificationNo(),
                    'Notif_Title'   => 'Material Request Rejected',
                    'Reference_No'  => $mr->MR_No,
                    'Notif_Text'    => 'MR ' . $mr->MR_No . ' rejected by ' . $user->Fullname,
                    'Notif_IsRead'  => 'N',
                    'Notif_From'    => $user->id,
                    'Notif_To'      => $mr->CR_BY,
                    'Notif_Date'    => Carbon::now(),
                    'Notif_Type'    => 'MR',
                ]);
    
                Logs::create([
                    'Logs_No' => Logs::generateLogsNo(),
                    'LOG_Type'   => 'MR',
                    'LOG_RefNo'  => $mr_no,
                    'LOG_Status' => 'REJECTED 3',
                    'LOG_User'   => $user->id,
                    'LOG_Date'   => Carbon::now(),
                    'LOG_Desc'   => $user->Fullname . ' REJECTED MR ' . $notes,
                ]);
            } elseif ($mr->MR_APStep == 4) {
                $mr->MR_Status = 'REJECT';
                $mr->MR_IsReject = 'Y';
                // $mr->MR_APStep = 1;
                $mr->MR_RejGroup = 'AP4';
                $mr->MR_RejBy = $user->id;
                $mr->MR_RejDate = Carbon::now();
                $mr->MR_RMK4 = $notes;
    
                Notification::create([
                    'Notif_No'      => Notification::generateNotificationNo(),
                    'Notif_Title'   => 'Material Request Rejected',
                    'Reference_No'  => $mr->MR_No,
                    'Notif_Text'    => 'MR ' . $mr->MR_No . ' rejected by ' . $user->Fullname,
                    'Notif_IsRead'  => 'N',
                    'Notif_From'    => $user->id,
                    'Notif_To'      => $mr->MR_AP1,
                    'Notif_Date'    => Carbon::now(),
                    'Notif_Type'    => 'MR',
                ]);
    
                Notification::create([
                    'Notif_No'      => Notification::generateNotificationNo(),
                    'Notif_Title'   => 'Material Request Rejected',
                    'Reference_No'  => $mr->MR_No,
                    'Notif_Text'    => 'MR ' . $mr->MR_No . ' rejected by ' . $user->Fullname,
                    'Notif_IsRead'  => 'N',
                    'Notif_From'    => $user->id,
                    'Notif_To'      => $mr->CR_BY,
                    'Notif_Date'    => Carbon::now(),
                    'Notif_Type'    => 'MR',
                ]);
    
                Logs::create([
                    'Logs_No' => Logs::generateLogsNo(),
                    'LOG_Type'   => 'MR',
                    'LOG_RefNo'  => $mr_no,
                    'LOG_Status' => 'REJECTED 4',
                    'LOG_User'   => $user->id,
                    'LOG_Date'   => Carbon::now(),
                    'LOG_Desc'   => $user->Fullname . ' REJECTED MR ' . $notes,
                ]);
            } else {
                return response()->json(['error' => 'Invalid approval step'], 400);
            }
    
            $mr->save();
    
            return response()->json(['message' => 'Material Request Rejected']);
        }
    }

    


}