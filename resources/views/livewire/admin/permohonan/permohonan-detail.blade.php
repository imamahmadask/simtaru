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
                                Informasi
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
                                                <label class="col-sm-4 col-form-label" for="nama">Nama
                                                    Pemohon</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="nama"
                                                        value="{{ $permohonan->registrasi->nama }}" readonly />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="nik">NIK</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="nik"
                                                        value="{{ Str::mask($permohonan->registrasi->nik, '*', 5, -1) }}"
                                                        readonly />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="no_hp">
                                                    No HP</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="no_hp"
                                                        value="{{ $permohonan->registrasi->no_hp }}" readonly />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="email">
                                                    Email
                                                </label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="email"
                                                        value="{{ $permohonan->registrasi->email }}" autocomplete="off"
                                                        readonly />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="npwp">
                                                    NPWP
                                                </label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="npwp"
                                                        value="{{ $permohonan->npwp }}" readonly />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="alamat_pemohon">
                                                    Alamat Pemohon
                                                </label>
                                                <div class="col-sm-8">
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
                                                <label class="col-sm-4 col-form-label" for="kode">Kode
                                                    Registrasi</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="kode"
                                                        value="{{ $permohonan->registrasi->kode }}" readonly />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="layanan">Nama
                                                    Layanan</label>
                                                <div class="col-sm-8">
                                                    <input type="text" id="layanan" class="form-control"
                                                        value="{{ $permohonan->layanan->nama }}" readonly />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="tanggal">Tanggal
                                                    Registrasi</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="tanggal"
                                                        value="{{ date('d-m-Y', strtotime($permohonan->created_at)) }}"
                                                        readonly />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="alamat_tanah">Alamat
                                                    Tanah</label>
                                                <div class="col-sm-8">
                                                    <input type="text" id="alamat_tanah" class="form-control"
                                                        value="{{ $permohonan->alamat_tanah }}" readonly />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label"
                                                    for="kel_tanah">Kelurahan</label>
                                                <div class="col-sm-8">
                                                    <input type="text" id="kel_tanah" class="form-control"
                                                        value="{{ $permohonan->kel_tanah }}" readonly />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label"
                                                    for="kec_tanah">Kecamatan</label>
                                                <div class="col-sm-8">
                                                    <input type="text" id="kec_tanah" class="form-control"
                                                        value="{{ $permohonan->kec_tanah }}" readonly />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="jenis_bangunan">
                                                    Fungsi Bangunan</label>
                                                <div class="col-sm-8">
                                                    <input type="text" id="jenis_bangunan" class="form-control"
                                                        value="{{ $permohonan->jenis_bangunan }}" readonly />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="luas_tanah">
                                                    Luas Tanah
                                                </label>
                                                <div class="col-sm-8">
                                                    <input type="text" id="luas_tanah" class="form-control"
                                                        value="{{ $permohonan->luas_tanah }} m2" readonly />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="status_modal">
                                                    Status Permodalan
                                                </label>
                                                <div class="col-sm-8">
                                                    <input type="text" id="status_modal" class="form-control"
                                                        value="{{ $permohonan->status_modal }}" readonly />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="kbli">
                                                    KBLI
                                                </label>
                                                <div class="col-sm-8">
                                                    <input type="text" id="kbli" class="form-control"
                                                        value="{{ $permohonan->kbli }}" readonly />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="judul_kbli">
                                                    Judul KBLI
                                                </label>
                                                <div class="col-sm-8">
                                                    <input type="text" id="judul_kbli" class="form-control"
                                                        value="{{ $permohonan->judul_kbli }}" readonly />
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="status">Status</label>
                                                <div class="col-sm-8">
                                                    <input type="text" id="status" class="form-control"
                                                        value="{{ $permohonan->status }}" readonly />
                                                </div>
                                            </div>
                                            @if ($permohonan->status == 'success')
                                                <div class="row mb-3">
                                                    <label class="col-sm-4 col-form-label" for="status">Tanggal
                                                        Selesai</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" id="status" class="form-control"
                                                            value="{{ date('d-m-Y', strtotime($permohonan->tgl_selesai)) }}"
                                                            readonly />
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="row mb-3">
                                                <span class="col-sm-4 col-form-label d-flex align-items-center">
                                                    Berkas
                                                </span>
                                                <div class="col-sm-8 d-flex justify-content-around flex-wrap gap-1">
                                                    <a href="{{ $permohonan->berkas_ktp ? asset('storage/' . $permohonan->berkas_ktp) : 'javascript:void(0)' }}"
                                                        target="_blank" type="button" class="btn btn-primary m-1">
                                                        KTP
                                                    </a>
                                                    <a href="{{ $permohonan->berkas_permohonan ? asset('storage/' . $permohonan->berkas_permohonan) : 'javascript:void(0)' }}"
                                                        target="_blank" type="button" class="btn btn-primary m-1">
                                                        Permohonan
                                                    </a>
                                                    <a href="{{ $permohonan->berkas_kuasa ? asset('storage/' . $permohonan->berkas_kuasa) : 'javascript:void(0)' }}"
                                                        target="_blank" type="button" class="btn btn-primary m-1">
                                                        Surat Kuasa
                                                    </a>
                                                    <a href="{{ $permohonan->berkas_nib ? asset('storage/' . $permohonan->berkas_nib) : 'javascript:void(0)' }}"
                                                        target="_blank" type="button" class="btn btn-primary m-1">
                                                        NIB
                                                    </a>
                                                    <a href="{{ $permohonan->berkas_penguasaan ? asset('storage/' . $permohonan->berkas_penguasaan) : 'javascript:void(0)' }}"
                                                        target="_blank" type="button" class="btn btn-primary m-1">
                                                        Penguasaan
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="keterangan">Ket.</label>
                                                <div class="col-sm-8">
                                                    <textarea id="keterangan" class="form-control" aria-describedby="basic-icon-default-message2" readonly>{{ $permohonan->keterangan }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    @livewire('admin.permohonan.riwayat.riwayat-permohonan-index', ['permohonan' => $permohonan])

                                    <div class="card mb-4">
                                        <div
                                            class="card-header d-flex align-items-center justify-content-between bg-secondary">
                                            <h5 class="mb-0 text-white">Berkas</h5>
                                        </div>
                                        <div class="card-body mt-3">
                                            <div class="table-responsive text-nowrap mb-3">
                                                <table class="table table-hover table-bordered">
                                                    <thead>
                                                        <th>No</th>
                                                        <th>Nama Berkas</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            $no = 1;
                                                        @endphp
                                                        @foreach ($permohonan->berkas as $item)
                                                            <tr>
                                                                <td>{{ $no++ }}</td>
                                                                <td>{{ $item->file_path }}</td>
                                                                <td class="text-capitalize">
                                                                    @switch($item->status)
                                                                        @case('menunggu')
                                                                            <span
                                                                                class="badge bg-label-warning">Menunggu</span>
                                                                        @break

                                                                        @case('ditolak')
                                                                            <span class="badge bg-label-danger">Ditolak</span>
                                                                        @break

                                                                        @case('diterima')
                                                                            <span
                                                                                class="badge bg-label-primary">Diterima</span>
                                                                        @break
                                                                    @endswitch
                                                                </td>
                                                                <td>
                                                                    <a href="{{ asset('storage/' . $item->file_path) }}"
                                                                        class="btn btn-sm btn-primary"
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
    </div>
</div>
