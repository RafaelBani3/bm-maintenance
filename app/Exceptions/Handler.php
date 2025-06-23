<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Session\TokenMismatchException;

class Handler extends ExceptionHandler
{
    public function register(): void
    {
        $this->renderable(function (UnauthorizedException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json(['message' => $e->getMessage()], 403);
            }
            return redirect()->back()->with('error', $e->getMessage());
        });

        // Handle Session Expired (CSRF Token mismatch)
        $this->renderable(function (TokenMismatchException $e, $request) {
            return redirect()->route('login')->withErrors([
                'message' => 'Your session has expired. Please login again.',
            ]);
        });
    }

    // Redirect to login if not authenticated
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest(route('login'))->withErrors([
            'message' => 'You need to login to access this page.',
        ]);
    }
}
