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
        </div>

        <div class="row">
            <div class="col-xxl">
                <div class="nav-align-top mb-4">
                    <ul class="nav nav-pills mb-3" role="tablist">
                        <li class="nav-item">
                            <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                data-bs-target="#navs-pills-top-general" aria-controls="navs-pills-top-general"
                                aria-selected="true">
                                Info
                            </button>
                        </li>
                        <li class="nav-item">
                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                data-bs-target="#navs-pills-top-survey" aria-controls="navs-pills-top-survey"
                                aria-selected="false">
                                Survey
                            </button>
                        </li>
                        <li class="nav-item">
                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                data-bs-target="#navs-pills-top-analisa" aria-controls="navs-pills-top-analisa"
                                aria-selected="false">
                                Analisa
                            </button>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="navs-pills-top-general" role="tabpanel">
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="card mb-4">
                                        {{-- Data Pemohon --}}
                                        <div
                                            class="card-header d-flex align-items-center justify-content-between bg-secondary">
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
                                                        value="{{ Str::mask($permohonan->registrasi->nik, '*', 5, -1) }}"
                                                        readonly />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-2 col-form-label" for="no_hp">
                                                    No HP</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="no_hp"
                                                        value="{{ $permohonan->registrasi->no_hp }}" readonly />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-2 col-form-label" for="email">
                                                    Email
                                                </label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="email"
                                                        value="{{ $permohonan->registrasi->email }}" autocomplete="off"
                                                        readonly />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-2 col-form-label" for="npwp">
                                                    NPWP
                                                </label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="npwp"
                                                        value="{{ $permohonan->npwp }}" readonly />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-2 col-form-label" for="alamat_pemohon">
                                                    Alamat Pemohon
                                                </label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="alamat_pemohon"
                                                        value="{{ $permohonan->alamat_pemohon }}" readonly />
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Data Permohonan --}}
                                        <div
                                            class="card-header d-flex align-items-center justify-content-between bg-secondary">
                                            <h5 class="mb-0 text-white">Data Permohonan</h5>
                                        </div>
                                        <div class="card-body mt-3">
                                            <div class="row mb-3">
                                                <label class="col-sm-2 col-form-label" for="kode">Kode
                                                    Registrasi</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="kode"
                                                        value="{{ $permohonan->registrasi->kode }}" readonly />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-2 col-form-label" for="layanan">Nama
                                                    Layanan</label>
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
                                                        value="{{ date('d-m-Y', strtotime($permohonan->created_at)) }}"
                                                        readonly />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-2 col-form-label" for="alamat_tanah">Alamat
                                                    Tanah</label>
                                                <div class="col-sm-10">
                                                    <input type="text" id="alamat_tanah" class="form-control"
                                                        value="{{ $permohonan->alamat_tanah }}" readonly />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-2 col-form-label"
                                                    for="kel_tanah">Kelurahan</label>
                                                <div class="col-sm-10">
                                                    <input type="text" id="kel_tanah" class="form-control"
                                                        value="{{ $permohonan->kel_tanah }}" readonly />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-2 col-form-label"
                                                    for="kec_tanah">Kecamatan</label>
                                                <div class="col-sm-10">
                                                    <input type="text" id="kec_tanah" class="form-control"
                                                        value="{{ $permohonan->kec_tanah }}" readonly />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-2 col-form-label" for="jenis_bangunan">
                                                    Fungsi Bangunan</label>
                                                <div class="col-sm-10">
                                                    <input type="text" id="jenis_bangunan" class="form-control"
                                                        value="{{ $permohonan->jenis_bangunan }}" readonly />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-2 col-form-label" for="luas_tanah">
                                                    Luas Tanah
                                                </label>
                                                <div class="col-sm-10">
                                                    <input type="text" id="luas_tanah" class="form-control"
                                                        value="{{ $permohonan->luas_tanah }} m2" readonly />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-2 col-form-label" for="status">Status</label>
                                                <div class="col-sm-10">
                                                    <input type="text" id="status" class="form-control"
                                                        value="{{ $permohonan->status }}" readonly />
                                                </div>
                                            </div>
                                            @if ($permohonan->status == 'success')
                                                <div class="row mb-3">
                                                    <label class="col-sm-2 col-form-label" for="status">Tanggal
                                                        Selesai</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" id="status" class="form-control"
                                                            value="{{ date('d-m-Y', strtotime($permohonan->tgl_selesai)) }}"
                                                            readonly />
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="row mb-3">
                                                <span class="col-sm-2 col-form-label d-flex align-items-center">
                                                    Berkas
                                                </span>
                                                <div class="col-sm d-flex justify-content-around flex-wrap">
                                                    <a href="{{ asset('storage/' . $permohonan->berkas_ktp) }}"
                                                        target="_blank" type="button" class="btn btn-primary m-1">
                                                        KTP
                                                    </a>
                                                    <a href="{{ asset('storage/' . $permohonan->berkas_permohonan) }}"
                                                        target="_blank" type="button" class="btn btn-primary m-1">
                                                        Permohonan
                                                    </a>
                                                    <a href="{{ asset('storage/' . $permohonan->berkas_nib) }}"
                                                        target="_blank" type="button" class="btn btn-primary m-1">
                                                        NIB
                                                    </a>
                                                    <a href="{{ asset('storage/' . $permohonan->berkas_penguasaan) }}"
                                                        target="_blank" type="button" class="btn btn-primary m-1">
                                                        Penguasaan
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-2 col-form-label" for="keterangan">Ket.</label>
                                                <div class="col-sm-10">
                                                    <textarea id="keterangan" class="form-control" aria-describedby="basic-icon-default-message2" readonly>{{ $permohonan->keterangan }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    @livewire('admin.permohonan.riwayat.riwayat-permohonan-index', ['permohonan' => $permohonan])
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="navs-pills-top-survey" role="tabpanel">
                            Survey
                        </div>

                        <div class="tab-pane fade" id="navs-pills-top-analisa" role="tabpanel">
                            Analisa
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @teleport('body')
            @livewire('admin.permohonan.disposisi.disposisi-create', ['permohonan_id' => $permohonan->id])
        @endteleport
    </div>
</div>
