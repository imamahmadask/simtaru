<div>
    <div wire:ignore.self class="modal fade" id="HoldanalisKkprnbModal" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{ $is_analis_hold ? 'Unhold Analis' : 'Hold Analis' }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form wire:submit.prevent="save">
                    <div class="modal-body">
                        @if ($is_analis_hold)
                            <div class="alert alert-warning">
                                Apakah Anda yakin ingin membatalkan status Hold pada proses Analis ini?
                            </div>
                        @else
                            <div class="mb-3">
                                <label class="form-label" for="tgl_analis_hold">Tanggal Hold</label>
                                <input type="date" wire:model="tgl_analis_hold" id="tgl_analis_hold" class="form-control @error('tgl_analis_hold') is-invalid @enderror">
                                @error('tgl_analis_hold')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="ket_analis_hold">Keterangan / Alasan Hold</label>
                                <textarea wire:model="ket_analis_hold" id="ket_analis_hold" class="form-control @error('ket_analis_hold') is-invalid @enderror" rows="5" placeholder="Masukkan alasan penangguhan proses analisa..."></textarea>
                                @error('ket_analis_hold')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Batal
                        </button>
                        <button type="submit" class="btn {{ $is_analis_hold ? 'btn-warning' : 'btn-success' }}" wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="save">
                                {{ $is_analis_hold ? 'Ya, Unhold' : 'Simpan Hold' }}
                            </span>
                            <span wire:loading wire:target="save">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                Memproses...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@script
<script>
    $wire.on('open-hold-analis-modal', () => {
        const modal = new bootstrap.Modal(document.getElementById('HoldanalisKkprnbModal'));
        modal.show();
    });

    $wire.on('trigger-close-hold-analis-modal', () => {
        const modalElement = document.getElementById('HoldanalisKkprnbModal');
        const modal = bootstrap.Modal.getInstance(modalElement);
        if (modal) {
            modal.hide();
        }
    });
</script>
@endscript
