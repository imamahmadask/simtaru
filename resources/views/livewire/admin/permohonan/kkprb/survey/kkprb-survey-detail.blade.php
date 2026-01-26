<div>
    <div class="mb-3">
        <div class="d-flex flex-wrap gap-3">
            @can('manageSurvey', $kkprb->permohonan)
                @if (!$kkprb->is_survey)
                    @if ($kkprb->tgl_survey)
                        {{-- Actions available AFTER survey date is set --}}
                        <button type="button"
                            wire:click="$dispatch('kkprb-survey-edit', { permohonan_id: {{ $kkprb->permohonan->id }}, kkprb_id: {{ $kkprb->id }} })"
                            class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#EditSurveyKkprbModal">
                            <i class="bx bx-edit"></i> Edit Survey
                        </button>
                        @teleport('body')
                            @livewire('admin.permohonan.kkprb.survey.kkprb-survey-edit', ['permohonan_id' => $kkprb->permohonan->id, 'kkprb_id' => $kkprb->id], key('kkprb-survey-edit-'.$kkprb->id))
                        @endteleport
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#UploadBerkasSurveyKkprbModal">
                            <i class="bx bx-cloud-upload"></i> Berkas Survey
                        </button>

                        @if ($cek_disposisi)
                            <button type="button" wire:click="$dispatch('disposisi-edit', { id: {{ $cek_disposisi->id }} })"
                                class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editDisposisiModal">
                                <i class="bx bx-edit"></i> Disposisi
                            </button>
                            @teleport('body')
                                @livewire('admin.disposisi.disposisi-edit', [], key('disposisi-edit-kkprb-'.$kkprb->id))
                            @endteleport
                        @else
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#AddDisposisiModal">
                                <i class="bx bx-plus"></i> Disposisi
                            </button>
                        @endif
                    @else
                        {{-- Action available BEFORE survey date is set --}}
                        <button type="button"
                            wire:click="$dispatch('kkprb-survey-hold', { kkprb_id: {{ $kkprb->id }} })"
                            class="{{ $kkprb->is_survey_hold ? 'btn btn-warning' : 'btn btn-success' }}" data-bs-toggle="modal" data-bs-target="#HoldSurveyKkprbModal">
                            @if ($kkprb->is_survey_hold) 
                                <i class="bx bx-pause-circle"></i> Unhold Survey 
                            @else 
                                <i class="bx bx-play-circle"></i> Hold Survey 
                            @endif
                        </button>

                        @if (!$kkprb->is_survey_hold)
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#AddSurveyKkprbModal">
                                <i class="bx bx-plus"></i> Add Survey
                            </button>
                        @endif
                    @endif                    
                @endif
                @if ($cek_disposisi)
                    <button type="button" class="btn {{ $kkprb->is_survey ? 'btn-success' : 'btn-danger' }}"
                        wire:loading.attr="disabled" data-bs-toggle="modal" data-bs-target="#selesaiSurveyModal"
                        {{ $kkprb->is_survey || !$kkprb->is_berkas_survey_uploaded ? 'disabled' : '' }}>
                        @if ($kkprb->is_survey)
                            <i class="bx bx-check"></i> Selesai Survey
                        @else
                            <i class="bx bx-x"></i> Belum Selesai Survey
                        @endif
                    </button>
                @endif
            @endcan
        </div>
    </div>

    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between bg-secondary">
                    <h5 class="mb-0 text-white">Data Survey KKPR Berusaha</h5>
                </div>
                <div class="card-body mt-3">
                    <div class="row">
                        <label class="col-sm-4 col-form-label" for="tgl_survey">
                            Tgl Survey
                        </label>
                        <div class="col-sm-8  mb-3">
                            <input id="tgl_survey" class="form-control"
                                value="{{ $kkprb->tgl_survey ? date('d-m-Y', strtotime($kkprb->tgl_survey)) : '' }}"
                                readonly>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-4 col-form-label" for="ada_bangunan">
                            Ada Bangunan
                        </label>
                        <div class="col-sm-8  mb-3">
                            <input id="ada_bangunan" class="form-control" value="{{ $kkprb->ada_bangunan }}" readonly>
                        </div>
                    </div>

                    <div class="row">
                        <label class="col-sm-4 col-form-label" for="status_jalan">
                            Status Jalan
                        </label>
                        <div class="col-sm-8  mb-3">
                            <input id="status_jalan" class="form-control" value="{{ $kkprb->status_jalan }}" readonly>
                        </div>
                    </div>

                    <div class="row">
                        <label class="col-sm-4 col-form-label" for="fungsi_jalan">
                            Fungsi Jalan
                        </label>
                        <div class="col-sm-8  mb-3">
                            <input id="fungsi_jalan" class="form-control" value="{{ $kkprb->fungsi_jalan }}" readonly>
                        </div>
                    </div>

                    <div class="row">
                        <label class="col-sm-4 col-form-label" for="tipe_jalan">
                            Tipe Jalan
                        </label>
                        <div class="col-sm-8  mb-3">
                            <input id="tipe_jalan" class="form-control" value="{{ $kkprb->tipe_jalan }}" readonly>
                        </div>
                    </div>

                    <div class="row">
                        <label class="col-sm-4 col-form-label" for="median_jalan">
                            Median Jalan
                        </label>
                        <div class="col-sm-8  mb-3">
                            <input id="median_jalan" class="form-control" value="{{ $kkprb->median_jalan }}" readonly>
                        </div>
                    </div>

                    <div class="row">
                        <label class="col-sm-4 col-form-label" for="lebar_jalan">
                            Lebar Jalan
                        </label>
                        <div class="col-sm-8  mb-3">
                            <input id="lebar_jalan" class="form-control" value="{{ $kkprb->lebar_jalan }} m2" readonly>
                        </div>
                    </div>

                    <div class="row">
                        <label class="col-sm-4 col-form-label" for="pola_ruang">
                            Pola Ruang
                        </label>
                        <div class="col-sm-8  mb-3">
                            <input id="pola_ruang" class="form-control" value="{{ $kkprb->pola_ruang }}"
                                readonly>
                        </div>
                    </div>

                    <div class="row">
                        <label class="col-sm-4 col-form-label" for="koordinat">
                            Koordinat
                        </label>

                        <div class="table text-nowrap mb-3">
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>X</th>
                                        <th>Y</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($kkprb->koordinat)
                                        @foreach ($kkprb->koordinat as $i => $point)
                                            <tr>
                                                <td>{{ $i + 1 }}</td>
                                                <td>{{ $point['x'] }}</td>
                                                <td>{{ $point['y'] }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="mb-3">
                        <span class="fs-5">Batas Persil</span>
                    </div>
                    @if ($kkprb->batas_persil)
                        <div class="row">
                            <label class="col-sm-4 col-form-label" for="utara">
                                Batas Utara
                            </label>
                            <div class="col-sm-8  mb-3">
                                <input id="utara" class="form-control"
                                    value="{{ $kkprb->batas_persil['utara'] ?? '' }}" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-4 col-form-label" for="selatan">
                                Batas Selatan
                            </label>
                            <div class="col-sm-8  mb-3">
                                <input id="selatan" class="form-control"
                                    value="{{ $kkprb->batas_persil['selatan'] ?? '' }}" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-4 col-form-label" for="timur">
                                Batas Timur
                            </label>
                            <div class="col-sm-8  mb-3">
                                <input id="timur" class="form-control"
                                    value="{{ $kkprb->batas_persil['timur'] ?? '' }}" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-4 col-form-label" for="barat">
                                Batas Barat
                            </label>
                            <div class="col-sm-8  mb-3">
                                <input id="barat" class="form-control"
                                    value="{{ $kkprb->batas_persil['barat'] ?? '' }}" readonly>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between bg-secondary">
                    <h5 class="mb-0 text-white">Download Template Berkas</h5>
                </div>
                <div class="card-body mt-3">
                    <div class="row mb-3">
                        <button type="button" class="btn btn-primary" wire:click="download1">
                            Template 1 (BA Pemeriksaan Lapangan)
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-6">
            <h5>Foto Survey</h5>
            @if ($kkprb->foto_survey != null)
                @foreach (json_decode($kkprb->foto_survey) as $item)
                    <img src="{{ asset('storage/' . $item) }}" alt="" width="200px"
                        class="img-fluid mb-1">
                @endforeach
            @endif

            <h5 class="mt-5">Gambar Peta</h5>
            @if ($kkprb->gambar_peta != null)
                @foreach (json_decode($kkprb->gambar_peta) as $item)
                    <img src="{{ asset('storage/' . $item) }}" alt="" width="200px"
                        class="img-fluid mb-1">
                @endforeach
            @endif

        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="selesaiSurveyModal" data-bs-backdrop="static" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">
                        Proses Survey Selesai
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Pastikan seluruh data dan berkas Survey sudah terunggah.<br>
                    Lanjutkan ke proses Analisa?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                        Tidak
                    </button>
                    <button type="button" class="btn btn-primary" wire:click="selesaiSurvey">
                        Ya
                    </button>
                </div>
            </div>
        </div>
    </div>

    @teleport('body')
        @livewire('admin.permohonan.kkprb.survey.kkprb-survey-create', ['permohonan_id' => $kkprb->permohonan->id, 'kkprb_id' => $kkprb->id], key('kkprb-survey-create-'.$kkprb->id))
    @endteleport
    @teleport('body')
        @livewire('admin.permohonan.kkprb.survey.upload-berkas', ['permohonan_id' => $kkprb->permohonan->id, 'kkprb_id' => $kkprb->id], key('kkprb-survey-upload-berkas-'.$kkprb->id))
    @endteleport
    @teleport('body')
        @livewire('admin.disposisi.disposisi-create', ['permohonan_id' => $kkprb->permohonan->id, 'pelayanan_id' => $kkprb->id], key('disposisi-create-kkprb-'.$kkprb->id))
    @endteleport
    @teleport('body')
        @livewire('admin.permohonan.kkprb.survey.kkprb-survey-hold')
    @endteleport
</div>
@script
    <script>
        $wire.on('trigger-close-modal', () => {
            const modal = bootstrap.Modal.getInstance(document.getElementById('selesaiSurveyModal'));
            if (modal) {
                modal.hide();
            }
        });
    </script>
    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('toast', (event) => {
                const {
                    type = 'success', message = 'Berhasil!'
                } = event[0] || event;

                // Pakai Bootstrap 5 Toast (atau SweetAlert2 kalau mau lebih cantik)
                const toastEl = document.createElement('div');
                toastEl.className =
                    `bs-toast toast align-items-center text-white bg-${type === 'error' ? 'danger' : 'success'} bg-${type === 'error' ? 'danger' : 'success'} fade show position-fixed top-0 end-0 m-3`;
                toastEl.style.zIndex = 9999;
                toastEl.setAttribute('role', 'alert');
                toastEl.innerHTML = `
                    <div class="d-flex">
                        <div class="toast-body">
                            <strong>${type === 'success' ? 'Berhasil!' : 'Gagal!'}</strong><br>
                            ${message}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                    </div>
                `;

                document.body.appendChild(toastEl);

                // Init dan tampilkan
                const toast = new bootstrap.Toast(toastEl, {
                    delay: 4000
                });
                toast.show();

                // Hapus dari DOM setelah selesai
                toastEl.addEventListener('hidden.bs.toast', () => toastEl.remove());
            });
        });
    </script>
@endscript
