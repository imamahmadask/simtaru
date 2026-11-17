<div>
    <style>
        .pa-kv-list {
            display: flex;
            flex-direction: column;
        }
        .pa-kv-item {
            display: grid;
            grid-template-columns: 1fr;
            gap: 0.2rem;
            padding: 0.7rem 0;
            border-bottom: 1px dashed #eceef1;
        }
        .pa-kv-item:first-child {
            padding-top: 0;
        }
        .pa-kv-item:last-child {
            border-bottom: 0;
            padding-bottom: 0;
        }
        .pa-kv-label {
            font-size: 0.78rem;
            font-weight: 600;
            color: #697a8d;
        }
        .pa-kv-value {
            color: #32475c;
            font-size: 0.92rem;
            overflow-wrap: anywhere;
            word-break: break-word;
        }
        .pa-photo-grid-item {
            display: block;
            width: 100%;
            aspect-ratio: 1 / 1;
            overflow: hidden;
            border-radius: 0.5rem;
            border: 1px solid #d9dee3;
            background: #f8f9fa;
        }
        .pa-photo-grid-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
        .pa-tpl-btn {
            white-space: normal !important;
            text-align: left;
            line-height: 1.3;
        }
        @media (min-width: 768px) {
            .pa-kv-item {
                grid-template-columns: 35% 1fr;
                gap: 0.25rem 0.75rem;
                padding: 0.5rem 0;
                border-bottom: 0;
                align-items: baseline;
            }
            .pa-kv-label {
                font-size: 0.9rem;
                color: #566a7f;
            }
        }
    </style>

    <div class="row">
        <div class="col-md-12">
            <div class="mb-3 d-flex flex-column flex-sm-row flex-wrap gap-2">
                <a href="{{ route('pelanggaran.analis', $pelanggaran->id) }}" class="btn btn-{{ $pelanggaran->temuan_pelanggaran ? 'warning' : 'primary' }} flex-fill flex-sm-grow-0">
                    <i class="bx bx-{{ $pelanggaran->temuan_pelanggaran ? 'edit' : 'plus' }} me-1"></i>
                    {{ $pelanggaran->temuan_pelanggaran ? 'Edit Analisa Pelanggaran' : 'Mulai Analisa Pelanggaran' }}
                </a>
                <button type="button" class="btn btn-info flex-fill flex-sm-grow-0" data-bs-toggle="modal" data-bs-target="#EvaluasiModal">
                    <i class="bx bx-calendar-check me-1"></i> Evaluasi
                </button>
            </div>
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Analisis</h5>
                </div>
                <div class="card-body">
                    <div class="pa-kv-list">
                        <div class="pa-kv-item">
                            <div class="pa-kv-label">Kesimpulan Pelanggaran</div>
                            <div class="pa-kv-value text-start">
                                <span class="d-none d-md-inline me-1 text-muted">:</span>
                                @if ($pelanggaran->temuan_pelanggaran == 'Ada Pelanggaran')
                                    <span class="badge bg-danger">Ada Pelanggaran</span>
                                @elseif ($pelanggaran->temuan_pelanggaran == 'Tidak Ada Pelanggaran')
                                    <span class="badge bg-success">Tidak Ada Pelanggaran</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </div>
                        </div>
                        @if ($pelanggaran->temuan_pelanggaran == 'Ada Pelanggaran')
                            @if ($pelanggaran->klasifikasi_pelanggaran)
                                <div class="pa-kv-item">
                                    <div class="pa-kv-label">Klasifikasi Pelanggaran</div>
                                    <div class="pa-kv-value text-start">
                                        @php
                                            $badgeColor = match($pelanggaran->klasifikasi_pelanggaran) {
                                                'Pelanggaran Rendah' => 'success',
                                                'Pelanggaran Sedang' => 'warning',
                                                'Pelanggaran Tinggi' => 'danger',
                                                default => 'secondary'
                                            };
                                        @endphp
                                        <span class="d-none d-md-inline me-1 text-muted">:</span>
                                        <span class="badge bg-{{ $badgeColor }} fs-6">{{ $pelanggaran->klasifikasi_pelanggaran }}</span>
                                    </div>
                                </div>
                            @endif
                            @if ($pelanggaran->jenis_indikasi_pelanggaran)
                                <div class="pa-kv-item">
                                    <div class="pa-kv-label">A. Indikasi Pelanggaran</div>
                                    <div class="pa-kv-value text-start fw-semibold"><span class="d-none d-md-inline me-1 text-muted fw-normal">:</span>{{ $pelanggaran->indikasi_label }}</div>
                                </div>
                            @endif
                            @if ($pelanggaran->kategori_pelanggaran)
                                <div class="pa-kv-item">
                                    <div class="pa-kv-label">A. Kategori Pelanggaran</div>
                                    <div class="pa-kv-value text-start"><span class="d-none d-md-inline me-1 text-muted">:</span>{{ $pelanggaran->kategori_label }}</div>
                                </div>
                            @endif
                            @if ($pelanggaran->jenis_pelanggaran)
                                @php
                                    $jenisItems = $pelanggaran->jenis_pelanggaran_list;
                                @endphp
                                <div class="pa-kv-item">
                                    <div class="pa-kv-label">A. Sub-Pelanggaran <span class="text-muted fw-normal small">(40%)</span></div>
                                    <div class="pa-kv-value text-start">
                                        @if (count($jenisItems) > 1)
                                            <ul class="mb-0 ps-3 text-danger fw-semibold">
                                                @foreach ($jenisItems as $slug)
                                                    @php $meta = \App\Models\Pelanggaran::JENIS_MAP[$slug] ?? null; @endphp
                                                    <li class="mb-1">
                                                        {{ $meta['label'] ?? $slug }}
                                                        @if ($meta)
                                                            <span class="badge bg-label-secondary ms-1">Nilai {{ $meta['nilai'] }}</span>
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <span class="d-none d-md-inline me-1 text-muted">:</span>
                                            <span class="text-danger fw-semibold">{{ $pelanggaran->jenis_pelanggaran_label }}</span>
                                        @endif
                                    </div>
                                </div>
                            @endif
                            @if ($pelanggaran->dampak_keluhan_masyarakat || $pelanggaran->dampak_radius_wilayah)
                                <div class="pa-kv-item">
                                    <div class="pa-kv-label">B. Dampak Masyarakat <span class="text-muted fw-normal small">(35%)</span></div>
                                    <div class="pa-kv-value text-start">
                                        <div class="d-flex flex-wrap align-items-center gap-2">
                                            <span class="d-none d-md-inline text-muted">:</span>
                                            <span>Kategori Dampak: <span class="badge bg-label-primary">{{ $pelanggaran->dampak_label }}</span></span>
                                            @if ($pelanggaran->dampak_keluhan_masyarakat)
                                                <span>Keluhan: <span class="badge bg-label-info">{{ $pelanggaran->dampak_keluhan_masyarakat }}</span></span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if ($pelanggaran->skala_pelanggaran)
                                <div class="pa-kv-item">
                                    <div class="pa-kv-label">C. Skala &amp; Intensitas <span class="text-muted fw-normal small">(15%)</span></div>
                                    <div class="pa-kv-value text-start"><span class="d-none d-md-inline me-1 text-muted">:</span>{{ $pelanggaran->skala_label }}</div>
                                </div>
                            @endif
                            @if ($pelanggaran->riwayat_pelanggaran)
                                <div class="pa-kv-item">
                                    <div class="pa-kv-label">D. Riwayat Pelanggaran <span class="text-muted fw-normal small">(10%)</span></div>
                                    <div class="pa-kv-value text-start"><span class="d-none d-md-inline me-1 text-muted">:</span>{{ $pelanggaran->riwayat_label }}</div>
                                </div>
                            @endif
                            @if ($pelanggaran->skor_total !== null)
                                @php
                                    $rincianSkor = \App\Models\Pelanggaran::hitungSkorPenilaian(
                                        $pelanggaran->jenis_pelanggaran,
                                        $pelanggaran->dampak_radius_wilayah,
                                        $pelanggaran->skala_pelanggaran,
                                        $pelanggaran->riwayat_pelanggaran
                                    );
                                @endphp
                                <div class="pa-kv-item">
                                    <div class="pa-kv-label">Skor Penilaian (S)</div>
                                    <div class="pa-kv-value text-start">
                                        <div class="d-flex flex-wrap align-items-center gap-2">
                                            <span class="d-none d-md-inline text-muted">:</span>
                                            <span class="badge bg-primary fs-6">{{ number_format((float) $pelanggaran->skor_total, 2) }}</span>
                                            @if ($rincianSkor['rekomendasi_kategori'])
                                                <span class="small text-muted">
                                                    (Rekomendasi Skor: <strong>{{ $rincianSkor['rekomendasi_kategori'] }}</strong>)
                                                </span>
                                            @endif
                                        </div>
                                        <div class="small text-muted mt-1">
                                            Rincian Hasil: A={{ number_format($rincianSkor['hasil_a'], 2) }},
                                            B={{ number_format($rincianSkor['hasil_b'], 2) }},
                                            C={{ number_format($rincianSkor['hasil_c'], 2) }},
                                            D={{ number_format($rincianSkor['hasil_d'], 2) }}
                                            &rarr; Jumlah {{ number_format($rincianSkor['jumlah_abcd'], 2) }} × 20
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="pa-kv-item">
                                <div class="pa-kv-label">Tindak Lanjut (Sanksi)</div>
                                <div class="pa-kv-value text-start fw-bold text-primary"><span class="d-none d-md-inline me-1 text-muted fw-normal">:</span>{{ $pelanggaran->tindak_lanjut ?? '-' }}</div>
                            </div>
                            @if ($pelanggaran->expert_user_name || $pelanggaran->expert_tindakan_rekomendasi)
                                <div class="pa-kv-item">
                                    <div class="pa-kv-label">Expert Judgment</div>
                                    <div class="pa-kv-value text-start">
                                        <div class="d-flex flex-wrap align-items-center gap-2">
                                            <span class="d-none d-md-inline text-muted">:</span>
                                            <small class="text-muted">Analis: <strong>{{ $pelanggaran->expert_user_name ?? ($pelanggaran->expertUser?->name ?? '-') }}</strong></small>
                                            <span class="badge bg-{{ $pelanggaran->expert_tindakan_rekomendasi == 'Ikuti Rekomendasi' ? 'label-success' : 'label-warning' }}">
                                                {{ $pelanggaran->expert_tindakan_rekomendasi ?? 'Ikuti Rekomendasi' }}
                                            </span>
                                        </div>
                                        @if ($pelanggaran->expert_justifikasi)
                                            <div class="mt-2 small"><strong>Justifikasi:</strong> {{ $pelanggaran->expert_justifikasi }}</div>
                                        @endif
                                        @if ($pelanggaran->expert_kesimpulan)
                                            <div class="mt-1 small"><strong>Kesimpulan:</strong> {{ $pelanggaran->expert_kesimpulan }}</div>
                                        @endif
                                        @if ($pelanggaran->expert_dokumen_pendukung && count($pelanggaran->expert_dokumen_pendukung) > 0)
                                            <div class="mt-2">
                                                <strong class="small">Dokumen Pendukung Expert:</strong>
                                                <div class="d-flex flex-wrap gap-1 mt-1">
                                                    @foreach ($pelanggaran->expert_dokumen_pendukung as $idx => $doc)
                                                        <a href="{{ Storage::url($doc) }}" target="_blank" class="btn btn-outline-info btn-xs">
                                                            <i class="bx bx-file me-1"></i> Berkas {{ $idx + 1 }}
                                                        </a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        @else
                            <div class="pa-kv-item">
                                <div class="pa-kv-label">Tindak Lanjut</div>
                                <div class="pa-kv-value text-start"><span class="d-none d-md-inline me-1 text-muted">:</span>{{ $pelanggaran->tindak_lanjut ?? '-' }}</div>
                            </div>
                        @endif
                        <div class="pa-kv-item">
                            <div class="pa-kv-label">Tanggal Evaluasi</div>
                            <div class="pa-kv-value text-start">
                                <span class="d-none d-md-inline me-1 text-muted">:</span>
                                {{ $pelanggaran->tgl_evaluasi ? \Carbon\Carbon::parse($pelanggaran->tgl_evaluasi)->translatedFormat('d F Y') : '-' }}
                            </div>
                        </div>
                        <div class="pa-kv-item">
                            <div class="pa-kv-label">Hasil Evaluasi</div>
                            <div class="pa-kv-value text-start"><span class="d-none d-md-inline me-1 text-muted">:</span>{{ $pelanggaran->hasil_evaluasi ?? '-' }}</div>
                        </div>
                        <div class="pa-kv-item">
                            <div class="pa-kv-label">Status Terkini</div>
                            <div class="pa-kv-value text-start">
                                <span class="d-none d-md-inline me-1 text-muted">:</span>
                                <span
                                    class="badge bg-{{ $pelanggaran->status == 'Selesai' ? 'success' : ($pelanggaran->status == 'Pelimpahan Berkas' ? 'primary' : 'warning') }}">
                                    {{ $pelanggaran->status }}
                                </span>
                            </div>
                        </div>
                        @if ($pelanggaran->temuan_pelanggaran == 'Tidak Ada Pelanggaran')
                            <div class="pa-kv-item">
                                <div class="pa-kv-label">Berkas KKPR/SKRK</div>
                                <div class="pa-kv-value text-start">
                                    <span class="d-none d-md-inline me-1 text-muted">:</span>
                                    @if($pelanggaran->file_kkpr_skrk)
                                        <a href="{{ Storage::url($pelanggaran->file_kkpr_skrk) }}" target="_blank" class="btn btn-primary btn-sm"><i class="bx bx-file me-1"></i>Lihat Berkas</a>
                                    @else
                                        -
                                    @endif
                                </div>
                            </div>
                            <div class="pa-kv-item">
                                <div class="pa-kv-label">Berkas PBG/IMB</div>
                                <div class="pa-kv-value text-start">
                                    <span class="d-none d-md-inline me-1 text-muted">:</span>
                                    @if($pelanggaran->file_pbg_imb)
                                        <a href="{{ Storage::url($pelanggaran->file_pbg_imb) }}" target="_blank" class="btn btn-primary btn-sm"><i class="bx bx-file me-1"></i>Lihat Berkas</a>
                                    @else
                                        -
                                    @endif
                                </div>
                            </div>
                            <div class="pa-kv-item">
                                <div class="pa-kv-label">Berkas NIB KBLI</div>
                                <div class="pa-kv-value text-start">
                                    <span class="d-none d-md-inline me-1 text-muted">:</span>
                                    @if($pelanggaran->file_nib_kbli)
                                        <a href="{{ Storage::url($pelanggaran->file_nib_kbli) }}" target="_blank" class="btn btn-primary btn-sm"><i class="bx bx-file me-1"></i>Lihat Berkas</a>
                                    @else
                                        -
                                    @endif
                                </div>
                            </div>
                        @else
                            <div class="pa-kv-item">
                                <div class="pa-kv-label">Bukti Perizinan</div>
                                <div class="pa-kv-value text-start">
                                    <span class="d-none d-md-inline me-1 text-muted">:</span>
                                    @if($pelanggaran->bukti_perizinan)
                                        <a href="{{ Storage::url($pelanggaran->bukti_perizinan) }}" target="_blank" class="btn btn-primary btn-sm"><i class="bx bx-file me-1"></i>Lihat Berkas</a>
                                    @else
                                        -
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>

                    <hr>

                    <div class="my-3">
                        <label for="foto_tindak_lanjut" class="form-label fw-bold">Foto Tindak Lanjut</label>
                        @if ($pelanggaran->foto_tindak_lanjut)
                            <div class="row g-2 g-md-3 mt-1">
                                @foreach ($pelanggaran->foto_tindak_lanjut as $foto)
                                    <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                                        <a href="{{ asset('storage/' . $foto) }}" target="_blank" class="pa-photo-grid-item">
                                            <img src="{{ asset('storage/' . $foto) }}" alt="Foto Tindak Lanjut">
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted small fst-italic mt-1 mb-0">Tidak ada foto tindak lanjut</p>
                        @endif
                    </div>

                    <hr>

                    <div class="my-3">
                        <label class="form-label fw-bold">Foto Lokasi Terkini (Evaluasi)</label>
                        @if ($pelanggaran->foto_existing)
                            <div class="row g-2 g-md-3 mt-1">
                                @foreach ($pelanggaran->foto_existing as $foto)
                                    <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                                        <a href="{{ asset('storage/' . $foto) }}" target="_blank" class="pa-photo-grid-item">
                                            <img src="{{ asset('storage/' . $foto) }}" alt="Foto Evaluasi">
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted small fst-italic mt-1 mb-0">Belum ada foto evaluasi lokasi</p>
                        @endif
                    </div>

                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="mb-0">Template Surat</h5>
                </div>
                <div class="card-body">
                    <div class="row g-2 mt-1">
                        @php
                            $templatesSurat = [
                                ['label' => 'SP 1', 'download' => 'downloadSP1', 'file' => 'file_sp1'],
                                ['label' => 'SP 2', 'download' => 'downloadSP2', 'file' => 'file_sp2'],
                                ['label' => 'SP 3', 'download' => 'downloadSP3', 'file' => 'file_sp3'],
                                [
                                    'label' => 'Pelimpahan Berkas Pol PP',
                                    'download' => 'downloadSuratPelimpahanBerkasPolPP',
                                    'file' => 'file_pelimpahan_polpp',
                                ],
                                [
                                    'label' => 'Surat Pernyataan',
                                    'download' => 'downloadSuratPernyataan',
                                    'file' => 'file_pernyataan',
                                ],
                                [
                                    'label' => 'Surat Sosialisasi',
                                    'download' => 'downloadSuratSosialisasi',
                                    'file' => 'file_sosialisasi',
                                ],
                            ];
                        @endphp

                        @foreach ($templatesSurat as $tpl)
                            <div class="col-12 col-sm-6 col-md-4">
                                <div class="btn-group w-100">
                                    <button wire:click="{{ $tpl['download'] }}"
                                        class="btn btn-outline-primary btn-sm flex-grow-1 pa-tpl-btn d-flex align-items-center justify-content-center gap-1" title="Download Template">
                                        <i class="bx bx-download flex-shrink-0"></i>
                                        <span>{{ $tpl['label'] }}</span>
                                    </button>
                                    @if ($pelanggaran->{$tpl['file']})
                                        <a href="{{ Storage::url($pelanggaran->{$tpl['file']}) }}" target="_blank"
                                            class="btn btn-primary btn-sm flex-shrink-0 d-flex align-items-center" title="Lihat Dokumen Terupload">
                                            <i class="bx bx-show"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="mb-0">Template Berita Acara</h5>
                </div>
                <div class="card-body">
                    <div class="row g-2 mt-1">
                        @php
                            $templatesBa = [
                                [
                                    'label' => 'Upload BA Pengambilan Dokumen',
                                    'download' => 'downloadBAPengambilanDokumen',
                                    'file' => 'file_ba_pengambilan_dokumen',
                                ],
                                [
                                    'label' => 'Upload BA Penolakan',
                                    'download' => 'downloadBAPenolakan',
                                    'file' => 'file_ba_penolakan',
                                ],
                                [
                                    'label' => 'Upload BA Survey Lapangan',
                                    'download' => 'downloadBASurvey',
                                    'file' => 'file_ba_survey',
                                ],
                                [
                                    'label' => 'Upload BA Survey Untuk Surveyor',
                                    'download' => 'downloadBASurveySurveyor',
                                    'file' => 'file_ba_survey_surveyor',
                                ],
                                [
                                    'label' => 'Upload BA Wawancara',
                                    'download' => 'downloadBAWawancara',
                                    'file' => 'file_ba_wawancara',
                                ],
                                [
                                    'label' => 'Upload BA Penerapan Sanksi',
                                    'download' => 'downloadPenerapanSanksi',
                                    'file' => 'file_ba_penerapan_sanksi',
                                ],
                                [
                                    'label' => 'Upload BA Sosialisasi',
                                    'download' => 'downloadBASosialisasi',
                                    'file' => 'file_ba_sosialisasi',
                                ],
                                [
                                    'label' => 'Upload SK Sanksi Pemberhentian',
                                    'download' => 'downloadSKSanksiPemberhentian',
                                    'file' => 'file_sk_sanksi_pemberhentian',
                                ],
                            ];
                        @endphp

                        @foreach ($templatesBa as $tpl)
                            <div class="col-12 col-sm-6 col-md-4">
                                <div class="btn-group w-100">
                                    <button wire:click="{{ $tpl['download'] }}"
                                        class="btn btn-outline-primary btn-sm flex-grow-1 pa-tpl-btn d-flex align-items-center justify-content-center gap-1" title="Download Template">
                                        <i class="bx bx-download flex-shrink-0"></i>
                                        <span>{{ $tpl['label'] }}</span>
                                    </button>
                                    @if ($pelanggaran->{$tpl['file']})
                                        <a href="{{ Storage::url($pelanggaran->{$tpl['file']}) }}" target="_blank"
                                            class="btn btn-primary btn-sm flex-shrink-0 d-flex align-items-center" title="Lihat Dokumen Terupload">
                                            <i class="bx bx-show"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="EvaluasiModal" tabindex="-1" aria-labelledby="EvaluasiModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="EvaluasiModalLabel">Evaluasi Pelanggaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form wire:submit.prevent="storeEvaluasi">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="tgl_evaluasi" class="form-label">Tanggal Evaluasi</label>
                            <input type="date" wire:model="tgl_evaluasi"
                                class="form-control @error('tgl_evaluasi') is-invalid @enderror" id="tgl_evaluasi">
                            @error('tgl_evaluasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status_pelanggaran" class="form-label">Status Terkini</label>
                            <select wire:model="status_pelanggaran"
                                class="form-select @error('status_pelanggaran') is-invalid @enderror"
                                id="status_pelanggaran">
                                <option value="">Pilih Status</option>
                                <option value="On Progress">On Progress</option>
                                <option value="Pelimpahan Berkas">Pelimpahan Berkas</option>
                                <option value="Selesai">Selesai</option>
                            </select>
                            @error('status_pelanggaran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="hasil_evaluasi" class="form-label">Hasil Evaluasi</label>
                            <textarea wire:model="hasil_evaluasi" class="form-control @error('hasil_evaluasi') is-invalid @enderror"
                                id="hasil_evaluasi" rows="3" placeholder="Masukkan hasil evaluasi..."></textarea>
                            @error('hasil_evaluasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="temp_foto_existing" class="form-label">Foto Lokasi Terkini (Multiple)</label>
                            <input type="file" wire:model="temp_foto_existing"
                                class="form-control @error('temp_foto_existing.*') is-invalid @enderror"
                                id="temp_foto_existing" multiple accept="image/*">
                            <div wire:loading wire:target="temp_foto_existing" class="text-info mt-1 small">
                                Uploading...</div>
                            @error('temp_foto_existing.*')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            @if (count($existing_foto_existing) > 0)
                                <div class="mt-3">
                                    <label class="form-label small fw-bold">Foto Saat Ini:</label>
                                    <div class="row g-2">
                                        @foreach ($existing_foto_existing as $index => $foto)
                                            <div class="col-4 col-sm-3 position-relative">
                                                <img src="{{ Storage::url($foto) }}" class="img-thumbnail w-100"
                                                    style="aspect-ratio: 1 / 1; object-fit: cover;">
                                                <button type="button"
                                                    wire:click="removeExistingFotoExisting({{ $index }})"
                                                    class="btn btn-danger btn-xs position-absolute top-0 end-0 m-1"
                                                    title="Hapus">
                                                    <i class="bx bx-x"></i>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($temp_foto_existing)
                                <div class="mt-3">
                                    <label class="form-label small fw-bold">Preview Foto Baru:</label>
                                    <div class="row g-2">
                                        @foreach ($temp_foto_existing as $index => $foto)
                                            <div class="col-4 col-sm-3 position-relative">
                                                <img src="{{ $foto->temporaryUrl() }}" class="img-thumbnail w-100"
                                                    style="aspect-ratio: 1 / 1; object-fit: cover;">
                                                <button type="button"
                                                    wire:click="removeTempFotoExisting({{ $index }})"
                                                    class="btn btn-danger btn-xs position-absolute top-0 end-0 m-1"
                                                    title="Hapus">
                                                    <i class="bx bx-x"></i>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Evaluasi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@script
    <script>
        $wire.on('closeEvaluasiModal', () => {
            const modal = bootstrap.Modal.getInstance(document.getElementById('EvaluasiModal'));
            if (modal) {
                modal.hide();
            }
        });
    </script>
@endscript
