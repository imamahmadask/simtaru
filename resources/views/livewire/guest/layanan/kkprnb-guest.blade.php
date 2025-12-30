<div>
    <!-- Hero Section -->
    <section class="bg-info text-white py-5" style="margin-top: 70px;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="display-4 fw-bold mb-3">KKPR Non Berusaha</h1>
                    <p class="lead mb-4">Kesesuaian Kegiatan Pemanfaatan Ruang untuk Non Berusaha - Persetujuan untuk kegiatan non-komersial seperti rumah tinggal, tempat ibadah, dan fasilitas sosial yang sesuai dengan tata ruang</p>
                    <div class="d-flex gap-3 justify-content-center">
                        <button wire:click="$emit('startApplication')" class="btn btn-light btn-lg px-4">
                            <i class="bi bi-file-earmark-plus me-2"></i>Ajukan Sekarang
                        </button>
                        <a href="#info" class="btn btn-outline-light btn-lg px-4">
                            <i class="bi bi-info-circle me-2"></i>Pelajari Lebih Lanjut
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Overview Section -->
    <section id="info" class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <div class="text-center mb-5">
                        <h2 class="fw-bold mb-3">Apa itu KKPR Non Berusaha?</h2>
                        <p class="text-muted">Informasi lengkap tentang Kesesuaian Kegiatan Pemanfaatan Ruang untuk Non Berusaha</p>
                    </div>
                    
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-body p-4">
                            <div class="row align-items-center">
                                <div class="col-md-2 text-center mb-3 mb-md-0">
                                    <i class="bi bi-house-heart text-info" style="font-size: 3rem;"></i>
                                </div>
                                <div class="col-md-10">
                                    <h5 class="card-title fw-bold">Definisi</h5>
                                    <p class="card-text text-muted mb-0">
                                        KKPR Non Berusaha adalah Persetujuan Kesesuaian Kegiatan Pemanfaatan Ruang yang diperlukan untuk kegiatan non-komersial atau tidak berorientasi pada keuntungan. Dokumen ini memastikan bahwa rencana kegiatan seperti pembangunan rumah tinggal, tempat ibadah, fasilitas sosial, dan kegiatan non-profit lainnya sesuai dengan rencana tata ruang dan peraturan zonasi yang berlaku di Kota Mataram.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body text-center">
                                    <div class="bg-info bg-opacity-10 rounded-circle d-inline-flex p-3 mb-3">
                                        <i class="bi bi-clock-history text-info" style="font-size: 2rem;"></i>
                                    </div>
                                    <h5 class="card-title fw-bold">Waktu Proses</h5>
                                    <p class="card-text text-muted">5-7 Hari Kerja</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body text-center">
                                    <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex p-3 mb-3">
                                        <i class="bi bi-currency-dollar text-success" style="font-size: 2rem;"></i>
                                    </div>
                                    <h5 class="card-title fw-bold">Biaya</h5>
                                    <p class="card-text text-muted">Sesuai Perda yang berlaku</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body text-center">
                                    <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex p-3 mb-3">
                                        <i class="bi bi-file-earmark-check text-primary" style="font-size: 2rem;"></i>
                                    </div>
                                    <h5 class="card-title fw-bold">Masa Berlaku</h5>
                                    <p class="card-text text-muted">Sesuai kegiatan yang diajukan</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Activity Types Section -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <div class="text-center mb-5">
                        <h2 class="fw-bold mb-3">Jenis Kegiatan Non Berusaha</h2>
                        <p class="text-muted">Berbagai jenis kegiatan non-komersial yang memerlukan KKPR Non Berusaha</p>
                    </div>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="card border-info h-100 shadow-sm">
                                <div class="card-header bg-info text-white">
                                    <h5 class="mb-0"><i class="bi bi-house-door me-2"></i>Hunian & Tempat Tinggal</h5>
                                </div>
                                <div class="card-body">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                            <i class="bi bi-check-circle-fill text-info me-2"></i>
                                            Rumah tinggal tunggal
                                        </li>
                                        <li class="list-group-item">
                                            <i class="bi bi-check-circle-fill text-info me-2"></i>
                                            Rumah susun/apartemen pribadi
                                        </li>
                                        <li class="list-group-item">
                                            <i class="bi bi-check-circle-fill text-info me-2"></i>
                                            Rumah dinas/mess
                                        </li>
                                        <li class="list-group-item">
                                            <i class="bi bi-check-circle-fill text-info me-2"></i>
                                            Asrama dan pondok pesantren
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card border-primary h-100 shadow-sm">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0"><i class="bi bi-heart me-2"></i>Fasilitas Sosial</h5>
                                </div>
                                <div class="card-body">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                            <i class="bi bi-check-circle-fill text-primary me-2"></i>
                                            Panti asuhan dan panti jompo
                                        </li>
                                        <li class="list-group-item">
                                            <i class="bi bi-check-circle-fill text-primary me-2"></i>
                                            Balai pertemuan warga/RT/RW
                                        </li>
                                        <li class="list-group-item">
                                            <i class="bi bi-check-circle-fill text-primary me-2"></i>
                                            Pos kamling dan pos ronda
                                        </li>
                                        <li class="list-group-item">
                                            <i class="bi bi-check-circle-fill text-primary me-2"></i>
                                            Taman dan ruang terbuka hijau
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card border-success h-100 shadow-sm">
                                <div class="card-header bg-success text-white">
                                    <h5 class="mb-0"><i class="bi bi-moon-stars me-2"></i>Fasilitas Keagamaan</h5>
                                </div>
                                <div class="card-body">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                                            Masjid dan musholla
                                        </li>
                                        <li class="list-group-item">
                                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                                            Gereja dan kapel
                                        </li>
                                        <li class="list-group-item">
                                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                                            Pura dan vihara
                                        </li>
                                        <li class="list-group-item">
                                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                                            Klenteng dan tempat ibadah lainnya
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card border-warning h-100 shadow-sm">
                                <div class="card-header bg-warning text-dark">
                                    <h5 class="mb-0"><i class="bi bi-building-add me-2"></i>Fasilitas Umum Lainnya</h5>
                                </div>
                                <div class="card-body">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                            <i class="bi bi-check-circle-fill text-warning me-2"></i>
                                            Lapangan olahraga non-komersial
                                        </li>
                                        <li class="list-group-item">
                                            <i class="bi bi-check-circle-fill text-warning me-2"></i>
                                            Perpustakaan umum
                                        </li>
                                        <li class="list-group-item">
                                            <i class="bi bi-check-circle-fill text-warning me-2"></i>
                                            Gedung serbaguna komunitas
                                        </li>
                                        <li class="list-group-item">
                                            <i class="bi bi-check-circle-fill text-warning me-2"></i>
                                            Makam dan tempat pemakaman umum
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Requirements Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <div class="text-center mb-5">
                        <h2 class="fw-bold mb-3">Persyaratan Dokumen</h2>
                        <p class="text-muted">Dokumen yang perlu disiapkan untuk pengajuan KKPR Non Berusaha</p>
                    </div>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="card border-info h-100">
                                <div class="card-header bg-info text-white">
                                    <h5 class="mb-0"><i class="bi bi-person-badge me-2"></i>Identitas Pemohon</h5>
                                </div>
                                <div class="card-body">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                            <i class="bi bi-check-circle-fill text-info me-2"></i>
                                            KTP Pemohon (Asli dan masih berlaku)
                                        </li>
                                        <li class="list-group-item">
                                            <i class="bi bi-check-circle-fill text-info me-2"></i>
                                            Kartu Keluarga (untuk rumah tinggal)
                                        </li>
                                        <li class="list-group-item">
                                            <i class="bi bi-check-circle-fill text-info me-2"></i>
                                            Surat Kuasa bermaterai (jika dikuasakan)
                                        </li>
                                        <li class="list-group-item">
                                            <i class="bi bi-check-circle-fill text-info me-2"></i>
                                            KTP Penerima Kuasa (jika dikuasakan)
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card border-primary h-100">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0"><i class="bi bi-geo-alt me-2"></i>Dokumen Tanah/Lokasi</h5>
                                </div>
                                <div class="card-body">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                            <i class="bi bi-check-circle-fill text-primary me-2"></i>
                                            Bukti kepemilikan tanah (Sertifikat/Petok D)
                                        </li>
                                        <li class="list-group-item">
                                            <i class="bi bi-check-circle-fill text-primary me-2"></i>
                                            Surat perjanjian sewa/kontrak (jika sewa)
                                        </li>
                                        <li class="list-group-item">
                                            <i class="bi bi-check-circle-fill text-primary me-2"></i>
                                            PBB tahun terakhir
                                        </li>
                                        <li class="list-group-item">
                                            <i class="bi bi-check-circle-fill text-primary me-2"></i>
                                            Peta lokasi dan koordinat
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="card border-success">
                                <div class="card-header bg-success text-white">
                                    <h5 class="mb-0"><i class="bi bi-file-earmark-text me-2"></i>Dokumen Teknis & Pendukung</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item">
                                                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                                                    Gambar site plan/denah lokasi
                                                </li>
                                                <li class="list-group-item">
                                                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                                                    Gambar rencana bangunan (jika ada)
                                                </li>
                                                <li class="list-group-item">
                                                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                                                    Uraian kegiatan yang akan dilakukan
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item">
                                                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                                                    Surat pernyataan tidak untuk komersial
                                                </li>
                                                <li class="list-group-item">
                                                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                                                    Surat rekomendasi RT/RW (jika diperlukan)
                                                </li>
                                                <li class="list-group-item">
                                                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                                                    Dokumen organisasi (untuk fasilitas sosial)
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info mt-4" role="alert">
                        <i class="bi bi-info-circle-fill me-2"></i>
                        <strong>Catatan:</strong> Semua dokumen harus dalam format PDF atau gambar (JPG/PNG) dengan ukuran maksimal 2MB per file. Pastikan kegiatan yang diajukan benar-benar bersifat non-komersial.
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Process Flow Section -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <div class="text-center mb-5">
                        <h2 class="fw-bold mb-3">Alur Proses Pengajuan</h2>
                        <p class="text-muted">Langkah-langkah mudah untuk mendapatkan KKPR Non Berusaha</p>
                    </div>

                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body text-center">
                                    <div class="bg-info text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                        <h3 class="mb-0">1</h3>
                                    </div>
                                    <h5 class="fw-bold">Pendaftaran & Login</h5>
                                    <p class="text-muted small">Daftar akun baru atau login ke sistem SIMTARU</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body text-center">
                                    <div class="bg-info text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                        <h3 class="mb-0">2</h3>
                                    </div>
                                    <h5 class="fw-bold">Isi Formulir</h5>
                                    <p class="text-muted small">Lengkapi data pemohon dan jenis kegiatan</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body text-center">
                                    <div class="bg-info text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                        <h3 class="mb-0">3</h3>
                                    </div>
                                    <h5 class="fw-bold">Upload Dokumen</h5>
                                    <p class="text-muted small">Unggah semua dokumen persyaratan</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body text-center">
                                    <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                        <h3 class="mb-0">4</h3>
                                    </div>
                                    <h5 class="fw-bold">Verifikasi Administrasi</h5>
                                    <p class="text-muted small">Tim memverifikasi kelengkapan dokumen</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body text-center">
                                    <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                        <h3 class="mb-0">5</h3>
                                    </div>
                                    <h5 class="fw-bold">Verifikasi Teknis</h5>
                                    <p class="text-muted small">Pemeriksaan kesesuaian dengan tata ruang</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body text-center">
                                    <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                        <h3 class="mb-0">6</h3>
                                    </div>
                                    <h5 class="fw-bold">Survei Lapangan</h5>
                                    <p class="text-muted small">Peninjauan lokasi (jika diperlukan)</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body text-center">
                                    <div class="bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                        <h3 class="mb-0">7</h3>
                                    </div>
                                    <h5 class="fw-bold">Pembahasan & Persetujuan</h5>
                                    <p class="text-muted small">Evaluasi dan rekomendasi tim teknis</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body text-center">
                                    <div class="bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                        <h3 class="mb-0">8</h3>
                                    </div>
                                    <h5 class="fw-bold">Penerbitan KKPR</h5>
                                    <p class="text-muted small">Dokumen KKPR Non Berusaha siap diunduh</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <div class="text-center mb-5">
                        <h2 class="fw-bold mb-3">Manfaat KKPR Non Berusaha</h2>
                        <p class="text-muted">Kegunaan dokumen KKPR Non Berusaha untuk kegiatan Anda</p>
                    </div>

                    <div class="row g-4">
                        <div class="col-md-6 col-lg-3">
                            <div class="text-center">
                                <div class="bg-info bg-opacity-10 rounded-circle d-inline-flex p-4 mb-3">
                                    <i class="bi bi-house-check text-info" style="font-size: 2.5rem;"></i>
                                </div>
                                <h5 class="fw-bold">Syarat IMB</h5>
                                <p class="text-muted small">Persyaratan untuk mengurus Izin Mendirikan Bangunan</p>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="text-center">
                                <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex p-4 mb-3">
                                    <i class="bi bi-shield-check text-primary" style="font-size: 2.5rem;"></i>
                                </div>
                                <h5 class="fw-bold">Kepastian Hukum</h5>
                                <p class="text-muted small">Jaminan kesesuaian dengan regulasi tata ruang</p>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="text-center">
                                <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex p-4 mb-3">
                                    <i class="bi bi-bank text-success" style="font-size: 2.5rem;"></i>
                                </div>
                                <h5 class="fw-bold">Pengajuan KPR</h5>
                                <p class="text-muted small">Dokumen pendukung untuk kredit pemilikan rumah</p>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="text-center">
                                <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex p-4 mb-3">
                                    <i class="bi bi-clipboard-data text-warning" style="font-size: 2.5rem;"></i>
                                </div>
                                <h5 class="fw-bold">Perencanaan Tepat</h5>
                                <p class="text-muted small">Acuan dalam merencanakan pembangunan</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="text-center mb-5">
                        <h2 class="fw-bold mb-3">Pertanyaan yang Sering Diajukan</h2>
                        <p class="text-muted">Temukan jawaban atas pertanyaan umum seputar KKPR Non Berusaha</p>
                    </div>

                    <div class="accordion" id="faqAccordion">
                        <div class="accordion-item border-0 shadow-sm mb-3">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                    <i class="bi bi-question-circle me-2 text-info"></i>
                                    Apa perbedaan KKPR Non Berusaha dengan KKPR Berusaha?
                                </button>
                            </h2>
                            <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <strong>KKPR Non Berusaha</strong> diperuntukkan bagi kegiatan non-komersial yang tidak berorientasi pada keuntungan (seperti rumah tinggal, tempat ibadah, fasilitas sosial), sedangkan <strong>KKPR Berusaha</strong> untuk kegiatan usaha atau komersial yang bertujuan mencari keuntungan.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item border-0 shadow-sm mb-3">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                    <i class="bi bi-question-circle me-2 text-info"></i>
                                    Berapa lama proses penerbitan KKPR Non Berusaha?
                                </button>
                            </h2>
                            <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Proses penerbitan KKPR Non Berusaha memakan waktu sekitar <strong>5-7 hari kerja</strong> setelah semua dokumen lengkap dan terverifikasi. Waktu proses lebih cepat dibanding KKPR Berusaha karena persyaratan yang lebih sederhana.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item border-0 shadow-sm mb-3">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                    <i class="bi bi-question-circle me-2 text-info"></i>
                                    Apakah rumah tinggal wajib memiliki KKPR Non Berusaha?
                                </button>
                            </h2>
                            <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Ya, KKPR Non Berusaha <strong>wajib untuk pembangunan rumah tinggal baru</strong> sebagai salah satu persyaratan untuk mengurus Izin Mendirikan Bangunan (IMB). Dokumen ini memastikan rumah Anda dibangun sesuai dengan peraturan zonasi yang berlaku.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item border-0 shadow-sm mb-3">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                    <i class="bi bi-question-circle me-2 text-info"></i>
                                    Bagaimana jika saya menyewa tanah/bangunan?
                                </button>
                            </h2>
                            <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Jika Anda menyewa, Anda tetap dapat mengajukan KKPR Non Berusaha dengan melampirkan <strong>surat perjanjian sewa/kontrak yang sah</strong> dan surat persetujuan dari pemilik tanah/bangunan. Pastikan masa sewa masih berlaku saat pengajuan.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item border-0 shadow-sm mb-3">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq5">
                                    <i class="bi bi-question-circle me-2 text-info"></i>
                                    Apakah renovasi rumah perlu KKPR Non Berusaha baru?
                                </button>
                            </h2>
                            <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Untuk <strong>renovasi kecil</strong> tidak perlu KKPR baru. Namun untuk <strong>renovasi besar yang mengubah struktur, menambah luas bangunan, atau mengubah fungsi bangunan</strong>, Anda perlu mengajukan KKPR Non Berusaha yang baru.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item border-0 shadow-sm mb-3">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq6">
                                    <i class="bi bi-question-circle me-2 text-info"></i>
                                    Apakah tempat ibadah perlu KKPR Non Berusaha?
                                </button>
                            </h2>
                            <div id="faq6" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Ya, <strong>pembangunan tempat ibadah wajib memiliki KKPR Non Berusaha</strong>. Selain itu, tempat ibadah juga memerlukan rekomendasi dari RT/RW setempat dan memenuhi persyaratan khusus sesuai peraturan yang berlaku mengenai pendirian rumah ibadah.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-5 bg-info text-white">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h2 class="fw-bold mb-3">Siap Mengajukan KKPR Non Berusaha?</h2>
                    <p class="lead mb-4">Pastikan kegiatan non-komersial Anda sesuai dengan regulasi tata ruang</p>
                    <div class="d-flex gap-3 justify-content-center flex-wrap">
                        <button wire:click="$emit('startApplication')" class="btn btn-light btn-lg px-5">
                            <i class="bi bi-rocket-takeoff me-2"></i>Mulai Pengajuan Sekarang
                        </button>
                        <a href="#info" class="btn btn-outline-light btn-lg px-5">
                            <i class="bi bi-telephone me-2"></i>Hubungi Kami
                        </a>
                    </div>
                    <div class="mt-4">
                        <small class="text-white-50">
                            <i class="bi bi-shield-check me-1"></i>
                            Proses mudah dan cepat untuk kegiatan non-komersial
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Info -->
    <section class="py-4 bg-dark text-white">
        <div class="container">
            <div class="row g-4 text-center">
                <div class="col-md-4">
                    <i class="bi bi-geo-alt-fill text-info mb-2" style="font-size: 1.5rem;"></i>
                    <p class="mb-0 small">Dinas Penataan Ruang Kota Mataram</p>
                </div>
                <div class="col-md-4">
                    <i class="bi bi-telephone-fill text-info mb-2" style="font-size: 1.5rem;"></i>
                    <p class="mb-0 small">(0370) 1234567</p>
                </div>
                <div class="col-md-4">
                    <i class="bi bi-envelope-fill text-info mb-2" style="font-size: 1.5rem;"></i>
                    <p class="mb-0 small">simtaru@mataramkota.go.id</p>
                </div>
            </div>
        </div>
    </section>
</div>
