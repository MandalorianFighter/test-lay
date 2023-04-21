<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;

class ApprovalMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->user() && !(auth()->user()->approved || auth()->user()->is_admin)) {
            Session::flush();
            return redirect()->route('login')->with(['message' => 'Your Account Needs Admin Approval!']);
        }
        return $next($request);
    }
}




