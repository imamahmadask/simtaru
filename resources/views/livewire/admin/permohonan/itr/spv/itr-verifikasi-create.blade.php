<div>
    <div wire:ignore.self class="modal fade" id="VerifikasiItrModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Verifikasi Berkas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <form wire:submit.prevent="addVerifikasi">
                    <div class="modal-body">
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
                                    <textarea class="form-control" wire:model="catatan" name="catatan" rows="3"></textarea>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@script
    <script>
        $wire.on('trigger-close-modal', () => {
            const modal = bootstrap.Modal.getInstance(document.getElementById('VerifikasiItrModal'));
            if (modal) {
                modal.hide();
            }
        });
    </script>
@endscript