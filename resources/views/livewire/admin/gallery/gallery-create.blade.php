<div>
    <div wire:ignore.self class="modal fade" id="addGalleryModal" tabindex="-1" aria-labelledby="addGalleryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addGalleryModalLabel">Tambah Gallery</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form wire:submit.prevent="addImage" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">                                                
                        <div class="mb-3">
                            <label for="create-title" class="form-label">Judul</label>
                            <input type="text" wire:model="title" class="form-control" id="create-title" name="title" required>
                            @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        {{-- <div class="mb-3">
                            <label for="create-category" class="form-label">Kategori</label>
                            <select wire:model="category" class="form-control" id="create-category" name="category">
                                <option value="">-- Pilih Kategori --</option>
                                <option value="Survey">Survey</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                            @error('category') <span class="text-danger">{{ $message }}</span> @enderror
                        </div> --}}
                        <div class="mb-3">
                            <label for="create-description" class="form-label">Deskripsi</label>
                            <textarea wire:model="description" class="form-control" id="create-description" name="description" required></textarea>
                            @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="create-images" class="form-label">Image</label>
                            <input type="file" wire:model="images" class="form-control" id="create-images" name="images" multiple required wire:loading.attr="disabled">
                            <div wire:loading wire:target="images" class="mt-2">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                            <div class="d-flex flex-wrap gap-2 mt-2">
                                @foreach ($images as $index => $image)
                                    <div class="position-relative">
                                        <img src="{{ $image->temporaryUrl() }}" class="rounded shadow-sm" width="100" height="100" style="object-fit: cover;">
                                        <button type="button" 
                                            class="btn btn-danger btn-sm position-absolute top-0 end-0 p-1 leading-none" 
                                            style="transform: translate(30%, -30%); border-radius: 50%; width: 20px; height: 20px; display: flex; align-items: center; justify-content: center;"
                                            wire:click="removeImage({{ $index }})">
                                            &times;
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                            @error('images.*') <span class="text-danger">{{ $message }}</span> @enderror
                            @error('images') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>                                                
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@script
    <script>
        $wire.on('close-modal-gallery', () => {
            const modalElement = document.getElementById('addGalleryModal');
            const modal = bootstrap.Modal.getInstance(modalElement);
            modal.hide();
        });
    </script>
@endscript