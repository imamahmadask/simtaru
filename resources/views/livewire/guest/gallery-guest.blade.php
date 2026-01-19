<div>
    <section id="gallery" style="padding-top: 5rem !important; padding-bottom: 5rem !important">
        <div class="container">
            <div class="row justify-content-center text-center mb-5">
                <div class="col-lg-8">
                    <h2 class="display-4 fw-bold text-dark mb-4">Galeri Tata Ruang</h2>
                    <p class="lead text-muted">
                        Gallery progres dan kegiatan penataan ruang di Kota Mataram.
                    </p>
                </div>
            </div>

            <div class="row g-4">
                @forelse ($galleries as $gallery)
                    @foreach ($gallery->images as $image)
                        <div class="col-md-6 col-lg-4">
                            <a href="{{ asset('storage/' . $image) }}" class="glightbox" data-gallery="gallery1" data-title="{{ $gallery->title }}" data-description="{{ $gallery->description }}">
                                <div class="gallery-item card h-100 border-0 shadow-sm overflow-hidden position-relative">
                                    <img src="{{ asset('storage/' . $image) }}" alt="{{ $gallery->title }}" class="img-fluid w-100" style="height: 300px; object-fit: cover; transition: transform 0.5s ease;">
                                    <div class="gallery-overlay d-flex flex-column justify-content-end p-3 position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0) 60%); opacity: 0; transition: opacity 0.3s ease;">
                                        <span class="badge bg-primary align-self-start mb-2">{{ $gallery->category }}</span>
                                        <h5 class="text-white mb-1">{{ $gallery->title }}</h5>
                                        <p class="text-white-50 small mb-0">{{ Str::limit($gallery->description, 60) }}</p>
                                        <small class="text-white">{{ date('d M Y', strtotime($gallery->created_at)) }}</small>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                @empty
                    <div class="col-12 text-center text-muted py-5">
                        <i class="bi bi-images fs-1 d-block mb-3"></i>
                        <p>Belum ada foto galeri.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <style>
        .gallery-item:hover img {
            transform: scale(1.1);
        }
        .gallery-item:hover .gallery-overlay {
            opacity: 1 !important;
        }
    </style>
</div>
