<div>
    <style>
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
            top: 5px;
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

    <div wire:ignore.self class="modal fade" id="detailRegistrasiModal" data-bs-backdrop="static" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">
                        Detail Registrasi
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 col-lg-6 pe-md-5">
                            <div class="table-responsive text-nowrap">
                                <table class="table table-hover">
                                    <thead>
                                        <th>Label</th>
                                        <th>Data</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Kode Registrasi</td>
                                            <td>{{ $kode }}</td>
                                        </tr>
                                        <tr>
                                            <td>Tanggal Registrasi</td>
                                            <td>{{ date('d F Y', strtotime($tanggal)) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Nama</td>
                                            <td>{{ $nama }}</td>
                                        </tr>
                                        <tr>
                                            <td>NIK</td>
                                            <td>{{ Str::mask($nik, '*', 5, -1) }}</td>
                                        </tr>
                                        <tr>
                                            <td>No Telpon</td>
                                            <td>{{ $no_hp }}</td>
                                        </tr>
                                        <tr>
                                            <td>Email</td>
                                            <td>{{ $email }}</td>
                                        </tr>
                                        <tr>
                                            <td>Layanan Permohonan</td>
                                            <td>{{ $layanan }}</td>
                                        </tr>
                                        <tr>
                                            <td>Fungsi Bangunan</td>
                                            <td>{{ $fungsi_bangunan }}</td>
                                        </tr>
                                        <tr>
                                            <td>Alamat Persil</td>
                                            <td>{{ $alamat_tanah }}</td>
                                        </tr>
                                        <tr>
                                            <td>Kelurahan Persil</td>
                                            <td>{{ $kel_tanah }}</td>
                                        </tr>
                                        <tr>
                                            <td>Kecamatan Persil</td>
                                            <td>{{ $kec_tanah }}</td>
                                        </tr>
                                        @if($status == 'Berkas Dicabut')
                                            <tr>
                                                <td>Status Berkas</td>
                                                <td>
                                                    <span class="badge bg-label-danger">{{ $status }}</span>
                                                </td>
                                            </tr>
                                        @elseif($permohonan != NULL)
                                            <tr>
                                                <td>Status</td>
                                                <td>
                                                    <span
                                                        class="badge bg-label-{{ is_null($permohonan) ? 'danger' : ($permohonan->status === 'completed' ? 'success' : 'warning') }}">
                                                        {{ is_null($permohonan) ? 'Belum Entry' : $permohonan->status }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 ps-md-5 mt-5 mt-md-0">
                            <h5 class="fw-bold">Riwayat Registrasi</h5>
                            <section class="p-2 mt-2" style="max-height: 470px; overflow-y: auto;">
                                <ul class="timeline">
                                    @foreach ($riwayats as $riwayat)
                                        <li class="timeline-item mb-3">
                                            <small class="text-muted">
                                                {{ date('j F Y h:i:s', strtotime($riwayat->created_at)) }}
                                            </small>
                                            <h5 class="fw-semibold fs-6 mb-1">{{ $riwayat->keterangan }}</h5>
                                            <p class="text-muted">
                                                Oleh : {{ $riwayat->user->name }}
                                            </p>
                                        </li>
                                    @endforeach
                                </ul>
                            </section>
                            <!-- Section: Timeline -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
