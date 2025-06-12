<?php

namespace App\Http\Controllers;

use App\Models\Cases;
use App\Models\Cats;
use App\Models\Imgs;
use App\Models\Logs;
use App\Models\Matrix;
use App\Models\Notification;
use App\Models\Subcats;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;


class CaseController extends Controller
{
    //View Page Crate Case
    public function CreateCase(){   
        $listCategory = Cats::all();
        $listSubCategory = Subcats::all();

        return view('content.case.createcase', compact('listCategory', 'listSubCategory'));
    }

    // mengambil subkategori berdasarkan Cat_No
    public function getSubCategories($cat_no)
    {
        $subCategories = Subcats::where('Cat_No', $cat_no)->get();

        return response()->json($subCategories);
    }

    // Validasi Data Create Cases
    public function validateCase(Request $request)
    {
        Log::info('Validating case data', ['request_data' => $request->all()]);

        $validator = Validator::make($request->all(), [
            'cases' => 'required|string|max:255',
            'date' => 'required|date',
            'category' => 'required|string|max:30',
            'sub_category' => 'required|string|max:30',
            'chronology' => 'required|string|max:255',
            'impact' => 'required|string|max:255',
            'suggestion' => 'required|string|max:255',
            'action' => 'required|string|max:255',
            'photos' => 'required|array|max:5', 
            'photos.*' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            Log::warning('Validation failed', ['errors' => $validator->errors()]);
            return response()->json(['errors' => $validator->errors()], 422);
        }

        Log::info('Validation successful');
        return response()->json(['success' => true]);
    }

    // Save Case
    public function SaveCase(Request $request)
    {
        $userId = Auth::id();
        Log::info('SaveCase triggered', ['user_id' => $userId]);

        $validated = $request->validate([
            'cases' => 'required|string|max:255',
            'date' => 'required|string',
            'category' => 'required|string|max:30',
            'sub_category' => 'required|string|max:30',
            'chronology' => 'required|string|max:255',
            'impact' => 'required|string|max:255',
            'suggestion' => 'required|string|max:255',
            'action' => 'required|string|max:255',
            'photos' => 'required|array|max:5',
            'photos.*' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $caseModel = new Cases();
        $caseNo = $caseModel->getIncrementCaseNo();
        $formattedDate = Carbon::createFromFormat('d/m/Y H:i', $validated['date'])->format('Y-m-d H:i:s');

        try {
            // Save main case
            $caseModel = Cases::create([
                'Case_No' => $caseNo,
                'Case_Name' => $validated['cases'],
                'Case_Date' => $formattedDate,
                'CR_BY' => $userId,
                'CR_DT' => now(),
                'Cat_No' => $validated['category'],
                'Scat_No' => $validated['sub_category'],
                'Case_Chronology' => $validated['chronology'],
                'Case_Outcome' => $validated['impact'],
                'Case_Suggest' => $validated['suggestion'],
                'Case_Action' => $validated['action'],
                'Case_Status' => 'OPEN',
                'Case_IsReject' => 'N',
                'Case_ApStep' => 0,
                'Case_ApMaxStep' => 2,
                'Case_Loc_Floor' => 0,
                'Case_Loc_Room' => '',
                'Case_Loc_Object' => '',
                'Update_Date' => now(),
            ]);

            // Upload photos
            $uploadedCount = 0;
            $sanitizedNo = str_replace(['/', '\\'], '-', $caseNo);
            $directory = "case_photos/$sanitizedNo";
            Storage::disk('public')->makeDirectory($directory, 0755, true);

            foreach ($request->file('photos') as $photo) {
                $fileName = 'case_' . time() . '_' . uniqid() . '.' . $photo->getClientOriginalExtension();
                $photo->storeAs($directory, $fileName, 'public');

                Imgs::create([
                    'IMG_No' => Imgs::generateImgNo(),
                    'IMG_Type' => 'BA',
                    'IMG_RefNo' => $caseNo,
                    'IMG_Filename' => $fileName,
                    'IMG_Realname' => $photo->getClientOriginalName(),
                ]);

                $uploadedCount++;
            }
            
            $userName = Auth::user()->Fullname;

            // Log photo upload
            Logs::create([
                'Logs_No' => Logs::generateLogsNo(),
                'LOG_Type' => 'BA',
                'LOG_RefNo' => $caseNo,
                'LOG_Status' => 'PHOTOS_UPLOADED',
                'LOG_User' => $userId,
                'LOG_Date' => now(),
                'LOG_Desc' => "$userName UPLOADED $uploadedCount IMAGES",
            ]);

            // Log creation
            Logs::create([
                'Logs_No' => Logs::generateLogsNo(),
                'LOG_Type' => 'BA',
                'LOG_RefNo' => $caseNo,
                'LOG_Status' => 'CREATED',
                'LOG_User' => $userId,
                'LOG_Date' => now(),
                'LOG_Desc' => "$userName CREATED NEW CASE",
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Your Case has been successfully created.',
                'case_no' => $caseNo,
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to save case', ['msg' => $e->getMessage()]);

            Logs::create([
                'Logs_No' => Logs::generateLogsNo(),
                'LOG_Type' => 'BA',
                'LOG_RefNo' => $caseNo ?? 'UNKNOWN',
                'LOG_Status' => 'FAILED',
                'LOG_User' => $userId,
                'LOG_Date' => now(),
                'LOG_Desc' => Str::limit('FAILED TO CREATE CASE. ERROR: ' . $e->getMessage(), 255),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'FAILED TO CREATE CASE.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // Page Edit Case
    public function EditCase($encoded_case_no)
    {
        $caseNo = base64_decode($encoded_case_no);

        $userId = Auth::id();

        $case = Cases::where('Case_No', $caseNo)->firstOrFail();

        if ($case->Case_Status === 'REJECT') {
            $case->update(['Case_Status' => 'OPEN']);

            Logs::create([
                'Logs_No' => Logs::generateLogsNo(),
                'LOG_Type' => 'BA',
                'LOG_RefNo' => $caseNo,
                'LOG_Status' => 'REVISION',
                'LOG_User' => $userId,
                'LOG_Date' => now(),
                'LOG_Desc' => 'A revision was made to the case data due to the rejection of the previous submission.',
            ]);
        }

        $categories = Cats::all();
        $subCategories = Subcats::where('Cat_No', $case->Cat_No)->get();
        $caseImages = Imgs::where('IMG_RefNo', $caseNo)->get();

        return view('content.case.EditCase', compact('case', 'categories', 'subCategories', 'caseImages'));
    }
    
    // Delete Image
    public function deleteImage(Request $request)
    {
        $image = Imgs::where('IMG_No', $request->img_id)->first();

        if (!$image) {
            return response()->json(['success' => false, 'message' => 'Foto tidak ditemukan.']);
        }

        Log::info('DeleteImage: Menghapus gambar', ['IMG_No' => $request->img_id]);

        $caseNo = str_replace(['/','\\'], '-', $image->IMG_RefNo);
        $directory = "case_photos/$caseNo";
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
            'LOG_Type' => 'BA',
            'LOG_RefNo' => $image->IMG_RefNo,
            'LOG_Status' => 'IMAGE_DELETED',
            'LOG_User' => Auth::id(),
            'LOG_Date' => now(),
            'LOG_Desc' => "Image deleted for case {$image->IMG_RefNo}",
        ]);

        return response()->json(['success' => true, 'message' => 'Foto berhasil dihapus.']);
    }

    // Save Draft Case
    public function SaveDraftCase(Request $request)
    {
        $request->validate([
            'case_no' => 'required|string|exists:cases,Case_No',
            'cases' => 'required|string|max:255',
            'date' => 'required|string',
            'category' => 'required|string|exists:Cats,Cat_No',
            'sub_category' => 'required|string|exists:Subcats,Scat_No',
            'chronology' => 'required|string|max:255',
            'impact' => 'required|string|max:255',
            'suggestion' => 'required|string|max:255',
            'action' => 'required|string|max:255',
        ]);

        try {
            $case = Cases::where('Case_No', $request->case_no)->first();

            if (!$case) {
                return response()->json(['success' => false, 'message' => 'Case not found.']);
            }

            $case->Case_Name = $request->cases;
            $case->Case_Date = Carbon::parse($request->date)->format('Y-m-d');
            $case->Cat_No = $request->category;
            $case->Scat_No = $request->sub_category;
            $case->Case_Chronology = $request->chronology;
            $case->Case_Outcome = $request->impact;
            $case->Case_Suggest = $request->suggestion;
            $case->Case_Action = $request->action;
            $case->Case_Status = 'OPEN';
            $case->Update_Date = now();
            $case->save();

            // Upload dan simpan gambar jika ada
            if ($request->hasFile('new_images')) {
                foreach ($request->file('new_images') as $image) {
                    Log::info('Uploading image: '.$image->getClientOriginalName());

                    $caseNo = str_replace(['/','\\'], '-', $case->Case_No);
                    $directory = "case_photos/$caseNo";

                    if (!Storage::disk('public')->exists($directory)) {
                        Storage::disk('public')->makeDirectory($directory, 0755, true);
                    }

                    $newFilename = "case_" . time() . "_" . uniqid() . "." . $image->getClientOriginalExtension();
                    $path = $image->storeAs($directory, $newFilename, 'public');

                    // Simpan ke tabel imgs
                    Imgs::create([
                        'IMG_No' => Imgs::generateImgNo(),
                        'IMG_RefNo' => $case->Case_No,
                        'IMG_Filename' => $newFilename,
                        'IMG_Realname' => $image->getClientOriginalName(),
                    ]);

                    // Simpan log upload gambar
                    DB::table('Logs')->insert([
                        'Logs_No' => Logs::generateLogsNo(),
                        'LOG_Type' => 'BA',
                        'LOG_RefNo' => $case->Case_No,
                        'LOG_Status' => 'IMAGE_ADDED',
                        'LOG_User' => Auth::id(),
                        'LOG_Date' => now(),
                        'LOG_Desc' => "New image has been uploaded.",
                    ]);
                }
            }

            // Simpan log draft
            DB::table('Logs')->insert([
                'Logs_No' => Logs::generateLogsNo(),
                'LOG_Type' => 'BA',
                'LOG_RefNo' => $case->Case_No,
                'LOG_Status' => 'DRAFT_SAVED',
                'LOG_User' => Auth::id(),
                'LOG_Date' => now(),
                'LOG_Desc' => 'Case has been successfully saved as a draft.',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Your case has been successfully saved as a draft.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    // Update Case
    public function UpdateCase(Request $request)
    {
        Log::debug('Tanggal yang dikirim:', ['date' => $request->CR_DT]);

        $request->validate([
            'case_no' => 'required|string|exists:cases,Case_No',
            'cases' => 'required|string|max:255',
            'date' => 'required|string',
            'category' => 'required|string|exists:Cats,Cat_No',
            'sub_category' => 'required|string|exists:Subcats,Scat_No',
            'chronology' => 'required|string|max:255',
            'impact' => 'required|string|max:255',
            'suggestion' => 'required|string|max:255',
            'action' => 'required|string|max:255',
            'new_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);

        try {
            
            Log::info('UpdateCase: Memulai proses update case', ['case_no' => $request->case_no]);

            $case = Cases::where('Case_No', $request->case_no)->first();
            
            if (!$case) {
                Log::warning('UpdateCase: Case tidak ditemukan', ['case_no' => $request->case_no]);
                return $request->ajax()
                    ? response()->json(['success' => false, 'message' => 'Case tidak ditemukan.'])
                    : redirect()->back()->with('error', 'Case tidak ditemukan.');
            }

            // $formattedDate = \Carbon\Carbon::parse($request->date)->format('Y-m-d');

            // $case->Case_Name = $request->cases;
            // $case->Case_Date = $formattedDate;
            // $case->Cat_No = $request->category;
            // $case->Scat_No = $request->sub_category;
            // $case->Case_Chronology = $request->chronology;
            // $case->Case_Outcome = $request->impact;
            // $case->Case_Suggest = $request->suggestion;
            // $case->Case_Action = $request->action;
            // $case->Update_Date = now();

            $user = User::find($case->CR_BY);
            if (!$user) {
                return $request->ajax()
                    ? response()->json(['success' => false, 'message' => 'User Not Found'])
                    : redirect()->back()->with('error', 'User Not Found');
            }

            if ($case->Case_Status === 'OPEN' && $case->Case_IsReject === 'Y') {
                $case->Case_RejGroup = null;
                $case->Case_RejBy = null;
                $case->Case_IsReject = 'N';
                $case->Case_RejDate = null;
                $case->Case_RMK1 = null;
                $case->Case_RMK2 = null;

                Log::info('UpdateCase: Reset data penolakan karena case dibuka kembali', [
                    'case_no' => $case->Case_No
                ]);
            }

            $matrix = Matrix::where('Position', $user->PS_ID)
                ->where('MAT_TYPE', 'CR')
                ->first();

            if ($matrix) {
                $case->Case_Status = 'SUBMIT';
                $case->Case_ApStep = 1;
                $case->Case_APMaxStep = $matrix->Mat_Max;
                $case->Case_AP1 = $matrix->AP1;
                $case->Case_AP2 = $matrix->AP2;
                $case->Case_AP3 = $matrix->AP3;
                $case->Case_AP4 = $matrix->AP4;
            } else {
                Log::warning('UpdateCase: Tidak ada data Matrix dengan MAT_TYPE CR untuk posisi ini', [
                    'position' => $user->PS_ID
                ]);
            }

            $case->save();

            Log::info('UpdateCase: Case berhasil diperbarui', ['case_no' => $request->case_no]);

            // if ($request->hasFile('new_images')) {
            //     foreach ($request->file('new_images') as $image) {
            //         $caseNo = str_replace(['/','\\'], '-', $case->Case_No);
            //         $directory = "case_photos/$caseNo";

            //         if (!Storage::disk('public')->exists($directory)) {
            //             Storage::disk('public')->makeDirectory($directory, 0755, true);
            //         }

            //         $newFilename = "case_" . time() . "_" . uniqid() . "." . $image->getClientOriginalExtension();
            //         $path = $image->storeAs($directory, $newFilename, 'public');

            //         $img = Imgs::create([
            //             'IMG_No' => Imgs::generateImgNo(),
            //             'IMG_RefNo' => $case->Case_No,
            //             'IMG_Filename' => $newFilename,
            //             'IMG_Realname' => $image->getClientOriginalName(),
            //         ]);

            //         DB::table('Logs')->insert([
            //             'Logs_No' => Logs::generateLogsNo(),
            //             'LOG_Type' => 'BA',
            //             'LOG_RefNo' => $case->Case_No,
            //             'LOG_Status' => 'IMAGE_ADDED',
            //             'LOG_User' => Auth::id(),
            //             'LOG_Date' => now(),
            //             'LOG_Desc' => "New image has been uploaded.",
            //         ]);
            //     }
            // }

            if ($case->Case_AP1) {
                Notification::create([
                    'Notif_No' => Notification::generateNotificationNo(),
                    'Notif_Title' => $case->Case_No,
                    'Reference_No' => $case->Case_No,
                    'Notif_Text' => 'A case has been submitted and requires your approval.',
                    'Notif_IsRead' => 'N',
                    'Notif_From' => Auth::id(),
                    'Notif_To' => $case->Case_AP1,  
                    'Notif_Date' => now(),
                    'Notif_Type' => 'BA',
                ]);
                
                Log::info('UpdateCase: Notifikasi berhasil dikirim', [
                    'case_no' => $case->Case_No,
                    'notif_to' => $case->Case_AP1,
                ]);

                DB::table('Logs')->insert([
                    'Logs_No' => Logs::generateLogsNo(),
                    'LOG_Type' => 'BA',
                    'LOG_RefNo' => $case->Case_No,
                    'LOG_Status' => 'NOTIFICATION_SENT',
                    'LOG_User' => Auth::id(),
                    'LOG_Date' => now(),
                    'LOG_Desc' => "Notification sent to user {$case->Case_AP1}",
                ]);
            }
            
            $userName = Auth::user()->Fullname;
            
            // Logs
            DB::table('Logs')->insert([
                'Logs_No' => Logs::generateLogsNo(),
                'LOG_Type' => 'BA',
                'LOG_RefNo' => $case->Case_No,
                'LOG_Status' => 'SUBMITTED',
                'LOG_User' => Auth::id(),
                'LOG_Date' => now(),
                'LOG_Desc' => $userName .' SUBMITTED A CASE', 
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Your case has been successfully submitted.',
                    'case_no' => $case->Case_No
                ]);
            } else {
                return redirect()->route('CreateCase')->with('success', 'Your case has been successfully submitted!');
            }

        } catch (\Exception $e) {
            Log::error('UpdateCase: Terjadi kesalahan saat update case', [
                'case_no' => $request->case_no,
                'error' => $e->getMessage()
            ]);

            DB::table('Logs')->insert([
                'Logs_No' => Logs::generateLogsNo(),
                'LOG_Type' => 'BA',
                'LOG_RefNo' => $request->case_no,
                'LOG_Status' => 'ERROR',
                'LOG_User' => Auth::id(),
                'LOG_Date' => now(),
                'LOG_Desc' => Str::limit('Error Submitting Case: ' . $e->getMessage(), 250),
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error: ' . $e->getMessage()
                ]);
            } else {
                return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
            }
        }
    }


// PAGE LIST CASE
    // Untuk Liat Page View Case
    public function viewListBA(){
        return view('content.case.ViewCase');
    }

    // Ambil Data Case Tampilkan di Table
    public function getCases(Request $request)
    {
        $userId = Auth::id();
        $user = Auth::user();
        $status = $request->query('status');
        $sortColumn = $request->query('sortColumn', 'Case_No');
        $sortDirection = $request->query('sortDirection', 'ASC');

        $validColumns = ['Case_No', 'Case_Date'];
        if (!in_array($sortColumn, $validColumns)) {
            $sortColumn = 'Case_No';
        }

        // Ambil semua permission user
        $canViewCr = $user->hasPermissionTo('view cr');
        $canViewCrAp = $user->hasPermissionTo('view cr_ap');

        Log::info("User: " . $user->Fullname);
        Log::info("Can view cr: " . json_encode($canViewCr));
        Log::info("Can view cr_ap: " . json_encode($canViewCrAp));

        // Base query
        $baseQuery = Cases::select(
                'cases.Case_No',
                'cases.Case_Name',
                'cases.Case_Date',
                'cases.Cat_No',
                'Cats.Cat_Name as Category',
                'cases.CR_BY',
                'users.Fullname as CreatedBy',
                'users.Fullname as User',
                'cases.Case_Status',
                'users.PS_ID',
                'Positions.PS_Name'
            )
            ->leftJoin('Cats', 'cases.Cat_No', '=', 'Cats.Cat_No')
            ->leftJoin('users', 'cases.CR_BY', '=', 'users.id')
            ->leftJoin('Positions', 'users.PS_ID', '=', 'Positions.id');

        // Filter data berdasarkan permission
        if ($canViewCr && !$canViewCrAp) {
            $baseQuery->where('cases.CR_BY', $userId);
        } elseif (!$canViewCr && $canViewCrAp) {
            $baseQuery->where(function($query) use ($userId) {
                $query->where('cases.Case_AP1', $userId)
                    ->orWhere('cases.Case_AP2', $userId);
            });
        } elseif ($canViewCr && $canViewCrAp) {
            $baseQuery->where(function($query) use ($userId) {
                $query->where('cases.CR_BY', $userId)
                    ->orWhere('cases.Case_AP1', $userId)
                    ->orWhere('cases.Case_AP2', $userId);
            });
        } else {
            return response()->json([]);
        }

        // Filter status jika ada
        if (!empty($status)) {
            $baseQuery->where('cases.Case_Status', $status);
        }

        $cases = $baseQuery->orderBy($sortColumn, $sortDirection)->get();

        return response()->json($cases);
    }

    // Untuk View Detail Case (Not Approval)
    public function showDetailPage($case_no)
    {
        $case_no = base64_decode($case_no);

        if (!$case_no) {
            return redirect()->back()->with('error', 'Case not found.');
        }

        $case = Cases::select(
                'cases.Case_No',
                'cases.Case_Name',
                'cases.CR_DT',
                'cases.Cat_No', 
                'Cats.Cat_Name as Category',
                'Subcats.Scat_Name as SubCategory', 
                'cases.CR_BY',
                'users.Fullname as User',
                'cases.Case_Status',
                'users.PS_ID',
                'Positions.PS_Name',
                'cases.Case_Chronology',
                'cases.Case_Outcome',
                'cases.Case_Suggest',
                'cases.Case_Action',
                'cases.Case_ApMaxStep', 
                'cases.Case_RMK1', 
                'cases.Case_RMK2', 
                'cases.Case_RMK3', 
                'cases.Case_RMK4', 
                'cases.Case_RMK5',
                'cases.Case_AP1',
                'cases.Case_AP2',
                'cases.Case_AP3',
                'cases.Case_AP4',
                'cases.Case_AP5'
            )
            ->leftJoin('Cats', 'cases.Cat_No', '=', 'Cats.Cat_No')
            ->leftJoin('Subcats', 'cases.Scat_No', '=', 'Subcats.Scat_No')
            ->leftJoin('users', 'cases.CR_BY', '=', 'users.id')
            ->leftJoin('Positions', 'users.PS_ID', '=', 'Positions.id')
            ->where('cases.Case_No', $case_no)
            ->first();

        if (!$case) {
            return redirect()->back()->with('error', 'Case not found.');
        }   
        
        $approvers = [];

        for ($i = 1; $i <= $case->Case_ApMaxStep; $i++) {
            $approverId = $case->{'Case_AP' . $i} ?? null;

            if ($approverId) {
                $user = User::find($approverId);
                $approvers[$i] = $user ? $user->Fullname : 'Unknown User';
            } else {
                $approvers[$i] = 'Unknown User';
            }
        }

        $images = Imgs::where('IMG_RefNo', $case_no)->get();

        $logs = DB::table('Logs')
            ->join('users', 'Logs.LOG_User', '=', 'users.id')
            ->select('Logs.*', 'users.Fullname as user_name')
            ->where('LOG_Type', 'BA') 
            ->where('LOG_RefNo', $case->Case_No)
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

        return view('content.case.DetailCase', compact('case', 'images', 'logs', 'approvalLogs','approvers'));
    }

// PAGE APPROVAL LIST CASE
    // Mengarahkan Ke Page Approval List (Table)
    public function ApprovalListBA(){
        
        return view('content.case.ApprovalList');
    }

    public function storeCaseNoApprovalList(Request $request)
    {
        $request->session()->put('case_no', $request->case_no);
        return redirect('/Case/Approval/Detail');
    }

    // Mengambil data Case Dan dimunculkan paga Approval List Case
    public function getApprovalCases(Request $request)
    {
        $user = Auth::user();
    
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    
        $status = $request->input('status'); 

        $cases = Cases::select(
                'cases.Case_No',
                'cases.Case_Name',
                'cases.Case_Date',
                'cases.Cat_No',
                'Cats.Cat_Name as Category',
                'cases.CR_BY',
                'users.Fullname as User',
                'cases.Case_Status',
                'users.PS_ID',
                'Positions.PS_Name',
                'cases.Case_ApStep',
                'cases.Case_ApMaxStep'
            )
            ->leftJoin('Cats', 'cases.Cat_No', '=', 'Cats.Cat_No')
            ->leftJoin('users', 'cases.CR_BY', '=', 'users.id')
            ->leftJoin('Positions', 'users.PS_ID', '=', 'Positions.id')
            ->whereNotIn('cases.Case_Status', ['CLOSE'])
            ->where(function ($query) use ($user) {
                $query->where(function ($q) use ($user) {
                    $q->where('cases.Case_ApStep', 1)
                        ->where('cases.Case_AP1', $user->id)
                        ->whereNull('cases.Case_RMK1');
                })
                ->orWhere(function ($q) use ($user) {
                    $q->where('cases.Case_ApStep', 2)
                        ->where('cases.Case_AP2', $user->id)
                        ->whereNull('cases.Case_RMK2');
                })
                ->orWhere(function ($q) use ($user) {
                    $q->where('cases.Case_ApStep', 3)
                        ->where('cases.Case_AP3', $user->id)
                        ->whereNull('cases.Case_RMK3');
                })
                ->orWhere(function ($q) use ($user) {
                    $q->where('cases.Case_ApStep', 4)
                        ->where('cases.Case_AP4', $user->id)
                        ->whereNull('cases.Case_RMK4');
                })
                ->orWhere(function ($q) use ($user) {
                    $q->where('cases.Case_ApStep', 5)
                        ->where('cases.Case_AP5', $user->id)
                        ->whereNull('cases.Case_RMK5');
                });
            });
    
        if ($status && $status !== '') {
            $cases->where('cases.Case_Status', $status);
        }
        
    
        return response()->json($cases->get());
    }

    // Mengambil dan Menampilkan data case untuk page Detail Approval Cases
    public function ApprovalDetailCase($case_no)
    {
        $case_no = base64_decode($case_no);

        Log::info('Case No (raw): ' . $case_no);
    
        $decodedCaseNo = urldecode($case_no);
        Log::info('Case No (decoded): ' . $decodedCaseNo);
    
        if (!$decodedCaseNo) {
            return redirect()->back()->with('error', 'Case not found.');
        }
    
        $case = Cases::select(
            'cases.*', 
            'Cats.Cat_Name as Category', 
            'Subcats.Scat_Name as SubCategory', 
            'users.Fullname as CreatedBy', 
            'UsersReject.Fullname as Case_RejectedBy',
            'Ap1.Fullname as Approver1',    
            'Ap2.Fullname as Approver2',
            'Ap3.Fullname as Approver3',
            'Ap4.Fullname as Approver4',
            'Ap5.Fullname as Approver5'
        )
        ->leftJoin('Cats', 'cases.Cat_No', '=', 'Cats.Cat_No')
        ->leftJoin('Subcats', 'cases.Scat_No', '=', 'Subcats.Scat_No')
        ->leftJoin('users', 'cases.CR_BY', '=', 'users.id')
        ->leftJoin('users as UsersReject', 'cases.Case_RejBy', '=', 'UsersReject.id')
        ->leftJoin('users as Ap1', 'cases.Case_AP1', '=', 'Ap1.id')
        ->leftJoin('users as Ap2', 'cases.Case_AP2', '=', 'Ap2.id')
        ->leftJoin('users as Ap3', 'cases.Case_AP3', '=', 'Ap3.id')
        ->leftJoin('users as Ap4', 'cases.Case_AP4', '=', 'Ap4.id')
        ->leftJoin('users as Ap5', 'cases.Case_AP5', '=', 'Ap5.id')
        ->where('cases.Case_No', $decodedCaseNo)
        ->first();
    
        Log::info('Hasil Query:', ['case' => $case]);
    
        if (!$case) {
            return abort(404, "Case not found");
        }
    
        $images = Imgs::where('IMG_RefNo', $decodedCaseNo)->get();
        
        $logs = DB::table('Logs')
            ->join('users', 'Logs.LOG_User', '=', 'users.id')
            ->select('Logs.*', 'users.Fullname as user_name')
            ->where('LOG_Type', 'BA') 
            ->where('LOG_RefNo', $case->Case_No)
            ->orderBy('LOG_Date', 'desc')
            ->get();
    
        return view('content.case.ApprovalDetail', compact('case', 'images','logs'));
    }
    
    // Function Approve
    public function approveReject(Request $request, $case_no)
    {
        // $case_no = urldecode($case_no); 
        $case_no = base64_decode($case_no);
        $case = Cases::where('Case_No', $case_no)->firstOrFail();
        $user = Auth::user();
        $notes = $request->input('approvalNotes');
        $action = $request->input('action');
        
        if ($action == 'approve') {
            if ($case->Case_ApStep == 1) {
                $case->Case_Status = 'AP1'; 
                $case->Case_RMK1 = $notes;
                $case->Case_ApStep = 2;

                Logs::create([
                    'Logs_No' => Logs::generateLogsNo(),
                    'LOG_Type'   => 'BA',
                    'LOG_RefNo'  => $case_no,
                    'LOG_Status' => 'APPROVED 1',
                    'LOG_User'   => $user->id,
                    'LOG_Date'   => Carbon::now(),
                    'LOG_Desc'   => $user->Fullname . ' APPROVED CASE' ,
                ]);

                Notification::create([
                    'Notif_No' => Notification::generateNotificationNo(),
                    'Notif_Title' => 'Case Approved',
                    'Reference_No' => $case->Case_No,
                    'Notif_Text'  => 'Case ' . $case->Case_No . ' approved by ' . $user->Fullname,
                    'Notif_IsRead' => 'N',
                    'Notif_From'  => $user->id,
                    'Notif_To'    => $case->Case_AP2, 
                    'Notif_Date'  => Carbon::now(),
                    'Notif_Type'  => 'BA'
                ]);
            } elseif ($case->Case_ApStep == 2) {
                $case->Case_Status = 'AP2'; 
                $case->Case_RMK2 = $notes;
                $case->Case_ApStep = 2; 

                Logs::create([
                    'Logs_No' => Logs::generateLogsNo(),
                    'LOG_Type'   => 'BA',
                    'LOG_RefNo'  => $case_no,
                    'LOG_Status' => 'APPROVED 2',
                    'LOG_User'   => $user->id,
                    'LOG_Date'   => Carbon::now(),
                    'LOG_Desc'   => $user->Fullname . ' APPROVED CASE' ,
                ]);

                Notification::create([
                    'Notif_No' => Notification::generateNotificationNo(),
                    'Notif_Title' => 'Case Approved',
                    'Reference_No' => $case->Case_No,
                    'Notif_Text'  => 'Case ' . $case->Case_No . ' approved by ' . $user->Fullname,
                    'Notif_IsRead' => 'N',
                    'Notif_From'  => $user->id,
                    'Notif_To'    => $case->CR_BY, 
                    'Notif_Date'  => Carbon::now(),
                    'Notif_Type'  => 'BA'
                ]);
            } else {
                return response()->json(['error' => 'Invalid approval step'], 400);
            }
        
            $case->save();
        
            return response()->json(['message' => 'Case Approved Successfully']);
        } else {
            if ($case->Case_ApStep == 1) {
                $case->Case_Status = 'REJECT';
                $case->Case_IsReject = 'Y';
                $case->Case_RejGroup = 'AP1';
                $case->Case_RejBy = $user->id;
                $case->Case_RejDate = Carbon::now();
                $case->Case_RMK1 = $notes;

                Notification::create([
                    'Notif_No' => Notification::generateNotificationNo(),
                    'Notif_Title' => 'Case Rejected',
                    'Reference_No' => $case->Case_No,
                    'Notif_Text'  => 'Case ' . $case->Case_No . ' rejected by ' . $user->Fullname,
                    'Notif_IsRead' => 'N',
                    'Notif_From'  => $user->id,
                    'Notif_To'    => $case->CR_BY,
                    'Notif_Date'  => Carbon::now(),
                    'Notif_Type'  => 'BA'
                ]);

                Logs::create([
                    'Logs_No' => Logs::generateLogsNo(),
                    'LOG_Type'   => 'BA',
                    'LOG_RefNo'  => $case_no,
                    'LOG_Status' => 'REJECTED 1',
                    'LOG_User'   => $user->id,
                    'LOG_Date'   => Carbon::now(),
                    'LOG_Desc'   => $user->Fullname . ' REJECTED CASE',
                ]);

            } elseif ($case->Case_ApStep == 2) {
                $case->Case_Status = 'REJECT';
                $case->Case_IsReject = 'Y';
                $case->Case_RejGroup = 'AP2';
                $case->Case_RejBy = $user->id;
                $case->Case_RejDate = Carbon::now();
                $case->Case_RMK2 = $notes;

                Notification::create([
                    'Notif_No' => Notification::generateNotificationNo(),
                    'Notif_Title' => 'Case Rejected',
                    'Reference_No' => $case->Case_No,
                    'Notif_Text'  => 'Case ' . $case->Case_No . ' rejected by ' . $user->Fullname,
                    'Notif_IsRead' => 'N',
                    'Notif_From'  => $user->id,
                    'Notif_To'    => $case->Case_AP1,
                    'Notif_Date'  => Carbon::now(),
                    'Notif_Type'  => 'BA'
                ]);

                Notification::create([
                    'Notif_No' => Notification::generateNotificationNo(),
                    'Notif_Title' => 'Case Rejected',
                    'Reference_No' => $case->Case_No,
                    'Notif_Text'  => 'Case ' . $case->Case_No . ' rejected by ' . $user->Fullname,
                    'Notif_IsRead' => 'N',
                    'Notif_From'  => $user->id,
                    'Notif_To'    => $case->CR_BY,
                    'Notif_Date'  => Carbon::now(),
                    'Notif_Type'  => 'BA'
                ]);

                Logs::create([
                    'Logs_No' => Logs::generateLogsNo(),
                    'LOG_Type'   => 'BA',
                    'LOG_RefNo'  => $case_no,
                    'LOG_Status' => 'REJECTED 2',
                    'LOG_User'   => $user->id,
                    'LOG_Date'   => Carbon::now(),
                    'LOG_Desc'   => $user->Fullname . ' REJECTED CASE',
                ]);
            } else {
                return response()->json(['error' => 'Invalid approval step'], 400);
            }

            $case->save();
        
            return response()->json(['message' => 'Case Rejected Successfully']);
        }
        
    }
    


}

