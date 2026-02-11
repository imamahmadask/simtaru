<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMTARU | {{ $title ?? '' }}</title>
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/fav.svg') }}" />
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />
    @stack('styles')
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
                            <a class="nav-link text-muted hover-primary" href="/#layanan">Layanan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-muted hover-primary" href="/#regulasi">Regulasi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-muted hover-primary" href="/#peta">Peta</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-muted hover-primary" href="/#faq">FAQ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-muted hover-primary" href="/#gallery">Galeri</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-muted hover-primary" href="/#kontak">Kontak</a>
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

    <main class="min-vh-100">
        {{ $slot }}
    </main>

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
                        <li><a href="/#layanan" class="text-light text-decoration-none hover-white">Layanan</a></li>
                        <li><a href="/#regulasi" class="text-light text-decoration-none hover-white">Regulasi</a></li>
                        <li><a href="/#peta" class="text-light text-decoration-none hover-white">Peta</a></li>
                        <li><a href="/#faq" class="text-light text-decoration-none hover-white">FAQ</a></li>
                        <li><a href="/#gallery" class="text-light text-decoration-none hover-white">Galeri</a></li>
                        <li><a href="/#kontak" class="text-light text-decoration-none hover-white">Kontak</a></li>
                    </ul>
                </div>
            </div>
            <hr class="my-4">
            <div class="text-center text-light">
                <p>&copy; 2026 SIMTARU HARUM. All rights reserved.</p>
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
    @stack('scripts')
</body>

</html>
