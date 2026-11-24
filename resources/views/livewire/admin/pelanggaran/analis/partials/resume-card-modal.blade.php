@php
    $resume = $pelanggaran->resume($resumeOverrides ?? []);
    $isHighTipologi = ($resume['tipologi'] ?? null) === 'Pelanggaran Tinggi';
    $safeNoKasus = preg_replace('/[^A-Za-z0-9_-]+/', '-', (string) ($pelanggaran->no_pelanggaran ?? 'kasus'));
    $safeFilename = 'Resume_Pelanggaran_' . trim($safeNoKasus, '-');

    $pillClass = fn (?string $level) => match ($level) {
        'Rendah', 'Pelanggaran Rendah' => 'rc-pill-low',
        'Sedang', 'Pelanggaran Sedang' => 'rc-pill-med',
        'Tinggi', 'Pelanggaran Tinggi' => 'rc-pill-high',
        'Tidak Ada Pelanggaran' => 'rc-pill-safe',
        default => 'rc-pill-neutral',
    };
@endphp

<div wire:ignore.self class="modal fade" id="ResumePelanggaranModal" tabindex="-1"
    aria-labelledby="ResumePelanggaranModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 680px;">
        <div class="modal-content border-0 bg-transparent shadow-none">
            <style>
                #ResumePelanggaranModal #ResumeCaptureArea {
                    padding: 12px;
                    border-radius: 22px;
                    font-family: 'Public Sans', -apple-system, BlinkMacSystemFont, sans-serif;
                }
                #ResumePelanggaranModal .rc-card {
                    background: #ffffff;
                    border-radius: 18px;
                    border: 1.5px solid #475569;
                    box-shadow: 0 20px 45px rgba(15, 23, 42, 0.28);
                    overflow: hidden;
                    font-family: 'Public Sans', -apple-system, BlinkMacSystemFont, sans-serif;
                }
                #ResumePelanggaranModal .rc-header {
                    padding: 14px 52px;
                    text-align: center;
                    color: #ffffff;
                    font-weight: 700;
                    font-size: 1.05rem;
                    letter-spacing: 0.5px;
                    text-transform: uppercase;
                    position: relative;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    min-height: 52px;
                }
                #ResumePelanggaranModal .rc-header-navy {
                    background: #132238;
                }
                #ResumePelanggaranModal .rc-header-crimson {
                    background: #bf3916;
                }
                #ResumePelanggaranModal .rc-dismiss-btn {
                    position: absolute;
                    top: 50%;
                    right: 14px;
                    transform: translateY(-50%);
                    width: 32px;
                    height: 32px;
                    border-radius: 50%;
                    border: 1px solid rgba(255, 255, 255, 0.35);
                    background: rgba(255, 255, 255, 0.14);
                    color: #ffffff;
                    display: inline-flex;
                    align-items: center;
                    justify-content: center;
                    padding: 0;
                    cursor: pointer;
                    transition: all 0.15s ease;
                    line-height: 1;
                }
                #ResumePelanggaranModal .rc-dismiss-btn:hover,
                #ResumePelanggaranModal .rc-dismiss-btn:focus {
                    background: rgba(255, 255, 255, 0.28);
                    border-color: rgba(255, 255, 255, 0.65);
                    color: #ffffff;
                    outline: none;
                    transform: translateY(-50%) scale(1.06);
                }
                #ResumePelanggaranModal .rc-dismiss-btn i {
                    font-size: 1.25rem;
                }
                #ResumePelanggaranModal .rc-photo-wrap {
                    width: 100%;
                    height: 230px;
                    background: #f1f5f9;
                    border-bottom: 1.5px solid #cbd5e1;
                    position: relative;
                    overflow: hidden;
                }
                #ResumePelanggaranModal .rc-photo-wrap img {
                    width: 100%;
                    height: 100%;
                    object-fit: cover;
                    display: block;
                }
                #ResumePelanggaranModal .rc-photo-placeholder {
                    width: 100%;
                    height: 100%;
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    justify-content: center;
                    background: linear-gradient(180deg, #e2e8f0 0%, #f8fafc 100%);
                    color: #475569;
                    padding: 1.5rem;
                    text-align: center;
                }
                #ResumePelanggaranModal .rc-table {
                    width: 100%;
                    border-collapse: collapse;
                    background: #ffffff;
                }
                #ResumePelanggaranModal .rc-table > tbody > tr {
                    border-bottom: 1px solid #cbd5e1;
                }
                #ResumePelanggaranModal .rc-table > tbody > tr:last-child {
                    border-bottom: none;
                }
                #ResumePelanggaranModal .rc-table > tbody > tr > th {
                    width: 34%;
                    padding: 13px 16px;
                    font-weight: 700;
                    font-size: 0.87rem;
                    color: #1e293b;
                    border-right: 1px solid #cbd5e1;
                    vertical-align: top;
                    text-align: left;
                    background: #f8fafc;
                }
                #ResumePelanggaranModal .rc-table > tbody > tr > td {
                    width: 66%;
                    padding: 13px 16px;
                    font-size: 0.86rem;
                    color: #1e293b;
                    line-height: 1.45;
                    vertical-align: top;
                    background: #ffffff;
                }
                #ResumePelanggaranModal .rc-subtable {
                    width: 100%;
                    border-collapse: collapse;
                }
                #ResumePelanggaranModal .rc-subtable tr {
                    border-bottom: 1px dashed #e2e8f0;
                }
                #ResumePelanggaranModal .rc-subtable tr:last-child {
                    border-bottom: none;
                }
                #ResumePelanggaranModal .rc-subtable td {
                    padding: 4px 0;
                    font-size: 0.83rem;
                    vertical-align: top;
                    background: transparent;
                }
                #ResumePelanggaranModal .rc-subtable td.rc-sub-lbl {
                    width: 48%;
                    color: #475569;
                    font-weight: 600;
                    padding-right: 8px;
                }
                #ResumePelanggaranModal .rc-subtable td.rc-sub-val {
                    width: 52%;
                    color: #0f172a;
                }
                #ResumePelanggaranModal .rc-peta-box {
                    border: 1px solid #cbd5e1;
                    border-radius: 10px;
                    background: #f8fafc;
                    padding: 6px;
                    text-align: center;
                }
                #ResumePelanggaranModal .rc-peta-box img {
                    max-width: 100%;
                    max-height: 320px;
                    width: auto;
                    height: auto;
                    display: block;
                    margin: 0 auto;
                    border-radius: 6px;
                }
                #ResumePelanggaranModal .rc-pill {
                    display: inline-flex;
                    align-items: center;
                    justify-content: center;
                    border-radius: 999px;
                    padding: 5px 16px;
                    font-weight: 700;
                    font-size: 0.82rem;
                    min-width: 82px;
                    text-align: center;
                    flex-shrink: 0;
                    color: #ffffff;
                    letter-spacing: 0.2px;
                }
                #ResumePelanggaranModal .rc-pill-wide {
                    padding: 6px 22px;
                    font-size: 0.86rem;
                }
                #ResumePelanggaranModal .rc-pill-low {
                    background-color: #688f1c;
                    color: #ffffff;
                }
                #ResumePelanggaranModal .rc-pill-med {
                    background-color: #f5a623;
                    color: #ffffff;
                }
                #ResumePelanggaranModal .rc-pill-high {
                    background-color: #ef2323;
                    color: #ffffff;
                }
                #ResumePelanggaranModal .rc-pill-safe {
                    background-color: #16a34a;
                    color: #ffffff;
                }
                #ResumePelanggaranModal .rc-pill-neutral {
                    background-color: #64748b;
                    color: #ffffff;
                }
                #ResumePelanggaranModal .rc-note-box {
                    margin-top: 12px;
                    background: #fffcf2;
                    border: 1.5px solid #e0a84b;
                    border-radius: 12px;
                    padding: 10px 16px;
                    text-align: center;
                    font-size: 0.84rem;
                    color: #1e293b;
                    box-shadow: 0 8px 20px rgba(15, 23, 42, 0.15);
                }
                #ResumePelanggaranModal .rc-export-toolbar {
                    margin-top: 12px;
                    display: flex;
                    flex-wrap: wrap;
                    justify-content: center;
                    gap: 10px;
                }
                @media (max-width: 575.98px) {
                    #ResumePelanggaranModal #ResumeCaptureArea {
                        padding: 6px;
                    }
                    #ResumePelanggaranModal .rc-header {
                        padding: 12px 46px 12px 14px;
                        font-size: 0.88rem;
                        min-height: 48px;
                    }
                    #ResumePelanggaranModal .rc-photo-wrap {
                        height: 185px;
                    }
                    #ResumePelanggaranModal .rc-table > tbody > tr > th,
                    #ResumePelanggaranModal .rc-table > tbody > tr > td {
                        display: block;
                        width: 100%;
                        padding: 10px 14px;
                    }
                    #ResumePelanggaranModal .rc-table > tbody > tr > th {
                        border-right: none;
                        padding-bottom: 4px;
                        font-size: 0.78rem;
                        color: #475569;
                        text-transform: uppercase;
                        letter-spacing: 0.3px;
                    }
                    #ResumePelanggaranModal .rc-table > tbody > tr > td {
                        padding-top: 6px;
                        padding-bottom: 12px;
                        font-size: 0.84rem;
                    }
                    #ResumePelanggaranModal .rc-cell-flex {
                        flex-direction: column;
                        align-items: flex-start !important;
                        gap: 0.5rem !important;
                    }
                }
            </style>

            <div id="ResumeCaptureArea">
                <div class="rc-card">
                    {{-- Header Card --}}
                    <div class="rc-header {{ $isHighTipologi ? 'rc-header-crimson' : 'rc-header-navy' }}">
                        <span id="ResumePelanggaranModalLabel" class="text-break">
                            RESUME PELANGGARAN — {{ $pelanggaran->no_pelanggaran }}
                        </span>
                        <button type="button" class="rc-dismiss-btn" data-bs-dismiss="modal"
                            data-html2canvas-ignore="true" aria-label="Tutup" title="Tutup">
                            <i class="bx bx-x"></i>
                        </button>
                    </div>

                    {{-- Foto Utama (Kondisi Eksisting) --}}
                    <div class="rc-photo-wrap">
                        @if ($resume['foto'])
                            <img src="{{ Storage::url($resume['foto']) }}"
                                data-rc-cover="true"
                                alt="Foto Kasus {{ $pelanggaran->no_pelanggaran }}">
                        @else
                            <div class="rc-photo-placeholder">
                                <svg width="52" height="52" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="opacity: 0.55;">
                                    <path d="M3 21h18" />
                                    <path d="M5 21V7l8-4v18" />
                                    <path d="M19 21V11l-6-4" />
                                    <path d="M9 9v.01" />
                                    <path d="M9 12v.01" />
                                    <path d="M9 15v.01" />
                                    <path d="M9 18v.01" />
                                </svg>
                                <div class="fw-bold mt-2">{{ $pelanggaran->nama_pemilik_display !== '-' ? $pelanggaran->nama_pemilik_display : 'Lokasi Kasus Pelanggaran' }}</div>
                                <small class="text-muted mt-1">
                                    {{ $pelanggaran->alamat_pelanggaran ?? '-' }}
                                    @if ($pelanggaran->kel_pelanggaran)
                                        , Kel. {{ $pelanggaran->kel_pelanggaran }}
                                    @endif
                                </small>
                            </div>
                        @endif
                    </div>

                    {{-- Tabel Ringkasan (10 Bagian sesuai sheet mode isian) --}}
                    @php
                        $profil = $resume['profil_lokasi'] ?? [];
                        $petaList = $resume['peta_deliniasi'] ?? [];
                    @endphp
                    <table class="rc-table">
                        <tbody>
                            <tr>
                                <th>Penjelasan Singkat Kasus</th>
                                <td>
                                    <div>{{ $resume['kasus'] }}</div>
                                    @if (!empty($resume['pasal_aturan_dilanggar']))
                                        <div class="small text-muted mt-2">
                                            <strong class="text-dark">Pasal &amp; Aturan Dilanggar:</strong>
                                            {{ $resume['pasal_aturan_dilanggar'] }}
                                        </div>
                                    @endif
                                    @if (!empty($resume['penjelasan_lainnya']))
                                        <div class="small text-muted mt-1">
                                            <strong class="text-dark">Penjelasan Lainnya:</strong>
                                            {{ $resume['penjelasan_lainnya'] }}
                                        </div>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Profil Lokasi Indikasi Pelanggaran</th>
                                <td>
                                    <table class="rc-subtable">
                                        <tr>
                                            <td class="rc-sub-lbl">Nama Pemilik/Perusahaan</td>
                                            <td class="rc-sub-val">{{ $profil['nama_pemilik_perusahaan'] ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="rc-sub-lbl">Alamat Lokasi Pelanggaran</td>
                                            <td class="rc-sub-val">{{ $profil['alamat_pelanggaran'] ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="rc-sub-lbl">Kelurahan Lokasi Pelanggaran</td>
                                            <td class="rc-sub-val">{{ $profil['kel_pelanggaran'] ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="rc-sub-lbl">Kecamatan Lokasi Pelanggaran</td>
                                            <td class="rc-sub-val">{{ $profil['kec_pelanggaran'] ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="rc-sub-lbl">Peruntukan Pemanfaatan Ruang dalam RTR</td>
                                            <td class="rc-sub-val">{{ $profil['peruntukan_rtr'] ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="rc-sub-lbl">Pemanfaatan Ruang Eksisting</td>
                                            <td class="rc-sub-val">{{ $profil['pemanfaatan_ruang_eksisting'] ?? '-' }}</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <th>Jenis dan Sub Pelanggaran</th>
                                <td>
                                    <div class="d-flex align-items-start gap-3 rc-cell-flex">
                                        @if ($resume['delik_level'])
                                            <span class="rc-pill {{ $pillClass($resume['delik_level']) }}">
                                                {{ $resume['delik_level'] }}
                                            </span>
                                        @endif
                                        <div>
                                            @if (!empty($resume['delik_sub']))
                                                <div class="fw-semibold">{{ $resume['delik_sub'] }}</div>
                                            @endif
                                            @if (!empty($resume['delik_items']) && count($resume['delik_items']) > 1)
                                                <ul class="mb-0 ps-3 mt-1 small">
                                                    @foreach ($resume['delik_items'] as $dItem)
                                                        <li>{{ $dItem }}</li>
                                                    @endforeach
                                                </ul>
                                            @elseif (!empty($resume['delik_items']))
                                                <div class="small text-muted">{{ $resume['delik_items'][0] }}</div>
                                            @elseif (empty($resume['delik_sub']))
                                                <span>{{ $resume['delik_text'] }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>Dampak</th>
                                <td>
                                    <div class="d-flex align-items-start gap-3 rc-cell-flex">
                                        @if ($resume['dampak_level'])
                                            <span class="rc-pill {{ $pillClass($resume['dampak_level']) }}">
                                                {{ $resume['dampak_level'] }}
                                            </span>
                                        @endif
                                        <div>{{ $resume['dampak_text'] }}</div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>Skala dan Intensitas Pelanggaran</th>
                                <td>{{ $resume['skala_label'] ?: '-' }}</td>
                            </tr>
                            <tr>
                                <th>Riwayat Pelanggaran</th>
                                <td>{{ $resume['riwayat_label'] ?: '-' }}</td>
                            </tr>
                            <tr>
                                <th>Hasil Tipologi</th>
                                <td>
                                    <div class="d-flex flex-wrap align-items-center gap-2">
                                        @if ($resume['tipologi'])
                                            <span class="rc-pill rc-pill-wide {{ $pillClass($resume['tipologi']) }}">
                                                {{ $resume['tipologi'] }}
                                            </span>
                                        @else
                                            <span class="text-muted fst-italic">Belum ditetapkan</span>
                                        @endif
                                        @if ($resume['skor_total'] !== null)
                                            <span class="badge bg-label-dark px-2 py-1" style="font-size: 0.82rem;">
                                                Skor: {{ rtrim(rtrim(number_format((float) $resume['skor_total'], 2, '.', ''), '0'), '.') }}
                                            </span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>Rekomendasi Penanganan</th>
                                <td>{{ $resume['rekomendasi_penanganan'] ?? $resume['arah'] }}</td>
                            </tr>
                            <tr>
                                <th>Petugas Analis</th>
                                <td class="fw-semibold">{{ $resume['petugas_analis'] ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Peta Deliniasi</th>
                                <td>
                                    @if (!empty($petaList))
                                        <div class="d-flex flex-column gap-2">
                                            @foreach ($petaList as $petaPath)
                                                <div class="rc-peta-box">
                                                    <img src="{{ Storage::url($petaPath) }}"
                                                        alt="Peta Deliniasi {{ $pelanggaran->no_pelanggaran }}">
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-muted fst-italic">Belum ada peta deliniasi yang diunggah.</span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- Catatan Bawah --}}
                <div class="rc-note-box">
                    <strong class="text-danger">Catatan:</strong> rekomendasi penanganan mengacu pada pedoman sanksi administratif; ketentuan final mengikuti hasil akhir kajian.
                </div>
            </div>

            {{-- Toolbar Unduh Resume (Tidak ikut terekam pada gambar hasil ekspor) --}}
            <div class="rc-export-toolbar" data-html2canvas-ignore="true">
                <button type="button" class="btn btn-primary shadow-sm fw-semibold rc-download-btn"
                    data-filename="{{ $safeFilename }}">
                    <i class="bx bx-image me-1"></i>
                    <span class="rc-btn-label">Download PNG</span>
                </button>
                <button type="button" class="btn btn-danger shadow-sm fw-semibold"
                    wire:click="downloadResumePdf" wire:loading.attr="disabled" wire:target="downloadResumePdf">
                    <span wire:loading.remove wire:target="downloadResumePdf">
                        <i class="bx bxs-file-pdf me-1"></i> Download PDF
                    </span>
                    <span wire:loading wire:target="downloadResumePdf">
                        <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Menyiapkan PDF...
                    </span>
                </button>
                <button type="button" class="btn btn-secondary shadow-sm" data-bs-dismiss="modal">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

@pushOnce('scripts')
    <script src="{{ asset('assets/vendor/libs/html2canvas/html2canvas.min.js') }}"></script>
    <script>
        (function () {
            if (window.__resumeCardExportBound) {
                return;
            }
            window.__resumeCardExportBound = true;

            const HTML2CANVAS_SRC = @json(asset('assets/vendor/libs/html2canvas/html2canvas.min.js'));
            let html2canvasLoadPromise = null;

            function withTimeout(promise, ms, onTimeout) {
                let timerId;
                const timeoutPromise = new Promise((resolve, reject) => {
                    timerId = setTimeout(() => {
                        if (typeof onTimeout === 'function') {
                            resolve(onTimeout());
                        } else {
                            reject(new Error(onTimeout || 'Proses ekspor gambar melewati batas waktu.'));
                        }
                    }, ms);
                });

                return Promise.race([
                    Promise.resolve(promise).finally(() => clearTimeout(timerId)),
                    timeoutPromise,
                ]);
            }

            async function ensureHtml2Canvas() {
                if (typeof window.html2canvas === 'function') {
                    return window.html2canvas;
                }

                if (!html2canvasLoadPromise) {
                    html2canvasLoadPromise = new Promise((resolve, reject) => {
                        const script = document.createElement('script');
                        script.src = HTML2CANVAS_SRC;
                        script.onload = () => {
                            if (typeof window.html2canvas === 'function') {
                                resolve(window.html2canvas);
                            } else {
                                reject(new Error('Pustaka ekspor gambar tidak tersedia.'));
                            }
                        };
                        script.onerror = () => reject(new Error('Gagal memuat pustaka ekspor gambar.'));
                        document.head.appendChild(script);
                    }).finally(() => {
                        html2canvasLoadPromise = null;
                    });
                }

                return withTimeout(html2canvasLoadPromise, 8000, 'Gagal memuat pustaka ekspor gambar.');
            }

            async function waitForImages(container) {
                const imgs = Array.from(container.querySelectorAll('img'));
                await Promise.all(imgs.map((img) => {
                    // PENTING: img yang gagal dimuat (404/broken) tetap memiliki img.complete === true dengan naturalWidth === 0
                    if (img.complete) {
                        return Promise.resolve();
                    }
                    return withTimeout(new Promise((resolve) => {
                        img.addEventListener('load', resolve, { once: true });
                        img.addEventListener('error', resolve, { once: true });
                    }), 2500, () => null);
                }));
            }

            function renderCoverDataUrl(img, scale) {
                const rect = img.getBoundingClientRect();
                const rw = rect.width;
                const rh = rect.height;
                const nw = img.naturalWidth;
                const nh = img.naturalHeight;

                if (!rw || !rh || !nw || !nh) {
                    return null;
                }

                const imgRatio = nw / nh;
                const boxRatio = rw / rh;
                let sx = 0, sy = 0, sw = nw, sh = nh;

                if (imgRatio > boxRatio) {
                    sw = nh * boxRatio;
                    sx = (nw - sw) / 2;
                } else {
                    sh = nw / boxRatio;
                    sy = (nh - sh) / 2;
                }

                const offscreen = document.createElement('canvas');
                offscreen.width = Math.round(rw * scale);
                offscreen.height = Math.round(rh * scale);
                const ctx = offscreen.getContext('2d');
                if (!ctx) {
                    return null;
                }
                ctx.drawImage(img, sx, sy, sw, sh, 0, 0, offscreen.width, offscreen.height);

                try {
                    return offscreen.toDataURL('image/png');
                } catch (e) {
                    return null;
                }
            }

            function appendBrokenPhotoFallback(doc, holder) {
                if (holder.querySelector('[data-rc-broken-placeholder="1"]')) {
                    return;
                }
                const box = doc.createElement('div');
                box.setAttribute('data-rc-broken-placeholder', '1');
                box.style.display = 'flex';
                box.style.alignItems = 'center';
                box.style.justifyContent = 'center';
                box.style.width = '100%';
                box.style.height = '100%';
                box.style.background = '#f1f5f9';
                box.style.color = '#94a3b8';

                const icon = doc.createElement('i');
                icon.className = 'bx bx-image-alt';
                icon.style.fontSize = '24px';
                box.appendChild(icon);
                holder.appendChild(box);
            }

            function triggerPngDownload(blobOrDataUrl, filename) {
                const link = document.createElement('a');
                link.download = filename;
                link.style.display = 'none';

                if (blobOrDataUrl instanceof Blob) {
                    const url = URL.createObjectURL(blobOrDataUrl);
                    link.href = url;
                    document.body.appendChild(link);
                    link.click();
                    setTimeout(() => {
                        link.remove();
                        URL.revokeObjectURL(url);
                    }, 4000);
                    return;
                }

                link.href = blobOrDataUrl;
                document.body.appendChild(link);
                link.click();
                setTimeout(() => link.remove(), 1000);
            }

            document.addEventListener('click', async function (event) {
                const btn = event.target.closest('.rc-download-btn');
                if (!btn || btn.disabled) {
                    return;
                }

                const captureArea = document.getElementById('ResumeCaptureArea');
                if (!captureArea) {
                    return;
                }

                const baseFilename = btn.dataset.filename || 'Resume_Pelanggaran';
                const labelEl = btn.querySelector('.rc-btn-label');
                const originalLabel = labelEl ? labelEl.textContent : 'Download PNG';
                const allButtons = document.querySelectorAll('#ResumePelanggaranModal .rc-download-btn');
                const taggedElements = [];

                try {
                    allButtons.forEach((b) => { b.disabled = true; });
                    if (labelEl) {
                        labelEl.textContent = 'Menyiapkan gambar...';
                    }

                    const h2c = await ensureHtml2Canvas();
                    if (document.fonts && document.fonts.ready) {
                        await withTimeout(document.fonts.ready, 800, () => null);
                    }
                    await waitForImages(captureArea);

                    const scale = 2;
                    const coverSnapshots = [];
                    const allImgs = captureArea.querySelectorAll('img');
                    allImgs.forEach((img) => {
                        if (!img.complete || img.naturalWidth === 0) {
                            img.setAttribute('data-rc-broken-img', '1');
                            taggedElements.push([img, 'data-rc-broken-img']);
                            if (img.parentElement) {
                                img.parentElement.setAttribute('data-rc-has-broken-img', '1');
                                taggedElements.push([img.parentElement, 'data-rc-has-broken-img']);
                            }
                        }
                    });

                    // Pra-potong gambar object-fit:cover agar tidak gepeng/tertarik saat dirender html2canvas
                    const liveCoverImgs = captureArea.querySelectorAll('img[data-rc-cover="true"]');
                    liveCoverImgs.forEach((img, idx) => {
                        if (img.getAttribute('data-rc-broken-img') === '1') {
                            return;
                        }
                        img.setAttribute('data-rc-cover-idx', String(idx));
                        taggedElements.push([img, 'data-rc-cover-idx']);
                        coverSnapshots[idx] = renderCoverDataUrl(img, scale);
                    });

                    const canvas = await withTimeout(h2c(captureArea, {
                        scale: scale,
                        useCORS: true,
                        backgroundColor: null,
                        imageTimeout: 2500,
                        logging: false,
                        scrollX: 0,
                        scrollY: 0,
                        ignoreElements: (el) => {
                            if (el.hasAttribute && el.hasAttribute('data-html2canvas-ignore')) {
                                return true;
                            }
                            const tag = el.tagName;
                            if (tag === 'IFRAME' || tag === 'VIDEO') {
                                return true;
                            }
                            if (tag === 'LINK' && el.rel === 'stylesheet' && el.href && el.href.indexOf('fonts.googleapis.com') !== -1) {
                                return true;
                            }
                            if (tag === 'IMG') {
                                if (!captureArea.contains(el) || el.getAttribute('data-rc-broken-img') === '1') {
                                    return true;
                                }
                            }
                            return false;
                        },
                        onclone: (clonedDoc) => {
                            const clonedModal = clonedDoc.getElementById('ResumePelanggaranModal');
                            if (clonedModal) {
                                clonedModal.style.overflow = 'visible';
                                clonedModal.scrollTop = 0;
                            }

                            const clonedArea = clonedDoc.getElementById('ResumeCaptureArea');
                            if (!clonedArea) return;

                            // Hilangkan box-shadow berlebih agar tepi bersih & center header simetris tanpa tombol X
                            const header = clonedArea.querySelector('.rc-header');
                            if (header) {
                                header.style.paddingLeft = '20px';
                                header.style.paddingRight = '20px';
                            }

                            const brokenHolders = clonedArea.querySelectorAll('[data-rc-has-broken-img="1"]');
                            brokenHolders.forEach((holder) => appendBrokenPhotoFallback(clonedDoc, holder));

                            const clonedCovers = clonedArea.querySelectorAll('img[data-rc-cover-idx]');
                            clonedCovers.forEach((cImg) => {
                                const idx = Number(cImg.getAttribute('data-rc-cover-idx'));
                                if (coverSnapshots[idx]) {
                                    cImg.src = coverSnapshots[idx];
                                    cImg.style.objectFit = 'fill';
                                }
                            });
                        },
                    }), 15000, 'Waktu render gambar resume habis.');

                    if (!canvas || canvas.width === 0 || canvas.height === 0) {
                        throw new Error('Kanvas resume kosong.');
                    }

                    const blob = await withTimeout(new Promise((resolve) => {
                        if (typeof canvas.toBlob === 'function') {
                            canvas.toBlob(resolve, 'image/png');
                        } else {
                            resolve(null);
                        }
                    }), 5000, () => null);

                    if (blob) {
                        triggerPngDownload(blob, `${baseFilename}.png`);
                    } else {
                        const dataUrl = canvas.toDataURL('image/png');
                        if (!dataUrl || dataUrl === 'data:,') {
                            throw new Error('Gagal menghasilkan berkas PNG.');
                        }
                        triggerPngDownload(dataUrl, `${baseFilename}.png`);
                    }
                } catch (err) {
                    console.error('Gagal mengunduh gambar resume:', err);
                    alert('Maaf, gagal mengunduh gambar resume. Silakan coba kembali.');
                } finally {
                    taggedElements.forEach(([el, attr]) => el.removeAttribute(attr));
                    allButtons.forEach((b) => { b.disabled = false; });
                    if (labelEl) {
                        labelEl.textContent = originalLabel;
                    }
                }
            });
        })();
    </script>
@endPushOnce
