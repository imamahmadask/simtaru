<div>
    <div class="mb-3">
        <div class="d-flex flex-wrap gap-3">
            @can('manageDataEntry', $itr->permohonan)
                @if ($itr->is_validate && !$itr->permohonan->is_done)
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#addDataFinalItrModal">
                        <i class="bx bx-plus"></i> Data Final
                    </button>
                @endif
            @endcan
        </div>
    </div>
    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between bg-secondary">
                    <h5 class="mb-0 text-white">Finalisasi Permohonan</h5>
                </div>
                <div class="card-body mt-3">
                    <div class="table-responsive text-nowrap mb-3">
                        <table class="table table-hover table-bordered">
                            <thead>
                                <th>Tanggal Terbit</th>
                                <th>No Surat/Dokumen</th>
                                <th>Waktu Penyelesaian</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $itr->permohonan->tgl_selesai }}</td>
                                    <td>{{ $itr->permohonan->no_dokumen }}</td>
                                    <td>{{ $itr->permohonan->waktu_pengerjaan }} Hari</td>
                                    <td>
                                        @can('manageDataEntry', $itr->permohonan)
                                            @if ($itr->is_validate && $itr->permohonan->is_done)
                                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#editDataFinalItrModal">
                                                    <i class="bx bx-edit"></i>
                                                </button>
                                            @endif
                                        @endcan
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between bg-secondary">
                    <h5 class="mb-0 text-white">Berkas Final</h5>
                </div>
                <div class="card-body mt-3">
                    <div class="alert alert-primary" role="alert">
                        <b>
                            Berkas final hasil scan dokumen yang sudah bertanda tangan dan stempel. <br>
                        </b>
                    </div>
                    <div class="table-responsive text-nowrap mb-3">
                        <table class="table table-hover table-bordered">
                            <thead>
                                <th>No</th>
                                <th>Nama Berkas</th>
                                <th>Versi</th>
                                <th>Uploaded At</th>
                                <th>Uploaded By</th>
                                <th>Show</th>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($berkas_final as $berkas)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $berkas->file_name }}</td>
                                        <td>{{ $berkas->versi }}</td>
                                        <td>
                                            {{ date('d-m-Y H:i:s', strtotime($berkas->uploaded_at)) }}
                                        </td>
                                        <td>{{ $berkas->uploadedBy->name }}</td>
                                        <td>
                                            <a href="{{ asset('storage/' . $berkas->file_path) }}"
                                                class="btn btn-sm btn-primary" target="_blank">
                                                <i class="bx bx-show"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @teleport('body')
        @livewire('admin.permohonan.itr.final.final-edit', ['permohonan_id' => $itr->permohonan->id, 'itr_id' => $itr->id])
    @endteleport
    @teleport('body')
        @livewire('admin.permohonan.itr.final.final-add', ['permohonan_id' => $itr->permohonan->id, 'itr_id' => $itr->id])
    @endteleport
</div>
