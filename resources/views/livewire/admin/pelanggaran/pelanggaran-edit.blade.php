<div>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3"><span class="text-muted fw-light">Pelanggaran /</span> Edit Kasus Pelanggaran</h4>   
        <h5 class="fw-semibold badge bg-danger fs-6 fst-italic mb-4">No Kasus : {{ $no_pelanggaran }}</h5>     
        <div class="card">
            <div class="card-body">
                <form wire:submit.prevent="update" enctype="multipart/form-data">
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
                                class="form-select @error('sumber_informasi_pelanggaran') is-invalid @enderror" disabled>
                                <option value="">Pilih Sumber Informasi</option>
                                <option value="Hasil Pengawasan dan Monitoring">Hasil Pengawasan dan Monitoring</option>
                                <option value="Laporan Masyarakat">Laporan Masyarakat</option>
                                <option value="Hasil Penilaian KKPR atau SKRK">Hasil Penilaian KKPR atau SKRK</option>
                            </select>
                            @error('sumber_informasi_pelanggaran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        @if($sumber_informasi_pelanggaran == 'Hasil Pengawasan dan Monitoring')
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
                                <input type="file" id="new_foto_pengawasan" wire:model="new_foto_pengawasan"
                                    class="form-control @error('new_foto_pengawasan') is-invalid @enderror" accept="image/*" multiple>
                                <div wire:loading wire:target="new_foto_pengawasan">Uploading...</div>
                                
                                <!-- Existing Photos -->
                                @if ($existing_foto_pengawasan)
                                    <div class="mt-2">
                                        <h6>Foto Saat Ini:</h6>
                                        @foreach ($existing_foto_pengawasan as $index => $path)
                                            <div class="d-inline-block position-relative me-2 mb-2">
                                                <img src="{{ Storage::url($path) }}" alt="Existing Photo"
                                                    class="img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">
                                                <button type="button" wire:click="removeExistingImage({{ $index }}, 'foto_pengawasan')"
                                                    class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1"
                                                    wire:confirm="Yakin ingin menghapus foto ini?">
                                                    <i class="bx bx-x"></i>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
 
                                @if ($new_foto_pengawasan)
                                    <div class="mt-2">
                                        <h6>Preview Foto Baru:</h6>
                                        @foreach ($new_foto_pengawasan as $index => $image)
                                            <div class="d-inline-block position-relative me-2 mb-2">
                                                <img src="{{ $image->temporaryUrl() }}" alt="Preview"
                                                    class="img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">
                                                <button type="button" wire:click="removeNewImage({{ $index }}, 'foto_pengawasan')"
                                                    class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1">
                                                    <i class="bx bx-x"></i>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                                @error('new_foto_pengawasan')
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
                                <textarea id="isi_laporan" wire:model="isi_laporan"
                                    class="form-control @error('isi_laporan') is-invalid @enderror"
                                    placeholder="Kronologis Isi Laporan" rows="3"></textarea>
                                @error('isi_laporan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        @elseif($sumber_informasi_pelanggaran == 'Hasil Penilaian KKPR atau SKRK')
                            <hr>
                            <h5 class="fw-semibold text-danger">Data KKPR atau SKRK</h5>
                            <div class="col-md-6">
                                <label class="form-label" for="no_kkpr_skrk">No. KKPR atau SKRK</label>
                                <input type="text" id="no_kkpr_skrk" wire:model="no_kkpr_skrk"
                                    class="form-control @error('no_kkpr_skrk') is-invalid @enderror"
                                    placeholder="No. KKPR atau SKRK">
                                @error('no_kkpr_skrk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="no_ba_sk_penilaian_kkpr">No. BA/SK Penilaian KKPR</label>
                                <input type="text" id="no_ba_sk_penilaian_kkpr" wire:model="no_ba_sk_penilaian_kkpr"
                                    class="form-control @error('no_ba_sk_penilaian_kkpr') is-invalid @enderror"
                                    placeholder="No. BA/SK Penilaian KKPR">
                                @error('no_ba_sk_penilaian_kkpr')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>                            
                            <div class="col-md-6">
                                <label class="form-label" for="dokumen_penilaian_kkpr">Dokumen Penilaian KKPR</label>
                                <input type="file" id="dokumen_penilaian_kkpr" wire:model="dokumen_penilaian_kkpr"
                                    class="form-control @error('dokumen_penilaian_kkpr') is-invalid @enderror"
                                    placeholder="Dokumen Penilaian KKPR">
                                <div wire:loading wire:target="dokumen_penilaian_kkpr">Uploading...</div>

                                @if ($existing_dokumen_penilaian_kkpr)
                                    <div class="mt-2">
                                        <small class="text-muted">Dokumen Saat Ini: </small>
                                        <a href="{{ Storage::url($existing_dokumen_penilaian_kkpr) }}" target="_blank" class="text-primary fw-semibold">
                                            <i class="bx bx-file me-1"></i> Lihat Dokumen
                                        </a>
                                    </div>
                                @endif

                                @error('dokumen_penilaian_kkpr')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        @endif

                        <hr>
                        <h5 class="fw-semibold text-danger">Jenis Indikasi Pelanggaran</h5>
                        <div class="col-md-12">
                            <label class="form-label" for="jenis_indikasi_pelanggaran">Jenis Indikasi Pelanggaran</label>
                            <select id="jenis_indikasi_pelanggaran" wire:model="jenis_indikasi_pelanggaran"
                                class="form-select @error('jenis_indikasi_pelanggaran') is-invalid @enderror">
                                <option value="">Pilih Jenis Indikasi Pelanggaran</option>
                                <option value="Tidak Memiliki KKPR atau SKRK">Tidak Memiliki KKPR atau SKRK</option>
                                <option value="Tidak memenuhi ketentuan dalam KKPR atau SKRK cth. pelanggaran GSB, KDB/KDH">Tidak memenuhi ketentuan dalam KKPR atau SKRK cth. pelanggaran GSB, KDB/KDH</option>
                                <option value="Menghalangi akses terhadap kawasan yang ditetapkan sebagai milik umum">Menghalangi akses terhadap kawasan yang ditetapkan sebagai milik umum</option>
                                <option value="Tidak Memiliki Persetujuan Bangunan Gedung (PBG)">Tidak Memiliki Persetujuan Bangunan Gedung (PBG)</option>
                            </select>
                            @error('jenis_indikasi_pelanggaran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <hr>

                        <h5 class="fw-semibold text-danger">Profil Identitas Pelanggar</h5>
                        
                        <div class="col-md-6">
                            <label class="form-label" for="nama_pelanggar">Nama Pemilik Lahan</label>
                            <input type="text" id="nama_pelanggar" wire:model="nama_pelanggar"
                                class="form-control @error('nama_pelanggar') is-invalid @enderror"
                                placeholder="Nama Pemilik Lahan">
                            @error('nama_pelanggar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="alamat_pelanggar">Alamat Pemilik Lahan</label>
                            <input type="text" id="alamat_pelanggar" wire:model="alamat_pelanggar"
                                class="form-control @error('alamat_pelanggar') is-invalid @enderror"
                                placeholder="Alamat Pemilik Lahan">
                            @error('alamat_pelanggar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="kel_pelanggar">Kelurahan Pemilik Lahan</label>
                            <input type="text" id="kel_pelanggar" wire:model="kel_pelanggar"
                                class="form-control @error('kel_pelanggar') is-invalid @enderror"
                                placeholder="Kelurahan Pemilik Lahan">
                            @error('kel_pelanggar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="kec_pelanggar">Kecamatan Pemilik Lahan</label>
                            <input type="text" id="kec_pelanggar" wire:model="kec_pelanggar"
                                class="form-control @error('kec_pelanggar') is-invalid @enderror"
                                placeholder="Kecamatan Pemilik Lahan">
                            @error('kec_pelanggar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="kota_pelanggar">Kota Pemilik Lahan</label>
                            <input type="text" id="kota_pelanggar" wire:model="kota_pelanggar"
                                class="form-control @error('kota_pelanggar') is-invalid @enderror"
                                placeholder="Kota Pemilik Lahan">
                            @error('kota_pelanggar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="prov_pelanggar">Provinsi Pemilik Lahan</label>
                            <input type="text" id="prov_pelanggar" wire:model="prov_pelanggar"
                                class="form-control @error('prov_pelanggar') is-invalid @enderror"
                                placeholder="Provinsi Pemilik Lahan">
                            @error('prov_pelanggar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr>
                        <h5 class="fw-semibold text-danger">Profil Lokasi Indikasi Pelanggaran</h5>
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
                            <label class="form-label" for="gmaps_pelanggaran">Link Google Maps Lokasi Pelanggaran</label>
                            <input type="text" id="gmaps_pelanggaran" wire:model="gmaps_pelanggaran"
                                class="form-control @error('gmaps_pelanggaran') is-invalid @enderror"
                                placeholder="Link Google Maps Lokasi Pelanggaran">
                            @error('gmaps_pelanggaran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="jenis_pemanfaatan_ruang">Jenis Pemanfaatan Ruang</label>
                            <input type="text" id="jenis_pemanfaatan_ruang" wire:model="jenis_pemanfaatan_ruang"
                                class="form-control @error('jenis_pemanfaatan_ruang') is-invalid @enderror"
                                placeholder="Jenis Pemanfaatan Ruang">
                            @error('jenis_pemanfaatan_ruang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <label class="form-label" for="penjelasan_singkat">Penjelasan Singkat</label>
                            <textarea id="penjelasan_singkat" wire:model="penjelasan_singkat"
                                class="form-control @error('penjelasan_singkat') is-invalid @enderror"
                                placeholder="Penjelasan Singkat" rows="3"></textarea>
                            @error('penjelasan_singkat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <label class="form-label" for="new_foto_existing">Foto Kondisi Existing</label>
                            <input type="file" id="new_foto_existing" wire:model="new_foto_existing"
                                class="form-control @error('new_foto_existing') is-invalid @enderror" accept="image/*" multiple>
                            <div wire:loading wire:target="new_foto_existing">Uploading...</div>
                            
                            <!-- Existing Photos -->
                            @if ($existing_foto_existing)
                                <div class="mt-2">
                                    <h6>Foto Saat Ini:</h6>
                                    @foreach ($existing_foto_existing as $index => $path)
                                        <div class="d-inline-block position-relative me-2 mb-2">
                                            <img src="{{ Storage::url($path) }}" alt="Existing Photo"
                                                class="img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">
                                            <button type="button" wire:click="removeExistingImage({{ $index }}, 'foto_existing')"
                                                class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1"
                                                wire:confirm="Yakin ingin menghapus foto ini?">
                                                <i class="bx bx-x"></i>
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            @if ($new_foto_existing)
                                <div class="mt-2">
                                    <h6>Preview Foto Baru:</h6>
                                    @foreach ($new_foto_existing as $index => $image)
                                        <div class="d-inline-block position-relative me-2 mb-2">
                                            <img src="{{ $image->temporaryUrl() }}" alt="Preview"
                                                class="img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">
                                            <button type="button" wire:click="removeNewImage({{ $index }}, 'foto_existing')"
                                                class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1">
                                                <i class="bx bx-x"></i>
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                            @error('new_foto_existing')
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
