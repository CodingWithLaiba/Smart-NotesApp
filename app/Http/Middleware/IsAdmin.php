<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     * This middleware protects all /admin/* routes.
     * It runs BEFORE the controller method.
     */
    public function handle(Request $request, Closure $next)
    {
        // If user is not logged in, send to admin login page
        if (!Auth::check()) {
            return redirect()->route('admin.login')->with('error', 'Please login as admin.');
        }
 
        // If user is logged in but NOT an admin, deny access
        if (!Auth::user()->is_admin) {
            abort(403, 'Access denied. Admins only.');
        }
 
        // If user is admin, let the request continue normally
        return $next($request);
    }
}