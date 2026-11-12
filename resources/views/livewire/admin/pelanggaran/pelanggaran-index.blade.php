@push('styles')
    <style>
        /* Mengunci card tabel agar proporsional dengan tinggi monitor tanpa memicu scroll window */
        .pelanggaran-table-card {
            height: calc(100vh - 175px);
            min-height: 480px;
            display: flex;
            flex-direction: column;
            border-radius: 0.5rem;
            background: #fff;
            overflow: hidden;
        }

        .pelanggaran-table-card .card-header-section {
            flex-shrink: 0;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #d9dee3;
        }

        /* Container tabel scrollable mandiri (vertikal & horizontal) */
        .pelanggaran-table-card .table-scroll-container {
            flex: 1 1 0%;
            min-height: 0;
            overflow-x: auto;
            overflow-y: auto;
            position: relative;
        }

        /* Header tabel sticky tetap terlihat saat scroll ke bawah */
        .pelanggaran-table-card .table-scroll-container thead th {
            position: sticky;
            top: 0;
            z-index: 10;
            background-color: #f5f5f9;
            box-shadow: inset 0 -2px 0 #d9dee3, inset 0 1px 0 #d9dee3;
            white-space: nowrap;
            font-weight: 600;
            font-size: 0.8125rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding-top: 0.85rem;
            padding-bottom: 0.85rem;
        }

        /* Footer pagination sticky di bagian bawah card */
        .pelanggaran-table-card .card-footer-section {
            flex-shrink: 0;
            padding: 0.65rem 1.5rem;
            border-top: 1px solid #d9dee3;
            background-color: #fff;
        }

        .pelanggaran-table-card .card-footer-section .pagination {
            margin-bottom: 0;
        }

        /* Custom scrollbar yang jelas, modern, dan mudah digeser */
        .pelanggaran-table-card .table-scroll-container::-webkit-scrollbar {
            width: 8px;
            height: 10px;
        }

        .pelanggaran-table-card .table-scroll-container::-webkit-scrollbar-track {
            background: #f1f2f4;
            border-radius: 4px;
        }

        .pelanggaran-table-card .table-scroll-container::-webkit-scrollbar-thumb {
            background: #b8bdc5;
            border-radius: 4px;
        }

        .pelanggaran-table-card .table-scroll-container::-webkit-scrollbar-thumb:hover {
            background: #8e95a0;
        }

        /* Kolom Aksi sticky di sebelah kanan agar selalu dapat diakses saat scroll horizontal */
        @media (min-width: 992px) {

            .pelanggaran-table-card .table-scroll-container thead th.col-actions,
            .pelanggaran-table-card .table-scroll-container tbody td.col-actions {
                position: sticky;
                right: 0;
                background-color: #fff;
                box-shadow: -3px 0 6px rgba(0, 0, 0, 0.05);
                z-index: 5;
            }

            .pelanggaran-table-card .table-scroll-container thead th.col-actions {
                background-color: #f5f5f9;
                z-index: 15;
            }

            .pelanggaran-table-card .table-scroll-container tbody tr:hover td.col-actions {
                background-color: #f8f9fa;
            }
        }
    </style>
@endpush

