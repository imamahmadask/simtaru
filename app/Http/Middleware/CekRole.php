<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CekRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Cek apakah user sudah login dan memiliki salah satu role yang diizinkan
        if ($request->user() && in_array($request->user()->role, $roles)) {
            return $next($request);
        }

        // 2. Jika tidak punya akses, arahkan secara dinamis berdasarkan role mereka
        $userRole = $request->user()->role;

        if ($userRole === 'admin-pelanggaran' || $userRole === 'superadmin') {
            return redirect()->route('pelanggaran.dashboard');
        }

        // Default redirect untuk admin atau role lainnya
        return redirect('/admin/dashboard');
    }
}
