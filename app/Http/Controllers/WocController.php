<?php

namespace App\Http\Controllers;

use App\Models\Cases;
use App\Models\Imgs;
use App\Models\Logs;
use App\Models\MatReq;
use App\Models\Matrix;
use App\Models\Notification;
use App\Models\technician;
use App\Models\User;
use App\Models\WorkOrder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Queue\Worker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class WocController extends Controller
{
    
    //Page Create WOC
    public function createWOC(Request $request)
    {
        $technicians = DB::table('technician')->get();
        
        $woNo = $request->input('wo_no');
        $selectedTechnicians = DB::table('WO_DoneBy')
            ->where('WO_No', $woNo)
            ->pluck('technician_id')
            ->toArray();

        return view('content.woc.CreateWOC', compact('technicians', 'selectedTechnicians', 'woNo'));
    }

    // Page List  WOC
    public function ListWOCPage(){
        return view('content.woc.ListWOC');
    }

    // Ambil data Wo_No berdasarkan ketentuan tertentu (PAGE CREATE WOC)
    public function getWorkOrders()
    {
        $userId = Auth::id();

        $workOrders = WorkOrder::where('WO_Status', 'INPROGRESS')
            ->where('WO_IsComplete', 'N')
            ->whereNull('WO_CompDate')
            ->whereNull('WO_IsReject')
            ->where('CR_BY', $userId)   
            ->where(function ($query) { 
                $query->where('WO_NeedMat', 'N')
                    ->orWhereIn('WO_No', function ($subquery) {
                        $subquery->select('WO_No')
                            ->from('Mat_Req')
                            ->whereIn('MR_Status', ['DONE', 'CLOSE','AP4','AP5']); 
                    });
            })
            ->get(['WO_No']);

        return response()->json($workOrders);
    }

    // Ambil Detail Wo berdasarkan WO yang dipilih dan menampilkannya pada field form craete WOC
    public function getWorkOrderDetails($encoded)
    {
        $woNo = urldecode(base64_decode($encoded));

        $workOrder = WorkOrder::where('WO_No', $woNo)
            ->with(['case', 'creator.position'])
            ->first();

        if (!$workOrder) {
            return response()->json(['error' => 'Work Order not found'], 404);
        }

        $allTechnicians = DB::table('technician')
            ->select('technician_id as id', 'technician_Name as fullname')
            ->orderBy('technician_Name', 'asc')
            ->get();

        $assignedTechs = DB::table('WO_DoneBy')
            ->join('technician', 'WO_DoneBy.technician_id', '=', 'technician.technician_id')
            ->where('WO_No', $woNo)
            ->select('technician.technician_id as id', 'technician.technician_Name as fullname')
            ->get();

        return response()->json([
            'Case_No' => $workOrder->Case_No,
            'Case_Name' => $workOrder->case->Case_Name,
            'CR_DT' => $workOrder->CR_DT,
            'WO_Start' => $workOrder->WO_Start,
            'WO_End' => $workOrder->WO_End,
            'WO_Narative' => $workOrder->WO_Narative,
            'Created_By' => $workOrder->creator->Fullname ?? null,
            'Position' => $workOrder->creator->position->PS_Name ?? null,
            'All_Technicians' => $allTechnicians,
            'Assigned_To' => $assignedTechs, 
        ]);
    }

    public function deleteImage(Request $request)
    {
        $image = Imgs::where('IMG_No', $request->img_id)->first();

        if (!$image) {
            return response()->json(['success' => false, 'message' => 'Foto tidak ditemukan.']);
        }

        Log::info('DeleteImage: Menghapus gambar', ['IMG_No' => $request->img_id]);

        $WoNo = str_replace(['/','\\'], '-', $image->IMG_RefNo);
        $directory = "woc_photos/$WoNo";
        $filePath = "$directory/{$image->IMG_Filename}";

        if (Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
            Log::info('DeleteImage: File dihapus', ['filepath' => $filePath]);
        } else {
            Log::warning('DeleteImage: File tidak ditemukan di storage', ['filepath' => $filePath]);
        }

        $image->delete();

        DB::table('Logs')->insert([
            'Logs_No' => Logs::generateLogsNo(),
            'LOG_Type' => 'WO',
            'LOG_RefNo' => $image->IMG_RefNo,
            'LOG_Status' => 'IMAGE_DELETED',
            'LOG_User' => Auth::id(),
            'LOG_Date' => now(),
            'LOG_Desc' => "Image deleted for WOC : {$image->IMG_RefNo}",
        ]);

        return response()->json(['success' => true, 'message' => 'Foto berhasil dihapus.']);
    }

    // Save WOC
    public function saveCompletion(Request $request)
    {
        DB::beginTransaction();
    
        try {
            $decodedWO = urldecode(base64_decode($request->reference_number));
            
            $user = Auth::user(); 
            $wo = WorkOrder::where('WO_No', $decodedWO)->firstOrFail();
    
            $wocNo = (new WorkOrder)->getIncrementWOCNo();
            
            $wo->WOC_No = $wocNo;
            $wo->WO_IsComplete = 'Y';
            // $wo->WO_CompDate = Carbon::now();
            $wo->WO_Compdate = Carbon::createFromFormat('d/m/Y H:i', $request->end_date)->format('Y-m-d H:i:s');
            $wo->WO_Narative = $request->work_description;
            $wo->WO_CompBy = Auth::id(); 
            $wo->save();
    
            DB::commit();

            Logs::create([
                'Logs_No' => Logs::generateLogsNo(),
                'LOG_Type' => 'WO',
                'LOG_RefNo' => $wocNo,
                'LOG_Status' => 'CREATED',
                'LOG_User' => $user->id,
                'LOG_Date' => now(),
                'LOG_Desc' => 'CREATED WORK ORDER COMPLETION',
            ]);

            $uploadedPaths = [];
            if ($request->hasFile('photos')) {
                $WocNo = str_replace(['/','\\'],'-', $wocNo);
                $directory = "woc_photos/$WocNo";
                if (!Storage::disk('public')->exists($directory)) {
                    Storage::disk('public')->makeDirectory($directory, 0755, true);
                }

                foreach ($request->file('photos') as $photo) {
                    $newFileName = "WOC_" . time() . "_" . uniqid() . "." . $photo->getClientOriginalExtension();
                    $path = $photo->storeAs($directory, $newFileName, 'public');
                    $uploadedPaths[] = $path;

                    Imgs::create([
                        'IMG_No' => Imgs::generateImgNo(),
                        'IMG_Type' => 'WO',
                        'IMG_RefNo' => $wocNo,
                        'IMG_Filename' => $newFileName,
                        'IMG_Realname' => $photo->getClientOriginalName(),
                    ]);
                }

                Log::info('Photos uploaded', [
                    'case_no' => $wocNo,
                    'files' => $uploadedPaths
                ]);

                Log::error('Failed to complete Work Order.');

                Logs::create([
                    'Logs_No' => Logs::generateLogsNo(),
                    'LOG_Type' => 'WO',
                    'LOG_RefNo' => $wocNo,
                    'LOG_Status' => 'PHOTOS_UPLOADED',
                    'LOG_User' => Auth::id(),
                    'LOG_Date' => now(),
                    'LOG_Desc' => count($uploadedPaths) . 'photos uploaded for WOC',
                ]);
            }
    
            Log::info('Work Order completed successfully.', [
                'WO_No'   => $wo->WO_No,
                'WOC_No'  => $wocNo,
                'User'    => Auth::user()->username ?? 'Unknown',
                'Time'    => now(),
            ]);
    
            return response()->json([
                'success' => true,
                'message' => 'Work Order Completion saved successfully.',
                'wo_no' => $wo->WO_No 
            ]);
        } catch (\Exception $e) {   
            DB::rollBack();
    
            Log::error('Failed to complete Work Order.', [
                'Reference_No' => $request->reference_number ?? 'N/A',
                'Error'        => $e->getMessage(),
                'User'         => Auth::user()->username ?? 'Unknown',
                'Time'         => now(),
            ]);
    
            return response()->json([
                'success' => false,
                'message' => 'Error completing Work Order.',
            ], 500);
        }
    }

    // Page Edit WOC
    public function EditWOC($wo_no)
    {
        try {
            $decoded_wo_no = base64_decode($wo_no, true); 
        
            if (!$decoded_wo_no) {
                return redirect()->route('CreateWOC')->with('error', 'Invalid Work Order Number.');
            }

            $user = Auth::user();
            $position = optional($user->position)->PS_Name;

            $workOrder = WorkOrder::with([
                'technicians', 
                'createdBy',
            ])->where('WO_No', $decoded_wo_no)->first();

            if (!$workOrder) {
                return redirect()->route('CreateWOC')->with('error', 'Invalid Work Order Number.');
            }

            $wocNo = $workOrder->WOC_No;

            if ($workOrder->WO_Status === 'REJECT_COMPLETION') {
                $workOrder->WO_Status = 'OPEN_COMPLETION';
                $workOrder->save();

                Logs::create([
                    'Logs_No' => Logs::generateLogsNo(),
                    'LOG_Type' => 'WO',
                    'LOG_RefNo' => $wocNo,
                    'LOG_Status' => 'REVISION',
                    'LOG_User' => $user->id,
                    'LOG_Date' => now(),
                    'LOG_Desc' => 'A revision was made to the Work Order Complition data due to the rejection of the previous submission.',
                ]);
            }

            $allTechnicians = technician::all();

            $selectedTechnicians = DB::table('WO_DoneBy')
                ->where('WO_No', $decoded_wo_no)
                ->pluck('technician_id')
                ->toArray();

            $wocImages = Imgs::where('IMG_RefNo', $wocNo)->get();

            return view('content.woc.EditWOC', compact(
                'workOrder',
                
                'allTechnicians',
                'selectedTechnicians',
                'wocImages'
            ));

        } catch (\Exception $e) {
            Log::error("Edit WOC Error: " . $e->getMessage());
            return redirect()->route('CreateWOC')->with('error', 'An unexpected error occurred while editing Work Order.');
        }
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

        Logs::create([
            'Logs_No' => Logs::generateLogsNo(),
            'LOG_Type' => 'WO',
            'LOG_RefNo' => $request->wo_no,
            'LOG_Status' => 'REMOVE TECHNICIAN',
            'LOG_User' => Auth::id(),
            'LOG_Date' => now(),
            'LOG_Desc' => $request->technician_id .' Technician Was Removed',
        ]);

        return response()->json(['status' => 'success']);
    }

    // Controller SAVE DRAFT WOC
    public function SaveDraftWOC(Request $request)
    {
        $user = auth::user();
        $request->validate([
            // 'reference_number' => 'required|string',
            'start_date' => 'required|string',
            'end_date' => 'required|string',
            'work_description' => 'required|string',
        ]);

        try {
        $wo = WorkOrder::where('WOC_No', $request->woc_no)->firstOrFail();

            $startDate = Carbon::createFromFormat('Y-m-d H:i', $request->start_date)->format('Y-m-d H:i:s');
            $endDate = Carbon::createFromFormat('Y-m-d H:i', $request->end_date)->format('Y-m-d H:i:s');

            $wo->WO_Start = $startDate;
            $wo->WO_CompDate = $endDate;
            $wo->WO_Narative = $request->work_description;
            $wo->Update_Date = now();
            $wo->save();

            // Upload dan simpan gambar jika ada
            if ($request->hasFile('new_images')) {
                $WocNo = str_replace(['/','\\'],'-', $request->woc_no);
                $directory = "woc_photos/$WocNo";
                if (!Storage::disk('public')->exists($directory)) {
                    Storage::disk('public')->makeDirectory($directory, 0755, true);
                }

                foreach ($request->file('new_images') as $photo) {
                    $newFileName = "WOC_" . time() . "_" . uniqid() . "." . $photo->getClientOriginalExtension();
                    $path = $photo->storeAs($directory, $newFileName, 'public');
                    $uploadedPaths[] = $path;

                    Imgs::create([
                        'IMG_No' => Imgs::generateImgNo(),
                        'IMG_Type' => 'WO',
                        'IMG_RefNo' => $wo->WOC_No,
                        'IMG_Filename' => $newFileName,
                        'IMG_Realname' => $photo->getClientOriginalName(),
                    ]);
                }

                Log::info('Photos uploaded', [
                    'WOC_No' => $wo->WOC_No,
                    'files' => $uploadedPaths
                ]);

                Log::error('Failed to complete Work Order.');

                Logs::create([
                    'Logs_No' => Logs::generateLogsNo(),
                    'LOG_Type' => 'WO',
                    'LOG_RefNo' => $wo->WOC_No,
                    'LOG_Status' => 'PHOTOS_UPLOADED',
                    'LOG_User' => Auth::id(),
                    'LOG_Date' => now(),
                    'LOG_Desc' => count($uploadedPaths) . ' photos uploaded for WOC No: ' . $wo->WOC_No,
                ]);
            }
            
    
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
    
                        Log::info("Technician {$tech_id} added to WOC {$request->woc_no} by {$user->Fullname}");
                    }
                }
            }

            DB::table('Logs')->insert([
                'Logs_No' => Logs::generateLogsNo(),
                'LOG_Type' => 'WO',
                'LOG_RefNo' => $wo->WOC_No,
                'LOG_Status' => 'DRAFT_SAVED',
                'LOG_User' => Auth::id(),
                'LOG_Date' => now(),
                'LOG_Desc' => 'Successfully Saved Work Order Complition Draft.',
            ]);

            return response()->json(['success' => true, 'message' => 'Work Order Complition Draft Saved Successfully.']);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }

    // Update WOC
    public function UpdateWOC(Request $request)
    {
        $user = Auth::user();   
    
        try {
            // Validasi data
            // $request->validate([
            //     // 'reference_number' => 'required|string',
            //     'start_date' => 'required|date',
            //     'end_date' => 'required|date|after_or_equal:start_date',
            //     'work_description' => 'required|string',
            //     'assigned_to' => 'nullable|array',
            // ]);

            Log::info('Submitted WOC Data:', $request->all());

            $wo = WorkOrder::where('WO_No', $request->reference_number)->first();
            if (!$wo) {
                Log::error("Work Order with number {$request->reference_number} not found by user ID: {$user->id}");

                return response()->json([
                    'success' => false,
                    'message' => 'Work Order not found.'
                ], 404);
            }
            // Matriks Approval
            // $matrix = collect([
            //     ['Mat_No' => 1, 'Position' => 1, 'Mat_Type' => 'CR', 'Mat_Max' => 2 ,'AP1' => 11, 'AP2' => 15],
            //     ['Mat_No' => 2, 'Position' => 2, 'Mat_Type' => 'CR', 'Mat_Max' => 2 ,'AP1' => 12, 'AP2' => 15],
            //     ['Mat_No' => 3, 'Position' => 3, 'Mat_Type' => 'CR', 'Mat_Max' => 2 ,'AP1' => 13, 'AP2' => 15],
            //     ['Mat_No' => 4, 'Position' => 4, 'Mat_Type' => 'CR', 'Mat_Max' => 2 ,'AP1' => 1,  'AP2' => 11],
            //     ['Mat_No' => 5, 'Position' => 5, 'Mat_Type' => 'CR', 'Mat_Max' => 2 ,'AP1' => 1,  'AP2' => 11],
            //     ['Mat_No' => 6, 'Position' => 6, 'Mat_Type' => 'CR', 'Mat_Max' => 2 ,'AP1' => 1,  'AP2' => 11],
            //     ['Mat_No' => 7, 'Position' => 7, 'Mat_Type' => 'CR', 'Mat_Max' => 2 ,'AP1' => 1,  'AP2' => 11],
            //     ['Mat_No' => 8, 'Position' => 8, 'Mat_Type' => 'CR', 'Mat_Max' => 2 ,'AP1' => 14, 'AP2' => 15],
            //     ['Mat_No' => 13, 'Position' => 14, 'Mat_Type' => 'CR', 'Mat_Max' => 2 ,'AP1' => 18, 'AP2' => 18],
            // ]);

            $userPosition = Auth::user()->Position->id;
            // $matrixRow = $matrix->firstWhere('Position', $userPosition);

            $matrixRow = Matrix::where('Mat_Type', 'CR')
                ->where('Position', $userPosition)
                ->first(); 
                
            // if ($matrixRow) {
            //     $wo->WO_AP1 = $matrixRow['AP1'] ?? null;
            //     $wo->WO_AP2 = $matrixRow['AP2'] ?? null;

            //     $wo->WO_APStep = 1;
            //     $wo->WO_APMaxStep = $matrixRow['Mat_Max'];
            // }

            if ($matrixRow) {
                $wo->WO_AP1 = $matrixRow->AP1 ?? null;
                $wo->WO_AP2 = $matrixRow->AP2 ?? null;
        
                $wo->WO_APStep = 1;
                $wo->WO_APMaxStep = $matrixRow->Mat_Max;
            }


            $wo->WO_Start = $request->start_date;
            $wo->WO_Compdate = Carbon::createFromFormat('Y-m-d H:i', $request->end_date)->format('Y-m-d H:i:s');
            $wo->WO_Narative = $request->work_description;
            $wo->WO_Status = 'SUBMIT_COMPLETION'; 

            if ($wo->WO_IsReject === 'Y') {
                $wo->WO_IsReject = 'N';
                $wo->WO_RejGroup = null;
                $wo->WO_RejBy = null;
                $wo->WO_RejDate = null;
                $wo->WO_RMK1 = null;
                $wo->WO_RMK2 = null;

                Log::info('UpdateCase: Reset status REJECT karena user melakukan revisi', [
                    'wo_no' => $wo->WOC_No
                ]);

                DB::table('Logs')->insert([
                    'Logs_No' => Logs::generateLogsNo(),
                    'LOG_Type' => 'BA',
                    'LOG_RefNo' => $wo->WOC_No,
                    'LOG_Status' => 'REVISION',
                    'LOG_User' => Auth::id(),
                    'LOG_Date' => now(),
                    'LOG_Desc' => 'WOC status and reject fields reset due to revision.',
                ]);   
            }

            $wo->save();
    
            Logs::create([
                'LOG_Type' => 'WO',
                'LOG_RefNo' => $wo->WOC_No,
                'LOG_Status' => 'SUBMITTED',
                'LOG_User' => $user->id,
                'LOG_Date' => now(),
                'LOG_Desc' => 'SUCCESSFULLY SUBMITTED A WORK ORDER COMPLITION.',
            ]);

            Notification::create([
                'Notif_Title'   => 'Work Order Completion Request Approval',
                'Reference_No'  => $wo->WO_No,
                'Notif_Text'    => 'A Work Order Completion has been submitted and requires your approval.',
                'Notif_IsRead'  => 'N',
                'Notif_From'    => $user->id,
                'Notif_To'      => $wo->WO_AP1,
                'Notif_Date'    => Carbon::now(),
                'Notif_Type'    => 'WO',
            ]);

               // Tambahan: Update status MR ke DONE
            $relatedMRs = MatReq::where('WO_No', $wo->WO_No)
                ->where('MR_Status', 'AP4')
                ->get();

            if ($relatedMRs->count() > 0) {
                foreach ($relatedMRs as $mr) {
                    $mr->MR_Status = 'DONE';
                    $mr->Update_Date = now();
                    $mr->save();

                    Logs::create([
                        'LOG_Type'   => 'MR',
                        'LOG_RefNo'  => $mr->MR_No,
                        'LOG_Status' => 'DONE',
                        'LOG_User'   => $user->id,
                        'LOG_Date'   => now(),
                        'LOG_Desc'   => 'MR status updated to DONE automatically after WO completion.',
                    ]);
                }
            } else {
                Log::warning('MR not updated to DONE. Either no MR found for this WO or status is not AP4.', [
                    'WO_No' => $wo->WO_No
                ]);
            }


            return response()->json([
                'success' => true,
                'message' => 'Work Order successfully updated!'
            ]);
    
        } catch (\Exception $e) {
            Log::error('Failed to update Work Order. Error: ' . $e->getMessage());
    
            Logs::create([
                'LOG_Type' => 'WO',
                'LOG_RefNo' => $wo->WOC_No,
                'LOG_Status' => 'FAILED',
                'LOG_User' => $user->id,
                'LOG_Date' => now(),
                'LOG_Desc' => Str::limit('FAILED TO SUBMITTED WORK ORDER COMPLITION. Error: ' . $e->getMessage(), 225),
            ]);
    
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }


// Page List WOC
    // Ambil Data WOC untuk ditampilkan pada table list WOC
    
    // public function getSubmittedData()
    // {
    //     $userId = Auth::id(); // Ambil ID user yang sedang login
    //     $user = Auth::user(); // Ambil user login
    //     $hasViewCr = $user->hasPermissionTo('view cr');
    //     $hasViewCrAp = $user->hasPermissionTo('view cr_ap');
    //     Log::info("User: " . $user->Fullname);
    //     Log::info("Can view cr: " . json_encode($hasViewCr));
    //     Log::info("Can view cr_ap: " . json_encode($hasViewCrAp));

    //     // Query dasar: hanya WO yang sudah complete
    //     $query = WorkOrder::with([
    //         'case',
    //         'createdBy.position',
    //     ])->where('WO_IsComplete', 'Y');

    //     // Filter berdasarkan permission
    //     $query->where(function ($q) use ($userId, $hasViewCr, $hasViewCrAp) {
    //         if ($hasViewCr) {
    //             $q->orWhere('CR_BY', $userId);
    //         }

    //         if ($hasViewCrAp) {
    //             $q->orWhere('WO_AP1', $userId)
    //             ->orWhere('WO_AP2', $userId);
    //         }
    //     });

    //     $data = $query->get();

    //     return response()->json(['data' => $data]);
    // }

    public function getSubmittedData()
    {
        $userId = Auth::id();
        $user = Auth::user();
        $userPosition = $user->position?->PS_Name ?? null;

        $hasViewCr = $user->hasPermissionTo('view cr');
        $hasViewCrAp = $user->hasPermissionTo('view cr_ap');

        Log::info("User: " . $user->Fullname);
        Log::info("User Position: " . $userPosition);
        Log::info("Can view cr: " . json_encode($hasViewCr));
        Log::info("Can view cr_ap: " . json_encode($hasViewCrAp));

        // Jika user adalah Creator, langsung ambil semua WOC
        if ($userPosition === 'Creator') {
            $data = WorkOrder::with(['case', 'createdBy.position'])
                ->where('WO_IsComplete', 'Y')
                ->get();

            return response()->json(['data' => $data]);
        }

        // Query default untuk user selain Creator
        $query = WorkOrder::with(['case', 'createdBy.position'])
            ->where('WO_IsComplete', 'Y');

        if ($hasViewCr || $hasViewCrAp) {
            $query->where(function ($q) use ($userId, $hasViewCr, $hasViewCrAp) {
                if ($hasViewCr) {
                    $q->orWhere('CR_BY', $userId);
                }

                if ($hasViewCrAp) {
                    $q->orWhere('WO_AP1', $userId)
                    ->orWhere('WO_AP2', $userId);
                }
            });
        } else {
            // Tidak punya hak akses apapun
            return response()->json(['data' => []]);
        }

        $data = $query->get();

        return response()->json(['data' => $data]);
    }


    // Page Detail WOC
    public function showDetailWOC($encodedWONo)
    {
        $wo_no = base64_decode($encodedWONo); 

        if (!$wo_no) {
            return redirect()->back()->with('error', 'Work Order not found.');
        }

        $workOrder = DB::table('Work_Orders')
        ->select(
            'Work_Orders.*',
            'cr.Fullname as Creator_Name',
            'mr.Fullname as MR_Requestor',
            'ap1.Fullname as Approver1',
            'ap2.Fullname as Approver2',
            'ap3.Fullname as Approver3',
            'ap4.Fullname as Approver4',
            'ap5.Fullname as Approver5'
        )
        ->leftJoin('users as cr', 'Work_Orders.CR_BY', '=', 'cr.id')
        ->leftJoin('users as mr', 'Work_Orders.WO_MR', '=', 'mr.id')
        ->leftJoin('users as ap1', 'Work_Orders.WO_AP1', '=', 'ap1.id')
        ->leftJoin('users as ap2', 'Work_Orders.WO_AP2', '=', 'ap2.id')
        ->leftJoin('users as ap3', 'Work_Orders.WO_AP3', '=', 'ap3.id')
        ->leftJoin('users as ap4', 'Work_Orders.WO_AP4', '=', 'ap4.id')
        ->leftJoin('users as ap5', 'Work_Orders.WO_AP5', '=', 'ap5.id')
        ->where('Work_Orders.WO_No', $wo_no)
        ->first();

        if (!$workOrder) {
            return redirect()->back()->with('error', 'Work Order not found.');
        }

        $approvers = [];

        for ($i = 1; $i <= $workOrder->WO_APMaxStep; $i++) {
            $approverId = $workOrder->{'WO_AP' . $i} ?? null;

            if ($approverId) {
                $user = User::find($approverId);
                $approvers[$i] = $user ? $user->Fullname : 'Unknown User';
            } else {
                $approvers[$i] = 'Unknown User';
            }
        }

        $wocNo = $workOrder->WOC_No;
        
        $logs = DB::table('Logs')
            ->join('users', 'Logs.LOG_User', '=', 'users.id')
            ->select('Logs.*', 'users.Fullname as user_name')
            ->where('LOG_Type', 'WO') 
            ->where('LOG_RefNo', $wocNo)
            ->orderBy('LOG_Date', 'asc')
            ->get();

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

        $wocImages = Imgs::where('IMG_RefNo', $wocNo)->get();


        return view('content.woc.DetailWOC', compact('workOrder','logs','wocImages','approvalLogs','approvers'));
    }
// End List WOC
    



// Page Approval WOC
    // Page List WOC Approval
    public function ApprovalListWOC(Request $request){
        return view('content.woc.ListApprovalWOC');
    }

    // Ambil data WO Yang akan di gunakan untuk approval dan tampilkan didalam table
    public function getApprovalWOC(Request $request)
    {
        
        $userId = Auth::id();
         $data = WorkOrder::with([
            'case',        
            'createdBy.position',   
           
        ])
        ->where('WO_IsComplete', 'Y')
        ->whereNotNull('WO_CompDate')
        ->whereNotNull('WO_CompBy')
        ->where(function($q) use ($userId) {
                $q->where(function($sub) use ($userId) {
                    $sub->where('WO_APStep', 1)
                        ->where('WO_Status', 'SUBMIT_COMPLETION')
                        ->where('WO_AP1', $userId);
                })
                ->orWhere(function($sub) use ($userId) {
                    $sub->where('WO_APStep', 2)
                        ->where('WO_Status', 'AP1')
                        ->where('WO_AP2', $userId);
                })
                ->orWhere(function($sub) use ($userId) {
                    $sub->where('WO_APStep', 3)
                        ->where('WO_Status', 'AP2')
                        ->where('WO_AP3', $userId);
                })
                ->orWhere(function($sub) use ($userId) {
                    $sub->where('WO_APStep', 4)
                        ->where('WO_Status', 'AP3')
                        ->where('WO_AP4', $userId);
                })
                ->orWhere(function($sub) use ($userId) {
                    $sub->where('WO_APStep', 5)
                        ->where('WO_Status', 'AP4')
                        ->where('WO_AP5', $userId);
                });
            })
            ->get();
    
        
        return response()->json(['data' => $data]);
    }

    // Detail WOC Untuk Approval WOC
    public function DetailApprovalWOC($encodedWO)
    {
        $WO_No = base64_decode($encodedWO);

        $workOrder = DB::table('Work_Orders as wo')
        ->leftJoin('cases as c', 'wo.Case_No', '=', 'c.Case_No')
        ->leftJoin('users as u', 'wo.CR_BY', '=', 'u.id')
        ->leftJoin('users as comp', 'wo.WO_CompBy', '=', 'comp.id')
        ->leftJoin('users as mr', 'wo.WO_MR', '=', 'mr.id')
        ->leftJoin('users as ap1', 'wo.WO_AP1', '=', 'ap1.id')
        ->leftJoin('users as ap2', 'wo.WO_AP2', '=', 'ap2.id')
        ->select(
            'wo.*',
            'c.Case_Name',
            'u.Fullname as Created_By',
            'comp.Fullname as Completed_By',
            'mr.Fullname as Requested_Material_By',
            'ap1.Fullname as Approver1',
            'ap2.Fullname as Approver2'
        )
        ->where('wo.WO_No', $WO_No)
        ->first();

        $technicians = DB::table('WO_DoneBy as wd')
            ->join('technician as t', 'wd.technician_id', '=', 't.technician_id')
            ->where('wd.WO_No', $WO_No)
            ->select('t.*')
            ->get();

        $matReqs = DB::table('Mat_Req as mr')
            ->where('mr.WO_No', $WO_No)
            ->get();

        $matReqChildren = DB::table('Mat_Req_Child as mrc')
            ->whereIn('mrc.MR_No', $matReqs->pluck('MR_No'))
            ->get()
            ->groupBy('MR_No');

        $wocNo = $workOrder->WOC_No;
       
        $logs = DB::table('Logs')
            ->join('users', 'Logs.LOG_User', '=', 'users.id')
            ->select('Logs.*', 'users.Fullname as user_name')
            ->where('LOG_Type', 'WO') 
            ->where('LOG_RefNo', $wocNo)
            ->orderBy('LOG_Date', 'desc')
            ->get();  
            
        // Ambil waktu terakhir REVISION atau SUBMITTED
        $lastCycleLog = DB::table('Logs')
            ->where('LOG_Type', 'WO')
            ->where('LOG_RefNo', $wocNo)
            ->whereIn('LOG_Status', ['REVISION', 'SUBMITTED'])
            ->orderBy('LOG_Date', 'desc')
            ->first();

        $cycleStartDate = $lastCycleLog ? $lastCycleLog->LOG_Date : null;

        // Ambil semua log setelah tanggal REVISION atau SUBMITTED terakhir
        $logs = DB::table('Logs')
            ->join('users', 'Logs.LOG_User', '=', 'users.id')
            ->select('Logs.*', 'users.Fullname as user_name')
            ->where('LOG_Type', 'WO')
            ->where('LOG_RefNo', $wocNo)
            ->when($cycleStartDate, function ($query, $cycleStartDate) {
                return $query->where('LOG_Date', '>=', $cycleStartDate);
            })
            ->orderBy('LOG_Date', 'desc')
            ->get();

        $wocImages = Imgs::where('IMG_RefNo', $wocNo)->get();

        return view('content.woc.DetailApprovalWOC', compact('workOrder', 'technicians', 'matReqs', 'matReqChildren','logs','wocImages'));
    }

    // Approval/Reject
    public function approveReject(Request $request, $wo_no)
    {
        try {
            Log::info('Request received for WO approval/rejection', $request->all());

            $decoded_wo_no = base64_decode($wo_no);
            $wo = WorkOrder::where('WO_No', $decoded_wo_no)->firstOrFail();

            $user = Auth::user();
            $notes = $request->input('approvalNotes');
            $action = $request->input('action');

            if ($action === 'approve') {
                if ($wo->WO_APStep == 1) {
                    $wo->WO_Status = 'AP1';
                    $wo->WO_RMK1 = $notes;
                    $wo->WO_APStep = 2;

                    Logs::create([
                        'Logs_No'    => Logs::generateLogsNo(),
                        'LOG_Type'   => 'WO',
                        'LOG_RefNo'  => $wo->WOC_No,
                        'LOG_Status' => 'APPROVED 1',
                        'LOG_User'   => $user->id,
                        'LOG_Date'   => Carbon::now(),
                        'LOG_Desc'   => $user->Fullname . ' APPROVED WOC',
                    ]);

                    Notification::create([
                        'Notif_No'      => Notification::generateNotificationNo(),
                        'Notif_Title'   => 'Work Order Complition Approved',
                        'Reference_No'  => $wo->WO_No,
                        'Notif_Text'    => 'WOC ' . $wo->WOC_No . ' approved by ' . $user->Fullname,
                        'Notif_IsRead'  => 'N',
                        'Notif_From'    => $user->id,
                        'Notif_To'      => $wo->WO_AP2,
                        'Notif_Date'    => Carbon::now(),
                        'Notif_Type'    => 'WO',
                    ]);
                } elseif ($wo->WO_APStep == 2) {
                    $wo->WO_Status = 'DONE';
                    $wo->WO_RMK2 = $notes;

                    // Update Case Status
                    Cases::where('Case_No', $wo->Case_No)->update([
                        'Case_Status' => 'DONE'
                    ]);

                    Logs::create([
                        'Logs_No'    => Logs::generateLogsNo(),
                        'LOG_Type'   => 'WO',
                        'LOG_RefNo'  => $wo->WOC_No,
                        'LOG_Status' => 'APPROVED 2',
                        'LOG_User'   => $user->id,
                        'LOG_Date'   => Carbon::now(),
                        'LOG_Desc'   => $user->Fullname . ' APPROVED WOC',
                    ]);
                    
                    // LOGS UPDATE WOC STATUS
                    Logs::create([
                        'Logs_No'    => Logs::generateLogsNo(),
                        'LOG_Type'   => 'WO',
                        'LOG_RefNo'  => $wo->WOC_No,
                        'LOG_Status' => 'DONE',
                        'LOG_User'   => $user->id,
                        'LOG_Date'   => Carbon::now(),
                        'LOG_Desc'   => 'Work Order Complition completed successfully',
                    ]);

                    // logs update CASE STATUS
                    Logs::create([
                        'Logs_No' => Logs::generateLogsNo(),
                        'LOG_Type'   => 'BA',
                        'LOG_RefNo'  => $wo->Case_No,
                        'LOG_Status' => 'DONE',
                        'LOG_User'   => $user->id,
                        'LOG_Date'   => Carbon::now(),
                        'LOG_Desc'   => 'Case completed successfully',
                    ]);

                    // LOGS UPDATE WO STATUS
                    Logs::create([
                        'Logs_No'    => Logs::generateLogsNo(),
                        'LOG_Type'   => 'WO',
                        'LOG_RefNo'  => $wo->WO_No,
                        'LOG_Status' => 'DONE',
                        'LOG_User'   => $user->id,
                        'LOG_Date'   => Carbon::now(),
                        'LOG_Desc'   => 'Work Order completed successfully',
                    ]);

                    Logs::create([
                        'Logs_No'    => Logs::generateLogsNo(),
                        'LOG_Type'   => 'WO',
                        'LOG_RefNo'  => $wo->WOC_No,
                        'LOG_Status' => 'DONE',
                        'LOG_User'   => $user->id,
                        'LOG_Date'   => Carbon::now(),
                        'LOG_Desc'   => 'Work Order completed successfully',
                    ]);

                    Notification::create([
                        'Notif_No'      => Notification::generateNotificationNo(),
                        'Notif_Title'   => 'Work Order Complition Approved',
                        'Reference_No'  => $wo->WO_No,
                        'Notif_Text'    => 'WOC ' . $wo->WOC_No . ' approved by ' . $user->Fullname,
                        'Notif_IsRead'  => 'N',
                        'Notif_From'    => $user->id,
                        'Notif_To'      => $wo->CR_BY,
                        'Notif_Date'    => Carbon::now(),
                        'Notif_Type'    => 'WO',
                    ]);
                }
                
                $wo->save();
                return response()->json(['message' => 'Work Order Complition Approved Successfully']);
            }
            
            // === HANDLE REJECT ===
            if ($wo->WO_APStep == 1) {
                $wo->WO_Status = 'REJECT_COMPLETION';
                $wo->WO_IsReject = 'Y';
                $wo->WO_RejGroup = 'AP1';
                $wo->WO_RejBy = $user->id;
                $wo->WO_RejDate = Carbon::now();
                $wo->WO_RMK1 = $notes;

                Logs::create([
                    'Logs_No'    => Logs::generateLogsNo(),
                    'LOG_Type'   => 'WO',
                    'LOG_RefNo'  => $wo->WOC_No,
                    'LOG_Status' => 'REJECTED 1',
                    'LOG_User'   => $user->id,
                    'LOG_Date'   => Carbon::now(),
                    'LOG_Desc'   => $user->Fullname . ' REJECTED WOC: ' . $notes,
                ]);

                Notification::create([
                    'Notif_No'      => Notification::generateNotificationNo(),
                    'Notif_Title'   => 'Work Order Rejected',
                    'Reference_No'  => $wo->WO_No,
                    'Notif_Text'    => 'WOC ' . $wo->WOC_No . ' rejected by ' . $user->Fullname,
                    'Notif_IsRead'  => 'N',
                    'Notif_From'    => $user->id,
                    'Notif_To'      => $wo->CR_BY,
                    'Notif_Date'    => Carbon::now(),
                    'Notif_Type'    => 'WO',
                ]);
            } elseif ($wo->WO_APStep == 2) {
                $wo->WO_Status = 'REJECT_COMPLETION';
                $wo->WO_IsReject = 'Y';
                $wo->WO_RejGroup = 'AP2';
                $wo->WO_RejBy = $user->id;
                $wo->WO_RejDate = Carbon::now();
                $wo->WO_RMK2 = $notes;

                Logs::create([
                    'Logs_No'    => Logs::generateLogsNo(),
                    'LOG_Type'   => 'WO',
                    'LOG_RefNo'  => $wo->WOC_No,
                    'LOG_Status' => 'REJECTED 2',
                    'LOG_User'   => $user->id,
                    'LOG_Date'   => Carbon::now(),
                    'LOG_Desc'   => $user->Fullname . ' REJECTED WOC: ' . $notes,
                ]);

                Notification::create([
                    'Notif_No'      => Notification::generateNotificationNo(),
                    'Notif_Title'   => 'Work Order Rejected',
                    'Reference_No'  => $wo->WO_No,
                    'Notif_Text'    => 'WOC ' . $wo->WOC_No . ' rejected by ' . $user->Fullname,
                    'Notif_IsRead'  => 'N',
                    'Notif_From'    => $user->id,
                    'Notif_To'      => $wo->CR_BY,
                    'Notif_Date'    => Carbon::now(),
                    'Notif_Type'    => 'WO',
                ]);
            }

            $wo->save();
            return response()->json(['message' => 'Work Order Complition Rejected']);
        } catch (\Exception $e) {
            Log::error('WOC Approval/Reject Error: ' . $e->getMessage(), [
                'stack' => $e->getTraceAsString()
            ]);
            return response()->json([
                'message' => 'An unexpected error occurred. Please check the logs.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
// END
}
