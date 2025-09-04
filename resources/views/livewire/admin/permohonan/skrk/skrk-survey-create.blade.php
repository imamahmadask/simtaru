<div>
    <div wire:ignore.self class="modal fade" id="AddSurveyModal" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">
                        Tambah Survey SKRK
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form wire:submit="createSurvey">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col mb-3">
                                <label for="tgl_survey" class="form-label">Tanggal Survey</label>
                                <input type="date" class="form-control" wire:model="tgl_survey" id="tgl_survey">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="koordinat" class="form-label">Koordinat</label>
                                <input type="text" class="form-control" wire:model="koordinat" id="koordinat"
                                    placeholder="Masukkan Koordinat (X, Y)">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="form_survey" class="form-label">Upload Form Survey</label>
                                <input type="file" class="form-control" wire:model="form_survey" id="form_survey">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="ba_form_survey" class="form-label">Upload Berita Acara Survey</label>
                                <input type="file" class="form-control" wire:model="ba_form_survey"
                                    id="ba_form_survey">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="foto_survey" class="form-label">Upload Foto Survey</label>
                                <input type="file" class="form-control" wire:model="foto_survey" id="foto_survey">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" class="btn btn-primary">
                            Create
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
