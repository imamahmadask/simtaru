<div>
    <div wire:ignore.self class="modal fade" id="editDataFinalSkrkModal" data-bs-backdrop="static" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">
                        Upload Dokumen SKRK Fix
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form wire:submit="editFinal">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col mb-3">
                                <label for="tgl_selesai" class="form-label">Tanggal Terbit</label>
                                <input type="date" class="form-control" wire:model.live="tgl_selesai"
                                    id="tgl_selesai">
                                @error('tgl_selesai')
                                    <span class="form-text text-xs text-danger"> {{ $message }} </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col mb-3">
                                <label for="waktu_pengerjaan" class="form-label">Waktu Penyelesaian (hari)</label>
                                <input type="text" class="form-control" wire:model="waktu_pengerjaan"
                                    id="waktu_pengerjaan" disabled>
                                @error('waktu_pengerjaan')
                                    <span class="form-text text-xs text-danger"> {{ $message }} </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col mb-3">
                                <label for="no_dokumen" class="form-label">Nomor Dokumen SKRK</label>
                                <input type="text" class="form-control" wire:model="no_dokumen" id="no_dokumen">
                                @error('no_dokumen')
                                    <span class="form-text text-xs text-danger"> {{ $message }} </span>
                                @enderror
                            </div>
                        </div>

                        @foreach ($persyaratan_berkas as $item)
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="file_.{{ $item->id }}" class="form-label">Upload
                                        {{ $item->nama_berkas }}</label>
                                    <input type="file" class="form-control" wire:model="file_.{{ $item->kode }}"
                                        id="file_.{{ $item->id }}" accept="application/pdf">
                                    @error('file_.' . $item->kode)
                                        <span class="form-text text-xs text-danger">{{ $message }}</span>
                                    @enderror
                                    {{-- Cek apakah sudah ada file yang tersimpan --}}
                                    @php
                                        // Cari berkas yang sesuai dengan persyaratan ini dan versinya 'final'
                                        $uploadedFile = $permohonan->berkas
                                            ->where('persyaratan_berkas_id', $item->id)
                                            ->where('versi', 'final')
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
                            Submit
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
            const modal = bootstrap.Modal.getInstance(document.getElementById('editDataFinalSkrkModal'));
            if (modal) {
                modal.hide();
            }
        });
    </script>
@endscript