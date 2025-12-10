<div>
    @if($kkprnb->no_ptp == null && $kkprnb->berkas_ptp == null)
        <div class="alert alert-danger ">
           <span class="fw-bold fs-5">Perhatian!</span><br>
           Data Dokumen PTP belum diupload, harap upload terlebih dahulu untuk dapat melanjutkan ke proses Analis.
        </div>
    @endif
    <div class="mb-3">
        <div class="d-flex flex-wrap gap-3">
            @can('manageAnalis', $kkprnb->permohonan)
                @if($kkprnb->no_ptp != null && $kkprnb->berkas_ptp != null)                
                    @if (!$kkprnb->is_kajian)
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#AddKajianKkprnbModal">
                            <i class="bx bx-plus"></i> Data Kajian
                        </button>
                    @elseif(!$kkprnb->is_kajian)
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#EditKajianKkprnbModal">
                            <i class="bx bx-edit"></i> Edit Data Kajian
                        </button>
                        @teleport('body')
                            @livewire('admin.permohonan.kkprnb.analis.kkprnb-kajian-analis-edit', ['permohonan_id' => $kkprnb->permohonan->id, 'kkprnb_id' => $kkprnb->id])
                        @endteleport
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#UploadBerkasAnalisaKkprnbModal">
                            <i class="bx bx-cloud-upload"></i> Berkas Analis
                        </button>
                    @endif
                    <button type="button" class="btn {{ $kkprnb->is_kajian ? 'btn-success' : 'btn-danger' }}"
                        wire:loading.attr="disabled" data-bs-toggle="modal" data-bs-target="#selesaiAnalisaModal"
                        {{ $kkprnb->is_kajian || !$kkprnb->is_berkas_analis_uploaded ? 'disabled' : '' }}>
                        @if ($kkprnb->is_kajian)
                            <i class="bx bx-check"></i> Selesai Analisa
                        @else
                            <i class="bx bx-x"></i> Belum Selesai Analisa
                        @endif
                    </button>
                @endif
            @endcan
        </div>
    </div>
    
    <div class="row">
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between bg-secondary">
                    <h5 class="mb-0 text-white">Data Dokumen KKPR Non Berusaha</h5>
                </div>
                <div class="card-body mt-3">
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="jenis_kkprnb">
                            Jenis KKPRNB
                        </label>
                        <div class="col-sm-8">
                            <input id="jenis_kkprnb" class="form-control" value="{{ $kkprnb->jenis_kkprnb }}" readonly>
                        </div>
                    </div>
                    @if ($kkprnb->jenis_kkprnb == 'KKPRNB')
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label" for="penguasaan_tanah">
                                Penguasaan Tanah
                            </label>
                            <div class="col-sm-8">
                                <input id="penguasaan_tanah" class="form-control" value="{{ $kkprnb->penguasaan_tanah }}"
                                    readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label" for="pemanfaatan_ruang">
                                Jenis Peruntukan Pemanfaatan Ruang
                            </label>
                            <div class="col-sm-8">
                                <input id="pemanfaatan_ruang" class="form-control" value="{{ $kkprnb->pemanfaatan_ruang }}"
                                    readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label" for="peraturan_zonasi">
                                Peraturan Zonasi
                            </label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <input id="peraturan_zonasi" class="form-control"
                                        value="{{ $kkprnb->peraturan_zonasi }}" readonly>
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
                                        value="{{ $kkprnb->persyaratan_pelaksanaan }}" readonly>
                                </div>
                            </div>
                        </div>
                    @elseif($kkprnb->jenis_kkprnb == 'ITR-KKKPR')
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label" for="no_kkkpr">
                                No KKKPR
                            </label>
                            <div class="col-sm-8">
                                <input id="no_kkkpr" class="form-control" value="{{ $kkprnb->no_kkkpr }}" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label" for="skala_usaha">
                                Skala Usaha
                            </label>
                            <div class="col-sm-8">
                                <input id="skala_usaha" class="form-control" value="{{ $kkprnb->skala_usaha }}" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label" for="luas_disetujui">
                                Luas Disetujui
                            </label>
                            <div class="col-sm-8">
                                <input id="luas_disetujui" class="form-control" value="{{ $kkprnb->luas_disetujui }} m2"
                                    readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label" for="pemanfaatan_ruang">
                                Jenis Peruntukan Pemanfaatan Ruang
                            </label>
                            <div class="col-sm-8">
                                <input id="pemanfaatan_ruang" class="form-control"
                                    value="{{ $kkprnb->pemanfaatan_ruang }}" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label" for="peraturan_zonasi">
                                Peraturan Zonasi
                            </label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <input id="peraturan_zonasi" class="form-control"
                                        value="{{ $kkprnb->peraturan_zonasi }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label" for="kdb">
                                Koefisien Dasar Bangunan (KDB) Maksimum
                            </label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <input id="kdb" class="form-control" value="{{ $kkprnb->kdb }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label" for="klb">
                                Koefisien Lantai Bangunan (KLB)
                            </label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <input id="klb" class="form-control" value="{{ $kkprnb->klb }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label" for="gsb">
                                Garis Sempadan Bangunan (GSB)
                            </label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <input id="gsb" class="form-control" value="{{ $kkprnb->gsb }} Meter"
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
                                    <input id="jba" class="form-control" value="{{ $kkprnb->jba }} Meter"
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
                                    <input id="jbb" class="form-control" value="{{ $kkprnb->jbb }} Meter"
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
                                    <input id="kdh" class="form-control" value="{{ $kkprnb->kdh }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label" for="ktb">
                                Koefisien Tapak Basement (KTB)
                            </label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <input id="ktb" class="form-control" value="{{ $kkprnb->ktb }}" readonly>
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
                                        value="{{ $kkprnb->luas_kavling }} m2" readonly>
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
                                        value="{{ $kkprnb->jaringan_utilitas }}" readonly>
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
                                        value="{{ $kkprnb->persyaratan_pelaksanaan }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label" for="persyaratan_pelaksanaan">
                                Dokumen KKKPR
                            </label>
                            <div class="col-sm-8">
                                <a href="{{ $kkprnb->dokumen_kkkpr ? asset('storage/' . $kkprnb->dokumen_kkkpr) : 'javascript:void(0)' }}"
                                    target="_blank" type="button" class="btn btn-primary m-1">
                                    Lihat Dokumen
                                </a>
                            </div>
                        </div>
                    @endif
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
                        <button type="button" class="btn btn-primary" wire:click="download3b">
                            Template 3B (BA Rapat FPR KKKPR Non Berusaha)
                        </button>
                    </div>
                    <div class="row mb-3">
                        <button type="button" class="btn btn-primary" wire:click="download3c">
                            Template 3C (Notulensi Rapat FPR KKKPR Non Berusaha)
                        </button>
                    </div>
                    <div class="row mb-3">
                        <button type="button" class="btn btn-primary" wire:click="download3d">
                            Template 3D (Kajian KKKPR Non Berusaha)
                        </button>
                    </div>
                    <div class="row mb-3">
                        <button type="button" class="btn btn-primary" wire:click="download4">
                            Template 4 (Nota Dinas KKKPR Non Berusaha)
                        </button>
                    </div>
                    <div class="row mb-3">
                        <button type="button" class="btn btn-primary" wire:click="download5">
                            Template 5 (Rekomendasi KKKPR Non Berusaha)
                        </button>
                    </div>
                    <div class="row mb-3">
                        <button type="button" class="btn btn-primary" wire:click="download6">
                            Template 6 (Format Persetujuan KKKPR Non Berusaha)
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
        @livewire('admin.permohonan.kkprnb.analis.kkprnb-kajian-analis-create', ['permohonan_id' => $kkprnb->permohonan->id, 'kkprnb_id' => $kkprnb->id])
    @endteleport
    @teleport('body')
        @livewire('admin.permohonan.kkprnb.analis.upload-berkas', ['permohonan_id' => $kkprnb->permohonan->id, 'kkprnb_id' => $kkprnb->id])
    @endteleport
</div>
