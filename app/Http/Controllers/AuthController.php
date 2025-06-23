<?php

namespace App\Http\Controllers;
use App\Models\Cats;
use App\Models\Matrix;
use App\Models\Position;
use App\Models\Subcats;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

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
        $users = User::with(['roles', 'position'])->get();

        return view('content.auth.createnewuser', compact('roles', 'positions', 'users'));
    }

    public function SaveNewUser(Request $request)
    {
        $validated = $request->validate([
            'Fullname' => 'required|string|max:255',
            'Username' => 'required|string|max:255|unique:users,Username',
            'Password' => 'nullable|string|min:6',
            'roles' => 'required|array|min:1',
            'roles.*' => 'string|exists:roles,name',
            'PS_ID' => 'required|exists:positions,id',
        ]);

        $user = User::create([
            'Fullname' => $validated['Fullname'],
            'Username' => $validated['Username'],
            'Password' => Hash::make($validated['Password'] ?? 'admin123'),
            'remember_token'=> Str::random(60),
            'CR_DT' => now(),
            'PS_ID' => $validated['PS_ID'],
        ]);

        // Assign multiple roles
        $user->assignRole($validated['roles']);

        return redirect()->route('CreateNewUser')->with('success', 'User berhasil ditambahkan.');
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



























// MATRIX
    public function CreateNewMatrix()
    {
        $matrices = Matrix::with(['approver1', 'approver2', 'approver3', 'approver4', 'approver5'])->get();
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

}
