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
                        @if ($count_permohonan == 0)
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="edit_layanan_id" class="form-label">Jenis Layanan</label>
                                    <select class="form-select" wire:model="layanan_id" name="layanan_id"
                                        id="edit_layanan_id" aria-label="Select Jenis Layanan">
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
                        @endif
                        <div class="row">
                            <div class="col mb-3">
                                <label for="edit_tanggal" class="form-label">Tanggal Permohonan</label>
                                <input type="date" wire:model="tanggal" name="tanggal" id="edit_tanggal"
                                    class="form-control" placeholder="" />
                                @error('tanggal')
                                    <span class="form-text text-xs text-danger"> {{ $message }} </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="edit_nama" class="form-label">Nama</label>
                                <input type="text" wire:model="nama" name="nama" id="edit_nama"
                                    class="form-control" placeholder="Masukkan Nama Pemohon" />
                                @error('nama')
                                    <span class="form-text text-xs text-danger"> {{ $message }} </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="edit_nik" class="form-label">NIK</label>
                                <input type="text" wire:model="nik" name="nik" id="edit_nik"
                                    class="form-control" placeholder="Masukkan NIK Pemohon" />
                                @error('nik')
                                    <span class="form-text text-xs text-danger"> {{ $message }} </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="edit_no_hp" class="form-label">Nomor HP</label>
                                <input type="text" wire:model="no_hp" name="no_hp" id="edit_no_hp"
                                    class="form-control" placeholder="Masukkan nomor HP aktif pemohon" />
                                @error('no_hp')
                                    <span class="form-text text-xs text-danger"> {{ $message }} </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="edit_email" class="form-label">Email</label>
                                <input type="email" wire:model="email" name="email" id="edit_email"
                                    class="form-control" placeholder="Masukkan Email pemohon" />
                                @error('email')
                                    <span class="form-text text-xs text-danger"> {{ $message }} </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="edit_fungsi_bangunan" class="form-label">Fungsi Bangunan</label>
                                <input type="text" wire:model="fungsi_bangunan" name="fungsi_bangunan"
                                    id="edit_fungsi_bangunan" class="form-control" placeholder="Masukkan Fungsi Bangunan" />
                                @error('fungsi_bangunan')
                                    <span class="form-text text-xs text-danger"> {{ $message }} </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="edit_alamat_tanah" class="form-label">Alamat Persil</label>
                                <textarea name="alamat_tanah" wire:model="alamat_tanah" id="edit_alamat_tanah" class="form-control"></textarea>
                                @error('alamat_tanah')
                                    <span class="form-text text-xs text-danger"> {{ $message }} </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label" for="edit_kel_tanah">Kelurahan Persil</label>
                                    <input type="text" class="form-control" wire:model="kel_tanah" id="edit_kel_tanah"
                                        placeholder="Masukkan Kelurahan Tanah" />
                                    @error('kel_tanah')
                                        <span class="form-text text-xs text-danger"> {{ $message }} </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label" for="edit_kec_tanah">Kecamatan Persil</label>
                                    <select class="form-select" wire:model="kec_tanah" id="edit_kec_tanah"
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
                        @if(!$permohonan)
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label class="form-label" for="edit_status">Status Berkas</label>
                                        <select class="form-select" wire:model.live="status" id="edit_status"
                                            aria-label="Default select example">
                                            <option value="" selected>Pilih Status</option>
                                            <option value="Berkas Dicabut">Berkas Dicabut</option>
                                            <option value="Berkas Tidak Lengkap">Berkas Tidak Lengkap</option>                                        
                                        </select>
                                        @error('status')
                                            <span class="form-text text-xs text-danger"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            @if($status == 'Berkas Dicabut')
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label" for="edit_alasan_dicabut">Alasan Dicabut</label>
                                            <textarea name="alasan_dicabut" wire:model="alasan_dicabut" id="edit_alasan_dicabut" class="form-control"></textarea>
                                            @error('alasan_dicabut')
                                                <span class="form-text text-xs text-danger"> {{ $message }} </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if($status == 'Berkas Tidak Lengkap')
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label" for="edit_alasan_tidak_lengkap">Alasan Tidak Lengkap</label>
                                            <textarea name="alasan_tidak_lengkap" wire:model="alasan_tidak_lengkap" id="edit_alasan_tidak_lengkap" class="form-control"></textarea>
                                            @error('alasan_tidak_lengkap')
                                                <span class="form-text text-xs text-danger"> {{ $message }} </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endif
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
@script
    <script>
        $wire.on('trigger-close-modal', () => {
            const modal = bootstrap.Modal.getInstance(document.getElementById('editRegistrasiModal'));
            if (modal) {
                modal.hide();
            }
        });
    </script>
@endscript