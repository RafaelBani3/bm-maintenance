<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class DBMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $db = $request->routeIs('Login.post') ? $request->db : session('db');
        if($db) {
            config(['database.connections.mysql.database'=>$db]);
            DB::purge();
        }
        return $next($request);
    }
}
