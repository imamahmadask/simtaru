<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMTARU</title>
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/fav.svg') }}" />
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('landing/style.css') }}" rel="stylesheet">
</head>

<body>
    <!-- Header -->
    <header class="container-fluid py-3">
        <nav class="navbar navbar-expand-lg fixed-top navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand fw-bold fs-3 text-primary" href="/">
                    <img src="{{ asset('assets/img/logo/simtaru2.png') }}" alt="SIMTARU Logo" class="d-inline-block"
                        width="180px">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto align-items-center">
                        <li class="nav-item">
                            <a class="nav-link text-muted hover-primary" href="#layanan">Layanan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-muted hover-primary" href="#regulasi">Regulasi</a>
                        </li>
                        {{-- <li class="nav-item">
                            <a class="nav-link text-muted hover-primary" href="#map">Peta</a>
                        </li> --}}
                        <li class="nav-item">
                            <a class="nav-link text-muted hover-primary" href="#kontak">Kontak</a>
                        </li>
                        @if (Route::has('login'))
                            @auth
                                <li class="nav-item ms-3">
                                    <a href="{{ route('dashboard') }}" class="btn btn-outline-primary">Dashboard</a>
                                </li>
                            @else
                                <li class="nav-item ms-3">
                                    <a href="{{ route('login') }}" class="btn btn-outline-primary">Login</a>
                                </li>
                            @endauth
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="hero-section" style="padding-top: 5rem !important; padding-bottom: 5rem !important">
        <div class="container text-center">
            <div class="row mb-5 justify-content-center">
                <div class="col-lg-8">
                    <img src="{{ asset('assets/img/logo/simtaru3.png') }}" alt="" width="150">
                    <h1 class="display-2 fw-bold text-dark mt-2">SIMTARU HARUM</h1>
                    <h3>Sistem Informasi Tata Ruang Kota Mataram</h3>
                    <p class="lead text-muted mb-5">
                        Dinas Pekerjaan Umum Dan Penataan Ruang Kota Mataram
                    </p>
                </div>
            </div>

            <div class="row mt-5 py-5" class="justify-content-center">
                <div class="col-md-8 col-lg-6 mx-auto">
                    <livewire:guest.lacak-berkas />
                </div>
            </div>
        </div>
    </section>

    <!-- layanan Section -->
    <section id="layanan" style="padding-top: 5rem !important; padding-bottom: 5rem !important">
        <div class="container">
            <div class="row justify-content-center text-center mb-5">
                <div class="col-lg-8">
                    <h2 class="display-4 fw-bold text-dark mb-4">Layanan</h2>
                    <p class="lead text-muted">
                        Layanan yang disediakan oleh SIMTARU Harum
                    </p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-lg feature-card">
                        <div class="card-body text-center p-4">
                            <a href="{{ route('layanan.skrk') }}" class="text-decoration-none" target="_blank">
                                <div class="feature-icon bg-primary-subtle text-primary mb-4 mx-auto">
                                    <i class="bi bi-file-earmark-text"></i>
                                </div>
                                <h3 class="h5 fw-semibold text-dark mb-3">SKRK</h3>
                            </a>
                            <p class="text-muted mb-1">
                                SKRK (Surat Keterangan Rencana Kota) adalah surat dari pemerintah daerah yang
                                menjelaskan peruntukan lahan dan ketentuan bangunan pada suatu lokasi sebagai syarat
                                sebelum mengurus IMB/PBG.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-lg feature-card">
                        <div class="card-body text-center p-4">
                            <a href="{{ route('layanan.itr') }}" class="text-decoration-none" target="_blank">
                                <div class="feature-icon bg-success-subtle text-success mb-4 mx-auto">
                                    <i class="bi bi-info-square"></i>
                                </div>
                                <h3 class="h5 fw-semibold text-dark mb-3">ITR</h3>
                            </a>
                            <p class="text-muted mb-1">
                                ITR (Informasi Tata Ruang) adalah keterangan yang berisi informasi resmi mengenai
                                kesesuaian peruntukan lahan dan kegiatan dengan rencana tata ruang yang berlaku.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-lg feature-card">
                        <div class="card-body text-center p-4">
                            <a href="{{ route('layanan.kkprb') }}" class="text-decoration-none" target="_blank">
                                <div class="feature-icon bg-warning-subtle text-warning mb-4 mx-auto">
                                    <i class="bi bi-cash-stack"></i>
                                </div>
                                <h3 class="h5 fw-semibold text-dark mb-3">KKPR Berusaha</h3>
                            </a>
                            <p class="text-muted mb-1">
                                KKPR Berusaha adalah izin dasar yang menyatakan kesesuaian rencana kegiatan usaha dengan
                                rencana tata ruang sebagai syarat perizinan berusaha.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-lg feature-card">
                        <div class="card-body text-center p-4">
                            <a href="{{ route('layanan.kkprnb') }}" class="text-decoration-none" target="_blank">
                                <div class="feature-icon bg-info-subtle text-info mb-4 mx-auto">
                                    <i class="bi bi-building-fill"></i>
                                </div>
                                <h3 class="h5 fw-semibold text-dark mb-3">KKPR Non Berusaha</h3>
                            </a>
                            <p class="text-muted mb-1">
                                KKPR Non Berusaha adalah persetujuan kesesuaian pemanfaatan ruang untuk kegiatan
                                nonkomersial sesuai dengan rencana tata ruang sebagai dasar perizinan.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="regulasi" class="bg-light" style="padding-top: 5rem !important; padding-bottom: 5rem !important">
        <div class="container">
            <div class="row justify-content-center text-center mb-5">
                <div class="col-lg-8">
                    <h2 class="display-4 fw-bold text-dark mb-4">Regulasi</h2>
                    <p class="lead text-muted">Regulasi & Dasar Hukum pelaksanaan Tata Ruang di Kota Mataram</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-lg">
                        <div class="card-body p-4">
                            <div class="float-end ms-3">
                                <i class="bi bi-file-earmark-pdf text-danger" style="font-size: 3rem;"></i>
                            </div>
                            <p class="text-muted fw-bold mb-4">
                                Peraturan Pemerintah Nomor 21 Tahun 2021 Tentang Penyelenggaraan Penataan Ruang
                            </p>
                        </div>
                        <div class="card-footer">
                            <a href="https://drive.google.com/file/d/1GH392IHUDvIEYlOghJ3GJhc8YpGtYaiA/view?usp=sharing"
                                class="btn btn-success" target="_blank">Lihat Regulasi</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-lg">
                        <div class="card-body p-4">
                            <div class="float-end ms-3">
                                <i class="bi bi-file-earmark-pdf text-danger" style="font-size: 3rem;"></i>
                            </div>
                            <p class="text-muted fw-bold mb-4">
                                Peraturan Daerah Kota Mataram No. 5 Tahun 2019 Tentang Perubahan Atas Peraturan Daerah
                                Nomor 12 Tahun 2011 Tentang Rencana Tata Ruang Wilayah Kota Mataram Tahun 2011-2031
                            </p>
                        </div>
                        <div class="card-footer">
                            <a href="https://drive.google.com/file/d/1WHFiIhchQ9MZLwNk63G8XHg1TenL1Ytj/view?usp=sharing"
                                class="btn btn-success" target="_blank">Lihat Regulasi</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-lg">
                        <div class="card-body p-4">
                            <div class="float-end ms-3">
                                <i class="bi bi-file-earmark-pdf text-danger" style="font-size: 3rem;"></i>
                            </div>
                            <p class="text-muted fw-bold mb-4">
                                Peraturan Wali Kota Mataram No. 19 Tahun 2024 Tentang Rencana Detail Tata Ruang
                                Kecamatan Ampenan, Kecamatan Sekarbela, Kecamatan Mataram dan Kecamatan Selaparang.
                            </p>
                        </div>
                        <div class="card-footer">
                            <a href="https://drive.google.com/file/d/1jT6UeaAre6iZ60yCHeVGqGhT7V-4az6F/view?usp=sharing"
                                class="btn btn-success" target="_blank">Lihat Regulasi</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    {{-- <section id="map" style="padding-top: 5rem !important; padding-bottom: 5rem !important">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <h2 class="display-4 fw-bold text-dark mb-4">Peta Digital</h2>
                    <p class="lead text-muted">
                        Visualisasi interaktif Rencana Tata Ruang Wilayah Kota Mataram
                    </p>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="row justify-content-center mb-4 g-3">
                <div class="col-md-4">
                    <div class="input-group shadow-sm">
                        <span class="input-group-text bg-white border-end-0"><i
                                class="bi bi-geo-alt text-primary"></i></span>
                        <select class="form-select border-start-0" aria-label="Filter Kecamatan">
                            <option selected>Semua Kecamatan</option>
                            <option value="Ampenan">Ampenan</option>
                            <option value="Cakranegara">Cakranegara</option>
                            <option value="Mataram">Mataram</option>
                            <option value="Sandubaya">Sandubaya</option>
                            <option value="Sekarbela">Sekarbela</option>
                            <option value="Selaparang">Selaparang</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group shadow-sm">
                        <span class="input-group-text bg-white border-end-0"><i
                                class="bi bi-layers text-primary"></i></span>
                        <select class="form-select border-start-0" aria-label="Filter Pemanfaatan Ruang">
                            <option selected>Semua Pemanfaatan Ruang</option>
                            <option value="Kawasan Lindung">Kawasan Lindung</option>
                            <option value="Kawasan Budidaya">Kawasan Budidaya</option>
                            <option value="RTH">Ruang Terbuka Hijau</option>
                            <option value="Perumahan">Perumahan</option>
                            <option value="Perdagangan">Perdagangan & Jasa</option>
                            <option value="Perkantoran">Perkantoran</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary w-100 shadow-sm">
                        <i class="bi bi-filter me-2"></i>Filter
                    </button>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-8">
                    <!-- Map Placeholder -->
                    <div
                        class="ratio ratio-16x9 bg-dark rounded shadow-lg d-flex align-items-center justify-content-center overflow-hidden position-relative">
                        <div class="position-absolute w-100 h-100 opacity-50"
                            style="background: linear-gradient(45deg, #2c3e50, #3498db);"></div>
                        <div class="position-relative z-1 text-white text-center">
                            <i class="bi bi-map-fill display-1 mb-3"></i>
                            <h4>Peta Interaktif</h4>
                            <p class="mb-4">Klik tombol di bawah untuk melihat peta selengkapnya</p>
                            <button class="btn btn-light btn-lg">
                                <i class="bi bi-arrows-fullscreen me-2"></i>Buka Peta Fullscreen
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <!-- Dummy Data / Stats -->
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4">


                            <h4 class="fw-bold mb-4">Statistik Wilayah</h4>

                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="text-muted">Kawasan Lindung</span>
                                    <span class="fw-bold text-success">1,240 Ha</span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 30%"></div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="text-muted">Kawasan Budidaya</span>
                                    <span class="fw-bold text-primary">4,850 Ha</span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 70%"></div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="text-muted">Ruang Terbuka Hijau</span>
                                    <span class="fw-bold text-info">850 Ha</span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: 25%"></div>
                                </div>
                            </div>

                            <hr>

                            <h5 class="fw-bold mb-3">Layer Tersedia</h5>
                            <div class="d-flex flex-wrap gap-2">
                                <span class="badge bg-light text-dark border">Administrasi</span>
                                <span class="badge bg-light text-dark border">Pola Ruang</span>
                                <span class="badge bg-light text-dark border">Jaringan Jalan</span>
                                <span class="badge bg-light text-dark border">Drainase</span>
                                <span class="badge bg-light text-dark border">Fasilitas Umum</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}

    <!-- CTA Section -->
    <section id="kontak" style="padding-top: 5rem !important; padding-bottom: 5rem !important">
        <div class="container text-center">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-8">
                    <h2 class="display-4 fw-bold text-dark mb-4">Hubungi Kami</h2>
                    <p class="lead text-muted">
                        Silahkan hubungi kami untuk informasi lebih lanjut mengenai Layanan Tata Ruang di Kota Mataram.
                    </p>
                </div>
            </div>
            <div class="row g-3 justify-content-center">
                <div class="col-md-3">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="mb-3 text-primary">
                                <i class="bi bi-geo-alt fs-1"></i>
                            </div>
                            <h5 class="card-title fw-bold">Alamat</h5>
                            <p class="card-text text-muted small">
                                Dinas PUPR Kota Mataram<br>
                                Jl. Semanggi No. 19, Kota Mataram
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="mb-3 text-primary">
                                <i class="bi bi-globe fs-1"></i>
                            </div>
                            <h5 class="card-title fw-bold">Website & Instagram</h5>
                            <p class="card-text text-muted small">
                                <a href="https://pupr.mataramkota.go.id/" class="text-decoration-none text-primary"
                                    target="_blank">pupr.mataramkota.go.id</a><br>
                                <a href="https://www.instagram.com/puprmataram/"
                                    class="text-decoration-none text-primary" target="_blank">@puprmataram</a>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="mb-3 text-primary">
                                <i class="bi bi-whatsapp fs-1"></i>
                            </div>
                            <h5 class="card-title fw-bold">Kontak Kami</h5>
                            <p class="card-text text-muted small">
                                Layanan Tata Ruang : <a href="https://wa.me/0895326753064"
                                    class="text-decoration-none text-primary" target="_blank">0895326753064</a>
                                <br>
                                Pengaduan Pelanggaran Tata Ruang : <a href="https://wa.me/081775232485"
                                    class="text-decoration-none text-primary" target="_blank">081775232485</a>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="mb-3 text-primary">
                                <i class="bi bi-envelope fs-1"></i>
                            </div>
                            <h5 class="card-title fw-bold">Email</h5>
                            <p class="card-text text-muted small">
                                <a href="mailto:bidangtataruangmataram@gmail.com"
                                    class="text-decoration-none text-primary"
                                    target="_blank">bidangtataruangmataram@gmail.com</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1102.4294683229016!2d116.10266777360239!3d-8.57736181405914!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dcdc0a12090bcf9%3A0xaebeae0268da0411!2sDinas%20Pekerjan%20Umum%20Kota%20Mataram!5e1!3m2!1sen!2sid!4v1767835507391!5m2!1sen!2sid"
                    width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <h5 class="text-primary mb-3 bg-white p-1">
                        <img src="{{ asset('assets/img/logo/simtaru2.png') }}" alt="" width="200">
                    </h5>
                    <p class="text-light">
                        Sistem Informasi Tata Ruang Kota Mataram
                    </p>
                </div>
                <div class="col-md-6 col-lg-3">
                    <h6 class="mb-3">Main Menu</h6>
                    <ul class="list-unstyled">
                        <li><a href="#layanan" class="text-light text-decoration-none hover-white">Layanan</a></li>
                        <li><a href="#regulasi" class="text-light text-decoration-none hover-white">Regulasi</a></li>
                        <li><a href="#contact" class="text-light text-decoration-none hover-white">Contact Us</a></li>
                    </ul>
                </div>
            </div>
            <hr class="my-4">
            <div class="text-center text-light">
                <p>&copy; 2025 SIMTARU HARUM. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('.collapse').forEach(el => {
            el.addEventListener('show.bs.collapse', () => {
                const toggler = document.querySelector(`a[href="#${el.id}"]`);
                if (toggler) toggler.textContent = 'Read Less';
            });
            el.addEventListener('hide.bs.collapse', () => {
                const toggler = document.querySelector(`a[href="#${el.id}"]`);
                if (toggler) toggler.textContent = 'Read More';
            });
        });
    </script>
</body>

</html>
