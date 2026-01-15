<div>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Permohonan /</span> Daftar Permohonan</h4>
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
        @endif
        @if (session()->has('error'))
            <div class="bs-toast toast bg-danger fade top-0 end-0 mb-2" role="alert" aria-live="assertive"
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
        <!-- Basic Bootstrap Table -->
        <div class="card">
            <h5 class="card-header">List Data Permohonan</h5>
            <div class="row mx-3 mb-3">
                <div class="col d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <!-- Tombol kiri -->
                    <a href="{{ route('permohonan.create') }}" class="btn btn-primary">
                        Input Permohonan
                    </a>

                    <!-- Filter & Search -->
                    <div class="d-flex flex-wrap gap-2">
                        <div class="flex-fill" style="min-width: 150px;">
                            <select wire:model.live="filterPrioritas" id="filterPrioritas" class="form-control">
                                <option value="">Pilih Prioritas</option>
                                <option value="1">Ya</option>
                                <option value="0">Tidak</option>
                            </select>
                        </div>
                        <div class="flex-fill" style="min-width: 150px;">
                            <select wire:model.live="filterStatus" id="filterStatus" class="form-control">
                                <option value="">Pilih Status</option>
                                <option value="pending">Pending</option>
                                <option value="Proses Survey">Proses Survey</option>
                                <option value="Proses Analisa">Proses Analisa</option>
                                <option value="Proses Verifikasi">Proses Verifikasi</option>
                                <option value="completed">Completed</option>
                            </select>
                        </div>
                        <div class="flex-fill" style="min-width: 150px;">
                            <select wire:model.live="filterLayanan" id="filterLayanan" class="form-control">
                                <option value="">Pilih Layanan</option>
                                @foreach ($layanans as $layanan)
                                    <option value="{{ $layanan->id }}">{{ $layanan->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex-fill" style="min-width: 150px;">
                            <input class="form-control" type="search" wire:model.live="search" placeholder="Search"
                                aria-label="Search">
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th><i class="bx bx-star text-warning"></i></th>
                            <th>Layanan</th>
                            <th>Kode Registrasi</th>
                            <th>Nama Pemohon</th>
                            <th>Waktu Penyelesaian</th>
                            <th>Keterangan</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($permohonans as $data)
                            <div wire:key="{{ $data->id }}">
                                <tr>
                                    <td>
                                        {{ $no++ }}
                                    </td>
                                    <td>
                                        @if ($data->is_prioritas)
                                            <i class="bx bx-star text-warning"></i>
                                        @endif
                                    </td>
                                    <td class="text-nowrap">
                                        {{ $data->layanan->nama }}
                                    </td>
                                    <td class="text-nowrap">
                                        <strong>
                                            {{ $data->registrasi->kode }}
                                        </strong>
                                        <br>
                                        <small class="text-muted fst-italic">
                                            {{ date('d-m-Y', strtotime($data->registrasi->tanggal)) }}
                                        </small>
                                    </td>
                                    <td class="text-wrap">
                                        {{ $data->registrasi->nama }}
                                    </td>
                                    <td>
                                        @if ($data->is_done)
                                            {{ $data->waktu_pengerjaan }} Hari
                                        @endif
                                    </td>
                                    <td>
                                        {{ $data->keterangan }}
                                    </td>
                                    <td>
                                        <span
                                            class="badge bg-label-{{ $data->status == 'completed' ? 'success' : 'warning' }} me-1">
                                            {{ $data->status }}
                                        </span>
                                    </td>
                                    <td class="text-nowrap">
                                        <div class="me-3">                                            
                                            <a href="{{ route('permohonan.edit', ['id' => $data->id]) }}"
                                                type="button" class="btn btn-primary btn-sm">
                                                <i class="bx bx-edit"></i>
                                            </a>
                                            <a href="{{ route('permohonan.detail', ['id' => $data->id]) }}"
                                                type="button" class="btn btn-primary btn-sm">
                                                <i class="bx bx-show"></i>
                                            </a>
                                            @can('manageAll', $data)
                                                <button type="button" class="btn btn-info btn-sm position-relative"
                                                    wire:click="showSaran({{ $data->id }})">
                                                    <i class="bx bx-chat"></i>
                                                    @if ($data->saran_count > 0)
                                                        <span
                                                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                                            {{ $data->saran_count }}
                                                        </span>
                                                    @endif
                                                </button>
                                            @endif
                                            @can('manageDataEntry', $data)
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    wire:click="deletePermohonan({{ $data->id }})"
                                                    wire:confirm="Are you sure you want to delete this Permohonan?">
                                                    <i class="bx bx-trash"></i>
                                                </button>
                                            @endcan
                                        </div>

                                    </td>
                                </tr>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!--/ Basic Bootstrap Table -->
    </div>

    <!-- Modal Saran -->
    <div wire:ignore.self class="modal fade" id="modalSaran" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Daftar Saran / Masukan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if($selectedPermohonan)
                        <div class="mb-3">
                            <h5>
                                <strong>Kode : {{ $selectedPermohonan->registrasi->kode }}</strong>                                
                            </h5>
                            <h5>Nama Pemohon : {{ $selectedPermohonan->registrasi->nama }}</h5>
                        </div>
                        <div class="table-responsive text-nowrap">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Nama</th>
                                        <th>Pesan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($saranList as $saran)
                                        <tr>
                                            <td>{{ $saran->created_at->format('d/m/Y H:i') }}</td>
                                            <td>{{ $saran->nama ?? '-' }}</td>
                                            <td class="text-wrap">{{ $saran->pesan }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center">Tidak ada saran untuk permohonan ini.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('open-modal-saran', () => {
                var myModal = new bootstrap.Modal(document.getElementById('modalSaran'));
                myModal.show();
            });
        });
    </script>
</div>
