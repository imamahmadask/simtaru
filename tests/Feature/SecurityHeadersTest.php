<?php

namespace Tests\Feature;

use Tests\TestCase;

/**
 * SecurityHeadersTest
 *
 * Menguji secara otomatis bahwa seluruh Security HTTP Headers wajib
 * berstandar OWASP telah aktif pada response SIMTARU.
 *
 * Header yang diuji:
 *   - Content-Security-Policy
 *   - X-Frame-Options
 *   - X-Content-Type-Options
 *   - Referrer-Policy
 *   - Permissions-Policy
 *   - Strict-Transport-Security
 *   - Cross-Origin-Opener-Policy
 *   - Cross-Origin-Resource-Policy
 *   - X-XSS-Protection
 *
 * Jalankan dengan: php artisan test --filter=SecurityHeadersTest
 */
class SecurityHeadersTest extends TestCase
{
    // ─────────────────────────────────────────────────────────────────────────
    // Helper: ambil response dari halaman utama
    // ─────────────────────────────────────────────────────────────────────────
    private function getHomeResponse()
    {
        return $this->get('/');
    }

    // ─────────────────────────────────────────────────────────────────────────
    // 1. Content-Security-Policy
    // ─────────────────────────────────────────────────────────────────────────
    public function test_response_has_content_security_policy_header(): void
    {
        $response = $this->getHomeResponse();
        $response->assertHeader('Content-Security-Policy');
    }

    public function test_csp_header_contains_default_src_self(): void
    {
        $response = $this->getHomeResponse();
        $csp = $response->headers->get('Content-Security-Policy');
        $this->assertStringContainsString("default-src 'self'", $csp,
            'CSP header harus mengandung "default-src \'self\'"');
    }

    public function test_csp_header_contains_object_src_none(): void
    {
        $response = $this->getHomeResponse();
        $csp = $response->headers->get('Content-Security-Policy');
        $this->assertStringContainsString("object-src 'none'", $csp,
            'CSP header harus melarang semua plugin/object (object-src: none)');
    }

    public function test_csp_header_contains_form_action_self(): void
    {
        $response = $this->getHomeResponse();
        $csp = $response->headers->get('Content-Security-Policy');
        $this->assertStringContainsString("form-action 'self'", $csp,
            'CSP header harus membatasi form action ke self saja');
    }

    public function test_csp_header_contains_frame_ancestors_self(): void
    {
        $response = $this->getHomeResponse();
        $csp = $response->headers->get('Content-Security-Policy');
        $this->assertStringContainsString("frame-ancestors 'self'", $csp,
            'CSP header harus memblok embedding oleh situs eksternal');
    }

    public function test_csp_header_allows_cdn_jsdelivr(): void
    {
        $response = $this->getHomeResponse();
        $csp = $response->headers->get('Content-Security-Policy');
        $this->assertStringContainsString('cdn.jsdelivr.net', $csp,
            'CSP harus mengizinkan Bootstrap CDN (cdn.jsdelivr.net)');
    }

    public function test_csp_header_allows_unpkg_for_leaflet(): void
    {
        $response = $this->getHomeResponse();
        $csp = $response->headers->get('Content-Security-Policy');
        $this->assertStringContainsString('unpkg.com', $csp,
            'CSP harus mengizinkan Leaflet dari unpkg.com');
    }

    public function test_csp_header_allows_google_fonts(): void
    {
        $response = $this->getHomeResponse();
        $csp = $response->headers->get('Content-Security-Policy');
        $this->assertStringContainsString('fonts.googleapis.com', $csp,
            'CSP harus mengizinkan Google Fonts');
    }

    public function test_csp_header_allows_openstreetmap_tiles(): void
    {
        $response = $this->getHomeResponse();
        $csp = $response->headers->get('Content-Security-Policy');
        $this->assertStringContainsString('*.tile.openstreetmap.org', $csp,
            'CSP harus mengizinkan tile peta OpenStreetMap');
    }

    public function test_csp_header_allows_google_maps_frame(): void
    {
        $response = $this->getHomeResponse();
        $csp = $response->headers->get('Content-Security-Policy');
        $this->assertStringContainsString('www.google.com', $csp,
            'CSP harus mengizinkan iframe Google Maps');
    }

    public function test_csp_header_allows_websocket_for_livewire(): void
    {
        $response = $this->getHomeResponse();
        $csp = $response->headers->get('Content-Security-Policy');
        $this->assertStringContainsString('ws:', $csp,
            'CSP harus mengizinkan WebSocket (ws:) untuk Livewire');
        $this->assertStringContainsString('wss:', $csp,
            'CSP harus mengizinkan WebSocket aman (wss:) untuk Livewire');
    }

