@php
    $resume = $pelanggaran->resume($resumeOverrides ?? []);
    $isHighTipologi = ($resume['tipologi'] ?? null) === 'Pelanggaran Tinggi';

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
    <div class="modal-dialog modal-dialog-centered" style="max-width: 580px;">
        <div class="modal-content border-0 bg-transparent shadow-none p-2">
            <style>
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
                    height: 235px;
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
                #ResumePelanggaranModal .rc-table tr {
                    border-bottom: 1px solid #cbd5e1;
                }
                #ResumePelanggaranModal .rc-table tr:last-child {
                    border-bottom: none;
                }
                #ResumePelanggaranModal .rc-table th {
                    width: 32%;
                    padding: 15px 18px;
                    font-weight: 700;
                    font-size: 0.9rem;
                    color: #1e293b;
                    border-right: 1px solid #cbd5e1;
                    vertical-align: middle;
                    text-align: left;
                    background: #ffffff;
                }
                #ResumePelanggaranModal .rc-table td {
                    width: 68%;
                    padding: 15px 18px;
                    font-size: 0.88rem;
                    color: #1e293b;
                    line-height: 1.45;
                    vertical-align: middle;
                    background: #ffffff;
                }
                #ResumePelanggaranModal .rc-pill {
                    display: inline-flex;
                    align-items: center;
                    justify-content: center;
                    border-radius: 999px;
                    padding: 5px 18px;
                    font-weight: 700;
                    font-size: 0.84rem;
                    min-width: 86px;
                    text-align: center;
                    flex-shrink: 0;
                    color: #ffffff;
                    letter-spacing: 0.2px;
                }
                #ResumePelanggaranModal .rc-pill-wide {
                    padding: 6px 24px;
                    font-size: 0.88rem;
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
            </style>

            <div class="rc-card">
                {{-- Header Card --}}
                <div class="rc-header {{ $isHighTipologi ? 'rc-header-crimson' : 'rc-header-navy' }}">
                    <span id="ResumePelanggaranModalLabel" class="text-truncate">
                        RESUME PELANGGARAN — {{ $pelanggaran->no_pelanggaran }}
                    </span>
                    <button type="button" class="rc-dismiss-btn" data-bs-dismiss="modal" aria-label="Tutup" title="Tutup">
                        <i class="bx bx-x"></i>
                    </button>
                </div>

                {{-- Foto Utama --}}
                <div class="rc-photo-wrap">
                    @if ($resume['foto'])
                        <img src="{{ Storage::url($resume['foto']) }}" alt="Foto Kasus {{ $pelanggaran->no_pelanggaran }}">
                    @else
                        <div class="rc-photo-placeholder">
                            <i class="bx bx-buildings" style="font-size: 3rem; opacity: 0.6;"></i>
                            <div class="fw-bold mt-2">{{ $pelanggaran->nama_pelanggar ?? 'Lokasi Kasus Pelanggaran' }}</div>
                            <small class="text-muted mt-1">
                                {{ $pelanggaran->alamat_pelanggaran ?? '-' }}
                                @if ($pelanggaran->kel_pelanggaran)
                                    , Kel. {{ $pelanggaran->kel_pelanggaran }}
                                @endif
                            </small>
                        </div>
                    @endif
                </div>

                {{-- Tabel Ringkasan --}}
                <table class="rc-table">
                    <tr>
                        <th>Kasus</th>
                        <td>{{ $resume['kasus'] }}</td>
                    </tr>
                    <tr>
                        <th>Delik Pelanggaran</th>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                @if ($resume['delik_level'])
                                    <span class="rc-pill {{ $pillClass($resume['delik_level']) }}">
                                        {{ $resume['delik_level'] }}
                                    </span>
                                @endif
                                <span>{{ $resume['delik_text'] }}</span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>Dampak</th>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                @if ($resume['dampak_level'])
                                    <span class="rc-pill {{ $pillClass($resume['dampak_level']) }}">
                                        {{ $resume['dampak_level'] }}
                                    </span>
                                @endif
                                <span>{{ $resume['dampak_text'] }}</span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>Hasil Tipologi</th>
                        <td>
                            @if ($resume['tipologi'])
                                <span class="rc-pill rc-pill-wide {{ $pillClass($resume['tipologi']) }}">
                                    {{ $resume['tipologi'] }}
                                </span>
                            @else
                                <span class="text-muted fst-italic">Belum ditetapkan</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Arah Penanganan</th>
                        <td>{{ $resume['arah'] }}</td>
                    </tr>
                </table>
            </div>

            {{-- Catatan Bawah --}}
            <div class="rc-note-box">
                <strong class="text-danger">Catatan:</strong> arah penanganan mengacu pada pedoman sanksi administratif; ketentuan final mengikuti hasil akhir kajian.
            </div>
        </div>
    </div>
</div>
