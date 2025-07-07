<?php

namespace App\Http\Controllers;
use App\Models\Cats;
use App\Models\Matrix;
use App\Models\Position;
use App\Models\Subcats;
use App\Models\technician;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class AuthController extends Controller
{
       // View Login Page
    public function LoginPage(){
        return View('content.auth.Login');
    }

    // Authentikasi Login
    public function LoginCheck(Request $request){
        // Validasi Input

        // Log Request Data (Kecuali Password)
        Log::info('Login Attempt', ['Username' => $request->Username]);
        $listCategory = Cats::all();
        $listSubCategory = Subcats::all();

        $request->validate([
            'Username' => 'required',
            'Password' => 'required|min:5',
        ]);

        $user = User::where('Username', $request->Username)->first();
        // Log Validasi Berhasil
        Log::info('Validation Passed', ['Username' => $user]);
        if ($user) {
            Log::info('User Found', ['id' => $user->id]);   
        } else {
            Log::warning('User Not Found', ['Username' => $request->Username]);
        }

        if ($user && Hash::check($request->Password, $user->Password)) {
            $request->session()->regenerate();
            Auth::guard('web')->login($user);   
            
            Log::info('Login Success', ['id' => $user->id]);

            return redirect()->route('Dashboard');

        } else {
            Log::warning('Login Failed', ['Username' => $request->Username]);

            return redirect()->back()->withErrors([
                'Username' => 'Username or Password is Incorrect!',
            ])->withInput();
        }
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Logout Berhasil!');
    }

    public function showChangePasswordForm()
    {
        return view('content.auth.changepassword');
    }


       public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = Auth::user();

        // Validasi password lama
        if (!Hash::check($request->current_password, $user->Password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }

        // Update password langsung via DB query builder
        DB::table('users')
            ->where('id', $user->id)
            ->update(['Password' => Hash::make($request->new_password)]);

        return redirect()->route('changepasswordpage')->with('success', 'Password updated successfully.');
    }


    public function CreateUser()
    {
        $roles = Role::all();
        $positions = Position::all();
        $users = User::with(['roles', 'position'])
        ->latest()
        ->get();

        return view('content.auth.createnewuser', compact('roles', 'positions', 'users'));
    }

    // public function SaveNewUser(Request $request)
    // {
    //     $validated = $request->validate([
    //         'Fullname' => 'required|string|max:255',
    //         'Username' => 'required|string|max:255|unique:users,Username',
    //         'Password' => 'nullable|string|min:6',
    //         'roles' => 'required|array|min:1',
    //         'roles.*' => 'string|exists:roles,name',
    //         'PS_ID' => 'required|exists:Positions,id',
    //     ]);

    //     $user = User::create([
    //         'Fullname' => $validated['Fullname'],
    //         'Username' => $validated['Username'],
    //         'Password' => Hash::make($validated['Password'] ?? 'admin123'),
    //         'remember_token'=> Str::random(60),
    //         'CR_DT' => now(),
    //         'PS_ID' => $validated['PS_ID'],
    //     ]);

    //     // Assign multiple roles
    //     $user->assignRole($validated['roles']);

    //     return redirect()->route('CreateNewUser')->with('success', 'User berhasil ditambahkan.');
    // }

    
    public function SaveNewUser(Request $request)
    {
        try {
            // Validasi dasar (Username boleh sama asal tidak sama PS_ID)
            $validated = $request->validate([
                'Fullname' => 'required|string|max:255',
                'Username' => 'required|string|max:255|unique:users,Username',
                'Password' => 'nullable|string|min:6',
                'roles' => 'required|array|min:1',
                'roles.*' => 'string|exists:roles,name',
                'PS_ID' => 'required|exists:Positions,id',
            ]);

            // Cek apakah kombinasi Username + Position sudah ada
            $exists = User::where('Username', $validated['Username'])
                ->where('PS_ID', $validated['PS_ID'])
                ->exists();

            if ($exists) {
                return redirect()->back()
                    ->withInput()
                    ->with('duplicate_user', true);
            }

            // Simpan user baru
            $user = User::create([
                'Fullname' => $validated['Fullname'],
                'Username' => $validated['Username'],
                'Password' => Hash::make($validated['Password'] ?? 'admin123'),
                'remember_token'=> Str::random(60),
                'CR_DT' => now(),
                'PS_ID' => $validated['PS_ID'],
            ]);

            // Assign roles
            $user->assignRole($validated['roles']);

            return redirect()->route('CreateNewUser')->with('success', 'User berhasil ditambahkan.');
        
        } catch (ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('validation_error', true);
        }
    }

    public function EditUser($id)
    {
        $user = User::with('position', 'roles')->findOrFail($id);
        $positions = Position::select('id', 'PS_Name')->get();
        $roles = Role::all(); 

        return view('content.auth.edituser', compact('user', 'positions', 'roles'));
    }

    public function UpdateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $user->update([
            'Fullname' => $request->Fullname,
            'Username' => $request->Username,
            'PS_ID' => $request->Position,
        ]);

        if ($request->has('roles')) {
            $user->syncRoles($request->roles);
        }

        return redirect()->route('CreateNewUser')->with('success', 'User updated successfully.');
    }

    public function DeleteUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Cek agar user tidak bisa menghapus dirinya sendiri
        if ($request->user()->is($user)) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return back()->with('success', 'User deleted successfully.');
    }

