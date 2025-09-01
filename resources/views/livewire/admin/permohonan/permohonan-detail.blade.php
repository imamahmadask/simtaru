<div>
    <style>
        .form-control:disabled,
        .form-control[readonly] {
            background-color: #ffffff;
            opacity: 1;
        }
    </style>

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="fw-bold py-3 mb-4">
                <span class="text-muted fw-light">Permohonan /</span> Detail Permohonan
            </h4>
            @if (Auth::user()->role == 'superadmin' || Auth::user()->role == 'supervisor')
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#AddDisposisiModal">
                    <i class="bx bx-plus"></i> Disposisi
                </button>
            @endif
        </div>

        <div class="row">
            <div class="col-xxl">
                <div class="card mb-4">
                    {{-- Data Pemohon --}}
                    <div class="card-header d-flex align-items-center justify-content-between bg-secondary">
                        <h5 class="mb-0 text-white">Data Pemohon</h5>
                    </div>
                    <div class="card-body mt-3">
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="nama">Nama</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="nama"
                                    value="{{ $permohonan->registrasi->nama }}" readonly />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="nik">NIK</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="nik"
                                    value="{{ Str::mask($permohonan->registrasi->nik, '*', 5, -1) }}" readonly />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="no_hp">No HP</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="no_hp"
                                    value="{{ $permohonan->registrasi->no_hp }}" readonly />
                            </div>
                        </div>
                    </div>

                    {{-- Data Permohonan --}}
                    <div class="card-header d-flex align-items-center justify-content-between bg-secondary">
                        <h5 class="mb-0 text-white">Data Permohonan</h5>
                    </div>
                    <div class="card-body mt-3">
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="kode">Kode Registrasi</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="kode"
                                    value="{{ $permohonan->registrasi->kode }}" readonly />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="layanan">Nama Layanan</label>
                            <div class="col-sm-10">
                                <input type="text" id="layanan" class="form-control"
                                    value="{{ $permohonan->layanan->nama }}" readonly />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="tanggal">Tanggal
                                Registrasi</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="tanggal"
                                    value="{{ date('d-m-Y', strtotime($permohonan->created_at)) }}" readonly />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="alamat_tanah">Alamat Tanah</label>
                            <div class="col-sm-10">
                                <input type="text" id="alamat_tanah" class="form-control"
                                    value="{{ $permohonan->alamat_tanah }}" readonly />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="kel_tanah">Kelurahan</label>
                            <div class="col-sm-10">
                                <input type="text" id="kel_tanah" class="form-control"
                                    value="{{ $permohonan->kel_tanah }}" readonly />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="kec_tanah">Kecamatan</label>
                            <div class="col-sm-10">
                                <input type="text" id="kec_tanah" class="form-control"
                                    value="{{ $permohonan->kec_tanah }}" readonly />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="jenis_bangunan">Jenis Bangunan</label>
                            <div class="col-sm-10">
                                <input type="text" id="jenis_bangunan" class="form-control"
                                    value="{{ $permohonan->jenis_bangunan }}" readonly />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="status">Status</label>
                            <div class="col-sm-10">
                                <input type="text" id="status" class="form-control"
                                    value="{{ $permohonan->status }}" readonly />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="berkas_pemohon">Berkas Pemohon</label>
                            <div class="col-sm-10">
                                <a href="{{ asset('storage/' . $permohonan->berkas_pemohon) }}" target="_blank">
                                    Lihat Berkas
                                </a>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="keterangan">Keterangan</label>
                            <div class="col-sm-10">
                                <textarea id="keterangan" class="form-control" aria-describedby="basic-icon-default-message2" readonly>{{ $permohonan->keterangan }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-4">
                    {{-- Data Pemohon --}}
                    <div class="card-header d-flex align-items-center justify-content-between bg-secondary">
                        <h5 class="mb-0 text-white">Download Template Berkas</h5>
                    </div>
                    <div class="card-body mt-3">
                        <div class="row mb-3">
                            <a href="{{ asset('storage/' . $satu_a) }}" target="_blank">
                                1A. Form Isian Pemeriksaan Lapangan
                            </a>
                        </div>
                        <div class="row mb-3">
                            <a href="{{ asset('storage/' . $satu_b) }}" target="_blank">
                                1B. BA Pemeriksaan Lapangan SKRK
                            </a>
                        </div>
                        <div class="row mb-3">
                            <a href="{{ asset('storage/' . $dua_a) }}" target="_blank">
                                2A. BA Rapat FPR (Bila Ada) SKRK
                            </a>
                        </div>
                        <div class="row mb-3">
                            <a href="{{ asset('storage/' . $dua_b) }}" target="_blank">
                                2B. Notulensi Rapat FPR SKRK (Bila Ada)
                            </a>
                        </div>
                        <div class="row mb-3">
                            <a href="{{ asset('storage/' . $tiga) }}" target="_blank">
                                3. Kajian SKRK
                            </a>
                        </div>
                        <div class="row mb-3">
                            <a href="{{ asset('storage/' . $empat) }}" target="_blank">
                                4. Dokumen SKRK
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl">
                {{-- Riwayat Permohonan --}}
                @livewire('admin.permohonan.riwayat.riwayat-permohonan-index', ['permohonan' => $permohonan])

                {{-- Upload Berkas --}}
                @livewire('admin.permohonan.berkas.upload-berkas', ['permohonan' => $permohonan])
            </div>
        </div>
        @teleport('body')
            @livewire('admin.permohonan.disposisi.disposisi-create', ['permohonan_id' => $permohonan->id])
        @endteleport
    </div>
</div>
