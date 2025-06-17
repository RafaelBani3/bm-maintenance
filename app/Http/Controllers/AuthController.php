<?php

namespace App\Http\Controllers;
use App\Models\Cats;
use App\Models\Subcats;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;

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


    public function showResetPasswordForm()
    {
        return view('content.auth.forgotpassword');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'Username' => 'required|string|exists:users,Username',
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::where('Username', $request->Username)->first();
        $user->Password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('password.request')->with('password_reset_success', true);
    }


}
