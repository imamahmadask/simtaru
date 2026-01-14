<div>
    <div class="card mb-4">
        <div class="card-header d-flex align-items-center justify-content-between bg-secondary">
            <h5 class="mb-0 text-white">Unggah Berkas</h5>
        </div>
        <div class="card-body">
            <!-- Section: Timeline -->
            <section class="py-2">
                @if ($berkas != null)
                    <div class="mb-4">
                        <h5>Berkas Berikutnya: {{ $berkas->persyaratanBerkas->nama_berkas }}</h5>
                        <form wire:submit.prevent="uploadBerkas">
                            <input type="file" wire:model="file" class="form-control mb-2">
                            @error('file')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                            <button type="submit" class="btn btn-primary">
                                <span wire:loading wire:target="file" class="spinner-border spinner-border-sm me-1"></span>
                                Upload
                            </button>
                        </form>
                    </div>
                @else
                    <div class="alert alert-success">
                        ✅ Semua berkas sudah diupload.
                    </div>
                @endif

                <hr>

                <h5>Berkas Terupload</h5>
                <ul class="list-group">
                    @forelse ($permohonan->berkas()->whereNotNull('file_path')->get() as $item)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong>{{ $item->persyaratanBerkas->nama_berkas }}</strong><br>
                                <small class="text-muted">Uploaded: {{ $item->uploaded_at }}</small>
                            </div>
                            <div class="d-flex align-items-center">
                                <a href="{{ asset('storage/' . $item->file_path) }}" target="_blank"
                                    class="btn btn-sm btn-outline-primary me-2">
                                    <i class="bx bx-show"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-danger"
                                    wire:click="deleteBerkas({{ $item->id }})"
                                    wire:confirm="Yakin ingin menghapus berkas ini?"
                                    wire:loading.attr="disabled"
                                    wire:target="deleteBerkas({{ $item->id }})">
                                    <i class="bx bx-trash" wire:loading.remove wire:target="deleteBerkas({{ $item->id }})"></i>
                                    <span wire:loading wire:target="deleteBerkas({{ $item->id }})"
                                        class="spinner-border spinner-border-sm"></span>
                                </button>
                            </div>
                        </li>
                    @empty
                        <li class="list-group-item text-center text-muted">Belum ada berkas terupload</li>
                    @endforelse
                </ul>

                @if (session()->has('message'))
                    <div class="alert alert-info mt-3">
                        {{ session('message') }}
                    </div>
                @endif
            </section>
            <!-- Section: Timeline -->
        </div>
    </div>
</div>

</div>
