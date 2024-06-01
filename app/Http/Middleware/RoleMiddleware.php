<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
{
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    $user = Auth::user();
    if (!$user->hasAnyRole($roles)) {
        return redirect()->back()->with('error', 'You do not have permission to access this page.');
    }

    return $next($request);
}

}
