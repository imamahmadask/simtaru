<div>
    <div wire:ignore.self class="modal fade" id="editLayananModal" data-bs-backdrop="static" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Edit Layanan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form wire:submit="editLayanan">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col mb-3">
                                <label for="edit-nama" class="form-label">Nama Layanan</label>
                                <input type="text" id="edit-nama" wire:model="nama" name="nama"
                                    class="form-control" placeholder="Masukkan Nama Layanan" />
                                @error('nama')
                                    <span class="form-text text-xs text-danger"> {{ $message }} </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="edit-kode" class="form-label">Kode Layanan</label>
                                <input type="text" id="edit-kode" wire:model="kode" name="kode"
                                    class="form-control" placeholder="Masukkan Kode Layanan" />
                                @error('kode')
                                    <span class="form-text text-xs text-danger"> {{ $message }} </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="edit-keterangan" class="form-label">Keterangan</label>
                                <input type="text" id="edit-keterangan" wire:model="keterangan" name="keterangan"
                                    class="form-control" placeholder="Masukkan keterangan jika ada" />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" class="btn btn-primary">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
