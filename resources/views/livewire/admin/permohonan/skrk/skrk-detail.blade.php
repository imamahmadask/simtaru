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
                <span class="text-muted fw-light">Permohonan /</span> Detail Permohonan SKRK
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
                                                        value="{{ $skrk->permohonan->registrasi->nama }}" readonly />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-2 col-form-label" for="nik">NIK</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="nik"
                                                        value="{{ Str::mask($skrk->permohonan->registrasi->nik, '*', 5, -1) }}"
                                                        readonly />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-2 col-form-label" for="no_hp">
                                                    No HP</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="no_hp"
                                                        value="{{ $skrk->permohonan->registrasi->no_hp }}" readonly />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-2 col-form-label" for="email">
                                                    Email
                                                </label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="email"
                                                        value="{{ $skrk->permohonan->email }}" autocomplete="off"
                                                        readonly />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-2 col-form-label" for="npwp">
                                                    NPWP
                                                </label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="npwp"
                                                        value="{{ $skrk->permohonan->npwp }}" readonly />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-2 col-form-label" for="alamat_pemohon">
                                                    Alamat Pemohon
                                                </label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="alamat_pemohon"
                                                        value="{{ $skrk->permohonan->alamat_pemohon }}" readonly />
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
                                                        value="{{ $skrk->permohonan->registrasi->kode }}" readonly />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-2 col-form-label" for="layanan">Nama
                                                    Layanan</label>
                                                <div class="col-sm-10">
                                                    <input type="text" id="layanan" class="form-control"
                                                        value="{{ $skrk->permohonan->layanan->nama }}" readonly />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-2 col-form-label" for="tanggal">Tanggal
                                                    Registrasi</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="tanggal"
                                                        value="{{ date('d-m-Y', strtotime($skrk->permohonan->created_at)) }}"
                                                        readonly />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-2 col-form-label" for="alamat_tanah">Alamat
                                                    Tanah</label>
                                                <div class="col-sm-10">
                                                    <input type="text" id="alamat_tanah" class="form-control"
                                                        value="{{ $skrk->permohonan->alamat_tanah }}" readonly />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-2 col-form-label"
                                                    for="kel_tanah">Kelurahan</label>
                                                <div class="col-sm-10">
                                                    <input type="text" id="kel_tanah" class="form-control"
                                                        value="{{ $skrk->permohonan->kel_tanah }}" readonly />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-2 col-form-label"
                                                    for="kec_tanah">Kecamatan</label>
                                                <div class="col-sm-10">
                                                    <input type="text" id="kec_tanah" class="form-control"
                                                        value="{{ $skrk->permohonan->kec_tanah }}" readonly />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-2 col-form-label" for="jenis_bangunan">Jenis
                                                    Bangunan</label>
                                                <div class="col-sm-10">
                                                    <input type="text" id="jenis_bangunan" class="form-control"
                                                        value="{{ $skrk->permohonan->jenis_bangunan }}" readonly />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-2 col-form-label" for="luas_tanah">
                                                    Luas Tanah
                                                </label>
                                                <div class="col-sm-10">
                                                    <input type="text" id="luas_tanah" class="form-control"
                                                        value="{{ $skrk->permohonan->luas_tanah }} m2" readonly />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-2 col-form-label" for="status">Status</label>
                                                <div class="col-sm-10">
                                                    <input type="text" id="status" class="form-control"
                                                        value="{{ $skrk->permohonan->status }}" readonly />
                                                </div>
                                            </div>
                                            @if ($skrk->permohonan->status == 'success')
                                                <div class="row mb-3">
                                                    <label class="col-sm-2 col-form-label" for="status">Tanggal
                                                        Selesai</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" id="status" class="form-control"
                                                            value="{{ date('d-m-Y', strtotime($skrk->permohonan->tgl_selesai)) }}"
                                                            readonly />
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="row mb-3">
                                                <span class="col-sm-2 col-form-label d-flex align-items-center">
                                                    Berkas
                                                </span>
                                                <div class="col-sm d-flex justify-content-around flex-wrap">
                                                    <a href="{{ asset('storage/' . $skrk->permohonan->berkas_ktp) }}"
                                                        target="_blank" type="button" class="btn btn-primary m-1"
                                                        id="berkas">
                                                        KTP
                                                    </a>
                                                    <a href="{{ asset('storage/' . $skrk->permohonan->berkas_nib) }}"
                                                        target="_blank" type="button" class="btn btn-primary m-1">
                                                        NIB
                                                    </a>
                                                    <a href="{{ asset('storage/' . $skrk->permohonan->berkas_penguasaan) }}"
                                                        target="_blank" type="button" class="btn btn-primary m-1">
                                                        Penguasaan
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-2 col-form-label" for="keterangan">Ket.</label>
                                                <div class="col-sm-10">
                                                    <textarea id="keterangan" class="form-control" aria-describedby="basic-icon-default-message2" readonly>{{ $skrk->permohonan->keterangan }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    @livewire('admin.permohonan.riwayat.riwayat-permohonan-index', ['permohonan' => $skrk->permohonan])

                                    <div class="card mb-4">
                                        {{-- Data Pemohon --}}
                                        <div
                                            class="card-header d-flex align-items-center justify-content-between bg-secondary">
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
                            </div>
                        </div>

                        <div class="tab-pane fade" id="navs-pills-top-survey" role="tabpanel">
                            <div class="mb-3">
                                @if (Auth::user()->role == 'superadmin' || Auth::user()->role == 'supervisor' || Auth::user()->role == 'surveyor')
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#AddSurveyModal">
                                        <i class="bx bx-plus"></i> Tambah Survey
                                    </button>
                                @endif
                            </div>

                            <div class="row">
                                <div class="col-xl">
                                    <div class="card mb-4">
                                        <div
                                            class="card-header d-flex align-items-center justify-content-between bg-secondary">
                                            <h5 class="mb-0 text-white">Data Analisa</h5>
                                        </div>
                                        <div class="card-body mt-3">
                                            <div class="row mb-3">
                                                <label class="col-sm-2 col-form-label" for="tgl_survey">
                                                    Tgl Survey
                                                </label>
                                                <div class="col-sm-10">
                                                    <input id="tgl_survey" class="form-control"
                                                        readonly>{{ $skrk->tgl_survey }}</input>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-2 col-form-label" for="koordinat">
                                                    Koordinat
                                                </label>
                                                <div class="col-sm-10">
                                                    <input id="koordinat" class="form-control"
                                                        readonly>{{ $skrk->koordinat }}</input>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-6">
                                    <ol>
                                        @foreach ($skrk->layanan->persyaratanBerkas as $item)
                                            <li>
                                                {{ $item->nama_berkas }}
                                            </li>
                                        @endforeach
                                    </ol>
                                </div>
                            </div>

                        </div>

                        <div class="tab-pane fade" id="navs-pills-top-analisa" role="tabpanel">
                            Analisa
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @teleport('body')
            @livewire('admin.permohonan.skrk.skrk-survey-create', ['permohonan_id' => $skrk->permohonan->id, 'skrk_id' => $skrk->id])
        @endteleport
    </div>
</div>
