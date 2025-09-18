<div>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Permohonan /</span> Edit Permohonan</h4>

        <!-- Basic Layout -->
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Form Edit Permohonan</h5>
                        <small class="text-muted float-end"></small>
                    </div>
                    <div class="card-body">
                        @if (session()->has('message'))
                            <div class="alert alert-success alert-dismissible" role="alert">
                                {{ session('message') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        <form wire:submit="updatePermohonan">
                            @if (Auth::user()->role == 'superadmin')
                                <div class="mb-3">
                                    <label for="is_prioritas" class="form-label">Is Prioritas?</label>
                                    <select class="form-select" wire:model.live="is_prioritas" id="is_prioritas"
                                        aria-label="Prioritas select">
                                        <option selected>Pilih Prioritas</option>
                                        <option value="1">Ya</option>
                                        <option value="0">Tidak</option>
                                    </select>
                                    @error('is_prioritas')
                                        <span class="form-text text-xs text-danger"> {{ $message }} </span>
                                    @enderror
                                </div>
                            @endif

                            <div class="mb-3">
                                <label for="registrasi_id" class="form-label">Kode Registrasi</label>
                                <select class="form-select" wire:model.live="registrasi_id" id="registrasi_id"
                                    aria-label="Default select example" disabled>
                                    <option value="" selected>Pilih Registrasi</option>
                                    @foreach ($registrasis as $data)
                                        <option value="{{ $data->id }}">{{ $data->kode }} - {{ $data->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('registrasi_id')
                                    <span class="form-text text-xs text-danger"> {{ $message }} </span>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="layanan_id" class="form-label">Jenis Layanan</label>
                                        <select class="form-select" wire:model="layanan_id" id="layanan_id"
                                            aria-label="Default select example" disabled>
                                            <option value="" selected>Pilih Jenis Layanan</option>
                                            @foreach ($layanans as $data)
                                                <option value="{{ $data->id }}">{{ $data->nama }}</option>
                                            @endforeach
                                        </select>
                                        @error('layanan_id')
                                            <span class="form-text text-xs text-danger"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="mb-3">
                                        <label class="form-label" for="nama">Nama Pemohon</label>
                                        <input type="text" class="form-control" wire:model="nama" id="nama"
                                            placeholder="" disabled />
                                        @error('nama')
                                            <span class="form-text text-xs text-danger"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label class="form-label" for="nik">NIK</label>
                                        <input type="text" class="form-control" wire:model="nik" id="nik"
                                            placeholder="" disabled />
                                        @error('nik')
                                            <span class="form-text text-xs text-danger"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label class="form-label" for="no_hp">No. HP</label>
                                        <input type="text" class="form-control" wire:model="no_hp" id="no_hp"
                                            placeholder="" disabled />
                                        @error('no_hp')
                                            <span class="form-text text-xs text-danger"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label class="form-label" for="email">Email Pemohon</label>
                                        <input type="email" class="form-control" wire:model="email" id="email"
                                            placeholder="Masukkan email pemohon" disabled />
                                        @error('email')
                                            <span class="form-text text-xs text-danger"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label class="form-label" for="npwp">NPWP Pemohon</label>
                                        <input type="npwp" class="form-control" wire:model="npwp" id="npwp"
                                            placeholder="Masukkan nomor npwp pemohon" />
                                        @error('npwp')
                                            <span class="form-text text-xs text-danger"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="alamat_pemohon">Alamat Pemohon</label>
                                <input type="text" class="form-control" wire:model="alamat_pemohon"
                                    id="alamat_pemohon" placeholder="Masukkan Alamat Pemohon" />
                                @error('alamat_pemohon')
                                    <span class="form-text text-xs text-danger"> {{ $message }} </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="alamat_tanah">Alamat Tanah</label>
                                <input type="text" class="form-control" wire:model="alamat_tanah"
                                    id="alamat_tanah" placeholder="Masukkan Alamat Tanah" />
                                @error('alamat_tanah')
                                    <span class="form-text text-xs text-danger"> {{ $message }} </span>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label class="form-label" for="kel_tanah">Kelurahan Tanah</label>
                                        <input type="text" class="form-control" wire:model="kel_tanah"
                                            id="kel_tanah" placeholder="Masukkan Kelurahan Tanah" />
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

                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label class="form-label" for="jenis_bangunan">Fungsi Bangunan</label>
                                        <input type="text" class="form-control" wire:model="jenis_bangunan"
                                            id="jenis_bangunan" placeholder="Masukkan Fungsi Bangunan" />
                                        @error('jenis_bangunan')
                                            <span class="form-text text-xs text-danger"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label class="form-label" for="luas_tanah">Luas Tanah (m2)</label>
                                        <input type="text" class="form-control" wire:model="luas_tanah"
                                            id="luas_tanah"
                                            placeholder="Masukkan Luas Tanah/persil yang dimohonkan" />
                                        @error('luas_tanah')
                                            <span class="form-text text-xs text-danger"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="status_modal">Status Modal</label>
                                <select class="form-control" wire:model="status_modal" id="status_modal">
                                    <option value="">Pilih Status Modal</option>
                                    <option value="PMDN">PMDN</option>
                                    <option value="PMA">PMA</option>
                                </select>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label class="form-label" for="kbli">KBLI</label>
                                        <input type="text" class="form-control" wire:model="kbli" id="kbli"
                                            placeholder="Masukkan KBLI" />
                                        @error('kbli')
                                            <span class="form-text text-xs text-danger"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label class="form-label" for="judul_kbli">Judul KBLI</label>
                                        <input type="text" class="form-control" wire:model="judul_kbli"
                                            id="judul_kbli" placeholder="Masukkan Judul KBLI" />
                                        @error('judul_kbli')
                                            <span class="form-text text-xs text-danger"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="mb-3">
                                        <label for="berkas_ktp" class="form-label">Upload KTP</label>
                                        <input type="file" class="form-control" id="berkas_ktp"
                                            wire:model="berkas_ktp">
                                        @if ($berkas_ktp_lama)
                                            <a href="{{ asset('storage/' . $berkas_ktp_lama) }}"
                                                class="btn btn-sm btn-primary my-2" target="_blank">
                                                <i class="bx bx-show"></i> KTP
                                            </a>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="mb-3">
                                        <label for="berkas_permohonan" class="form-label">Upload Permohonan</label>
                                        <input type="file" class="form-control" id="berkas_permohonan"
                                            wire:model="berkas_permohonan">
                                        @if ($berkas_permohonan_lama)
                                            <a href="{{ asset('storage/' . $berkas_permohonan_lama) }}"
                                                class="btn btn-sm btn-primary my-2" target="_blank">
                                                <i class="bx bx-show"></i> Permohonan
                                            </a>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="mb-3">
                                        <label for="berkas_nib" class="form-label">Upload NIB</label>
                                        <input type="file" class="form-control" id="berkas_nib"
                                            wire:model="berkas_nib">
                                        @if ($berkas_nib_lama)
                                            <a href="{{ asset('storage/' . $berkas_nib_lama) }}"
                                                class="btn btn-sm btn-primary my-2" target="_blank">
                                                <i class="bx bx-show"></i> NIB
                                            </a>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="mb-3">
                                        <label for="berkas_penguasaan" class="form-label">Upload Penguasaan
                                            Tanah</label>
                                        <input type="file" class="form-control" id="berkas_penguasaan"
                                            wire:model="berkas_penguasaan">
                                        @if ($berkas_penguasaan_lama)
                                            <a href="{{ asset('storage/' . $berkas_penguasaan_lama) }}"
                                                class="btn btn-sm btn-primary my-2" target="_blank">
                                                <i class="bx bx-show"></i> Penguasaan
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="keterangan" class="form-label">Keterangan</label>
                                <textarea class="form-control" wire:model="keterangan" id="keterangan" rows="3"></textarea>
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

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary me-2">Simpan Perubahan</button>
                                <a href="{{ route('permohonan.index') }}" class="btn btn-outline-secondary">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
