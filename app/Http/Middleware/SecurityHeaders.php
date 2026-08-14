<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * SecurityHeaders Middleware
 *
 * Menambahkan HTTP Security Response Headers berstandar OWASP pada setiap
 * response web SIMTARU. Mencakup:
 *  - Content-Security-Policy (CSP)
 *  - X-Frame-Options
 *  - X-Content-Type-Options
 *  - Strict-Transport-Security (HSTS)
 *  - Referrer-Policy
 *  - Permissions-Policy
 *  - Cross-Origin-Opener-Policy (COOP)
 *  - Cross-Origin-Resource-Policy (CORP)
 *  - X-XSS-Protection (legacy browsers)
 *
 * Disesuaikan dengan dependensi SIMTARU: Livewire, Alpine.js, Bootstrap CDN,
 * Google Fonts, Font Bunny, Leaflet, OpenStreetMap, Google Maps, dan WhatsApp link.
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

        // ─────────────────────────────────────────────────────────────────────
        // 1. Content-Security-Policy (CSP)
        //    Disesuaikan dengan seluruh sumber aset dan CDN yang dipakai SIMTARU:
        //    - 'self'             : aset lokal (JS, CSS, gambar dari server sendiri)
        //    - 'unsafe-inline'   : Diperlukan Livewire, Alpine.js, inline style/script
        //    - 'unsafe-eval'     : Diperlukan beberapa library JS (ApexCharts, Alpine)
        //    - fonts.googleapis.com / fonts.gstatic.com / fonts.bunny.net : Google Fonts & Bunny
        //    - cdn.jsdelivr.net  : Bootstrap CSS/JS, GLightbox, Bootstrap Icons
        //    - unpkg.com         : Leaflet.js & CSS
        //    - *.tile.openstreetmap.org : Tile peta OpenStreetMap
        //    - raw.githubusercontent.com / cdnjs.cloudflare.com : Leaflet marker icons
        //    - maps.googleapis.com / maps.gstatic.com / www.google.com : Google Maps iframe & API
        //    - buttons.github.io : GitHub buttons script
        //    - wa.me              : WhatsApp links (navigasi)
        //    - drive.google.com   : Google Drive (link regulasi PDF)
        //    - geoportal.mataramkota.go.id : Geoportal Kota Mataram (link eksternal)
        //    - lapor.go.id        : Lapor SP4N (link pengaduan)
        //    - pupr.mataramkota.go.id / instagram.com : link kontak
        //    - ws: / wss:         : WebSocket Livewire
        // ─────────────────────────────────────────────────────────────────────
        $csp = implode('; ', [
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

            // Upgrade HTTP ke HTTPS (browser yang mendukung)
            "upgrade-insecure-requests",
        ]);

        // ─────────────────────────────────────────────────────────────────────
        // 2. X-Frame-Options
        //    Mencegah halaman SIMTARU di-embed oleh situs luar (Clickjacking).
        //    SAMEORIGIN = hanya boleh di-embed dari domain yang sama.
        // ─────────────────────────────────────────────────────────────────────
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

        // ─────────────────────────────────────────────────────────────────────
        // 3. X-Content-Type-Options
        //    Mencegah browser "menebak" tipe konten (MIME sniffing).
        //    Penting mencegah eksekusi file berbahaya yang di-upload.
        // ─────────────────────────────────────────────────────────────────────
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // ─────────────────────────────────────────────────────────────────────
        // 4. Strict-Transport-Security (HSTS)
        //    Memaksa browser selalu menggunakan HTTPS ke server ini.
        //    max-age=31536000 = 1 tahun. includeSubDomains agar subdomain aman.
        //    preload memungkinkan domain masuk HSTS preload list browser.
        //    CATATAN: Pastikan SSL/TLS sudah aktif di server sebelum deploy.
        // ─────────────────────────────────────────────────────────────────────
        $response->headers->set(
            'Strict-Transport-Security',
            'max-age=31536000; includeSubDomains; preload'
        );

        // ─────────────────────────────────────────────────────────────────────
        // 5. Referrer-Policy
        //    Mengontrol informasi referrer yang dikirim saat navigasi.
        //    strict-origin-when-cross-origin: kirim origin saja ke situs lain,
        //    kirim full URL hanya jika navigasi ke sesama origin.
        // ─────────────────────────────────────────────────────────────────────
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // ─────────────────────────────────────────────────────────────────────
        // 6. Permissions-Policy (Feature Policy)
        //    Menonaktifkan fitur browser yang tidak dibutuhkan SIMTARU.
        //    - camera, microphone : tidak dibutuhkan
        //    - payment            : tidak ada fitur payment
        //    - geolocation        : diizinkan hanya dari origin sendiri (peta)
        //    - fullscreen         : diizinkan untuk fullscreen peta
        //    - usb, bluetooth     : tidak dibutuhkan
        // ─────────────────────────────────────────────────────────────────────
        $response->headers->set(
            'Permissions-Policy',
            'camera=(), microphone=(), payment=(), usb=(), bluetooth=(), '
                . 'geolocation=(self), fullscreen=(self)'
        );

        // ─────────────────────────────────────────────────────────────────────
        // 7. Cross-Origin-Opener-Policy (COOP)
        //    Mengisolasi browsing context dari popup/tab asing.
        //    Melindungi dari serangan cross-origin side-channel.
        // ─────────────────────────────────────────────────────────────────────
        $response->headers->set('Cross-Origin-Opener-Policy', 'same-origin-allow-popups');

        // ─────────────────────────────────────────────────────────────────────
        // 8. Cross-Origin-Resource-Policy (CORP)
        //    Mengontrol resource milik SIMTARU yang boleh di-load oleh situs lain.
        //    same-origin: hanya halaman dari origin yang sama yang boleh load resource.
        // ─────────────────────────────────────────────────────────────────────
        $response->headers->set('Cross-Origin-Resource-Policy', 'same-origin');

        // ─────────────────────────────────────────────────────────────────────
        // 9. X-XSS-Protection (legacy, untuk browser lama seperti IE/Edge lama)
        //    Mengaktifkan filter XSS bawaan browser.
        //    Nilai "1; mode=block" menginstruksikan browser memblok halaman jika
        //    terdeteksi serangan XSS, bukan me-render dengan filter.
        // ─────────────────────────────────────────────────────────────────────
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        // ─────────────────────────────────────────────────────────────────────
        // 10. Content-Security-Policy (terapkan setelah build string)
        // ─────────────────────────────────────────────────────────────────────
        $response->headers->set('Content-Security-Policy', $csp);

        // ─────────────────────────────────────────────────────────────────────
        // 11. Hapus header yang membocorkan informasi server
        //     Header "Server" dan "X-Powered-By" sering dieksploitasi untuk
        //     fingerprinting teknologi yang digunakan aplikasi.
        // ─────────────────────────────────────────────────────────────────────
        $response->headers->remove('X-Powered-By');
        $response->headers->remove('Server');

        return $response;
    }
}
