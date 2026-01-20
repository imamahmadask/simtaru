<div>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Pelanggaran /</span> Daftar Pelanggaran</h4>
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
            <h5 class="card-header">List Data Pelanggaran</h5>
            <div class="row mx-3 mb-3">
                <div class="col d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <!-- Tombol kiri -->
                    <a href="{{ route('pelanggaran.create') }}" class="btn btn-primary">
                        Tambah Pelanggaran
                    </a>
                    <!-- Filter & Search -->
                    <div class="d-flex flex-wrap gap-2">                        
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
                            <th>No Pelanggaran</th>
                            <th>Tanggal</th>
                            <th>Jenis Formulir</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($pelanggarans as $data)
                            <div wire:key="{{ $data->id }}">
                                <tr>
                                    <td>
                                        {{ $no++ }}
                                    </td>
                                    <td class="text-nowrap">
                                        <span class="fw-bold">
                                            {{ $data->no_pelanggaran }}
                                        </span>
                                    </td>
                                    <td class="text-nowrap">
                                        {{ date('d-m-Y', strtotime($data->tanggal_pengawasan)) }}
                                    </td>
                                    <td class="text-wrap">
                                        {{ $data->jenis_formulir }}
                                    </td>                                                                        
                                    <td class="text-nowrap">
                                        <div class="me-3">                                            
                                            <a href="{{ route('pelanggaran.edit', $data->id) }}"
                                                class="btn btn-primary btn-sm">
                                                <i class="bx bx-edit"></i>
                                            </a>
                                            <a href="{{ route('pelanggaran.detail', $data->id) }}"
                                                class="btn btn-primary btn-sm">
                                                <i class="bx bx-show"></i>
                                            </a>
                                            @if (Auth::user()->role == 'superadmin' || Auth::user()->role == 'admin-pelanggaran')
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    wire:click="deletePelanggaran({{ $data->id }})"
                                                    wire:confirm="Are you sure you want to delete this Pelanggaran?">
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
</div>