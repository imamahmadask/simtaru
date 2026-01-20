<div>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Pelanggaran /</span> Edit Pelanggaran</h4>
        @if (session()->has('success'))
            <div class="bs-toast toast bg-primary fade top-0 end-0 mb-2" role="alert" aria-live="assertive"
                aria-atomic="true" data-bs-delay="3000" data-bs-autohide="true">
                <div class="toast-header">
                    <i class="bx bx-bell me-2"></i>
                    <div class="me-auto fw-semibold">Message!</div>
                    <small>a moment ago</small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">{{ session('success') }}</div>
            </div>
        @endif
        <div class="card">
            <div class="card-body">
                <form wire:submit.prevent="update" enctype="multipart/form-data">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label" for="no_pelanggaran">No Pelanggaran</label>
                            <input type="text" id="no_pelanggaran" wire:model="no_pelanggaran"
                                class="form-control @error('no_pelanggaran') is-invalid @enderror"
                                placeholder="No Pelanggaran">
                            @error('no_pelanggaran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="jenis_formulir">Jenis Formulir</label>
                            <select id="jenis_formulir" wire:model="jenis_formulir"
                                class="form-select @error('jenis_formulir') is-invalid @enderror">
                                <option value="">Pilih Jenis Formulir</option>
                                <option value="Laporan Hasil Pengawasan">Laporan Hasil Pengawasan</option>
                                <option value="Laporan Indikasi Pelanggaran Dari Masyarakat">Laporan Indikasi Pelanggaran Dari Masyarakat</option>
                                <option value="Hasil Audit dalam rangka Pemberian Sanksi">Hasil Audit dalam rangka Pemberian Sanksi</option>
                                <option value="Laporan Hasil Penilaian KKPR atau SKRK">Laporan Hasil Penilaian KKPR atau SKRK</option>
                            </select>
                            @error('jenis_formulir')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr>

                        <div class="col-md-6">
                            <label class="form-label" for="tanggal_pengawasan">Tanggal Pengawasan</label>
                            <input type="date" id="tanggal_pengawasan" wire:model="tanggal_pengawasan"
                                class="form-control @error('tanggal_pengawasan') is-invalid @enderror">
                            @error('tanggal_pengawasan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="lokasi_pengawasan">Lokasi atau Jalur Pengawasan</label>
                            <input type="text" id="lokasi_pengawasan" wire:model="lokasi_pengawasan"
                                class="form-control @error('lokasi_pengawasan') is-invalid @enderror"
                                placeholder="Lokasi atau Jalur Pengawasan">
                            @error('lokasi_pengawasan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <label class="form-label" for="hasil_pengawasan">Hasil Laporan Pengawasan</label>
                            <textarea id="hasil_pengawasan" wire:model="hasil_pengawasan"
                                class="form-control @error('hasil_pengawasan') is-invalid @enderror" rows="5"></textarea>
                            @error('hasil_pengawasan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="anggota_tidak_hadir">Anggota Tidak Hadir</label>
                            <select id="anggota_tidak_hadir" wire:model="anggota_tidak_hadir"
                                class="form-select @error('anggota_tidak_hadir') is-invalid @enderror">
                                <option value="">Pilih Anggota Tidak Hadir</option>
                                <option value="Tidak Ada">Tidak Ada</option>
                                <option value="Sudiman">Sudiman</option>
                                <option value="Niko Putra Manunggal">Niko Putra Manunggal</option>
                                <option value="Bayu Muliawan">Bayu Muliawan</option>
                                <option value="M. Junaidi">M. Junaidi</option>
                                <option value="Nadeem Ali">Nadeem Ali</option>
                                <option value="Jayadi Sofian">Jayadi Sofian</option>
                                <option value="M. Alfian Firdaus">M. Alfian Firdaus</option>
                            </select>
                            @error('anggota_tidak_hadir')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="temuan_pelanggaran">Temuan Pelanggaran</label>
                            <select id="temuan_pelanggaran" wire:model="temuan_pelanggaran"
                                class="form-select @error('temuan_pelanggaran') is-invalid @enderror">
                                <option value="">Pilih Temuan Pelanggaran</option>
                                <option value="Ada Indikasi Pelanggaran">Ada Indikasi Pelanggaran</option>
                                <option value="Tidak Ada Indikasi Pelanggaran">Tidak Ada Indikasi Pelanggaran</option>
                            </select>
                            @error('temuan_pelanggaran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <label class="form-label" for="foto_pengawasan">Foto Pengawasan</label>
                            
                            <!-- Existing Photos -->
                            @if ($existing_foto_pengawasan)
                                <div class="mb-3">
                                    <h6>Foto Saat Ini:</h6>
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach ($existing_foto_pengawasan as $index => $path)
                                            <div class="position-relative">
                                                <img src="{{ Storage::url($path) }}" alt="Existing Photo"
                                                    class="img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">
                                                <button type="button" wire:click="removeExistingImage({{ $index }})"
                                                    class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1"
                                                    wire:confirm="Yakin ingin menghapus foto ini?">
                                                    <i class="bx bx-x"></i>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- New Photos Upload -->
                            <input type="file" id="new_foto_pengawasan" wire:model="new_foto_pengawasan"
                                class="form-control @error('new_foto_pengawasan') is-invalid @enderror" accept="image/*" multiple>
                            <div wire:loading wire:target="new_foto_pengawasan">Uploading...</div>
                            
                            @if ($new_foto_pengawasan)
                                <div class="mt-2">
                                    <h6>Preview Foto Baru:</h6>
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach ($new_foto_pengawasan as $index => $image)
                                            <div class="position-relative">
                                                <img src="{{ $image->temporaryUrl() }}" alt="Preview"
                                                    class="img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">
                                                <button type="button" wire:click="removeNewImage({{ $index }})"
                                                    class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1">
                                                    <i class="bx bx-x"></i>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            
                            @error('new_foto_pengawasan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr>

                        <div class="col-md-12">
                            <label class="form-label" for="sumber_informasi_pelanggaran">Sumber Informasi Pelanggaran</label>
                            <select id="sumber_informasi_pelanggaran" wire:model="sumber_informasi_pelanggaran"
                                class="form-select @error('sumber_informasi_pelanggaran') is-invalid @enderror">
                                <option value="">Pilih Sumber Informasi Pelanggaran</option>
                                <option value="Hasil Pengawasan dan Monitoring">Hasil Pengawasan dan Monitoring</option>
                                <option value="Laporan Masyarakat">Laporan Masyarakat</option>
                                <option value="Hasil Penilaian KKPR atau SKRK">Hasil Penilaian KKPR atau SKRK</option>
                            </select>
                            @error('sumber_informasi_pelanggaran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <hr>

                        <h4>Profil Identitas Pelanggar</h4>
                        
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

                        <h4>Profil Lokasi Indikasi Pelanggaran</h4>
                        
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
                                <option value="">Pilih Kecamatan Lokasi Pelanggaran</option>
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
                            <label class="form-label" for="bentuk_laporan">Bentuk Laporan</label>
                            <select id="bentuk_laporan" wire:model="bentuk_laporan"
                                class="form-select @error('bentuk_laporan') is-invalid @enderror">
                                <option value="">Pilih Bentuk Laporan</option>
                                <option value="Surat">Surat</option>
                                <option value="Laporan Lisan">Laporan Lisan</option>
                                <option value="Saluran Pengaduan Lapor">Saluran Pengaduan Lapor</option>
                                <option value="Laporan Media Sosial/Media Cetak">Laporan Media Sosial/Media Cetak</option>
                                <option value="Laporan Dari Whatsapp">Laporan Dari Whatsapp</option>
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
                            <label class="form-label" for="isi_laporan">Kronologis Isi Laporan</label>
                            <textarea id="isi_laporan" wire:model="isi_laporan"
                                class="form-control @error('isi_laporan') is-invalid @enderror"
                                placeholder="Kronologis Isi Laporan"></textarea>
                            @error('isi_laporan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <hr>
                        <div class="col-md-6">
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
                        <div class="col-md-6">
                            <label class="form-label" for="status">Status</label>
                            <select id="status" wire:model="status"
                                class="form-select @error('status') is-invalid @enderror">
                                <option value="">Pilih Status</option>
                                <option value="Pending">Pending</option>
                                <option value="Process">Process</option>
                                <option value="Success">Success</option>
                                <option value="Rejected">Rejected</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            <a href="{{ route('pelanggaran.index') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
