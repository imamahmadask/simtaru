<div>
    <style>
        .form-control:disabled,
        .form-control[readonly] {
            background-color: #ffffff;
            opacity: 1;
        }
    </style>

    <div class="container-xxl flex-grow-1 container-p-y">
        @if (session()->has('success'))
            <div class="bs-toast toast bg-primary fade top-0 end-0 mb-2" role="alert" aria-live="assertive"
                aria-atomic="true" data-bs-delay="3000" data-bs-autohide="true">
                <div class="toast-header">
                    <i class="bx bx-bell me-2"></i>
                    <div class="me-auto fw-semibold">Message!</div>
                    <small>a moment ago</small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">{{ session('success') }}</div>
            </div>
        @elseif(session()->has('error'))
            <div class="bs-toast toast bg-danger fade top-0 end-0 m-2" role="alert" aria-live="assertive"
                aria-atomic="true" data-bs-delay="3000" data-bs-autohide="true">
                <div class="toast-header">
                    <i class="bx bx-bell me-2"></i>
                    <div class="me-auto fw-semibold">Message!</div>
                    <small>a moment ago</small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">{{ session('error') }}</div>
            </div>
        @endif

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
                                                <label class="col-sm-4 col-form-label" for="nama">Nama</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="nama"
                                                        value="{{ $skrk->permohonan->registrasi->nama }}" readonly />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="nik">NIK</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="nik"
                                                        value="{{ Str::mask($skrk->permohonan->registrasi->nik, '*', 5, -1) }}"
                                                        readonly />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="no_hp">
                                                    No HP</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="no_hp"
                                                        value="{{ $skrk->permohonan->registrasi->no_hp }}" readonly />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="email">
                                                    Email
                                                </label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="email"
                                                        value="{{ $skrk->permohonan->registrasi->email }}"
                                                        autocomplete="off" readonly />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="npwp">
                                                    NPWP
                                                </label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="npwp"
                                                        value="{{ $skrk->permohonan->npwp }}" readonly />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="alamat_pemohon">
                                                    Alamat Pemohon
                                                </label>
                                                <div class="col-sm-8">
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
                                                <label class="col-sm-4 col-form-label" for="kode">Kode
                                                    Registrasi</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="kode"
                                                        value="{{ $skrk->permohonan->registrasi->kode }}" readonly />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="layanan">Nama
                                                    Layanan</label>
                                                <div class="col-sm-8">
                                                    <input type="text" id="layanan" class="form-control"
                                                        value="{{ $skrk->permohonan->layanan->nama }}" readonly />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="tanggal">Tanggal
                                                    Registrasi</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="tanggal"
                                                        value="{{ date('d-m-Y', strtotime($skrk->permohonan->created_at)) }}"
                                                        readonly />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="alamat_tanah">Alamat
                                                    Tanah</label>
                                                <div class="col-sm-8">
                                                    <input type="text" id="alamat_tanah" class="form-control"
                                                        value="{{ $skrk->permohonan->registrasi->alamat_tanah }}"
                                                        readonly />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label"
                                                    for="kel_tanah">Kelurahan</label>
                                                <div class="col-sm-8">
                                                    <input type="text" id="kel_tanah" class="form-control"
                                                        value="{{ $skrk->permohonan->registrasi->kel_tanah }}"
                                                        readonly />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label"
                                                    for="kec_tanah">Kecamatan</label>
                                                <div class="col-sm-8">
                                                    <input type="text" id="kec_tanah" class="form-control"
                                                        value="{{ $skrk->permohonan->registrasi->kec_tanah }}"
                                                        readonly />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="fungsi_bangunan">
                                                    Fungsi Bangunan</label>
                                                <div class="col-sm-8">
                                                    <input type="text" id="fungsi_bangunan" class="form-control"
                                                        value="{{ $skrk->permohonan->registrasi->fungsi_bangunan }}"
                                                        readonly />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="luas_tanah">
                                                    Luas Tanah
                                                </label>
                                                <div class="col-sm-8">
                                                    <input type="text" id="luas_tanah" class="form-control"
                                                        value="{{ $skrk->permohonan->luas_tanah }} m2" readonly />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="status">Status</label>
                                                <div class="col-sm-8">
                                                    <input type="text" id="status" class="form-control"
                                                        value="{{ $skrk->permohonan->status }}" readonly />
                                                </div>
                                            </div>
                                            @if ($skrk->permohonan->status == 'success')
                                                <div class="row mb-3">
                                                    <label class="col-sm-4 col-form-label" for="status">Tanggal
                                                        Selesai</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" id="status" class="form-control"
                                                            value="{{ date('d-m-Y', strtotime($skrk->permohonan->tgl_selesai)) }}"
                                                            readonly />
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="row mb-3">
                                                <span class="col-sm-4 col-form-label d-flex align-items-center">
                                                    Berkas
                                                </span>
                                                <div class="col-sm d-flex justify-content-around flex-wrap">
                                                    <a href="{{ $skrk->permohonan->berkas_ktp ? asset('storage/' . $skrk->permohonan->berkas_ktp) : 'javascript:void(0)' }}"
                                                        target="_blank" type="button" class="btn btn-primary m-1"
                                                        id="berkas">
                                                        KTP
                                                    </a>
                                                    <a href="{{ $skrk->permohonan->berkas_permohonan ? asset('storage/' . $skrk->permohonan->berkas_permohonan) : 'javascript:void(0)' }}"
                                                        target="_blank" type="button" class="btn btn-primary m-1">
                                                        Permohonan
                                                    </a>

                                                    <a href="{{ $skrk->permohonan->berkas_kuasa ? asset('storage/' . $skrk->permohonan->berkas_kuasa) : 'javascript:void(0)' }}"
                                                        target="_blank" type="button" class="btn btn-primary m-1">
                                                        Surat Kuasa
                                                    </a>

                                                    <a href="{{ $skrk->permohonan->berkas_nib ? asset('storage/' . $skrk->permohonan->berkas_nib) : 'javascript:void(0)' }}"
                                                        target="_blank" type="button" class="btn btn-primary m-1">
                                                        NIB
                                                    </a>

                                                    <a href="{{ $skrk->permohonan->berkas_penguasaan ? asset('storage/' . $skrk->permohonan->berkas_penguasaan) : 'javascript:void(0)' }}"
                                                        target="_blank" type="button" class="btn btn-primary m-1">
                                                        Penguasaan
                                                    </a>

                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="keterangan">Ket.</label>
                                                <div class="col-sm-8">
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
                            @livewire('admin.permohonan.skrk.survey.skrk-survey-detail', ['skrk_id' => $skrk->id])
                        </div>

                        <div class="tab-pane fade" id="navs-pills-top-analisa" role="tabpanel">
                            @livewire('admin.permohonan.skrk.analis.skrk-analis-detail', ['skrk_id' => $skrk->id])
                        </div>

                        <div class="tab-pane fade" id="navs-pills-top-berkas" role="tabpanel">
                            <div class="row">
                                <div class="col-xl">
                                    <div class="card mb-4">
                                        <div
                                            class="card-header d-flex align-items-center justify-content-between bg-secondary">
                                            <h5 class="mb-0 text-white">Berkas SKRK</h5>
                                        </div>
                                        <div class="card-body mt-3">
                                            <div class="table-responsive text-nowrap mb-3">
                                                <table class="table table-hover table-bordered">
                                                    <thead>
                                                        <th>No</th>
                                                        <th>Nama Berkas</th>
                                                        <th>Status</th>
                                                        <th>Catatan</th>
                                                        <th>Action</th>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            $no = 1;
                                                        @endphp
                                                        @foreach ($skrk->permohonan->berkas as $item)
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
                                                                    {{ $item->catatan_verifikator }}
                                                                </td>
                                                                <td>
                                                                    <a href="{{ asset('storage/' . $item->file_path) }}"
                                                                        class="btn btn-sm btn-primary"
                                                                        target="_blank">
                                                                        <i class="bx bx-show"></i>
                                                                    </a>
                                                                    @if (Auth::user()->role == 'superadmin' || Auth::user()->role == 'supervisor')
                                                                        @if ($skrk->is_analis && $item->status == 'menunggu')
                                                                            <button class="btn btn-sm btn-success"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#VerifikasiModal">
                                                                                Verifikasi
                                                                            </button>
                                                                            @teleport('body')
                                                                                @livewire('admin.permohonan.skrk.spv.skrk-verifikasi', ['skrk_id' => $skrk->id, 'berkas_id' => $item->id])
                                                                            @endteleport
                                                                        @elseif($skrk->is_analis && $item->status == 'ditolak')
                                                                            <button class="btn btn-sm btn-success"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#EditVerifikasiModal">
                                                                                Edit Verifikasi
                                                                            </button>
                                                                            @teleport('body')
                                                                                @livewire('admin.permohonan.skrk.spv.skrk-edit-verifikasi', ['skrk_id' => $skrk->id, 'berkas_id' => $item->id])
                                                                            @endteleport
                                                                        @endif
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>

                                            @if ($skrk->is_analis && !$skrk->is_validate && $count_verifikasi == 0)
                                                <button type="button"
                                                    class="btn {{ $skrk->is_validate ? 'btn-primary' : 'btn-warning' }}"
                                                    data-bs-toggle="modal" data-bs-target="#selesaiVerifikasiModal">
                                                    <i class="bx bx-check"></i> Selesai Verifikasi Berkas
                                                </button>
                                            @elseif ($skrk->is_validate)
                                                <button type="button" class="btn btn-primary" disabled>
                                                    <i class="bx bx-check"></i> Semua Berkasi Sudah Diverifikasi
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div wire:ignore.self class="modal fade" id="selesaiVerifikasiModal" data-bs-backdrop="static"
            tabindex="-1" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel1">
                            Proses Verifikasi Selesai
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Pastikan seluruh data dan berkas sudah terverifikasi dengan baik.
                        Lanjutkan ke proses cetak dokumen SKRK?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                            Tidak
                        </button>
                        <button type="button" class="btn btn-primary" wire:click="selesaiVerifikasi">
                            Ya
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