// MATRIX
    public function CreateNewMatrix()
    {
        $matrices = Matrix::with(['approver1', 'approver2', 'approver3', 'approver4', 'approver5'])
        ->latest()
        ->get();
        $users = User::select('id', 'Fullname')->get();
        $positions = Position::all();

        return view('content.matrix.creatematrix', compact('matrices', 'users','positions'));
    }

    public function SaveMatrix(Request $request)
    {
        $validated = $request->validate([
            'Position' => 'required|string|max:255',
            'Mat_Type' => 'required|in:CR,MR,WO',
            'Mat_Max' => 'required|integer|min:1',
            'AP1' => 'nullable|exists:users,id',
            'AP2' => 'nullable|exists:users,id',
            'AP3' => 'nullable|exists:users,id',
            'AP4' => 'nullable|exists:users,id',
            'AP5' => 'nullable|exists:users,id',
        ]);

        $matrix = Matrix::create($validated);

        return redirect()->route('CreateNewMatrix')->with('success', 'Matrix added successfully.');
    }

    public function EditMatrix($id)
    {
        $matrix = Matrix::with(['approver1', 'approver2', 'approver3', 'approver4'])->findOrFail($id);
        $users = User::select('id', 'Fullname')->get();
        $positions = Position::all();

        return view('content.matrix.editmatrix', compact('matrix', 'users', 'positions'));
    }

    public function UpdateMatrix(Request $request, $id)
    {
        $request->validate([
            'Position' => 'required|string',
            'Mat_Type' => 'required|in:CR,MR,WO',
            'Mat_Max' => 'required|integer|min:1|max:5',
        ]);

        $matrix = Matrix::findOrFail($id);
        $matrix->Position = $request->Position;
        $matrix->Mat_Type = $request->Mat_Type;
        $matrix->Mat_Max = $request->Mat_Max;
        $matrix->AP1 = $request->AP1;
        $matrix->AP2 = $request->AP2;
        $matrix->AP3 = $request->AP3;
        $matrix->AP4 = $request->AP4;
        $matrix->AP5 = null; 
        $matrix->save();

        return redirect()->route('CreateNewMatrix')->with('success', 'Matrix updated successfully.');
    }


    public function DeleteMatrix($mat_no)
    {
        $matrix = Matrix::where('Mat_No', $mat_no)->firstOrFail();

        $matrix->delete();

        return redirect()->back()->with('success', 'Matrix Successfully Deleted.');
    }




// CRUD POSITION
    public function PositionPage()
    {
        $positions = Position::latest()->get();
        return view('content.auth.position.createposition', compact('positions'));
    }

    public function SavePosition(Request $request)
    {
        $request->validate([
            'PS_Name' => 'required|string|max:255',
            'PS_Desc' => 'nullable|string|max:500',
        ]);

        Position::create($request->only('PS_Name', 'PS_Desc'));

        return back()->with('success', 'Position created successfully.');
    }

    public function EditPosition($id)
    {
        return Position::findOrFail($id);
    }

    public function UpdatePosition(Request $request, $id)
    {
        $request->validate([
            'PS_Name' => 'required|string|max:255',
            'PS_Desc' => 'nullable|string|max:500',
        ]);

        $position = Position::findOrFail($id);
        $position->update($request->only('PS_Name', 'PS_Desc'));

        return back()->with('success', 'Position updated successfully.');
    }

    public function DeletePosition($id)
    {
        Position::findOrFail($id)->delete();
        return back()->with('success', 'Position deleted successfully.');
    }


