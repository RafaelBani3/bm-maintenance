<?php

namespace App\Http\Controllers;

use App\Models\Cases;
use App\Models\Cats;
use App\Models\Imgs;
use App\Models\Subcats;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use League\CommonMark\Extension\Footnote\Node\Footnote;

class CaseController extends Controller
{
    // View Cases Create Page
    public function CreateCase(){   
        $listCategory = Cats::all();
        $listSubCategory = Subcats::all();

        return view('content.case.CreateCase', compact('listCategory', 'listSubCategory'));
    }

    // Method untuk mengambil subkategori berdasarkan Cat_No
    public function getSubCategories($cat_no)
    {
        $subCategories = Subcats::where('Cat_No', $cat_no)->get();
        return response()->json($subCategories);
    }

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
            'photos.*' => 'image|mimes:jpeg,png,jpg|max:1048',
        ]);

        if ($validator->fails()) {
            Log::warning('Validation failed', ['errors' => $validator->errors()]);
            return response()->json(['errors' => $validator->errors()], 422);
        }

        Log::info('Validation successful');
        return response()->json(['success' => true]);
    }


    // Create Case Save Controller
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
            'photos.*' => 'required|image|mimes:jpeg,png,jpg|max:1048',
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

            // // **4. Simpan Foto Jika Ada**
            // if ($request->hasFile('photos')) {
            //     foreach ($request->file('photos') as $photo) {
            //         // **Generate Nama File Random**
            //         $randomFileName = Str::uuid() . '.' . $photo->getClientOriginalExtension();

            //         // **Simpan ke Storage**
            //         $photo->storeAs('case_photos', $randomFileName, 'public');

                    
            //         // **Simpan Data ke Tabel imgs**
            //         Imgs::create([
            //             'IMG_No' => Imgs::generateImgNo(),
            //             'IMG_Type' => 'BA', 
            //             'IMG_RefNo' => $case->Case_No, 
            //             'IMG_Filename' => $randomFileName, 
            //             'IMG_Realname' => $photo->getClientOriginalName(), 
            //         ]);

            //         Log::info('Photo uploaded', [
            //             'case_no' => $case->Case_No,
            //             'file_name' => $randomFileName
            //         ]);
            //     }
            // }

            // if ($request->hasFile('photos')) {
            //     $caseNo = str_replace(['/', '\\'], '-', $case->Case_No); // Hindari karakter tidak valid
            //     $directory = "case_photos/$caseNo";
            
            //     if (!Storage::exists($directory)) {
            //         Storage::makeDirectory($directory);
            //     }
            
            //     $uploadedPaths = [];
            //     foreach ($request->file('photos') as $photo) {
            //         $newFileName = "case_" . time() . "_" . uniqid() . "." . $photo->getClientOriginalExtension();
            //         $path = $photo->storeAs($directory, $newFileName, 'public');
            //         $uploadedPaths[] = $path;
            
            //         // **Simpan Data ke Tabel imgs**
            //         Imgs::create([
            //             'IMG_No' => Imgs::generateImgNo(),
            //             'IMG_Type' => 'BA',
            //             'IMG_RefNo' => $case->Case_No,
            //             'IMG_Filename' => $newFileName,
            //             'IMG_Realname' => $photo->getClientOriginalName(),
            //         ]); 
            //     }
            
            //     Log::info('Photos uploaded', [
            //         'case_no' => $case->Case_No,
            //         'files' => $uploadedPaths
            //     ]);
            // }

            $uploadedPaths = [];
            if ($request->hasFile('photos')) {
                $caseNo = str_replace(['/','\\'],'-', $case->Case_No);
                $directory = "case_photos/$caseNo";
                    if (!Storage::exists($directory)) {
                        Storage::makeDirectory($directory);
                    }
                
                    foreach($request->file('photos') as $photo){
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

                // $case->photos = json_encode($uploadedPaths);
                // $case->save();

                Log::info('Photos uploaded', [
                    'case_no' => $case->Case_No,
                    'files' => $uploadedPaths
                ]);
            }
                
            Log::info('Case creation completed successfully', ['case_no' => $case->Case_No]);
            // return redirect()->back()->with('success', 'Case created successfully.');
            return response()->json([
                'success' => true,
                'message' => 'Case created successfully.',
                'case_no' => $case->Case_No
            ]);
        } catch (\Exception $e) {
            Log::error('Error saving case', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Failed to create case.');
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
            $case->save();
    
            Log::info('UpdateCase: Case berhasil diperbarui', ['case_no' => $request->case_no]);
    
            // Handle Image Updates
            if ($request->hasFile('new_images')) {
                foreach ($request->file('new_images') as $img_no => $image) {
                    $existingImage = Imgs::where('IMG_No', $img_no)->first();
                    if ($existingImage) {
                        Log::info('UpdateCase: Mengupdate gambar', ['IMG_No' => $img_no]);
    
                        Storage::delete('public/case_photos/' . $existingImage->IMG_RefNo . '/' . $existingImage->IMG_Filename);
    
                        $newFilename = time() . '-' . $image->getClientOriginalName();
                        $image->storeAs('public/case_photos/' . $existingImage->IMG_RefNo, $newFilename);
    
                        $existingImage->IMG_Filename = $newFilename;
                        $existingImage->IMG_Realname = $image->getClientOriginalName();
                        $existingImage->save();
    
                        Log::info('UpdateCase: Gambar berhasil diperbarui', ['IMG_No' => $img_no, 'filename' => $newFilename]);
                    } else {
                        Log::warning('UpdateCase: Gambar tidak ditemukan', ['IMG_No' => $img_no]);
                    }
                }
            }
    
            return redirect()->route('CreateCase')->with('success', 'Case updated successfully!');
        } catch (\Exception $e) {
            Log::error('UpdateCase: Terjadi kesalahan saat update case', [
                'case_no' => $request->case_no,
                'error' => $e->getMessage()
            ]);
    
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
    
    // View List BA/CR Page
    public function viewListBA(){
        return view('content.case.ListCases');
    }

    public function getCases()
    {
        $cases = Cases::select(
            'cases.Case_No',
            'cases.Case_Name',
            'cases.Case_Date',
            'cases.Cat_No',
            'Cats.Cat_Name as Category',
            'cases.CR_BY',
            'Users.Fullname as User'
        )
        ->leftJoin('Cats', 'cases.Cat_No', '=', 'Cats.Cat_No')
        ->leftJoin('Users', 'cases.CR_BY', '=', 'Users.id')
        ->get();           
        
        return response()->json($cases);
    }

    public function ApprovalListPage()
    {
        return view('content.case.ApprovalList');
    }

    public function getApprovalCases(Request $request){
        $sortBy = $request->get('sortBy', 'created_at'); 
        $sortOrder = $request->get('sortOrder', 'asc');

        $CasePendingApproval = Cases::where('Case_Status', 'OPEN')
            ->with('user')
            ->orderBy($sortBy, $sortOrder)
            ->paginate(5);

        return response()->json($CasePendingApproval);
    }

    // public function show(Request $request)
    // {
    //     // $decoded_Case_No = urldecode($Case_No);

    //     $case_no = $request->query('case_no');
    //     $case = Cases::where('Case_No', $case_no)->firstOrFail();

    //     // $images = DB::table('imgs')->where('IMG_RefNo', $decoded_Case_No)->get();

    //     return view('content.case.DetailsCases', compact('case'));
    // }

    public function show($Case_No)
    {
        $decoded_case_no = urldecode($Case_No); 
    
        $case = Cases::where('Case_No', $decoded_case_no)->firstOrFail();
    
        $images = DB::table('imgs')->where('IMG_RefNo', $decoded_case_no)->get();
    
        return view('content.case.DetailsCases', compact('case', 'images'));
    }
    

  
}
