<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed ...$roles
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Ambil user yang lagi login
        $user = $request->user();

        // Kalau belum login → arahkan ke halaman login
        if (! $user) {
            return redirect()->route('login');
        }

        // Role user di-LOWERCASE biar "Admin" & "admin" dianggap sama
        $userRole = strtolower($user->role ?? '');

        // Role yang diizinkan dari middleware (role:admin,staff,dll)
        // juga kita turunin ke lowercase semua
        $allowedRoles = array_map('strtolower', $roles);

        // Kalau role user tidak ada di daftar yang diizinkan → 403
        if (! in_array($userRole, $allowedRoles, true)) {
            abort(403, 'Unauthorized.');
        }

        // Lolos semua cek → lanjut ke request berikutnya
        return $next($request);
    }
}
