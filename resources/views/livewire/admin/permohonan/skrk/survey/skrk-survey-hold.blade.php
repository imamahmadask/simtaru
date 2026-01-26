<div>
    <div wire:ignore.self class="modal fade" id="HoldSurveySkrkModal" tabindex="-1" aria-labelledby="HoldSurveySkrkModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="HoldSurveySkrkModalLabel">Hold Survey SKRK</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form wire:submit.prevent="saveHold">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Status Hold</label>
                            <select wire:model.live="is_survey_hold" class="form-select @error('is_survey_hold') is-invalid @enderror">
                                <option value="">Pilih Status Hold</option>
                                <option value="1">Hold</option>
                                <option value="0">Unhold</option>
                            </select>
                            @error('is_survey_hold') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        @if ($is_survey_hold)
                            <div class="mb-3">
                                <label class="form-label">Tanggal Hold</label>
                                <input type="date" wire:model="tgl_survey_hold" class="form-control @error('tgl_survey_hold') is-invalid @enderror" 
                                    id="tgl_survey_hold">
                                @error('tgl_survey_hold') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>                        
                            <div class="mb-3">
                                <label for="ket_survey_hold" class="form-label">Keterangan / Alasan Hold</label>
                                <textarea wire:model="ket_survey_hold" class="form-control @error('ket_survey_hold') is-invalid @enderror" 
                                    id="ket_survey_hold" rows="3" placeholder="Masukkan alasan hold survey..."></textarea>
                                @error('ket_survey_hold') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>                        
                        @elseif(!$is_survey_hold)
                            <div class="mb-3">
                                <label class="form-label">Tanggal Unhold</label>
                                <input type="date" wire:model="tgl_survey_unhold" class="form-control @error('tgl_survey_unhold') is-invalid @enderror" 
                                    id="tgl_survey_unhold">
                                @error('tgl_survey_unhold') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">
                            <span wire:loading wire:target="saveHold" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Simpan Perubahan
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
            const modal = bootstrap.Modal.getInstance(document.getElementById('HoldSurveySkrkModal'));
            if (modal) {
                modal.hide();
            }
        });
    </script>
@endscript  