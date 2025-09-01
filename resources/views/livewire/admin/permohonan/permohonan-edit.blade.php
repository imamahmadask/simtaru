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
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="registrasi_id" class="form-label">Kode Registrasi</label>
                                    <select class="form-select @error('registrasi_id') is-invalid @enderror"
                                        wire:model="registrasi_id" id="registrasi_id" disabled>
                                        <option value="">Pilih Registrasi</option>
                                        @foreach ($registrasis as $registrasi)
                                            <option value="{{ $registrasi->id }}">{{ $registrasi->kode }} -
                                                {{ $registrasi->nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('registrasi_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col mb-3">
                                    <label for="layanan_id" class="form-label">Jenis Layanan</label>
                                    <select class="form-select @error('layanan_id') is-invalid @enderror"
                                        wire:model="layanan_id" id="layanan_id" disabled>
                                        <option value="">Pilih Layanan</option>
                                        @foreach ($layanans as $layanan)
                                            <option value="{{ $layanan->id }}">{{ $layanan->nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('layanan_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="alamat_tanah">Alamat Tanah</label>
                                <textarea class="form-control @error('alamat_tanah') is-invalid @enderror" id="alamat_tanah" wire:model="alamat_tanah"
                                    rows="3"></textarea>
                                @error('alamat_tanah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col mb-3">
                                    <label class="form-label" for="kel_tanah">Kelurahan</label>
                                    <input type="text" class="form-control @error('kel_tanah') is-invalid @enderror"
                                        wire:model="kel_tanah" id="kel_tanah" placeholder="Masukkan kelurahan" />
                                    @error('kel_tanah')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col mb-3">
                                    <label class="form-label" for="kec_tanah">Kecamatan</label>
                                    <input type="text" class="form-control @error('kec_tanah') is-invalid @enderror"
                                        wire:model="kec_tanah" id="kec_tanah" placeholder="Masukkan kecamatan" />
                                    @error('kec_tanah')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="jenis_bangunan">Jenis Bangunan</label>
                                <input type="text" class="form-control @error('jenis_bangunan') is-invalid @enderror"
                                    wire:model="jenis_bangunan" id="jenis_bangunan"
                                    placeholder="Masukkan jenis bangunan" />
                                @error('jenis_bangunan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" wire:model="status" id="status">
                                    <option value="pending">Pending</option>
                                    <option value="process">Process</option>
                                    <option value="completed">Completed</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="berkas_pemohon" class="form-label">Upload Berkas Pemohon</label>
                                <input type="file" class="form-control" id="berkas_pemohon"
                                    wire:model="berkas_pemohon">

                                @if ($berkas_pemohon_lama)
                                    <a href="{{ asset('storage/' . $berkas_pemohon_lama) }}" target="_blank">
                                        Lihat Berkas
                                    </a>
                                @else
                                    Belum ada file
                                @endif
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="keterangan">Keterangan</label>
                                <textarea class="form-control" id="keterangan" wire:model="keterangan" rows="3"></textarea>
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
