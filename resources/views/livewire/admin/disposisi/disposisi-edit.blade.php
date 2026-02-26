<div>
    <div wire:ignore.self class="modal fade" id="editDisposisiModal" data-bs-backdrop="static" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Edit Disposisi
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form wire:submit="updateDisposisi">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col">
                                <ul class="list-unstyled">
                                    <li>
                                        Kode Registrasi : <strong>{{ $kode_registrasi }}</strong>
                                    </li>
                                    <li>
                                        Jenis Layanan Permohonan : <strong>{{ $nama_layanan }}</strong>

                                    </li>
                                    <li>
                                        {{-- Nama Pemohon : <strong>{{ $permohonan->registrasi->nama }}</strong> --}}
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col mb-3">
                                <label for="tahapan_id" class="form-label">Tahapan</label>
                                <select class="form-select" wire:model="tahapan_id" name="tahapan_id" id="tahapan_id"
                                    aria-label="Select Tahapan">
                                    <option selected>Pilih Tahapan</option>
                                    @foreach ($tahapans as $tahapan)
                                        <option value="{{ $tahapan->id }}">
                                            {{ $tahapan->layanan->nama }} - {{ $tahapan->urutan }} -
                                            {{ $tahapan->nama }}
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
                                <select class="form-select" wire:model="penerima_id" name="penerima_id" id="penerima_id"
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
                                <label for="catatan" class="form-label">Catatan</label>
                                <textarea class="form-control" wire:model="catatan" name="catatan" id="catatan" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" class="btn btn-primary">
                            Simpan
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
            const modal = bootstrap.Modal.getInstance(document.getElementById('editDisposisiModal'));
            if (modal) {
                modal.hide();
            }
        });
    </script>
@endscript