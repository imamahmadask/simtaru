<div>
    @if($kkprnb->rdtr_rtrw == 'RTRW')
        @if($kkprnb->no_ptp == null && $kkprnb->berkas_ptp == null)
            <div class="alert alert-danger ">
            <span class="fw-bold fs-5">Perhatian!</span><br>
            Data Dokumen PTP belum diupload, harap upload terlebih dahulu untuk dapat melanjutkan ke proses Analis.
            </div>
        @endif
    @endif  
    <div class="mb-3">
        <div class="d-flex flex-wrap gap-3">
            @can('manageAnalis', $kkprnb->permohonan)
                @php
                    $showButtons = true;
                    if ($kkprnb->rdtr_rtrw == 'RTRW') {
                        $showButtons = ($kkprnb->no_ptp != null && $kkprnb->berkas_ptp != null);
                    }
                @endphp
                @if($showButtons)
                    @if (!$kkprnb->is_kajian && $kkprnb->is_survey)
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#AddKajianKkprnbModal">
                            <i class="bx bx-plus"></i> Data Kajian
                        </button>
                    @elseif($kkprnb->is_kajian && !$kkprnb->is_analis)
                        <button type="button" class="btn btn-primary" wire:click="$dispatch('kkprnb-kajian-edit', { permohonan_id: {{ $kkprnb->permohonan->id }}, kkprnb_id: {{ $kkprnb->id }} })" data-bs-toggle="modal"
                            data-bs-target="#EditKajianKkprnbModal">
                            <i class="bx bx-edit"></i> Edit Data Kajian
                        </button>
                        @teleport('body')
                            @livewire('admin.permohonan.kkprnb.analis.kkprnb-kajian-analis-edit', [], key('kkprnb-kajian-edit-'.$kkprnb->id))
                        @endteleport
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#UploadBerkasAnalisaKkprnbModal">
                            <i class="bx bx-cloud-upload"></i> Berkas Analis
                        </button>
                    @endif
                    <button type="button" class="btn {{ $kkprnb->is_analis ? 'btn-success' : 'btn-danger' }}"
                        wire:loading.attr="disabled" data-bs-toggle="modal" data-bs-target="#selesaiAnalisaModal"
                        {{ $kkprnb->is_analis || !$kkprnb->is_berkas_analis_uploaded ? 'disabled' : '' }}>
                        @if ($kkprnb->is_analis)
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
                        <label class="col-sm-4 col-form-label" for="rdtr_rtrw_analis">
                            Jenis KKPRNB
                        </label>
                        <div class="col-sm-8">
                            <input id="rdtr_rtrw_analis" class="form-control" value="{{ $kkprnb->rdtr_rtrw }}" readonly>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="jenis_kegiatan_pemanfaatan">
                            Jenis Kegiatan Pemanfaatan Ruang
                        </label>
                        <div class="col-sm-8">
                            <input id="jenis_kegiatan_pemanfaatan" class="form-control" value="{{ $kkprnb->jenis_kegiatan }}" readonly>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="penguasaan_tanah">
                            Penguasaan Tanah
                        </label>
                        <div class="col-sm-8">
                            <textarea id="penguasaan_tanah" class="form-control" rows="5" readonly>{{ $kkprnb->penguasaan_tanah }}</textarea>
                        </div>
                    </div>                    
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="jml_bangunan">
                            Jumlah Bangunan
                        </label>
                        <div class="col-sm-8">
                            <input id="jml_bangunan" class="form-control" value="{{ $kkprnb->jml_bangunan }}"
                                readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="jml_lantai">
                            Jumlah Lantai
                        </label>
                        <div class="col-sm-8">
                            <input id="jml_lantai" class="form-control" value="{{ $kkprnb->jml_lantai }} Lantai"
                                readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="luas_lantai">
                            Luas Lantai
                        </label>
                        <div class="col-sm-8">
                            <input id="luas_lantai" class="form-control" value="{{ $kkprnb->luas_lantai }} m2"
                                readonly>
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
                        <label class="col-sm-4 col-form-label" for="kedalaman_min">
                            Kedalaman/Ketinggian Minimum
                        </label>
                        <div class="col-sm-8">
                            <input id="kedalaman_min" class="form-control" value="{{ $kkprnb->kedalaman_min }}"
                                readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="kedalaman_max">
                            Kedalaman/Ketinggian Maximum
                        </label>
                        <div class="col-sm-8">
                            <input id="kedalaman_max" class="form-control" value="{{ $kkprnb->kedalaman_max }}"
                                readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="indikasi_program">
                            Indikasi Program
                        </label>
                        <div class="col-sm-8">
                            <input id="indikasi_program" class="form-control" value="{{ $kkprnb->indikasi_program }}"
                                readonly>
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
                                <textarea id="persyaratan_pelaksanaan" class="form-control" rows="10" readonly>{{ $kkprnb->persyaratan_pelaksanaan }}</textarea>
                            </div>
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
        @livewire('admin.permohonan.kkprnb.analis.kkprnb-kajian-analis-create', ['permohonan_id' => $kkprnb->permohonan->id, 'kkprnb_id' => $kkprnb->id], key('kkprnb-kajian-create-'.$kkprnb->id))
    @endteleport
    @teleport('body')
        @livewire('admin.permohonan.kkprnb.analis.upload-berkas', ['permohonan_id' => $kkprnb->permohonan->id, 'kkprnb_id' => $kkprnb->id], key('kkprnb-analis-upload-berkas-'.$kkprnb->id))
    @endteleport
</div>
@script
    <script>
        $wire.on('trigger-close-modal', () => {
            const modal = bootstrap.Modal.getInstance(document.getElementById('selesaiAnalisaModal'));
            if (modal) {
                modal.hide();
            }
        });
    </script>
@endscript
    