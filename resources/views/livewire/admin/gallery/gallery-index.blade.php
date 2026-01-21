<div>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4">
            <span class="text-muted fw-light">Data Galeri /</span> List Galeri
        </h4>

        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Data Galeri</h5>   
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addGalleryModal">
                        Tambah Gallery
                    </button>                 
                </div>
            </div>
            <div class="card-body">
                <div class="table table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul</th>
                                <th>Deskripsi</th>
                                <th>Image</th>    
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($galleries as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="text-wrap" style="width: 20%;">{{ $item->title }}</td>
                                    <td class="text-wrap" style="width: 50%;">{{ $item->description }}</td>
                                    <td>
                                        @foreach ($item->images as $image)
                                            <img class="image-fluid rounded-circle" src="{{ asset('storage/' . $image) }}" alt="{{ $item->title }}" width="100">
                                        @endforeach
                                    </td>
                                    <td class="text-nowrap">
                                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editGalleryModal" 
                                        wire:click="$dispatch('edit-gallery', { id: {{ $item->id }} })">
                                            Edit
                                        </button>
                                        <button type="button" class="btn btn-danger btn-sm" 
                                            wire:confirm="Apakah Anda yakin ingin menghapus galeri ini?"
                                            wire:click="deleteGallery({{ $item->id }})">
                                            Hapus
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <livewire:admin.gallery.gallery-create />
        <livewire:admin.gallery.gallery-edit />
    </div>
</div>
