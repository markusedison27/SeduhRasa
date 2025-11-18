<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string ...$guards
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();

                if ($user->role === 'super_admin') {
                    return redirect()->route('super.dashboard');
                } elseif ($user->role === 'owner') {
                    return redirect()->route('owner.dashboard');
                } elseif ($user->role === 'staff') {
                    return redirect()->route('staff.dashboard');
                }

                // fallback kalau role ga dikenali
                return redirect('/');
            }
        }

        // kalau BELUM login, lanjut ke /login
        return $next($request);
    }
}
