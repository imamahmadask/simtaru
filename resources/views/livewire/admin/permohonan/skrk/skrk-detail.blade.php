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
                        <li class="nav-item">
                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                data-bs-target="#navs-pills-top-berkas" aria-controls="navs-pills-top-berkas"
                                aria-selected="false">
                                Berkas
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
                                                        value="{{ $skrk->permohonan->registrasi->email }}"
                                                        autocomplete="off" readonly />
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
                                                <label class="col-sm-2 col-form-label" for="jenis_bangunan">
                                                    Fungsi Bangunan</label>
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
                                                    <a href="{{ asset('storage/' . $skrk->permohonan->berkas_permohonan) }}"
                                                        target="_blank" type="button" class="btn btn-primary m-1">
                                                        Permohonan
                                                    </a>
                                                    <a href="{{ asset('storage/' . $skrk->permohonan->berkas_kuasa) }}"
                                                        target="_blank" type="button" class="btn btn-primary m-1">
                                                        Surat Kuasa
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
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="navs-pills-top-survey" role="tabpanel">
                            <div class="mb-3">
                                @if (!$skrk->is_survey)
                                    @if (Auth::user()->role == 'superadmin' || Auth::user()->role == 'supervisor' || Auth::user()->role == 'surveyor')
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#AddSurveyModal">
                                            <i class="bx bx-plus"></i> Add Survey
                                        </button>
                                    @endif
                                @else
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#EditSurveyModal">
                                        <i class="bx bx-edit"></i> Edit Survey
                                    </button>
                                    @teleport('body')
                                        @livewire('admin.permohonan.skrk.survey.skrk-survey-edit', ['permohonan_id' => $skrk->permohonan->id, 'skrk_id' => $skrk->id])
                                    @endteleport
                                @endif
                            </div>

                            <div class="row">
                                <div class="col-xl">
                                    <div class="card mb-4">
                                        <div
                                            class="card-header d-flex align-items-center justify-content-between bg-secondary">
                                            <h5 class="mb-0 text-white">Data Survey</h5>
                                        </div>
                                        <div class="card-body mt-3">
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="tgl_survey">
                                                    Tgl Survey
                                                </label>
                                                @if ($skrk->is_survey)
                                                    <div class="col-sm-8">
                                                        <input id="tgl_survey" class="form-control"
                                                            value="{{ date('d-m-Y', strtotime($skrk->tgl_survey)) }}"
                                                            readonly>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="koordinat">
                                                    Koordinat
                                                </label>
                                                @if ($skrk->is_survey)
                                                    <div class="table text-nowrap">
                                                        <table class="table table-hover table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>X</th>
                                                                    <th>Y</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($skrk->koordinat as $i => $point)
                                                                    <tr>
                                                                        <td>{{ $i + 1 }}</td>
                                                                        <td>{{ $point['x'] }}</td>
                                                                        <td>{{ $point['y'] }}</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card mb-4">
                                        <div
                                            class="card-header d-flex align-items-center justify-content-between bg-secondary">
                                            <h5 class="mb-0 text-white">Download Template Berkas</h5>
                                        </div>
                                        <div class="card-body mt-3">
                                            <div class="row mb-3">
                                                <button type="button" class="btn btn-primary"
                                                    wire:click="download1a">
                                                    Template 1A (Form Survey)
                                                </button>
                                            </div>
                                            <div class="row mb-3">
                                                <button type="button" class="btn btn-primary"
                                                    wire:click="download1b">
                                                    Template 1B (BA Survey)
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-6">
                                    @if ($skrk->foto_survey != null)
                                        @foreach (json_decode($skrk->foto_survey) as $item)
                                            <img src="{{ asset('storage/' . $item) }}" alt="" width="200px"
                                                class="mb-3">
                                        @endforeach

                                    @endif
                                </div>
                            </div>

                        </div>

                        <div class="tab-pane fade" id="navs-pills-top-analisa" role="tabpanel">
                            <div class="mb-3">
                                <div class="d-flex flex-wrap gap-3">
                                    @if (Auth::user()->role == 'superadmin' || Auth::user()->role == 'supervisor' || Auth::user()->role == 'analis')
                                        @if ($skrk->is_survey && !$skrk->is_kajian)
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#AddKajianAnalisaModal">
                                                <i class="bx bx-plus"></i> Data Kajian
                                            </button>
                                        @elseif($skrk->is_kajian)
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#EditKajianAnalisaModal">
                                                <i class="bx bx-edit"></i> Edit Data Kajian
                                            </button>
                                            @teleport('body')
                                                @livewire('admin.permohonan.skrk.analis.skrk-kajian-analis-edit', ['permohonan_id' => $skrk->permohonan->id, 'skrk_id' => $skrk->id])
                                            @endteleport
                                        @endif

                                        @if ($skrk->is_kajian && !$skrk->is_dokumen)
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#AddDokumenSkrkModal">
                                                <i class="bx bx-plus"></i> Data Dokumen
                                            </button>
                                        @elseif($skrk->is_dokumen)
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#EditDokumenSkrkModal">
                                                <i class="bx bx-edit"></i> Edit Data Dokumen
                                            </button>
                                            @teleport('body')
                                                @livewire('admin.permohonan.skrk.analis.skrk-dokumen-analis-edit', ['permohonan_id' => $skrk->permohonan->id, 'skrk_id' => $skrk->id])
                                            @endteleport
                                        @endif

                                        @if ($skrk->is_survey)
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#UploadBerkasAnalisaModal">
                                                <i class="bx bx-cloud-upload"></i> Berkas Analisa
                                            </button>
                                        @endif
                                    @endif
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="card mb-4">
                                        <div
                                            class="card-header d-flex align-items-center justify-content-between bg-secondary">
                                            <h5 class="mb-0 text-white">Data Kajian Analisa</h5>
                                        </div>
                                        <div class="card-body mt-3">
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="luas_permohonan">
                                                    Luas Permohonan
                                                </label>
                                                <div class="col-sm-8">
                                                    <input id="luas_permohonan" class="form-control"
                                                        value="{{ $skrk->permohonan->luas_tanah }} m2" readonly>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="penguasaan_tanah">
                                                    Informasi Penguasaan Tanah
                                                </label>
                                                <div class="col-sm-8">
                                                    <input id="penguasaan_tanah" class="form-control"
                                                        value="{{ $skrk->penguasaan_tanah }}" readonly>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="ada_bangunan">
                                                    Ada Bangunan
                                                </label>
                                                <div class="col-sm-8">
                                                    <div class="input-group">
                                                        <input id="ada_bangunan" class="form-control"
                                                            value="{{ $skrk->ada_bangunan }}" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="jml_bangunan">
                                                    Jumlah Bangunan
                                                </label>
                                                <div class="col-sm-8">
                                                    <div class="input-group">
                                                        <input id="jml_bangunan" class="form-control"
                                                            value="{{ $skrk->jml_bangunan }} Unit" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="jml_lantai">
                                                    Rencana Lantai Bangunan
                                                </label>
                                                <div class="col-sm-8">
                                                    <div class="input-group">
                                                        <input id="jml_lantai" class="form-control"
                                                            value="{{ $skrk->jml_lantai }} Lantai" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="luas_lantai">
                                                    Rencana Luas Lantai Bangunan
                                                </label>
                                                <div class="col-sm-8">
                                                    <div class="input-group">
                                                        <input id="luas_lantai" class="form-control"
                                                            value="{{ $skrk->luas_lantai }} m2" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="kedalaman_min">
                                                    Kedalaman/Ketinggian Minimal
                                                </label>
                                                <div class="col-sm-8">
                                                    <div class="input-group">
                                                        <input id="kedalaman_min" class="form-control"
                                                            value="{{ $skrk->kedalaman_min }} Meter" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="kedalaman_max">
                                                    Kedalaman/Ketinggian Maksimal
                                                </label>
                                                <div class="col-sm-8">
                                                    <div class="input-group">
                                                        <input id="kedalaman_max" class="form-control"
                                                            value="{{ $skrk->kedalaman_max }} Meter" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card mb-4">
                                        <div
                                            class="card-header d-flex align-items-center justify-content-between bg-secondary">
                                            <h5 class="mb-0 text-white">Download Template Berkas</h5>
                                        </div>
                                        <div class="card-body mt-3">
                                            <div class="row mb-3">
                                                <button type="button" class="btn btn-primary"
                                                    wire:click="download2a">
                                                    Template 2A (BA Rapat FPR)
                                                </button>
                                            </div>
                                            <div class="row mb-3">
                                                <button type="button" class="btn btn-primary"
                                                    wire:click="download2b">
                                                    Template 2B (Notulensi Rapat FPR)
                                                </button>
                                            </div>
                                            <div class="row mb-3">
                                                <button type="button" class="btn btn-primary"
                                                    wire:click="download3">
                                                    Template 3 (Kajian SKRK)
                                                </button>
                                            </div>
                                            <div class="row mb-3">
                                                <button type="button" class="btn btn-primary"
                                                    wire:click="download4">
                                                    Template 4 (Dokumen SKRK)
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-6">
                                    <div class="card mb-4">
                                        <div
                                            class="card-header d-flex align-items-center justify-content-between bg-secondary">
                                            <h5 class="mb-0 text-white">Data Dokumen SKRK</h5>
                                        </div>
                                        <div class="card-body mt-3">
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="luas_disetujui">
                                                    Luas Disetujui
                                                </label>
                                                <div class="col-sm-8">
                                                    <input id="luas_disetujui" class="form-control"
                                                        value="{{ $skrk->luas_disetujui }} m2" readonly>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="pemanfaatan_ruang">
                                                    Jenis Peruntukan Pemanfaatan Ruang
                                                </label>
                                                <div class="col-sm-8">
                                                    <input id="pemanfaatan_ruang" class="form-control"
                                                        value="{{ $skrk->pemanfaatan_ruang }}" readonly>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="peraturan_zonasi">
                                                    Peraturan Zonasi
                                                </label>
                                                <div class="col-sm-8">
                                                    <div class="input-group">
                                                        <input id="peraturan_zonasi" class="form-control"
                                                            value="{{ $skrk->peraturan_zonasi }}" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="kbli_diizinkan">
                                                    Kode KBLI Diizinkan
                                                </label>
                                                <div class="col-sm-8">
                                                    <div class="input-group">
                                                        <input id="kbli_diizinkan" class="form-control"
                                                            value="{{ $skrk->kbli_diizinkan }}" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="kdb">
                                                    Koefisien Dasar Bangunan (KDB) Maksimum
                                                </label>
                                                <div class="col-sm-8">
                                                    <div class="input-group">
                                                        <input id="kdb" class="form-control"
                                                            value="{{ $skrk->kdb }}" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="klb">
                                                    Koefisien Lantai Bangunan (KLB)
                                                </label>
                                                <div class="col-sm-8">
                                                    <div class="input-group">
                                                        <input id="klb" class="form-control"
                                                            value="{{ $skrk->klb }}" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="gsb">
                                                    Garis Sempadan Bangunan (GSB)
                                                </label>
                                                <div class="col-sm-8">
                                                    <div class="input-group">
                                                        <input id="gsb" class="form-control"
                                                            value="{{ $skrk->gsb }} Meter" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="jba">
                                                    Jarak Bebas Antar Bangunan (JBA) Minimum
                                                </label>
                                                <div class="col-sm-8">
                                                    <div class="input-group">
                                                        <input id="jba" class="form-control"
                                                            value="{{ $skrk->jba }} Meter" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="jbb">
                                                    Jarak Bebas Belakang (JBB) Minimum
                                                </label>
                                                <div class="col-sm-8">
                                                    <div class="input-group">
                                                        <input id="jbb" class="form-control"
                                                            value="{{ $skrk->jbb }} Meter" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="kdh">
                                                    Koefisien Dasar Hijau (KDH) Minimum
                                                </label>
                                                <div class="col-sm-8">
                                                    <div class="input-group">
                                                        <input id="kdh" class="form-control"
                                                            value="{{ $skrk->kdh }}" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="ktb">
                                                    Koefisien Tapak Basement (KTB)
                                                </label>
                                                <div class="col-sm-8">
                                                    <div class="input-group">
                                                        <input id="ktb" class="form-control"
                                                            value="{{ $skrk->ktb }}" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="luas_kavling">
                                                    Luas kavling Minimum
                                                </label>
                                                <div class="col-sm-8">
                                                    <div class="input-group">
                                                        <input id="luas_kavling" class="form-control"
                                                            value="{{ $skrk->luas_kavling }} m2" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="jaringan_utilitas">
                                                    Jaringan Utilitas Kota
                                                </label>
                                                <div class="col-sm-8">
                                                    <div class="input-group">
                                                        <input id="jaringan_utilitas" class="form-control"
                                                            value="{{ $skrk->jaringan_utilitas }}" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="persyaratan_pelaksanaan">
                                                    Persyaratan Pelaksanaan Kegiatan Pemanfaatan Ruang
                                                </label>
                                                <div class="col-sm-8">
                                                    <div class="input-group">
                                                        <input id="persyaratan_pelaksanaan" class="form-control"
                                                            value="{{ $skrk->persyaratan_pelaksanaan }}" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="navs-pills-top-berkas" role="tabpanel">
                            <div class="row">
                                <div class="col-xl">
                                    <div class="card mb-4">
                                        <div
                                            class="card-header d-flex align-items-center justify-content-between bg-secondary">
                                            <h5 class="mb-0 text-white">Berkas</h5>
                                        </div>
                                        <div class="card-body mt-3">
                                            <div class="table-responsive text-nowrap">
                                                <table class="table table-hover table-bordered">
                                                    <thead>
                                                        <th>No</th>
                                                        <th>Nama Berkas</th>
                                                        <th>Status</th>
                                                        <th>Lihat</th>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            $no = 1;
                                                        @endphp
                                                        @foreach ($skrk->permohonan->berkas as $item)
                                                            <tr>
                                                                <td>{{ $no++ }}</td>
                                                                <td>{{ $item->file_path }}</td>
                                                                <td>{{ $item->status }}</td>
                                                                <td>
                                                                    <a href="{{ asset('storage/' . $item->file_path) }}"
                                                                        target="_blank">
                                                                        <i class="bx bx-show"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @teleport('body')
            @livewire('admin.permohonan.skrk.survey.skrk-survey-create', ['permohonan_id' => $skrk->permohonan->id, 'skrk_id' => $skrk->id])
        @endteleport
        @teleport('body')
            @livewire('admin.permohonan.skrk.analis.skrk-kajian-analis-create', ['permohonan_id' => $skrk->permohonan->id, 'skrk_id' => $skrk->id])
        @endteleport
        @teleport('body')
            @livewire('admin.permohonan.skrk.analis.skrk-dokumen-analis-create', ['permohonan_id' => $skrk->permohonan->id, 'skrk_id' => $skrk->id])
        @endteleport
        @teleport('body')
            @livewire('admin.permohonan.skrk.analis.upload-berkas', ['permohonan_id' => $skrk->permohonan->id, 'skrk_id' => $skrk->id])
        @endteleport
    </div>
</div>
