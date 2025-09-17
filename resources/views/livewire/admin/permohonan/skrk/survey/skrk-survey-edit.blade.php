<div>
    <div wire:ignore.self class="modal fade" id="EditSurveyModal" data-bs-backdrop="static" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">
                        Edit Survey SKRK
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form wire:submit="EditSurvey">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col mb-3">
                                <label for="tgl_survey" class="form-label">Tanggal Survey</label>
                                <input type="date" class="form-control" wire:model="tgl_survey" id="tgl_survey">
                                @error('tgl_survey')
                                    <span class="form-text text-xs text-danger"> {{ $message }} </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Koordinat</label>

                            @foreach ($koordinat as $i => $point)
                                <div class="row mb-2">
                                    <div class="col">
                                        <input type="text" class="form-control"
                                            wire:model="koordinat.{{ $i }}.x" placeholder="X">
                                        @error("koordinat.$i.x")
                                            <span class="form-text text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control"
                                            wire:model="koordinat.{{ $i }}.y" placeholder="Y">
                                        @error("koordinat.$i.y")
                                            <span class="form-text text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-auto">
                                        <button type="button" class="btn btn-sm btn-danger"
                                            wire:click="removeRow({{ $i }})" @disabled(count($koordinat) <= 4)>
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach

                            <div class="d-flex justify-content-between mt-2">
                                <button type="button" class="btn btn-sm btn-success" wire:click="addRow"
                                    @disabled(count($koordinat) >= 8)>
                                    <i class="bx bx-plus"></i>
                                </button>
                            </div>
                        </div>

                        {{-- @foreach ($persyaratan_berkas as $item)
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="file_.{{ $item->id }}" class="form-label">Upload
                                        {{ $item->nama_berkas }}</label>
                                    <input type="file" class="form-control" wire:model="file_.{{ $item->kode }}"
                                        id="file_.{{ $item->id }}">
                                </div>
                            </div>
                        @endforeach

                        <div class="row">
                            <div class="col mb-3">
                                <label for="foto_survey" class="form-label">Upload Foto Survey</label>
                                <input type="file" class="form-control" wire:model="foto_survey" id="foto_survey"
                                    multiple>
                            </div>
                        </div> --}}

                        {{-- Persyaratan Berkas --}}
                        @foreach ($persyaratan_berkas as $item)
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="file_.{{ $item->id }}" class="form-label">
                                        Upload {{ $item->nama_berkas }}
                                    </label>

                                    {{-- tampilkan file lama jika sudah ada --}}
                                    @if ($item->permohonan_berkas->file_path)
                                        <div class="mb-2">
                                            <a href="{{ Storage::url($item->permohonan_berkas->file_path) }}"
                                                target="_blank" class="btn btn-outline-primary btn-sm">
                                                📄 Lihat Berkas Lama
                                            </a>
                                        </div>
                                    @endif

                                    {{-- input file baru --}}
                                    <input type="file" class="form-control" wire:model="file_.{{ $item->kode }}"
                                        id="file_.{{ $item->id }}" accept="application/pdf">

                                    @error('file_.' . $item->kode)
                                        <span class="form-text text-xs text-danger"> {{ $message }} </span>
                                    @enderror
                                </div>
                            </div>
                        @endforeach

                        {{-- Foto Survey --}}
                        <div class="row">
                            <div class="col mb-3">
                                <label for="foto_survey" class="form-label">Upload Foto Survey</label>
                                {{-- input file baru --}}
                                <input type="file" class="form-control" wire:model="foto_survey" id="foto_survey"
                                    multiple accept="image/*,application/pdf">

                                {{-- tampilkan foto lama jika sudah ada --}}
                                @if (!empty($foto_survey_lama) && count($foto_survey_lama) > 0)
                                    <div class="mb-2">
                                        @foreach ($foto_survey_lama as $foto)
                                            <a href="{{ Storage::url($foto) }}" target="_blank" class="d-block mb-1">
                                                📷 Lihat Foto Survey
                                            </a>
                                        @endforeach
                                    </div>
                                @endif

                            </div>
                        </div>

                        <h5 class="mt-3">Disposisi</h5>

                        <div class="row">
                            <div class="col mb-3">
                                <label for="tahapan_id" class="form-label">Tahapan</label>
                                <select class="form-select" wire:model.live="tahapan_id" name="tahapan_id"
                                    aria-label="Select Tahapan">
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
                                <label for="penerima_id" class="form-label">Penerima Disposisi</label>
                                <select class="form-select" wire:model="penerima_id" name="penerima_id"
                                    aria-label="Select Penerima">
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
                                <label for="catatan" class="form-label">Catatan Disposisi</label>
                                <textarea class="form-control" wire:model="catatan" name="catatan" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" class="btn btn-primary">
                            Edit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
