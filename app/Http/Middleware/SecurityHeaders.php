<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * SecurityHeaders Middleware
 *
 * Menambahkan HTTP Security Response Headers berstandar OWASP pada setiap
 * response web SIMTARU.
 */
class SecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $cspRules = [
            "default-src 'self'",

            // Skrip: self, inline (Livewire/Alpine), eval (ApexCharts), CDN
            "script-src 'self' 'unsafe-inline' 'unsafe-eval' "
                . "cdn.jsdelivr.net unpkg.com cdnjs.cloudflare.com "
                . "raw.githubusercontent.com buttons.github.io "
                . "maps.googleapis.com maps.gstatic.com",

            // Stylesheet: self, inline, Google Fonts, Font Bunny, Bootstrap, Leaflet
            "style-src 'self' 'unsafe-inline' "
                . "fonts.googleapis.com cdn.jsdelivr.net "
                . "unpkg.com cdnjs.cloudflare.com fonts.bunny.net",

            // Gambar: self, data URI, blob, dan semua CDN gambar peta & aset
            "img-src 'self' data: blob: "
                . "*.tile.openstreetmap.org "
                . "raw.githubusercontent.com cdnjs.cloudflare.com "
                . "maps.googleapis.com maps.gstatic.com "
                . "cdn.jsdelivr.net unpkg.com",

            // Font: self, Google Fonts, Font Bunny, CDN
            "font-src 'self' "
                . "fonts.googleapis.com fonts.gstatic.com "
                . "fonts.bunny.net cdn.jsdelivr.net",

            // Koneksi: self + WebSocket Livewire + tile OSM + Google Maps API
            "connect-src 'self' ws: wss: "
                . "*.tile.openstreetmap.org "
                . "maps.googleapis.com",

            // Frame/iframe: self dan Google Maps embed saja
            "frame-src 'self' www.google.com",

            // Mencegah situs lain embed SIMTARU (Clickjacking)
            "frame-ancestors 'self'",

            // Media: hanya dari server sendiri
            "media-src 'self'",

            // Object/plugin: tidak diizinkan
            "object-src 'none'",

            // Worker (service worker): hanya dari server sendiri
            "worker-src 'self' blob:",

            // Form action: hanya submit ke server sendiri
            "form-action 'self'",
        ];

        // Upgrade HTTP ke HTTPS & HSTS HANYA jika request menggunakan HTTPS (mencegah error 419 Page Expired di environment HTTP/lokal)
        if ($request->isSecure()) {
            $cspRules[] = "upgrade-insecure-requests";

            $response->headers->set(
                'Strict-Transport-Security',
                'max-age=31536000; includeSubDomains; preload'
            );
        }

        $csp = implode('; ', $cspRules);

        // Standard OWASP Security Headers
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set(
            'Permissions-Policy',
            'camera=(), microphone=(), payment=(), usb=(), bluetooth=(), '
                . 'geolocation=(self), fullscreen=(self)'
        );
        $response->headers->set('Cross-Origin-Opener-Policy', 'same-origin-allow-popups');
        $response->headers->set('Cross-Origin-Resource-Policy', 'same-origin');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('Content-Security-Policy', $csp);

        // Hapus header fingerprinting
        $response->headers->remove('X-Powered-By');
        $response->headers->remove('Server');

        return $response;
    }
}
