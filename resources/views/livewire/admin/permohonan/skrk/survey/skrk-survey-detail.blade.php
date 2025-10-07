<div>
    <div class="mb-3">
        <div class="d-flex flex-wrap gap-3">
            @can('manageSurvey', $skrk->permohonan)
                @if ($skrk->tgl_survey)
                    {{-- Actions available AFTER survey date is set --}}
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#EditSurveyModal">
                        <i class="bx bx-edit"></i> Edit Survey
                    </button>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#UploadBerkasSurveyModal">
                        <i class="bx bx-cloud-upload"></i> Berkas Survey
                    </button>
                @else
                    {{-- Action available BEFORE survey date is set --}}
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#AddSurveyModal">
                        <i class="bx bx-plus"></i> Add Survey
                    </button>
                @endif
                @if ($skrk->is_survey)
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#AddDisposisiModal">
                        <i class="bx bx-plus"></i> Disposisi
                    </button>
                @endif
                <button type="button" class="btn {{ $skrk->is_survey ? 'btn-success' : 'btn-danger' }}"
                    wire:loading.attr="disabled" data-bs-toggle="modal" data-bs-target="#selesaiSurveyModal"
                    {{ $skrk->is_survey || !$skrk->is_berkas_survey_uploaded ? 'disabled' : '' }}>
                    @if ($skrk->is_survey)
                        <i class="bx bx-check"></i> Selesai Survey
                    @else
                        <i class="bx bx-x"></i> Belum Selesai Survey
                    @endif
                </button>
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
                    <img src="{{ asset('storage/' . $item) }}" alt="" width="200px" class="img-fluid mb-1">
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
        @livewire('admin.permohonan.skrk.survey.skrk-survey-create', ['permohonan_id' => $skrk->permohonan->id, 'skrk_id' => $skrk->id])
    @endteleport
    @teleport('body')
        @livewire('admin.permohonan.skrk.survey.skrk-survey-edit', ['permohonan_id' => $skrk->permohonan->id, 'skrk_id' => $skrk->id])
    @endteleport
    @teleport('body')
        @livewire('admin.permohonan.skrk.survey.upload-berkas', ['permohonan_id' => $skrk->permohonan->id, 'skrk_id' => $skrk->id])
    @endteleport
    @teleport('body')
        @livewire('admin.disposisi.disposisi-create', ['permohonan_id' => $skrk->permohonan->id, 'pelayanan_id' => $skrk->id])
    @endteleport

</div>
