<div>
    <div class="mb-3">
        <div class="d-flex flex-wrap gap-3">
            @can('manageSurvey', $skrk->permohonan)
                {{-- Mulai Kerjakan Button --}}
                @if ($disposisiSurvey && !$disposisiSurvey->tgl_mulai_kerja && !$skrk->is_survey)
                    <button type="button" class="btn btn-success" wire:click="mulaiKerja"
                        wire:confirm="Mulai mengerjakan Survey? Waktu mulai akan dicatat.">
                        <i class="bx bx-play-circle"></i> Mulai Kerjakan
                    </button>
                @elseif ($disposisiSurvey && $disposisiSurvey->tgl_mulai_kerja && !$skrk->is_survey)
                    <span class="badge bg-success p-2">
                        <i class="bx bx-check-circle"></i> Dikerjakan sejak: {{ \Carbon\Carbon::parse($disposisiSurvey->tgl_mulai_kerja)->format('d-m-Y H:i') }}
                    </span>
                @endif

                @if (!$skrk->is_survey && $disposisiSurvey && $disposisiSurvey->tgl_mulai_kerja)
                    @if ($skrk->tgl_survey)
                        {{-- Actions available AFTER survey date is set --}}
                        <button type="button"
                            wire:click="$dispatch('skrk-survey-edit', { permohonan_id: {{ $skrk->permohonan->id }}, skrk_id: {{ $skrk->id }} })"
                            class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#EditSurveySkrkModal">
                            <i class="bx bx-edit"></i> Edit Survey
                        </button>
                        @teleport('body')
                            @livewire('admin.permohonan.skrk.survey.skrk-survey-edit', ['permohonan_id' => $skrk->permohonan->id, 'skrk_id' => $skrk->id], key('skrk-survey-edit-'.$skrk->id))
                        @endteleport

                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#UploadBerkasSurveySkrkModal">
                            <i class="bx bx-cloud-upload"></i> Berkas Survey
                        </button>
                        @teleport('body')
                            @livewire('admin.permohonan.skrk.survey.upload-berkas', ['permohonan_id' => $skrk->permohonan->id, 'skrk_id' => $skrk->id], key('skrk-survey-upload-berkas-'.$skrk->id))
                        @endteleport

                        @if ($cek_disposisi)
                            <button type="button" wire:click="$dispatch('disposisi-edit', { id: {{ $cek_disposisi->id }} })"
                                class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editDisposisiModal">
                                <i class="bx bx-edit"></i> Disposisi
                            </button>
                            @teleport('body')
                                @livewire('admin.disposisi.disposisi-edit', [], key('disposisi-edit-skrk-'.$skrk->id))
                            @endteleport
                        @else
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#AddDisposisiModal">
                                <i class="bx bx-plus"></i> Disposisi
                            </button>
                        @endif
                    @else
                        {{-- Action available BEFORE survey date is set --}}
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#AddSurveySkrkModal">
                            <i class="bx bx-plus"></i> Add Survey
                        </button>
                    @endif                   
                @endif
                @if ($skrk->is_survey || ($cek_disposisi && $disposisiSurvey && $disposisiSurvey->tgl_mulai_kerja))
                    <button type="button" class="btn {{ $skrk->is_survey ? 'btn-success' : 'btn-danger' }}"
                        wire:loading.attr="disabled" data-bs-toggle="modal" data-bs-target="#selesaiSurveySkrkModal"
                        {{ $skrk->is_survey || !$skrk->is_berkas_survey_uploaded ? 'disabled' : '' }}>
                        @if ($skrk->is_survey)
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
                    <h5 class="mb-0 text-white">Data Survey SKRK</h5>
                </div>
                <div class="card-body mt-3">
                    <div class="row">
                        <label class="col-sm-4 col-form-label" for="tgl_survey">
                            Tgl Survey
                        </label>
                        <div class="col-sm-8  mb-3">
                            <input id="tgl_survey" class="form-control"
                                value="{{ $skrk->tgl_survey ? date('d-m-Y', strtotime($skrk->tgl_survey)) : '' }}"
                                readonly>
                        </div>
                    </div>

                    <div class="row">
                        <label class="col-sm-4 col-form-label" for="status_jalan">
                            Status Jalan
                        </label>
                        <div class="col-sm-8  mb-3">
                            <input id="status_jalan" class="form-control" value="{{ $skrk->status_jalan }}" readonly>
                        </div>
                    </div>

                    <div class="row">
                        <label class="col-sm-4 col-form-label" for="fungsi_jalan">
                            Fungsi Jalan
                        </label>
                        <div class="col-sm-8  mb-3">
                            <input id="fungsi_jalan" class="form-control" value="{{ $skrk->fungsi_jalan }}" readonly>
                        </div>
                    </div>

                    <div class="row">
                        <label class="col-sm-4 col-form-label" for="tipe_jalan">
                            Tipe Jalan
                        </label>
                        <div class="col-sm-8  mb-3">
                            <input id="tipe_jalan" class="form-control" value="{{ $skrk->tipe_jalan }}" readonly>
                        </div>
                    </div>

                    <div class="row">
                        <label class="col-sm-4 col-form-label" for="median_jalan">
                            Median Jalan
                        </label>
                        <div class="col-sm-8  mb-3">
                            <input id="median_jalan" class="form-control" value="{{ $skrk->median_jalan }}" readonly>
                        </div>
                    </div>

                    <div class="row">
                        <label class="col-sm-4 col-form-label" for="lebar_jalan">
                            Lebar Jalan
                        </label>
                        <div class="col-sm-8  mb-3">
                            <input id="lebar_jalan" class="form-control" value="{{ $skrk->lebar_jalan }} m2"
                                readonly>
                        </div>
                    </div>

                    <div class="row">
                        <label class="col-sm-4 col-form-label" for="pola_ruang">
                            Pola Ruang
                        </label>
                        <div class="col-sm-8  mb-3">
                            <input id="pola_ruang" class="form-control" value="{{ $skrk->pola_ruang }}"
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
                                    @if ($skrk->koordinat)
                                        @foreach ($skrk->koordinat as $i => $point)
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
                    @if ($skrk->batas_administratif)
                        <div class="row">
                            <label class="col-sm-4 col-form-label" for="utara">
                                Batas Utara
                            </label>
                            <div class="col-sm-8  mb-3">
                                <input id="utara" class="form-control"
                                    value="{{ $skrk->batas_administratif['utara'] ?? '' }}" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-4 col-form-label" for="selatan">
                                Batas Selatan
                            </label>
                            <div class="col-sm-8  mb-3">
                                <input id="selatan" class="form-control"
                                    value="{{ $skrk->batas_administratif['selatan'] ?? '' }}" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-4 col-form-label" for="timur">
                                Batas Timur
                            </label>
                            <div class="col-sm-8  mb-3">
                                <input id="timur" class="form-control"
                                    value="{{ $skrk->batas_administratif['timur'] ?? '' }}" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-4 col-form-label" for="barat">
                                Batas Barat
                            </label>
                            <div class="col-sm-8  mb-3">
                                <input id="barat" class="form-control"
                                    value="{{ $skrk->batas_administratif['barat'] ?? '' }}" readonly>
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
                        <button type="button" class="btn btn-primary" wire:click="download1a">
                            Template 1A (Form Survey)
                        </button>
                    </div>
                    <div class="row mb-3">
                        <button type="button" class="btn btn-primary" wire:click="download1b">
                            Template 1B (BA Survey)
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-6">
            <h5>Foto Survey</h5>
            @if ($skrk->foto_survey != null)
                @foreach (json_decode($skrk->foto_survey) as $item)
                    <img src="{{ asset('storage/' . $item) }}" alt="" width="200px" class="img-fluid mb-1">
                @endforeach
            @endif

            <h5 class="mt-5">Gambar Peta</h5>
            @if ($skrk->gambar_peta != null)
                @foreach (json_decode($skrk->gambar_peta) as $item)
                    <img src="{{ asset('storage/' . $item) }}" alt="" width="200px"
                        class="img-fluid mb-1">
                @endforeach
            @endif

        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="selesaiSurveySkrkModal" data-bs-backdrop="static" tabindex="-1"
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
        @livewire('admin.permohonan.skrk.survey.skrk-survey-create', ['permohonan_id' => $skrk->permohonan->id, 'skrk_id' => $skrk->id], key('skrk-survey-create-'.$skrk->id))
    @endteleport
    @teleport('body')
        @livewire('admin.disposisi.disposisi-create', ['permohonan_id' => $skrk->permohonan->id, 'pelayanan_id' => $skrk->id], key('disposisi-create-'.$skrk->id))
    @endteleport
</div>
