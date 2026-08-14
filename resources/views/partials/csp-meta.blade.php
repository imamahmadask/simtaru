{{--
    partials/csp-meta.blade.php
    ─────────────────────────────────────────────────────────────────────────────
    Meta tag Content-Security-Policy untuk lapisan keamanan di sisi HTML.
    Tag ini bekerja sebagai pelengkap HTTP Header CSP yang dikirim middleware.

    Sumber yang diizinkan disesuaikan dengan seluruh dependensi SIMTARU:
    - Livewire & Alpine.js    : unsafe-inline, unsafe-eval, WebSocket (ws/wss)
    - Bootstrap CSS/JS        : cdn.jsdelivr.net
    - Google Fonts            : fonts.googleapis.com, fonts.gstatic.com
    - Font Bunny              : fonts.bunny.net
    - Leaflet Maps            : unpkg.com
    - OpenStreetMap tiles     : *.tile.openstreetmap.org
    - Leaflet marker icons    : raw.githubusercontent.com, cdnjs.cloudflare.com
    - Google Maps (iframe)    : www.google.com
    - Google Maps API         : maps.googleapis.com, maps.gstatic.com
    - GitHub Buttons          : buttons.github.io
    - GLightbox               : cdn.jsdelivr.net
    ─────────────────────────────────────────────────────────────────────────────
--}}
<meta http-equiv="Content-Security-Policy" content="
    default-src 'self';
    script-src 'self' 'unsafe-inline' 'unsafe-eval'
        cdn.jsdelivr.net
        unpkg.com
        cdnjs.cloudflare.com
        raw.githubusercontent.com
        buttons.github.io
        maps.googleapis.com
        maps.gstatic.com;
    style-src 'self' 'unsafe-inline'
        fonts.googleapis.com
        cdn.jsdelivr.net
        unpkg.com
        cdnjs.cloudflare.com
        fonts.bunny.net;
    img-src 'self' data: blob:
        *.tile.openstreetmap.org
        raw.githubusercontent.com
        cdnjs.cloudflare.com
        maps.googleapis.com
        maps.gstatic.com
        cdn.jsdelivr.net
        unpkg.com;
    font-src 'self'
        fonts.googleapis.com
        fonts.gstatic.com
        fonts.bunny.net
        cdn.jsdelivr.net;
    connect-src 'self' ws: wss:
        *.tile.openstreetmap.org
        maps.googleapis.com;
    frame-src 'self' www.google.com;
    frame-ancestors 'self';
    media-src 'self';
    object-src 'none';
    worker-src 'self' blob:;
    form-action 'self';
    upgrade-insecure-requests;
">

{{-- X-Frame-Options: juga ditegaskan via meta untuk browser yang mendukung --}}
<meta http-equiv="X-Frame-Options" content="SAMEORIGIN">
