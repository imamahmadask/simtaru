<div>
    <div class="content-wrapper min-vh-100 d-flex flex-column justify-content-between">
        <!-- Content -->

        <div class="container-xxl pt-4">
            <div class="row">
                <div class="col-md-3 ms-auto">
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="bx bx-calendar"></i></span>
                        <select id="yearFilter" wire:model.live="year" class="form-select">
                            @foreach ($years as $y)
                                <option value="{{ $y }}">Tahun {{ $y }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

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
                                        <h5 class="text-nowrap mb-2">Rekap Penilaian</h5>
                                        <span class="badge bg-label-warning rounded-pill">Year
                                            {{ $year }}</span>
                                    </div>
                                    <div class="mt-sm-auto">
                                        <h3 class="mb-0">{{ $this->rekap['count_penilaian_year'] }} Berkas</h3>
                                    </div>
                                </div>
                                <div wire:ignore x-data="{
                                    chart: null,
                                    rekap: @entangle('rekap'),
                                    init() {
                                        const profileReportChartConfig = {
                                            chart: {
                                                height: 80,
                                                type: 'line',
                                                toolbar: {
                                                    show: false
                                                },
                                                dropShadow: {
                                                    enabled: true,
                                                    top: 10,
                                                    left: 5,
                                                    blur: 3,
                                                    color: config.colors.warning,
                                                    opacity: 0.15
                                                },
                                                sparkline: {
                                                    enabled: true
                                                }
                                            },
                                            grid: {
                                                show: false,
                                                padding: {
                                                    right: 8
                                                }
                                            },
                                            colors: [config.colors.warning],
                                            dataLabels: {
                                                enabled: false
                                            },
                                            stroke: {
                                                width: 5,
                                                curve: 'smooth'
                                            },
                                            series: [{
                                                data: this.rekap.monthly_counts
                                            }],
                                            xaxis: {
                                                show: false,
                                                lines: {
                                                    show: false
                                                },
                                                labels: {
                                                    show: false
                                                },
                                                axisBorder: {
                                                    show: false
                                                }
                                            },
                                            yaxis: {
                                                show: false
                                            }
                                        };
                                        this.chart = new ApexCharts(this.$refs.profileReportChart, profileReportChartConfig);
                                        this.chart.render();

                                        this.$watch('rekap', (value) => {
                                            this.chart.updateSeries([{
                                                data: value.monthly_counts
                                            }]);
                                        });
                                    }
                                }">
                                    <div x-ref="profileReportChart"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-12 col-md-4 mb-4">
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
                                        <a class="dropdown-item" href="{{ route('penilaian.index') }}">View
                                            More</a>
                                    </div>
                                </div>
                            </div>
                            <span class="d-block fw-bold">Total Penilaian <small class="text-muted fst-italic">({{ $year }})</small></span>
                            <h3 class="card-title text-nowrap">{{ $this->rekap['count_penilaian_year'] }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="p-2 rounded bg-success text-white">
                                    <i class="bx bx-check-double fs-3"></i>
                                </div>                                
                            </div>
                            <span class="d-block fw-bold">Penilaian KKPR/KKKPR <small class="text-muted fst-italic">({{ $year }})</small></span>
                            <h3 class="card-title text-nowrap">{{ $this->rekap['count_kkpr_kkkpr'] }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="p-2 rounded bg-info text-white">
                                    <i class="bx bx-shield fs-3"></i>
                                </div>                                
                            </div>
                            <span class="d-block fw-bold">Penilaian PMP UMK <small class="text-muted fst-italic">({{ $year }})</small></span>
                            <h3 class="card-title text-nowrap">{{ $this->rekap['count_pmp_umk'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>    
            
            <div class="row">
                <div class="col-6 col-md-3 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="p-2 rounded bg-success text-white">
                                    <i class="bx bx-check-double fs-3"></i>
                                </div>                                
                            </div>
                            <span>Penilaian KKPR/KKKPR <br> <b>Sesuai Sebagian</b></span>
                            <h3 class="card-title text-nowrap">{{ $this->rekap['count_kkpr_sesuai_sebagian'] }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="p-2 rounded bg-success text-white">
                                    <i class="bx bx-check-double fs-3"></i>
                                </div>                                
                            </div>
                            <span class="d-block">Penilaian KKPR/KKKPR <br> <b>Sesuai Seluruhnya</b></span>
                            <h3 class="card-title text-nowrap">{{ $this->rekap['count_kkpr_sesuai_seluruhnya'] }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="p-2 rounded bg-info text-white">
                                    <i class="bx bx-shield fs-3"></i>
                                </div>                                
                            </div>
                            <span>Penilaian PMP UMK <br> <b>Sesuai Sebagian</b></span>
                            <h3 class="card-title text-nowrap">{{ $this->rekap['count_pmp_umk_sesuai_sebagian'] }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="p-2 rounded bg-info text-white">
                                    <i class="bx bx-shield fs-3"></i>
                                </div>                                
                            </div>
                            <span class="d-block">Penilaian PMP UMK <br> <b>Sesuai Seluruhnya</b></span>
                            <h3 class="card-title text-nowrap">{{ $this->rekap['count_pmp_umk_sesuai_seluruhnya'] }}</h3>
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
