<div>
    <div wire:ignore.self class="modal fade" id="editTahapanModal" data-bs-backdrop="static" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Edit Tahapan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form wire:submit="editTahapan">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col mb-3">
                                <label for="edit-nama" class="form-label">Nama Urutan</label>
                                <input type="text" wire:model="nama" name="nama" id="edit-nama"
                                    class="form-control" placeholder="Masukkan Nama Urutan" />
                                @error('nama')
                                    <span class="form-text text-xs text-danger"> {{ $message }} </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="edit-urutan" class="form-label">Urutan</label>
                                <select class="form-select" wire:model="urutan" name="urutan" id="edit-urutan">
                                    <option selected>Pilih Urutan</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                                @error('urutan')
                                    <span class="form-text text-xs text-danger"> {{ $message }} </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" class="btn btn-primary">
                            Edit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
