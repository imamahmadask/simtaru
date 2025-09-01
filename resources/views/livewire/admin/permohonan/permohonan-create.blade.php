<div>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Permohonan /</span> Tambah Permohonan</h4>

        <!-- Basic Layout -->
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Form Permohonan</h5>
                        <small class="text-muted float-end"></small>
                    </div>
                    <div class="card-body">
                        <form wire:submit="addPermohonan">
                            <div class="mb-3">
                                <label for="registrasi_id" class="form-label">Kode Registrasi</label>
                                <select class="form-select" wire:model.live="registrasi_id" id="registrasi_id"
                                    aria-label="Default select example">
                                    <option value="" selected>Pilih Registrasi</option>
                                    @foreach ($registrasis as $data)
                                        <option value="{{ $data->id }}">{{ $data->kode }} - {{ $data->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="layanan_id" class="form-label">Jenis Layanan</label>
                                        <select class="form-select" wire:model="layanan_id" id="layanan_id"
                                            aria-label="Default select example" disabled>
                                            @foreach ($layanans as $data)
                                                <option value="{{ $data->id }}">{{ $data->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="mb-3">
                                        <label class="form-label" for="nama">Nama Pemohon</label>
                                        <input type="text" class="form-control" wire:model="nama" id="nama"
                                            placeholder="" disabled />
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="alamat_tanah">Alamat Tanah</label>
                                <input type="text" class="form-control" wire:model="alamat_tanah" id="alamat_tanah"
                                    placeholder="Masukkan Alamat Tanah" />
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label class="form-label" for="kel_tanah">Kelurahan Tanah</label>
                                        <input type="text" class="form-control" wire:model="kel_tanah" id="kel_tanah"
                                            placeholder="Masukkan Kelurahan Tanah" />
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label class="form-label" for="kec_tanah">Kecamatan Tanah</label>
                                        <input type="text" class="form-control" wire:model="kec_tanah" id="kec_tanah"
                                            placeholder="Masukkan Kecamatan Tanah" />
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="jenis_bangunan">Jenis Bangunan</label>
                                <input type="text" class="form-control" wire:model="jenis_bangunan"
                                    id="jenis_bangunan" placeholder="Masukkan Jenis Bangunan" />
                            </div>

                            <div class="mb-3">
                                <label for="keterangan" class="form-label">Keterangan</label>
                                <textarea class="form-control" id="keterangan" rows="3"></textarea>
                            </div>

                            <h5 class="mt-5">Disposisi</h5>

                            <div class="row">
                                <div class="col mb-3">
                                    <label for="tahapan_id" class="form-label">Tahapan</label>
                                    <select class="form-select" wire:model.live="tahapan_id" name="tahapan_id"
                                        aria-label="Select Tahapan">
                                        <option selected>Pilih Tahapan</option>
                                        @foreach ($tahapans as $tahapan)
                                            <option value="{{ $tahapan->id }}">
                                                {{ $tahapan->urutan }} - {{ $tahapan->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('tahapan_id')
                                        <span class="form-text text-xs text-danger"> {{ $message }} </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col mb-3">
                                    <label for="penerima_id" class="form-label">Penerima Disposisi</label>
                                    <select class="form-select" wire:model="penerima_id" name="penerima_id"
                                        aria-label="Select Penerima">
                                        <option selected>Pilih Penerima</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">
                                                {{ $user->name }} - {{ $user->role }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('penerima_id')
                                        <span class="form-text text-xs text-danger"> {{ $message }} </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col mb-3">
                                    <label for="catatan" class="form-label">Catatan Disposisi</label>
                                    <textarea class="form-control" wire:model="catatan" name="catatan" rows="3"></textarea>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
