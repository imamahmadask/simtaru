<div>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Registrasi /</span> Daftar Registrasi</h4>
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
        
        <!-- Basic Bootstrap Table -->
        <div class="card">
            <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div class="d-flex align-items-center gap-2">
                    <h5 class="mb-0">List Data Registrasi</h5>
                    @if ($viewTrash)
                        <span class="badge bg-label-danger"><i class="bx bx-trash me-1"></i> Mode Sampah (Trash)</span>
                    @endif
                </div>

                @if (Auth::user()->role == 'superadmin' || Auth::user()->role == 'supervisor')
                    <ul class="nav nav-pills card-header-pills gap-2">
                        <li class="nav-item">
                            <button type="button"
                                class="nav-link {{ !$viewTrash ? 'active btn-primary text-white' : 'bg-label-secondary text-secondary' }} btn-sm px-3"
                                wire:click="toggleTrashView(false)">
                                <i class="bx bx-list-ul me-1"></i> Data Aktif
                            </button>
                        </li>
                        <li class="nav-item">
                            <button type="button"
                                class="nav-link {{ $viewTrash ? 'active btn-primary text-white' : 'bg-label-secondary text-secondary' }} btn-sm px-3"
                                wire:click="toggleTrashView(true)">
                                <i class="bx bx-trash me-1"></i> Sampah (Trash)
                            </button>
                        </li>
                    </ul>
                @endif
            </div>

            <div class="row mx-3 mb-3">
                <div class="col d-flex flex-wrap justify-content-between align-items-center gap-3">
                    <!-- Tombol kiri -->
                    @if (!$viewTrash)
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#AddRegistrasiModal">
                            <i class="bx bx-plus me-1"></i> Tambah Registrasi
                        </button>
                    @else
                        <span class="text-muted small">
                            <i class="bx bx-info-circle me-1 text-primary"></i> Menampilkan data registrasi yang berada di Sampah.
                        </span>
                    @endif

                    <!-- Filter & Search -->
                    <div class="d-flex flex-wrap gap-2">
                        <div class="flex-fill" style="min-width: 170px;">
                            <select wire:model.live="filterLayanan" id="filterLayanan" class="form-control">
                                <option value="">Semua Layanan</option>
                                @foreach ($layanans as $layanan)
                                    <option value="{{ $layanan->id }}">{{ $layanan->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex-fill" style="min-width: 170px;">
                            <input class="form-control" type="search" wire:model.live="search" placeholder="Cari pemohon / kode..."
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
                            <th>Kode</th>
                            <th>Tanggal</th>
                            <th>Nama Pemohon</th>
                            <th>No Hp</th>
                            <th>Jenis Layanan</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">

                        @foreach ($registrasis as $data)
                            <tr wire:key="{{ $data->id }}">
                                <td>
                                    {{ ($registrasis->currentPage() - 1) * $registrasis->perPage() + $loop->iteration }}
                                </td>
                                <td class="text-nowrap">
                                    <span class="fw-bold text-primary">
                                        {{ $data->kode }}
                                    </span>
                                </td>
                                <td class="text-nowrap">
                                    {{ date('d-m-Y', strtotime($data->tanggal)) }}
                                </td>
                                <td class="text-wrap">
                                    {{ $data->nama }}
                                </td>
                                <td>
                                    {{ $data->no_hp }}
                                </td>
                                <td class="text-nowrap">
                                    {{ $data->layanan->nama }}
                                </td>
                                <td>
                                    @if ($viewTrash)
                                        <span class="badge bg-label-danger">Terhapus</span>
                                    @elseif (in_array($data->status, ['Berkas Dicabut', 'Berkas Tidak Lengkap', 'Berkas Ditolak']))
                                        <span class="badge bg-label-danger">{{ $data->status }}</span>
                                    @else
                                        <span
                                            class="badge bg-label-{{ is_null($data->permohonan) ? 'danger' : ($data->permohonan->status === 'completed' ? 'success' : 'warning') }}">
                                            {{ is_null($data->permohonan) ? 'Belum Entry' : $data->permohonan->status }}
                                        </span>
                                    @endif
                                </td>
                                <td class="text-nowrap text-center">
                                    <div class="d-inline-flex align-items-center gap-2">
                                        @if ($viewTrash)
                                            <!-- Mode Sampah: Restore & Force Delete -->
                                            @if (Auth::user()->role == 'superadmin' || Auth::user()->role == 'supervisor')
                                                <button type="button" class="btn btn-primary btn-sm px-2"
                                                    wire:click="restoreRegistrasi({{ $data->id }})"
                                                    wire:confirm="Pulihkan data registrasi '{{ $data->kode }}' dari Sampah?"
                                                    title="Pulihkan Data">
                                                    <i class="bx bx-undo me-1"></i> Pulihkan
                                                </button>
                                            @endif

                                            @if (Auth::user()->role == 'superadmin')
                                                <button type="button" class="btn btn-outline-danger btn-sm px-2"
                                                    wire:click="forceDeleteRegistrasi({{ $data->id }})"
                                                    wire:confirm="HAPUS PERMANEN registrasi '{{ $data->kode }}'? Data dan berkas fisik akan dihapus dari server secara permanen!"
                                                    title="Hapus Permanen">
                                                    <i class="bx bx-trash me-1"></i> Permanen
                                                </button>
                                            @endif
                                        @else
                                            <!-- Mode Normal: Print, Detail, Edit, Soft Delete -->
                                            <a href="{{ url('admin/registrasi/print/' . $data->id) }}"
                                                target="_blank" class="btn btn-primary btn-sm"
                                                title="Cetak Tanda Terima">
                                                <i class="bx bx-download"></i>
                                            </a>
                                            <button
                                                wire:click="$dispatch('registrasi-detail', { id: {{ $data->id }} })"
                                                type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#detailRegistrasiModal" title="Detail Registrasi">
                                                <i class="bx bx-show"></i>
                                            </button>
                                            <button
                                                wire:click="$dispatch('registrasi-edit', { id: {{ $data->id }} })"
                                                type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editRegistrasiModal" title="Edit Registrasi">
                                                <i class="bx bx-edit"></i>
                                            </button>
                                            @if (Auth::user()->role == 'superadmin' || Auth::user()->role == 'supervisor')
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    wire:click="deleteRegistrasi({{ $data->id }})"
                                                    wire:confirm="Pindahkan data registrasi '{{ $data->kode }}' ke Sampah (Trash)?"
                                                    title="Pindahkan ke Sampah">
                                                    <i class="bx bx-trash"></i>
                                                </button>
                                            @endif
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="row mx-3 my-3">
                <div class="col d-flex justify-content-end align-items-center">
                    {{ $registrasis->links() }}
                </div>
            </div>
        </div>
        <!--/ Basic Bootstrap Table -->
    </div>

    <!-- Modal -->
    @teleport('body')
        <!-- Edit  User Modal -->
        @livewire('admin.registrasi.registrasi-create')
    @endteleport
    <!-- Modal -->
    @teleport('body')
        <!-- Edit  Regustrasi Modal -->
        @livewire('admin.registrasi.registrasi-edit')
    @endteleport
    @teleport('body')
        <!-- Edit  User Modal -->
        @livewire('admin.registrasi.registrasi-detail')
    @endteleport
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
