<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Breadcrumb & Title -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold py-1 mb-1">
                <span class="text-muted fw-light">Pengaturan /</span> Dokumen Template
            </h4>
            <p class="text-muted mb-0">Kelola dan perbarui format dokumen Word (.docx) untuk seluruh layanan SIMTARU secara dinamis.</p>
        </div>
    </div>

    <!-- Alert Success / Error -->
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
            <i class="bx bx-check-circle fs-4 me-2"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
            <i class="bx bx-error-circle fs-4 me-2"></i>
            <div>{{ session('error') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Filter & Search Card -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row g-3 align-items-center">
                <!-- Filter Modul Pills -->
                <div class="col-12 col-lg-7">
                    <label class="form-label small text-muted mb-2">Filter Layanan / Modul:</label>
                    <div class="d-flex flex-wrap gap-1">
                        @foreach ($modules as $key => $label)
                            <button type="button" 
                                wire:click="$set('selectedModul', '{{ $key }}')"
                                class="btn btn-sm {{ $selectedModul === $key ? 'btn-primary' : 'btn-outline-primary' }}">
                                {{ $label }}
                            </button>
                        @endforeach
                    </div>
                </div>

                <!-- Status Filter -->
                <div class="col-12 col-sm-6 col-lg-2">
                    <label class="form-label small text-muted mb-2">Status Template:</label>
                    <select wire:model.live="statusFilter" class="form-select form-select-sm">
                        <option value="all">Semua Status</option>
                        <option value="default">Default Sistem</option>
                        <option value="custom">Kustom (Diunggah)</option>
                    </select>
                </div>

                <!-- Search Input -->
                <div class="col-12 col-sm-6 col-lg-3">
                    <label class="form-label small text-muted mb-2">Pencarian:</label>
                    <div class="input-group input-group-sm">
                        <span class="input-group-text"><i class="bx bx-search"></i></span>
                        <input type="text" wire:model.live.debounce.300ms="search" class="form-control" placeholder="Cari nama atau kode...">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Daftar Template Dokumen ({{ count($templates) }})</h5>
            <small class="text-muted"><i class="bx bx-info-circle"></i> Klik <b>Kelola / Upload</b> untuk mengganti format dokumen</small>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th style="width: 120px;">Modul</th>
                        <th>Nama Dokumen & Kode</th>
                        <th style="width: 180px;">Status Template</th>
                        <th style="width: 150px;">Terakhir Diperbarui</th>
                        <th style="width: 180px;" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse ($templates as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                @php
                                    $modulBadges = [
                                        'skrk' => 'bg-label-primary',
                                        'itr' => 'bg-label-info',
                                        'kkprb' => 'bg-label-success',
                                        'kkprnb' => 'bg-label-warning',
                                        'pelanggaran' => 'bg-label-danger',
                                        'registrasi' => 'bg-label-secondary',
                                    ];
                                @endphp
                                <span class="badge {{ $modulBadges[$item->modul] ?? 'bg-label-secondary' }}">
                                    {{ strtoupper($item->modul) }}
                                </span>
                            </td>
                            <td>
                                <div class="fw-semibold text-dark">{{ $item->nama }}</div>
                                <code class="small text-muted">{{ $item->kode }}</code>
                                @if($item->description)
                                    <div class="text-muted small text-truncate" style="max-width: 380px;">
                                        {{ $item->description }}
                                    </div>
                                @endif
                            </td>
                            <td>
                                @if ($item->isCustom())
                                    <span class="badge bg-success">
                                        <i class="bx bx-upload me-1"></i> Kustom
                                    </span>
                                    <div class="small text-muted mt-1 text-truncate" style="max-width: 170px;" title="{{ $item->original_filename }}">
                                        {{ $item->original_filename }}
                                    </div>
                                @else
                                    <span class="badge bg-label-secondary">
                                        <i class="bx bx-shield-quarter me-1"></i> Default Bawaan
                                    </span>
                                    <div class="small text-muted mt-1 text-truncate" style="max-width: 170px;" title="{{ basename($item->default_path) }}">
                                        {{ basename($item->default_path) }}
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="small fw-semibold">{{ $item->updated_at->format('d/m/Y H:i') }}</div>
                                <div class="small text-muted">
                                    {{ $item->updatedBy ? $item->updatedBy->name : 'Sistem' }}
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <!-- Download Active File -->
                                    <button type="button" 
                                        wire:click="downloadTemplate({{ $item->id }})" 
                                        class="btn btn-outline-primary btn-sm" 
                                        title="Unduh File Template Aktif">
                                        <i class="bx bx-download"></i>
                                    </button>

                                    <!-- Upload / Edit Modal -->
                                    <button type="button" 
                                        wire:click="openEditModal({{ $item->id }})" 
                                        class="btn btn-primary btn-sm" 
                                        title="Kelola & Upload Template">
                                        <i class="bx bx-edit"></i> Kelola
                                    </button>

                                    <!-- Reset to Default Button (if custom) -->
                                    @if ($item->isCustom())
                                        <button type="button" 
                                            wire:click="resetToDefault({{ $item->id }})" 
                                            wire:confirm="Yakin ingin mereset template ini ke versi bawaan sistem? File kustom yang telah diunggah akan dihapus."
                                            class="btn btn-outline-warning btn-sm" 
                                            title="Kembalikan ke Template Bawaan Sistem">
                                            <i class="bx bx-undo"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="bx bx-folder-open text-muted fs-1 mb-2"></i>
                                <div class="text-muted">Tidak ada template dokumen yang sesuai dengan filter.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Kelola & Upload Template -->
    <div wire:ignore.self class="modal fade" id="templateModal" tabindex="-1" aria-labelledby="templateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                @if ($selectedTemplate)
                    <div class="modal-header bg-light">
                        <div>
                            <h5 class="modal-title fw-bold mb-0" id="templateModalLabel">
                                Kelola Template: {{ $selectedTemplate->nama }}
                            </h5>
                            <span class="badge bg-label-primary text-uppercase">{{ $selectedTemplate->modul }}</span>
                            <code class="small ms-2">{{ $selectedTemplate->kode }}</code>
                        </div>
                        <button type="button" wire:click="closeEditModal" class="btn-close" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <!-- Informasi Status Template -->
                        <div class="card bg-lighter shadow-none border mb-4">
                            <div class="card-body p-3">
                                <div class="row align-items-center">
                                    <div class="col-sm-8">
                                        <div class="d-flex align-items-center mb-1">
                                            <span class="fw-semibold me-2">Status Saat Ini:</span>
                                            @if ($selectedTemplate->isCustom())
                                                <span class="badge bg-success">Versi Kustom (Hasil Upload)</span>
                                            @else
                                                <span class="badge bg-label-secondary">Versi Bawaan Sistem</span>
                                            @endif
                                        </div>
                                        <div class="small text-muted">
                                            Nama File: <b>{{ $selectedTemplate->isCustom() ? $selectedTemplate->original_filename : basename($selectedTemplate->default_path) }}</b>
                                        </div>
                                        @if ($selectedTemplate->updated_at)
                                            <div class="small text-muted">
                                                Terakhir Diperbarui: {{ $selectedTemplate->updated_at->format('d F Y, H:i') }} (Oleh: {{ $selectedTemplate->updatedBy ? $selectedTemplate->updatedBy->name : 'Sistem' }})
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-sm-4 text-sm-end mt-2 mt-sm-0">
                                        <button type="button" wire:click="downloadTemplate({{ $selectedTemplate->id }})" class="btn btn-outline-primary btn-sm">
                                            <i class="bx bx-download me-1"></i> Unduh File Aktif
                                        </button>
                                        @if ($selectedTemplate->isCustom())
                                            <button type="button" 
                                                wire:click="resetToDefault({{ $selectedTemplate->id }})" 
                                                wire:confirm="Kembalikan ke template default bawaan sistem?"
                                                class="btn btn-outline-warning btn-sm mt-1">
                                                <i class="bx bx-undo me-1"></i> Reset ke Default
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Kamus Placeholder / Tag Variabel -->
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="fw-bold mb-0">
                                    <i class="bx bx-code-alt text-primary me-1"></i> Daftar Variabel Placeholder yang Didukung:
                                </label>
                                <small class="text-muted">Klik variabel untuk menyalin format <code>${...}</code></small>
                            </div>
                            <div class="border rounded p-3 bg-light" style="max-height: 180px; overflow-y: auto;">
                                @if (!empty($selectedTemplate->available_variables))
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach ($selectedTemplate->available_variables as $varKey => $varLabel)
                                            <button type="button" 
                                                onclick="navigator.clipboard.writeText('${{ $varKey }}'); alert('Tag ${{{ $varKey }}} berhasil disalin!');"
                                                class="btn btn-sm btn-outline-secondary d-flex align-items-center py-1 px-2 text-start"
                                                title="Klik untuk menyalin: ${{ $varKey }}">
                                                <code class="text-primary fw-bold me-1">${{ '{' . $varKey . '}' }}</code>
                                                <span class="small text-muted">({{ $varLabel }})</span>
                                            </button>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-muted small">Tidak ada daftar variabel khusus yang didefinisikan.</span>
                                @endif
                            </div>
                            <small class="text-muted d-block mt-1">
                                <i class="bx bx-info-circle"></i> Pastikan tag di atas tetap tertulis dengan format <code>${nama_variabel}</code> di dalam file Microsoft Word (.docx) Anda.
                            </small>
                        </div>

                        <!-- Form Upload File Baru -->
                        <div class="border-top pt-3">
                            <label class="form-label fw-bold">
                                <i class="bx bx-cloud-upload text-success me-1"></i> Unggah File Template Baru (.docx):
                            </label>
                            
                            <div class="input-group mb-2">
                                <input type="file" wire:model="file_template" class="form-control @error('file_template') is-invalid @enderror" accept=".docx">
                            </div>

                            @error('file_template')
                                <div class="text-danger small mb-2">{{ $message }}</div>
                            @enderror

                            <!-- Uploading Loading Indicator -->
                            <div wire:loading wire:target="file_template" class="text-primary small mb-2">
                                <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                                Memeriksa dan memvalidasi file template Word...
                            </div>

                            <!-- Inspection Feedback -->
                            @if (!empty($inspectionResult))
                                @if ($inspectionResult['success'])
                                    <div class="alert alert-success d-flex align-items-start p-2 small mb-3">
                                        <i class="bx bx-check-circle fs-5 me-2 mt-1"></i>
                                        <div>
                                            <b>File valid!</b> Berhasil mendeteksi <b>{{ $inspectionResult['count'] }} variabel</b> di dalam dokumen:
                                            <div class="d-flex flex-wrap gap-1 mt-1">
                                                @foreach (array_slice($inspectionResult['variables'], 0, 12) as $v)
                                                    <span class="badge bg-label-success">${{ '{' . $v . '}' }}</span>
                                                @endforeach
                                                @if ($inspectionResult['count'] > 12)
                                                    <span class="badge bg-secondary">+{{ $inspectionResult['count'] - 12 }} lainnya</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="alert alert-danger d-flex align-items-center p-2 small mb-3">
                                        <i class="bx bx-error-circle fs-5 me-2"></i>
                                        <div>{{ $inspectionResult['error'] }}</div>
                                    </div>
                                @endif
                            @endif

                            <div class="small text-muted">
                                <b>Catatan:</b> File harus berekstensi <code>.docx</code> dengan ukuran maksimal 10 MB. Sistem akan secara otomatis menguji file sebelum disimpan agar tidak terjadi error saat proses pembuatan dokumen.
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer bg-light">
                        <button type="button" wire:click="closeEditModal" class="btn btn-outline-secondary">Batal</button>
                        <button type="button" 
                            wire:click="uploadTemplate" 
                            wire:loading.attr="disabled"
                            @if(!$file_template) disabled @endif
                            class="btn btn-primary">
                            <span wire:loading wire:target="uploadTemplate" class="spinner-border spinner-border-sm me-1"></span>
                            Simpan & Terapkan Template
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('livewire:initialized', () => {
        const modalElement = document.getElementById('templateModal');
        let bsModal = null;

        if (modalElement) {
            bsModal = new bootstrap.Modal(modalElement);
        }

        Livewire.on('open-template-modal', () => {
            if (bsModal) {
                bsModal.show();
            }
        });

        Livewire.on('close-template-modal', () => {
            if (bsModal) {
                bsModal.hide();
            }
        });
    });
</script>
@endpush
