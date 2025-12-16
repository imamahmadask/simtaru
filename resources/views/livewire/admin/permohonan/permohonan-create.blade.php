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
                                            placeholder="" disabled />
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
                                <input type="text" class="form-control" wire:model="alamat_tanah" id="alamat_tanah"
                                    placeholder="Masukkan Alamat Tanah" disabled />
                                @error('alamat_tanah')
                                    <span class="form-text text-xs text-danger"> {{ $message }} </span>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label class="form-label" for="kel_tanah">Kelurahan Tanah</label>
                                        <input type="text" class="form-control" wire:model="kel_tanah"
                                            id="kel_tanah" placeholder="Masukkan Kelurahan Tanah" disabled />
                                        @error('kel_tanah')
                                            <span class="form-text text-xs text-danger"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label class="form-label" for="kec_tanah">Kecamatan Tanah</label>
                                        <select class="form-select" wire:model="kec_tanah" id="kec_tanah"
                                            aria-label="Default select example" disabled>
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
                                        <label class="form-label" for="fungsi_bangunan">Fungsi Bangunan</label>
                                        <input type="text" class="form-control" wire:model="fungsi_bangunan"
                                            id="fungsi_bangunan" placeholder="Masukkan Fungsi Bangunan" disabled />
                                        @error('fungsi_bangunan')
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

                            @if ($kode_layanan == 'SKRK' || $kode_layanan == 'ITR')
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
                            @endif

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label for="berkas_ktp" class="form-label">
                                            Upload KTP
                                            <div wire:loading wire:target="berkas_ktp"
                                                class="spinner-border spinner-border-sm text-primary" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                            {{-- Tanda centang setelah upload selesai --}}
                                            @if (!empty($berkas_ktp))
                                                <i wire:loading.remove wire:target="berkas_ktp"
                                                    class="bx bx-check-circle text-success"></i>
                                            @endif
                                        </label>
                                        <input type="file" class="form-control" id="berkas_ktp"
                                            wire:model.blur="berkas_ktp" accept="application/pdf">
                                        <div class="form-text">Format file .pdf maks 2 Mb</div>
                                        @error('berkas_ktp')
                                            <span class="form-text text-xs text-danger"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label for="berkas_permohonan" class="form-label">
                                            Upload Formulir Permohonan
                                            <div wire:loading wire:target="berkas_permohonan"
                                                class="spinner-border spinner-border-sm text-primary" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                            {{-- Tanda centang setelah upload selesai --}}
                                            @if (!empty($berkas_permohonan))
                                                <i wire:loading.remove wire:target="berkas_permohonan"
                                                    class="bx bx-check-circle text-success"></i>
                                            @endif
                                        </label>
                                        <input type="file" class="form-control" id="berkas_permohonan"
                                            wire:model.blur="berkas_permohonan" accept="application/pdf">
                                        <div class="form-text">Format file .pdf maks 2 Mb</div>
                                        @error('berkas_permohonan')
                                            <span class="form-text text-xs text-danger"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label for="berkas_kuasa" class="form-label">
                                            Surat Kuasa (Jika Ada)
                                            <div wire:loading wire:target="berkas_kuasa"
                                                class="spinner-border spinner-border-sm text-primary" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                            {{-- Tanda centang setelah upload selesai --}}
                                            @if (!empty($berkas_kuasa))
                                                <i wire:loading.remove wire:target="berkas_kuasa"
                                                    class="bx bx-check-circle text-success"></i>
                                            @endif
                                        </label>
                                        <input type="file" class="form-control" id="berkas_kuasa"
                                            wire:model.blur="berkas_kuasa" accept="application/pdf">
                                        <div class="form-text">Format file .pdf maks 2 Mb</div>
                                        @error('berkas_kuasa')
                                            <span class="form-text text-xs text-danger"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                </div>

                                @if ($kode_layanan == 'SKRK' || $kode_layanan == 'ITR')
                                    <div class="col-sm-4">
                                        <div class="mb-3">
                                            <label for="berkas_nib" class="form-label">
                                                Upload NIB, KBLI, dan Pernyataan Mandiri
                                                <div wire:loading wire:target="berkas_nib"
                                                    class="spinner-border spinner-border-sm text-primary" role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                                {{-- Tanda centang setelah upload selesai --}}
                                                @if (!empty($berkas_nib))
                                                    <i wire:loading.remove wire:target="berkas_nib"
                                                        class="bx bx-check-circle text-success"></i>
                                                @endif
                                            </label>
                                            <input type="file" class="form-control" id="berkas_nib"
                                                wire:model.blur="berkas_nib" accept="application/pdf">
                                            <div class="form-text">Format file .pdf maks 2 Mb</div>
                                            @error('berkas_nib')
                                                <span class="form-text text-xs text-danger"> {{ $message }} </span>
                                            @enderror
                                        </div>
                                    </div>
                                @endif

                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label for="berkas_penguasaan" class="form-label">
                                            Bukti Penguasaan Tanah
                                            <div wire:loading wire:target="berkas_penguasaan"
                                                class="spinner-border spinner-border-sm text-primary" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                            {{-- Tanda centang setelah upload selesai --}}
                                            @if (!empty($berkas_penguasaan))
                                                <i wire:loading.remove wire:target="berkas_penguasaan"
                                                    class="bx bx-check-circle text-success"></i>
                                            @endif
                                        </label>
                                        <input type="file" class="form-control" id="berkas_penguasaan"
                                            wire:model.blur="berkas_penguasaan" accept="application/pdf">
                                        <div class="form-text">Format file .pdf maks 2 Mb</div>
                                        @error('berkas_penguasaan')
                                            <span class="form-text text-xs text-danger"> {{ $message }} </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            @if ($kode_layanan == 'KKPRNB')
                                <hr class="mt-3">

                                <h5 class="text-danger">KKPR Non Berusaha</h5>

                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label" for="create-rdtr-rtrw">RDTR / RTRW</label>
                                            <select class="form-control" wire:model.live="rdtr_rtrw"
                                                id="create-rdtr-rtrw">
                                                <option value="">-- Pilih --</option>
                                                <option value="RDTR">RDTR</option>
                                                <option value="RTRW">RTRW</option>
                                            </select>
                                            @error('rdtr_rtrw')
                                                <span class="form-text text-xs text-danger"> {{ $message }} </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label" for="create-tgl-validasi">Tanggal Validasi
                                                Berkas</label>
                                            <input type="date" class="form-control" wire:model="tgl_validasi"
                                                id="create-tgl-validasi" placeholder="Masukkan Tanggal Validasi" />
                                            @error('tgl_validasi')
                                                <span class="form-text text-xs text-danger"> {{ $message }} </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                @if ($rdtr_rtrw == 'RTRW')
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label" for="create-tgl-terima-ptp">Tanggal
                                                    Penerimaan PTP</label>
                                                <input type="date" class="form-control"
                                                    wire:model="tgl_terima_ptp" id="create-tgl-terima-ptp"
                                                    placeholder="Masukkan Tanggal PTP" />
                                                @error('tgl_terima_ptp')
                                                    <span class="form-text text-xs text-danger"> {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label" for="create-tgl-ptp">Tanggal Penerbitan
                                                    PTP</label>
                                                <input type="date" class="form-control" wire:model="tgl_ptp"
                                                    id="create-tgl-ptp" placeholder="Masukkan Tanggal PTP" />
                                                @error('tgl_ptp')
                                                    <span class="form-text text-xs text-danger"> {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <label class="form-label" for="create-no-ptp">Nomor PTP</label>
                                                <input type="text" class="form-control" wire:model="no_ptp"
                                                    id="create-no-ptp" placeholder="Masukkan Nomor PTP" />
                                                @error('no_ptp')
                                                    <span class="form-text text-xs text-danger"> {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="mb-3">
                                                <label for="berkas_ptp" class="form-label">
                                                    Berkas PTP
                                                    <div wire:loading wire:target="berkas_ptp"
                                                        class="spinner-border spinner-border-sm text-primary"
                                                        role="status">
                                                        <span class="visually-hidden">Loading...</span>
                                                    </div>
                                                    {{-- Tanda centang setelah upload selesai --}}
                                                    @if (!empty($berkas_ptp))
                                                        <i wire:loading.remove wire:target="berkas_ptp"
                                                            class="bx bx-check-circle text-success"></i>
                                                    @endif
                                                </label>
                                                <input type="file" class="form-control" id="berkas_ptp"
                                                    wire:model.blur="berkas_ptp" accept="application/pdf">
                                                <div class="form-text">Format file .pdf maks 2 Mb</div>
                                                @error('berkas_ptp')
                                                    <span class="form-text text-xs text-danger"> {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div class="row">
                                    <div class="col">
                                        <ul>
                                            <li>
                                                <div class="mb-3">
                                                    <label for="tanggapan_1a" class="form-label">
                                                        Tanggapan 1A (Bila Ada)
                                                        <div wire:loading wire:target="tanggapan_1a"
                                                            class="spinner-border spinner-border-sm text-primary"
                                                            role="status">
                                                            <span class="visually-hidden">Loading...</span>
                                                        </div>
                                                        {{-- Tanda centang setelah upload selesai --}}
                                                        @if (!empty($tanggapan_1a))
                                                            <i wire:loading.remove wire:target="tanggapan_1a"
                                                                class="bx bx-check-circle text-success"></i>
                                                        @endif
                                                    </label>
                                                    <input type="file" class="form-control" id="tanggapan_1a"
                                                        wire:model.blur="tanggapan_1a" accept="application/pdf">
                                                    <div class="form-text">Format file .pdf maks 2 Mb</div>
                                                    @error('tanggapan_1a')
                                                        <span class="form-text text-xs text-danger"> {{ $message }}
                                                        </span>
                                                    @enderror
                                                </div>
                                            </li>
                                            <li>
                                                <div class="mb-3">
                                                    <label for="tanggapan_1b" class="form-label">
                                                        Tanggapan 1B
                                                        <div wire:loading wire:target="tanggapan_1b"
                                                            class="spinner-border spinner-border-sm text-primary"
                                                            role="status">
                                                            <span class="visually-hidden">Loading...</span>
                                                        </div>
                                                        {{-- Tanda centang setelah upload selesai --}}
                                                        @if (!empty($tanggapan_1b))
                                                            <i wire:loading.remove wire:target="tanggapan_1b"
                                                                class="bx bx-check-circle text-success"></i>
                                                        @endif
                                                    </label>
                                                    <input type="file" class="form-control" id="tanggapan_1b"
                                                        wire:model.blur="tanggapan_1b" accept="application/pdf">
                                                    <div class="form-text">Format file .pdf maks 2 Mb</div>
                                                    @error('tanggapan_1b')
                                                        <span class="form-text text-xs text-danger"> {{ $message }}
                                                        </span>
                                                    @enderror
                                                </div>
                                            </li>
                                            <li>
                                                <div class="mb-3">
                                                    <label for="tanggapan_2" class="form-label">
                                                        Tanggapan 2
                                                        <div wire:loading wire:target="tanggapan_2"
                                                            class="spinner-border spinner-border-sm text-primary"
                                                            role="status">
                                                            <span class="visually-hidden">Loading...</span>
                                                        </div>
                                                        {{-- Tanda centang setelah upload selesai --}}
                                                        @if (!empty($tanggapan_2))
                                                            <i wire:loading.remove wire:target="tanggapan_2"
                                                                class="bx bx-check-circle text-success"></i>
                                                        @endif
                                                    </label>
                                                    <input type="file" class="form-control" id="tanggapan_2"
                                                        wire:model.blur="tanggapan_2" accept="application/pdf">
                                                    <div class="form-text">Format file .pdf maks 2 Mb</div>
                                                    @error('tanggapan_2')
                                                        <span class="form-text text-xs text-danger"> {{ $message }}
                                                        </span>
                                                    @enderror
                                                </div>
                                            </li>
                                            <li>
                                                <div class="mb-3">
                                                    <label for="surat_pengantar_kelengkapan" class="form-label">
                                                        Surat Pengantar Tanggapan Kelengkapan Berkas
                                                        <div wire:loading wire:target="surat_pengantar_kelengkapan"
                                                            class="spinner-border spinner-border-sm text-primary"
                                                            role="status">
                                                            <span class="visually-hidden">Loading...</span>
                                                        </div>
                                                        {{-- Tanda centang setelah upload selesai --}}
                                                        @if (!empty($surat_pengantar_kelengkapan))
                                                            <i wire:loading.remove wire:target="surat_pengantar_kelengkapan"
                                                                class="bx bx-check-circle text-success"></i>
                                                        @endif
                                                    </label>
                                                    <input type="file" class="form-control" id="surat_pengantar_kelengkapan"
                                                        wire:model.blur="surat_pengantar_kelengkapan" accept="application/pdf">
                                                    <div class="form-text">Format file .pdf maks 2 Mb</div>
                                                    @error('surat_pengantar_kelengkapan')
                                                        <span class="form-text text-xs text-danger"> {{ $message }}
                                                        </span>
                                                    @enderror
                                                </div>
                                            </li>
                                            <li>
                                                <div class="mb-3">
                                                    <label for="ceklis" class="form-label">
                                                        Ceklis
                                                        <div wire:loading wire:target="ceklis"
                                                            class="spinner-border spinner-border-sm text-primary"
                                                            role="status">
                                                            <span class="visually-hidden">Loading...</span>
                                                        </div>
                                                        {{-- Tanda centang setelah upload selesai --}}
                                                        @if (!empty($ceklis))
                                                            <i wire:loading.remove wire:target="ceklis"
                                                                class="bx bx-check-circle text-success"></i>
                                                        @endif
                                                    </label>
                                                    <input type="file" class="form-control" id="ceklis"
                                                        wire:model.blur="ceklis" accept="application/pdf">
                                                    <div class="form-text">Format file .pdf maks 2 Mb</div>
                                                    @error('ceklis')
                                                        <span class="form-text text-xs text-danger"> {{ $message }}
                                                        </span>
                                                    @enderror
                                                </div>
                                            </li>
                                        </ul>
                                    </div>                                                                       
                                    
                                    <div class="col">
                                        <div class="card mb-4">
                                            <div class="card-header d-flex align-items-center justify-content-between bg-secondary">
                                                <h5 class="mb-0 text-white">Download Template Berkas KKPR Non Berusaha</h5>
                                            </div>
                                            <div class="card-body mt-3">
                                                <div class="row mb-3">
                                                    <div class="col">
                                                        <button type="button" class="btn btn-primary" wire:click="download1a">
                                                            Template Tanggapan 1A
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col">
                                                        <button type="button" class="btn btn-primary" wire:click="download1b">
                                                            Template Tanggapan 1B
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col">
                                                        <button type="button" class="btn btn-primary" wire:click="download2">
                                                            Template Tanggapan 2
                                                        </button>
                                                    </div>     
                                                </div>
                                                <div class="row mb-3">   
                                                    <div class="col">
                                                        <button type="button" class="btn btn-primary" wire:click="downloadCeklis">
                                                            Template Ceklis
                                                        </button>
                                                    </div>    
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col">
                                                        <button type="button" class="btn btn-primary" wire:click="downloadSuratPengantarKelengkapan" @if(empty($rdtr_rtrw)) disabled @endif>
                                                            Template Surat Pengantar Tanggapan Kelengkapan
                                                        </button>
                                                    </div>                                                                                                                                
                                                </div>                                                                                                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>                            
                            @endif

                            <div class="mb-3">
                                <label for="keterangan" class="form-label">Keterangan</label>
                                <textarea class="form-control" wire:model="keterangan" id="keterangan" rows="3"></textarea>
                            </div>

                            <hr class="mt-5">
                            <h5 class="fw-bold">DISPOSISI</h5>

                            <div class="row">
                                <div class="col mb-3">
                                    <label for="create-tahapan-id" class="form-label">Tahapan</label>
                                    <select class="form-select" wire:model.blur="tahapan_id" name="tahapan_id"
                                        id="create-tahapan-id" aria-label="Select Tahapan">
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
                                    <label for="create-penerima-id" class="form-label">Penerima Disposisi</label>
                                    <select class="form-select" wire:model="penerima_id" name="penerima_id"
                                        id="create-penerima-id" aria-label="Select Penerima">
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
                                    <label for="create-catatan" class="form-label">Catatan Disposisi</label>
                                    <textarea class="form-control" wire:model="catatan" name="catatan" id="create-catatan" rows="3"></textarea>
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
