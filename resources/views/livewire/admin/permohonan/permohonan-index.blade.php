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
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th><i class="bx bx-star text-warning"></i></th>
                            <th>Layanan</th>
                            <th>Kode Registrasi</th>
                            <th>Nama Pemohon</th>
                            <th>Keterangan</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">

                        @foreach ($permohonans as $data)
                            <div wire:key="{{ $data->id }}">
                                <tr>
                                    <td>
                                        {{ ($permohonans->currentPage() - 1) * $permohonans->perPage() + $loop->iteration }}
                                    </td>
                                    <td>
                                        @if ($data->is_prioritas)
                                            <i class="bx bx-star text-warning"></i>
                                        @endif
                                    </td>
                                    <td class="text-wrap">
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
                                        {{ $data->keterangan }}
                                    </td>
                                    <td>
                                        @if($data->registrasi->status == 'Berkas Dicabut' || $data->registrasi->status == 'Berkas Tidak Lengkap' || $data->is_ditolak || $data->registrasi->status == 'Berkas Ditolak')
                                            <span
                                                class="badge bg-label-danger me-1">
                                                {{ $data->is_ditolak ? 'Berkas Ditolak' : $data->registrasi->status }}
                                            </span>                                        
                                        @else
                                            <span
                                                class="badge bg-label-{{ $data->status == 'completed' ? 'success' : 'warning' }} me-1">
                                                {{ $data->status }}
                                            </span>
                                        @endif
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
                                            @if($data->status != 'completed')
                                                <button type="button" class="btn btn-danger btn-sm"
                                                    wire:click="openModalTolak({{ $data->id }})" title="{{ $data->is_ditolak ? 'Detail Penolakan Berkas' : 'Tolak Berkas' }}">
                                                    <i class="bx bx-x"></i>
                                                </button>
                                            @endif
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
            <div class="row mx-3 my-3">
                <div class="col d-flex justify-content-end align-items-center">
                    {{ $permohonans->links() }}
                </div>
            </div>
        </div>
        <!--/ Basic Bootstrap Table -->
    </div>

    <!-- Modal Tolak Berkas -->
    <div wire:ignore.self class="modal fade" id="modalTolak" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Tolak Berkas Permohonan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if($isDetailTolak)
                        <div class="mb-3">
                            <label class="form-label fw-bold">Tanggal Surat Penolakan</label>
                            <p class="mb-0">{{ \Carbon\Carbon::parse($tgl_surat_penolakan)->format('d F Y') }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Alasan Ditolak</label>
                            <p class="mb-0">{{ $alasan_ditolak }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Berkas Surat Penolakan</label>
                            <br>
                            @if($permohonanDitolak && $permohonanDitolak->surat_penolakan)
                                <a href="{{ asset('storage/' . $permohonanDitolak->surat_penolakan) }}" target="_blank" class="btn btn-primary btn-sm mt-1">
                                    <i class="bx bx-download me-1"></i> Lihat Berkas
                                </a>
                            @endif
                        </div>
                    @else
                        <form wire:submit="submitTolak">
                            <div class="mb-3">
                                <label class="form-label">Alasan Ditolak</label>
                                <textarea wire:model="alasan_ditolak" class="form-control" rows="3" required></textarea>
                                @error('alasan_ditolak') <span class="text-danger error">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tanggal Surat Penolakan</label>
                                <input type="date" wire:model="tgl_surat_penolakan" class="form-control" required>
                                @error('tgl_surat_penolakan') <span class="text-danger error">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Upload Surat Penolakan</label>
                                <input type="file" wire:model="surat_penolakan" class="form-control" accept=".pdf,.png,.jpg,.jpeg" required>
                                <div wire:loading wire:target="surat_penolakan">Uploading...</div>
                                @error('surat_penolakan') <span class="text-danger error">{{ $message }}</span> @enderror
                            </div>
                        </form>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        {{ $isDetailTolak ? 'Tutup' : 'Batal' }}
                    </button>
                    @if(!$isDetailTolak)
                        <button type="button" class="btn btn-danger" wire:click="submitTolak" wire:loading.attr="disabled">
                            <span wire:loading wire:target="submitTolak" class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                            Tolak Berkas
                        </button>
                    @endif
                </div>
            </div>
        </div>
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

            var modalTolakInstance;
            Livewire.on('open-modal-tolak', () => {
                if (!modalTolakInstance) {
                    modalTolakInstance = new bootstrap.Modal(document.getElementById('modalTolak'));
                }
                modalTolakInstance.show();
            });

            Livewire.on('close-modal-tolak', () => {
                if (modalTolakInstance) {
                    modalTolakInstance.hide();
                } else {
                    var el = document.getElementById('modalTolak');
                    var inst = bootstrap.Modal.getInstance(el);
                    if(inst) inst.hide();
                }
            });
        });
    </script>
</div>
