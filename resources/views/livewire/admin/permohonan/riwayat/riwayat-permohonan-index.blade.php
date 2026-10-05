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

    <div class="card mb-4">
        <div class="card-header d-flex align-items-center justify-content-between bg-secondary">
            <h5 class="mb-0 text-white">Riwayat Permohonan</h5>
        </div>
        <div class="card-body">
            <!-- Section: Timeline -->
            <section class="py-2">
                <ul class="timeline">
                    @foreach ($permohonan->registrasi->riwayat as $riwayat)
                        <li class="timeline-item mb-3">
                            <small class="text-muted">
                                {{ date('j F Y H:i:s', strtotime($riwayat->created_at)) }}
                            </small>
                            @if ($riwayat->instansi)
                                <div class="mt-1 mb-1">
                                    <span class="badge bg-{{ $riwayat->instansi === 'BPN' ? 'warning' : 'info' }} me-1">
                                        <i class="bx bx-buildings me-1"></i>{{ $riwayat->instansi }}
                                    </span>
                                    @if ($riwayat->proses)
                                        <span class="badge bg-label-primary me-1">
                                            {{ $riwayat->proses }}
                                        </span>
                                    @endif
                                    @if ($riwayat->tanggal_status)
                                        <span class="badge bg-label-secondary">
                                            Per: {{ \Carbon\Carbon::parse($riwayat->tanggal_status)->translatedFormat('d F Y') }}
                                        </span>
                                    @endif
                                </div>
                                @php
                                    $keteranganText = $riwayat->keterangan;
                                    if ($riwayat->instansi === 'BPN') {
                                        $keteranganText = str_ireplace(['(Bagian Survey)', '(Bagian Survey )'], '', $keteranganText);
                                        $keteranganText = preg_replace('/\s+/', ' ', $keteranganText);
                                    }
                                @endphp
                                <h6 class="fw-bold mb-1 text-dark">{{ $keteranganText }}</h6>
                            @else
                                <h5 class="fw-bold mb-1">{{ $riwayat->keterangan }}</h5>
                            @endif
                            <p class="text-muted mb-0 small">
                                Oleh : {{ $riwayat->user->name ?? '-' }}
                            </p>
                        </li>
                    @endforeach
                </ul>
            </section>
            <!-- Section: Timeline -->
        </div>
    </div>
</div>
