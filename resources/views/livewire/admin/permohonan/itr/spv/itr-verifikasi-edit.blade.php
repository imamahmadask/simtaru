<div>
    <div wire:ignore.self class="modal fade" id="EditVerifikasiItrModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Verifikasi Berkas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <form wire:submit.prevent="updateVerifikasi">
                    <div class="modal-body">
                        @if ($berkas)
                            <div class="alert alert-secondary py-2 px-3 mb-3">
                                <div class="d-flex align-items-center justify-content-between mb-1">
                                    <span class="badge {{ ($berkas->persyaratan->tahapan->nama ?? '') == 'Survey' ? 'bg-primary' : 'bg-info' }}">
                                        Tahap {{ $berkas->persyaratan->tahapan->nama ?? 'Berkas' }}
                                    </span>
                                    <small class="text-muted">{{ $berkas->versi }}</small>
                                </div>
                                <div class="fw-bold text-dark">{{ $berkas->persyaratan->nama_berkas ?? '-' }}</div>
                                <div class="text-muted small text-truncate" title="{{ $berkas->file_name }}">
                                    <i class="bx bx-file"></i> {{ $berkas->file_name }}
                                </div>
                            </div>
                        @else
                            <div class="text-center py-3">
                                <div class="spinner-border text-primary spinner-border-sm" role="status"></div>
                                <span class="ms-1 text-muted">Memuat data berkas...</span>
                            </div>
                        @endif

                        <p>Apakah Anda ingin <b>menerima</b> atau <b>menolak</b> berkas ini?</p>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="status" class="form-label">Verifikasi</label>
                                <select wire:model.live="status" name="status" id="status" class="form-select">
                                    <option value="">Pilih Verifikasi</option>
                                    <option value="diterima">Terima</option>
                                    <option value="ditolak">Tolak</option>
                                </select>
                            </div>
                        </div>
                        @if ($status == 'ditolak')
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="catatan" class="form-label">Catatan</label>
                                    <textarea class="form-control" wire:model="catatan" name="catatan" rows="3" placeholder="Masukkan alasan penolakan..."></textarea>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled" {{ !$berkas ? 'disabled' : '' }}>
                            <span wire:loading class="spinner-border spinner-border-sm me-1" role="status"></span>
                            Edit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@script
    <script>
        $wire.on('trigger-close-modal', () => {
            const modal = bootstrap.Modal.getInstance(document.getElementById('EditVerifikasiItrModal'));
            if (modal) {
                modal.hide();
            }
        });
    </script>
@endscript