<div>
    <style>
        .pd-kv-list {
            display: flex;
            flex-direction: column;
        }
        .pd-kv-item {
            display: grid;
            grid-template-columns: 1fr;
            gap: 0.15rem;
            padding: 0.6rem 0;
            border-bottom: 1px dashed #eceef1;
        }
        .pd-kv-item:first-child {
            padding-top: 0;
        }
        .pd-kv-item:last-child {
            border-bottom: 0;
            padding-bottom: 0;
        }
        .pd-kv-label {
            font-size: 0.78rem;
            font-weight: 600;
            color: #697a8d;
        }
        .pd-kv-value {
            color: #32475c;
            font-size: 0.92rem;
            overflow-wrap: anywhere;
            word-break: break-word;
        }
        .pd-photo-grid-item {
            display: block;
            width: 100%;
            aspect-ratio: 1 / 1;
            overflow: hidden;
            border-radius: 0.5rem;
            border: 1px solid #d9dee3;
            background: #f8f9fa;
        }
        .pd-photo-grid-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
        @media (max-width: 767.98px) {
            .pd-tabs {
                display: grid !important;
                grid-template-columns: 1fr 1fr;
                gap: 0.5rem;
            }
            .pd-tabs .nav-link {
                width: 100%;
                justify-content: center;
            }
        }
        @media (min-width: 576px) {
            .pd-w-sm-auto {
                width: auto !important;
            }
        }
        @media (min-width: 768px) {
            .pd-kv-item {
                grid-template-columns: 35% 1fr;
                gap: 0.25rem 0.75rem;
                padding: 0.45rem 0;
                border-bottom: 0;
                align-items: baseline;
            }
            .pd-kv-label {
                font-size: 0.9rem;
                color: #566a7f;
            }
        }
    </style>

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4">
            <h4 class="fw-bold py-1 py-sm-2 mb-0"><span class="text-muted fw-light">Pelanggaran /</span> Detail Kasus Pelanggaran</h4>
            <div class="d-flex flex-wrap gap-2 w-100 pd-w-sm-auto">
                <a href="{{ route('pelanggaran.edit', $pelanggaran->id) }}" class="btn btn-warning flex-fill flex-sm-grow-0">
                    <i class="bx bx-edit-alt me-1"></i> Edit
                </a>
                <a href="{{ route('pelanggaran.index') }}" class="btn btn-secondary flex-fill flex-sm-grow-0">
                    <i class="bx bx-arrow-back me-1"></i> Kembali
                </a>
            </div>
        </div>

        @if (session()->has('success'))
            <div class="bs-toast toast bg-success fade top-0 end-0 mb-2" role="alert" aria-live="assertive"
                aria-atomic="true" data-bs-delay="3000" data-bs-autohide="true">
                <div class="toast-header">
                    <i class="bx bx-bell me-2"></i>
                    <div class="me-auto fw-semibold">Message!</div>
                    <small>a moment ago</small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">{{ session('success') }}</div>
            </div>
        @endif
        @if (session()->has('error'))
            <div class="bs-toast toast bg-danger fade top-0 end-0 mb-2" role="alert" aria-live="assertive"
                aria-atomic="true" data-bs-delay="3000" data-bs-autohide="true">
                <div class="toast-header">
                    <i class="bx bx-bell me-2"></i>
                    <div class="me-auto fw-semibold">Message!</div>
                    <small>a moment ago</small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">{{ session('error') }}</div>
            </div>
        @endif

        <div class="row">
            <div class="col-xxl-12 mb-4">
                <div class="nav-align-top mb-4">
                    <ul class="nav nav-pills pd-tabs mb-3" role="tablist">
                        <li class="nav-item">
                            <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-detail" aria-controls="navs-pills-detail" aria-selected="true">
                                <i class="bx bx-info-circle me-1"></i> Detail
                            </button>
                        </li>
                        <li class="nav-item">
                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-analisis" aria-controls="navs-pills-analisis" aria-selected="false">
                                <i class="bx bx-history me-1"></i> Analisis
                            </button>
                        </li>
                    </ul>
                    <div class="tab-content p-3 p-md-4">
                        <div class="tab-pane fade show active" id="navs-pills-detail" role="tabpanel">
                            <div class="mb-3">
                                <button type="button" class="btn btn-dark w-100 pd-w-sm-auto" data-bs-toggle="modal" data-bs-target="#ResumePelanggaranModal">
                                    <i class="bx bx-id-card me-1"></i> Resume Pelanggaran
                                </button>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <div class="card h-100">
                                        <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
                                            <h5 class="mb-0">Informasi Umum</h5>
                                            <span
                                                class="badge bg-{{ $pelanggaran->status == 'Selesai' ? 'success' : ($pelanggaran->status == 'Pelimpahan Berkas' ? 'primary' : 'warning') }}">
                                                {{ $pelanggaran->status }}
                                            </span>
                                        </div>
                                        <div class="card-body">
                                            <div class="pd-kv-list">
                                                <div class="pd-kv-item">
                                                    <div class="pd-kv-label">No Kasus</div>
                                                    <div class="pd-kv-value"><span class="d-none d-md-inline me-1 text-muted">:</span><span class="badge bg-danger fs-6 fst-italic text-wrap text-start">{{ $pelanggaran->no_pelanggaran }}</span></div>
                                                </div>
                                                <div class="pd-kv-item">
                                                    <div class="pd-kv-label">Tanggal Laporan</div>
                                                    <div class="pd-kv-value"><span class="d-none d-md-inline me-1 text-muted">:</span>{{ $pelanggaran->tgl_laporan ? \Carbon\Carbon::parse($pelanggaran->tgl_laporan)->translatedFormat('d F Y') : '-' }}</div>
                                                </div>
                                                <div class="pd-kv-item">
                                                    <div class="pd-kv-label">Sumber Informasi</div>
                                                    <div class="pd-kv-value"><span class="d-none d-md-inline me-1 text-muted">:</span>{{ $pelanggaran->sumber_informasi_pelanggaran }}</div>
                                                </div>
                                                @if($pelanggaran->jenis_indikasi_pelanggaran)
                                                <div class="pd-kv-item">
                                                    <div class="pd-kv-label">Jenis Indikasi</div>
                                                    <div class="pd-kv-value"><span class="d-none d-md-inline me-1 text-muted">:</span>{{ $pelanggaran->indikasi_label }}</div>
                                                </div>
                                                @endif
                                                <div class="pd-kv-item">
                                                    <div class="pd-kv-label">Penjelasan Singkat</div>
                                                    <div class="pd-kv-value"><span class="d-none d-md-inline me-1 text-muted">:</span>{{ $pelanggaran->penjelasan_singkat ?? '-' }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <!-- Detail Berdasarkan Sumber -->
                                    @if($pelanggaran->sumber_informasi_pelanggaran == 'Hasil Pengawasan dan Monitoring')
                                        <div class="card h-100">
                                            <div class="card-header">
                                                <h5 class="mb-0">Hasil Pengawasan</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="pd-kv-list">
                                                    <div class="pd-kv-item">
                                                        <div class="pd-kv-label">Tanggal Pengawasan</div>
                                                        <div class="pd-kv-value"><span class="d-none d-md-inline me-1 text-muted">:</span>{{ $pelanggaran->tanggal_pengawasan ? \Carbon\Carbon::parse($pelanggaran->tanggal_pengawasan)->translatedFormat('d F Y') : '-' }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @elseif($pelanggaran->sumber_informasi_pelanggaran == 'Laporan Masyarakat')
                                        <div class="card h-100">
                                            <div class="card-header">
                                                <h5 class="mb-0">Profil Pelapor</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="pd-kv-list">
                                                    <div class="pd-kv-item">
                                                        <div class="pd-kv-label">Bentuk Laporan</div>
                                                        <div class="pd-kv-value"><span class="d-none d-md-inline me-1 text-muted">:</span>{{ $pelanggaran->bentuk_laporan }}</div>
                                                    </div>
                                                    <div class="pd-kv-item">
                                                        <div class="pd-kv-label">Nama Pelapor</div>
                                                        <div class="pd-kv-value"><span class="d-none d-md-inline me-1 text-muted">:</span>{{ $pelanggaran->nama_pelapor }}</div>
                                                    </div>
                                                    <div class="pd-kv-item">
                                                        <div class="pd-kv-label">No. Telp Pelapor</div>
                                                        <div class="pd-kv-value"><span class="d-none d-md-inline me-1 text-muted">:</span>{{ $pelanggaran->telp_pelapor }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @elseif($pelanggaran->sumber_informasi_pelanggaran == 'Hasil Penilaian KKPR atau SKRK')
                                        <div class="card h-100">
                                            <div class="card-header">
                                                <h5 class="mb-0">Data KKPR/SKRK</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="pd-kv-list">
                                                    <div class="pd-kv-item">
                                                        <div class="pd-kv-label">No. KKPR/SKRK</div>
                                                        <div class="pd-kv-value"><span class="d-none d-md-inline me-1 text-muted">:</span>{{ $pelanggaran->no_kkpr_skrk }}</div>
                                                    </div>
                                                    <div class="pd-kv-item">
                                                        <div class="pd-kv-label">No. BA/SK Penilaian</div>
                                                        <div class="pd-kv-value"><span class="d-none d-md-inline me-1 text-muted">:</span>{{ $pelanggaran->no_ba_sk_penilaian_kkpr }}</div>
                                                    </div>
                                                    <div class="pd-kv-item">
                                                        <div class="pd-kv-label">Dokumen Penilaian</div>
                                                        <div class="pd-kv-value"><span class="d-none d-md-inline me-1 text-muted">:</span><a href="{{ Storage::url($pelanggaran->dokumen_penilaian_kkpr) }}" target="_blank" class="text-primary fw-semibold">
                                                                <i class="bx bx-file me-1"></i> Lihat Dokumen
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                @if($pelanggaran->sumber_informasi_pelanggaran == 'Laporan Masyarakat')
                                    <div class="col-md-12 mb-4">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="mb-0">Isi Laporan / Kronologis</h5>
                                            </div>
                                            <div class="card-body">
                                                <p class="mb-0" style="overflow-wrap: anywhere;">{{ $pelanggaran->isi_laporan }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endif


                                <!-- Lokasi Pelanggaran -->
                                <div class="col-md-12 mb-4">
                                    <div class="card h-100">
                                        <div class="card-header">
                                            <h5 class="mb-0">Profil Lokasi Indikasi Pelanggaran</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="pd-kv-list">
                                                <div class="pd-kv-item">
                                                    <div class="pd-kv-label">Nama Pelanggar</div>
                                                    <div class="pd-kv-value"><span class="d-none d-md-inline me-1 text-muted">:</span>{{ $pelanggaran->nama_pelanggar }}</div>
                                                </div>
                                                @if($pelanggaran->nama_pemilik_perusahaan)
                                                <div class="pd-kv-item">
                                                    <div class="pd-kv-label">Nama Pemilik/Perusahaan</div>
                                                    <div class="pd-kv-value"><span class="d-none d-md-inline me-1 text-muted">:</span>{{ $pelanggaran->nama_pemilik_perusahaan }}</div>
                                                </div>
                                                @endif
                                                @if($pelanggaran->alamat_pelanggar)
                                                <div class="pd-kv-item">
                                                    <div class="pd-kv-label">Alamat Pemilik Lahan</div>
                                                    <div class="pd-kv-value"><span class="d-none d-md-inline me-1 text-muted">:</span>{{ $pelanggaran->alamat_pelanggar }}{{ $pelanggaran->kel_pelanggar ? ', Kel. ' . $pelanggaran->kel_pelanggar : '' }}{{ $pelanggaran->kec_pelanggar ? ', Kec. ' . $pelanggaran->kec_pelanggar : '' }}{{ $pelanggaran->kota_pelanggar ? ', Kab/Kota ' . $pelanggaran->kota_pelanggar : '' }}{{ $pelanggaran->prov_pelanggar ? ', Provinsi ' . $pelanggaran->prov_pelanggar : '' }}</div>
                                                </div>
                                                @endif
                                                <div class="pd-kv-item">
                                                    <div class="pd-kv-label">Alamat Lokasi</div>
                                                    <div class="pd-kv-value"><span class="d-none d-md-inline me-1 text-muted">:</span>{{ $pelanggaran->alamat_pelanggaran }}</div>
                                                </div>
                                                <div class="pd-kv-item">
                                                    <div class="pd-kv-label">Kelurahan</div>
                                                    <div class="pd-kv-value"><span class="d-none d-md-inline me-1 text-muted">:</span>{{ $pelanggaran->kel_pelanggaran }}</div>
                                                </div>
                                                <div class="pd-kv-item">
                                                    <div class="pd-kv-label">Kecamatan</div>
                                                    <div class="pd-kv-value"><span class="d-none d-md-inline me-1 text-muted">:</span>{{ $pelanggaran->kec_pelanggaran }}</div>
                                                </div>
                                                <div class="pd-kv-item">
                                                    <div class="pd-kv-label">Koordinat</div>
                                                    <div class="pd-kv-value"><span class="d-none d-md-inline me-1 text-muted">:</span>{{ $pelanggaran->koordinat_pelanggaran }}</div>
                                                </div>
                                                <div class="pd-kv-item">
                                                    <div class="pd-kv-label">Peruntukan Pemanfaatan Ruang dalam RTR</div>
                                                    <div class="pd-kv-value"><span class="d-none d-md-inline me-1 text-muted">:</span>{{ $pelanggaran->pemanfaatan_ruang ?? '-' }}</div>
                                                </div>
                                                <div class="pd-kv-item">
                                                    <div class="pd-kv-label">Pemanfaatan Ruang Existing</div>
                                                    <div class="pd-kv-value"><span class="d-none d-md-inline me-1 text-muted">:</span>{{ $pelanggaran->jenis_pemanfaatan_ruang ?? '-' }}</div>
                                                </div>
                                                <div class="pd-kv-item">
                                                    <div class="pd-kv-label">Google Maps</div>
                                                    <div class="pd-kv-value"><span class="d-none d-md-inline me-1 text-muted">:</span><a href="{{ $pelanggaran->gmaps_pelanggaran }}" target="_blank" class="btn btn-sm btn-primary mt-1 mt-md-0"><i class="bx bx-map-alt me-1"></i> Buka Peta</a></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @php
                                    $photos = $pelanggaran->foto_pengawasan ?? [];
                                    $existing_photos = $pelanggaran->foto_existing ?? [];
                                @endphp
                                @if(count($photos) > 0)
                                    <!-- Foto Pengawasan -->
                                    <div class="col-md-12 mb-4">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="mb-0">Foto Pengawasan / Lokasi</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="row g-2 g-md-3">
                                                    @foreach ($photos as $photo)
                                                        <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                                                            <a href="{{ Storage::url($photo) }}" target="_blank" class="pd-photo-grid-item">
                                                                <img src="{{ Storage::url($photo) }}" alt="Foto Pengawasan">
                                                            </a>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if(count($existing_photos) > 0)
                                    <!-- Foto Existing -->
                                    <div class="col-md-12 mb-4">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="mb-0">Foto Kondisi Existing</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="row g-2 g-md-3">
                                                    @foreach ($existing_photos as $photo)
                                                        <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                                                            <a href="{{ Storage::url($photo) }}" target="_blank" class="pd-photo-grid-item">
                                                                <img src="{{ Storage::url($photo) }}" alt="Foto Existing">
                                                            </a>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="tab-pane fade" id="navs-pills-analisis" role="tabpanel">
                            @livewire('admin.pelanggaran.analis.pelanggaran-analis-detail', ['id' => $pelanggaran->id])
                        </div>
                    </div>
                </div>
            </div>            
        </div>
    </div>

    @include('livewire.admin.pelanggaran.analis.partials.resume-card-modal', ['pelanggaran' => $pelanggaran])
</div>
@script
<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('toast', (event) => {
            const { type = 'success', message = 'Berhasil!' } = event[0] || event;

            // Pakai Bootstrap 5 Toast (atau SweetAlert2 kalau mau lebih cantik)
            const toastEl = document.createElement('div');
            toastEl.className = `bs-toast toast align-items-center text-white bg-${type === 'error' ? 'danger' : 'success'} bg-${type === 'error' ? 'danger' : 'success'} fade show position-fixed top-0 end-0 m-3`;
            toastEl.style.zIndex = 9999;
            toastEl.setAttribute('role', 'alert');
            toastEl.innerHTML = `
                <div class="d-flex">
                    <div class="toast-body">
                        <strong>${type === 'success' ? 'Berhasil!' : 'Gagal!'}</strong><br>
                        ${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            `;

            document.body.appendChild(toastEl);

            // Init dan tampilkan
            const toast = new bootstrap.Toast(toastEl, { delay: 4000 });
            toast.show();

            // Hapus dari DOM setelah selesai
            toastEl.addEventListener('hidden.bs.toast', () => toastEl.remove());
        });
    });
</script>
@endscript