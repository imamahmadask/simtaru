<div>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Pelanggaran /</span> Daftar Kasus Pelanggaran</h4>
        @if (session()->has('success'))
            <div class="bs-toast toast bg-success fade top-0 end-0 mb-2" role="alert" aria-live="assertive"
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
            <h5 class="card-header">List Data Kasus Pelanggaran</h5>
            <div class="row mx-3 mb-3">
                <div class="col d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <!-- Tombol kiri -->
                    <a href="{{ route('pelanggaran.create') }}" class="btn btn-primary">
                        Tambah Kasus
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
                            <th>No Kasus</th>
                            <th>Sumber Informasi</th>
                            <th class="text-wrap">Nama Pemilik/ Penanggung Jawab</th>
                            <th class="text-wrap">Alamat Lokasi</th>
                            <th class="text-wrap">Jenis Indikasi Pelanggaran</th>                            
                            <th class="text-wrap">Temuan Pelanggaran</th>
                            <th class="text-wrap">Tindak Lanjut</th>                            
                            <th class="text-wrap">Status</th>                            
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
                                        </span> <br>
                                        <small class="text-muted fst-italic">
                                            {{ date('d-m-Y', strtotime($data->tgl_laporan)) }}                                            
                                        </small>
                                    </td>
                                    <td class="text-wrap">
                                        {{ $data->sumber_informasi_pelanggaran }}
                                    </td>
                                    <td class="text-nowrap">
                                        {{ $data->nama_pelanggar }}
                                    </td>                  
                                    <td class="text-nowrap">
                                        {{ $data->alamat_pelanggaran }} <br>
                                        <small class="text-muted fst-italic">
                                            Kel. {{ $data->kel_pelanggaran }} - Kec. {{ $data->kec_pelanggaran }}
                                        </small>
                                    </td>                
                                    <td class="text-wrap">
                                        {{ $data->jenis_indikasi_pelanggaran }}                                          
                                    </td>                                      
                                    <td class="text-nowrap">
                                        {{ $data->temuan_pelanggaran }}                                          
                                    </td>
                                    <td class="text-nowrap">
                                        {{ $data->tindak_lanjut }}                                          
                                    </td>
                                    <td class="text-nowrap">
                                        @if($data->status == 'Selesai')
                                            <span class="badge bg-success">Selesai</span>
                                        @elseif($data->status == 'On Progress')
                                            <span class="badge bg-warning">On Progress</span>                                        
                                        @endif
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
                                            <button type="button" class="btn btn-info btn-sm position-relative"
                                                wire:click="openSaranModal({{ $data->id }})"
                                                title="Lihat Masukan">
                                                <i class="bx bx-chat"></i>
                                                @if ($data->sarans_count > 0)
                                                    <span
                                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                                        {{ $data->sarans_count }}
                                                    </span>
                                                @endif
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-body">
                {{ $pelanggarans->links() }}
            </div>
        </div>
        <!--/ Basic Bootstrap Table -->
    </div>

    <!-- Modal Masukan Pelanggaran -->
    <div wire:ignore.self class="modal fade" id="modalSaranAdmin" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Masukan Pelanggaran: 
                        <span class="text-primary">{{ $selectedPelanggaran ? $selectedPelanggaran->no_pelanggaran : '' }}</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="closeSaranModal"></button>
                </div>
                <div class="modal-body">
                    @if($selectedPelanggaran && $selectedPelanggaran->sarans->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Nama</th>
                                        <th>Pesan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($selectedPelanggaran->sarans as $saran)
                                        <tr>
                                            <td class="text-nowrap">{{ $saran->created_at->format('d/m/Y H:i') }}</td>
                                            <td><strong>{{ $saran->nama }}</strong></td>
                                            <td class="text-wrap">{{ $saran->pesan }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bx bx-message-square-minus display-4 text-muted"></i>
                            <p class="mt-2">Belum ada masukan untuk pelanggaran ini.</p>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" wire:click="closeSaranModal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('open-modal-saran-admin', () => {
                const modalElement = document.getElementById('modalSaranAdmin');
                if (modalElement) {
                    let modalInstance = bootstrap.Modal.getInstance(modalElement);
                    if (!modalInstance) {
                        modalInstance = new bootstrap.Modal(modalElement);
                    }
                    modalInstance.show();
                }
            });
        });
    </script>
    @endpush
</div>
```