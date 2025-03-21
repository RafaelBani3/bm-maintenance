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
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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
        Log::info('Processing SaveCase', ['user_id' => Auth::id(), 'request_data' => $request->all()]);

        $validatedData = $request->validate([
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

        try {
            $case = new Cases();
            $caseNo = $case->getIncrementCaseNo();
            Log::info('Generated Case Number', ['case_no' => $caseNo]);

            $case = Cases::create([
                'Case_No' => $caseNo,
                'Case_Name' => $validatedData['cases'],
                'Case_Date' => $validatedData['date'],
                'CR_BY' => Auth::id(),
                'CR_DT' => now(),
                'Cat_No' => $validatedData['category'],
                'Scat_No' => $validatedData['sub_category'],
                'Case_Chronology' => $validatedData['chronology'],
                'Case_Outcome' => $validatedData['impact'],
                'Case_Suggest' => $validatedData['suggestion'],
                'Case_Action' => $validatedData['action'],
                'Case_Status' => 'OPEN',
                'Case_IsReject' => 'N',
                'Case_ApStep' => 0,
                'Case_ApMaxStep' => 5,
                'Case_Loc_Floor' => 0,
                'Case_Loc_Room' => '',
                'Case_Loc_Object' => '',
                'Update_Date' => now(),
            ]);

            Log::info('Case saved successfully', ['case_no' => $case->Case_No]);

            Logs::create([
                'LOG_Type' => 'BA',  
                'LOG_RefNo' => $case->Case_No,
                'LOG_Status' => 'CREATED',
                'LOG_User' => Auth::id(),
                'LOG_Date' => now(),
                'LOG_Desc' => 'New case created with Case No: ' . $case->Case_No,
            ]);

            $uploadedPaths = [];
            if ($request->hasFile('photos')) {
                $caseNo = str_replace(['/','\\'],'-', $case->Case_No);
                $directory = "case_photos/$caseNo";
                if (!Storage::disk('public')->exists($directory)) {
                    Storage::disk('public')->makeDirectory($directory, 0755, true);
                }

                foreach ($request->file('photos') as $photo) {
                    $newFileName = "case_" . time() . "_" . uniqid() . "." . $photo->getClientOriginalExtension();
                    $path = $photo->storeAs($directory, $newFileName, 'public');
                    $uploadedPaths[] = $path;

                    Imgs::create([
                        'IMG_No' => Imgs::generateImgNo(),
                        'IMG_Type' => 'BA',
                        'IMG_RefNo' => $case->Case_No,
                        'IMG_Filename' => $newFileName,
                        'IMG_Realname' => $photo->getClientOriginalName(),
                    ]);
                }

                Log::info('Photos uploaded', [
                    'case_no' => $case->Case_No,
                    'files' => $uploadedPaths
                ]);

                Logs::create([
                    'LOG_Type' => 'BA',
                    'LOG_RefNo' => $case->Case_No,
                    'LOG_Status' => 'PHOTOS_UPLOADED',
                    'LOG_User' => Auth::id(),
                    'LOG_Date' => now(),
                    'LOG_Desc' => count($uploadedPaths) . ' photos uploaded for Case No: ' . $case->Case_No,
                ]);
            }

            Log::info('Case creation completed successfully', ['case_no' => $case->Case_No]);
            return response()->json([
                'success' => true,
                'message' => 'Case created successfully.',
                'case_no' => $case->Case_No
            ]);
        } catch (\Exception $e) {
            Log::error('Error saving case', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            Logs::create([
                'LOG_Type' => 'BA',
                'LOG_RefNo' => null,
                'LOG_Status' => 'FAILED',
                'LOG_User' => Auth::id(),
                'LOG_Date' => now(),
                'LOG_Desc' => 'Failed to create case. Error: ' . $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to create case.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function EditCase(Request $request)
    {
        $caseNo = $request->query('case_no');

        $case = Cases::where('Case_No', $caseNo)->firstOrFail();
        $categories = Cats::all();
        $subCategories = Subcats::where('Cat_No', $case->Cat_No)->get();
        $caseImages = Imgs::where('IMG_RefNo', $case->Case_No)->get();

        return view('content.case.EditCase', compact('case', 'categories', 'subCategories', 'caseImages'));
    }

    public function UpdateCase(Request $request)
    {
        $request->validate([
            'case_no' => 'required|string|exists:cases,Case_No',
            'cases' => 'required|string|max:255',
            'date' => 'required|date',
            'category' => 'required|string|exists:cats,Cat_No',
            'sub_category' => 'required|string|exists:subcats,Scat_No',
            'chronology' => 'required|string|max:255',
            'impact' => 'required|string|max:255',
            'suggestion' => 'required|string|max:255',
            'action' => 'required|string|max:255',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);

        try {
            Log::info('UpdateCase: Memulai proses update case', ['case_no' => $request->case_no]);

            $case = Cases::where('Case_No', $request->case_no)->first();
            if (!$case) {
                Log::warning('UpdateCase: Case tidak ditemukan', ['case_no' => $request->case_no]);
                return redirect()->back()->with('error', 'Case tidak ditemukan.');
            }

            $case->Case_Name = $request->cases;
            $case->Case_Date = $request->date;
            $case->Cat_No = $request->category;
            $case->Scat_No = $request->sub_category;
            $case->Case_Chronology = $request->chronology;
            $case->Case_Outcome = $request->impact;
            $case->Case_Suggest = $request->suggestion;
            $case->Case_Action = $request->action;
            $case->Update_Date = now();

            $user = User::find($case->CR_BY);
            if (!$user) {
                return redirect()->back()->with('error', 'User Not Found');
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

            DB::table('Logs')->insert([
                'LOG_Type' => 'BA',
                'LOG_RefNo' => $case->Case_No,
                'LOG_Status' => 'UPDATED',
                'LOG_User' => Auth::id(),
                'LOG_Date' => now(),
                'LOG_Desc' => 'Case updated successfully',
            ]);

            if ($request->hasFile('new_images')) {
                foreach ($request->file('new_images') as $img_no => $image) {
                    $existingImage = Imgs::where('IMG_No', $img_no)->first();

                    if ($existingImage) {
                        Log::info('UpdateCase: Mengupdate gambar', ['IMG_No' => $img_no]);

                        $caseNo = str_replace(['/','\\'], '-', $existingImage->IMG_RefNo);
                        $directory = "case_photos/$caseNo";

                        if (!Storage::disk('public')->exists($directory)) {
                            Storage::disk('public')->makeDirectory($directory, 0755, true);
                        }

                        $oldFilePath = "$directory/{$existingImage->IMG_Filename}";

                        if (Storage::disk('public')->exists($oldFilePath)) {
                            Storage::disk('public')->delete($oldFilePath);
                            Log::info('UpdateCase: File lama dihapus', ['filepath' => $oldFilePath]);
                        } else {
                            Log::warning('UpdateCase: File lama tidak ditemukan', ['filepath' => $oldFilePath]);
                        }

                        $newFilename = "case_" . time() . "_" . uniqid() . "." . $image->getClientOriginalExtension();
                        $path = $image->storeAs($directory, $newFilename, 'public');

                        $existingImage->IMG_Filename = $newFilename;
                        $existingImage->IMG_Realname = $image->getClientOriginalName();
                        $existingImage->save();

                        Log::info('UpdateCase: Gambar berhasil diperbarui', [
                            'IMG_No' => $img_no,
                            'filename' => $newFilename,
                            'path' => $path
                        ]);

                        DB::table('Logs')->insert([
                            'LOG_Type' => 'BA',
                            'LOG_RefNo' => $case->Case_No,
                            'LOG_Status' => 'IMAGE_UPDATED',
                            'LOG_User' => Auth::id(),
                            'LOG_Date' => now(),
                            'LOG_Desc' => "Image updated for case {$case->Case_No}",
                        ]);
                    } else {
                        Log::warning('UpdateCase: Gambar tidak ditemukan', ['IMG_No' => $img_no]);
                    }
                }
            }

            // Notifikasi
            if ($case->Case_AP1) {
                $notifFrom = Auth::id();
                if (!$notifFrom) {
                    Log::error('UpdateCase: User login tidak ditemukan untuk Notif_From');
                    return redirect()->back()->with('error', 'User login tidak ditemukan.');
                }

                Notification::create([
                    'Notif_Title' => 'Approval Case: ' . $case->Case_No,
                    'Notif_Text' => 'A case has been updated and requires your approval.',
                    'Notif_IsRead' => 'N',
                    'Notif_From' => $notifFrom,
                    'Notif_To' => $case->Case_AP1,
                    'Notif_Date' => now(),
                    'Notif_Type' => 'BA',
                ]);

                Log::info('UpdateCase: Notifikasi berhasil dikirim', [
                    'case_no' => $case->Case_No,
                    'notif_to' => $case->Case_AP1,
                ]);

                // Simpan ke Logs
                DB::table('Logs')->insert([
                    'LOG_Type' => 'BA',
                    'LOG_RefNo' => $case->Case_No,
                    'LOG_Status' => 'NOTIFICATION_SENT',
                    'LOG_User' => Auth::id(),
                    'LOG_Date' => now(),
                    'LOG_Desc' => "Notification sent to user {$case->Case_AP1}",
                ]);
            }

            return redirect()->route('CreateCase')->with('success', 'Case updated successfully!');

        } catch (\Exception $e) {
            Log::error('UpdateCase: Terjadi kesalahan saat update case', [
                'case_no' => $request->case_no,
                'error' => $e->getMessage()
            ]);

            // Simpan error ke Logs
            DB::table('Logs')->insert([
                'LOG_Type' => 'BA',
                'LOG_RefNo' => $request->case_no,
                'LOG_Status' => 'ERROR',
                'LOG_User' => Auth::id(),
                'LOG_Date' => now(),
                'LOG_Desc' => 'Error updating case: ' . $e->getMessage(),
            ]);

            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

// PAGE LIST CASE
    // Untuk Liat Page View Case
    public function viewListBA(){
        return view('content.case.ViewCase');
    }

    public function filter(Request $request)
    {
        $query = DB::table('cases');
    
        if ($request->status) {
            $query->where('Case_Status', $request->status);
        }
    
        if ($request->date) {
            $query->whereDate('CR_DT', $request->date  );
        }
    
        $data = $query->get();
    
        return response()->json(['data' => $data]);
    }
    
    
    // Untuk mengambil data Cases dan ditampilakn kedalam Table
    public function getCases()
    {
        $cases = Cases::select(
            'cases.Case_No',
            'cases.Case_Name',
            'cases.Case_Date',
            'cases.Cat_No',
            'Cats.Cat_Name as Category',
            'cases.CR_BY',
            'Users.Fullname as CreatedBy', 
            // 'Users2.Fullname as Case_RejectedBy',
            'Users.Fullname as User',
            'cases.Case_Status',
            'Users.PS_ID',
            'Positions.PS_Name', 
        )
        ->leftJoin('Cats', 'cases.Cat_No', '=', 'Cats.Cat_No')
        ->leftJoin('Users', 'cases.CR_BY', '=', 'Users.id')
        ->leftJoin('Positions', 'Users.PS_ID', '=', 'Positions.id') 
        ->get();           
        
        return response()->json($cases);
    }


    public function storeCaseNoViewBA(Request $request)
    {
        $request->session()->put('case_no', $request->case_no);
        return redirect('/Case/Detail');
    }

    // Untuk Buku Detail Case (Not Approval)
    public function showDetailPage(Request $request)
    {
        $case_no = $request->session()->get('case_no');

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
            'Users.Fullname as User',
            'cases.Case_Status',
            'Users.PS_ID',
            'Positions.PS_Name',
            'cases.Case_Chronology',
            'cases.Case_Outcome',
            'cases.Case_Suggest',
            'cases.Case_Action',
            'cases.Case_ApMaxStep', 
            'cases.Case_RMK1', 'cases.Case_RMK2', 'cases.Case_RMK3', 
            'cases.Case_RMK4', 'cases.Case_RMK5' 
        )
        ->leftJoin('Cats', 'cases.Cat_No', '=', 'Cats.Cat_No')
        ->leftJoin('Subcats', 'cases.Scat_No', '=', 'Subcats.Scat_No')
        ->leftJoin('Users', 'cases.CR_BY', '=', 'Users.id')
        ->leftJoin('Positions', 'Users.PS_ID', '=', 'Positions.id')
        ->where('cases.Case_No', $case_no)
        ->first();

        $images = Imgs::where('IMG_RefNo', $case_no)->get();

        if (!$case) {
            return redirect()->back()->with('error', 'Case not found.');
        }

        return view('content.case.DetailCase', compact('case', 'images'));
    }

// Page Approval List Table
    // Untuk mengambil dara Cases dan ditampilakn kedalam Table
    // public function getApprovalCases()
    // {
    //     $user = Auth::user();

    //     if (!$user) {
    //         return response()->json(['error' => 'Unauthorized'], 401);
    //     }

    //     $cases = Cases::select(
    //             'cases.Case_No',
    //             'cases.Case_Name',
    //             'cases.Case_Date',
    //             'cases.Cat_No',
    //             'Cats.Cat_Name as Category',
    //             'cases.CR_BY',
    //             'Users.Fullname as User',
    //             'cases.Case_Status',
    //             'Users.PS_ID',
    //             'Positions.PS_Name', 
    //         )
    //         ->leftJoin('Cats', 'cases.Cat_No', '=', 'Cats.Cat_No')
    //         ->leftJoin('Users', 'cases.CR_BY', '=', 'Users.id')
    //         ->leftJoin('Positions', 'Users.PS_ID', '=', 'Positions.id') 
    //         ->where(function ($query) use ($user) {
    //             $query->where('cases.Case_AP1', $user->id)
    //                 ->orWhere('cases.Case_AP2', $user->id)
    //                 ->orWhere('cases.Case_AP3', $user->id)
    //                 ->orWhere('cases.Case_AP4', $user->id)
    //                 ->orWhere('cases.Case_AP5', $user->id);
    //         })
    //         ->whereNotIn('cases.Case_Status', ['CLOSE', 'REJECT'])
    //         ->get();

    //     return response()->json($cases);
    // }

    public function getApprovalCases()
    {
        $user = Auth::user();
    
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    
        $cases = Cases::select(
                'cases.Case_No',
                'cases.Case_Name',
                'cases.Case_Date',
                'cases.Cat_No',
                'Cats.Cat_Name as Category',
                'cases.CR_BY',
                'Users.Fullname as User',
                'cases.Case_Status',
                'Users.PS_ID',
                'Positions.PS_Name'
            )
            ->leftJoin('Cats', 'cases.Cat_No', '=', 'Cats.Cat_No')
            ->leftJoin('Users', 'cases.CR_BY', '=', 'Users.id')
            ->leftJoin('Positions', 'Users.PS_ID', '=', 'Positions.id') 
            ->where(function ($query) use ($user) {
                $query->where('cases.Case_AP1', $user->id)
                      ->whereNull('cases.Case_RMK1')  
                    ->orWhere(function ($q) use ($user) {
                        $q->where('cases.Case_AP2', $user->id)
                          ->whereNull('cases.Case_RMK2'); 
                    });
            })
            ->whereNotIn('cases.Case_Status', ['CLOSE', 'REJECT'])
            ->get();
    
        return response()->json($cases);
    }
    

    // Mengarahkan Ke Page Approval List (Table)
    public function ApprovalListBA(){
        return view('content.case.ApprovalList');
    }

    public function storeCaseNoApprovalList(Request $request)
    {
        $request->session()->put('case_no', $request->case_no);
        return redirect('/Case/Approval/Detail');
    }

    public function ApprovalDetailCase(Request $request)
    {
        $case_no = $request->session()->get('case_no');

        if (!$case_no) {
            return redirect()->back()->with('error', 'Case not found.');
        }

        $case = Cases::select(
            'cases.*', 
            'Cats.Cat_Name as Category', 
            'Subcats.Scat_Name as SubCategory', 
            'Users.Fullname as CreatedBy', 
            'UsersReject.Fullname as Case_RejectedBy',
            'Ap1.Fullname as Approver1',
            'Ap2.Fullname as Approver2',
            'Ap3.Fullname as Approver3',
            'Ap4.Fullname as Approver4',
            'Ap5.Fullname as Approver5'
        )
        ->leftJoin('Cats', 'cases.Cat_No', '=', 'Cats.Cat_No')
        ->leftJoin('Subcats', 'cases.Scat_No', '=', 'Subcats.Scat_No')
        ->leftJoin('Users', 'cases.CR_BY', '=', 'Users.id')
        ->leftJoin('Users as UsersReject', 'cases.Case_RejBy', '=', 'UsersReject.id')
        ->leftJoin('Users as Ap1', 'cases.Case_AP1', '=', 'Ap1.id')
        ->leftJoin('Users as Ap2', 'cases.Case_AP2', '=', 'Ap2.id')
        ->leftJoin('Users as Ap3', 'cases.Case_AP3', '=', 'Ap3.id')
        ->leftJoin('Users as Ap4', 'cases.Case_AP4', '=', 'Ap4.id')
        ->leftJoin('Users as Ap5', 'cases.Case_AP5', '=', 'Ap5.id')
        ->where('cases.Case_No', $case_no)
        ->first();

        $images = Imgs::where('IMG_RefNo', $case_no)->get();

        if (!$case) {
            return abort(404, "Case not found");
        }

        return view('content.case.ApprovalDetail', compact('case', 'images'));
    }


    // Function Approve
    public function approveReject(Request $request, $case_no)
    {
        $case_no = urldecode($case_no); 
        $case = Cases::where('Case_No', $case_no)->firstOrFail();
        $user = Auth::user();
        $notes = $request->input('approvalNotes');
        $action = $request->input('action');
        if ($action == 'approve') {
            if ($case->Case_ApStep == 1) {
                $case->Case_Status = 'AP1'; 
                $case->Case_RMK1 = $notes;
                $case->Case_ApStep = 2;
            } elseif ($case->Case_ApStep == 2) {
                $case->Case_Status = 'AP2'; 
                $case->Case_RMK2 = $notes;
                $case->Case_ApStep = 2; 
            } else {
                return response()->json(['error' => 'Invalid approval step'], 400);
            }
        
            $case->save();
        
            Logs::create([
                'LOG_Type'   => 'BA',
                'LOG_RefNo'  => $case_no,
                'LOG_Status' => 'APPROVED',
                'LOG_User'   => $user->id,
                'LOG_Date'   => Carbon::now(),
                'LOG_Desc'   => 'Case Approved by ' . $user->Fullname,
            ]);
        
            Notification::create([
                'Notif_Title' => 'Case Approved',
                'Notif_Text'  => 'Case ' . $case->Case_No . ' approved by ' . $user->Fullname,
                'Notif_IsRead' => 'N',
                'Notif_From'  => $user->id,
                'Notif_To'    => $case->Case_AP2, 
                'Notif_Date'  => Carbon::now(),
                'Notif_Type'  => 'BA'
            ]);
        
            return response()->json(['message' => 'Case Approved Successfully']);
        } else {
            if ($case->Case_ApStep == 1) {
                $case->Case_Status = 'REJECT';
                $case->Case_IsReject = 'Y';
                $case->Case_RejGroup = 'AP2';
                $case->Case_RejBy = $user->id;
                $case->Case_RejDate = Carbon::now();
                $case->Case_RMK1 = $notes;

                Notification::create([
                    'Notif_Title' => 'Case Rejected',
                    'Notif_Text'  => 'Case ' . $case->Case_No . ' rejected by ' . $user->Fullname,
                    'Notif_IsRead' => 'N',
                    'Notif_From'  => $user->id,
                    'Notif_To'    => $case->CR_BY,
                    'Notif_Date'  => Carbon::now(),
                    'Notif_Type'  => 'BA'
                ]);

            } elseif ($case->Case_ApStep == 2) {
                $case->Case_Status = 'REJECT';
                $case->Case_IsReject = 'Y';
                $case->Case_RejGroup = 'AP2';
                $case->Case_RejBy = $user->id;
                $case->Case_RejDate = Carbon::now();
                $case->Case_RMK2 = $notes;

                Notification::create([
                    'Notif_Title' => 'Case Rejected',
                    'Notif_Text'  => 'Case ' . $case->Case_No . ' rejected by ' . $user->Fullname,
                    'Notif_IsRead' => 'N',
                    'Notif_From'  => $user->id,
                    'Notif_To'    => $case->Case_AP1,
                    'Notif_Date'  => Carbon::now(),
                    'Notif_Type'  => 'BA'
                ]);

                Notification::create([
                    'Notif_Title' => 'Case Rejected',
                    'Notif_Text'  => 'Case ' . $case->Case_No . ' rejected by ' . $user->Fullname,
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
        
            Logs::create([
                'LOG_Type'   => 'BA',
                'LOG_RefNo'  => $case_no,
                'LOG_Status' => 'REJECTED',
                'LOG_User'   => $user->id,
                'LOG_Date'   => Carbon::now(),
                'LOG_Desc'   => 'Case Rejected by ' . $user->Fullname,
            ]);
        
            return response()->json(['message' => 'Case Rejected']);
        }
        
    }


}
