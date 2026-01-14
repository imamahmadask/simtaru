<div>
    <div class="mb-3">
        <div class="d-flex flex-wrap gap-3">
            @can('manageDataEntry', $skrk->permohonan)
                @if ($skrk->is_validate && !$skrk->permohonan->no_dokumen)
                    <button type="button" class="btn btn-primary" wire:click="$dispatch('skrk-final-create', { permohonan_id: {{ $skrk->permohonan->id }}, skrk_id: {{ $skrk->id }} })" data-bs-toggle="modal" 
                    data-bs-target="#addDataFinalSkrkModal">
                        <i class="bx bx-plus"></i> Data Final
                    </button>
                    @teleport('body')
                        @livewire('admin.permohonan.skrk.final.final-add')
                    @endteleport
                @endif
                @if ($skrk->permohonan->no_dokumen)
                    <button type="button" class="btn {{ $skrk->permohonan->is_done ? 'btn-success' : 'btn-danger' }}"
                        wire:loading.attr="disabled" data-bs-toggle="modal" data-bs-target="#selesaiFinalisasiSkrkModal"
                        {{ $skrk->permohonan->is_done ? 'disabled' : '' }}>
                        @if ($skrk->permohonan->is_done)
                            <i class="bx bx-check"></i> Selesai Finalisasi
                        @else
                            <i class="bx bx-x"></i> Belum Selesai Finalisasi
                        @endif
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
                                            @if ($skrk->is_validate && $skrk->permohonan->no_dokumen)
                                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" wire:click="$dispatch('skrk-final-edit', { permohonan_id: {{ $skrk->permohonan->id }}, skrk_id: {{ $skrk->id }} })"
                                                    data-bs-target="#editDataFinalSkrkModal" @if($skrk->permohonan->is_done) disabled @endif>
                                                    <i class="bx bx-edit"></i>
                                                </button>

                                                @teleport('body')
                                                    @livewire('admin.permohonan.skrk.final.final-edit')
                                                @endteleport     
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

    <div wire:ignore.self class="modal fade" id="selesaiFinalisasiSkrkModal" data-bs-backdrop="static" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">
                        Proses Finalisasi Selesai
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Pastikan seluruh data dan berkas Finalisasi sudah terunggah.<br>
                    Yakin sudah selesai finalisasi?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                        Tidak
                    </button>
                    <button type="button" class="btn btn-primary" wire:click="selesaiFinalisasi">
                        Ya
                    </button>
                </div>
            </div>
        </div>
    </div>    
</div>
@script
    <script>
        $wire.on('trigger-close-modal', () => {
            const modal = bootstrap.Modal.getInstance(document.getElementById('selesaiFinalisasiSkrkModal'));
            if (modal) {
                modal.hide();
            }
        });
    </script>
@endscript
