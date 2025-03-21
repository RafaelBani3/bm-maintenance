<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            session()->flash('error', 'Anda harus login terlebih dahulu.');
            Log::warning('User not logged in, redirecting to login page');
            return redirect('/Login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user();

        // Ambil role pengguna berdasarkan model_id di tabel model_has_roles
        $userRole = DB::table('model_has_roles')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->where('model_has_roles.model_id', $user->id)
            ->value('roles.name'); 
            
        if (!$userRole || !in_array($userRole, $roles)) {
            session()->flash('error', 'Anda tidak memiliki izin untuk mengakses halaman ini.');
            Log::warning('Role mismatch for user: ' . $user->username . '. Required role: ' . implode(', ', $roles));
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        Log::info('Role verified for user: ' . $user->username . '. Allowed access.');
        return $next($request);
    }
}

