<div>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3"><span class="text-muted fw-light">Penilaian /</span> Edit Penilaian</h4>   
        <h5 class="fw-semibold badge bg-primary fs-6 fst-italic mb-4">No Dokumen : {{ $nomor_dokumen }}</h5>     
        <div class="card">
            <div class="card-body">
                <form wire:submit.prevent="update" enctype="multipart/form-data">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label" for="tanggal_penilaian">Tanggal Penilaian</label>
                            <input type="date" id="tanggal_penilaian" wire:model="tanggal_penilaian"
                                class="form-control @error('tanggal_penilaian') is-invalid @enderror">
                            @error('tanggal_penilaian')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>                        

                        <div class="col-md-6">
                            <label class="form-label" for="jenis_penilaian">Jenis Penilaian</label>
                            <select id="jenis_penilaian" wire:model="jenis_penilaian"
                                class="form-select @error('jenis_penilaian') is-invalid @enderror">
                                <option value="">Pilih Jenis Penilaian</option>
                                <option value="KKPR/KKKPR">KKPR/KKKPR</option>
                                <option value="PMP UMK">PMP UMK</option>                                
                            </select>
                            @error('jenis_penilaian')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="jenis_dokumen">Jenis Dokumen</label>
                            <select name="jenis_dokumen" id="jenis_dokumen" wire:model="jenis_dokumen" class="form-select @error('jenis_dokumen') is-invalid @enderror">
                                <option value="">Pilih Jenis Dokumen</option>
                                <option value="PKKPR">PKKPR</option>
                                <option value="KKKPR">KKKPR</option>
                                <option value="SKRK/Penilaian Mandiri">SKRK/Penilaian Mandiri</option>
                            </select>
                            @error('jenis_dokumen')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="nomor_dokumen">Nomor Dokumen</label>
                            <input type="text" id="nomor_dokumen" wire:model="nomor_dokumen"
                                class="form-control @error('nomor_dokumen') is-invalid @enderror"
                                placeholder="Nomor Dokumen">
                            @error('nomor_dokumen')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12">
                            <label class="form-label" for="new_file_dokumen">File Dokumen Pemanfaatan Ruang (Opsional - Pilih Jika Ingin Ganti)</label>
                            <input type="file" id="new_file_dokumen" wire:model="new_file_dokumen"
                                class="form-control @error('new_file_dokumen') is-invalid @enderror" accept="application/pdf">
                            <div wire:loading wire:target="new_file_dokumen">Uploading...</div>
                            
                            @if ($existing_file_dokumen)
                                <div class="mt-2">
                                    <small class="text-muted">Dokumen Saat Ini: </small>
                                    <a href="{{ Storage::url($existing_file_dokumen) }}" target="_blank" class="text-primary fw-semibold">
                                        <i class="bx bx-file me-1"></i> Lihat Dokumen
                                    </a>
                                </div>
                            @endif

                            @error('new_file_dokumen')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr>
                        <h5 class="fw-semibold text-primary">Profil Pelaku Usaha</h5>

                        <div class="col-md-6">
                            <label class="form-label" for="nama_pelaku_usaha">Nama Pelaku Usaha</label>
                            <input type="text" id="nama_pelaku_usaha" wire:model="nama_pelaku_usaha"
                                class="form-control @error('nama_pelaku_usaha') is-invalid @enderror"
                                placeholder="Nama Pelaku Usaha">
                            @error('nama_pelaku_usaha')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="no_telepon">No. Telepon</label>
                            <input type="text" id="no_telepon" wire:model="no_telepon"
                                class="form-control @error('no_telepon') is-invalid @enderror"
                                placeholder="No. Telepon">
                            @error('no_telepon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="email">Email</label>
                            <input type="email" id="email" wire:model="email"
                                class="form-control @error('email') is-invalid @enderror"
                                placeholder="Email">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="alamat_pelaku_usaha">Alamat Pelaku Usaha</label>
                            <textarea id="alamat_pelaku_usaha" wire:model="alamat_pelaku_usaha"
                                class="form-control @error('alamat_pelaku_usaha') is-invalid @enderror"
                                placeholder="Alamat Pelaku Usaha" rows="2"></textarea>
                            @error('alamat_pelaku_usaha')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr>
                        <h5 class="fw-semibold text-primary">Data Usaha & Kegiatan</h5>

                        <div class="col-md-6">
                            <label class="form-label" for="nama_usaha">Nama Usaha</label>
                            <input type="text" id="nama_usaha" wire:model="nama_usaha"
                                class="form-control @error('nama_usaha') is-invalid @enderror"
                                placeholder="Nama Usaha">
                            @error('nama_usaha')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="jenis_kegiatan_usaha">Jenis Kegiatan Usaha</label>
                            <input type="text" id="jenis_kegiatan_usaha" wire:model="jenis_kegiatan_usaha"
                                class="form-control @error('jenis_kegiatan_usaha') is-invalid @enderror"
                                placeholder="Jenis Kegiatan Usaha">
                            @error('jenis_kegiatan_usaha')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="alamat_lokasi_usaha">Alamat Lokasi Usaha</label>
                            <textarea id="alamat_lokasi_usaha" wire:model="alamat_lokasi_usaha"
                                class="form-control @error('alamat_lokasi_usaha') is-invalid @enderror"
                                placeholder="Alamat Lokasi Usaha" rows="2"></textarea>
                            @error('alamat_lokasi_usaha')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="koordinat">Koordinat</label>
                            <input type="text" id="koordinat" wire:model="koordinat"
                                class="form-control @error('koordinat') is-invalid @enderror"
                                placeholder="Koordinat">
                            @error('koordinat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr>
                        <h5 class="fw-semibold text-primary">Hasil Penilaian</h5>

                        <div class="col-md-12">
                            <label class="form-label" for="analisa_penilaian">Analisa Penilaian</label>
                            <select name="analisa_penilaian" id="analisa_penilaian" wire:model="analisa_penilaian" class="form-select @error('analisa_penilaian') is-invalid @enderror">
                                <option value="">Pilih Analisa Penilaian</option>
                                <option value="Sesuai Seluruhnya">Sesuai Seluruhnya</option>
                                <option value="Sesuai Sebagian">Sesuai Sebagian</option>
                            </select>
                            @error('analisa_penilaian')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="rekomendasi">Rekomendasi</label>
                            <textarea id="rekomendasi" wire:model="rekomendasi"
                                class="form-control @error('rekomendasi') is-invalid @enderror"
                                placeholder="Rekomendasi" rows="3"></textarea>
                            @error('rekomendasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="link_hasil_penilaian">Link Hasil Penilaian</label>
                            <input type="text" id="link_hasil_penilaian" wire:model="link_hasil_penilaian"
                                class="form-control @error('link_hasil_penilaian') is-invalid @enderror"
                                placeholder="Link Hasil Penilaian">
                            @error('link_hasil_penilaian')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>                        

                        <div class="col-md-6">
                            <label class="form-label" for="status">Status</label>
                            <select id="status" wire:model="status"
                                class="form-select @error('status') is-invalid @enderror">
                                <option value="Selesai">Selesai</option>
                                <option value="Proses">Proses</option>
                                <option value="Pending">Pending</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('penilaian.index') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
