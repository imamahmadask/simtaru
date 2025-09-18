<div>
    <div wire:ignore.self class="modal fade" id="editPersyaratanBerkasModal" data-bs-backdrop="static" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Edit Persyaratan Berkas
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form wire:submit="editPersyaratanBerkas">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col mb-3">
                                <label for="edit_nama_berkas" class="form-label">Nama Berkas</label>
                                <input type="text" wire:model="nama_berkas" name="nama_berkas" id="edit_nama_berkas"
                                    class="form-control" placeholder="Masukkan Nama Berkas" />
                                @error('nama_berkas')
                                    <span class="form-text text-xs text-danger"> {{ $message }} </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="edit_kode" class="form-label">Kode Berkas</label>
                                <input type="text" wire:model="kode" name="kode" id="edit_kode"
                                    class="form-control" placeholder="Masukkan Nama Berkas" />
                                @error('kode')
                                    <span class="form-text text-xs text-danger"> {{ $message }} </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="edit_deskripsi" class="form-label">deskripsi</label>
                                <textarea class="form-control" wire:model="deskripsi" name="deskripsi" id="edit_deskripsi" rows="4"
                                    placeholder="Masukkan Deskripsi"></textarea>
                                @error('deskripsi')
                                    <span class="form-text text-xs text-danger"> {{ $message }} </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="edit_urutan" class="form-label">Urutan</label>
                                <input type="text" wire:model="urutan" name="urutan" id="edit_urutan"
                                    class="form-control" placeholder="Masukkan Urutan" />
                                @error('urutan')
                                    <span class="form-text text-xs text-danger"> {{ $message }} </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="edit_wajib" class="form-label">wajib Permohonan</label>
                                <select class="form-select" wire:model="wajib" name="wajib" id="edit_wajib"
                                    aria-label="Select wajib Permohonan">
                                    <option selected>Pilih wajib Permohonan</option>
                                    <option value="1">Ya</option>
                                    <option value="0">Tidak</option>
                                </select>
                                @error('wajib')
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
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
