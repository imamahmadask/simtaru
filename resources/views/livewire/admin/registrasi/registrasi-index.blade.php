<div>
    <div class="container-xxl flex-grow-1 container-p-y">
        @if (session()->has('success'))
            <div class="bs-toast toast fade show bg-primary top-0 end-0 m-2" role="alert" aria-role="alert"
                aria-live="assertive" aria-atomic="true" data-delay="2000">
                <div class="toast-header">
                    <i class="bx bx-bell me-2"></i>
                    <div class="me-auto fw-semibold">Bootstrap</div>
                    <small>11 mins ago</small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">{{ session('success') }}</div>
            </div>
        @endif

        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Registrasi /</span> Daftar Registrasi</h4>

        <!-- Basic Bootstrap Table -->
        <div class="card">
            <h5 class="card-header">List Data Registrasi</h5>
            <div class="row mx-3 mb-3">
                <div class="col d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <!-- Tombol kiri -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#AddRegistrasiModal">
                        Tambah Registrasi
                    </button>

                    <!-- Filter & Search -->
                    <div class="d-flex flex-wrap gap-2">
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
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Registrasi</th>
                            <th>Tanggal</th>
                            <th>Nama Pemohon</th>
                            <th>No Hp</th>
                            <th>Email</th>
                            <th>Jenis Layanan</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($registrasis as $data)
                            <div wire:key="{{ $data->id }}">
                                <tr>
                                    <td>
                                        {{ $no++ }}
                                    </td>
                                    <td>
                                        <span class="fw-bold">
                                            {{ $data->kode }}
                                        </span>
                                    </td>
                                    <td>
                                        {{ date('d-m-Y', strtotime($data->tanggal)) }}
                                    </td>
                                    <td>
                                        {{ $data->nama }}
                                    </td>
                                    <td>
                                        {{ $data->no_hp }}
                                    </td>
                                    <td>
                                        {{ $data->email }}
                                    </td>
                                    <td>
                                        {{ $data->layanan->nama }}
                                    </td>
                                    <td>
                                        <span class="badge bg-label-{{ $data->permohonan ? 'success' : 'danger' }}">
                                            {{ $data->permohonan ? 'Sudah Entry' : 'Belum Entry' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="me-3">
                                            <!-- Button trigger modal -->
                                            <button
                                                wire:click="$dispatch('registrasi-detail', { id: {{ $data->id }} })"
                                                type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#detailRegistrasiModal">
                                                <i class="bx bx-show"></i>
                                            </button>
                                            <button
                                                wire:click="$dispatch('registrasi-edit', { id: {{ $data->id }} })"
                                                type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editRegistrasiModal">
                                                <i class="bx bx-edit"></i>
                                            </button>
                                            @if (Auth::user()->role == 'superadmin' || Auth::user()->role == 'supervisor')
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    wire:click="deleteRegistrasi({{ $data->id }})"
                                                    wire:confirm="Are you sure you want to delete this Registrasi?">
                                                    <i class="bx bx-trash"></i>
                                                </button>
                                            @endif
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
