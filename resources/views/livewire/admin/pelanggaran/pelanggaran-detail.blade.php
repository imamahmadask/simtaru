<div>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold py-3 mb-0"><span class="text-muted fw-light">Pelanggaran /</span> Detail Pelanggaran</h4>
            <div>               
                <a href="{{ route('pelanggaran.edit', $pelanggaran->id) }}" class="btn btn-warning">
                    <i class="bx bx-edit-alt me-1"></i> Edit
                </a>
                <a href="{{ route('pelanggaran.index') }}" class="btn btn-secondary ms-2">
                    <i class="bx bx-arrow-back me-1"></i> Kembali
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-xxl-12 mb-4">
                <div class="nav-align-top mb-4">
                    <ul class="nav nav-pills flex-column flex-md-row mb-3" role="tablist">
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
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="navs-pills-detail" role="tabpanel">
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <div class="card h-100">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h5 class="mb-0">Informasi Umum</h5>
                                            <span class="badge bg-{{ $pelanggaran->status == 'Selesai' ? 'success' : 'warning' }}">
                                                {{ $pelanggaran->status }}
                                            </span>
                                        </div>
                                        <div class="card-body">
                                            <div class="row mb-2">
                                                <div class="col-md-4 fw-semibold">No Pelanggaran</div>
                                                <div class="col-md-8">: {{ $pelanggaran->no_pelanggaran }}</div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-md-4 fw-semibold">Tanggal Laporan</div>
                                                <div class="col-md-8">: {{ $pelanggaran->tgl_laporan ? \Carbon\Carbon::parse($pelanggaran->tgl_laporan)->translatedFormat('d F Y') : '-' }}</div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-md-4 fw-semibold">Sumber Informasi</div>
                                                <div class="col-md-8">: {{ $pelanggaran->sumber_informasi_pelanggaran }}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4 fw-semibold">Jenis Indikasi</div>
                                                <div class="col-md-8">: {{ $pelanggaran->jenis_indikasi_pelanggaran }}</div>
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
                                                <div class="row">
                                                    <div class="col-md-4 fw-semibold">Tanggal Pengawasan</div>
                                                    <div class="col-md-8">: {{ $pelanggaran->tanggal_pengawasan ? \Carbon\Carbon::parse($pelanggaran->tanggal_pengawasan)->translatedFormat('d F Y') : '-' }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    @elseif($pelanggaran->sumber_informasi_pelanggaran == 'Laporan Masyarakat')
                                        <div class="card h-100">
                                            <div class="card-header">
                                                <h5 class="mb-0">Profil Pelapor</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="row mb-2">
                                                    <div class="col-md-4 fw-semibold">Bentuk Laporan</div>
                                                    <div class="col-md-8">: {{ $pelanggaran->bentuk_laporan }}</div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-md-4 fw-semibold">Nama Pelapor</div>
                                                    <div class="col-md-8">: {{ $pelanggaran->nama_pelapor }}</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4 fw-semibold">No. Telp Pelapor</div>
                                                    <div class="col-md-8">: {{ $pelanggaran->telp_pelapor }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    @elseif($pelanggaran->sumber_informasi_pelanggaran == 'Hasil Penilaian KKPR atau SKRK')
                                        <div class="card h-100">
                                            <div class="card-header">
                                                <h5 class="mb-0">Data KKPR/SKRK</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="row mb-2">
                                                    <div class="col-md-4 fw-semibold">No. KKPR/SKRK</div>
                                                    <div class="col-md-8">: {{ $pelanggaran->no_kkpr_skrk }}</div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-md-4 fw-semibold">No. BA/SK Penilaian</div>
                                                    <div class="col-md-8">: {{ $pelanggaran->no_ba_sk_penilaian_kkpr }}</div>
                                                </div>                                                    
                                                <div class="row">
                                                    <div class="col-md-4 fw-semibold">Dokumen Penilaian</div>
                                                    <div class="col-md-8">: <a href="{{ Storage::url($pelanggaran->dokumen_penilaian_kkpr) }}" target="_blank" class="text-primary fw-semibold">
                                                            <i class="bx bx-file me-1"></i> Lihat Dokumen
                                                        </a>
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
                                                <p class="mb-0">{{ $pelanggaran->isi_laporan }}</p>
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
                                            <div class="row mb-2">
                                                <div class="col-md-4 fw-semibold">Nama Pemilik/Penanggung Jawab</div>
                                                <div class="col-md-8">: {{ $pelanggaran->nama_pelanggar }}</div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-md-4 fw-semibold">Alamat Pemilik/Penanggung Jawab</div>
                                                <div class="col-md-8">: {{ $pelanggaran->alamat_pelanggar }}, Kel. {{ $pelanggaran->kel_pelanggar }}, Kec. {{ $pelanggaran->kec_pelanggar }}, Kab/Kota {{ $pelanggaran->kota_pelanggar }}, Provinsi {{ $pelanggaran->prov_pelanggar }}</div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-md-4 fw-semibold">Alamat Lokasi</div>
                                                <div class="col-md-8">: {{ $pelanggaran->alamat_pelanggaran }}</div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-md-4 fw-semibold">Kelurahan</div>
                                                <div class="col-md-8">: {{ $pelanggaran->kel_pelanggaran }}</div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-md-4 fw-semibold">Kecamatan</div>
                                                <div class="col-md-8">: {{ $pelanggaran->kec_pelanggaran }}</div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-md-4 fw-semibold">Koordinat</div>
                                                <div class="col-md-8">: {{ $pelanggaran->koordinat_pelanggaran }}</div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-md-4 fw-semibold">Jenis Pemanfaatan</div>
                                                <div class="col-md-8">: {{ $pelanggaran->jenis_pemanfaatan_ruang }}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4 fw-semibold">Google Maps</div>
                                                <div class="col-md-8">: <a href="{{ $pelanggaran->gmaps_pelanggaran }}" target="_blank" class="btn btn-xs btn-primary"><i class="bx bx-map-alt me-1"></i> Buka Peta</a></div>
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
                                                <div class="d-flex flex-wrap gap-2">
                                                    @foreach ($photos as $photo)
                                                        <a href="{{ Storage::url($photo) }}" target="_blank">
                                                            <img src="{{ Storage::url($photo) }}" alt="Foto Pengawasan"
                                                                class="img-thumbnail" style="width: 200px; height: 200px; object-fit: cover;">
                                                        </a>
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
                                                <div class="d-flex flex-wrap gap-2">
                                                    @foreach ($existing_photos as $photo)
                                                        <a href="{{ Storage::url($photo) }}" target="_blank">
                                                            <img src="{{ Storage::url($photo) }}" alt="Foto Existing"
                                                                class="img-thumbnail" style="width: 200px; height: 200px; object-fit: cover;">
                                                        </a>
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
</div>
@script
    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('toast', (event) => {
                const { type = 'success', message = 'Berhasil!' } = event[0] || event;

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

                const toast = new bootstrap.Toast(toastEl, { delay: 4000 });
                toast.show();

                toastEl.addEventListener('hidden.bs.toast', () => toastEl.remove());
            });
        });
    </script>
@endscript