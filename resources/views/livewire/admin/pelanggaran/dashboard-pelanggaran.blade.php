<div>
    <div class="content-wrapper min-vh-100 d-flex flex-column justify-content-between">
        <!-- Content -->

        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row mb-4">
                <div class="col-lg-8 col-md-8 mb-4 order-0">
                    <div class="card">
                        <div class="d-flex align-items-end row">
                            <div class="col-sm-7">
                                <div class="card-body">
                                    <h5 class="card-title text-primary">Halo, {{ Auth::user()->name }}! 🎉</h5>
                                    <p class="mb-4">
                                        Apa kabarmu hari ini? Semoga sehat dan bahagia selalu.
                                    </p>
                                </div>
                            </div>
                            <div class="col-sm-5 text-center text-sm-left">
                                <div class="card-body pb-0 px-0 px-md-4">
                                    <img src="{{ asset('assets/img/illustrations/man-with-laptop-light.png') }}" height="140"
                                        alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                        data-app-light-img="illustrations/man-with-laptop-light.png" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 mb-4 order-1">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
                                <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                                    <div class="card-title">
                                        <h5 class="text-nowrap mb-2">Rekap Pelanggaran</h5>
                                        <span class="badge bg-label-warning rounded-pill">Year
                                            {{ $year }}</span>
                                    </div>
                                    <div class="mt-sm-auto">
                                        <h3 class="mb-0">{{ $this->rekap['count_pelanggaran_year'] }} Berkas</h3>
                                    </div>
                                </div>
                                <div id="profileReportChart"></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-6 col-md-3 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="p-2 rounded bg-primary text-white">
                                    <i class="bx bx-file fs-3"></i>
                                </div>
                                <div class="dropdown">
                                    <button class="btn p-0" type="button" id="cardOpt3"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                                        <a class="dropdown-item" href="{{ route('pelanggaran.index') }}">View
                                            More</a>
                                    </div>
                                </div>
                            </div>
                            <span>Total Pelanggaran</span>
                            <h3 class="card-title text-nowrap">{{ $this->rekap['count_pelanggaran'] }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="p-2 rounded bg-success text-white">
                                    <i class="bx bx-file fs-3"></i>
                                </div>                                
                            </div>
                            <span>Pelanggaran Selesai</span>
                            <h3 class="card-title text-nowrap">{{ $this->rekap['count_selesai'] }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="p-2 rounded bg-info text-white">
                                    <i class="bx bx-file fs-3"></i>
                                </div>                                
                            </div>
                            <span class="d-block">Pelanggaran Proses</span>
                            <h3 class="card-title text-nowrap">{{ $this->rekap['count_proses'] }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="p-2 rounded bg-danger text-white">
                                    <i class="bx bx-file fs-3"></i>
                                </div>                                
                            </div>
                            <span>Pelanggaran Pending</span>
                            <h3 class="card-title text-nowrap">{{ $this->rekap['count_pending'] }}</h3>
                        </div>
                    </div>
                </div>                                  
            </div>    

            <hr>
            <h5>Rekap Berdasarkan Sumber Informasi</h5>
            <div class="row">
                <div class="col-6 col-md-3 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="p-2 rounded bg-info text-white">
                                    <i class="bx bx-info-circle fs-3"></i>
                                </div>                              
                            </div>
                            <span>Sumber Hasil Pengawasan</span>
                            <h3 class="card-title text-nowrap">{{ $this->rekap['count_sumber_pengawasan'] }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="p-2 rounded bg-warning text-white">
                                    <i class="bx bx-info-circle fs-3"></i>
                                </div>                                
                            </div>
                            <span class="d-block">Sumber Dari Masyarakat</span>
                            <h3 class="card-title text-nowrap">{{ $this->rekap['count_sumber_masyarakat'] }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="p-2 rounded bg-primary text-white">
                                    <i class="bx bx-info-circle fs-3"></i>
                                </div>                               
                            </div>
                            <span>Sumber Hasil Penilaian KKPR/SKRK</span>
                            <h3 class="card-title text-nowrap">{{ $this->rekap['count_sumber_penilaian'] }}</h3>
                        </div>
                    </div>
                </div>  
            </div>
                        
        </div>
        <!-- / Content -->

        <!-- Footer -->
        @include('layouts.footer')
        <!-- / Footer -->

        <div class="content-backdrop fade"></div>
    </div>
</div>
