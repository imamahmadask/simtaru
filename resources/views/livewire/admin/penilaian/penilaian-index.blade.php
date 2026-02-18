<div>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Penilaian /</span> Daftar Penilaian</h4>
        @if (session()->has('success'))
            <div class="bs-toast toast bg-success fade show top-0 end-0 mb-2" role="alert" aria-live="assertive"
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
            <h5 class="card-header">List Data Penilaian</h5>
            <div class="row mx-3 mb-3">
                <div class="col d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <!-- Tombol kiri -->
                    <a href="{{ route('penilaian.create') }}" class="btn btn-primary">
                        Tambah Penilaian
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
                            <th>No & Tgl Dokumen</th>
                            <th>Jenis Penilaian</th>
                            <th class="text-wrap">Pelaku Usaha</th>
                            <th class="text-wrap">Nama Usaha</th>
                            <th class="text-wrap">Alamat Lokasi</th>
                            <th class="text-wrap">Koordinat</th>                            
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @php
                            $no = ($penilaians->currentPage() - 1) * $penilaians->perPage() + 1;
                        @endphp
                        @foreach ($penilaians as $data)
                            <tr wire:key="{{ $data->id }}">
                                <td>
                                    {{ $no++ }}
                                </td>
                                <td class="text-nowrap">
                                    <span class="fw-bold">
                                        {{ $data->nomor_dokumen }}
                                    </span> <br>
                                    <small class="text-muted fst-italic">
                                        {{ $data->tanggal_penilaian ? date('d-m-Y', strtotime($data->tanggal_penilaian)) : '-' }}                                            
                                    </small>
                                </td>
                                <td class="text-wrap">
                                    {{ $data->jenis_penilaian }} <br>
                                    <small class="text-muted fst-italic">
                                        {{ $data->jenis_dokumen }}
                                    </small>
                                </td>
                                <td class="text-nowrap">
                                    {{ $data->nama_pelaku_usaha }}
                                </td>                  
                                <td class="text-nowrap">
                                    {{ $data->nama_usaha }}
                                </td>                
                                <td class="text-wrap" style="max-width: 200px;">
                                    {{ $data->alamat_lokasi_usaha }}
                                </td>                                      
                                <td class="text-nowrap">
                                    {{ $data->koordinat }}                                          
                                </td>
                                <td class="text-nowrap">
                                    <div class="me-3">                                            
                                        <a href="{{ route('penilaian.edit', $data->id) }}"
                                            class="btn btn-primary btn-sm">
                                            <i class="bx bx-edit"></i>
                                        </a>
                                        <a href="{{ route('penilaian.detail', $data->id) }}"
                                            class="btn btn-primary btn-sm">
                                            <i class="bx bx-show"></i>
                                        </a>
                                        @if (Auth::user()->role == 'superadmin' || Auth::user()->role == 'admin-penilaian')
                                            <button type="button" class="btn btn-danger btn-sm"
                                                wire:click="deletePenilaian({{ $data->id }})"
                                                wire:confirm="Are you sure you want to delete this Penilaian?">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-body">
                {{ $penilaians->links() }}
            </div>
        </div>
        <!--/ Basic Bootstrap Table -->
    </div>
</div>