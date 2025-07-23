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
            <div class="col-4">
                <button type="button" class="ms-4 mb-3 btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#AddRegistrasiModal">
                    Create Registrasi
                </button>
            </div>
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Registrasi</th>
                            <th>Nama</th>
                            <th>No Hp</th>
                            <th>NIK</th>
                            <th>Jenis Layanan</th>
                            <th>Tanggal</th>
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
                                        {{ $data->kode }}
                                    </td>
                                    <td>
                                        {{ $data->nama }}
                                    </td>
                                    <td>
                                        {{ $data->no_hp }}
                                    </td>
                                    <td>
                                        {{ Str::mask($data->nik, '*', 5, -1) }}
                                    </td>
                                    <td>
                                        {{ $data->layanan->nama }}
                                    </td>
                                    <td>
                                        {{ date('d-m-Y', strtotime($data->tanggal)) }}
                                    </td>
                                    <td>
                                        <div class="me-3">
                                            <!-- Button trigger modal -->
                                            <button
                                                wire:click="$dispatch('registrasi-edit', { id: {{ $data->id }} })"
                                                type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editRegistrasiModal">
                                                Edit
                                            </button>
                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#basicModal">
                                                Hapus
                                            </button>
                                        </div>
                                        <!-- Modal -->
                                        @teleport('body')
                                            <!-- Edit  Regustrasi Modal -->
                                            @livewire('admin.registrasi.registrasi-edit')
                                        @endteleport
                                    </td>
                                </tr>
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
</div>
