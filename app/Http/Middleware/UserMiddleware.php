<?php

namespace App\Http\Middleware;

use Closure;
use Error;
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
    public function handle(Request $request, Closure $next, ...$permission): Response
    {
        if (!Auth::check()) {
        Log::warning('User not logged in, redirecting to login page');

        return redirect()
            ->route('Login.page')
            ->with('error', 'You must login first.');
        }

        // $userRole = DB::table('model_has_roles')
        //     ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
        //     ->where('model_has_roles.model_id', $user->id)
        //     ->value('roles.name');
            
        // if (!$userRole || !in_array($userRole, $roles)) {
        //     Log::warning("Role mismatch for user: {$user->Fullname}. Required role: " . implode(', ', $roles));

        //     return redirect()->back()->with('error', 'You dont have access to this page.');
        // }

        /** @var \App\Models\User $user */
        $user = Auth::user();

        $permission = $permissions[0] ?? null;

        if (!$permission) {
            return $next($request);
        }

        Log::info("Middleware triggered for user: {$user->Fullname}");

        if (!$user->can($permission)) {
            Log::warning("Permission check failed: {$permission}");
            return redirect()->back()->with('error', 'You do not have access to this page.');
        }

        Log::info("Permission check passed for: {$permission}");

        $roles = $user->getRoleNames()->implode(', ');
        Log::info("Access granted for user: {$user->Fullname} with roles: {$roles}");

        return $next($request);
    }
}

