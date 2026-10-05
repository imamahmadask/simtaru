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

    <form wire:submit.prevent="lacakBerkas">
        <div class="input-group input-group-lg shadow-sm">
            <span class="input-group-text bg-white border-end-0">
                <i class="bi bi-search text-muted"></i>
            </span>
            <input type="text" wire:model="no_reg" class="form-control border-start-0 ps-0"
                placeholder="Masukkan nomor registrasi untuk melacak berkas..." aria-label="Nomor Registrasi">
            <button class="btn btn-primary px-4 fw-bold" type="submit" wire:loading.attr="disabled"
                data-bs-toggle="modal" data-bs-target="#showModalDetailRegistrasi">
                Cari
            </button>
            <div wire:loading class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </form>

    <div wire:ignore.self class="modal fade" id="showModalDetailRegistrasi" data-bs-backdrop="static" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">
                        Riwayat Registrasi
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-start">
                    <div class="row">
                        <div class="col-md-12 col-lg-12 mt-5 mt-md-0">
                            @if ($riwayats)
                                Nomor Registrasi : <strong>{{ $berkas->kode }}</strong> <br>
                                Nama Pemohon : <strong>{{ $berkas->nama }}</strong>

                                @if ($berkas->permohonan?->posisi_berkas)
                                    <div
                                        class="alert alert-{{ $berkas->permohonan->posisi_berkas === 'BPN' ? 'warning' : 'info' }} mt-3 mb-2 p-3 rounded">
                                        <div class="d-flex align-items-center">
                                            <i
                                                class="bi bi-geo-alt-fill text-{{ $berkas->permohonan->posisi_berkas === 'BPN' ? 'warning' : 'primary' }} fs-3 me-2"></i>
                                            <div>
                                                <span class="d-block small text-muted text-uppercase fw-semibold">Status Posisi Berkas Terkini</span>
                                                <strong class="d-block text-dark">
                                                    Berkas sedang berada di {{ $berkas->permohonan->posisi_berkas }}{{ $berkas->permohonan->proses_berkas ? ' (' . $berkas->permohonan->proses_berkas . ')' : '' }}
                                                </strong>
                                                <span class="d-block small text-muted">
                                                    Per Tanggal:
                                                    {{ $berkas->permohonan->tgl_posisi_berkas ? \Carbon\Carbon::parse($berkas->permohonan->tgl_posisi_berkas)->translatedFormat('d F Y') : '-' }}
                                                </span>
                                                @if ($berkas->permohonan->ket_posisi_berkas)
                                                    <span class="d-block small fst-italic text-dark mt-1">
                                                        "{{ $berkas->permohonan->ket_posisi_berkas }}"
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <hr>

                                <section class="p-2 mt-2" style="max-height: 470px; overflow-y: auto;">
                                    <ul class="timeline">
                                        @foreach ($riwayats as $riwayat)
                                            <li class="timeline-item mb-3">
                                                <small class="text-muted">
                                                    {{ date('j F Y H:i:s', strtotime($riwayat->created_at)) }}
                                                </small>
                                                @if ($riwayat->instansi)
                                                    <div class="mt-1 mb-1">
                                                        <span
                                                            class="badge bg-{{ $riwayat->instansi === 'BPN' ? 'warning' : 'info' }} me-1">
                                                            {{ $riwayat->instansi }}
                                                        </span>
                                                        @if ($riwayat->proses)
                                                            <span class="badge bg-secondary me-1">
                                                                {{ $riwayat->proses }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                    @php
                                                        $keteranganText = $riwayat->keterangan;
                                                        if ($riwayat->instansi === 'BPN') {
                                                            $keteranganText = str_ireplace(
                                                                [
                                                                    '(Bagian Survey)',
                                                                    '(Bagian Survey )',
                                                                ],
                                                                '',
                                                                $keteranganText,
                                                            );
                                                            $keteranganText = preg_replace(
                                                                '/\s+/',
                                                                ' ',
                                                                $keteranganText,
                                                            );
                                                        }
                                                    @endphp
                                                    <h6 class="fw-semibold fs-6 mb-1 text-dark">{{ $keteranganText }}
                                                    </h6>
                                                @else
                                                    <h5 class="fw-semibold fs-6 mb-1">{{ $riwayat->keterangan }}</h5>
                                                @endif
                                                <p class="text-muted small mb-0">
                                                    Oleh : {{ $riwayat->user->name ?? '-' }}
                                                </p>
                                            </li>
                                        @endforeach
                                    </ul>
                                </section>
                            @else
                                <p class="text-center">Data tidak ditemukan</p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</div>
