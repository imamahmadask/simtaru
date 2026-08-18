<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsurePasswordNotExpired
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            $user = auth()->user();

            if ($user->isPasswordExpired()) {
                // Rute yang dikecualikan dari pengalihan (agar user bisa ganti password & logout)
                if (
                    $request->is('user/profile*') ||
                    $request->is('user/password*') ||
                    $request->is('user/profile-information*') ||
                    $request->is('logout') ||
                    $request->is('livewire/*') ||
                    $request->routeIs('profile.show') ||
                    $request->routeIs('user-password.update') ||
                    $request->routeIs('logout')
                ) {
                    return $next($request);
                }

                session()->flash('warning', 'Masa berlaku kata sandi Anda telah habis. Silakan perbarui kata sandi Anda untuk dapat melanjutkan.');

                return redirect()->route('profile.show');
            }
        }

        return $next($request);
    }
}
