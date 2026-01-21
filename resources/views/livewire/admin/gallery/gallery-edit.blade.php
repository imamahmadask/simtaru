<div>
<div wire:ignore.self class="modal fade" id="editGalleryModal" tabindex="-1" aria-labelledby="editGalleryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editGalleryModalLabel">Edit Gallery</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form wire:submit.prevent="updateGallery" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">                                                
                        <div class="mb-3">
                            <label for="edit-title" class="form-label">Judul</label>
                            <input type="text" wire:model="title" class="form-control" id="edit-title" name="title" required>
                            @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        {{-- <div class="mb-3">
                            <label for="edit-category" class="form-label">Kategori</label>
                            <select wire:model="category" class="form-control" id="edit-category" name="category">
                                <option value="">-- Pilih Kategori --</option>
                                <option value="Survey">Survey</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                            @error('category') <span class="text-danger">{{ $message }}</span> @enderror
                        </div> --}}
                        <div class="mb-3">
                            <label for="edit-description" class="form-label">Deskripsi</label>
                            <textarea wire:model="description" class="form-control" id="edit-description" name="description" required></textarea>
                            @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Existing Images</label>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach ($existingImages as $index => $image)
                                    <div class="position-relative">
                                        <img src="{{ asset('storage/' . $image) }}" class="rounded shadow-sm" width="100" height="100" style="object-fit: cover;">
                                        <button type="button" 
                                            class="btn btn-danger btn-sm position-absolute top-0 end-0 p-1 leading-none" 
                                            style="transform: translate(30%, -30%); border-radius: 50%; width: 20px; height: 20px; display: flex; align-items: center; justify-content: center;"
                                            wire:click="removeExistingImage({{ $index }})">
                                            &times;
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="edit-images" class="form-label">Add New Images</label>
                            <input type="file" wire:model="newImages" class="form-control" id="edit-images" name="images" multiple wire:loading.attr="disabled">
                            <div wire:loading wire:target="newImages" class="mt-2">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                            <div class="d-flex flex-wrap gap-2 mt-2">
                                @foreach ($newImages as $index => $image)
                                    <div class="position-relative">
                                        <img src="{{ $image->temporaryUrl() }}" class="rounded shadow-sm" width="100" height="100" style="object-fit: cover;">
                                        <button type="button" 
                                            class="btn btn-danger btn-sm position-absolute top-0 end-0 p-1 leading-none" 
                                            style="transform: translate(30%, -30%); border-radius: 50%; width: 20px; height: 20px; display: flex; align-items: center; justify-content: center;"
                                            wire:click="removeNewImage({{ $index }})">
                                            &times;
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                            @error('newImages.*') <span class="text-danger">{{ $message }}</span> @enderror
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
            const modalElement = document.getElementById('editGalleryModal');
            const modal = bootstrap.Modal.getInstance(modalElement);
            modal.hide();
        });
    </script>
@endscript