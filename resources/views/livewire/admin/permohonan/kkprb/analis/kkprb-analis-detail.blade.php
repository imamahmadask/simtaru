<div>
    <div class="mb-3">
        <div class="d-flex flex-wrap gap-3">
            @can('manageAnalis', $kkprb->permohonan)
                {{-- Mulai Kerjakan Button --}}
                @if ($disposisiAnalis && !$disposisiAnalis->tgl_mulai_kerja && !$kkprb->is_analis)
                    <button type="button" class="btn btn-success" wire:click="mulaiKerja"
                        wire:confirm="Mulai mengerjakan Analisis? Waktu mulai akan dicatat.">
                        <i class="bx bx-play-circle"></i> Mulai Kerjakan
                    </button>
                @elseif ($kkprb->is_analis || ($disposisiAnalis && $disposisiAnalis->tgl_mulai_kerja))
                    <span class="badge bg-success p-2">
                        <i class="bx bx-check-circle"></i> Dikerjakan sejak: {{ \Carbon\Carbon::parse($disposisiAnalis->tgl_mulai_kerja)->format('d-m-Y H:i') }}
                    </span>
                @endif

                @php
                    $showButtons = true;
                    if ($kkprb->rdtr_rtrw == 'RTRW') {
                        $showButtons = ($kkprb->no_ptp != null && $kkprb->berkas_ptp != null);
                    }
                @endphp
                @if($showButtons)
                    @if (!$kkprb->is_analis && $disposisiAnalis && $disposisiAnalis->tgl_mulai_kerja)
                        @if (!$kkprb->is_kajian && $kkprb->is_survey)
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#AddKajianKkprbModal">
                                <i class="bx bx-plus"></i> Data Kajian
                            </button>
                        @elseif($kkprb->is_kajian && !$kkprb->is_analis)
                            <button type="button"
                                wire:click="$dispatch('kkprb-kajian-edit', { permohonan_id: {{ $kkprb->permohonan->id }}, kkprb_id: {{ $kkprb->id }} })"
                                class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#EditKajianKkprbModal">
                                <i class="bx bx-edit"></i> Edit Data Kajian
                            </button>
                            @teleport('body')
                                @livewire('admin.permohonan.kkprb.analis.kkprb-kajian-analis-edit', [], key('kkprb-kajian-edit-'.$kkprb->id))
                            @endteleport
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#UploadBerkasAnalisaKkprbModal">
                                <i class="bx bx-cloud-upload"></i> Berkas Analis
                            </button>
                        @endif
                    @endif
                    @if ($kkprb->is_analis || ($disposisiAnalis && $disposisiAnalis->tgl_mulai_kerja))
                        <button type="button" class="btn {{ $kkprb->is_analis ? 'btn-success' : 'btn-danger' }}"
                            wire:loading.attr="disabled" data-bs-toggle="modal" data-bs-target="#selesaiAnalisaModal"
                            {{ $kkprb->is_analis || !$kkprb->is_berkas_analis_uploaded ? 'disabled' : '' }}>
                            @if ($kkprb->is_analis)
                                <i class="bx bx-check"></i> Selesai Analisa
                            @else
                                <i class="bx bx-x"></i> Belum Selesai Analisa
                            @endif
                        </button>
                    @endif
                @endif
            @endcan
        </div>
    </div>
    
    <div class="row">
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between bg-secondary">
                    <h5 class="mb-0 text-white">Data Analisa KKPR Berusaha</h5>
                </div>
                <div class="card-body mt-3">                    
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="tgl_oss">
                            Tanggal Permohonan Masuk OSS
                        </label>
                        <div class="col-sm-8">
                            <input id="tgl_oss" class="form-control" value="{{ $kkprb->tgl_oss ? date('d-m-Y', strtotime($kkprb->tgl_oss)) : '' }}"
                                readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="oss_id">
                            OSS ID
                        </label>
                        <div class="col-sm-8">
                            <input id="oss_id" class="form-control" value="{{ $kkprb->oss_id }}"
                                readonly>
                        </div>
                    </div>                    
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="id_proyek">
                            ID Proyek
                        </label>
                        <div class="col-sm-8">
                            <input id="id_proyek" class="form-control" value="{{ $kkprb->id_proyek }}"
                                readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="luas_disetujui">
                            Luas Disetujui
                        </label>
                        <div class="col-sm-8">
                            <input id="luas_disetujui" class="form-control" value="{{ $kkprb->luas_disetujui }}"
                                readonly>
                        </div>
                    </div>                                       
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="skala_usaha">
                            Skala Usaha
                        </label>
                        <div class="col-sm-8">
                            <input id="skala_usaha" class="form-control" value="{{ $kkprb->skala_usaha }}"
                                readonly>
                        </div>
                    </div>                    
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="jenis_usaha">
                            Jenis Usaha
                        </label>
                        <div class="col-sm-8">
                            <input id="jenis_usaha" class="form-control" value="{{ $kkprb->jenis_usaha }}"
                                readonly>
                        </div>
                    </div>                    
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="nib">
                            NIB
                        </label>
                        <div class="col-sm-8">
                            <input id="nib" class="form-control" value="{{ $kkprb->nib }}"
                                readonly>
                        </div>
                    </div>                    
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="penguasaan_tanah">
                            Penguasaan Tanah
                        </label>
                        <div class="col-sm-8">
                            <input id="penguasaan_tanah" class="form-control" value="{{ $kkprb->penguasaan_tanah }}"
                                readonly>
                        </div>
                    </div>                    
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="jml_bangunan">
                            Jumlah Bangunan
                        </label>
                        <div class="col-sm-8">
                            <input id="jml_bangunan" class="form-control" value="{{ $kkprb->jml_bangunan }}"
                                readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="jml_lantai">
                            Jumlah Lantai
                        </label>
                        <div class="col-sm-8">
                            <input id="jml_lantai" class="form-control" value="{{ $kkprb->jml_lantai }}"
                                readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="luas_lantai">
                            Luas Lantai
                        </label>
                        <div class="col-sm-8">
                            <input id="luas_lantai" class="form-control" value="{{ $kkprb->luas_lantai }}"
                                readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="kedalaman_min">
                            Kedalaman Minimum
                        </label>
                        <div class="col-sm-8">
                            <input id="kedalaman_min" class="form-control" value="{{ $kkprb->kedalaman_min }}"
                                readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="kedalaman_max">
                            Kedalaman Maximum
                        </label>
                        <div class="col-sm-8">
                            <input id="kedalaman_max" class="form-control" value="{{ $kkprb->kedalaman_max }}"
                                readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="ketinggian_min">
                            Ketinggian Minimum
                        </label>
                        <div class="col-sm-8">
                            <input id="ketinggian_min" class="form-control" value="{{ $kkprb->ketinggian_min }}"
                                readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="ketinggian_max">
                            Ketinggian Maximum
                        </label>
                        <div class="col-sm-8">
                            <input id="ketinggian_max" class="form-control" value="{{ $kkprb->ketinggian_max }}"
                                readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="indikasi_program">
                            Indikasi Program
                        </label>
                        <div class="col-sm-8">
                            <input id="indikasi_program" class="form-control" value="{{ $kkprb->indikasi_program }}"
                                readonly>
                        </div>
                    </div>                                                        
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="kdb">
                            Koefisien Dasar Bangunan (KDB) Maksimum
                        </label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <input id="kdb" class="form-control" value="{{ $kkprb->kdb }}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="klb">
                            Koefisien Lantai Bangunan (KLB)
                        </label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <input id="klb" class="form-control" value="{{ $kkprb->klb }}" readonly>
                            </div>
                        </div>
                    </div>                                    
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="kdh">
                            Koefisien Dasar Hijau (KDH) Minimum
                        </label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <input id="kdh" class="form-control" value="{{ $kkprb->kdh }}" readonly>
                            </div>
                        </div>
                    </div>                      
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="gsb">
                            Garis Sempadan Bangunan (GSB)
                        </label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <input id="gsb" class="form-control" value="{{ $kkprb->gsb }}" readonly>
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
                        <button type="button" class="btn btn-primary" wire:click="download2a">
                            Template 2A (BA Rapat FPR KKKPR Berusaha)
                        </button>
                    </div>
                    <div class="row mb-3">
                        <button type="button" class="btn btn-primary" wire:click="download2b">
                            Template 2B (Notulensi Rapat FPR KKKPR Berusaha)
                        </button>
                    </div>
                    <div class="row mb-3">
                        <button type="button" class="btn btn-primary" wire:click="download3">
                            Template 3 (Kajian KKKPR Berusaha)
                        </button>
                    </div>
                    <div class="row mb-3">
                        <button type="button" class="btn btn-primary" wire:click="download4">
                            Template 4 (Nota Dinas KKKPR Berusaha)
                        </button>
                    </div>
                    <div class="row mb-3">
                        <button type="button" class="btn btn-primary" wire:click="download5">
                            Template 5 (Rekomendasi KKKPR Berusaha)
                        </button>
                    </div>
                    <div class="row mb-3">
                        <button type="button" class="btn btn-primary" wire:click="download6">
                            Template 6 (Format Persetujuan KKKPR Berusaha)
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
        @livewire('admin.permohonan.kkprb.analis.kkprb-analis-create', ['permohonan_id' => $kkprb->permohonan->id, 'kkprb_id' => $kkprb->id], key('kkprb-kajian-create-'.$kkprb->id))
    @endteleport
    @teleport('body')
        @livewire('admin.permohonan.kkprb.analis.upload-berkas', ['permohonan_id' => $kkprb->permohonan->id, 'kkprb_id' => $kkprb->id], key('kkprb-analis-upload-berkas-'.$kkprb->id))
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
    