// CATEGORY
    public function CategoryPage(){
        $category = Cats::latest()->get();
        $subcategory = Subcats::latest()->get();
        // $subcategory = Subcats::orderBy('created_at', 'desc')->get();

        return view('content.auth.category.createcategory', compact('category', 'subcategory'));
    }

    public function SaveCategory(Request $request)
    {
        $request->validate([
            'Cat_Name' => 'required|string|max:255',
            'Cat_Desc' => 'nullable|string|max:500',
        ]);

        Cats::create($request->only('Cat_Name', 'Cat_Desc'));

        return back()->with('success', 'Category created successfully.');
    }


    public function UpdateCategory(Request $request, $id)
    {
        $request->validate([
            'Cat_Name' => 'required|string|max:255',
            'Cat_Desc' => 'nullable|string|max:255',
        ]);

        Cats::where('Cat_No', $id)->update([
            'Cat_Name' => $request->Cat_Name,
            'Cat_Desc' => $request->Cat_Desc,
            'updated_at' => now(),  
        ]);

        return redirect()->route('CategoryPage')->with('success', 'Category updated successfully.');
    }

    public function DeleteCategory($id)
    {
        try {
            Cats::where('Cat_No', $id)->delete();
            return response()->json(['status' => 'success', 'message' => 'Category deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Failed to delete category.']);
        }
    }


    // --- SUBCATEGORY ---

    // public function SubCategoryPage()
    // {
    //     $subcategory = Subcats::with('category')->orderByDesc('created_at')->get();
    //     return view('pages.subcategory', compact('subcategory'));
    // }

    public function SubSaveCategory(Request $request)
    {
        $request->validate([
            'Cat_No' => 'required|exists:Cats,Cat_No',
            'Scat_Name' => 'required|string|max:255',
            'Scat_Desc' => 'nullable|string|max:255',
        ]);

        Subcats::create([
            'Scat_No' => strtoupper(Str::random(10)),
            'Cat_No' => $request->Cat_No,
            'Scat_Name' => $request->Scat_Name,
            'Scat_Desc' => $request->Scat_Desc,
        ]);

        return redirect()->route('CategoryPage')->with('success', 'Sub-category created successfully.');
    }

    public function SubUpdateCategory(Request $request, $id)
    {
        $request->validate([
            'Cat_No' => 'nullable|string|max:255',
            'Scat_Name' => 'required|string|max:255',
            'Scat_Desc' => 'nullable|string|max:255',
        ]);

        Subcats::where('Scat_No', $id)->update([
            'Cat_No' => $request->Cat_No,
            'Scat_Name' => $request->Scat_Name,
            'Scat_Desc' => $request->Scat_Desc,
            'updated_at' => now(),
        ]);

        return redirect()->route('CategoryPage')->with('success', 'Sub-category updated successfully.');
    }

    public function SubDeleteCategory($id)
    {
        // Subcats::where('Scat_No', $id)->delete();
        // return redirect()->route('SubCategoryPage')->with('success', 'Sub-category deleted successfully.');
        try {
            Subcats::where('Scat_No', $id)->delete();
            return response()->json(['status' => 'success', 'message' => 'Sub-Category deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Failed to delete sub-category.']);
        }
    }



    // TECNICIAN
    public function TechnicianPage(){
        $technicians = Technician::with('position')->latest()->get();
        $positions = Position::latest()->get();

        return view('content.auth.teknisi.createteknisi', compact('technicians','positions'));
    }

    public function SaveTechnician(Request $request)
    {
        $request->validate([
            'Technician_Name' => 'required|string|max:255',
            'Position_ID' => 'required|exists:positions,id',
        ]);

       $technician = new Technician();
        $technician_id = $technician->getIncrementTechnicianNo();

        Technician::create([
            'technician_id' => $technician_id,
            'technician_Name' => $request->Technician_Name,
            'PS_ID' => $request->Position_ID,
        ]);

        return back()->with('success', 'Technician created successfully.');
    }

    public function UpdateTechnician(Request $request, $id)
    {
        $request->validate([
            'Technician_Name' => 'required|string|max:255',
            'Position_ID' => 'required|exists:positions,id',
        ]);

        $technician = Technician::where('technician_id', $id)->firstOrFail();

        $technician->update([
            'technician_Name' => $request->Technician_Name,
            'PS_ID' => $request->Position_ID,
        ]);

        return redirect()->back()->with('success', 'Technician updated successfully.');
    }



    public function DeleteTechnician($id)
    {
        try {
            technician::where('technician_id', $id)->delete();

            // RETURN JSON, JANGAN REDIRECT
            return response()->json([
                'status' => 'success',
                'message' => 'Technician deleted successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete Technician.',
                'error' => $e->getMessage()
            ], 500); // Kirim status 500 supaya ketahuan error
        }
    }






}
