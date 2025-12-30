<div>
    <!-- Hero Section -->
    <section class="bg-success text-white py-5" style="margin-top: 70px;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="display-4 fw-bold mb-3">Informasi Tata Ruang (ITR)</h1>
                    <p class="lead mb-4">Layanan informasi mengenai rencana tata ruang wilayah dan detail tata ruang untuk mendukung perencanaan pembangunan yang berkelanjutan</p>
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
                        <h2 class="fw-bold mb-3">Apa itu ITR?</h2>
                        <p class="text-muted">Informasi lengkap tentang Informasi Tata Ruang</p>
                    </div>
                    
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-body p-4">
                            <div class="row align-items-center">
                                <div class="col-md-2 text-center mb-3 mb-md-0">
                                    <i class="bi bi-map text-success" style="font-size: 3rem;"></i>
                                </div>
                                <div class="col-md-10">
                                    <h5 class="card-title fw-bold">Definisi</h5>
                                    <p class="card-text text-muted mb-0">
                                        ITR (Informasi Tata Ruang) adalah layanan informasi yang memberikan data dan keterangan mengenai rencana tata ruang wilayah, rencana detail tata ruang, dan peraturan zonasi yang berlaku di suatu kawasan. Layanan ini membantu masyarakat memahami arahan pemanfaatan ruang dan ketentuan teknis yang berlaku untuk mendukung perencanaan pembangunan yang sesuai dengan regulasi tata ruang Kota Mataram.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body text-center">
                                    <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex p-3 mb-3">
                                        <i class="bi bi-clock-history text-success" style="font-size: 2rem;"></i>
                                    </div>
                                    <h5 class="card-title fw-bold">Waktu Proses</h5>
                                    <p class="card-text text-muted">3-5 Hari Kerja</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body text-center">
                                    <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex p-3 mb-3">
                                        <i class="bi bi-currency-dollar text-primary" style="font-size: 2rem;"></i>
                                    </div>
                                    <h5 class="card-title fw-bold">Biaya</h5>
                                    <p class="card-text text-muted">Sesuai Perda yang berlaku</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body text-center">
                                    <div class="bg-info bg-opacity-10 rounded-circle d-inline-flex p-3 mb-3">
                                        <i class="bi bi-file-earmark-check text-info" style="font-size: 2rem;"></i>
                                    </div>
                                    <h5 class="card-title fw-bold">Format Output</h5>
                                    <p class="card-text text-muted">Dokumen Digital (PDF)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Types of ITR Section -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <div class="text-center mb-5">
                        <h2 class="fw-bold mb-3">Jenis Informasi Tata Ruang</h2>
                        <p class="text-muted">Berbagai jenis informasi tata ruang yang tersedia</p>
                    </div>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="card border-success h-100 shadow-sm">
                                <div class="card-header bg-success text-white">
                                    <h5 class="mb-0"><i class="bi bi-globe me-2"></i>RTRW (Rencana Tata Ruang Wilayah)</h5>
                                </div>
                                <div class="card-body">
                                    <p class="card-text">Informasi mengenai rencana struktur dan pola ruang wilayah kota yang mencakup:</p>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                                            Rencana struktur ruang (sistem jaringan prasarana)
                                        </li>
                                        <li class="list-group-item">
                                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                                            Rencana pola ruang (kawasan lindung & budidaya)
                                        </li>
                                        <li class="list-group-item">
                                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                                            Arahan pemanfaatan ruang wilayah
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card border-primary h-100 shadow-sm">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0"><i class="bi bi-pin-map me-2"></i>RDTR (Rencana Detail Tata Ruang)</h5>
                                </div>
                                <div class="card-body">
                                    <p class="card-text">Informasi detail mengenai rencana tata ruang kawasan yang mencakup:</p>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                            <i class="bi bi-check-circle-fill text-primary me-2"></i>
                                            Rencana struktur ruang kawasan
                                        </li>
                                        <li class="list-group-item">
                                            <i class="bi bi-check-circle-fill text-primary me-2"></i>
                                            Rencana pola ruang kawasan
                                        </li>
                                        <li class="list-group-item">
                                            <i class="bi bi-check-circle-fill text-primary me-2"></i>
                                            Ketentuan pemanfaatan ruang (zonasi)
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="card border-info shadow-sm">
                                <div class="card-header bg-info text-white">
                                    <h5 class="mb-0"><i class="bi bi-rulers me-2"></i>Peraturan Zonasi</h5>
                                </div>
                                <div class="card-body">
                                    <p class="card-text">Informasi mengenai ketentuan teknis pemanfaatan ruang yang mencakup:</p>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item">
                                                    <i class="bi bi-check-circle-fill text-info me-2"></i>
                                                    Koefisien Dasar Bangunan (KDB)
                                                </li>
                                                <li class="list-group-item">
                                                    <i class="bi bi-check-circle-fill text-info me-2"></i>
                                                    Koefisien Lantai Bangunan (KLB)
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-md-4">
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item">
                                                    <i class="bi bi-check-circle-fill text-info me-2"></i>
                                                    Koefisien Daerah Hijau (KDH)
                                                </li>
                                                <li class="list-group-item">
                                                    <i class="bi bi-check-circle-fill text-info me-2"></i>
                                                    Ketinggian bangunan maksimal
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-md-4">
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item">
                                                    <i class="bi bi-check-circle-fill text-info me-2"></i>
                                                    Garis Sempadan Bangunan (GSB)
                                                </li>
                                                <li class="list-group-item">
                                                    <i class="bi bi-check-circle-fill text-info me-2"></i>
                                                    Jenis kegiatan yang diperbolehkan
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
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
                        <p class="text-muted">Dokumen yang perlu disiapkan untuk pengajuan ITR</p>
                    </div>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="card border-success h-100">
                                <div class="card-header bg-success text-white">
                                    <h5 class="mb-0"><i class="bi bi-person-badge me-2"></i>Identitas Pemohon</h5>
                                </div>
                                <div class="card-body">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                                            Scan KTP Pemohon (Asli dan masih berlaku)
                                        </li>
                                        <li class="list-group-item">
                                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                                            Surat Kuasa bermaterai (jika dikuasakan)
                                        </li>
                                        <li class="list-group-item">
                                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                                            KTP Penerima Kuasa (jika dikuasakan)
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card border-primary h-100">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0"><i class="bi bi-geo-alt me-2"></i>Informasi Lokasi</h5>
                                </div>
                                <div class="card-body">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                            <i class="bi bi-check-circle-fill text-primary me-2"></i>
                                            Alamat lengkap lokasi yang dimohonkan
                                        </li>
                                        <li class="list-group-item">
                                            <i class="bi bi-check-circle-fill text-primary me-2"></i>
                                            Koordinat lokasi (jika ada)
                                        </li>
                                        <li class="list-group-item">
                                            <i class="bi bi-check-circle-fill text-primary me-2"></i>
                                            Peta/sketsa lokasi yang jelas
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info mt-4" role="alert">
                        <i class="bi bi-info-circle-fill me-2"></i>
                        <strong>Catatan:</strong> Semua dokumen harus dalam format PDF atau gambar (JPG/PNG) dengan ukuran maksimal 2MB per file. Pastikan informasi lokasi yang diberikan akurat untuk mendapatkan informasi tata ruang yang tepat.
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
                        <p class="text-muted">Langkah-langkah mudah untuk mendapatkan Informasi Tata Ruang</p>
                    </div>

                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body text-center">
                                    <div class="bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
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
                                    <div class="bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                        <h3 class="mb-0">2</h3>
                                    </div>
                                    <h5 class="fw-bold">Isi Formulir</h5>
                                    <p class="text-muted small">Lengkapi formulir dengan informasi lokasi yang akurat</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body text-center">
                                    <div class="bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                        <h3 class="mb-0">3</h3>
                                    </div>
                                    <h5 class="fw-bold">Upload Dokumen</h5>
                                    <p class="text-muted small">Unggah dokumen identitas dan informasi lokasi</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body text-center">
                                    <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                        <h3 class="mb-0">4</h3>
                                    </div>
                                    <h5 class="fw-bold">Verifikasi</h5>
                                    <p class="text-muted small">Tim memverifikasi kelengkapan dan keakuratan data</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body text-center">
                                    <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                        <h3 class="mb-0">5</h3>
                                    </div>
                                    <h5 class="fw-bold">Penyusunan Informasi</h5>
                                    <p class="text-muted small">Tim menyusun informasi tata ruang sesuai lokasi</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body text-center">
                                    <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                        <h3 class="mb-0">6</h3>
                                    </div>
                                    <h5 class="fw-bold">Penerbitan ITR</h5>
                                    <p class="text-muted small">Dokumen ITR digital siap diunduh</p>
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
                        <h2 class="fw-bold mb-3">Manfaat Informasi Tata Ruang</h2>
                        <p class="text-muted">Kegunaan ITR untuk berbagai keperluan perencanaan</p>
                    </div>

                    <div class="row g-4">
                        <div class="col-md-6 col-lg-3">
                            <div class="text-center">
                                <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex p-4 mb-3">
                                    <i class="bi bi-lightbulb text-success" style="font-size: 2.5rem;"></i>
                                </div>
                                <h5 class="fw-bold">Perencanaan Investasi</h5>
                                <p class="text-muted small">Acuan untuk merencanakan investasi pembangunan</p>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="text-center">
                                <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex p-4 mb-3">
                                    <i class="bi bi-clipboard-check text-primary" style="font-size: 2.5rem;"></i>
                                </div>
                                <h5 class="fw-bold">Studi Kelayakan</h5>
                                <p class="text-muted small">Mendukung penyusunan studi kelayakan proyek</p>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="text-center">
                                <div class="bg-info bg-opacity-10 rounded-circle d-inline-flex p-4 mb-3">
                                    <i class="bi bi-file-earmark-ruled text-info" style="font-size: 2.5rem;"></i>
                                </div>
                                <h5 class="fw-bold">Syarat Perizinan</h5>
                                <p class="text-muted small">Dokumen pendukung untuk berbagai perizinan</p>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="text-center">
                                <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex p-4 mb-3">
                                    <i class="bi bi-graph-up text-warning" style="font-size: 2.5rem;"></i>
                                </div>
                                <h5 class="fw-bold">Analisis Properti</h5>
                                <p class="text-muted small">Informasi penting untuk analisis nilai properti</p>
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
                        <p class="text-muted">Temukan jawaban atas pertanyaan umum seputar ITR</p>
                    </div>

                    <div class="accordion" id="faqAccordion">
                        <div class="accordion-item border-0 shadow-sm mb-3">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                    <i class="bi bi-question-circle me-2 text-success"></i>
                                    Apa perbedaan ITR dengan SKRK?
                                </button>
                            </h2>
                            <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <strong>ITR (Informasi Tata Ruang)</strong> memberikan informasi umum mengenai rencana tata ruang di suatu kawasan, sedangkan <strong>SKRK (Surat Keterangan Rencana Kota)</strong> adalah dokumen resmi yang menyatakan ketentuan teknis tata ruang pada lokasi spesifik. ITR bersifat informatif, sementara SKRK lebih formal dan sering digunakan sebagai syarat perizinan.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item border-0 shadow-sm mb-3">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                    <i class="bi bi-question-circle me-2 text-success"></i>
                                    Berapa lama proses penerbitan ITR?
                                </button>
                            </h2>
                            <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Proses penerbitan ITR memakan waktu sekitar <strong>3-5 hari kerja</strong> setelah semua dokumen persyaratan lengkap dan terverifikasi. Waktu proses lebih cepat dibanding SKRK karena sifatnya yang informatif.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item border-0 shadow-sm mb-3">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                    <i class="bi bi-question-circle me-2 text-success"></i>
                                    Informasi apa saja yang tercantum dalam ITR?
                                </button>
                            </h2>
                            <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    ITR mencakup informasi mengenai <strong>zona pemanfaatan ruang, ketentuan teknis zonasi (KDB, KLB, KDH, GSB, ketinggian bangunan), jenis kegiatan yang diperbolehkan, dan arahan pemanfaatan ruang</strong> berdasarkan RTRW dan RDTR yang berlaku.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item border-0 shadow-sm mb-3">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                    <i class="bi bi-question-circle me-2 text-success"></i>
                                    Apakah ITR bisa digunakan untuk pengajuan kredit bank?
                                </button>
                            </h2>
                            <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    ITR dapat digunakan sebagai <strong>dokumen pendukung untuk studi kelayakan dan analisis properti</strong>, namun untuk pengajuan kredit bank biasanya memerlukan dokumen yang lebih formal seperti SKRK atau IMB. Sebaiknya konfirmasi terlebih dahulu dengan pihak bank mengenai dokumen yang diperlukan.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item border-0 shadow-sm mb-3">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq5">
                                    <i class="bi bi-question-circle me-2 text-success"></i>
                                    Apakah ITR memiliki masa berlaku?
                                </button>
                            </h2>
                            <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    ITR berlaku <strong>selama RTRW dan RDTR yang menjadi dasarnya masih berlaku</strong>. Jika terjadi perubahan atau revisi RTRW/RDTR, maka informasi yang tercantum dalam ITR perlu disesuaikan dengan regulasi terbaru.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item border-0 shadow-sm mb-3">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq6">
                                    <i class="bi bi-question-circle me-2 text-success"></i>
                                    Bagaimana jika lokasi saya berada di zona yang tidak jelas?
                                </button>
                            </h2>
                            <div id="faq6" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Jika lokasi berada di zona yang tidak jelas atau perbatasan zona, <strong>tim teknis akan melakukan verifikasi lebih detail</strong> menggunakan peta digital dan koordinat yang akurat. Pastikan Anda memberikan informasi lokasi yang sejelas mungkin untuk mempercepat proses.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-5 bg-success text-white">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h2 class="fw-bold mb-3">Siap Mendapatkan Informasi Tata Ruang?</h2>
                    <p class="lead mb-4">Proses cepat, mudah, dan dapat dilakukan secara online kapan saja</p>
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
                            Data Anda aman dan terlindungi
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
                    <i class="bi bi-geo-alt-fill text-success mb-2" style="font-size: 1.5rem;"></i>
                    <p class="mb-0 small">Dinas Penataan Ruang Kota Mataram</p>
                </div>
                <div class="col-md-4">
                    <i class="bi bi-telephone-fill text-success mb-2" style="font-size: 1.5rem;"></i>
                    <p class="mb-0 small">(0370) 1234567</p>
                </div>
                <div class="col-md-4">
                    <i class="bi bi-envelope-fill text-success mb-2" style="font-size: 1.5rem;"></i>
                    <p class="mb-0 small">simtaru@mataramkota.go.id</p>
                </div>
            </div>
        </div>
    </section>
</div>
