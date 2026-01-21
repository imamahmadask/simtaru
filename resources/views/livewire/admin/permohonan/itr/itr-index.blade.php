<div>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Permohonan /</span> ITR</h4>

        <!-- Basic Bootstrap Table -->
        <div class="card">
            <h5 class="card-header">List Permohonan ITR</h5>
            <div class="row mx-3 mb-3">
                <div class="col d-flex justify-content-end align-items-center">
                    <!-- Search kanan -->
                    <div class="col-2">
                        <input class="form-control" type="search" wire:model.live="search" placeholder="Search"
                            aria-label="Search">
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Registrasi</th>
                            <th>Nama Pemohon</th>
                            <th>Tgl Permohonan</th>
                            <th>Waktu Penyelesaian</th>
                            <th>Keterangan</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($itr as $data)
                            <div wire:key="{{ $data->id }}">
                                <tr>
                                    <td>
                                        {{ $no++ }}
                                    </td>
                                    <td class="text-nowrap">
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
                                        @if ($data->permohonan->is_done)
                                            {{ $data->permohonan->waktu_pengerjaan }} Hari
                                        @endif
                                    </td>
                                    <td>
                                        {{ $data->permohonan->keterangan }}
                                    </td>
                                    <td>
                                        <span
                                            class="badge bg-label-{{ $data->permohonan->status == 'completed' ? 'success' : 'warning' }} me-1">
                                            {{ is_null($data->permohonan) ? 'Belum Entry' : $data->permohonan->status }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('itr.detail', ['id' => $data->id]) }}" type="button"
                                            class="btn btn-primary btn-sm">
                                            <i class="bx bx-show"></i>
                                        </a>
                                    </td>
                                </tr>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="row mx-3 my-3">
                <div class="col d-flex justify-content-end align-items-center">
                    {{ $itr->links() }}
                </div>
            </div>
        </div>
        <!--/ Basic Bootstrap Table -->
    </div>
</div>
