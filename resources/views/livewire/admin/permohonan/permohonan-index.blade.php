<div>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Permohonan /</span> Daftar Permohonan</h4>

        <!-- Basic Bootstrap Table -->
        <div class="card">
            <h5 class="card-header">List Data Permohonan</h5>
            <div class="col-4">
                <a href="{{ route('permohonan.create') }}" type="button" class="ms-4 mb-3 btn btn-primary">
                    Input Permohonan
                </a>
            </div>
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Registrasi</th>
                            <th>Nama Pemohon</th>
                            <th>Tgl Permohonan</th>
                            <th>Jenis Layanan</th>
                            <th>Jenis Bangunan</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($permohonans as $data)
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
                                    {{ $data->jenis_bangunan }}
                                </td>
                                <td>
                                    <span
                                        class="badge bg-label-{{ $data->status == 'pending' ? 'danger' : ($data->status == 'process' ? 'warning' : ($data->status == 'completed' ? 'success' : 'secondary')) }} me-1">
                                        {{ $data->status }}
                                    </span>
                                </td>
                                <td>
                                    <div class="me-3">
                                        <a href="{{ route('permohonan.edit', ['id' => $data->id]) }}" type="button"
                                            class="btn btn-primary btn-sm">
                                            Edit
                                        </a>
                                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#basicModal">
                                            Detail
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!--/ Basic Bootstrap Table -->
    </div>
</div>
