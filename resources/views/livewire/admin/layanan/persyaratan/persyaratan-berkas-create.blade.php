<div>
    <div wire:ignore.self class="modal fade" id="addPersyaratanModal" data-bs-backdrop="static" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Add Persyaratan Berkas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form wire:submit="createPersyaratanBerkas">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col mb-3">
                                <label for="nama_berkas" class="form-label">Nama Berkas</label>
                                <input type="text" wire:model="nama_berkas" name="nama_berkas" id="nama_berkas"
                                    class="form-control" placeholder="Masukkan Nama Berkas" />
                                @error('nama_berkas')
                                    <span class="form-text text-xs text-danger"> {{ $message }} </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="kode" class="form-label">Kode Berkas</label>
                                <input type="text" wire:model="kode" name="kode" id="kode"
                                    class="form-control" placeholder="Masukkan Nama Berkas" />
                                @error('kode')
                                    <span class="form-text text-xs text-danger"> {{ $message }} </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="deskripsi" class="form-label">deskripsi</label>
                                <textarea class="form-control" wire:model="deskripsi" name="deskripsi" id="deskripsi" rows="4"
                                    placeholder="Masukkan Deskripsi"></textarea>
                                @error('deskripsi')
                                    <span class="form-text text-xs text-danger"> {{ $message }} </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="urutan" class="form-label">Urutan</label>
                                <select class="form-select" wire:model="urutan" name="urutan" id="urutan">
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
                        <div class="row">
                            <div class="col mb-3">
                                <label for="wajib" class="form-label">wajib Permohonan</label>
                                <select class="form-select" wire:model="wajib" name="wajib"
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
                            Create
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
