<div>
    <div class="card mb-4">
        <div class="card-header d-flex align-items-center justify-content-between bg-secondary">
            <h5 class="mb-0 text-white">Unggah Berkas</h5>
        </div>
        <div class="card-body">
            <!-- Section: Timeline -->
            <section class="py-2">
                @if ($berkas == null)
                    @foreach ($permohonan->layanan->persyaratanBerkas as $data)
                        <h4>
                            {{ $data->nama_berkas }}
                        </h4>
                        <form wire:submit.prevent="uploadBerkas">
                            <input type="file" wire:model="file" name="file">
                            @error('file')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                            <button type="submit" class="btn btn-primary mt-2">Upload</button>
                        </form>
                        <hr>
                    @endforeach
                @else
                    <p>✅ Semua berkas sudah diupload.</p>
                @endif

                @if (session()->has('message'))
                    <div class="alert alert-success mt-2">
                        {{ session('message') }}
                    </div>
                @endif
            </section>
            <!-- Section: Timeline -->
        </div>
    </div>
</div>

</div>
