<div>
    <div class="content-wrapper min-vh-100 d-flex flex-column justify-content-between">
        <!-- Content -->

        <div class="container-xxl pt-4">
            <div class="row">
                <div class="col-md-3 ms-auto">
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="bx bx-calendar"></i></span>
                        <select class="form-select" wire:model.live="year">
                            @foreach(range(date('Y'), date('Y') - 2) as $y)
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
                                        <h5 class="text-nowrap mb-2">Rekap Pelanggaran</h5>
                                        <span class="badge bg-label-warning rounded-pill">Tahun
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
                            <span class="fw-bold">Total Kasus <small class="text-muted fst-italic">({{ $year }})</small></span>
                            <h3 class="card-title text-nowrap">{{ $this->rekap['count_pelanggaran_year'] }}</h3>
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
                            <span class="fw-bold">Kasus Selesai <small class="text-muted fst-italic">({{ $year }})</small></span>
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
                            <span class="fw-bold">Kasus On Progress <small class="text-muted fst-italic">({{ $year }})</small></span>
                            <h3 class="card-title text-nowrap">{{ $this->rekap['count_on_progress'] }}</h3>
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
                            <span class="fw-bold">Kasus Pelimpahan Berkas <small class="text-muted fst-italic">({{ $year }})</small></span>
                            <h3 class="card-title text-nowrap">{{ $this->rekap['count_pelimpahan'] }}</h3>
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
                            <span class="fw-bold">Hasil Pengawasan <small class="text-muted fst-italic">({{ $year }})</small></span>
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
                            <span class="fw-bold">Dari Masyarakat <small class="text-muted fst-italic">({{ $year }})</small></span>
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
                            <span class="fw-bold">Hasil Penilaian KKPR/SKRK <small class="text-muted fst-italic">({{ $year }})</small></span>
                            <h3 class="card-title text-nowrap">{{ $this->rekap['count_sumber_penilaian'] }}</h3>
                        </div>
                    </div>
                </div>  
            </div>
            <hr>
            <div class="row">
                <!-- Left Side: Rekap Berdasarkan Temuan -->
                <div class="col-lg-6 mb-4">
                    <h5>Rekap Berdasarkan Temuan</h5>
                    <div class="card">
                        <div class="card-body">
                            <div wire:ignore x-data="{
                                chart: null,
                                rekap: @entangle('rekap'),
                                init() {
                                    const options = {
                                        series: [
                                            this.rekap.count_temuan_ada,
                                            this.rekap.count_temuan_tidak_ada
                                        ],
                                        labels: ['Ada Pelanggaran', 'Tidak Ada Pelanggaran'],
                                        chart: {
                                            type: 'donut',
                                            height: 350,
                                            toolbar: { show: false }
                                        },
                                        colors: [
                                            config.colors.danger,
                                            config.colors.success
                                        ],
                                        dataLabels: {
                                            enabled: true,
                                            formatter: function (val, opts) {
                                                return opts.w.globals.series[opts.seriesIndex]
                                            }
                                        },
                                        legend: {
                                            position: 'bottom'
                                        },
                                        plotOptions: {
                                            pie: {
                                                donut: {
                                                    labels: {
                                                        show: true,
                                                        total: {
                                                            show: true,
                                                            label: 'Total',
                                                            formatter: function (w) {
                                                                return w.globals.seriesTotals.reduce((a, b) => a + b, 0)
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    };
                
                                    this.chart = new ApexCharts(this.$refs.temuanChart, options);
                                    this.chart.render();
                
                                    this.$watch('rekap', (value) => {
                                        this.chart.updateSeries([
                                            value.count_temuan_ada,
                                            value.count_temuan_tidak_ada
                                        ]);
                                    });
                                }
                            }">
                                <div x-ref="temuanChart"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Side: Rekap Berdasarkan Indikasi Pelanggaran -->
                <div class="col-lg-6 mb-4">
                    <h5>Rekap Berdasarkan Indikasi Pelanggaran</h5>
                    <div class="card">
                        <div class="card-body">
                            <div wire:ignore x-data="{
                                chart: null,
                                rekap: @entangle('rekap'),
                                init() {
                                    const options = {
                                        series: [{
                                            name: 'Jumlah Berkas',
                                            data: [
                                                this.rekap.count_indikasi_tidak_memiliki_kkpr,
                                                this.rekap.count_indikasi_tidak_memenuhi_ketentuan,
                                                this.rekap.count_indikasi_menghalangi_akses,
                                                this.rekap.count_indikasi_tidak_memiliki_pbg
                                            ]
                                        }],
                                        chart: {
                                            type: 'bar',
                                            height: 350,
                                            toolbar: { show: false }
                                        },
                                        plotOptions: {
                                            bar: {
                                                borderRadius: 4,
                                                horizontal: false,
                                                distributed: true,
                                                columnWidth: '50%',
                                            }
                                        },
                                        dataLabels: {
                                            enabled: true,
                                            formatter: function (val) {
                                                return val.toFixed(0);
                                            }
                                        },
                                        yaxis: {
                                            labels: {
                                                formatter: function (val) {
                                                    return val.toFixed(0);
                                                }
                                            }
                                        },
                                        colors: [
                                            config.colors.danger,
                                            config.colors.success,
                                            config.colors.info,
                                            config.colors.warning
                                        ],
                                        xaxis: {
                                            categories: [
                                                'Tidak Memiliki KKPR/SKRK',
                                                'Tidak Memenuhi Ketentuan Dalam KKPR/SKRK',
                                                'Menghalangi Akses Kawasan Milik Umum',
                                                'Tidak Memiliki PBG'
                                            ],
                                        },
                                        legend: {
                                            show: false
                                        }
                                    };
                
                                    this.chart = new ApexCharts(this.$refs.indikasiChart, options);
                                    this.chart.render();
                
                                    this.$watch('rekap', (value) => {
                                        this.chart.updateSeries([{
                                            data: [
                                                value.count_indikasi_tidak_memiliki_kkpr,
                                                value.count_indikasi_tidak_memenuhi_ketentuan,
                                                value.count_indikasi_menghalangi_akses,
                                                value.count_indikasi_tidak_memiliki_pbg
                                            ]
                                        }]);
                                    });
                                }
                            }">
                                <div x-ref="indikasiChart"></div>
                            </div>
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
