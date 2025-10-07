<div>
    <div wire:ignore.self class="modal fade" id="UploadBerkasSurveyModal" data-bs-backdrop="static" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">
                        Tambah Survey SKRK
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form wire:submit="uploadBerkas">
                    <div class="modal-body">
                        @foreach ($persyaratan_berkas as $item)
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="file_{{ $item->id }}" class="form-label">
                                        Upload {{ $item->nama_berkas }}
                                    </label>
                                    <input type="file" class="form-control" id="file_{{ $item->id }}"
                                        wire:model="file_.{{ $item->kode }}" accept="application/pdf">
                                    @error('file_.' . $item->kode)
                                        <span class="form-text text-xs text-danger">{{ $message }}</span>
                                    @enderror
                                    @php
                                        $uploadedFile = $permohonan->berkas
                                            ->where('persyaratan_berkas_id', $item->id)
                                            ->first();
                                    @endphp

                                    @if ($uploadedFile)
                                        <div class="mt-2">
                                            <a href="{{ asset('storage/' . $uploadedFile->file_path) }}" target="_blank"
                                                class="text-primary">
                                                <i class="bx bx-file"></i> Lihat Berkas
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" class="btn btn-primary">
                            Upload
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
