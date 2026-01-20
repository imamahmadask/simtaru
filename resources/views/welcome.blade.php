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
    <!-- GLightbox CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />
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
                        <li class="nav-item">
                            <a class="nav-link text-muted hover-primary" href="#maps">Peta</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-muted hover-primary" href="#faq">FAQ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-muted hover-primary" href="#gallery">Galeri</a>
                        </li>
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
    <section id="maps" style="padding-top: 5rem !important; padding-bottom: 5rem !important">
        <livewire:guest.maps />
    </section>

    <!-- Gallery Section -->
    <livewire:guest.gallery-guest />

    <!-- FAQ Section -->
    <section id="faq" class="bg-light" style="padding-top: 5rem !important; padding-bottom: 5rem !important">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-4 fw-bold text-dark mb-4">Pertanyaan Umum (FAQ)</h2>
                <p class="lead text-muted">Temukan jawaban atas pertanyaan yang sering diajukan mengenai layanan kami.</p>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="accordion shadow-sm" id="accordionFAQ">
                        <!-- Q1 -->
                        <div class="accordion-item border-0 mb-3">
                            <h2 class="accordion-header">
                                <button class="accordion-button fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                    <i class="bi bi-question-circle me-2 text-success"></i>
                                    Apa syarat pengajuan KKPR?
                                </button>
                            </h2>
                            <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#accordionFAQ">
                                <div class="accordion-body">
                                    Syaratnya meliputi: KTP pemohon, bukti kepemilikan tanah, dokumen OSS (jika usaha), selengkapnya dapat memilih menu Layanan KKPR.
                                </div>
                            </div>
                        </div>

                        <!-- Q2 -->
                        <div class="accordion-item border-0 mb-3">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                    <i class="bi bi-question-circle me-2 text-success"></i>
                                    Bagaimana alur pengajuan SKRK?
                                </button>
                            </h2>
                            <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#accordionFAQ">
                                <div class="accordion-body">
                                    Pengajuan dilakukan melalui surat permohonan, dilengkapi dokumen pendukung. Pemeriksaan teknis dilakukan sebelum penerbitan SKRK, selengkapnya dapat memilih menu Layanan SKRK.
                                </div>
                            </div>
                        </div>

                        <!-- Q3 -->
                        <div class="accordion-item border-0 mb-3">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                    <i class="bi bi-question-circle me-2 text-success"></i>
                                    Berapa lama waktu proses KKPR/SKRK?
                                </button>
                            </h2>
                            <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#accordionFAQ">
                                <div class="accordion-body">
                                    <ul>
                                        <li>KKPR Berusaha Non-UMK Maksimal 30 Hari Kerja (setelah PNBP PTP Terbit)</li>
                                        <li>SKRK/KKPR Berusaha UMK Maksimal 20 Hari Kerja</li>
                                        <li>ITR Maksimal 14 Hari Kerja</li>
                                        <li>KKPR Non-Berusaha Maksimal 24 Hari Kerja (setelah PNBP PTP Terbit)</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Q4 -->
                        <div class="accordion-item border-0 mb-3">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                    <i class="bi bi-question-circle me-2 text-success"></i>
                                    Apakah permohonan dapat dilakukan tanpa melalui OSS (Online Single Submission)?
                                </button>
                            </h2>
                            <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#accordionFAQ">
                                <div class="accordion-body">
                                    <ul>
                                        <li>Permohonan dapat dilakukan tanpa melalui OSS untuk KKPR Berusaha UMK.</li>
                                        <li>Penggunaan OSS hanya diwajibkan untuk permohonan KKPR Berusaha Non-UMK dengan jenis usaha skala besar dan nilai modal di atas Rp5 Milyar,-.</li>
                                        <li>Sementara itu, KKPR Berusaha UMK dapat diajukan melalui pernyataan mandiri atau permohonan pengajuan dokumen SKRK pada Bidang Tata Ruang Dinas PUPR Kota Mataram.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Q5 -->
                        <div class="accordion-item border-0 mb-3">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#faq5">
                                    <i class="bi bi-question-circle me-2 text-success"></i>
                                    Kenapa sebelum membangun harus mengurus izin terlebih dahulu?
                                </button>
                            </h2>
                            <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#accordionFAQ">
                                <div class="accordion-body">
                                    Untuk memastikan rencana bangunan sesuai rencana tata ruang dan peraturan teknis, serta menghindari sanksi di kemudian hari.    
                                </div>
                            </div>
                        </div>

                        <!-- Q6 -->
                        <div class="accordion-item border-0 mb-3">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#faq6">
                                    <i class="bi bi-question-circle me-2 text-success"></i>
                                    Apakah boleh membangun jika lokasi berada di dalam KP2B?
                                </button>
                            </h2>
                            <div id="faq6" class="accordion-collapse collapse" data-bs-parent="#accordionFAQ">
                                <div class="accordion-body">
                                   <ul>
                                        <li>Pada prinsipnya, tidak diperbolehkan melakukan pembangunan di kawasan KP2B. KP2B (Kawasan Pertanian Pangan Berkelanjutan) adalah kawasan yang ditetapkan untuk melindungi lahan pertanian, khususnya sawah dan lahan pangan, agar tetap digunakan untuk mendukung ketahanan pangan.</li>
                                        <li>Pembangunan hanya dapat dilakukan untuk kegiatan tertentu yang secara khusus diizinkan dan diatur dalam peraturan perundang-undangan, seperti prasarana pendukung pertanian atau kepentingan strategis yang tidak mengganggu fungsi utama lahan.</li>
                                   </ul>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Q7 -->
                        <div class="accordion-item border-0 mb-3">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#faq7">
                                    <i class="bi bi-question-circle me-2 text-success"></i>
                                    Apakah boleh membangun jika lokasi berada di dalam LSD?
                                </button>
                            </h2>
                            <div id="faq7" class="accordion-collapse collapse" data-bs-parent="#accordionFAQ">
                                <div class="accordion-body">
                                   <ul>
                                    <li>Tidak diperbolehkan melakukan pembangunan di kawasan LSD. LSD (Lahan Sawah Dilindungi) adalah lahan sawah yang ditetapkan untuk dilindungi dari alih fungsi, sehingga tidak boleh digunakan untuk kegiatan non-pertanian.</li>
                                    <li>Pembangunan hanya dapat dilakukan untuk kegiatan tertentu yang diatur secara khusus dalam peraturan perundang-undangan, dan tetap harus menjaga fungsi lahan sebagai kawasan pertanian.</li>        
                                </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Q8 -->
                        <div class="accordion-item border-0 mb-3">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#faq8">
                                    <i class="bi bi-question-circle me-2 text-success"></i>
                                    Jika melanggar peraturan tata ruang, apa sanksinya?
                                </button>
                            </h2>
                            <div id="faq8" class="accordion-collapse collapse" data-bs-parent="#accordionFAQ">
                                <div class="accordion-body">
                                    Sanksi dapat berupa peringatan tertulis, pembongkaran bangunan, atau denda administratif sesuai ketentuan peraturan daerah yang berlaku. </div>
                            </div>
                        </div>                        

                        <!-- Q9 -->
                        <div class="accordion-item border-0 mb-3">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#faq9">
                                    <i class="bi bi-question-circle me-2 text-success"></i>
                                    Bagaimana cara mengajukan revisi jika dokumen KKPR/SKRK sudah terbit?
                                </button>
                            </h2>
                            <div id="faq9" class="accordion-collapse collapse" data-bs-parent="#accordionFAQ">
                                <div class="accordion-body">
                                   Ajukan surat permohonan revisi dengan melampirkan dokumen yang diperbarui dan dokumen lama untuk pembanding.
                                </div>
                            </div>
                        </div>                        

                        <!-- Q10 -->
                        <div class="accordion-item border-0 mb-3">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#faq10">
                                    <i class="bi bi-question-circle me-2 text-success"></i>
                                    Kalau tanahnya belum bersertifikat, apakah bisa mengajukan KKPR?
                                </button>
                            </h2>
                            <div id="faq10" class="accordion-collapse collapse" data-bs-parent="#accordionFAQ">
                                <div class="accordion-body">
                                    Bisa. Pengajuan KKPR tetap dapat dilakukan meskipun tanah belum bersertifikat, dengan melampirkan bukti kepemilikan atau penguasaan lahan yang sah, seperti akta jual beli atau surat pinjam/sewa.
                                </div>
                            </div>
                        </div>

                        <!-- Q11 -->
                        <div class="accordion-item border-0 mb-3">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#faq11">
                                    <i class="bi bi-question-circle me-2 text-success"></i>
                                    Bagaimana jika lokasi berada di sempadan sungai atau pantai?
                                </button>
                            </h2>
                            <div id="faq11" class="accordion-collapse collapse" data-bs-parent="#accordionFAQ">
                                <div class="accordion-body">
                                    Tidak diperbolehkan mendirikan bangunan permanen kecuali untuk kegiatan tertentu yang diatur peraturan.
                                </div>
                            </div>
                        </div>

                        <!-- Q12 -->
                        <div class="accordion-item border-0 mb-3">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#faq12">
                                    <i class="bi bi-question-circle me-2 text-success"></i>
                                    Jika KKPR sudah terbit tetapi belum dibangun, apakah KKPR tersebut masih berlaku?
                                </button>
                            </h2>
                            <div id="faq12" class="accordion-collapse collapse" data-bs-parent="#accordionFAQ">
                                <div class="accordion-body">
                                    <ul>
                                        <li>KKPR tetap berlaku meskipun pembangunan belum dilakukan.</li>
                                        <li>Namun, apabila di kemudian hari terdapat perubahan peraturan atau perubahan peruntukan ruang, maka dokumen KKPR dapat perlu disesuaikan kembali agar tetap sesuai dengan ketentuan yang berlaku.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Q13 -->
                        <div class="accordion-item border-0 mb-3">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#faq13">
                                    <i class="bi bi-question-circle me-2 text-success"></i>
                                    Bagaimana cara mengetahui pola ruang lokasi yang akan dibangun?
                                </button>
                            </h2>
                            <div id="faq13" class="accordion-collapse collapse" data-bs-parent="#accordionFAQ">
                                <div class="accordion-body">
                                    <ul>
                                        <li>Pola ruang lokasi dapat diketahui dengan mengeceknya melalui RDTR Interaktif yang tersedia secara online.</li>
                                        <li>Selain itu, masyarakat juga dapat mengajukan permohonan informasi tata ruang secara langsung ke Dinas PUPR sesuai dengan ketentuan yang berlaku.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Q14 -->
                        <div class="accordion-item border-0 mb-3">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#faq14">
                                    <i class="bi bi-question-circle me-2 text-success"></i>
                                    Bagaimana jika yang mengajukan KKPR/SKRK berbeda dengan nama di sertifikat tanah?
                                </button>
                            </h2>
                            <div id="faq14" class="accordion-collapse collapse" data-bs-parent="#accordionFAQ">
                                <div class="accordion-body">
                                    Wajib melampirkan surat kuasa dari pemilik tanah beserta fotokopi KTP pemilik yang sesuai sertifikat.
                                </div>
                            </div>
                        </div>

                        <!-- Technical Calculation Section -->
                        <div class="accordion-item border-0 mb-3">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#faqTechnical">
                                    <i class="bi bi-question-circle me-2 text-success"></i>
                                    Cara Menghitung Pengaturan Teknis Tata Ruang
                                </button>
                            </h2>
                            <div id="faqTechnical" class="accordion-collapse collapse" data-bs-parent="#accordionFAQ">
                                <div class="accordion-body">
                                    <div class="mb-4">
                                        <h6 class="fw-bold">1. Garis Sempadan Bangunan (GSB)</h6>
                                        <p class="small text-muted mb-2">Cara Hitung Sederhana:</p>
                                        <ul class="small">
                                            <li>Misalnya ketentuan GSB jalan arteri = 10 meter.</li>
                                            <li>Jika tanah menghadap jalan arteri, maka bangunan harus mundur min. 10 meter dari batas jalan.</li>
                                            <li><strong>Contoh</strong>: Tanah 20 m x 30 m (menghadap jalan arteri → GSB 10 m). Maka bagian depan sepanjang 10 m tidak boleh dibangun.</li>
                                        </ul>
                                    </div>

                                    <div class="mb-4">
                                        <h6 class="fw-bold">2. Koefisien Dasar Bangunan (KDB)</h6>
                                        <p class="small text-muted mb-1">Rumus: KDB = (Luas Lantai Dasar / Luas Tanah) × 100%</p>
                                        <p class="small text-muted mb-2">Cara Hitung:</p>
                                        <ul class="small">
                                            <li>Ketentuan KDB = 60%.</li>
                                            <li>Jika tanah luasnya 300 m² maka luas maksimal lantai dasar = 60% × 300 = 180 m².</li>
                                            <li><strong>Artinya</strong>: Dari tanah 300 m², bangunan di lantai dasar maksimal seluas 180 m².</li>
                                        </ul>
                                    </div>

                                    <div class="mb-4">
                                        <h6 class="fw-bold">3. Koefisien Dasar Hijau (KDH)</h6>
                                        <p class="small text-muted mb-1">Rumus: KDH = (Luas Lahan Terbuka Hijau / Luas Tanah) × 100%</p>
                                        <p class="small text-muted mb-2">Cara Hitung:</p>
                                        <ul class="small">
                                            <li>Ketentuan KDH = 30%.</li>
                                            <li>Jika tanah 300 m² maka lahan terbuka hijau minimal = 30% × 300 = 90 m².</li>
                                            <li><strong>Artinya</strong>: Dari tanah 300 m², minimal 90 m² harus jadi taman/halaman terbuka.</li>
                                        </ul>
                                    </div>

                                    <div>
                                        <h6 class="fw-bold">4. Koefisien Lantai Bangunan (KLB)</h6>
                                        <p class="small text-muted mb-1">Rumus: KLB = Total Luas Seluruh Lantai / Luas Tanah</p>
                                        <p class="small text-muted mb-2">Cara Hitung:</p>
                                        <ul class="small">
                                            <li>Ketentuan KLB = 2,0.</li>
                                            <li>Jika tanah luasnya 300 m² → total luas seluruh lantai = 2 × 300 = 600 m².</li>
                                            <li><strong>Artinya</strong>: Bangunan boleh 2–3 lantai asalkan luas totalnya tidak melebihi 600 m² sesuai ketentuan yang berlaku.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Kontak Section -->
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
            <div class="row g-2 justify-content-center">
                <div class="col-md-2">
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
                <div class="col-md-2">
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
                <div class="col-md-2">
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
                <div class="col-md-2">
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
                <div class="col-md-2">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="mb-3 text-primary">
                                <i class="bi bi-bell fs-1"></i>
                            </div>
                            <h5 class="card-title fw-bold">Lapor Pengaduan</h5>
                            <p class="card-text text-muted small">
                                <a href="https://lapor.go.id" class="text-decoration-none text-primary"
                                    target="_blank">lapor.go.id</a> <br>
                                <button type="button" class="btn btn-primary btn-sm mt-2"
                                    data-bs-toggle="modal" data-bs-target="#modalPengaduan">
                                    Form Pengaduan
                                </button>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
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
                        <li><a href="#maps" class="text-light text-decoration-none hover-white">Maps</a></li>
                        <li><a href="#faq" class="text-light text-decoration-none hover-white">FAQ</a></li>
                        <li><a href="#kontak" class="text-light text-decoration-none hover-white">Kontak</a></li>
                    </ul>
                </div>
            </div>
            <hr class="my-4">
            <div class="text-center text-light">
                <p>&copy; 2026 SIMTARU HARUM. All rights reserved.</p>
            </div>
        </div>
    </footer>

    @livewire('guest.pengaduan')

    <!-- Toast Notification -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="successToast" class="toast align-items-center text-white bg-success border-0" role="alert"
            aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body" id="toastMessage">
                    Pengaduan berhasil dikirim!
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- GLightbox JS -->
    <script src="https://cdn.jsdelivr.net/gh/mcstudios/glightbox/dist/js/glightbox.min.js"></script>

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

        const lightbox = GLightbox({
            selector: '.glightbox'
        });
    </script>
</body>

</html>
