<div>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Permohonan /</span> KKPR Berusaha</h4>

        <!-- Basic Bootstrap Table -->
        <div class="card">
            <h5 class="card-header">List Permohonan KKPR Berusaha</h5>
            <div class="row mx-3 mb-3">
                <div class="col d-flex justify-content-end align-items-center">
                    <!-- Search kanan -->
                    <div class="col-2">
                        <input class="form-control" type="search" wire:model.live="search" placeholder="Search"
                            aria-label="Search">
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Registrasi</th>
                            <th>Nama Pemohon</th>
                            <th>Tgl Permohonan</th>
                            <th>Waktu Penyelesaian</th>
                            <th>Keterangan</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">

                        @foreach ($kkprb as $data)
                            <div wire:key="{{ $data->id }}">
                                <tr>
                                    <td>
                                        {{ ($kkprb->currentPage() - 1) * $kkprb->perPage() + $loop->iteration }}
                                    </td>
                                    <td class="text-nowrap">
                                        <strong>
                                            {{ $data->registrasi->kode }}
                                        </strong>
                                    </td>
                                    <td>
                                        {{ $data->registrasi->nama }}
                                    </td>
                                    <td>
                                        {{ date('d-m-Y', strtotime($data->registrasi->tanggal)) }}
                                    </td>
                                    <td>
                                        @if ($data->permohonan->is_done)
                                            {{ $data->permohonan->waktu_pengerjaan }} Hari
                                        @endif
                                    </td>
                                    <td>
                                        {{ $data->permohonan->keterangan }}
                                    </td>
                                    <td>
                                        @if($data->permohonan->registrasi->status == 'Berkas Dicabut' || $data->permohonan->registrasi->status == 'Berkas Tidak Lengkap')
                                            <span
                                                class="badge bg-label-danger me-1">
                                                {{ $data->permohonan->registrasi->status }}
                                            </span>                                        
                                        @else
                                            <span
                                                class="badge bg-label-{{ $data->permohonan->status == 'completed' ? 'success' : 'warning' }} me-1">
                                                {{ is_null($data->permohonan) ? 'Belum Entry' : $data->permohonan->status }}
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($data->permohonan->registrasi->status != 'Berkas Dicabut' && $data->permohonan->registrasi->status != 'Berkas Tidak Lengkap')
                                            <div class="d-flex gap-1">
                                                <a href="{{ route('kkprb.detail', ['id' => $data->id]) }}" type="button"
                                                    class="btn btn-primary btn-sm" title="Detail">
                                                    <i class="bx bx-show"></i>
                                                </a>
                                                <button type="button" class="btn btn-info btn-sm"
                                                    wire:click="showTimeline({{ $data->id }})" title="History Timeline">
                                                    <i class="bx bx-history"></i>
                                                </button>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="row mx-3 my-3">
                <div class="col d-flex justify-content-end align-items-center">
                    {{ $kkprb->links() }}
                </div>
            </div>
        </div>
        <!--/ Basic Bootstrap Table -->

        {{-- Timeline Modal --}}
        <div wire:ignore.self class="modal fade" id="timelineModal" tabindex="-1" aria-labelledby="timelineModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title text-white" id="timelineModalLabel">
                            <i class="bx bx-time-five me-2"></i>Timeline Pengerjaan
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @if($showTimelineModal)
                            <div class="mb-3">
                                <h6 class="text-muted mb-1">Permohonan</h6>
                                <h5 class="fw-bold">{{ $timelineTitle }}</h5>
                            </div>

                            <hr>

                            @if(count($timelineData) > 0)
                                {{-- Summary Cards --}}
                                @php
                                    $surveyItems = collect($timelineData)->where('tahapan', 'Survey')->where('status', '!=', 'revised');
                                    $analisItems = collect($timelineData)->where('tahapan', 'Analisis')->where('status', '!=', 'revised');
                                    $verifikasiItems = collect($timelineData)->where('tahapan', 'Verifikasi')->where('status', '!=', 'revised');
                                    $cetakItems = collect($timelineData)->where('tahapan', 'Cetak')->where('status', '!=', 'revised');
                                @endphp

                                <div class="row g-3 mb-4">
                                    {{-- Survey Summary --}}
                                    <div class="col-md-6">
                                        <div class="card border shadow-none h-100">
                                            <div class="card-body p-3">
                                                <div class="d-flex align-items-center mb-2">
                                                    <div class="avatar avatar-sm me-2 flex-shrink-0" style="background-color: #e7f3ff; width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                                        <i class="bx bx-map" style="color: #2196F3; font-size: 18px;"></i>
                                                    </div>
                                                    <h6 class="mb-0 fw-bold">Survey</h6>
                                                </div>
                                                @if($surveyItems->count() > 0)
                                                    @php $latestSurvey = $surveyItems->last(); @endphp
                                                    <div class="small text-muted">Petugas: <strong>{{ $latestSurvey['penerima'] }}</strong></div>
                                                    <div class="small text-muted">Durasi: 
                                                        <span class="badge bg-label-{{ $latestSurvey['is_done'] ? 'success' : 'warning' }}">
                                                            {{ $latestSurvey['durasi'] }}
                                                        </span>
                                                    </div>
                                                @else
                                                    <div class="small text-muted fst-italic">Belum ada disposisi</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Analisis Summary --}}
                                    <div class="col-md-6">
                                        <div class="card border shadow-none h-100">
                                            <div class="card-body p-3">
                                                <div class="d-flex align-items-center mb-2">
                                                    <div class="avatar avatar-sm me-2 flex-shrink-0" style="background-color: #fef3e2; width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                                        <i class="bx bx-analyse" style="color: #FF9800; font-size: 18px;"></i>
                                                    </div>
                                                    <h6 class="mb-0 fw-bold">Analisis</h6>
                                                </div>
                                                @if($analisItems->count() > 0)
                                                    @php $latestAnalis = $analisItems->last(); @endphp
                                                    <div class="small text-muted">Petugas: <strong>{{ $latestAnalis['penerima'] }}</strong></div>
                                                    <div class="small text-muted">Durasi: 
                                                        <span class="badge bg-label-{{ $latestAnalis['is_done'] ? 'success' : 'warning' }}">
                                                            {{ $latestAnalis['durasi'] }}
                                                        </span>
                                                    </div>
                                                @else
                                                    <div class="small text-muted fst-italic">Belum ada disposisi</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Verifikasi Summary --}}
                                    <div class="col-md-6">
                                        <div class="card border shadow-none h-100">
                                            <div class="card-body p-3">
                                                <div class="d-flex align-items-center mb-2">
                                                    <div class="avatar avatar-sm me-2 flex-shrink-0" style="background-color: #e8f5e9; width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                                        <i class="bx bx-check-shield" style="color: #4CAF50; font-size: 18px;"></i>
                                                    </div>
                                                    <h6 class="mb-0 fw-bold">Verifikasi</h6>
                                                </div>
                                                @if($verifikasiItems->count() > 0)
                                                    @php $latestVerifikasi = $verifikasiItems->last(); @endphp
                                                    <div class="small text-muted">Petugas: <strong>{{ $latestVerifikasi['penerima'] }}</strong></div>
                                                    <div class="small text-muted">Durasi: 
                                                        <span class="badge bg-label-{{ $latestVerifikasi['is_done'] ? 'success' : 'warning' }}">
                                                            {{ $latestVerifikasi['durasi'] }}
                                                        </span>
                                                    </div>
                                                @else
                                                    <div class="small text-muted fst-italic">Belum ada disposisi</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Cetak Summary --}}
                                    <div class="col-md-6">
                                        <div class="card border shadow-none h-100">
                                            <div class="card-body p-3">
                                                <div class="d-flex align-items-center mb-2">
                                                    <div class="avatar avatar-sm me-2 flex-shrink-0" style="background-color: #fce4ec; width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                                        <i class="bx bx-printer" style="color: #E91E63; font-size: 18px;"></i>
                                                    </div>
                                                    <h6 class="mb-0 fw-bold">Cetak</h6>
                                                </div>
                                                @if($cetakItems->count() > 0)
                                                    @php $latestCetak = $cetakItems->last(); @endphp
                                                    <div class="small text-muted">Petugas: <strong>{{ $latestCetak['penerima'] }}</strong></div>
                                                    <div class="small text-muted">Durasi: 
                                                        <span class="badge bg-label-{{ $latestCetak['is_done'] ? 'success' : 'warning' }}">
                                                            {{ $latestCetak['durasi'] }}
                                                        </span>
                                                    </div>
                                                @else
                                                    <div class="small text-muted fst-italic">Belum ada disposisi</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Detail Timeline Table --}}
                                <h6 class="fw-bold mb-3"><i class="bx bx-list-ul me-1"></i> Detail Riwayat Disposisi</h6>
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="text-center" style="width: 40px;">No</th>
                                                <th>Tahapan</th>
                                                <th>Petugas</th>
                                                <th>Tgl Disposisi</th>
                                                <th>Tgl Mulai</th>
                                                <th>Tgl Selesai</th>
                                                <th>Durasi</th>
                                                <th class="text-center">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($timelineData as $index => $item)
                                                <tr class="{{ $item['is_revisi'] ? 'table-warning' : '' }}">
                                                    <td class="text-center">{{ $index + 1 }}</td>
                                                    <td>
                                                        <strong>{{ $item['tahapan'] }}</strong>
                                                        @if($item['is_revisi'])
                                                            <span class="badge bg-label-warning ms-1" style="font-size: 10px;">Revisi</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{ $item['penerima'] }}
                                                        <br><small class="text-muted">{{ ucfirst($item['role']) }}</small>
                                                    </td>
                                                    <td class="text-nowrap small">
                                                        @php
                                                            $tgl_disposisi = explode(' ', $item['tanggal_disposisi']);
                                                        @endphp
                                                        {{ $tgl_disposisi[0] }}
                                                        @if (isset($tgl_disposisi[1]))
                                                            <br><small class="text-muted fst-italic">{{ $tgl_disposisi[1] }}</small>
                                                        @endif
                                                    </td>
                                                    <td class="text-nowrap small">
                                                        @php
                                                            $tgl_mulai = explode(' ', $item['tgl_mulai_kerja']);
                                                        @endphp
                                                        {{ $tgl_mulai[0] }}
                                                        @if (isset($tgl_mulai[1]))
                                                            <br><small class="text-muted fst-italic">{{ $tgl_mulai[1] }}</small>
                                                        @endif
                                                    </td>
                                                    <td class="text-nowrap small">
                                                        @php
                                                            $tgl_selesai = explode(' ', $item['tgl_selesai']);
                                                        @endphp
                                                        {{ $tgl_selesai[0] }}
                                                        @if (isset($tgl_selesai[1]))
                                                            <br><small class="text-muted fst-italic">{{ $tgl_selesai[1] }}</small>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($item['is_done'])
                                                            <span class="text-success fw-bold">{{ $item['durasi'] }}</span>
                                                        @else
                                                            <span class="text-warning fst-italic">{{ $item['durasi'] }}</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        @if($item['status'] == 'completed')
                                                            <span class="badge bg-success"><i class="bx bx-check"></i> Selesai</span>
                                                        @elseif($item['status'] == 'revised')
                                                            <span class="badge bg-warning"><i class="bx bx-revision"></i> Direvisi</span>
                                                        @else
                                                            <span class="badge bg-secondary"><i class="bx bx-loader-alt"></i> Proses</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                @if($permohonanIsDone)
                                    <div class="mt-3 p-3 bg-label-success border rounded">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h6 class="mb-0 fw-bold text-success">Total Waktu Penyelesaian:</h6>
                                            <span class="badge bg-success" style="font-size: 14px;">{{ $permohonanWaktuPekerjaan }} Hari</span>
                                        </div>
                                    </div>
                                @endif
                            @else
                                <div class="text-center py-4">
                                    <i class="bx bx-info-circle text-muted" style="font-size: 48px;"></i>
                                    <p class="text-muted mt-2">Belum ada data disposisi untuk permohonan ini.</p>
                                </div>
                            @endif
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@script
    <script>
        $wire.on('open-timeline-modal', () => {
            const modal = new bootstrap.Modal(document.getElementById('timelineModal'));
            modal.show();
        });
    </script>
@endscript
