<div>
    <div wire:ignore.self class="modal fade" id="UploadBerkasAnalisaModal" data-bs-backdrop="static" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">
                        Upload Berkas Analisa SKRK
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form wire:submit="uploadBerkas">
                    <div class="modal-body">
                        @foreach ($persyaratan_berkas as $item)
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="file_.{{ $item->id }}" class="form-label">
                                        Upload {{ $item->nama_berkas }}
                                    </label>

                                    <input type="file" class="form-control" wire:model="file_.{{ $item->kode }}"
                                        id="file_.{{ $item->id }}">

                                    {{-- Cek apakah sudah ada file yang tersimpan --}}
                                    @php
                                        $uploadedFile = $item->permohonan_berkas->file_path ?? null; // misalnya kolom file_path
                                    @endphp

                                    @if ($uploadedFile)
                                        <div class="mt-2">
                                            <a href="{{ Storage::url($uploadedFile) }}" target="_blank"
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
