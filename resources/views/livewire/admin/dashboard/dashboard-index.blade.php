<div>
    <div class="content-wrapper min-vh-100 d-flex flex-column justify-content-between">
        <!-- Content -->

        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-body d-flex align-items-center justify-content-between p-3">
                            <div>
                                <h4 class="fw-bold mb-0"><i class="bx bx-calendar me-2"></i>Filter Tahun</h4>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <label for="yearFilter" class="form-label mb-0 fw-semibold">Pilih Tahun:</label>
                                <select id="yearFilter" wire:model.live="year" class="form-select form-select-sm border-primary" style="width: 120px;">
                                    @foreach ($years as $y)
                                        <option value="{{ $y }}">{{ $y }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

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
                                    <img src="../assets/img/illustrations/man-with-laptop-light.png" height="140"
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
                                        <h5 class="text-nowrap mb-2">Rekap Permohonan</h5>
                                        <span class="badge bg-label-warning rounded-pill">Year
                                            {{ $year }}</span>
                                    </div>
                                    <div class="mt-sm-auto">
                                        <h3 class="mb-0">{{ $this->rekap['count_permohonan'] }} Berkas</h3>
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
                                <div class="avatar flex-shrink-0">
                                    <img src="../assets/img/icons/unicons/chart-success.png" alt="chart success"
                                        class="rounded" />
                                </div>
                                <div class="dropdown">
                                    <button class="btn p-0" type="button" id="cardOpt3"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                                        <a class="dropdown-item" href="{{ route('registrasi.index') }}">View
                                            More</a>
                                    </div>
                                </div>
                            </div>
                            <span>Registrasi</span>
                            <h3 class="card-title text-nowrap">{{ $this->rekap['count_registrasi'] }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                    <img src="../assets/img/icons/unicons/wallet-info.png" alt="Credit Card"
                                        class="rounded" />
                                </div>
                                <div class="dropdown">
                                    <button class="btn p-0" type="button" id="cardOpt6"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
                                        <a class="dropdown-item" href="{{ route('permohonan.index') }}">View
                                            More</a>
                                    </div>
                                </div>
                            </div>
                            <span>Permohonan</span>
                            <h3 class="card-title text-nowrap">{{ $this->rekap['count_permohonan'] }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                    <img src="../assets/img/icons/unicons/paypal.png" alt="Credit Card"
                                        class="rounded" />
                                </div>
                                <div class="dropdown">
                                    <button class="btn p-0" type="button" id="cardOpt4"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                </div>
                            </div>
                            <span class="d-block">Layanan</span>
                            <h3 class="card-title text-nowrap">{{ $this->rekap['count_layanan'] }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                    <img src="../assets/img/icons/unicons/cc-primary.png" alt="Credit Card"
                                        class="rounded" />
                                </div>
                                <div class="dropdown">
                                    <button class="btn p-0" type="button" id="cardOpt1"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
                                        <a class="dropdown-item" href="{{ route('pengaduan.index') }}">View
                                            More</a>
                                    </div>
                                </div>
                            </div>
                            <span>Pengaduan</span>
                            <h3 class="card-title text-nowrap">{{ $this->rekap['count_pengaduan'] }}</h3>
                        </div>
                    </div>
                </div>               
            </div>    
            
            <hr>

            <div class="row">
                <h5>Rekapitulasi Permohonan per Layanan</h5>
                <div class="col-6 col-md-3 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="p-2 rounded bg-info text-white">
                                    <i class="bx bx-file fs-3"></i>
                                </div>
                                <div class="dropdown">
                                    <button class="btn p-0" type="button" id="cardOpt3"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                                        <a class="dropdown-item" href="{{ route('skrk.index') }}">View
                                            More</a>
                                    </div>
                                </div>
                            </div>
                            <span>SKRK</span>
                            <h3 class="card-title text-nowrap mb-1">{{ $this->rekap['count_skrk'] }}</h3>
                            <div class="d-flex align-items-center justify-content-between">
                                <small class="text-success fw-semibold"><i class='bx bx-check-double'></i> {{ $this->rekap['count_skrk_done'] }} Selesai</small>
                                <small class="text-muted">{{ $this->rekap['count_skrk'] > 0 ? round(($this->rekap['count_skrk_done'] / $this->rekap['count_skrk']) * 100) : 0 }}%</small>
                            </div>
                            <div class="progress mt-2" style="height: 6px;">
                                <div class="progress-bar bg-info" role="progressbar" style="width: {{ $this->rekap['count_skrk'] > 0 ? ($this->rekap['count_skrk_done'] / $this->rekap['count_skrk'] * 100) : 0 }}%" aria-valuenow="{{ $this->rekap['count_skrk_done'] }}" aria-valuemin="0" aria-valuemax="{{ $this->rekap['count_skrk'] }}"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="p-2 rounded bg-warning text-white">
                                    <i class="bx bx-file fs-3"></i>
                                </div>
                                <div class="dropdown">
                                    <button class="btn p-0" type="button" id="cardOpt6"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
                                        <a class="dropdown-item" href="{{ route('itr.index') }}">View
                                            More</a>
                                    </div>
                                </div>
                            </div>
                            <span>ITR</span>
                            <h3 class="card-title text-nowrap mb-1">{{ $this->rekap['count_itr'] }}</h3>
                            <div class="d-flex align-items-center justify-content-between">
                                <small class="text-success fw-semibold"><i class='bx bx-check-double'></i> {{ $this->rekap['count_itr_done'] }} Selesai</small>
                                <small class="text-muted">{{ $this->rekap['count_itr'] > 0 ? round(($this->rekap['count_itr_done'] / $this->rekap['count_itr']) * 100) : 0 }}%</small>
                            </div>
                            <div class="progress mt-2" style="height: 6px;">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $this->rekap['count_itr'] > 0 ? ($this->rekap['count_itr_done'] / $this->rekap['count_itr'] * 100) : 0 }}%" aria-valuenow="{{ $this->rekap['count_itr_done'] }}" aria-valuemin="0" aria-valuemax="{{ $this->rekap['count_itr'] }}"></div>
                            </div>
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
                                <div class="dropdown">
                                    <button class="btn p-0" type="button" id="cardOpt4"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
                                        <a class="dropdown-item" href="{{ route('kkprb.index') }}">View
                                            More</a>
                                    </div>
                                </div>
                            </div>
                            <span class="d-block">KKPR Berusaha Non UMK</span>
                            <h3 class="card-title text-nowrap mb-1">{{ $this->rekap['count_kkprb'] }}</h3>
                            <div class="d-flex align-items-center justify-content-between">
                                <small class="text-success fw-semibold"><i class='bx bx-check-double'></i> {{ $this->rekap['count_kkprb_done'] }} Selesai</small>
                                <small class="text-muted">{{ $this->rekap['count_kkprb'] > 0 ? round(($this->rekap['count_kkprb_done'] / $this->rekap['count_kkprb']) * 100) : 0 }}%</small>
                            </div>
                            <div class="progress mt-2" style="height: 6px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: {{ $this->rekap['count_kkprb'] > 0 ? ($this->rekap['count_kkprb_done'] / $this->rekap['count_kkprb'] * 100) : 0 }}%" aria-valuenow="{{ $this->rekap['count_kkprb_done'] }}" aria-valuemin="0" aria-valuemax="{{ $this->rekap['count_kkprb'] }}"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="p-2 rounded bg-primary text-white">
                                    <i class="bx bx-file fs-3"></i>
                                </div>
                                <div class="dropdown">
                                    <button class="btn p-0" type="button" id="cardOpt1"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
                                        <a class="dropdown-item" href="{{ route('kkprnb.index') }}">View
                                            More</a>
                                    </div>
                                </div>
                            </div>
                            <span class="d-block">KKPR Non Berusaha</span>
                            <h3 class="card-title text-nowrap mb-1">{{ $this->rekap['count_kkprnb'] }}</h3>
                            <div class="d-flex align-items-center justify-content-between">
                                <small class="text-success fw-semibold"><i class='bx bx-check-double'></i> {{ $this->rekap['count_kkprnb_done'] }} Selesai</small>
                                <small class="text-muted">{{ $this->rekap['count_kkprnb'] > 0 ? round(($this->rekap['count_kkprnb_done'] / $this->rekap['count_kkprnb']) * 100) : 0 }}%</small>
                            </div>
                            <div class="progress mt-2" style="height: 6px;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $this->rekap['count_kkprnb'] > 0 ? ($this->rekap['count_kkprnb_done'] / $this->rekap['count_kkprnb'] * 100) : 0 }}%" aria-valuenow="{{ $this->rekap['count_kkprnb_done'] }}" aria-valuemin="0" aria-valuemax="{{ $this->rekap['count_kkprnb'] }}"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <hr>

            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="mb-0 text-primary">Ringkasan Penyelesaian Permohonan</h5>
                        </div>
                        <div class="table-responsive text-nowrap">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Layanan</th>
                                        <th class="text-center">Total Berkas</th>
                                        <th class="text-center">Selesai</th>
                                        <th class="text-center">% Achievement</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><strong>SKRK</strong></td>
                                        <td class="text-center">{{ $this->rekap['count_skrk'] }}</td>
                                        <td class="text-center text-success"><strong>{{ $this->rekap['count_skrk_done'] }}</strong></td>
                                        <td style="width: 40%">
                                            <div class="d-flex align-items-center">
                                                <div class="progress w-100 me-3" style="height: 8px;">
                                                    <div class="progress-bar bg-info" role="progressbar" style="width: {{ $this->rekap['count_skrk'] > 0 ? ($this->rekap['count_skrk_done'] / $this->rekap['count_skrk'] * 100) : 0 }}%"></div>
                                                </div>
                                                <span>{{ $this->rekap['count_skrk'] > 0 ? round(($this->rekap['count_skrk_done'] / $this->rekap['count_skrk']) * 100) : 0 }}%</span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>ITR</strong></td>
                                        <td class="text-center">{{ $this->rekap['count_itr'] }}</td>
                                        <td class="text-center text-success"><strong>{{ $this->rekap['count_itr_done'] }}</strong></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="progress w-100 me-3" style="height: 8px;">
                                                    <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $this->rekap['count_itr'] > 0 ? ($this->rekap['count_itr_done'] / $this->rekap['count_itr'] * 100) : 0 }}%"></div>
                                                </div>
                                                <span>{{ $this->rekap['count_itr'] > 0 ? round(($this->rekap['count_itr_done'] / $this->rekap['count_itr']) * 100) : 0 }}%</span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>KKPR Berusaha Non UMK</strong></td>
                                        <td class="text-center">{{ $this->rekap['count_kkprb'] }}</td>
                                        <td class="text-center text-success"><strong>{{ $this->rekap['count_kkprb_done'] }}</strong></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="progress w-100 me-3" style="height: 8px;">
                                                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ $this->rekap['count_kkprb'] > 0 ? ($this->rekap['count_kkprb_done'] / $this->rekap['count_kkprb'] * 100) : 0 }}%"></div>
                                                </div>
                                                <span>{{ $this->rekap['count_kkprb'] > 0 ? round(($this->rekap['count_kkprb_done'] / $this->rekap['count_kkprb']) * 100) : 0 }}%</span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>KKPR Non Berusaha</strong></td>
                                        <td class="text-center">{{ $this->rekap['count_kkprnb'] }}</td>
                                        <td class="text-center text-success"><strong>{{ $this->rekap['count_kkprnb_done'] }}</strong></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="progress w-100 me-3" style="height: 8px;">
                                                    <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $this->rekap['count_kkprnb'] > 0 ? ($this->rekap['count_kkprnb_done'] / $this->rekap['count_kkprnb'] * 100) : 0 }}%"></div>
                                                </div>
                                                <span>{{ $this->rekap['count_kkprnb'] > 0 ? round(($this->rekap['count_kkprnb_done'] / $this->rekap['count_kkprnb']) * 100) : 0 }}%</span>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <td><strong>Total</strong></td>
                                        <td class="text-center">{{ $this->rekap['count_total'] }}</td>
                                        <td class="text-center text-success"><strong>{{ $this->rekap['count_total_done'] }}</strong></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="progress w-100 me-3" style="height: 8px;">
                                                    <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $this->rekap['count_total'] > 0 ? ($this->rekap['count_total_done'] / $this->rekap['count_total'] * 100) : 0 }}%"></div>
                                                </div>
                                                <span>{{ $this->rekap['count_total'] > 0 ? round(($this->rekap['count_total_done'] / $this->rekap['count_total']) * 100) : 0 }}%</span>
                                            </div>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <hr>
                
            @if(Auth::user()->role == 'superadmin')
            <div class="row">
                <div class="col-12 mb-4">
                    <div class="card">
                        <div class="card-header d-flex align-items-center justify-content-between bg-secondary">
                            <h5 class="mb-0 text-white">Permohonan Terkini (On Proses)</h5>
                        </div>
                        <div class="card-body mt-3">
                            <div class="table-responsive text-nowrap">
                                <table class="table table-hover table-bordered">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>No. Registrasi</th>
                                            <th class="text-center">Posisi Terkini</th>
                                            <th class="text-center">Survey</th>
                                            <th class="text-center">Analis</th>
                                            <th class="text-center">Verifikasi</th>
                                            <th class="text-center">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($latestPermohonans as $permohonan)
                                            @php
                                                $surveyDays = 0;
                                                $analisDays = 0;
                                                $verifikasiDays = 0;
                                                $surveyNames = [];
                                                $analisNames = [];
                                                $verifikasiNames = [];
                                                $latestDisposisi = $permohonan->disposisi->sortByDesc('created_at')->first();
                                                
                                                foreach ($permohonan->disposisi as $disposisi) {
                                                    $start = \Carbon\Carbon::parse($disposisi->tanggal_disposisi);
                                                    $end = $disposisi->is_done && $disposisi->tgl_selesai ? \Carbon\Carbon::parse($disposisi->tgl_selesai) : now();
                                                    $diff = $start->floatDiffInDays($end);
                                                    
                                                    $tahapanName = strtolower($disposisi->tahapan->nama ?? '');
                                                    $penerimaName = $disposisi->penerima->name ?? 'N/A';
                                                    if (str_contains($tahapanName, 'survey')) {
                                                        $surveyDays += $diff;
                                                        $surveyNames[] = $penerimaName;
                                                    } elseif (str_contains($tahapanName, 'analis')) {
                                                        $analisDays += $diff;
                                                        $analisNames[] = $penerimaName;
                                                    } elseif (str_contains($tahapanName, 'verifikasi')) {
                                                        $verifikasiDays += $diff;
                                                        $verifikasiNames[] = $penerimaName;
                                                    }
                                                }
                                                $totalDays = $surveyDays + $analisDays + $verifikasiDays;
                                            @endphp
                                            <tr>
                                                <td class="text-wrap">
                                                    <strong>{{ $permohonan->registrasi->kode }}</strong>
                                                    <br>
                                                    <small class="text-muted">{{ $permohonan->registrasi->nama }}</small>
                                                </td>
                                                <td class="text-center">
                                                    @if($latestDisposisi)
                                                        <span class="badge bg-label-secondary mb-1">
                                                            {{ $latestDisposisi->tahapan->nama ?? '-' }}
                                                            @if($latestDisposisi->is_revisi)
                                                                <span class="text-danger">(Revisi)</span>
                                                            @endif
                                                        </span>
                                                        <br>
                                                        <small class="text-muted">{{ $latestDisposisi->penerima->name ?? '-' }}</small>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge bg-label-info">{{ round($surveyDays) }} Hari</span>
                                                    @if(count($surveyNames))
                                                        <br><small class="text-muted">{{ implode(', ', array_unique($surveyNames)) }}</small>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge bg-label-warning">{{ round($analisDays) }} Hari</span>
                                                    @if(count($analisNames))
                                                        <br><small class="text-muted">{{ implode(', ', array_unique($analisNames)) }}</small>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge bg-label-primary">{{ round($verifikasiDays) }} Hari</span>
                                                    @if(count($verifikasiNames))
                                                        <br><small class="text-muted">{{ implode(', ', array_unique($verifikasiNames)) }}</small>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge bg-primary">{{ round($totalDays) }} Hari</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-4">
                                {{ $latestPermohonans->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
        <!-- / Content -->

        <!-- Footer -->
        @include('layouts.footer')
        <!-- / Footer -->

        <div class="content-backdrop fade"></div>
    </div>
</div>
