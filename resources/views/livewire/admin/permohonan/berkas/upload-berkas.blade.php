<div>
    <div class="card mb-4">
        <div class="card-header d-flex align-items-center justify-content-between bg-secondary">
            <h5 class="mb-0 text-white">Unggah Berkas</h5>
        </div>
        <div class="card-body">
            <!-- Section: Timeline -->
            <section class="py-2">
                @if ($berkas)
                    <h4>Upload Berkas: {{ $berkas->persyaratan->nama_berkas }}</h4>
                    @if ($berkas->persyaratan->deskripsi)
                        <p>{{ $berkas->persyaratan->deskripsi }}</p>
                    @endif

                    <form wire:submit.prevent="upload">
                        <input type="file" wire:model="file">
                        @error('file')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror

                        <button type="submit" class="btn btn-primary mt-2">Upload</button>
                    </form>
                @elseif ($berkas == null)
                    <p class="text-danger">Belum ada berkas yang diupload.</p>
                    Syarat Berkas yang harus diupload :
                    @foreach ($permohonan->layanan->persyaratanBerkas as $persyaratan)
                        <ul>
                            <li>
                                {{ $persyaratan->nama_berkas }}
                            </li>
                        </ul>
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
