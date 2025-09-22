<div>
    <div class="mb-3">
        <div class="d-flex flex-wrap gap-3">
            @if (Auth::user()->role == 'superadmin' || Auth::user()->role == 'supervisor' || Auth::user()->role == 'analis')
                @if ($skrk->is_survey && !$skrk->is_kajian)
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#AddKajianAnalisaModal">
                        <i class="bx bx-plus"></i> Data Kajian
                    </button>
                @elseif($skrk->is_kajian)
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#EditKajianAnalisaModal">
                        <i class="bx bx-edit"></i> Edit Data Kajian
                    </button>
                    @teleport('body')
                        @livewire('admin.permohonan.skrk.analis.skrk-kajian-analis-edit', ['permohonan_id' => $skrk->permohonan->id, 'skrk_id' => $skrk->id])
                    @endteleport
                @endif

                @if ($skrk->is_kajian && !$skrk->is_dokumen)
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#AddDokumenSkrkModal">
                        <i class="bx bx-plus"></i> Data Dokumen
                    </button>
                @elseif($skrk->is_dokumen)
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#EditDokumenSkrkModal">
                        <i class="bx bx-edit"></i> Edit Data Dokumen
                    </button>
                    @teleport('body')
                        @livewire('admin.permohonan.skrk.analis.skrk-dokumen-analis-edit', ['permohonan_id' => $skrk->permohonan->id, 'skrk_id' => $skrk->id])
                    @endteleport
                @endif

                @if ($skrk->is_survey)
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#UploadBerkasAnalisaModal">
                        <i class="bx bx-cloud-upload"></i> Berkas Analisa
                    </button>
                @endif

                @if ($skrk->is_dokumen)
                    <button type="button" class="btn {{ $skrk->is_analis ? 'btn-primary' : 'btn-warning' }}"
                        data-bs-toggle="modal" data-bs-target="#selesaiAnalisaModal"
                        {{ $skrk->is_analis ? 'disabled' : '' }}>
                        <i class="bx bx-check"></i> Selesai Analisa
                    </button>
                @endif
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between bg-secondary">
                    <h5 class="mb-0 text-white">Data Kajian Analisa SKRK</h5>
                </div>
                <div class="card-body mt-3">
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="luas_permohonan">
                            Luas Permohonan
                        </label>
                        <div class="col-sm-8">
                            <input id="luas_permohonan" class="form-control"
                                value="{{ $skrk->permohonan->luas_tanah }} m2" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="penguasaan_tanah">
                            Informasi Penguasaan Tanah
                        </label>
                        <div class="col-sm-8">
                            <input id="penguasaan_tanah" class="form-control" value="{{ $skrk->penguasaan_tanah }}"
                                readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="ada_bangunan">
                            Ada Bangunan
                        </label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <input id="ada_bangunan" class="form-control" value="{{ $skrk->ada_bangunan }}"
                                    readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="jml_bangunan">
                            Jumlah Bangunan
                        </label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <input id="jml_bangunan" class="form-control" value="{{ $skrk->jml_bangunan }} Unit"
                                    readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="jml_lantai">
                            Rencana Lantai Bangunan
                        </label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <input id="jml_lantai" class="form-control" value="{{ $skrk->jml_lantai }} Lantai"
                                    readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="luas_lantai">
                            Rencana Luas Lantai Bangunan
                        </label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <input id="luas_lantai" class="form-control" value="{{ $skrk->luas_lantai }} m2"
                                    readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="kedalaman_min">
                            Kedalaman/Ketinggian Minimal
                        </label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <input id="kedalaman_min" class="form-control" value="{{ $skrk->kedalaman_min }} Meter"
                                    readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="kedalaman_max">
                            Kedalaman/Ketinggian Maksimal
                        </label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <input id="kedalaman_max" class="form-control" value="{{ $skrk->kedalaman_max }} Meter"
                                    readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between bg-secondary">
                    <h5 class="mb-0 text-white">Download Template Berkas</h5>
                </div>
                <div class="card-body mt-3">
                    <div class="row mb-3">
                        <button type="button" class="btn btn-primary" wire:click="download2a">
                            Template 2A (BA Rapat FPR)
                        </button>
                    </div>
                    <div class="row mb-3">
                        <button type="button" class="btn btn-primary" wire:click="download2b">
                            Template 2B (Notulensi Rapat FPR)
                        </button>
                    </div>
                    <div class="row mb-3">
                        <button type="button" class="btn btn-primary" wire:click="download3">
                            Template 3 (Kajian SKRK)
                        </button>
                    </div>
                    <div class="row mb-3">
                        <button type="button" class="btn btn-primary" wire:click="download4">
                            Template 4 (Dokumen SKRK)
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between bg-secondary">
                    <h5 class="mb-0 text-white">Data Dokumen SKRK</h5>
                </div>
                <div class="card-body mt-3">
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="luas_disetujui">
                            Luas Disetujui
                        </label>
                        <div class="col-sm-8">
                            <input id="luas_disetujui" class="form-control" value="{{ $skrk->luas_disetujui }} m2"
                                readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="pemanfaatan_ruang">
                            Jenis Peruntukan Pemanfaatan Ruang
                        </label>
                        <div class="col-sm-8">
                            <input id="pemanfaatan_ruang" class="form-control"
                                value="{{ $skrk->pemanfaatan_ruang }}" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="peraturan_zonasi">
                            Peraturan Zonasi
                        </label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <input id="peraturan_zonasi" class="form-control"
                                    value="{{ $skrk->peraturan_zonasi }}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="kbli_diizinkan">
                            Kode KBLI Diizinkan
                        </label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <input id="kbli_diizinkan" class="form-control" value="{{ $skrk->kbli_diizinkan }}"
                                    readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="kdb">
                            Koefisien Dasar Bangunan (KDB) Maksimum
                        </label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <input id="kdb" class="form-control" value="{{ $skrk->kdb }}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="klb">
                            Koefisien Lantai Bangunan (KLB)
                        </label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <input id="klb" class="form-control" value="{{ $skrk->klb }}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="gsb">
                            Garis Sempadan Bangunan (GSB)
                        </label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <input id="gsb" class="form-control" value="{{ $skrk->gsb }} Meter"
                                    readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="jba">
                            Jarak Bebas Antar Bangunan (JBA) Minimum
                        </label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <input id="jba" class="form-control" value="{{ $skrk->jba }} Meter"
                                    readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="jbb">
                            Jarak Bebas Belakang (JBB) Minimum
                        </label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <input id="jbb" class="form-control" value="{{ $skrk->jbb }} Meter"
                                    readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="kdh">
                            Koefisien Dasar Hijau (KDH) Minimum
                        </label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <input id="kdh" class="form-control" value="{{ $skrk->kdh }}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="ktb">
                            Koefisien Tapak Basement (KTB)
                        </label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <input id="ktb" class="form-control" value="{{ $skrk->ktb }}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="luas_kavling">
                            Luas kavling Minimum
                        </label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <input id="luas_kavling" class="form-control" value="{{ $skrk->luas_kavling }} m2"
                                    readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="jaringan_utilitas">
                            Jaringan Utilitas Kota
                        </label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <input id="jaringan_utilitas" class="form-control"
                                    value="{{ $skrk->jaringan_utilitas }}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="persyaratan_pelaksanaan">
                            Persyaratan Pelaksanaan Kegiatan Pemanfaatan Ruang
                        </label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <input id="persyaratan_pelaksanaan" class="form-control"
                                    value="{{ $skrk->persyaratan_pelaksanaan }}" readonly>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="selesaiAnalisaModal" data-bs-backdrop="static" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">
                        Proses Analisa Selesai
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Pastikan seluruh data dan berkas analisa sudah terunggah.
                    Lanjutkan ke proses verifikasi oleh Supervisor?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                        Tidak
                    </button>
                    <button type="button" class="btn btn-primary" wire:click="selesaiAnalisa">
                        Ya
                    </button>
                </div>
            </div>
        </div>
    </div>

    @teleport('body')
        @livewire('admin.permohonan.skrk.analis.skrk-kajian-analis-create', ['permohonan_id' => $skrk->permohonan->id, 'skrk_id' => $skrk->id])
    @endteleport
    @teleport('body')
        @livewire('admin.permohonan.skrk.analis.skrk-dokumen-analis-create', ['permohonan_id' => $skrk->permohonan->id, 'skrk_id' => $skrk->id])
    @endteleport
    @teleport('body')
        @livewire('admin.permohonan.skrk.analis.upload-berkas', ['permohonan_id' => $skrk->permohonan->id, 'skrk_id' => $skrk->id])
    @endteleport
</div>
