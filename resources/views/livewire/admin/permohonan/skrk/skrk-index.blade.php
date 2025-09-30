<div>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Permohonan /</span> SKRK</h4>

        <!-- Basic Bootstrap Table -->
        <div class="card">
            <h5 class="card-header">List Permohonan SKRK</h5>
            <div class="row mx-3 mb-3">
                <div class="col d-flex justify-content-end align-items-center">
                    <!-- Search kanan -->
                    <div class="col-2">
                        <input class="form-control" type="search" wire:model.live="search" placeholder="Search"
                            aria-label="Search">
                    </div>
                </div>
            </div>

            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Registrasi</th>
                            <th>Nama Pemohon</th>
                            <th>Tgl Permohonan</th>
                            <th>Layanan</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($skrk as $data)
                            <div wire:key="{{ $data->id }}">
                                <tr>
                                    <td>
                                        {{ $no++ }}
                                    </td>
                                    <td>
                                        <strong>
                                            {{ $data->registrasi->kode }}
                                        </strong>
                                    </td>
                                    <td>
                                        {{ $data->registrasi->nama }}
                                    </td>
                                    <td>
                                        {{ date('d-m-Y', strtotime($data->registrasi->tanggal)) }}
                                    </td>
                                    <td>
                                        {{ $data->layanan->nama }}
                                    </td>
                                    <td>
                                        <span
                                            class="badge bg-label-{{ $data->permohonan->status == 'completed' ? 'success' : 'warning' }} me-1">
                                            {{ is_null($data->permohonan) ? 'Belum Entry' : $data->permohonan->status }}
                                        </span>
                                    </td>
                                    <td>
                                        {{ $data->permohonan->keterangan }}
                                    </td>
                                    <td>
                                        <a href="{{ route('skrk.detail', ['id' => $data->id]) }}" type="button"
                                            class="btn btn-primary btn-sm">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!--/ Basic Bootstrap Table -->
    </div>
</div>
