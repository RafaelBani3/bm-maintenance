<?php
namespace App\Http\Middleware;

use Illuminate\Support\Facades\Log;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class CustomAuthenticate extends Middleware
{
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {

            session()->flash('session_expired', 'Please Login first!');
            return route('login');
        }
    }
}

?>