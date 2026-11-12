@php
    use App\Models\Pelanggaran;

    $isAda = $temuan_pelanggaran === 'Ada Pelanggaran';
    $isTidakAda = $temuan_pelanggaran === 'Tidak Ada Pelanggaran';
    $rekomendasi = $this->rekomendasi_sistem;

    $klasifikasiOpsi = [
        'Pelanggaran Rendah' => ['color' => 'success', 'icon' => 'bx-shield', 'desc' => '3 dokumen sanksi'],
        'Pelanggaran Sedang' => ['color' => 'warning', 'icon' => 'bx-shield-quarter', 'desc' => '6 dokumen sanksi'],
        'Pelanggaran Tinggi' => ['color' => 'danger', 'icon' => 'bx-shield-x', 'desc' => '8 dokumen sanksi'],
    ];

    $steps = [
        ['id' => 'step-kesimpulan', 'label' => 'Kesimpulan Pemeriksaan', 'done' => (bool) $temuan_pelanggaran, 'show' => true],
        ['id' => 'step-indikasi', 'label' => 'Indikasi & Jenis Pelanggaran', 'done' => $jenis_indikasi_pelanggaran && $kategori_pelanggaran && $jenis_pelanggaran, 'show' => $isAda],
        ['id' => 'step-dampak', 'label' => 'Kajian Dampak', 'done' => $dampak_keluhan_masyarakat && $dampak_radius_wilayah, 'show' => $isAda],
        ['id' => 'step-expert', 'label' => 'Expert Judgment', 'done' => $expert_tindakan_rekomendasi && filled($expert_justifikasi), 'show' => $isAda],
        ['id' => 'step-klasifikasi', 'label' => 'Klasifikasi & Dokumen Sanksi', 'done' => (bool) $klasifikasi_pelanggaran, 'show' => $isAda],
        ['id' => 'step-dokumentasi', 'label' => 'Dokumentasi (Opsional)', 'done' => !empty($existing_foto_tindak_lanjut) || !empty($foto_tindak_lanjut), 'show' => $isAda],
        ['id' => 'step-perizinan', 'label' => 'Berkas Perizinan (Opsional)', 'done' => false, 'show' => $isTidakAda],
    ];
    $visibleSteps = array_values(array_filter($steps, fn ($s) => $s['show']));
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

        .ap-progress-item { display: flex; align-items: center; gap: .6rem; padding: .45rem .25rem; color: #697a8d; text-decoration: none; border-radius: .375rem; }
        .ap-progress-item:hover { background: #f5f5f9; color: #566a7f; }
        .ap-progress-item i { font-size: 1.15rem; }
        .ap-progress-item.is-done { color: #566a7f; }
        .ap-progress-item.is-done i { color: #71dd37; }

        .ap-option { display: flex; gap: .75rem; align-items: flex-start; padding: .85rem 1rem; border: 1px solid #d9dee3; border-radius: .5rem; cursor: pointer; transition: all .15s ease; height: 100%; margin: 0; }
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
                    {{-- Progres --}}
                    <div class="card">
                        <div class="card-body">
                            <h6 class="fw-semibold mb-3"><i class="bx bx-list-check me-1"></i> Progres Analisis</h6>
                            <div class="d-flex flex-column">
                                @foreach ($visibleSteps as $i => $step)
                                    <a href="#{{ $step['id'] }}" class="ap-progress-item {{ $step['done'] ? 'is-done' : '' }}">
                                        <i class="bx {{ $step['done'] ? 'bxs-check-circle' : 'bx-circle' }}"></i>
                                        <span class="small">{{ $i }}. {{ $step['label'] }}</span>
                                    </a>
                                @endforeach
                            </div>

                            @if ($isAda && ($rekomendasi || $klasifikasi_pelanggaran))
                                <hr class="my-3">
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
                            @endif
                        </div>
                    </div>

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
                                <div class="ap-info-value">{{ $pelanggaran->pemanfaatan_ruang ?: '-' }}</div>
                            </div>
                            <div class="ap-info-row">
                                <div class="ap-info-label">Peruntukan dalam RTR</div>
                                <div class="ap-info-value">{{ $pelanggaran->jenis_pemanfaatan_ruang ?: '-' }}</div>
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

            {{-- ================= KOLOM KANAN (FORM) ================= --}}
            <div class="col-lg-8 order-1 order-lg-2">
                <form wire:submit.prevent="storeAnalisa" class="d-flex flex-column gap-4">

                    {{-- STEP 0: Kesimpulan --}}
                    <div class="card ap-section" id="step-kesimpulan">
                        <div class="card-header ap-card-header">
                            <span class="ap-step-no">0</span>
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
                                        <small>Lanjutkan ke alur sanksi administrasi</small>
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
                        </div>
                    </div>

                    @if ($isAda)
                        {{-- STEP 1: Indikasi, Kategori, Jenis --}}
                        <div class="card ap-section" id="step-indikasi">
                            <div class="card-header ap-card-header">
                                <span class="ap-step-no">1</span>
                                <div>
                                    <h5>Indikasi, Kategori &amp; Jenis Pelanggaran</h5>
                                    <small>Sesuai bagan alur pengenaan sanksi administrasi</small>
                                </div>
                            </div>
                            <div class="card-body pt-4">
                                {{-- Indikasi --}}
                                <label class="form-label fw-semibold">Jenis Indikasi Pelanggaran <span class="text-danger">*</span></label>
                                <div class="d-flex flex-column gap-2 mb-1">
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
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror

                                {{-- Kategori --}}
                                @if ($jenis_indikasi_pelanggaran)
                                    @php
                                        $kategoriKeys = $jenis_indikasi_pelanggaran === 'menghalangi_akses_umum'
                                            ? ['akses_umum']
                                            : ['tanpa_kkpr', 'tidak_sesuai_kkpr'];
                                    @endphp
                                    <label class="form-label fw-semibold mt-4">Kategori Pelanggaran <span class="text-danger">*</span></label>
                                    <div class="row g-2 mb-1">
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
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                @endif

                                {{-- Jenis --}}
                                @if ($kategori_pelanggaran && isset(Pelanggaran::JENIS_PER_KATEGORI[$kategori_pelanggaran]))
                                    <div class="mt-4">
                                        <label for="jenis_pelanggaran" class="form-label fw-semibold">Jenis Pelanggaran <span class="text-danger">*</span></label>
                                        <select wire:model.live="jenis_pelanggaran" id="jenis_pelanggaran"
                                            class="form-select @error('jenis_pelanggaran') is-invalid @enderror">
                                            <option value="">-- Pilih Jenis Pelanggaran --</option>
                                            @foreach (Pelanggaran::JENIS_PER_KATEGORI[$kategori_pelanggaran] as $key)
                                                <option value="{{ $key }}">{{ Pelanggaran::JENIS_MAP[$key]['label'] }}</option>
                                            @endforeach
                                        </select>
                                        @error('jenis_pelanggaran')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- STEP 2: Dampak --}}
                        <div class="card ap-section" id="step-dampak">
                            <div class="card-header ap-card-header">
                                <span class="ap-step-no">2</span>
                                <div>
                                    <h5>Kajian Dampak Pelanggaran</h5>
                                    <small>Menjadi dasar rekomendasi klasifikasi pelanggaran</small>
                                </div>
                            </div>
                            <div class="card-body pt-4">
                                <div class="row g-4">
                                    <div class="col-md-5">
                                        <label class="form-label fw-semibold d-block">Keluhan Masyarakat <span class="text-danger">*</span></label>
                                        <div class="btn-group w-100" role="group">
                                            @foreach (['Ada' => 'Ada', 'Tidak Ada' => 'Tidak Ada'] as $val => $lbl)
                                                <input type="radio" class="btn-check" id="keluhan_{{ Str::slug($val) }}"
                                                    value="{{ $val }}" wire:model.live="dampak_keluhan_masyarakat" autocomplete="off">
                                                <label class="btn btn-outline-primary" for="keluhan_{{ Str::slug($val) }}">{{ $lbl }}</label>
                                            @endforeach
                                        </div>
                                        @error('dampak_keluhan_masyarakat')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-7">
                                        <label class="form-label fw-semibold d-block">Radius Wilayah Terdampak <span class="text-danger">*</span></label>
                                        <div class="btn-group w-100" role="group">
                                            @foreach (['Tidak Ada' => 'Tidak Ada', 'Kecil (< 500 m)' => '< 500 m', 'Besar (> 500 m)' => '> 500 m'] as $val => $lbl)
                                                <input type="radio" class="btn-check" id="radius_{{ $loop->index }}"
                                                    value="{{ $val }}" wire:model.live="dampak_radius_wilayah" autocomplete="off">
                                                <label class="btn btn-outline-primary" for="radius_{{ $loop->index }}">{{ $lbl }}</label>
                                            @endforeach
                                        </div>
                                        @error('dampak_radius_wilayah')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                @if ($rekomendasi)
                                    <div class="alert alert-{{ $klasifikasiOpsi[$rekomendasi]['color'] }} d-flex align-items-center gap-2 mt-4 mb-0" role="alert">
                                        <i class="bx bx-bulb fs-4"></i>
                                        <div>
                                            Rekomendasi sistem: <strong>{{ $rekomendasi }}</strong>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- STEP 3: Expert Judgment --}}
                        <div class="card ap-section" id="step-expert">
                            <div class="card-header ap-card-header">
                                <span class="ap-step-no">3</span>
                                <div>
                                    <h5>Expert Judgment / Kajian Teknis</h5>
                                    <small>Pertimbangan tim ahli terhadap rekomendasi sistem</small>
                                </div>
                            </div>
                            <div class="card-body pt-4">
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
                                                <i class="bx bx-check me-1"></i> Ikuti
                                            </label>
                                            <input type="radio" class="btn-check" id="tindakan_anulir" value="Anulir Rekomendasi"
                                                wire:model.live="expert_tindakan_rekomendasi" autocomplete="off">
                                            <label class="btn btn-outline-warning" for="tindakan_anulir">
                                                <i class="bx bx-revision me-1"></i> Anulir
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
                                        placeholder="Dasar pertimbangan teknis, regulasi yang dilanggar, kondisi lapangan..."></textarea>
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

                        {{-- STEP 4: Klasifikasi & Dokumen Sanksi --}}
                        <div class="card ap-section" id="step-klasifikasi">
                            <div class="card-header ap-card-header">
                                <span class="ap-step-no">4</span>
                                <div>
                                    <h5>Klasifikasi Pelanggaran &amp; Dokumen Sanksi</h5>
                                    <small>Slot unggahan menyesuaikan klasifikasi yang dipilih</small>
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
                                        <div>Klasifikasi berbeda dari rekomendasi sistem — tindakan tercatat sebagai <strong>Anulir Rekomendasi</strong>. Pastikan justifikasi telah diisi.</div>
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
                            </div>
                        </div>

                        {{-- STEP 5: Dokumentasi --}}
                        <div class="card ap-section" id="step-dokumentasi">
                            <div class="card-header ap-card-header">
                                <span class="ap-step-no">5</span>
                                <div>
                                    <h5>Dokumentasi Tindak Lanjut <span class="badge bg-label-secondary ms-1">Opsional</span></h5>
                                    <small>Foto tindak lanjut lapangan dan bukti perizinan</small>
                                </div>
                            </div>
                            <div class="card-body pt-4">
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
                    @elseif ($isTidakAda)
                        {{-- Berkas Perizinan --}}
                        @php
                            $berkasIzin = [
                                ['prop' => 'upload_kkpr_skrk', 'col' => 'file_kkpr_skrk', 'label' => 'KKPR / SKRK'],
                                ['prop' => 'upload_pbg_imb', 'col' => 'file_pbg_imb', 'label' => 'PBG / IMB'],
                                ['prop' => 'upload_nib_kbli', 'col' => 'file_nib_kbli', 'label' => 'NIB / KBLI'],
                            ];
                        @endphp
                        <div class="card ap-section" id="step-perizinan">
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
                    @else
                        <div class="card">
                            <div class="card-body text-center py-5 text-muted">
                                <i class="bx bx-pointer fs-1 d-block mb-2"></i>
                                Pilih kesimpulan pemeriksaan di atas untuk melanjutkan analisis.
                            </div>
                        </div>
                    @endif

                    {{-- Action Bar --}}
                    <div class="card ap-actionbar shadow">
                        <div class="card-body py-3 d-flex flex-wrap justify-content-between align-items-center gap-2">
                            <a href="{{ route('pelanggaran.detail', $pelanggaran->id) }}" class="btn btn-outline-secondary">
                                Batal
                            </a>
                            <button type="submit" class="btn btn-primary px-4" wire:loading.attr="disabled"
                                wire:target="storeAnalisa" @disabled(!$temuan_pelanggaran)>
                                <span wire:loading.remove wire:target="storeAnalisa">
                                    <i class="bx bx-save me-1"></i> Simpan Analisis
                                </span>
                                <span wire:loading wire:target="storeAnalisa">
                                    <i class="bx bx-loader-alt bx-spin me-1"></i> Menyimpan...
                                </span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
