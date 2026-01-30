<div>
    <div wire:ignore.self class="modal fade" id="UploadBerkasSurveyKkprbModal" data-bs-backdrop="static" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">
                        Tambah Survey KKPR NB
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form wire:submit="uploadBerkas">
                    <div class="modal-body">
                        @foreach ($persyaratan_berkas as $item)
                            <div class="row">
                                <div class="col mb-3">
                                    <div class="d-flex align-items-center">
                                        <label for="file_{{ $item->id }}" class="form-label mb-0 me-2">
                                            Upload {{ $item->nama_berkas }}
                                            {{-- Spinner saat proses upload --}}
                                            <div wire:loading wire:target="file_.{{ $item->kode }}"
                                                class="spinner-border spinner-border-sm text-primary" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                            {{-- Tanda centang setelah upload selesai --}}
                                            @if (!empty($file_[$item->kode]))
                                                <i wire:loading.remove wire:target="file_.{{ $item->kode }}"
                                                    class="bx bx-check-circle text-success"></i>
                                            @endif
                                        </label>
                                    </div>
                                    <input type="file" class="form-control" id="file_{{ $item->id }}"
                                        wire:model="file_.{{ $item->kode }}" accept="application/.doc, .docx">
                                    @error('file_.' . $item->kode)
                                        <span class="form-text text-xs text-danger">{{ $message }}</span>
                                    @enderror

                                    @php
                                        $uploadedFile = $permohonan->berkas
                                            ->where('persyaratan_berkas_id', $item->id)
                                            ->where('versi', 'draft')
                                            ->first();
                                    @endphp

                                    @if ($uploadedFile)
                                        <div class="mt-2 d-flex align-items-center">
                                            {{-- Use the asset() helper for public storage files --}}
                                            <a href="{{ asset('storage/' . $uploadedFile->file_path) }}" target="_blank"
                                                class="text-primary me-3">
                                                <i class="bx bx-file"></i> Lihat Berkas
                                            </a>
                                            <button type="button" class="btn btn-sm btn-outline-danger border-0"
                                                wire:click="deleteBerkas({{ $uploadedFile->id }})"
                                                wire:confirm="Apakah Anda yakin ingin menghapus berkas ini?"
                                                wire:loading.attr="disabled"
                                                wire:target="deleteBerkas({{ $uploadedFile->id }})">
                                                <i class="bx bx-trash" wire:loading.remove
                                                    wire:target="deleteBerkas({{ $uploadedFile->id }})"></i>
                                                <span wire:loading wire:target="deleteBerkas({{ $uploadedFile->id }})"
                                                    class="spinner-border spinner-border-sm" role="status"></span>
                                            </button>
                                        </div>

                                        @if ($uploadedFile->status == 'ditolak')
                                            <div class="mt-2">
                                                <label for="catatan_{{ $item->kode }}"
                                                    class="form-label mb-0 me-2">
                                                    Catatan {{ $item->nama_berkas }}
                                                </label>
                                                <textarea class="form-control" id="catatan_{{ $item->kode }}" 
                                                    wire:model="catatan_.{{ $item->kode }}" rows="3">                                                                                               
                                                </textarea>
                                            </div>
                                        @endif
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
                            <span wire:loading.remove wire:target="uploadBerkas">
                                Upload
                            </span>
                            <span wire:loading wire:target="uploadBerkas" class="spinner-border spinner-border-sm"
                                role="status" aria-hidden="true"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@script
    <script>
        $wire.on('trigger-close-modal', () => {
            const modal = bootstrap.Modal.getInstance(document.getElementById('UploadBerkasSurveyKkprbModal'));
            if (modal) {
                modal.hide();
            }
        });
    </script>
@endscript