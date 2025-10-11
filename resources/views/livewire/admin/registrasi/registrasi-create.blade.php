<div>
    <div wire:ignore.self class="modal fade" id="AddRegistrasiModal" data-bs-backdrop="static" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Tambah Data Registrasi
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form wire:submit="createRegistrasi">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col mb-3">
                                <label for="layanan_id" class="form-label">Jenis Layanan</label>
                                <select class="form-select" wire:model="layanan_id" id="layanan_id" name="layanan_id"
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
                        <div class="row">
                            <div class="col mb-3">
                                <label for="tanggal" class="form-label">Tanggal Permohonan</label>
                                <input type="date" wire:model="tanggal" name="tanggal" id="tanggal"
                                    class="form-control" placeholder="" />
                                @error('tanggal')
                                    <span class="form-text text-xs text-danger"> {{ $message }} </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" wire:model="nama" name="nama" id="nama"
                                    class="form-control" placeholder="Masukkan Nama Pemohon" />
                                @error('nama')
                                    <span class="form-text text-xs text-danger"> {{ $message }} </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="nik" class="form-label">NIK</label>
                                <input type="text" wire:model="nik" name="nik" id="nik"
                                    class="form-control" placeholder="Masukkan NIK Pemohon" />
                                @error('nik')
                                    <span class="form-text text-xs text-danger"> {{ $message }} </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="no_hp" class="form-label">Nomor HP</label>
                                <input type="text" wire:model="no_hp" name="no_hp" id="no_hp"
                                    class="form-control" placeholder="Masukkan nomor HP aktif pemohon" />
                                @error('no_hp')
                                    <span class="form-text text-xs text-danger"> {{ $message }} </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" wire:model="email" name="email" id="email"
                                    class="form-control" placeholder="Masukkan Email pemohon" />
                                @error('email')
                                    <span class="form-text text-xs text-danger"> {{ $message }} </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col mb-3">
                                <label for="fungsi_bangunan" class="form-label">Fungsi Bangunan</label>
                                <input type="text" wire:model="fungsi_bangunan" name="fungsi_bangunan"
                                    id="fungsi_bangunan" class="form-control" placeholder="Masukkan Fungsi Bangunan" />
                                @error('fungsi_bangunan')
                                    <span class="form-text text-xs text-danger"> {{ $message }} </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="alamat_tanah" class="form-label">Alamat Tanah</label>
                                <textarea name="alamat_tanah" wire:model="alamat_tanah" id="alamat_tanah" class="form-control"></textarea>
                                @error('alamat_tanah')
                                    <span class="form-text text-xs text-danger"> {{ $message }} </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label" for="kel_tanah">Kelurahan Tanah</label>
                                    <input type="text" class="form-control" wire:model="kel_tanah" id="kel_tanah"
                                        placeholder="Masukkan Kelurahan Tanah" />
                                    @error('kel_tanah')
                                        <span class="form-text text-xs text-danger"> {{ $message }} </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label" for="kec_tanah">Kecamatan Tanah</label>
                                    <select class="form-select" wire:model="kec_tanah" id="kec_tanah"
                                        aria-label="Default select example">
                                        <option value="" selected>Pilih Kecamatan</option>
                                        <option value="Ampenan">Ampenan</option>
                                        <option value="Mataram">Mataram</option>
                                        <option value="Cakranegara">Cakranegara</option>
                                        <option value="Sandubaya">Sandubaya</option>
                                        <option value="Sekarbela">Sekarbela</option>
                                        <option value="Selaparang">Selaparang</option>
                                    </select>
                                    @error('kec_tanah')
                                        <span class="form-text text-xs text-danger"> {{ $message }} </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" class="btn btn-primary">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
