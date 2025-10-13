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

                            <div class="d-flex justify-content-between mb-3">
                                <button type="button" class="btn btn-sm btn-success" wire:click="addRow"
                                    @disabled(count($koordinat) >= 8)>
                                    <i class="bx bx-plus"></i>
                                </button>
                            </div>

                            <span class="fs-5 mb-1">
                                Batas Persil
                            </span>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="batas_utara" class="form-label">Batas Utara</label>
                                    <input type="text" class="form-control" wire:model="batas_utara"
                                        id="batas_utara">
                                    @error('batas_utara')
                                        <span class="form-text text-xs text-danger"> {{ $message }} </span>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="batas_selatan" class="form-label">Batas Selatan</label>
                                    <input type="text" class="form-control" wire:model="batas_selatan"
                                        id="batas_selatan">
                                    @error('batas_selatan')
                                        <span class="form-text text-xs text-danger"> {{ $message }} </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="batas_timur" class="form-label">Batas Timur</label>
                                    <input type="text" class="form-control" wire:model="batas_timur"
                                        id="batas_timur">
                                    @error('batas_timur')
                                        <span class="form-text text-xs text-danger"> {{ $message }} </span>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="batas_barat" class="form-label">Batas Barat</label>
                                    <input type="text" class="form-control" wire:model="batas_barat"
                                        id="batas_barat">
                                    @error('batas_barat')
                                        <span class="form-text text-xs text-danger"> {{ $message }} </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col mb-3">
                                    <label for="foto_survey" class="form-label">
                                        Upload Foto Survey
                                        <div wire:loading wire:target="foto_survey"
                                            class="spinner-border spinner-border-sm text-primary" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                        {{-- Tanda centang setelah upload selesai --}}
                                        @if (!empty($foto_survey))
                                            <i wire:loading.remove wire:target="foto_survey"
                                                class="bx bx-check-circle text-success"></i>
                                        @endif
                                    </label>
                                    <input type="file" class="form-control" wire:model.blur="foto_survey"
                                        id="foto_survey" multiple accept="image/*">
                                    @error('foto_survey')
                                        <span class="form-text text-xs text-danger"> {{ $message }} </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col mb-3">
                                    <label for="gambar_peta" class="form-label">
                                        Upload Gambar Peta
                                        <div wire:loading wire:target="gambar_peta"
                                            class="spinner-border spinner-border-sm text-primary" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                        {{-- Tanda centang setelah upload selesai --}}
                                        @if (!empty($gambar_peta))
                                            <i wire:loading.remove wire:target="gambar_peta"
                                                class="bx bx-check-circle text-success"></i>
                                        @endif
                                    </label>
                                    <input type="file" class="form-control" wire:model.blur="gambar_peta"
                                        id="gambar_peta" multiple accept="image/*">
                                    @error('gambar_peta')
                                        <span class="form-text text-xs text-danger"> {{ $message }} </span>
                                    @enderror
                                </div>
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