<div>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-1 mb-3"><span class="text-muted fw-light">Pelanggaran /</span> Daftar Kasus Pelanggaran</h4>

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

        <!-- Card Tabel Pelanggaran Berukuran Proporsional Layar -->
        <div class="card pelanggaran-table-card shadow-sm">
            <!-- Header Card & Search Toolbar -->
            <div class="card-header-section">
                <!-- Baris 1: Judul, Status Filter, Tambah Kasus, Per Page, & Search -->
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <h5 class="mb-0 fw-semibold text-primary">
                            <i class="bx bx-list-ul me-1"></i> List Data Kasus Pelanggaran
                        </h5>
                        @if ($this->activeFilterCount > 0)
                            <span class="badge bg-label-primary px-2 py-1">
                                <i class="bx bx-filter-alt me-1"></i>{{ $this->activeFilterCount }} Filter Aktif
                            </span>
                            <button type="button" class="btn btn-outline-secondary btn-sm py-0 px-2"
                                wire:click="resetFilters" title="Reset Semua Filter">
                                <i class="bx bx-reset me-1"></i>Reset
                            </button>
                        @endif
                    </div>

                    <div class="d-flex flex-wrap align-items-center gap-2">
                        <a href="{{ route('pelanggaran.create') }}" class="btn btn-primary btn-sm">
                            <i class="bx bx-plus me-1"></i> Tambah Kasus
                        </a>
                        <div class="d-flex align-items-center gap-1">
                            <small class="text-muted text-nowrap d-none d-sm-inline">Tampil:</small>
                            <select class="form-select form-select-sm" wire:model.live="perPage" style="width: 75px;" title="Jumlah data per halaman">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                        <div style="min-width: 230px;">
                            <div class="input-group input-group-merge input-group-sm">
                                <span class="input-group-text"><i class="bx bx-search"></i></span>
                                <input class="form-control form-control-sm" type="text"
                                    wire:model.live.debounce.300ms="search" placeholder="Cari nomor, nama, lokasi..."
                                    aria-label="Search">
                                @if ($search)
                                    <span class="input-group-text cursor-pointer text-muted" role="button"
                                        wire:click="$set('search', '')" title="Hapus teks pencarian">
                                        <i class="bx bx-x fs-5"></i>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Baris 2: Grid Filter Toolbar Kompak -->
                <div class="pt-2 mt-2 border-top">
                    <div class="row g-2 align-items-end">
                        <!-- Filter Tahun -->
                        <div class="col-6 col-md-3 col-xl-auto" style="min-width: 125px;">
                            <label class="form-label mb-1 text-muted" style="font-size: 0.75rem;">Tahun Laporan</label>
                            <select class="form-select form-select-sm" wire:model.live="filterYear">
                                <option value="">Semua Tahun</option>
                                @foreach ($years as $year)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Filter Status -->
                        <div class="col-6 col-md-3 col-xl-auto" style="min-width: 140px;">
                            <label class="form-label mb-1 text-muted" style="font-size: 0.75rem;">Status Kasus</label>
                            <select class="form-select form-select-sm" wire:model.live="filterStatus">
                                <option value="">Semua Status</option>
                                <option value="On Progress">On Progress</option>
                                <option value="Pelimpahan Berkas">Pelimpahan Berkas</option>
                                <option value="Selesai">Selesai</option>
                            </select>
                        </div>

                        <!-- Filter Temuan -->
                        <div class="col-6 col-md-3 col-xl-auto" style="min-width: 155px;">
                            <label class="form-label mb-1 text-muted" style="font-size: 0.75rem;">Temuan Pelanggaran</label>
                            <select class="form-select form-select-sm" wire:model.live="filterTemuan">
                                <option value="">Semua Temuan</option>
                                <option value="Ada Pelanggaran">Ada Pelanggaran</option>
                                <option value="Tidak Ada Pelanggaran">Tidak Ada Pelanggaran</option>
                            </select>
                        </div>

                        <!-- Filter Kecamatan -->
                        <div class="col-6 col-md-3 col-xl-auto" style="min-width: 145px;">
                            <label class="form-label mb-1 text-muted" style="font-size: 0.75rem;">Kecamatan</label>
                            <select class="form-select form-select-sm" wire:model.live="filterKecamatan">
                                <option value="">Semua Kecamatan</option>
                                @foreach ($kecamatans as $kec)
                                    <option value="{{ $kec }}">{{ $kec }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Filter Klasifikasi -->
                        <div class="col-6 col-md-3 col-xl-auto" style="min-width: 160px;">
                            <label class="form-label mb-1 text-muted" style="font-size: 0.75rem;">Klasifikasi Sanksi</label>
                            <select class="form-select form-select-sm" wire:model.live="filterKlasifikasi">
                                <option value="">Semua Klasifikasi</option>
                                <option value="Pelanggaran Rendah">Pelanggaran Rendah</option>
                                <option value="Pelanggaran Sedang">Pelanggaran Sedang</option>
                                <option value="Pelanggaran Tinggi">Pelanggaran Tinggi</option>
                                <option value="belum_dianalisis">Belum Dianalisis</option>
                            </select>
                        </div>

                        <!-- Filter Sumber Informasi -->
                        <div class="col-6 col-md-3 col-xl-auto" style="min-width: 175px;">
                            <label class="form-label mb-1 text-muted" style="font-size: 0.75rem;">Sumber Informasi</label>
                            <select class="form-select form-select-sm" wire:model.live="filterSumber">
                                <option value="">Semua Sumber</option>
                                @foreach ($sumberInformasis as $sumber)
                                    <option value="{{ $sumber }}">{{ $sumber }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Filter Tindak Lanjut -->
                        <div class="col-6 col-md-3 col-xl-auto" style="min-width: 160px;">
                            <label class="form-label mb-1 text-muted" style="font-size: 0.75rem;">Tindak Lanjut</label>
                            <select class="form-select form-select-sm" wire:model.live="filterTindakLanjut">
                                <option value="">Semua Tindak Lanjut</option>
                                @foreach ($tindakLanjuts as $tindak)
                                    <option value="{{ $tindak }}">{{ $tindak }}</option>
                                @endforeach
                            </select>
                        </div>

                        @if ($this->activeFilterCount > 0)
                            <div class="col-12 col-md-auto ms-auto align-self-end">
                                <button type="button" class="btn btn-outline-danger btn-sm w-100" wire:click="resetFilters" title="Hapus seluruh filter yang diterapkan">
                                    <i class="bx bx-filter-alt me-1"></i> Reset Filter
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Scrollable Table Container -->
            <div class="table-scroll-container">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th>No Kasus</th>
                            <th>Sumber Informasi</th>
                            <th class="text-wrap" style="min-width: 180px;">Nama Pemilik/Perusahaan</th>
                            <th class="text-wrap" style="min-width: 220px;">Alamat Lokasi</th>
                            <th class="text-wrap" style="min-width: 200px;">Jenis Indikasi Pelanggaran</th>
                            <th class="text-nowrap">Temuan Pelanggaran</th>
                            <th class="text-nowrap">Tindak Lanjut</th>
                            <th class="text-nowrap">Status</th>
                            <th class="text-center col-actions" style="min-width: 160px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @php
                            $no = ($pelanggarans->currentPage() - 1) * $pelanggarans->perPage() + 1;
                        @endphp
                        @forelse ($pelanggarans as $data)
                            <tr wire:key="pelanggaran-{{ $data->id }}">
                                <td>
                                    {{ $no++ }}
                                </td>
                                <td class="text-nowrap">
                                    <span class="fw-bold text-dark">
                                        {{ $data->no_pelanggaran }}
                                    </span> <br>
                                    <small class="text-muted fst-italic">
                                        {{ $data->tgl_laporan ? date('d-m-Y', strtotime($data->tgl_laporan)) : '-' }}
                                    </small>
                                </td>
                                <td class="text-wrap" style="max-width: 200px;">
                                    {{ $data->sumber_informasi_pelanggaran }}
                                </td>
                                <td class="text-wrap fw-semibold" style="max-width: 200px;">
                                    {{ $data->nama_pelanggar }}
                                    @if ($data->nama_pemilik_perusahaan)
                                        <br><small class="text-muted fw-normal">({{ $data->nama_pemilik_perusahaan }})</small>
                                    @endif
                                </td>
                                <td class="text-nowrap">
                                    {{ $data->alamat_pelanggaran }} <br>
                                    <small class="text-muted fst-italic">
                                        Kel. {{ $data->kel_pelanggaran }} - Kec. {{ $data->kec_pelanggaran }}
                                    </small>
                                </td>
                                <td class="text-wrap" style="max-width: 220px;">
                                    {{ $data->jenis_indikasi_pelanggaran }}
                                </td>
                                <td class="text-nowrap">
                                    @if ($data->temuan_pelanggaran == 'Ada Pelanggaran')
                                        <span class="badge bg-label-danger">{{ $data->temuan_pelanggaran }}</span>
                                    @elseif ($data->temuan_pelanggaran == 'Tidak Ada Pelanggaran')
                                        <span class="badge bg-label-success">{{ $data->temuan_pelanggaran }}</span>
                                    @else
                                        <span class="text-muted">{{ $data->temuan_pelanggaran ?: '-' }}</span>
                                    @endif
                                </td>
                                <td class="text-nowrap">
                                    {{ $data->tindak_lanjut ?: '-' }}
                                </td>
                                <td class="text-nowrap">
                                    <span
                                        class="badge bg-{{ $data->status == 'Selesai' ? 'success' : ($data->status == 'Pelimpahan Berkas' ? 'primary' : 'warning') }}">
                                        {{ $data->status }}
                                    </span>
                                </td>
                                <td class="text-nowrap text-center col-actions">
                                    <div class="d-inline-flex gap-1 justify-content-center">
                                        <a href="{{ route('pelanggaran.edit', $data->id) }}"
                                            class="btn btn-outline-primary btn-sm p-1 px-2" title="Edit Kasus">
                                            <i class="bx bx-edit"></i>
                                        </a>
                                        <a href="{{ route('pelanggaran.detail', $data->id) }}"
                                            class="btn btn-outline-info btn-sm p-1 px-2" title="Detail Kasus">
                                            <i class="bx bx-show"></i>
                                        </a>
                                        @if (Auth::user()?->role == 'superadmin' || Auth::user()?->role == 'admin-pelanggaran')
                                            <button type="button" class="btn btn-outline-danger btn-sm p-1 px-2"
                                                wire:click="deletePelanggaran({{ $data->id }})"
                                                wire:confirm="Yakin ingin menghapus data pelanggaran ini?"
                                                title="Hapus Kasus">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        @endif
                                        <button type="button"
                                            class="btn btn-outline-secondary btn-sm p-1 px-2 position-relative"
                                            wire:click="openSaranModal({{ $data->id }})" title="Lihat Masukan">
                                            <i class="bx bx-chat"></i>
                                            @if ($data->sarans_count > 0)
                                                <span
                                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                                                    style="font-size: 0.65rem;">
                                                    {{ $data->sarans_count }}
                                                </span>
                                            @endif
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center py-4 text-muted">
                                    <i class="bx bx-folder-open fs-1 d-block mb-2 text-secondary"></i>
                                    <span>Tidak ada data kasus pelanggaran ditemukan{{ $this->activeFilterCount > 0 ? ' yang sesuai dengan filter yang dipilih.' : '.' }}</span>
                                    @if ($this->activeFilterCount > 0)
                                        <div class="mt-2">
                                            <button type="button" class="btn btn-outline-primary btn-sm" wire:click="resetFilters">
                                                <i class="bx bx-reset me-1"></i> Reset Semua Filter
                                            </button>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Footer Pagination -->
            <div class="card-footer-section">
                {{ $pelanggarans->links() }}
            </div>
        </div>
    </div>

    <!-- Modal Masukan Pelanggaran -->
    <div wire:ignore.self class="modal fade" id="modalSaranAdmin" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Masukan Pelanggaran:
                        <span
                            class="text-primary">{{ $selectedPelanggaran ? $selectedPelanggaran->no_pelanggaran : '' }}</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        wire:click="closeSaranModal"></button>
                </div>
                <div class="modal-body">
                    @if ($selectedPelanggaran && $selectedPelanggaran->sarans->count() > 0)
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
                                    @foreach ($selectedPelanggaran->sarans as $saran)
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
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                        wire:click="closeSaranModal">Tutup</button>
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
