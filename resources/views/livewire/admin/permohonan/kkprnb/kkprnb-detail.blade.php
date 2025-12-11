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
                <span class="text-muted fw-light">Permohonan /</span> Detail Permohonan KKPRNB
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
                                data-bs-target="#navs-pills-top-jafung" aria-controls="navs-pills-top-jafung"
                                aria-selected="false">
                                Jafung
                            </button>
                        </li>
                        <li class="nav-item">
                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                data-bs-target="#navs-pills-top-finalisasi" aria-controls="navs-pills-top-finalisasi"
                                aria-selected="false">
                                Finalisasi
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
                                                        value="{{ $kkprnb->permohonan->registrasi->nama }}" readonly />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="nik">NIK</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="nik"
                                                        value="{{ Str::mask($kkprnb->permohonan->registrasi->nik, '*', 5, -1) }}"
                                                        readonly />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="no_hp">
                                                    No HP</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="no_hp"
                                                        value="{{ $kkprnb->permohonan->registrasi->no_hp }}" readonly />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="email">
                                                    Email
                                                </label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="email"
                                                        value="{{ $kkprnb->permohonan->registrasi->email }}"
                                                        autocomplete="off" readonly />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="npwp">
                                                    NPWP
                                                </label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="npwp"
                                                        value="{{ $kkprnb->permohonan->npwp }}" readonly />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="alamat_pemohon">
                                                    Alamat Pemohon
                                                </label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="alamat_pemohon"
                                                        value="{{ $kkprnb->permohonan->alamat_pemohon }}" readonly />
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
                                                        value="{{ $kkprnb->permohonan->registrasi->kode }}" readonly />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="layanan">Nama
                                                    Layanan</label>
                                                <div class="col-sm-8">
                                                    <input type="text" id="layanan" class="form-control"
                                                        value="{{ $kkprnb->permohonan->layanan->nama }}" readonly />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="tanggal">Tanggal
                                                    Registrasi</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="tanggal"
                                                        value="{{ date('d-m-Y', strtotime($kkprnb->permohonan->created_at)) }}"
                                                        readonly />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="alamat_tanah">Alamat
                                                    Tanah</label>
                                                <div class="col-sm-8">
                                                    <input type="text" id="alamat_tanah" class="form-control"
                                                        value="{{ $kkprnb->permohonan->registrasi->alamat_tanah }}"
                                                        readonly />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label"
                                                    for="kel_tanah">Kelurahan</label>
                                                <div class="col-sm-8">
                                                    <input type="text" id="kel_tanah" class="form-control"
                                                        value="{{ $kkprnb->permohonan->registrasi->kel_tanah }}"
                                                        readonly />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label"
                                                    for="kec_tanah">Kecamatan</label>
                                                <div class="col-sm-8">
                                                    <input type="text" id="kec_tanah" class="form-control"
                                                        value="{{ $kkprnb->permohonan->registrasi->kec_tanah }}"
                                                        readonly />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="fungsi_bangunan">
                                                    Fungsi Bangunan</label>
                                                <div class="col-sm-8">
                                                    <input type="text" id="fungsi_bangunan" class="form-control"
                                                        value="{{ $kkprnb->permohonan->registrasi->fungsi_bangunan }}"
                                                        readonly />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="luas_tanah">
                                                    Luas Tanah
                                                </label>
                                                <div class="col-sm-8">
                                                    <input type="text" id="luas_tanah" class="form-control"
                                                        value="{{ $kkprnb->permohonan->luas_tanah }} m2" readonly />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="tgl_validasi">
                                                    Tanggal Validasi Berkas
                                                </label>
                                                <div class="col-sm-8">
                                                    <input type="text" id="tgl_validasi" class="form-control"
                                                        value="@if($kkprnb->tgl_validasi != null) {{ date('d-m-Y', strtotime($kkprnb->tgl_validasi)) }} @endif" readonly />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="tgl_terima_ptp">
                                                    Tanggal Penerimaan PTP
                                                </label>
                                                <div class="col-sm-8">
                                                    <input type="text" id="tgl_terima_ptp" class="form-control"
                                                        value="@if($kkprnb->tgl_terima_ptp != null) {{ date('d-m-Y', strtotime($kkprnb->tgl_terima_ptp)) }} @endif" readonly />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="tgl_ptp">
                                                    Tanggal Penerbitan PTP
                                                </label>
                                                <div class="col-sm-8">
                                                    <input type="text" id="tgl_ptp" class="form-control"
                                                        value="@if($kkprnb->tgl_ptp != null) {{ date('d-m-Y', strtotime($kkprnb->tgl_ptp)) }} @endif" readonly />
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="no_ptp">
                                                    No PTP
                                                </label>
                                                <div class="col-sm-8">
                                                    <input type="text" id="no_ptp" class="form-control"
                                                        value="{{ $kkprnb->no_ptp }}" readonly />
                                                </div>
                                            </div>
                                            
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="rdtr_rtrw">
                                                    RDTR / RTRW
                                                </label>
                                                <div class="col-sm-8">
                                                    <input type="text" id="rdtr_rtrw" class="form-control"
                                                        value="{{ $kkprnb->rdtr_rtrw }}" readonly />
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="status">Status</label>
                                                <div class="col-sm-8">
                                                    <input type="text" id="status" class="form-control"
                                                        value="{{ $kkprnb->permohonan->status }}" readonly />
                                                </div>
                                            </div>
                                            @if ($kkprnb->permohonan->status == 'success')
                                                <div class="row mb-3">
                                                    <label class="col-sm-4 col-form-label" for="status">Tanggal
                                                        Selesai</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" id="status" class="form-control"
                                                            value="{{ date('d-m-Y', strtotime($kkprnb->permohonan->tgl_selesai)) }}"
                                                            readonly />
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="row mb-3">
                                                <span class="col-sm-4 col-form-label d-flex align-items-center">
                                                    Berkas
                                                </span>
                                                <div class="col-sm d-flex justify-content-around flex-wrap">
                                                    <a href="{{ $kkprnb->permohonan->berkas_ktp ? asset('storage/' . $kkprnb->permohonan->berkas_ktp) : 'javascript:void(0)' }}"
                                                        target="_blank" type="button" class="btn btn-primary m-1"
                                                        id="berkas">
                                                        KTP
                                                    </a>
                                                    <a href="{{ $kkprnb->permohonan->berkas_permohonan ? asset('storage/' . $kkprnb->permohonan->berkas_permohonan) : 'javascript:void(0)' }}"
                                                        target="_blank" type="button" class="btn btn-primary m-1">
                                                        Permohonan
                                                    </a>

                                                    <a href="{{ $kkprnb->permohonan->berkas_kuasa ? asset('storage/' . $kkprnb->permohonan->berkas_kuasa) : 'javascript:void(0)' }}"
                                                        target="_blank" type="button" class="btn btn-primary m-1">
                                                        Surat Kuasa
                                                    </a>

                                                    <a href="{{ $kkprnb->permohonan->berkas_nib ? asset('storage/' . $kkprnb->permohonan->berkas_nib) : 'javascript:void(0)' }}"
                                                        target="_blank" type="button" class="btn btn-primary m-1">
                                                        NIB
                                                    </a>

                                                    <a href="{{ $kkprnb->permohonan->berkas_penguasaan ? asset('storage/' . $kkprnb->permohonan->berkas_penguasaan) : 'javascript:void(0)' }}"
                                                        target="_blank" type="button" class="btn btn-primary m-1">
                                                        Penguasaan
                                                    </a>
                                                    <a href="{{ $kkprnb->berkas_ptp ? asset('storage/' . $kkprnb->berkas_ptp) : 'javascript:void(0)' }}"
                                                        target="_blank" type="button" class="btn btn-primary m-1">
                                                        PTP
                                                    </a>

                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label class="col-sm-4 col-form-label" for="keterangan">Ket.</label>
                                                <div class="col-sm-8">
                                                    <textarea id="keterangan" class="form-control" aria-describedby="basic-icon-default-message2" readonly>{{ $kkprnb->permohonan->keterangan }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    @livewire('admin.permohonan.riwayat.riwayat-permohonan-index', ['permohonan' => $kkprnb->permohonan])
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="navs-pills-top-survey" role="tabpanel">
                            @livewire('admin.permohonan.kkprnb.survey.kkprnb-survey-detail', ['kkprnb_id' => $kkprnb->id])
                        </div>

                        <div class="tab-pane fade" id="navs-pills-top-analisa" role="tabpanel">
                            @livewire('admin.permohonan.kkprnb.analis.kkprnb-analis-detail', ['kkprnb_id' => $kkprnb->id])
                        </div>

                        <div class="tab-pane fade" id="navs-pills-top-jafung" role="tabpanel">
                            @livewire('admin.permohonan.kkprnb.spv.kkprnb-verifikasi-detail', ['kkprnb_id' => $kkprnb->id])
                        </div>

                        <div class="tab-pane fade" id="navs-pills-top-finalisasi" role="tabpanel">
                            @livewire('admin.permohonan.kkprnb.final.kkprnb-final-detail', ['kkprnb_id' => $kkprnb->id])
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
