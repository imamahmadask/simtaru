<div>
    <style>
        .form-control:disabled,
        .form-control[readonly] {
            background-color: #ffffff;
            opacity: 1;
        }

        .timeline {
            border-left: 1px solid hsl(0, 0%, 90%);
            position: relative;
            list-style: none;
        }

        .timeline .timeline-item {
            position: relative;
        }

        .timeline .timeline-item:after {
            position: absolute;
            display: block;
            top: 0;
        }

        .timeline .timeline-item:after {
            background-color: hsl(0, 0%, 90%);
            left: -38px;
            border-radius: 50%;
            height: 11px;
            width: 11px;
            content: "";
        }
    </style>

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Permohonan /</span> Detail Permohonan</h4>
        <div class="row">
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Data Permohonan</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Kode Registrasi</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" value="{{ $permohonan->registrasi->kode }}"
                                    readonly />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-company">Tanggal
                                Registrasi</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control"
                                    value="{{ $permohonan->registrasi->tanggal }}" readonly />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-phone">Nama Layanan</label>
                            <div class="col-sm-10">
                                <input type="text" id="basic-default-phone" class="form-control"
                                    value="{{ $permohonan->layanan->nama }}" readonly />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-phone">Alamat Tanah</label>
                            <div class="col-sm-10">
                                <input type="text" id="basic-default-phone" class="form-control"
                                    value="{{ $permohonan->alamat_tanah }}" readonly />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-phone">Kelurahan</label>
                            <div class="col-sm-10">
                                <input type="text" id="basic-default-phone" class="form-control"
                                    value="{{ $permohonan->kel_tanah }}" readonly />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-phone">Kecamatan</label>
                            <div class="col-sm-10">
                                <input type="text" id="basic-default-phone" class="form-control"
                                    value="{{ $permohonan->kec_tanah }}" readonly />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-phone">Jenis Bangunan</label>
                            <div class="col-sm-10">
                                <input type="text" id="basic-default-phone" class="form-control"
                                    value="{{ $permohonan->jenis_bangunan }}" readonly />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-phone">Status</label>
                            <div class="col-sm-10">
                                <input type="text" id="basic-default-phone" class="form-control"
                                    value="{{ $permohonan->status }}" readonly />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-message">Keterangan</label>
                            <div class="col-sm-10">
                                <textarea id="basic-default-message" class="form-control" aria-describedby="basic-icon-default-message2" readonly>{{ $permohonan->keterangan }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Data Pemohon</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Nama</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" value="{{ $permohonan->registrasi->nama }}"
                                    readonly />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-company">NIK</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" value="{{ $permohonan->registrasi->nik }}"
                                    readonly />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-phone">No Handphone</label>
                            <div class="col-sm-10">
                                <input type="text" id="basic-default-phone" class="form-control"
                                    value="{{ $permohonan->registrasi->no_hp }}" readonly />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Riwayat</h5>
                    </div>
                    <div class="card-body">
                        <!-- Section: Timeline -->
                        <section class="py-5">
                            <ul class="timeline">
                                <li class="timeline-item mb-5">
                                    <h5 class="fw-bold">Our company starts its operations</h5>
                                    <p class="text-muted mb-2 fw-bold">11 March 2020</p>
                                    <p class="text-muted">
                                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Sit
                                        necessitatibus adipisci, ad alias, voluptate pariatur officia
                                        repellendus repellat inventore fugit perferendis totam dolor
                                        voluptas et corrupti distinctio maxime corporis optio?
                                    </p>
                                </li>

                                <li class="timeline-item mb-5">
                                    <h5 class="fw-bold">First customer</h5>
                                    <p class="text-muted mb-2 fw-bold">19 March 2020</p>
                                    <p class="text-muted">
                                        Quisque ornare dui nibh, sagittis egestas nisi luctus nec. Sed
                                        aliquet laoreet sapien, eget pulvinar lectus maximus vel.
                                        Phasellus suscipit porta mattis.
                                    </p>
                                </li>

                                <li class="timeline-item mb-5">
                                    <h5 class="fw-bold">Our team exceeds 10 people</h5>
                                    <p class="text-muted mb-2 fw-bold">24 June 2020</p>
                                    <p class="text-muted">
                                        Orci varius natoque penatibus et magnis dis parturient montes,
                                        nascetur ridiculus mus. Nulla ullamcorper arcu lacus, maximus
                                        facilisis erat pellentesque nec. Duis et dui maximus dui aliquam
                                        convallis. Quisque consectetur purus erat, et ullamcorper sapien
                                        tincidunt vitae.
                                    </p>
                                </li>

                                <li class="timeline-item mb-5">
                                    <h5 class="fw-bold">Earned the first million $!</h5>
                                    <p class="text-muted mb-2 fw-bold">15 October 2020</p>
                                    <p class="text-muted">
                                        Nulla ac tellus convallis, pulvinar nulla ac, fermentum diam. Sed
                                        et urna sit amet massa dapibus tristique non finibus ligula. Nam
                                        pharetra libero nibh, id feugiat tortor rhoncus vitae. Ut suscipit
                                        vulputate mattis.
                                    </p>
                                </li>
                            </ul>
                        </section>
                        <!-- Section: Timeline -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
