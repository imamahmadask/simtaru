<div>
    <div wire:ignore.self class="modal fade" id="AddSurveyModal" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">
                        Tambah Survey SKRK
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form wire:submit="createSurvey">
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

                        @foreach ($persyaratan_berkas as $item)
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
                            Create
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
