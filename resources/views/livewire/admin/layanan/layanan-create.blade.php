<div>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Layanan /</span> Tambah Layanan
        </h4>

        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header">Tambah Layanan Baru</h5>
                    <div class="card-body">
                        <form wire:submit.prevent="store">
                            <div class="mb-3">
                                <label for="nama_layanan" class="form-label">Nama Layanan</label>
                                <input type="text" 
                                    class="form-control @error('nama_layanan') is-invalid @enderror" 
                                    id="nama_layanan" 
                                    wire:model="nama_layanan" 
                                    placeholder="Masukkan nama layanan">
                                @error('nama_layanan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                <textarea 
                                    class="form-control @error('deskripsi') is-invalid @enderror" 
                                    id="deskripsi" 
                                    wire:model="deskripsi" 
                                    rows="4" 
                                    placeholder="Masukkan deskripsi layanan"></textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary me-2">Simpan</button>
                                <a href="{{ route('admin.layanan.index') }}" class="btn btn-outline-secondary">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>