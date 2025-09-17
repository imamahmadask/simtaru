<div>
    <div wire:ignore.self class="modal fade" id="AddKajianAnalisaModal" data-bs-backdrop="static" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">
                        Tambah Data Kajian Analisis SKRK
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form wire:submit="createKajianAnalisa">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col mb-3">
                                <label for="penguasaan_tanah" class="form-label">Informasi Penguasaan Tanah</label>
                                <input type="text" class="form-control" wire:model="penguasaan_tanah"
                                    id="penguasaan_tanah" placeholder="Masukkan Informasi Penguasaan Tanah">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="ada_bangunan" class="form-label">Ada Bangunan</label>
                                <select name="ada_bangunan" wire:model="ada_bangunan" id="ada_bangunan"
                                    class="form-select">
                                    <option value="" selected>Pilih Ada Bangunan</option>
                                    <option value="Ada">Ada Bangunan</option>
                                    <option value="Tidak Ada">Tidak Ada Bangunan</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="jml_bangunan" class="form-label">Jumlah Bangunan</label>
                                <input type="text" class="form-control" wire:model="jml_bangunan" id="jml_bangunan"
                                    placeholder="Masukkan Rencana Lantai Bangunan">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="jml_lantai" class="form-label">Lantai Bangunan</label>
                                <input type="text" class="form-control" wire:model="jml_lantai" id="jml_lantai"
                                    placeholder="Masukkan Rencana Lantai Bangunan">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="luas_lantai" class="form-label">Luas Lantai Bangunan</label>
                                <input type="text" class="form-control" wire:model="luas_lantai" id="luas_lantai"
                                    placeholder="Masukkan Rencana Luas Lantai Bangunan">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="kedalaman_min" class="form-label">Kedalaman/Ketinggian Minimal</label>
                                <input type="text" class="form-control" wire:model="kedalaman_min" id="kedalaman_min"
                                    placeholder="Masukkan Kedalaman/ketinggian minimal yang dimohonkan">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="kedalaman_max" class="form-label">Kedalaman/Ketinggian Maksimal</label>
                                <input type="text" class="form-control" wire:model="kedalaman_max" id="kedalaman_max"
                                    placeholder="Masukkan Kedalaman/ketinggian maksimal yang dimohonkan">
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
