<div>
    <style>
        .form-control:disabled,
        .form-control[readonly] {
            background-color: #ffffff;
            opacity: 1;
        }
    </style>

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Permohonan /</span> Detail Permohonan</h4>
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
                            <label class="col-sm-2 col-form-label" for="keterangan">Keterangan</label>
                            <div class="col-sm-10">
                                <textarea id="keterangan" class="form-control" aria-describedby="basic-icon-default-message2" readonly>{{ $permohonan->keterangan }}</textarea>
                            </div>
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
    </div>
</div>
