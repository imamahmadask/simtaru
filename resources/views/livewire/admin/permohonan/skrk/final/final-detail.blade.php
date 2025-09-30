<div>
    <div class="mb-3">
        <div class="d-flex flex-wrap gap-3">
            @can('manageDataEntry', $skrk->permohonan)
                @if ($skrk->is_validate && !$skrk->permohonan->is_done)
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDataFinalModal">
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
                                    <td>{{ $skrk->permohonan->tgl_selesai }}</td>
                                    <td>{{ $skrk->permohonan->no_dokumen }}</td>
                                    <td>{{ $skrk->permohonan->waktu_pengerjaan }} Hari</td>
                                    <td>
                                        @can('manageDataEntry', $skrk->permohonan)
                                            @if ($skrk->is_validate && $skrk->permohonan->is_done)
                                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#editDataFinalModal">
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
        </div>
    </div>
    @teleport('body')
        @livewire('admin.permohonan.skrk.final.final-edit', ['permohonan_id' => $skrk->permohonan->id, 'skrk_id' => $skrk->id])
    @endteleport
    @teleport('body')
        @livewire('admin.permohonan.skrk.final.final-add', ['permohonan_id' => $skrk->permohonan->id, 'skrk_id' => $skrk->id])
    @endteleport
</div>