    // ─────────────────────────────────────────────────────────────────────────
    // 2. X-Frame-Options (Clickjacking protection)
    // ─────────────────────────────────────────────────────────────────────────
    public function test_response_has_x_frame_options_header(): void
    {
        $response = $this->getHomeResponse();
        $response->assertHeader('X-Frame-Options', 'SAMEORIGIN');
    }

    // ─────────────────────────────────────────────────────────────────────────
    // 3. X-Content-Type-Options (MIME sniffing protection)
    // ─────────────────────────────────────────────────────────────────────────
    public function test_response_has_x_content_type_options_header(): void
    {
        $response = $this->getHomeResponse();
        $response->assertHeader('X-Content-Type-Options', 'nosniff');
    }

    // ─────────────────────────────────────────────────────────────────────────
    // 4. Referrer-Policy
    // ─────────────────────────────────────────────────────────────────────────
    public function test_response_has_referrer_policy_header(): void
    {
        $response = $this->getHomeResponse();
        $response->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
    }

    // ─────────────────────────────────────────────────────────────────────────
    // 5. Permissions-Policy
    // ─────────────────────────────────────────────────────────────────────────
    public function test_response_has_permissions_policy_header(): void
    {
        $response = $this->getHomeResponse();
        $response->assertHeader('Permissions-Policy');
    }

    public function test_permissions_policy_disables_camera_and_microphone(): void
    {
        $response = $this->getHomeResponse();
        $policy = $response->headers->get('Permissions-Policy');
        $this->assertStringContainsString('camera=()', $policy,
            'Permissions-Policy harus menonaktifkan kamera');
        $this->assertStringContainsString('microphone=()', $policy,
            'Permissions-Policy harus menonaktifkan mikrofon');
    }

    // ─────────────────────────────────────────────────────────────────────────
    // 6. Strict-Transport-Security (HSTS)
    // ─────────────────────────────────────────────────────────────────────────
    public function test_response_has_strict_transport_security_header(): void
    {
        $response = $this->getHomeResponse();
        $response->assertHeader('Strict-Transport-Security');
    }

    public function test_hsts_header_has_required_max_age(): void
    {
        $response = $this->getHomeResponse();
        $hsts = $response->headers->get('Strict-Transport-Security');
        $this->assertStringContainsString('max-age=31536000', $hsts,
            'HSTS harus memiliki max-age minimal 1 tahun (31536000 detik)');
        $this->assertStringContainsString('includeSubDomains', $hsts,
            'HSTS harus mencakup seluruh subdomain');
    }

    // ─────────────────────────────────────────────────────────────────────────
    // 7. Cross-Origin-Opener-Policy (COOP)
    // ─────────────────────────────────────────────────────────────────────────
    public function test_response_has_cross_origin_opener_policy_header(): void
    {
        $response = $this->getHomeResponse();
        $response->assertHeader('Cross-Origin-Opener-Policy', 'same-origin-allow-popups');
    }

    // ─────────────────────────────────────────────────────────────────────────
    // 8. Cross-Origin-Resource-Policy (CORP)
    // ─────────────────────────────────────────────────────────────────────────
    public function test_response_has_cross_origin_resource_policy_header(): void
    {
        $response = $this->getHomeResponse();
        $response->assertHeader('Cross-Origin-Resource-Policy', 'same-origin');
    }

    // ─────────────────────────────────────────────────────────────────────────
    // 9. X-XSS-Protection
    // ─────────────────────────────────────────────────────────────────────────
    public function test_response_has_x_xss_protection_header(): void
    {
        $response = $this->getHomeResponse();
        $response->assertHeader('X-XSS-Protection', '1; mode=block');
    }

    // ─────────────────────────────────────────────────────────────────────────
    // 10. Tidak ada header bocor info server (fingerprinting)
    // ─────────────────────────────────────────────────────────────────────────
    public function test_response_does_not_expose_x_powered_by(): void
    {
        $response = $this->getHomeResponse();
        $this->assertNull(
            $response->headers->get('X-Powered-By'),
            'Header X-Powered-By HARUS dihapus agar tidak membocorkan versi PHP/Laravel'
        );
    }

    // ─────────────────────────────────────────────────────────────────────────
    // 11. Login page juga harus memiliki security headers
    // ─────────────────────────────────────────────────────────────────────────
    public function test_login_page_has_security_headers(): void
    {
        $response = $this->get('/login');
        $response->assertHeader('Content-Security-Policy');
        $response->assertHeader('X-Frame-Options', 'SAMEORIGIN');
        $response->assertHeader('X-Content-Type-Options', 'nosniff');
    }
}
