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
                                {{ date('j F Y h:i:s', strtotime($riwayat->created_at)) }}
                            </small>
                            <h5 class="fw-bold mb-1">{{ $riwayat->keterangan }}</h5>
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
