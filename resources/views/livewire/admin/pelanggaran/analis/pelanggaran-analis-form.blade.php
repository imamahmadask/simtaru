@php
    use App\Models\Pelanggaran;

    $isAda = $temuan_pelanggaran === 'Ada Pelanggaran';
    $isTidakAda = $temuan_pelanggaran === 'Tidak Ada Pelanggaran';
    $skor = $this->penilaian_skor;
    $rekomendasi = $skor['rekomendasi_kategori'];
    $selectedJenis = Pelanggaran::normalizeJenisPelanggaranList($jenis_pelanggaran);
    $wizardSteps = $this->wizard_steps;
    $totalSteps = $this->total_steps;
    $activeStep = max(1, min($totalSteps, $currentStep));
    $completedStepsCount = collect($wizardSteps)->where('done', true)->count();

    $klasifikasiOpsi = [
        'Pelanggaran Rendah' => ['color' => 'success', 'icon' => 'bx-shield', 'desc' => 'Skor < 40 • 3 dokumen sanksi'],
        'Pelanggaran Sedang' => ['color' => 'warning', 'icon' => 'bx-shield-quarter', 'desc' => 'Skor 40 - 60 • 6 dokumen sanksi'],
        'Pelanggaran Tinggi' => ['color' => 'danger', 'icon' => 'bx-shield-x', 'desc' => 'Skor > 60 • 8 dokumen sanksi'],
    ];
@endphp

