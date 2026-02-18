<div>
    <div class="container-xxl flex-grow-1 container-p-y">        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold py-3 mb-0"><span class="text-muted fw-light">Penilaian /</span> Detail Penilaian</h4>                        
            <div>               
                <a href="{{ route('penilaian.edit', $penilaian->id) }}" class="btn btn-warning">
                    <i class="bx bx-edit-alt me-1"></i> Edit
                </a>
                <a href="{{ route('penilaian.index') }}" class="btn btn-secondary ms-2">
                    <i class="bx bx-arrow-back me-1"></i> Kembali
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Informasi Penilaian</h5>
                        <span class="badge bg-{{ $penilaian->status == 'Selesai' ? 'success' : ($penilaian->status == 'Proses' ? 'primary' : 'warning') }}">
                            {{ $penilaian->status }}
                        </span>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-md-4 fw-semibold">No Dokumen</div>
                            <div class="col-md-8">: <span class="badge bg-primary fs-6 fst-italic">{{ $penilaian->nomor_dokumen }}</span></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4 fw-semibold">Tanggal</div>
                            <div class="col-md-8">: {{ $penilaian->tanggal_penilaian ? \Carbon\Carbon::parse($penilaian->tanggal_penilaian)->translatedFormat('d F Y') : '-' }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4 fw-semibold">Jenis Penilaian</div>
                            <div class="col-md-8">: {{ $penilaian->jenis_penilaian }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4 fw-semibold">Jenis Dokumen</div>
                            <div class="col-md-8">: {{ $penilaian->jenis_dokumen }}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 fw-semibold">Dokumen</div>
                            <div class="col-md-8">: 
                                @if($penilaian->file_dokumen)
                                    <a href="{{ Storage::url($penilaian->file_dokumen) }}" target="_blank" class="text-primary fw-semibold">
                                        <i class="bx bx-file me-1"></i> Lihat Dokumen
                                    </a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="mb-0">Profil Pelaku Usaha</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-md-4 fw-semibold">Nama</div>
                            <div class="col-md-8">: {{ $penilaian->nama_pelaku_usaha }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4 fw-semibold">No. Telepon</div>
                            <div class="col-md-8">: {{ $penilaian->no_telepon ?? '-' }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4 fw-semibold">Email</div>
                            <div class="col-md-8">: {{ $penilaian->email ?? '-' }}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 fw-semibold">Alamat</div>
                            <div class="col-md-8">: {{ $penilaian->alamat_pelaku_usaha ?? '-' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="mb-0">Data Usaha & Lokasi</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-md-3 fw-semibold">Nama Usaha</div>
                            <div class="col-md-9">: {{ $penilaian->nama_usaha }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-3 fw-semibold">Jenis Kegiatan</div>
                            <div class="col-md-9">: {{ $penilaian->jenis_kegiatan_usaha ?? '-' }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-3 fw-semibold">Alamat Lokasi</div>
                            <div class="col-md-9">: {{ $penilaian->alamat_lokasi_usaha ?? '-' }}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 fw-semibold">Koordinat</div>
                            <div class="col-md-9">: {{ $penilaian->koordinat ?? '-' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="mb-0">Hasil Penilaian & Rekomendasi</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-12 fw-semibold mb-2">Analisa Penilaian:</div>
                            <div class="col-md-12 p-3 bg-light rounded text-dark">
                                {!! nl2br(e($penilaian->analisa_penilaian)) !!}
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-12 fw-semibold mb-2">Rekomendasi:</div>
                            <div class="col-md-12 p-3 bg-light rounded text-dark border-start border-primary border-4">
                                {!! nl2br(e($penilaian->rekomendasi)) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 fw-semibold">Link Hasil Penilaian</div>
                            <div class="col-md-9">: 
                                @if($penilaian->link_hasil_penilaian)
                                    <a href="{{ $penilaian->link_hasil_penilaian }}" target="_blank" class="text-primary">
                                        {{ $penilaian->link_hasil_penilaian }} <i class="bx bx-link-external ms-1"></i>
                                    </a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>