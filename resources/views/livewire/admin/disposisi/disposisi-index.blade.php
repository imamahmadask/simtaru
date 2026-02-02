<div>
    <style>
        .scrollable-cell {
            max-width: 250px;
            /* atur lebar maksimum kolom */
            white-space: nowrap;
            /* supaya teks tidak turun ke bawah */
            overflow-x: auto;
            /* munculkan scroll horizontal */
            overflow-y: hidden;
            /* cegah scroll vertical */

            /* wajib supaya overflow bisa jalan */
        }

        .timeline {
            border-left: 2px solid #e9ecef;
            position: relative;
            list-style: none;
            padding-left: 30px; /* Jarak dari garis ke konten */
            margin-left: 10px;
        }

        .timeline .timeline-item {
            position: relative;
        }

        /* Titik Bulat Bulatan */
        .timeline .timeline-item::before {
            content: "";
            position: absolute;
            width: 16px;
            height: 16px;
            background-color: #fff;
            border: 3px solid #696cff; /* Warna default (Primary) */
            border-radius: 50%;
            left: -39px; /* Posisi tepat di tengah garis */
            top: 0; /* Sejajar dengan baris pertama teks (Header) */
            z-index: 1;
        }

        /* Warna Titik Jika Revisi */
        .timeline .timeline-item.is-revisi::before {
            border-color: #ff3e1d; /* Warna Danger */
        }

        .timeline-event {
            position: relative;
            top: -4px; /* Kompensasi agar teks sejajar tengah dengan bulatan */
        }

        .timeline-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        /* Kotak Catatan agar lebih rapi */
        .catatan-box {
            background-color: #f8f9fa;
            border-radius: 6px;
            padding: 10px 15px;
            border-left: 3px solid #d1d5db;
            margin-top: 8px;
        }
    </style>
    <div class="container-xxl flex-grow-1 container-p-y">
        @if (session()->has('success'))
            <div class="bs-toast toast fade show bg-primary top-0 end-0 m-2" role="alert" aria-role="alert"
                aria-live="assertive" aria-atomic="true" data-delay="2000">
                <div class="toast-header">
                    <i class="bx bx-bell me-2"></i>
                    <div class="me-auto fw-semibold">Bootstrap</div>
                    <small>a moment ago</small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">{{ session('success') }}</div>
            </div>
        @endif

        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Disposisi /</span> Daftar Disposisi</h4>

        @if (Auth::user()->role == 'superadmin')
            <div class="card">
                <h5 class="card-header">Monitoring Perjalanan Berkas (Grouping)</h5>
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Kode/Layanan</th>
                                <th>Pemohon</th>
                                <th>Pemberi</th>
                                <th>Penerima/Tahapan</th>
                                <th>Jenis</th>
                                <th class="text-center">Riwayat</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($disposisi as $data)
                                <tr wire:key="group-{{ $data->id }}">
                                    <td>{{ ($disposisi->currentPage() - 1) * $disposisi->perPage() + $loop->iteration }}</td>
                                    <td>
                                        {{ date('d-m-Y', strtotime($data->tanggal_disposisi)) }} <br>
                                        <small class="text-muted fst-italic">{{ date('H:i:s', strtotime($data->tanggal_disposisi)) }}</small>
                                    </td>
                                    <td>
                                        <span class="fw-bold">{{ $data->permohonan->registrasi->kode ?? '-' }}</span><br>
                                        <small class="text-muted">{{ $data->permohonan->layanan->nama ?? '-' }}</small>
                                    </td>
                                    <td class="text-wrap fw-semibold">
                                        {{ $data->permohonan->registrasi->nama ?? '-' }}
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            {{ $data->pemberi->name ?? '-' }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                           {{ $data->penerima->name ?? '-' }}
                                           <small class="fw-bold text-primary">{{ $data->tahapan->nama ?? '-' }}</small>
                                        </div>
                                    </td>                                                                       
                                    <td>
                                        @if($data->is_revisi)
                                            <span class="badge bg-label-danger">Revisi</span>
                                        @else
                                            <span class="badge bg-label-info">Normal</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <button wire:click="openHistory({{ $data->permohonan_id }})" 
                                                class="btn btn-icon btn-outline-info btn-sm">
                                            <i class="bx bx-history"></i>
                                        </button>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <a href="{{ route(Str::lower($data->layanan_type_name) . '.detail', ['id' => $data->layanan_id]) }}"
                                            target="_blank" class="btn btn-primary btn-sm">
                                                <i class="bx bx-link-external"></i>
                                            </a>
                                            
                                            <button wire:click="$dispatch('disposisi-edit', { id: {{ $data->id }} })"
                                                    class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#editDisposisiModal">
                                                <i class="bx bx-edit"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="row mx-3 my-3">
                    <div class="col d-flex justify-content-end align-items-center">
                        {{ $disposisi->links() }}
                    </div>
                </div>
            </div>
        @else
            <!-- Non-Superadmin: Active Disposisi -->
            <div class="card">
                <h5 class="card-header">List Disposisi Masuk (Aktif)</h5>
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Kode/Layanan</th>
                                <th>Pemohon</th>
                                <th>Tahapan</th>
                                <th>Pemberi</th>
                                <th>Catatan</th>
                                <th>Status</th>
                                <th class="text-center">Selesai</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($disposisi as $data)
                                <tr wire:key="active-{{ $data->id }}">
                                    <td>{{ ($disposisi->currentPage() - 1) * $disposisi->perPage() + $loop->iteration }}</td>
                                    <td>
                                        {{ date('d-m-Y', strtotime($data->tanggal_disposisi)) }} <br>
                                        <small class="text-muted fst-italic">
                                            {{ date('H:i:s', strtotime($data->tanggal_disposisi)) }}
                                        </small>
                                    </td>
                                    <td>
                                        <span class="fw-bold">{{ $data->permohonan->registrasi->kode ?? '-' }}</span><br>
                                        <small class="text-muted fst-italic ">{{ $data->permohonan->layanan->nama ?? '-' }}</small>
                                    </td>
                                    <td class="text-wrap">{{ $data->permohonan->registrasi->nama ?? '-' }}</td>
                                    <td>
                                        {{ $data->tahapan->nama ?? '-' }} <br>
                                        <small class="text-muted fw-bold fst-italic">
                                            <span class="{{ $data->is_revisi ? 'text-danger' : 'text-primary' }}">
                                                {{ $data->is_revisi ? 'Revisi' : 'Normal' }}
                                            </span>
                                        </small>
                                    </td>
                                    <td>{{ $data->pemberi->name ?? '-' }}</td>
                                    <td>
                                        <button type="button" class="btn btn-outline-primary btn-sm"
                                            data-bs-toggle="modal" data-bs-target="#catatanModal{{ $data->id }}">
                                            Lihat
                                        </button>
                                    </td>
                                    <td>{{ $data->status }}</td>
                                    <td class="text-center">
                                        <span class="badge badge-center bg-label-danger me-1">
                                            <i class="bx bx-block"></i>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            @if (Auth::user()->role == 'supervisor')
                                                <button wire:click="$dispatch('disposisi-edit', { id: {{ $data->id }} })"
                                                        class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                        data-bs-target="#editDisposisiModal">
                                                    <i class="bx bx-edit"></i>
                                                </button>
                                            @endif

                                            <a href="{{ route(Str::lower($data->layanan_type_name) . '.detail', ['id' => $data->layanan_id]) }}"
                                                target="_blank" class="btn btn-primary btn-sm">
                                                <i class="bx bx-link-external"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Catatan Modal -->
                                <div class="modal fade" id="catatanModal{{ $data->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Catatan</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">{{ $data->catatan ?? '-' }}</div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="row mx-3 my-3">
                    <div class="col d-flex justify-content-end align-items-center">
                        {{ $disposisi->links() }}
                    </div>
                </div>
            </div>

            <!-- Non-Superadmin: Selesai Disposisi -->
            <div class="card mt-5">
                <h5 class="card-header">List Disposisi Selesai</h5>
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Kode/Layanan</th>
                                <th>Pemohon</th>
                                <th>Tahapan</th>
                                <th>Pemberi</th>
                                <th>Catatan</th>
                                <th>Status</th>
                                <th class="text-center">Selesai</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($disposisi_selesai as $data)
                                <tr wire:key="done-{{ $data->id }}">
                                    <td>{{ ($disposisi_selesai->currentPage() - 1) * $disposisi_selesai->perPage() + $loop->iteration }}</td>
                                    <td>
                                        {{ date('d-m-Y', strtotime($data->tanggal_disposisi)) }} <br>
                                        <small class="text-muted fst-italic">
                                            {{ date('H:i:s', strtotime($data->tanggal_disposisi)) }}
                                        </small>
                                    </td>
                                    <td>
                                        <span class="fw-bold">{{ $data->permohonan->registrasi->kode ?? '-' }}</span><br>
                                        <small class="text-muted fst-italic ">{{ $data->permohonan->layanan->nama ?? '-' }}</small>
                                    </td>
                                    <td class="text-wrap">{{ $data->permohonan->registrasi->nama ?? '-' }}</td>
                                    <td>
                                        {{ $data->tahapan->nama ?? '-' }} <br>
                                        <small class="text-muted fw-bold fst-italic">
                                            <span class="{{ $data->is_revisi ? 'text-danger' : 'text-primary' }}">
                                                {{ $data->is_revisi ? 'Revisi' : 'Normal' }}
                                            </span>
                                        </small>
                                    </td>
                                    <td>{{ $data->pemberi->name ?? '-' }}</td>
                                    <td>
                                        <button type="button" class="btn btn-outline-primary btn-sm"
                                            data-bs-toggle="modal" data-bs-target="#catatanSelesaiModal{{ $data->id }}">
                                            Lihat
                                        </button>
                                    </td>
                                    <td>{{ $data->status }}</td>
                                    <td class="text-center">
                                        <span class="badge badge-center bg-label-success me-1">
                                            <i class="bx bx-check"></i>
                                        </span>
                                    </td>
                                </tr>

                                <!-- Catatan Selesai Modal -->
                                <div class="modal fade" id="catatanSelesaiModal{{ $data->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Catatan</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">{{ $data->catatan ?? '-' }}</div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="row mx-3 my-3">
                    <div class="col d-flex justify-content-end align-items-center">
                        {{ $disposisi_selesai->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>
    @teleport('body')
        <!-- Edit  Regustrasi Modal -->
        @livewire('admin.disposisi.disposisi-edit')
    @endteleport

    <div wire:ignore.self class="modal fade" id="historyModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-scrollable" role="document">
            <div class="modal-content shadow-lg">
                <div class="modal-header border-bottom">
                    <h5 class="modal-title fw-bold">
                        <i class="bx bx-map-pin me-2"></i>Tracking Riwayat Disposisi
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="timeline mt-3">
                        @forelse($riwayatSelected as $history)
                            <li class="timeline-item mb-4 {{ $history->is_revisi ? 'border-left-danger' : '' }}">
                                <div class="timeline-event">
                                    <div class="timeline-header mb-2">
                                        <h6 class="mb-0 fw-bold">
                                            {{ $history->tahapan->nama }}
                                            @if($history->is_revisi)
                                                <span class="badge bg-label-danger ms-2">Revisi</span>
                                            @else
                                                <span class="badge bg-label-info ms-2">Normal</span>
                                            @endif
                                        </h6>
                                        <small class="text-muted">
                                            <i class="bx bx-time-five me-1"></i>{{ date('d F Y H:i', strtotime($history->tanggal_disposisi)) }}
                                        </small>
                                    </div>
                                    
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="avatar-group d-flex align-items-center">
                                            <span class="text-dark fw-semibold">{{ $history->pemberi->name }}</span>
                                            <i class="bx bx-right-arrow-alt mx-2 text-muted"></i>
                                            <span class="text-dark fw-semibold">{{ $history->penerima->name }}</span>
                                        </div>                                        
                                    </div>

                                    <div class="mb-2">
                                        Status: {{ $history->is_done }}
                                        @if($history->status == 'pending')
                                            <small class="text-danger text-capitalize">{{ $history->status }} <i class="bx bx-loader-alt bx-spin ms-1"></i></small>
                                        @elseif(in_array($history->status, ['completed', 'revised']) || $history->is_done)
                                            <small class="text-success text-capitalize">
                                                {{ in_array($history->status, ['completed', 'revised']) ? $history->status : 'Completed' }}
                                                <i class="bx bx-check-circle ms-1"></i>
                                            </small>
                                        @endif
                                    </div>

                                    <div class="catatan-box">
                                        <small class="text-uppercase text-muted d-block mb-1" style="font-size: 10px; letter-spacing: 1px;">Catatan Disposisi:</small>
                                        <p class="mb-0 text-secondary" style="font-size: 13px;">
                                            {{ $history->catatan ?? 'Tidak ada catatan khusus.' }}
                                        </p>
                                    </div>
                                </div>
                            </li>
                        @empty
                            <div class="text-center py-5">
                                <i class="bx bx-loader-alt bx-spin fs-1 text-muted mb-3"></i>
                                <p class="text-muted">Mengambil data riwayat...</p>
                            </div>
                        @endforelse
                    </ul>
                </div>
                <div class="modal-footer border-top">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</div>
@script
<script>
    $wire.on('toast', (event) => {
        const { type = 'success', message = 'Berhasil!' } = event[0] || event;

        const toastEl = document.createElement('div');
        toastEl.className = `bs-toast toast align-items-center text-white bg-${type === 'error' ? 'danger' : 'success'} fade show position-fixed top-0 end-0 m-3`;
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
        const toast = new bootstrap.Toast(toastEl, { delay: 4000 });
        toast.show();
        toastEl.addEventListener('hidden.bs.toast', () => toastEl.remove());
    });

    $wire.on('show-history-modal', () => {
        const modalEl = document.getElementById('historyModal');
        if (modalEl) {
            const myModal = new bootstrap.Modal(modalEl);
            myModal.show();
        }
    });
</script>
@endscript