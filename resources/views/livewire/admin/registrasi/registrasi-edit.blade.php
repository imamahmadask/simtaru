<div>
    <div wire:ignore.self class="modal fade" id="editRegistrasiModal" data-bs-backdrop="static" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Edit Registrasi
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form wire:submit="editRegistrasi">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col mb-3">
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" wire:model="nama" name="nama" class="form-control"
                                    placeholder="Masukkan Nama Pemohon" />
                                @error('nama')
                                    <span class="form-text text-xs text-danger"> {{ $message }} </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="nik" class="form-label">NIK</label>
                                <input type="text" wire:model="nik" name="nik" class="form-control"
                                    placeholder="Masukkan NIK Pemohon" />
                                @error('nik')
                                    <span class="form-text text-xs text-danger"> {{ $message }} </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="no_hp" class="form-label">Nomor HP</label>
                                <input type="text" wire:model="no_hp" name="no_hp" class="form-control"
                                    placeholder="Masukkan nomor HP aktif pemohon" />
                                @error('no_hp')
                                    <span class="form-text text-xs text-danger"> {{ $message }} </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="tanggal" class="form-label">Tanggal Permohonan</label>
                                <input type="date" wire:model="tanggal" name="tanggal" class="form-control"
                                    placeholder="" />
                                @error('tanggal')
                                    <span class="form-text text-xs text-danger"> {{ $message }} </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="layanan_id" class="form-label">Jenis Layanan</label>
                                <select class="form-select" wire:model="layanan_id" name="layanan_id"
                                    aria-label="Select Jenis Layanan">
                                    <option selected>Pilih Jenis Layanan</option>
                                    @foreach ($layanans as $layanan)
                                        <option value="{{ $layanan->id }}">{{ $layanan->nama }}</option>
                                    @endforeach
                                </select>
                                @error('layanan_id')
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
