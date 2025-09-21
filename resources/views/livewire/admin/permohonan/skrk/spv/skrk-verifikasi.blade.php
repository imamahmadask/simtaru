<div>
    <div wire:ignore.self class="modal fade" id="verifikasiModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Verifikasi Berkas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda ingin <b>menerima</b> atau <b>menolak</b> berkas ini?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" wire:click="verifikasi('ditolak')"
                        data-bs-dismiss="modal">
                        Ditolak
                    </button>
                    <button type="button" class="btn btn-success" wire:click="verifikasi('diterima')"
                        data-bs-dismiss="modal">
                        Diterima
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
