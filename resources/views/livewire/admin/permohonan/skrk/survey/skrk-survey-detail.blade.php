<div>
    <div class="mb-3">
        @if (!$skrk->is_survey)
            @if (Auth::user()->role == 'superadmin' || Auth::user()->role == 'supervisor' || Auth::user()->role == 'surveyor')
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#AddSurveyModal">
                    <i class="bx bx-plus"></i> Add Survey
                </button>
            @endif
        @else
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#EditSurveyModal">
                <i class="bx bx-edit"></i> Edit Survey
            </button>
            @teleport('body')
                @livewire('admin.permohonan.skrk.survey.skrk-survey-edit', ['permohonan_id' => $skrk->permohonan->id, 'skrk_id' => $skrk->id])
            @endteleport
        @endif
    </div>

    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between bg-secondary">
                    <h5 class="mb-0 text-white">Data Survey SKRK</h5>
                </div>
                <div class="card-body mt-3">
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="tgl_survey">
                            Tgl Survey
                        </label>
                        @if ($skrk->is_survey)
                            <div class="col-sm-8">
                                <input id="tgl_survey" class="form-control"
                                    value="{{ date('d-m-Y', strtotime($skrk->tgl_survey)) }}" readonly>
                            </div>
                        @endif
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 col-form-label" for="koordinat">
                            Koordinat
                        </label>
                        @if ($skrk->is_survey)
                            <div class="table text-nowrap">
                                <table class="table table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>X</th>
                                            <th>Y</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($skrk->koordinat as $i => $point)
                                            <tr>
                                                <td>{{ $i + 1 }}</td>
                                                <td>{{ $point['x'] }}</td>
                                                <td>{{ $point['y'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
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
            @if ($skrk->foto_survey != null)
                @foreach (json_decode($skrk->foto_survey) as $item)
                    <img src="{{ asset('storage/' . $item) }}" alt="" width="200px" class="mb-3">
                @endforeach

            @endif
        </div>
    </div>
</div>
