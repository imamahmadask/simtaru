<div>
    <div wire:ignore.self class="modal fade" id="AddTahapanModal" data-bs-backdrop="static" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Add Persyaratan Berkas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form wire:submit="createTahapan">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col mb-3">
                                <label for="nama" class="form-label">Nama Tahapan</label>
                                <input type="text" wire:model="nama" name="nama" class="form-control"
                                    placeholder="Masukkan Nama Tahapan" />
                                @error('nama')
                                    <span class="form-text text-xs text-danger"> {{ $message }} </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="urutan" class="form-label">Urutan</label>
                                <input type="text" wire:model="urutan" name="urutan" class="form-control"
                                    placeholder="Masukkan Urutan" />
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
                            Create
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
