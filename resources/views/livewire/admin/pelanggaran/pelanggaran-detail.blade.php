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
            <!-- Informasi Umum -->
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
                                <th>Jenis Formulir</th>
                                <td>: {{ $pelanggaran->jenis_formulir }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Pengawasan</th>
                                <td>: {{ \Carbon\Carbon::parse($pelanggaran->tanggal_pengawasan)->translatedFormat('d F Y') }}</td>
                            </tr>
                            <tr>
                                <th>Lokasi Pengawasan</th>
                                <td>: {{ $pelanggaran->lokasi_pengawasan }}</td>
                            </tr>
                            <tr>
                                <th>Anggota Tidak Hadir</th>
                                <td>: {{ $pelanggaran->anggota_tidak_hadir }}</td>
                            </tr>
                            <tr>
                                <th>Temuan Pelanggaran</th>
                                <td>: {{ $pelanggaran->temuan_pelanggaran }}</td>
                            </tr>
                        </table>
                        <hr>
                        <h6>Hasil Laporan Pengawasan:</h6>
                        <p class="text-muted">{{ $pelanggaran->hasil_pengawasan }}</p>
                    </div>
                </div>
            </div>

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
            <div class="col-md-12 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Profil Lokasi Indikasi Pelanggaran</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
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
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <th style="width: 40%">Koordinat</th>
                                        <td>: {{ $pelanggaran->koordinat_pelanggaran }}</td>
                                    </tr>
                                    <tr>
                                        <th>Link Google Maps</th>
                                        <td>: <a href="{{ $pelanggaran->gmaps_pelanggaran }}" target="_blank" class="btn btn-sm btn-outline-primary">Buka Peta</a></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Laporan & Foto -->
            <div class="col-md-12 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Sumber Informasi & Laporan</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <th style="width: 40%">Sumber Informasi</th>
                                        <td>: {{ $pelanggaran->sumber_informasi_pelanggaran }}</td>
                                    </tr>
                                    <tr>
                                        <th>Bentuk Laporan</th>
                                        <td>: {{ $pelanggaran->bentuk_laporan }}</td>
                                    </tr>
                                    <tr>
                                        <th>Asal/Nama Pelapor</th>
                                        <td>: {{ $pelanggaran->nama_pelapor }}</td>
                                    </tr>
                                    <tr>
                                        <th>Jenis Indikasi</th>
                                        <td>: {{ $pelanggaran->jenis_indikasi_pelanggaran }}</td>
                                    </tr>
                                </table>
                                <hr>
                                <h6>Kronologis Isi Laporan:</h6>
                                <p class="text-muted">{{ $pelanggaran->isi_laporan }}</p>
                            </div>
                            <div class="col-md-6">
                                <h6>Foto Pengawasan:</h6>
                                <div class="d-flex flex-wrap gap-2 mt-2">
                                    @php
                                        $photos = json_decode($pelanggaran->foto_pengawasan, true) ?? [];
                                    @endphp
                                    @forelse ($photos as $photo)
                                        <a href="{{ \Illuminate\Support\Facades\Storage::url($photo) }}" target="_blank">
                                            <img src="{{ \Illuminate\Support\Facades\Storage::url($photo) }}" 
                                                alt="Foto Pengawasan" class="img-thumbnail" 
                                                style="width: 150px; height: 150px; object-fit: cover;">
                                        </a>
                                    @empty
                                        <p class="text-muted small italic">Tidak ada foto pengawasan</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
