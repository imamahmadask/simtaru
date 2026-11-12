<div>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Pelanggaran /</span> Tambah Kasus Pelanggaran</h4>
        <div class="card">
            <div class="card-body">
                <form wire:submit.prevent="store" enctype="multipart/form-data">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label" for="tgl_laporan">Tanggal</label>
                            <input type="date" id="tgl_laporan" wire:model="tgl_laporan"
                                class="form-control @error('tgl_laporan') is-invalid @enderror"
                                placeholder="Tanggal Laporan">
                            @error('tgl_laporan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="sumber_informasi_pelanggaran">Sumber Informasi</label>
                            <select id="sumber_informasi_pelanggaran" wire:model.live="sumber_informasi_pelanggaran"
                                class="form-select @error('sumber_informasi_pelanggaran') is-invalid @enderror">
                                <option value="">Pilih Sumber Informasi</option>
                                <option value="Hasil Pengawasan dan Monitoring">Hasil Pengawasan dan Monitoring</option>
                                <option value="Laporan Masyarakat">Laporan Masyarakat</option>
                                <option value="Hasil Penilaian KKPR atau SKRK">Hasil Penilaian KKPR atau SKRK</option>
                            </select>
                            @error('sumber_informasi_pelanggaran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        @if ($sumber_informasi_pelanggaran == 'Hasil Pengawasan dan Monitoring')
                            <hr>
                            <h5 class="fw-semibold text-danger">Laporan Hasil Pengawasan</h5>
                            <div class="col-md-6">
                                <label class="form-label" for="tanggal_pengawasan">Tanggal Pengawasan</label>
                                <input type="date" id="tanggal_pengawasan" wire:model="tanggal_pengawasan"
                                    class="form-control @error('tanggal_pengawasan') is-invalid @enderror">
                                @error('tanggal_pengawasan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="foto_pengawasan">Foto Pengawasan</label>
                                <input type="file" id="foto_pengawasan" wire:model="foto_pengawasan"
                                    class="form-control @error('foto_pengawasan') is-invalid @enderror" accept="image/*"
                                    multiple>
                                <div wire:loading wire:target="foto_pengawasan">Uploading...</div>
                                @if ($foto_pengawasan)
                                    <div class="mt-2">
                                        @foreach ($foto_pengawasan as $index => $image)
                                            <div class="d-inline-block position-relative me-2 mb-2">
                                                <img src="{{ $image->temporaryUrl() }}" alt="Preview"
                                                    class="img-thumbnail"
                                                    style="width: 100px; height: 100px; object-fit: cover;">
                                                <button type="button"
                                                    wire:click="removeImage({{ $index }}, 'foto_pengawasan')"
                                                    class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1">
                                                    <i class="bx bx-x"></i>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                                @error('foto_pengawasan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        @elseif($sumber_informasi_pelanggaran == 'Laporan Masyarakat')
                            <hr>
                            <h5 class="fw-semibold text-danger">Profil Pelapor</h5>
                            <div class="col-md-6">
                                <label class="form-label" for="bentuk_laporan">Bentuk Laporan</label>
                                <select id="bentuk_laporan" wire:model="bentuk_laporan"
                                    class="form-select @error('bentuk_laporan') is-invalid @enderror">
                                    <option value="">Pilih Bentuk Laporan</option>
                                    <option value="Lisan">Lisan</option>
                                    <option value="Surat">Surat</option>
                                    <option value="Saluran Pengaduan">Saluran Pengaduan</option>
                                    <option value="Media Sosial">Media Sosial</option>
                                    <option value="Whatsapp">Whatsapp</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                                @error('bentuk_laporan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="nama_pelapor">Asal/Nama Pelapor</label>
                                <input type="text" id="nama_pelapor" wire:model="nama_pelapor"
                                    class="form-control @error('nama_pelapor') is-invalid @enderror"
                                    placeholder="Asal/Nama Pelapor">
                                @error('nama_pelapor')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="telp_pelapor">No. Telp Pelapor</label>
                                <input type="text" id="telp_pelapor" wire:model="telp_pelapor"
                                    class="form-control @error('telp_pelapor') is-invalid @enderror"
                                    placeholder="No. Telp Pelapor">
                                @error('telp_pelapor')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" for="isi_laporan">Kronologis/Isi Laporan</label>
                                <textarea id="isi_laporan" wire:model="isi_laporan" class="form-control @error('isi_laporan') is-invalid @enderror"
                                    placeholder="Kronologis Isi Laporan" rows="3"></textarea>
                                @error('isi_laporan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        @elseif($sumber_informasi_pelanggaran == 'Hasil Penilaian KKPR atau SKRK')
                            <hr>
                            <h5 class="fw-semibold text-danger">Hasil Penilaian KKPR atau SKRK</h5>

                            <div class="col-md-6">
                                <label class="form-label" for="no_kkpr_skrk">No. KKPR/SKRK</label>
                                <input type="text" id="no_kkpr_skrk" wire:model="no_kkpr_skrk"
                                    class="form-control @error('no_kkpr_skrk') is-invalid @enderror"
                                    placeholder="No. KKPR/SKRK">
                                @error('no_kkpr_skrk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="no_ba_sk_penilaian_kkpr">No. Berita Acara Penilaian
                                    KKPR/SKRK</label>
                                <input type="text" id="no_ba_sk_penilaian_kkpr"
                                    wire:model="no_ba_sk_penilaian_kkpr"
                                    class="form-control @error('no_ba_sk_penilaian_kkpr') is-invalid @enderror"
                                    placeholder="No. Berita Acara Penilaian KKPR/SKRK">
                                @error('no_ba_sk_penilaian_kkpr')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="dokumen_penilaian_kkpr">Dokumen Penilaian
                                    KKPR/SKRK</label>
                                <input type="file" id="dokumen_penilaian_kkpr" wire:model="dokumen_penilaian_kkpr"
                                    class="form-control @error('dokumen_penilaian_kkpr') is-invalid @enderror">
                                <div wire:loading wire:target="dokumen_penilaian_kkpr">Uploading...</div>
                                @error('dokumen_penilaian_kkpr')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        @endif

                        <hr>
                        <h5 class="fw-semibold text-danger">Profil Identitas Pelanggar</h5>

                        <div class="col-md-6">
                            <label class="form-label" for="nama_pelanggar">Nama Pelanggar</label>
                            <input type="text" id="nama_pelanggar" wire:model="nama_pelanggar"
                                class="form-control @error('nama_pelanggar') is-invalid @enderror"
                                placeholder="Nama Pelanggar">
                            @error('nama_pelanggar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr>
                        <h5 class="fw-semibold text-danger">Profil Lokasi Indikasi Pelanggaran</h5>
                        <div class="col-md-6">
                            <label class="form-label" for="nama_pemilik_perusahaan">Nama Pemilik / Perusahaan</label>
                            <input type="text" id="nama_pemilik_perusahaan" wire:model="nama_pemilik_perusahaan"
                                class="form-control @error('nama_pemilik_perusahaan') is-invalid @enderror"
                                placeholder="Nama Pemilik / Perusahaan">
                            @error('nama_pemilik_perusahaan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="alamat_pelanggaran">Alamat Lokasi Pelanggaran</label>
                            <input type="text" id="alamat_pelanggaran" wire:model="alamat_pelanggaran"
                                class="form-control @error('alamat_pelanggaran') is-invalid @enderror"
                                placeholder="Alamat Lokasi Pelanggaran">
                            @error('alamat_pelanggaran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="kel_pelanggaran">Kelurahan Lokasi Pelanggaran</label>
                            <input type="text" id="kel_pelanggaran" wire:model="kel_pelanggaran"
                                class="form-control @error('kel_pelanggaran') is-invalid @enderror"
                                placeholder="Kelurahan Lokasi Pelanggaran">
                            @error('kel_pelanggaran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="kec_pelanggaran">Kecamatan Lokasi Pelanggaran</label>
                            <select id="kec_pelanggaran" wire:model="kec_pelanggaran"
                                class="form-select @error('kec_pelanggaran') is-invalid @enderror">
                                <option value="">Pilih Kecamatan Pemilik Lahan</option>
                                <option value="Ampenan">Ampenan</option>
                                <option value="Mataram">Mataram</option>
                                <option value="Cakranegara">Cakranegara</option>
                                <option value="Sekarbela">Sekarbela</option>
                                <option value="Selaparang">Selaparang</option>
                                <option value="Sandubaya">Sandubaya</option>
                            </select>
                            @error('kec_pelanggaran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="koordinat_pelanggaran">Koordinat Lokasi Pelanggaran</label>
                            <input type="text" id="koordinat_pelanggaran" wire:model="koordinat_pelanggaran"
                                class="form-control @error('koordinat_pelanggaran') is-invalid @enderror"
                                placeholder="Koordinat Lokasi Pelanggaran">
                            @error('koordinat_pelanggaran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="gmaps_pelanggaran">Link Google Maps Lokasi
                                Pelanggaran</label>
                            <input type="text" id="gmaps_pelanggaran" wire:model="gmaps_pelanggaran"
                                class="form-control @error('gmaps_pelanggaran') is-invalid @enderror"
                                placeholder="Link Google Maps Lokasi Pelanggaran">
                            @error('gmaps_pelanggaran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="pemanfaatan_ruang">Peruntukan Pemanfaatan Ruang dalam RTR</label>
                            <input type="text" id="pemanfaatan_ruang" wire:model="pemanfaatan_ruang"
                                class="form-control @error('pemanfaatan_ruang') is-invalid @enderror"
                                placeholder="Peruntukan Pemanfaatan Ruang dalam RTR">
                            @error('pemanfaatan_ruang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="jenis_pemanfaatan_ruang">Pemanfaatan Ruang Existing</label>
                            <input type="text" id="jenis_pemanfaatan_ruang" wire:model="jenis_pemanfaatan_ruang"
                                class="form-control @error('jenis_pemanfaatan_ruang') is-invalid @enderror"
                                placeholder="Pemanfaatan Ruang Existing">
                            @error('jenis_pemanfaatan_ruang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <label class="form-label" for="penjelasan_singkat">Penjelasan Singkat Kasus</label>
                            <textarea id="penjelasan_singkat" wire:model="penjelasan_singkat"
                                class="form-control @error('penjelasan_singkat') is-invalid @enderror" placeholder="Penjelasan Singkat"
                                rows="3"></textarea>
                            @error('penjelasan_singkat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <label class="form-label" for="foto_existing">Foto Existing</label>
                            <input type="file" id="foto_existing" wire:model="foto_existing"
                                class="form-control @error('foto_existing') is-invalid @enderror" accept="image/*"
                                multiple>
                            <div wire:loading wire:target="foto_existing">Uploading...</div>
                            @if ($foto_existing)
                                <div class="mt-2">
                                    @foreach ($foto_existing as $index => $image)
                                        <div class="d-inline-block position-relative me-2 mb-2">
                                            <img src="{{ $image->temporaryUrl() }}" alt="Preview"
                                                class="img-thumbnail"
                                                style="width: 100px; height: 100px; object-fit: cover;">
                                            <button type="button"
                                                wire:click="removeImage({{ $index }}, 'foto_existing')"
                                                class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1">
                                                <i class="bx bx-x"></i>
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                            @error('foto_existing')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('pelanggaran.index') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
