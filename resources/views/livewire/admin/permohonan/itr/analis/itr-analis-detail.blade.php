<div>
    <div class="mb-3">
        <div class="d-flex flex-wrap gap-3">
            @can('manageAnalis', $itr->permohonan)
                @if (!$itr->is_dokumen)
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#AddDokumenItrModal">
                        <i class="bx bx-plus"></i> Data Analisa
                    </button>
                @elseif(!$itr->is_analis)
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#EditDokumenItrModal">
                        <i class="bx bx-edit"></i> Edit Data Dokumen
                    </button>
                    @teleport('body')
                        @livewire('admin.permohonan.itr.analis.itr-dokumen-analis-edit', ['permohonan_id' => $itr->permohonan->id, 'itr_id' => $itr->id], key('itr-dokumen-edit-'.$itr->id))
                    @endteleport
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#UploadBerkasAnalisaItrModal">
                        <i class="bx bx-cloud-upload"></i> Berkas Analisa
                    </button>
                @endif
                <button type="button" class="btn {{ $itr->is_analis ? 'btn-success' : 'btn-danger' }}"
                    wire:loading.attr="disabled" data-bs-toggle="modal" data-bs-target="#selesaiAnalisaModal"
                    {{ $itr->is_analis || !$itr->is_berkas_analis_uploaded ? 'disabled' : '' }}>
                    @if ($itr->is_analis)
                        <i class="bx bx-check"></i> Selesai Analisa
                    @else
                        <i class="bx bx-x"></i> Belum Selesai Analisa
                    @endif
                </button>
            @endcan
        </div>
    </div>

    <div class="row">
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between bg-secondary">
                    <h5 class="mb-0 text-white">Data Dokumen ITR</h5>
                </div>
                <div class="card-body mt-3">
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="jenis_itr">
                            Jenis ITR
                        </label>
                        <div class="col-sm-8">
                            <input id="jenis_itr" class="form-control" value="{{ $itr->jenis_itr }}" readonly>
                        </div>
                    </div>
                    @if ($itr->jenis_itr == 'ITR')
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label" for="penguasaan_tanah">
                                Penguasaan Tanah
                            </label>
                            <div class="col-sm-8">
                                <textarea id="penguasaan_tanah" class="form-control" rows="5"
                                    readonly>{{ $itr->penguasaan_tanah }}</textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label" for="pemanfaatan_ruang">
                                Jenis Peruntukan Pemanfaatan Ruang
                            </label>
                            <div class="col-sm-8">
                                <input id="pemanfaatan_ruang" class="form-control" value="{{ $itr->pemanfaatan_ruang }}"
                                    readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label" for="peraturan_zonasi">
                                Peraturan Zonasi
                            </label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <textarea id="peraturan_zonasi" class="form-control" rows="5" readonly>{{ $itr->peraturan_zonasi }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label" for="persyaratan_pelaksanaan">
                                Persyaratan Pelaksanaan Kegiatan Pemanfaatan Ruang
                            </label>
                            <div class="col-sm-8">
                                <div class="input-group">                                    
                                    <textarea id="persyaratan_pelaksanaan" class="form-control"
                                    rows="5" readonly>{{ $itr->persyaratan_pelaksanaan }}</textarea>
                                </div>
                            </div>
                        </div>
                    @elseif($itr->jenis_itr == 'ITR-KKKPR')
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label" for="no_kkkpr">
                                No KKKPR
                            </label>
                            <div class="col-sm-8">
                                <input id="no_kkkpr" class="form-control" value="{{ $itr->no_kkkpr }}" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label" for="skala_usaha">
                                Skala Usaha
                            </label>
                            <div class="col-sm-8">
                                <input id="skala_usaha" class="form-control" value="{{ $itr->skala_usaha }}" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label" for="luas_disetujui">
                                Luas Disetujui
                            </label>
                            <div class="col-sm-8">
                                <input id="luas_disetujui" class="form-control" value="{{ $itr->luas_disetujui }} m2"
                                    readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label" for="pemanfaatan_ruang">
                                Jenis Peruntukan Pemanfaatan Ruang
                            </label>
                            <div class="col-sm-8">
                                <input id="pemanfaatan_ruang" class="form-control"
                                    value="{{ $itr->pemanfaatan_ruang }}" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label" for="peraturan_zonasi">
                                Peraturan Zonasi
                            </label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <input id="peraturan_zonasi" class="form-control"
                                        value="{{ $itr->peraturan_zonasi }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label" for="kdb">
                                Koefisien Dasar Bangunan (KDB) Maksimum
                            </label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <input id="kdb" class="form-control" value="{{ $itr->kdb }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label" for="klb">
                                Koefisien Lantai Bangunan (KLB)
                            </label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <input id="klb" class="form-control" value="{{ $itr->klb }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label" for="gsb">
                                Garis Sempadan Bangunan (GSB)
                            </label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <input id="gsb" class="form-control" value="{{ $itr->gsb }} Meter"
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
                                    <input id="jba" class="form-control" value="{{ $itr->jba }} Meter"
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
                                    <input id="jbb" class="form-control" value="{{ $itr->jbb }} Meter"
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
                                    <input id="kdh" class="form-control" value="{{ $itr->kdh }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label" for="ktb">
                                Koefisien Tapak Basement (KTB)
                            </label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <input id="ktb" class="form-control" value="{{ $itr->ktb }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label" for="luas_kavling">
                                Luas kavling Minimum
                            </label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <input id="luas_kavling" class="form-control"
                                        value="{{ $itr->luas_kavling }} m2" readonly>
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
                                        value="{{ $itr->jaringan_utilitas }}" readonly>
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
                                        value="{{ $itr->persyaratan_pelaksanaan }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label" for="persyaratan_pelaksanaan">
                                Dokumen KKKPR
                            </label>
                            <div class="col-sm-8">
                                <a href="{{ $itr->dokumen_kkkpr ? asset('storage/' . $itr->dokumen_kkkpr) : 'javascript:void(0)' }}"
                                    target="_blank" type="button" class="btn btn-primary m-1">
                                    Lihat Dokumen
                                </a>
                            </div>
                        </div>
                    @endif
                    <div class="row mb-3">
                            <label class="col-sm-4 col-form-label" for="keterangan">
                               Keterangan
                            </label>
                            <div class="col-sm-8">
                                <input id="keterangan" class="form-control" value="{{ $itr->keterangan }}" readonly>
                            </div>
                        </div>
                </div>
            </div>
        </div>

        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between bg-secondary">
                    <h5 class="mb-0 text-white">Download Template Berkas</h5>
                </div>
                <div class="card-body mt-3">
                    <div class="row mb-3">
                        <button type="button" class="btn btn-primary" wire:click="download2">
                            Template 2 (Dokumen ITR)
                        </button>
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
                    Pastikan seluruh data dan berkas analisa sudah terunggah.<br>
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
        @livewire('admin.permohonan.itr.analis.itr-dokumen-analis-create', ['permohonan_id' => $itr->permohonan->id, 'itr_id' => $itr->id], key('itr-dokumen-create-'.$itr->id))
    @endteleport
    @teleport('body')
        @livewire('admin.permohonan.itr.analis.upload-berkas', ['permohonan_id' => $itr->permohonan->id, 'itr_id' => $itr->id], key('itr-analis-upload-berkas-'.$itr->id))
    @endteleport
</div>
