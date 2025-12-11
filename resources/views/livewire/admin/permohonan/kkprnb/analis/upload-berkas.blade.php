<div>
    <div wire:ignore.self class="modal fade" id="UploadBerkasAnalisaKkprnbModal" data-bs-backdrop="static" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">
                        Upload Berkas Analisa KKPR Non Berusaha
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
                                            Upload {{ $item->nama_berkas }} {!! $item->wajib ? '<span class="text-danger">*</span>' : '' !!}
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
                                    <input type="file" class="form-control" wire:model="file_.{{ $item->kode }}"
                                        id="file_.{{ $item->id }}" accept="application/.docx, .docx">
                                    @php
                                        // Find the uploaded file for this specific requirement from the loaded relationship
                                        $uploadedFile = $permohonan->berkas
                                            ->where('persyaratan_berkas_id', $item->id)
                                            ->where('versi', 'draft')
                                            ->first();
                                    @endphp

                                    @if ($uploadedFile)
                                        <div class="mt-2">
                                            {{-- Use the asset() helper for public storage files --}}
                                            <a href="{{ asset('storage/' . $uploadedFile->file_path) }}" target="_blank"
                                                class="text-primary">
                                                <i class="bx bx-file"></i> Lihat Berkas
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                        <span class="text-danger fs-6 fst-italic">(*) Wajib diisi</span>
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
@script
    <script>
        $wire.on('trigger-close-modal', () => {
            const modal = bootstrap.Modal.getInstance(document.getElementById('UploadBerkasAnalisaKkprnbModal'));
            if (modal) {
                modal.hide();
            }
        });
    </script>
@endscript  