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
                                            <span class="badge bg-{{ $pelanggaran->status == 'Success' ? 'success' : ($pelanggaran->status == 'Process' ? 'primary' : ($pelanggaran->status == 'Pending' ? 'warning' : 'danger')) }}">
                                                {{ $pelanggaran->status }}
                                            </span>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <th style="width: 40%">No Pelanggaran</th>
                                                    <td>: {{ $pelanggaran->no_pelanggaran }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Tanggal Laporan</th>
                                                    <td>: {{ $pelanggaran->tgl_laporan ? \Carbon\Carbon::parse($pelanggaran->tgl_laporan)->translatedFormat('d F Y') : '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Sumber Informasi</th>
                                                    <td>: {{ $pelanggaran->sumber_informasi_pelanggaran }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Jenis Indikasi</th>
                                                    <td>: {{ $pelanggaran->jenis_indikasi_pelanggaran }}</td>
                                                </tr>
                                            </table>                    
                                        </div>
                                    </div>
                                </div>
    
                                <!-- Detail Berdasarkan Sumber -->
                                <div class="col-md-6 mb-4">
                                    @if($pelanggaran->sumber_informasi_pelanggaran == 'Hasil Pengawasan dan Monitoring')
                                        <div class="card h-100">
                                            <div class="card-header">
                                                <h5 class="mb-0">Hasil Pengawasan</h5>
                                            </div>
                                            <div class="card-body">
                                                <table class="table table-borderless">
                                                    <tr>
                                                        <th style="width: 40%">Tanggal Pengawasan</th>
                                                        <td>: {{ $pelanggaran->tanggal_pengawasan ? \Carbon\Carbon::parse($pelanggaran->tanggal_pengawasan)->translatedFormat('d F Y') : '-' }}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    @elseif($pelanggaran->sumber_informasi_pelanggaran == 'Laporan Masyarakat')
                                        <div class="card h-100">
                                            <div class="card-header">
                                                <h5 class="mb-0">Profil Pelapor</h5>
                                            </div>
                                            <div class="card-body">
                                                <table class="table table-borderless">
                                                    <tr>
                                                        <th style="width: 40%">Bentuk Laporan</th>
                                                        <td>: {{ $pelanggaran->bentuk_laporan }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Nama Pelapor</th>
                                                        <td>: {{ $pelanggaran->nama_pelapor }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>No. Telp Pelapor</th>
                                                        <td>: {{ $pelanggaran->telp_pelapor }}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    @elseif($pelanggaran->sumber_informasi_pelanggaran == 'Hasil Penilaian KKPR atau SKRK')
                                        <div class="card h-100">
                                            <div class="card-header">
                                                <h5 class="mb-0">Data KKPR/SKRK</h5>
                                            </div>
                                            <div class="card-body">
                                                <table class="table table-borderless">
                                                    <tr>
                                                        <th style="width: 40%">No. KKPR/SKRK</th>
                                                        <td>: {{ $pelanggaran->no_kkpr_skrk }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>No. BA/SK Penilaian</th>
                                                        <td>: {{ $pelanggaran->no_ba_sk_penilaian_kkpr }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Jenis Pemanfaatan</th>
                                                        <td>: {{ $pelanggaran->jenis_pemanfaatan_ruang }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Dokumen Penilaian</th>
                                                        <td>: {{ $pelanggaran->dokumen_penilaian_kkpr }}</td>
                                                    </tr>
                                                </table>
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
                                                <p>{{ $pelanggaran->isi_laporan }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
    
                                <!-- Identitas Pelanggar -->
                                <div class="col-md-6 mb-4">
                                    <div class="card h-100">
                                        <div class="card-header">
                                            <h5 class="mb-0">Profil Identitas Pelanggar</h5>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <th style="width: 40%">Nama Pemilik Lahan</th>
                                                    <td>: {{ $pelanggaran->nama_pelanggar }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Alamat Pemilik Lahan</th>
                                                    <td>: {{ $pelanggaran->alamat_pelanggar }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Kelurahan</th>
                                                    <td>: {{ $pelanggaran->kel_pelanggar }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Kecamatan</th>
                                                    <td>: {{ $pelanggaran->kec_pelanggar }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Kota</th>
                                                    <td>: {{ $pelanggaran->kota_pelanggar }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Provinsi</th>
                                                    <td>: {{ $pelanggaran->prov_pelanggar }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
    
                                <!-- Lokasi Pelanggaran -->
                                <div class="col-md-6 mb-4">
                                    <div class="card h-100">
                                        <div class="card-header">
                                            <h5 class="mb-0">Profil Lokasi Indikasi Pelanggaran</h5>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <th style="width: 40%">Alamat Lokasi</th>
                                                    <td>: {{ $pelanggaran->alamat_pelanggaran }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Kelurahan</th>
                                                    <td>: {{ $pelanggaran->kel_pelanggaran }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Kecamatan</th>
                                                    <td>: {{ $pelanggaran->kec_pelanggaran }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Koordinat</th>
                                                    <td>: {{ $pelanggaran->koordinat_pelanggaran }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Google Maps</th>
                                                    <td>: <a href="{{ $pelanggaran->gmaps_pelanggaran }}" target="_blank" class="btn btn-xs btn-primary"><i class="bx bx-map-alt me-1"></i> Buka Peta</a></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
    
                                @php
                                    $photos = json_decode($pelanggaran->foto_pengawasan, true) ?? [];
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