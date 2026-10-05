<div>
    <div wire:ignore.self class="modal fade" id="modalPosisiBerkas" data-bs-backdrop="static" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title text-white fw-bold">
                        <i class="bx bx-buildings me-2"></i>Keterangan Posisi Berkas (BPN / DPMPTSP)
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                @if ($permohonan)
                    <form wire:submit.prevent="saveKeterangan">
                        <div class="modal-body">
                            {{-- Info Permohonan --}}
                            <div class="card bg-light border mb-3">
                                <div class="card-body p-3">
                                    <div class="row align-items-center">
                                        <div class="col-md-7">
                                            <span class="text-muted small d-block">Nomor Registrasi:</span>
                                            <strong
                                                class="fs-6 text-primary">{{ $permohonan->registrasi->kode ?? '-' }}</strong>
                                            <span class="text-muted small d-block mt-1">Nama Pemohon:</span>
                                            <strong
                                                class="text-dark">{{ $permohonan->registrasi->nama ?? '-' }}</strong>
                                        </div>
                                        <div class="col-md-5 mt-2 mt-md-0">
                                            <span class="text-muted small d-block">Layanan:</span>
                                            <span
                                                class="badge bg-secondary mb-1">{{ $permohonan->layanan->nama ?? '-' }}</span>

                                            @if ($permohonan->posisi_berkas)
                                                <div class="mt-1">
                                                    <span class="text-muted small d-block">Status Posisi Saat
                                                        Ini:</span>
                                                    <span
                                                        class="badge bg-label-{{ $permohonan->posisi_berkas === 'BPN' ? 'warning' : 'info' }}">
                                                        {{ $permohonan->posisi_berkas }}@if ($permohonan->proses_berkas)
                                                            - {{ $permohonan->proses_berkas }}
                                                        @endif
                                                    </span>
                                                    <small class="text-muted d-block mt-1">
                                                        Per:
                                                        {{ $permohonan->tgl_posisi_berkas ? \Carbon\Carbon::parse($permohonan->tgl_posisi_berkas)->translatedFormat('d F Y') : '-' }}
                                                    </small>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-3">
                                {{-- Pilihan Instansi --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">
                                        Instansi / Lokasi Berkas <span class="text-danger">*</span>
                                    </label>
                                    <div class="d-flex gap-3 mt-1">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" wire:model.live="instansi"
                                                id="instansi_dpmptsp" value="DPMPTSP">
                                            <label class="form-check-label fw-semibold" for="instansi_dpmptsp">
                                                <i class="bx bx-building text-info me-1"></i> DPMPTSP
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" wire:model.live="instansi"
                                                id="instansi_bpn" value="BPN">
                                            <label class="form-check-label fw-semibold" for="instansi_bpn">
                                                <i class="bx bx-map-pin text-warning me-1"></i> BPN
                                            </label>
                                        </div>
                                    </div>
                                    @error('instansi')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Pilihan Proses / Tahapan --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-bold" for="proses_berkas">
                                        Tahapan / Proses <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select" wire:model.live="proses" id="proses_berkas">
                                        @foreach ($this->prosesOptions as $val => $label)
                                            <option value="{{ $val }}">{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted">
                                        @if ($instansi === 'BPN')
                                            Opsi BPN: <strong>Proses Survey</strong> & <strong>Analisa</strong>
                                        @else
                                            Opsi DPMPTSP: <strong>Input Permohonan</strong> & <strong>Cetak Berkas</strong>
                                        @endif
                                    </small>
                                    @error('proses')
                                        <span class="text-danger small d-block">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Tanggal --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-bold" for="tanggal_status">
                                        Per Tanggal <span class="text-danger">*</span>
                                    </label>
                                    <input type="date" class="form-control" wire:model.live="tanggal_status"
                                        id="tanggal_status">
                                    <small class="text-muted">Tanggal berkas berada di BPN / dpmptsp</small>
                                    @error('tanggal_status')
                                        <span class="text-danger small d-block">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Catatan / Keterangan Penjelasan --}}
                                <div class="col-md-12">
                                    <label class="form-label fw-bold" for="catatan_lokasi">
                                        Keterangan / Catatan Tambahan (Opsional)
                                    </label>
                                    <textarea class="form-control" wire:model.live="catatan" id="catatan_lokasi" rows="3"
                                        placeholder="Contoh: Menunggu proses pertanahan di BPN / Menunggu tanda tangan dokumen di dpmptsp..."></textarea>
                                    @error('catatan')
                                        <span class="text-danger small d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Live Preview Box --}}
                            <div class="alert alert-primary mt-3 mb-2 p-2">
                                <small class="fw-bold d-block text-uppercase" style="font-size: 11px;">
                                    <i class="bx bx-show me-1"></i> Preview Catatan Riwayat Berkas:
                                </small>
                                <span class="fst-italic text-dark">{{ $this->previewText }}</span>
                            </div>

                            {{-- Riwayat Posisi Berkas Sebelumnya --}}
                            @if (count($riwayatLokasi) > 0)
                                <div class="mt-4">
                                    <h6 class="fw-bold mb-2">
                                        <i class="bx bx-history me-1"></i> Riwayat Posisi BPN / DPMPTSP Sebelumnya:
                                    </h6>
                                    <div class="table-responsive" style="max-height: 200px; overflow-y: auto;">
                                        <table class="table table-sm table-bordered">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Per Tanggal</th>
                                                    <th>Instansi</th>
                                                    <th>Tahapan</th>
                                                    <th>Keterangan</th>
                                                    <th>Dicatat Oleh</th>
                                                    <th class="text-center" style="width: 50px;">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($riwayatLokasi as $row)
                                                    <tr wire:key="riwayat-lokasi-{{ $row->id }}">
                                                        <td class="text-nowrap small">
                                                            {{ $row->tanggal_status ? \Carbon\Carbon::parse($row->tanggal_status)->format('d-m-Y') : '-' }}
                                                        </td>
                                                        <td>
                                                            <span
                                                                class="badge bg-label-{{ $row->instansi === 'BPN' ? 'warning' : 'info' }}">
                                                                {{ $row->instansi }}
                                                            </span>
                                                        </td>
                                                        <td class="small">
                                                            {{ $row->proses ?: '-' }}
                                                        </td>
                                                        <td class="small">{{ $row->catatan ?: '-' }}</td>
                                                        <td class="small text-muted">{{ $row->user->name ?? '-' }}
                                                        </td>
                                                        <td class="text-center">
                                                            <button type="button"
                                                                class="btn btn-outline-danger btn-xs"
                                                                wire:click="deleteRiwayat({{ $row->id }})"
                                                                wire:confirm="Yakin ingin menghapus catatan posisi ini?"
                                                                title="Hapus Catatan">
                                                                <i class="bx bx-trash"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="modal-footer d-flex justify-content-between">
                            <div>
                                @if ($permohonan->posisi_berkas)
                                    <button type="button" class="btn btn-outline-secondary"
                                        wire:click="clearPosisiBerkas"
                                        wire:confirm="Kembalikan berkas ke proses internal SIMTARU? Posisi berkas di BPN/DPMPTSP akan dinonaktifkan.">
                                        <i class="bx bx-reset me-1"></i> Kembali ke SIMTARU
                                    </button>
                                @endif
                            </div>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                                    <span wire:loading.remove><i class="bx bx-save me-1"></i> Simpan Keterangan</span>
                                    <span wire:loading><i class="bx bx-loader-alt bx-spin me-1"></i>
                                        Menyimpan...</span>
                                </button>
                            </div>
                        </div>
                    </form>
                @else
                    <div class="modal-body text-center py-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="text-muted mt-2">Memuat data permohonan...</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@script
    <script>
        $wire.on('show-posisi-berkas-modal', () => {
            const modalEl = document.getElementById('modalPosisiBerkas');
            if (modalEl) {
                const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                modal.show();
            }
        });

        $wire.on('trigger-close-posisi-berkas-modal', () => {
            const modalEl = document.getElementById('modalPosisiBerkas');
            if (modalEl) {
                const modal = bootstrap.Modal.getInstance(modalEl);
                if (modal) {
                    modal.hide();
                }
            }
        });
    </script>
@endscript