<div>
    <style>
        .ap-step-no {
            width: 32px; height: 32px; border-radius: 50%;
            display: inline-flex; align-items: center; justify-content: center;
            font-weight: 600; font-size: .9rem; flex-shrink: 0;
            background: rgba(105, 108, 255, .16); color: #696cff;
        }
        .ap-card-header { display: flex; align-items: center; gap: .85rem; border-bottom: 1px solid #eceef1; }
        .ap-card-header h5 { margin: 0; font-size: 1rem; font-weight: 600; }
        .ap-card-header small { display: block; color: #a1acb8; font-size: .8rem; margin-top: 2px; }

        .ap-info-row { padding: .55rem 0; border-bottom: 1px dashed #eceef1; }
        .ap-info-row:last-child { border-bottom: 0; }
        .ap-info-label { font-size: .75rem; text-transform: uppercase; letter-spacing: .3px; color: #a1acb8; margin-bottom: 2px; }
        .ap-info-value { font-weight: 500; color: #566a7f; word-break: break-word; }

        .ap-stepper { display: flex; flex-wrap: wrap; gap: .5rem; }
        .ap-stepper-btn {
            display: inline-flex; align-items: center; gap: .45rem;
            padding: .45rem .75rem; border-radius: 999px; border: 1px solid #d9dee3;
            background: #fff; color: #697a8d; font-size: .8rem; font-weight: 500;
            transition: all .15s ease; cursor: pointer;
        }
        .ap-stepper-btn:hover:not(:disabled) { border-color: #696cff; color: #696cff; }
        .ap-stepper-btn:disabled { opacity: .55; cursor: not-allowed; }
        .ap-stepper-btn .ap-stepper-num {
            width: 22px; height: 22px; border-radius: 50%;
            display: inline-flex; align-items: center; justify-content: center;
            font-size: .72rem; font-weight: 700; background: #eceef1; color: #697a8d;
        }
        .ap-stepper-btn.is-done { border-color: rgba(113, 221, 55, .55); background: rgba(113, 221, 55, .08); color: #3d7a1c; }
        .ap-stepper-btn.is-done .ap-stepper-num { background: #71dd37; color: #fff; }
        .ap-stepper-btn.is-current { border-color: #696cff; background: #696cff; color: #fff; box-shadow: 0 2px 6px rgba(105, 108, 255, .35); }
        .ap-stepper-btn.is-current .ap-stepper-num { background: #fff; color: #696cff; }

        .ap-step-pane { display: none; }
        .ap-step-pane.is-active { display: block; }

        .ap-substep {
            border: 1px solid #eceef1; border-radius: .5rem; padding: 1rem; background: #fcfcfd;
        }

        .ap-option { display: flex; gap: .75rem; align-items: flex-start; padding: .8rem 1rem; border: 1px solid #d9dee3; border-radius: .5rem; cursor: pointer; transition: all .15s ease; height: 100%; margin: 0; background: #fff; }
        .ap-option:hover { border-color: #696cff; }
        .ap-option .form-check-input { margin-top: .2rem; flex-shrink: 0; }
        .ap-option.is-active { border-color: #696cff; background: rgba(105, 108, 255, .06); box-shadow: 0 0 0 1px #696cff inset; }
        .ap-option-title { font-weight: 600; color: #566a7f; line-height: 1.35; }
        .ap-option-desc { font-size: .8rem; color: #a1acb8; margin-top: 2px; line-height: 1.4; }

        .ap-choice { display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; gap: .25rem; padding: 1rem .75rem; height: 100%; white-space: normal; }
        .ap-choice i { font-size: 1.6rem; }
        .ap-choice small { opacity: .8; font-weight: 400; }

        .ap-doc { border: 1px solid #d9dee3; border-radius: .5rem; padding: .85rem 1rem; background: #fff; height: 100%; }
        .ap-doc.is-done { border-color: rgba(113, 221, 55, .6); background: rgba(113, 221, 55, .05); }
        .ap-doc-no { width: 24px; height: 24px; border-radius: 50%; background: #f0f2f4; color: #697a8d; font-size: .75rem; font-weight: 600; display: inline-flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .ap-doc.is-done .ap-doc-no { background: #71dd37; color: #fff; }

        .ap-thumb { position: relative; width: 96px; height: 96px; }
        .ap-thumb img { width: 100%; height: 100%; object-fit: cover; border-radius: .5rem; border: 1px solid #d9dee3; }
        .ap-thumb .btn { position: absolute; top: -8px; right: -8px; width: 24px; height: 24px; padding: 0; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; }

        .ap-actionbar { position: sticky; bottom: 1rem; z-index: 6; }

        @media (min-width: 992px) {
            .ap-sticky { position: sticky; top: 1.5rem; }
        }
        .ap-section { scroll-margin-top: 1.5rem; }
    </style>

    <div class="container-xxl flex-grow-1 container-p-y">
        {{-- Header --}}
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
            <div>
                <h4 class="fw-bold py-2 mb-0">
                    <span class="text-muted fw-light">Pelanggaran / Detail Kasus /</span> Analisis Pelanggaran
                </h4>
                <small class="text-muted">
                    No. Kasus <span class="badge bg-label-danger ms-1">{{ $pelanggaran->no_pelanggaran }}</span>
                </small>
            </div>
            <a href="{{ route('pelanggaran.detail', $pelanggaran->id) }}" class="btn btn-secondary">
                <i class="bx bx-arrow-back me-1"></i> Kembali
            </a>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger d-flex align-items-start gap-2" role="alert">
                <i class="bx bx-error-circle fs-4"></i>
                <div>
                    <strong>Data belum lengkap.</strong>
                    Periksa kembali isian yang ditandai merah sebelum menyimpan.
                </div>
            </div>
        @endif

        <div class="row g-4">
            {{-- ================= KOLOM KIRI ================= --}}
            <div class="col-lg-4 order-2 order-lg-1">
                <div class="ap-sticky d-flex flex-column gap-4">
                    {{-- Ringkasan Skor --}}
                    @if ($isAda)
                        <div class="card">
                            <div class="card-header py-3">
                                <h6 class="mb-0 fw-semibold"><i class="bx bx-calculator me-1"></i> Ringkasan Skor</h6>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center small mb-2">
                                    <span class="text-muted">Nilai A + B + C + D</span>
                                    <span class="fw-semibold">{{ number_format($skor['jumlah_abcd'], 2) }}</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center small mb-2">
                                    <span class="text-muted">Skor Total (S)</span>
                                    <span class="badge bg-label-dark fs-6">{{ number_format($skor['skor_total'], 0) }}</span>
                                </div>
                                @if ($rekomendasi)
                                    <div class="d-flex justify-content-between align-items-center small mb-2">
                                        <span class="text-muted">Rekomendasi Sistem</span>
                                        <span class="badge bg-label-{{ $klasifikasiOpsi[$rekomendasi]['color'] }}">{{ $rekomendasi }}</span>
                                    </div>
                                @endif
                                @if ($klasifikasi_pelanggaran)
                                    <div class="d-flex justify-content-between align-items-center small">
                                        <span class="text-muted">Klasifikasi Akhir</span>
                                        <span class="badge bg-{{ $klasifikasiOpsi[$klasifikasi_pelanggaran]['color'] ?? 'secondary' }}">{{ $klasifikasi_pelanggaran }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    {{-- Acuan Data Kasus --}}
                    <div class="card">
                        <div class="card-header py-3">
                            <h6 class="mb-0 fw-semibold"><i class="bx bx-info-circle me-1"></i> Acuan Data Kasus</h6>
                        </div>
                        <div class="card-body pt-0">
                            <div class="ap-info-row">
                                <div class="ap-info-label">Nama Pelanggar</div>
                                <div class="ap-info-value">{{ $pelanggaran->nama_pelanggar ?? '-' }}</div>
                            </div>
                            <div class="ap-info-row">
                                <div class="ap-info-label">Pemilik / Perusahaan</div>
                                <div class="ap-info-value">{{ $pelanggaran->nama_pemilik_perusahaan ?: '-' }}</div>
                            </div>
                            <div class="ap-info-row">
                                <div class="ap-info-label">Lokasi</div>
                                <div class="ap-info-value">{{ $pelanggaran->alamat_pelanggaran ?? '-' }}</div>
                                <div class="small text-muted">
                                    Kel. {{ $pelanggaran->kel_pelanggaran ?? '-' }}, Kec. {{ $pelanggaran->kec_pelanggaran ?? '-' }}
                                </div>
                                @if ($pelanggaran->gmaps_pelanggaran)
                                    <a href="{{ $pelanggaran->gmaps_pelanggaran }}" target="_blank" rel="noopener"
                                        class="btn btn-sm btn-outline-primary mt-2">
                                        <i class="bx bx-map me-1"></i> Google Maps
                                    </a>
                                @endif
                            </div>
                            <div class="ap-info-row">
                                <div class="ap-info-label">Pemanfaatan Ruang Existing</div>
                                <div class="ap-info-value">{{ $pelanggaran->jenis_pemanfaatan_ruang ?: '-' }}</div>
                            </div>
                            <div class="ap-info-row">
                                <div class="ap-info-label">Peruntukan Pemanfaatan Ruang dalam RTR</div>
                                <div class="ap-info-value">{{ $pelanggaran->pemanfaatan_ruang ?: '-' }}</div>
                            </div>
                            @if (!empty($pelanggaran->foto_pengawasan))
                                <div class="ap-info-row">
                                    <div class="ap-info-label mb-2">Foto Lapangan</div>
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach ($pelanggaran->foto_pengawasan as $img)
                                            <a href="{{ Storage::url($img) }}" target="_blank">
                                                <img src="{{ Storage::url($img) }}" class="rounded border"
                                                    style="width: 64px; height: 64px; object-fit: cover;" alt="Foto Lapangan">
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- ================= KOLOM KANAN (FORM WIZARD) ================= --}}
            <div class="col-lg-8 order-1 order-lg-2">
                {{-- Stepper Header Horizontal --}}
                <div class="card mb-4 ap-section" id="wizard-stepper-top">
                    <div class="card-body py-3">
                        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-2">
                            <div class="small fw-semibold text-primary">
                                Langkah {{ $activeStep }} dari {{ $totalSteps }}:
                                <span class="text-dark">{{ $wizardSteps[$activeStep]['title'] ?? '' }}</span>
                            </div>
                            <span class="small text-muted">{{ $completedStepsCount }} / {{ $totalSteps }} selesai</span>
                        </div>
                        <div class="progress mb-3" style="height: 6px;">
                            <div class="progress-bar bg-primary" role="progressbar"
                                style="width: {{ round(($activeStep / max(1, $totalSteps)) * 100) }}%;"
                                aria-valuenow="{{ $activeStep }}" aria-valuemin="1" aria-valuemax="{{ $totalSteps }}"></div>
                        </div>
                        <div class="ap-stepper">
                            @foreach ($wizardSteps as $sNum => $step)
                                @php
                                    $isCurrent = $activeStep === $sNum;
                                    $accessible = $this->canAccessStep($sNum);
                                @endphp
                                <button type="button"
                                    wire:click="goToStep({{ $sNum }})"
                                    wire:key="top-step-{{ $sNum }}"
                                    @disabled(!$accessible)
                                    class="ap-stepper-btn {{ $isCurrent ? 'is-current' : ($step['done'] ? 'is-done' : '') }}">
                                    <span class="ap-stepper-num">
                                        @if ($step['done'] && !$isCurrent)
                                            <i class="bx bx-check"></i>
                                        @else
                                            {{ $sNum }}
                                        @endif
                                    </span>
                                    <span>{{ $step['short'] }}</span>
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>

                <form wire:submit.prevent="storeAnalisa" class="d-flex flex-column gap-4">

                    {{-- LANGKAH 1: Kesimpulan Pemeriksaan --}}
                    <div class="ap-step-pane {{ $activeStep === 1 ? 'is-active' : '' }}" id="step-kesimpulan">
                        <div class="card ap-section">
                            <div class="card-header ap-card-header">
                                <span class="ap-step-no">1</span>
                                <div>
                                    <h5>Kesimpulan Pemeriksaan</h5>
                                    <small>Tentukan apakah ditemukan pelanggaran pemanfaatan ruang</small>
                                </div>
                            </div>
                            <div class="card-body pt-4">
                                <div class="row g-3">
                                    <div class="col-sm-6">
                                        <input type="radio" class="btn-check" id="temuan_ada" value="Ada Pelanggaran"
                                            wire:model.live="temuan_pelanggaran" autocomplete="off">
                                        <label class="btn btn-outline-danger w-100 ap-choice" for="temuan_ada">
                                            <i class="bx bx-error-alt"></i>
                                            <span class="fw-semibold">Ada Pelanggaran</span>
                                            <small>Lanjutkan ke penilaian bertahap (A, B, C, D) &amp; alur sanksi</small>
                                        </label>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="radio" class="btn-check" id="temuan_tidak" value="Tidak Ada Pelanggaran"
                                            wire:model.live="temuan_pelanggaran" autocomplete="off">
                                        <label class="btn btn-outline-success w-100 ap-choice" for="temuan_tidak">
                                            <i class="bx bx-check-shield"></i>
                                            <span class="fw-semibold">Tidak Ada Pelanggaran</span>
                                            <small>Pemanfaatan ruang sesuai ketentuan</small>
                                        </label>
                                    </div>
                                </div>
                                @error('temuan_pelanggaran')
                                    <div class="text-danger small mt-2">{{ $message }}</div>
                                @enderror

                                @if ($isAda)
                                    <div class="alert alert-info small d-flex align-items-center gap-2 mt-3 mb-0">
                                        <i class="bx bx-info-circle fs-5"></i>
                                        <div>Klik <strong>Selanjutnya</strong> untuk mulai mengisi <strong>Komponen A (Jenis Pelanggaran)</strong> secara bertahap.</div>
                                    </div>
                                @elseif ($isTidakAda)
                                    <div class="alert alert-success small d-flex align-items-center gap-2 mt-3 mb-0">
                                        <i class="bx bx-check-circle fs-5"></i>
                                        <div>Klik <strong>Selanjutnya</strong> untuk melengkapi <strong>Berkas Perizinan (Opsional)</strong> dan menyimpan analisis.</div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if ($isAda)
                        {{-- LANGKAH 2: Komponen A — Jenis Pelanggaran (Bobot 40%) --}}
                        <div class="ap-step-pane {{ $activeStep === 2 ? 'is-active' : '' }}" id="step-indikasi">
                            <div class="card ap-section">
                                <div class="card-header ap-card-header justify-content-between">
                                    <div class="d-flex align-items-center gap-3">
                                        <span class="ap-step-no">2</span>
                                        <div>
                                            <h5>A. Jenis Pelanggaran <span class="badge bg-label-primary ms-1">Bobot 40%</span></h5>
                                            <small>Ikuti 3 sub-tahap berurutan: Indikasi → Kategori → Sub-Pelanggaran (Multi-Select)</small>
                                        </div>
                                    </div>
                                    @if ($skor['nilai_a'] !== null)
                                        <span class="badge bg-primary">Nilai A: {{ $skor['nilai_a'] }} (Hasil: {{ number_format($skor['hasil_a'], 2) }})</span>
                                    @endif
                                </div>
                                <div class="card-body pt-4 d-flex flex-column gap-4">
                                    {{-- Tahap A1: Indikasi --}}
                                    <div class="ap-substep">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <label class="form-label fw-semibold mb-0">
                                                <span class="badge bg-label-primary me-1">Tahap A1</span> Uraian Indikasi Pelanggaran <span class="text-danger">*</span>
                                            </label>
                                            @if ($jenis_indikasi_pelanggaran)
                                                <span class="badge bg-label-success"><i class="bx bx-check"></i> Dipilih</span>
                                            @endif
                                        </div>
                                        <div class="d-flex flex-column gap-2">
                                            @foreach (Pelanggaran::INDIKASI_MAP as $key => $ind)
                                                <label class="ap-option {{ $jenis_indikasi_pelanggaran === $key ? 'is-active' : '' }}" for="indikasi_{{ $key }}">
                                                    <input class="form-check-input" type="radio" id="indikasi_{{ $key }}"
                                                        value="{{ $key }}" wire:model.live="jenis_indikasi_pelanggaran">
                                                    <div>
                                                        <div class="ap-option-title">{{ $ind['label'] }}</div>
                                                        <div class="ap-option-desc">{{ $ind['full'] }}</div>
                                                    </div>
                                                </label>
                                            @endforeach
                                        </div>
                                        @error('jenis_indikasi_pelanggaran')
                                            <div class="text-danger small mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Tahap A2: Kategori --}}
                                    @if ($jenis_indikasi_pelanggaran)
                                        @php
                                            $kategoriKeys = $jenis_indikasi_pelanggaran === 'menghalangi_akses_umum'
                                                ? ['akses_umum']
                                                : ['tanpa_kkpr', 'tidak_sesuai_kkpr'];
                                        @endphp
                                        <div class="ap-substep">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <label class="form-label fw-semibold mb-0">
                                                    <span class="badge bg-label-primary me-1">Tahap A2</span> Pelanggaran (Kategori) <span class="text-danger">*</span>
                                                </label>
                                                @if ($kategori_pelanggaran)
                                                    <span class="badge bg-label-success"><i class="bx bx-check"></i> Dipilih</span>
                                                @endif
                                            </div>
                                            <div class="row g-2">
                                                @foreach ($kategoriKeys as $key)
                                                    <div class="{{ count($kategoriKeys) > 1 ? 'col-md-6' : 'col-12' }}">
                                                        <label class="ap-option {{ $kategori_pelanggaran === $key ? 'is-active' : '' }}" for="kategori_{{ $key }}">
                                                            <input class="form-check-input" type="radio" id="kategori_{{ $key }}"
                                                                value="{{ $key }}" wire:model.live="kategori_pelanggaran">
                                                            <div class="ap-option-title">{{ Pelanggaran::KATEGORI_MAP[$key]['label'] }}</div>
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                            @error('kategori_pelanggaran')
                                                <div class="text-danger small mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    @else
                                        <div class="alert alert-secondary small mb-0">
                                            <i class="bx bx-down-arrow-alt me-1"></i> Pilih <strong>Tahap A1 (Uraian Indikasi)</strong> terlebih dahulu untuk menampilkan pilihan kategori &amp; sub-pelanggaran.
                                        </div>
                                    @endif

                                    {{-- Tahap A3: Sub Pelanggaran (Multi-Select Checkbox Cards) --}}
                                    @if ($kategori_pelanggaran && isset(Pelanggaran::JENIS_PER_KATEGORI[$kategori_pelanggaran]))
                                        <div class="ap-substep">
                                            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                                                <label class="form-label fw-semibold mb-0">
                                                    <span class="badge bg-label-primary me-1">Tahap A3</span> Sub Pelanggaran (Dapat memilih lebih dari satu) <span class="text-danger">*</span>
                                                </label>
                                                <div class="d-flex align-items-center gap-2">
                                                    <span class="badge bg-label-info">{{ count($selectedJenis) }} dipilih</span>
                                                    <button type="button" class="btn btn-xs btn-outline-primary" wire:click="selectAllJenisPelanggaran">
                                                        Pilih Semua
                                                    </button>
                                                    @if (count($selectedJenis) > 0)
                                                        <button type="button" class="btn btn-xs btn-outline-secondary" wire:click="clearJenisPelanggaran">
                                                            Reset
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="row g-2">
                                                @foreach (Pelanggaran::JENIS_PER_KATEGORI[$kategori_pelanggaran] as $key)
                                                    @php
                                                        $meta = Pelanggaran::JENIS_MAP[$key];
                                                        $checked = in_array($key, $selectedJenis, true);
                                                    @endphp
                                                    <div class="col-md-6" wire:key="jenis-opt-{{ $key }}">
                                                        <label class="ap-option {{ $checked ? 'is-active' : '' }}" for="jenis_{{ $key }}">
                                                            <input class="form-check-input" type="checkbox" id="jenis_{{ $key }}"
                                                                value="{{ $key }}" wire:model.live="jenis_pelanggaran">
                                                            <div class="d-flex justify-content-between align-items-start gap-2 w-100">
                                                                <div class="ap-option-title small">{{ $meta['label'] }}</div>
                                                                <span class="badge bg-label-secondary flex-shrink-0">Nilai {{ $meta['nilai'] }}</span>
                                                            </div>
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                            @error('jenis_pelanggaran')
                                                <div class="text-danger small mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- LANGKAH 3: Komponen B — Dampak Terhadap Masyarakat (Bobot 35%) --}}
                        <div class="ap-step-pane {{ $activeStep === 3 ? 'is-active' : '' }}" id="step-dampak">
                            <div class="card ap-section">
                                <div class="card-header ap-card-header justify-content-between">
                                    <div class="d-flex align-items-center gap-3">
                                        <span class="ap-step-no">3</span>
                                        <div>
                                            <h5>B. Dampak Terhadap Masyarakat <span class="badge bg-label-primary ms-1">Bobot 35%</span></h5>
                                            <small>Pilih kategori dampak dan radius wilayah terdampak</small>
                                        </div>
                                    </div>
                                    @if ($skor['nilai_b'] !== null)
                                        <span class="badge bg-primary">Nilai B: {{ $skor['nilai_b'] }} (Hasil: {{ number_format($skor['hasil_b'], 2) }})</span>
                                    @endif
                                </div>
                                <div class="card-body pt-4">
                                    <label class="form-label fw-semibold">Kategori Dampak Terhadap Masyarakat <span class="text-danger">*</span></label>
                                    <div class="row g-2 mb-3">
                                        @foreach (Pelanggaran::DAMPAK_MAP as $val => $meta)
                                            <div class="col-sm-6 col-md-3" wire:key="dampak-opt-{{ $loop->index }}">
                                                <label class="ap-option {{ $dampak_radius_wilayah === $val ? 'is-active' : '' }}" for="dampak_{{ $loop->index }}">
                                                    <input class="form-check-input" type="radio" id="dampak_{{ $loop->index }}"
                                                        value="{{ $val }}" wire:model.live="dampak_radius_wilayah">
                                                    <div>
                                                        <div class="ap-option-title small">{{ $meta['label'] }}</div>
                                                        <span class="badge bg-label-secondary mt-1">Nilai {{ $meta['nilai'] }}</span>
                                                    </div>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                    @error('dampak_radius_wilayah')
                                        <div class="text-danger small mb-3">{{ $message }}</div>
                                    @enderror

                                    <div class="pt-3 border-top d-flex flex-wrap justify-content-between align-items-center gap-2">
                                        <span class="small fw-semibold text-muted">Status Keluhan Masyarakat (Informasi Pendukung)</span>
                                        <div class="btn-group btn-group-sm" role="group">
                                            @foreach (['Ada' => 'Ada Keluhan', 'Tidak Ada' => 'Tidak Ada Keluhan'] as $val => $lbl)
                                                <input type="radio" class="btn-check" id="keluhan_{{ Str::slug($val) }}"
                                                    value="{{ $val }}" wire:model.live="dampak_keluhan_masyarakat" autocomplete="off">
                                                <label class="btn btn-outline-secondary" for="keluhan_{{ Str::slug($val) }}">{{ $lbl }}</label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- LANGKAH 4: Komponen C — Skala & Intensitas Pelanggaran (Bobot 15%) --}}
                        <div class="ap-step-pane {{ $activeStep === 4 ? 'is-active' : '' }}" id="step-skala">
                            <div class="card ap-section">
                                <div class="card-header ap-card-header justify-content-between">
                                    <div class="d-flex align-items-center gap-3">
                                        <span class="ap-step-no">4</span>
                                        <div>
                                            <h5>C. Skala &amp; Intensitas Pelanggaran <span class="badge bg-label-primary ms-1">Bobot 15%</span></h5>
                                            <small>Pilih besaran persentase luasan maksimal dan luas bangunan pelanggaran</small>
                                        </div>
                                    </div>
                                    @if ($skor['nilai_c'] !== null)
                                        <span class="badge bg-primary">Nilai C: {{ $skor['nilai_c'] }} (Hasil: {{ number_format($skor['hasil_c'], 2) }})</span>
                                    @endif
                                </div>
                                <div class="card-body pt-4">
                                    <label class="form-label fw-semibold mb-2">
                                        Pilihan Skala &amp; Intensitas <span class="text-danger">*</span>
                                    </label>
                                    <div class="d-flex flex-column gap-2">
                                        @foreach (Pelanggaran::SKALA_MAP as $slug => $meta)
                                            <label class="ap-option {{ $skala_pelanggaran === $slug ? 'is-active' : '' }}" for="skala_{{ $slug }}" wire:key="skala-opt-{{ $slug }}">
                                                <input class="form-check-input" type="radio" id="skala_{{ $slug }}"
                                                    value="{{ $slug }}" wire:model.live="skala_pelanggaran">
                                                <div class="d-flex justify-content-between align-items-center gap-2 w-100">
                                                    <div class="ap-option-title small">{{ $meta['label'] }}</div>
                                                    <span class="badge bg-label-secondary flex-shrink-0">Nilai {{ $meta['nilai'] }}</span>
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                    @error('skala_pelanggaran')
                                        <div class="text-danger small mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- LANGKAH 5: Komponen D — Riwayat Pelanggaran (Bobot 10%) --}}
                        <div class="ap-step-pane {{ $activeStep === 5 ? 'is-active' : '' }}" id="step-riwayat">
                            <div class="card ap-section">
                                <div class="card-header ap-card-header justify-content-between">
                                    <div class="d-flex align-items-center gap-3">
                                        <span class="ap-step-no">5</span>
                                        <div>
                                            <h5>D. Riwayat Pelanggaran <span class="badge bg-label-primary ms-1">Bobot 10%</span></h5>
                                            <small>Tentukan faktor pemberat atau riwayat pembinaan / peringatan sebelumnya</small>
                                        </div>
                                    </div>
                                    @if ($skor['nilai_d'] !== null)
                                        <span class="badge bg-primary">Nilai D: {{ $skor['nilai_d'] }} (Hasil: {{ number_format($skor['hasil_d'], 2) }})</span>
                                    @endif
                                </div>
                                <div class="card-body pt-4">
                                    <label class="form-label fw-semibold mb-2">
                                        Pilihan Riwayat Pelanggaran <span class="text-danger">*</span>
                                    </label>
                                    <div class="d-flex flex-column gap-2">
                                        @foreach (Pelanggaran::RIWAYAT_MAP as $slug => $meta)
                                            <label class="ap-option {{ $riwayat_pelanggaran === $slug ? 'is-active' : '' }}" for="riwayat_{{ $slug }}" wire:key="riwayat-opt-{{ $slug }}">
                                                <input class="form-check-input" type="radio" id="riwayat_{{ $slug }}"
                                                    value="{{ $slug }}" wire:model.live="riwayat_pelanggaran">
                                                <div class="d-flex justify-content-between align-items-center gap-2 w-100">
                                                    <div class="ap-option-title small">{{ $meta['label'] }}</div>
                                                    <span class="badge bg-label-secondary flex-shrink-0">Nilai {{ $meta['nilai'] }}</span>
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                    @error('riwayat_pelanggaran')
                                        <div class="text-danger small mt-2">{{ $message }}</div>
                                    @enderror

                                    @if ($rekomendasi)
                                        <div class="alert alert-{{ $klasifikasiOpsi[$rekomendasi]['color'] }} d-flex flex-wrap align-items-center justify-content-between gap-2 mt-4 mb-0" role="alert">
                                            <div class="d-flex align-items-center gap-2">
                                                <i class="bx bx-calculator fs-4"></i>
                                                <div>
                                                    Skor Total (S) = <strong>{{ number_format($skor['skor_total'], 2) }}</strong>
                                                    &bull; Rekomendasi Sistem: <strong>{{ $rekomendasi }}</strong>
                                                </div>
                                            </div>
                                            <span class="small opacity-75">Lihat rincian lengkap di langkah berikutnya</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- LANGKAH 6: Ringkasan Skor Penilaian (S) & Expert Judgement --}}
                        <div class="ap-step-pane {{ $activeStep === 6 ? 'is-active' : '' }}" id="step-expert">
                            <div class="card ap-section mb-4">
                                <div class="card-header ap-card-header">
                                    <span class="ap-step-no">6</span>
                                    <div>
                                        <h5>Ringkasan Perhitungan Skor (S) &amp; Expert Judgement</h5>
                                        <small>Tinjau rincian skor A, B, C, D lalu tentukan pertimbangan teknis / rapat FPR</small>
                                    </div>
                                </div>
                                <div class="card-body pt-4">
                                    {{-- Tabel Rincian Perhitungan Skor (Sesuai Sheet Kasus) --}}
                                    <div class="border rounded p-3 bg-lighter mb-4">
                                        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-2">
                                            <h6 class="mb-0 fw-bold"><i class="bx bx-calculator me-1 text-primary"></i> Rincian Perhitungan Skor Penilaian</h6>
                                            <small class="text-muted">Rumus: S = 20 × ((A×40%) + (B×35%) + (C×15%) + (D×10%))</small>
                                        </div>
                                        <div class="table-responsive bg-white rounded border">
                                            <table class="table table-sm mb-0">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th style="width: 65px">Kode</th>
                                                        <th>Sub Pelanggaran / Kategori</th>
                                                        <th class="text-center" style="width: 80px">Nilai</th>
                                                        <th class="text-center" style="width: 90px">Bobot</th>
                                                        <th class="text-end" style="width: 90px">Hasil</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($skor['items_a'] as $itemA)
                                                        <tr>
                                                            <td><span class="badge bg-label-primary">A</span></td>
                                                            <td>{{ $itemA['label'] }}</td>
                                                            <td class="text-center">{{ $itemA['nilai'] }}</td>
                                                            <td class="text-center">40%</td>
                                                            <td class="text-end fw-semibold">{{ number_format($itemA['hasil'], 2) }}</td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td><span class="badge bg-label-secondary">A</span></td>
                                                            <td colspan="4" class="text-muted fst-italic">Belum ada sub-pelanggaran dipilih</td>
                                                        </tr>
                                                    @endforelse
                                                    <tr>
                                                        <td><span class="badge bg-label-info">B</span></td>
                                                        <td>{{ $skor['dampak_label'] ?? 'Belum dipilih' }}</td>
                                                        <td class="text-center">{{ $skor['nilai_b'] ?? '-' }}</td>
                                                        <td class="text-center">35%</td>
                                                        <td class="text-end fw-semibold">{{ $skor['nilai_b'] !== null ? number_format($skor['hasil_b'], 2) : '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><span class="badge bg-label-warning">C</span></td>
                                                        <td>{{ $skor['skala_label'] ?? 'Belum dipilih' }}</td>
                                                        <td class="text-center">{{ $skor['nilai_c'] ?? '-' }}</td>
                                                        <td class="text-center">15%</td>
                                                        <td class="text-end fw-semibold">{{ $skor['nilai_c'] !== null ? number_format($skor['hasil_c'], 2) : '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><span class="badge bg-label-danger">D</span></td>
                                                        <td>{{ $skor['riwayat_label'] ?? 'Belum dipilih' }}</td>
                                                        <td class="text-center">{{ $skor['nilai_d'] ?? '-' }}</td>
                                                        <td class="text-center">10%</td>
                                                        <td class="text-end fw-semibold">{{ $skor['nilai_d'] !== null ? number_format($skor['hasil_d'], 2) : '-' }}</td>
                                                    </tr>
                                                </tbody>
                                                <tfoot class="table-light">
                                                    <tr>
                                                        <th colspan="4" class="text-end">Nilai A + B + C + D</th>
                                                        <th class="text-end">{{ number_format($skor['jumlah_abcd'], 2) }}</th>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="4" class="text-end">Nilai Total (Skor S = 20 × Jumlah)</th>
                                                        <th class="text-end fs-5 text-primary">{{ number_format($skor['skor_total'], 2) }}</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>

                                        @if ($rekomendasi)
                                            <div class="alert alert-{{ $klasifikasiOpsi[$rekomendasi]['color'] }} d-flex align-items-center justify-content-between gap-2 mt-3 mb-0" role="alert">
                                                <div class="d-flex align-items-center gap-2">
                                                    <i class="bx bx-bulb fs-4"></i>
                                                    <div>
                                                        Hasil Perhitungan Skor (<strong>{{ number_format($skor['skor_total'], 2) }}</strong>):
                                                        Rekomendasi Sistem = <strong>{{ $rekomendasi }}</strong>
                                                    </div>
                                                </div>
                                                <span class="small opacity-75">
                                                    &lt;40 Rendah | 40–60 Sedang | &gt;60 Tinggi
                                                </span>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Expert Judgement Fields --}}
                                    <div class="row g-3 mb-3">
                                        <div class="col-md-5">
                                            <label class="form-label fw-semibold">Petugas Analis</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bx bx-user"></i></span>
                                                <input type="text" class="form-control" readonly
                                                    value="{{ Auth::user()?->name ?? ($expert_user_name ?? 'Analis') }}">
                                            </div>
                                            <div class="form-text">Tercatat otomatis saat disimpan.</div>
                                        </div>
                                        <div class="col-md-7">
                                            <label class="form-label fw-semibold d-block">Tindakan Terhadap Rekomendasi <span class="text-danger">*</span></label>
                                            <div class="btn-group w-100" role="group">
                                                <input type="radio" class="btn-check" id="tindakan_ikuti" value="Ikuti Rekomendasi"
                                                    wire:model.live="expert_tindakan_rekomendasi" autocomplete="off">
                                                <label class="btn btn-outline-success" for="tindakan_ikuti">
                                                    <i class="bx bx-check me-1"></i> Ikuti Rekomendasi
                                                </label>
                                                <input type="radio" class="btn-check" id="tindakan_anulir" value="Anulir Rekomendasi"
                                                    wire:model.live="expert_tindakan_rekomendasi" autocomplete="off">
                                                <label class="btn btn-outline-warning" for="tindakan_anulir">
                                                    <i class="bx bx-revision me-1"></i> Anulir / Ganti Kategori
                                                </label>
                                            </div>
                                            @error('expert_tindakan_rekomendasi')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="expert_justifikasi" class="form-label fw-semibold">Justifikasi</label>
                                        <textarea wire:model.blur="expert_justifikasi" id="expert_justifikasi" rows="4"
                                            class="form-control @error('expert_justifikasi') is-invalid @enderror"
                                            placeholder="Dasar pertimbangan teknis, hasil rapat FPR, regulasi yang dilanggar, kondisi lapangan..."></textarea>
                                        @error('expert_justifikasi')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="expert_kesimpulan" class="form-label fw-semibold">Kesimpulan</label>
                                        <textarea wire:model.blur="expert_kesimpulan" id="expert_kesimpulan" rows="4"
                                            class="form-control @error('expert_kesimpulan') is-invalid @enderror"
                                            placeholder="Kesimpulan akhir kajian teknis..."></textarea>
                                        @error('expert_kesimpulan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="upload_expert_dokumen" class="form-label fw-semibold">Dokumen Pendukung</label>
                                        <input type="file" wire:model="upload_expert_dokumen" multiple id="upload_expert_dokumen"
                                            class="form-control @error('upload_expert_dokumen.*') is-invalid @enderror"
                                            accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                        <div class="form-text">Bisa lebih dari satu file. PDF, DOC/DOCX, JPG, PNG — maks. 10 MB per file.</div>
                                        <div wire:loading wire:target="upload_expert_dokumen" class="small text-info mt-1">
                                            <i class="bx bx-loader-alt bx-spin me-1"></i> Mengunggah...
                                        </div>
                                        @error('upload_expert_dokumen.*')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror

                                        @if (!empty($existing_expert_dokumen) || !empty($upload_expert_dokumen))
                                            <ul class="list-group mt-3">
                                                @foreach ($existing_expert_dokumen as $idx => $docPath)
                                                    <li class="list-group-item d-flex justify-content-between align-items-center gap-2">
                                                        <a href="{{ Storage::url($docPath) }}" target="_blank" class="text-truncate small">
                                                            <i class="bx bx-file me-1"></i>{{ basename($docPath) }}
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-icon btn-outline-danger flex-shrink-0"
                                                            wire:click="removeExistingExpertDokumen({{ $idx }})"
                                                            wire:confirm="Hapus dokumen ini?" title="Hapus">
                                                            <i class="bx bx-trash"></i>
                                                        </button>
                                                    </li>
                                                @endforeach
                                                @foreach ($upload_expert_dokumen as $idx => $tempDoc)
                                                    <li class="list-group-item d-flex justify-content-between align-items-center gap-2 bg-lighter">
                                                        <span class="text-truncate small">
                                                            <span class="badge bg-label-success me-1">Baru</span>{{ $tempDoc->getClientOriginalName() }}
                                                        </span>
                                                        <button type="button" class="btn btn-sm btn-icon btn-outline-secondary flex-shrink-0"
                                                            wire:click="removeTempExpertDokumen({{ $idx }})" title="Batal">
                                                            <i class="bx bx-x"></i>
                                                        </button>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- LANGKAH 7: Klasifikasi Pelanggaran, Dokumen Sanksi & Dokumentasi --}}
                        <div class="ap-step-pane {{ $activeStep === 7 ? 'is-active' : '' }}" id="step-klasifikasi">
                            <div class="card ap-section mb-4">
                                <div class="card-header ap-card-header">
                                    <span class="ap-step-no">7</span>
                                    <div>
                                        <h5>Klasifikasi Pelanggaran &amp; Dokumen Sanksi</h5>
                                        <small>Slot unggahan menyesuaikan kategori pelanggaran akhir yang ditetapkan</small>
                                    </div>
                                </div>
                                <div class="card-body pt-4">
                                    <label class="form-label fw-semibold">Klasifikasi Pelanggaran <span class="text-danger">*</span></label>
                                    <div class="row g-3">
                                        @foreach ($klasifikasiOpsi as $val => $opt)
                                            <div class="col-md-4">
                                                <input type="radio" class="btn-check" id="klas_{{ $loop->index }}" value="{{ $val }}"
                                                    wire:model.live="klasifikasi_pelanggaran" autocomplete="off">
                                                <label class="btn btn-outline-{{ $opt['color'] }} w-100 ap-choice position-relative" for="klas_{{ $loop->index }}">
                                                    @if ($rekomendasi === $val)
                                                        <span class="badge bg-primary position-absolute top-0 start-50 translate-middle">Rekomendasi</span>
                                                    @endif
                                                    <i class="bx {{ $opt['icon'] }}"></i>
                                                    <span class="fw-semibold">{{ str_replace('Pelanggaran ', '', $val) }}</span>
                                                    <small>{{ $opt['desc'] }}</small>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                    @error('klasifikasi_pelanggaran')
                                        <div class="text-danger small mt-2">{{ $message }}</div>
                                    @enderror

                                    @if ($rekomendasi && $klasifikasi_pelanggaran && $klasifikasi_pelanggaran !== $rekomendasi)
                                        <div class="alert alert-warning small d-flex gap-2 mt-3 mb-0">
                                            <i class="bx bx-info-circle fs-5"></i>
                                            <div>Klasifikasi berbeda dari rekomendasi skor sistem — tindakan tercatat sebagai <strong>Anulir Rekomendasi</strong>. Pastikan justifikasi telah diisi.</div>
                                        </div>
                                    @endif

                                    @if ($klasifikasi_pelanggaran)
                                        <hr class="my-4">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h6 class="mb-0 fw-semibold">Dokumen Sanksi Administratif</h6>
                                            @php
                                                $docs = $this->dokumen_sanksi;
                                                $uploaded = collect($docs)->filter(fn ($d) => $pelanggaran->{$d['col']} || $this->{$d['prop']})->count();
                                            @endphp
                                            <span class="badge bg-label-primary">{{ $uploaded }} / {{ count($docs) }} terunggah</span>
                                        </div>
                                        <div class="row g-3">
                                            @foreach ($docs as $i => $doc)
                                                @php
                                                    $existing = $pelanggaran->{$doc['col']};
                                                    $temp = $this->{$doc['prop']};
                                                @endphp
                                                <div class="col-md-6" wire:key="doc-{{ $doc['prop'] }}">
                                                    <div class="ap-doc {{ $existing || $temp ? 'is-done' : '' }}">
                                                        <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                                                            <div class="d-flex align-items-center gap-2">
                                                                <span class="ap-doc-no">{{ $i + 1 }}</span>
                                                                <span class="fw-semibold small">{{ $doc['label'] }}</span>
                                                            </div>
                                                            @if ($existing)
                                                                <a href="{{ Storage::url($existing) }}" target="_blank" class="badge bg-label-success flex-shrink-0">
                                                                    <i class="bx bx-show"></i> Lihat
                                                                </a>
                                                            @endif
                                                        </div>
                                                        <input type="file" wire:model="{{ $doc['prop'] }}" accept=".pdf,.jpg,.jpeg,.png"
                                                            class="form-control form-control-sm @error($doc['prop']) is-invalid @enderror">
                                                        <div wire:loading wire:target="{{ $doc['prop'] }}" class="small text-info mt-1">
                                                            <i class="bx bx-loader-alt bx-spin"></i> Mengunggah...
                                                        </div>
                                                        @if ($temp)
                                                            <div class="small text-success mt-1 text-truncate">
                                                                <i class="bx bx-check"></i> {{ $temp->getClientOriginalName() }}
                                                            </div>
                                                        @endif
                                                        @error($doc['prop'])
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif

                                    <hr class="my-4">
                                    <h6 class="fw-semibold mb-3">Dokumentasi Tindak Lanjut <span class="badge bg-label-secondary ms-1">Opsional</span></h6>
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <label for="foto_tindak_lanjut" class="form-label fw-semibold">Foto Tindak Lanjut</label>
                                            <input type="file" wire:model="foto_tindak_lanjut" multiple id="foto_tindak_lanjut" accept="image/*"
                                                class="form-control @error('foto_tindak_lanjut.*') is-invalid @enderror">
                                            <div wire:loading wire:target="foto_tindak_lanjut" class="small text-info mt-1">
                                                <i class="bx bx-loader-alt bx-spin"></i> Mengunggah...
                                            </div>
                                            @error('foto_tindak_lanjut.*')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="upload_bukti_perizinan" class="form-label fw-semibold">Bukti Perizinan (PDF)</label>
                                            <input type="file" wire:model="upload_bukti_perizinan" id="upload_bukti_perizinan" accept=".pdf"
                                                class="form-control @error('upload_bukti_perizinan') is-invalid @enderror">
                                            @error('upload_bukti_perizinan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            @if ($pelanggaran->bukti_perizinan)
                                                <a href="{{ Storage::url($pelanggaran->bukti_perizinan) }}" target="_blank" class="small d-inline-block mt-1">
                                                    <i class="bx bx-file"></i> Lihat berkas tersimpan
                                                </a>
                                            @endif
                                        </div>
                                    </div>

                                    @if (!empty($existing_foto_tindak_lanjut) || !empty($foto_tindak_lanjut))
                                        <div class="d-flex flex-wrap gap-3 mt-4">
                                            @foreach ($existing_foto_tindak_lanjut as $idx => $foto)
                                                <div class="ap-thumb" wire:key="foto-ex-{{ $idx }}">
                                                    <a href="{{ Storage::url($foto) }}" target="_blank">
                                                        <img src="{{ Storage::url($foto) }}" alt="Foto Tindak Lanjut">
                                                    </a>
                                                    <button type="button" class="btn btn-danger" title="Hapus"
                                                        wire:click="removeExistingImage({{ $idx }})" wire:confirm="Hapus foto ini?">
                                                        <i class="bx bx-x"></i>
                                                    </button>
                                                </div>
                                            @endforeach
                                            @foreach ($foto_tindak_lanjut as $idx => $foto)
                                                <div class="ap-thumb" wire:key="foto-new-{{ $idx }}">
                                                    <img src="{{ $foto->temporaryUrl() }}" alt="Foto Baru" style="border-color: #71dd37;">
                                                    <button type="button" class="btn btn-secondary" title="Batal"
                                                        wire:click="removeImage({{ $idx }})">
                                                        <i class="bx bx-x"></i>
                                                    </button>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @elseif ($isTidakAda)
                        {{-- LANGKAH 2 (Tidak Ada Pelanggaran): Berkas Perizinan --}}
                        @php
                            $berkasIzin = [
                                ['prop' => 'upload_kkpr_skrk', 'col' => 'file_kkpr_skrk', 'label' => 'KKPR / SKRK'],
                                ['prop' => 'upload_pbg_imb', 'col' => 'file_pbg_imb', 'label' => 'PBG / IMB'],
                                ['prop' => 'upload_nib_kbli', 'col' => 'file_nib_kbli', 'label' => 'NIB / KBLI'],
                            ];
                        @endphp
                        <div class="ap-step-pane {{ $activeStep === 2 ? 'is-active' : '' }}" id="step-perizinan">
                            <div class="card ap-section">
                                <div class="card-header ap-card-header">
                                    <span class="ap-step-no" style="background: rgba(113,221,55,.16); color: #71dd37;"><i class="bx bx-check"></i></span>
                                    <div>
                                        <h5>Berkas Perizinan <span class="badge bg-label-secondary ms-1">Opsional</span></h5>
                                        <small>Lampirkan perizinan yang sah sebagai arsip pengawasan</small>
                                    </div>
                                </div>
                                <div class="card-body pt-4">
                                    <div class="row g-3">
                                        @foreach ($berkasIzin as $doc)
                                            @php
                                                $existing = $pelanggaran->{$doc['col']};
                                                $temp = $this->{$doc['prop']};
                                            @endphp
                                            <div class="col-md-4" wire:key="izin-{{ $doc['prop'] }}">
                                                <div class="ap-doc {{ $existing || $temp ? 'is-done' : '' }}">
                                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                                        <span class="fw-semibold small">{{ $doc['label'] }}</span>
                                                        @if ($existing)
                                                            <a href="{{ Storage::url($existing) }}" target="_blank" class="badge bg-label-success">
                                                                <i class="bx bx-show"></i> Lihat
                                                            </a>
                                                        @endif
                                                    </div>
                                                    <input type="file" wire:model="{{ $doc['prop'] }}" accept=".pdf,.jpg,.jpeg,.png"
                                                        class="form-control form-control-sm @error($doc['prop']) is-invalid @enderror">
                                                    <div wire:loading wire:target="{{ $doc['prop'] }}" class="small text-info mt-1">
                                                        <i class="bx bx-loader-alt bx-spin"></i> Mengunggah...
                                                    </div>
                                                    @error($doc['prop'])
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Action Bar Wizard Navigation --}}
                    <div class="card ap-actionbar shadow">
                        <div class="card-body py-3 d-flex flex-wrap justify-content-between align-items-center gap-2">
                            <div class="d-flex align-items-center gap-2">
                                <a href="{{ route('pelanggaran.detail', $pelanggaran->id) }}" class="btn btn-outline-secondary">
                                    Batal
                                </a>
                                @if ($activeStep > 1)
                                    <button type="button" class="btn btn-outline-primary" wire:click="prevStep" wire:loading.attr="disabled">
                                        <i class="bx bx-chevron-left me-1"></i> Sebelumnya
                                    </button>
                                @endif
                            </div>

                            <span class="small text-muted fw-semibold d-none d-sm-inline">
                                Langkah {{ $activeStep }} / {{ $totalSteps }}
                            </span>

                            <div class="d-flex align-items-center gap-2">
                                @if ($activeStep < $totalSteps)
                                    <button type="button" class="btn btn-primary px-4" wire:click="nextStep"
                                        wire:loading.attr="disabled" wire:target="nextStep" @disabled(!$temuan_pelanggaran)>
                                        <span wire:loading.remove wire:target="nextStep">
                                            Selanjutnya <i class="bx bx-chevron-right ms-1"></i>
                                        </span>
                                        <span wire:loading wire:target="nextStep">
                                            <i class="bx bx-loader-alt bx-spin me-1"></i> Memeriksa...
                                        </span>
                                    </button>
                                @else
                                    <button type="submit" class="btn btn-success px-4" wire:loading.attr="disabled"
                                        wire:target="storeAnalisa" @disabled(!$temuan_pelanggaran)>
                                        <span wire:loading.remove wire:target="storeAnalisa">
                                            <i class="bx bx-save me-1"></i> Simpan Analisis
                                        </span>
                                        <span wire:loading wire:target="storeAnalisa">
                                            <i class="bx bx-loader-alt bx-spin me-1"></i> Menyimpan...
                                        </span>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@script
<script>
    $wire.on('wizard-step-changed', () => {
        const el = document.getElementById('wizard-stepper-top');
        if (el) {
            el.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    });
</script>
@endscript
