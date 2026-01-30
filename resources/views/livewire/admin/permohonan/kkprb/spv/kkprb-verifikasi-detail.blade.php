<div>
    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between bg-secondary">
                    <h5 class="mb-0 text-white">Berkas KKPR Berusaha</h5>
                </div>
                <div class="card-body mt-3">
                    <div class="alert alert-primary" role="alert">
                        <b>
                            Berkas draft dari surveyor dan analis. <br>
                        </b>
                        <i>
                            Note : Mohon melakukan verifikasi masing-masing berkas
                            sebelum melanjutkan ke proses cetak dokumen.
                        </i>
                    </div>
                    <div class="table-responsive text-nowrap mb-3">
                        <table class="table table-hover table-bordered">
                            <thead>
                                <th>No</th>
                                <th>Nama Berkas</th>
                                <th>Status</th>
                                <th>Versi</th>
                                <th>Catatan Surveyor/Analis</th>
                                <th>Catatan Verifikator</th>
                                <th>Verifikasi Oleh</th>
                                <th>Tgl Verifikasi</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($berkas_draft as $item)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $item->file_name }}</td>
                                        <td class="text-capitalize">
                                            @switch($item->status)
                                                @case('menunggu')
                                                    <span class="badge bg-label-warning">Menunggu</span>
                                                @break

                                                @case('ditolak')
                                                    <span class="badge bg-label-danger">Ditolak</span>
                                                @break

                                                @case('diterima')
                                                    <span class="badge bg-label-success">Diterima</span>
                                                @break
                                            @endswitch
                                        </td>
                                        <td>
                                            {{ $item->versi }}
                                        </td>
                                        <td>
                                            {{ $item->catatan ?? '-' }}
                                        </td>
                                        <td>
                                            {{ $item->catatan_verifikator }}
                                        </td>
                                        <td>
                                            {{ $item->verifiedBy->name ?? '-' }}
                                        </td>
                                        <td>
                                            {{ $item->verified_at ? date('d-m-Y', strtotime($item->verified_at)) : '-' }}
                                        </td>
                                        <td>
                                            <a href="{{ asset('storage/' . $item->file_path) }}"
                                                class="btn btn-sm btn-primary" target="_blank">
                                                <i class="bx bx-show"></i>
                                            </a>
                                            @if (Auth::user()->role == 'superadmin' || Auth::user()->role == 'supervisor')
                                                @if ($item->status == 'menunggu')
                                                    <button class="btn btn-sm btn-success" data-bs-toggle="modal" wire:click="$dispatch('kkprb-verifikasi-create', { kkprb_id: {{ $kkprb->id }}, berkas_id: {{ $item->id }} })"
                                                        data-bs-target="#VerifikasiModal">
                                                        Verifikasi
                                                    </button>
                                                @elseif($item->status == 'ditolak')
                                                    <button class="btn btn-sm btn-success" data-bs-toggle="modal" wire:click="$dispatch('kkprb-verifikasi-edit', { kkprb_id: {{ $kkprb->id }}, berkas_id: {{ $item->id }} })"
                                                        data-bs-target="#EditVerifikasiModal">
                                                        Edit Verifikasi
                                                    </button>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="alert alert-info" role="alert">
                        <b>Kesimpulan Persetujuan Kesesuaian Kegiatan Pemanfaatan Ruang (KKPR) : {{ $kkprb->kesimpulan }}</b> 
                    </div>
                    
                    <br>
                    <button type="button" class="btn {{ $kkprb->kesimpulan ? 'btn-primary' : 'btn-danger' }}" data-bs-toggle="modal" data-bs-target="#kesimpulanPersetujuanKkprbModal">
                        @if($kkprb->kesimpulan) <i class="bx bx-check"></i> @else  <i class="bx bx-x"></i> @endif Kesimpulan
                    </button>

                    @if ($kkprb->is_survey && $kkprb->is_analis && !$kkprb->is_validate && $count_verifikasi == 0)
                        <button type="button" class="btn {{ $kkprb->is_validate ? 'btn-primary' : 'btn-warning' }}"
                            data-bs-toggle="modal" data-bs-target="#selesaiVerifikasiKkprbModal">
                            <i class="bx bx-check"></i> Selesai Verifikasi Berkas
                        </button>
                    @elseif ($kkprb->is_validate)
                        <button type="button" class="btn btn-success" disabled>
                            <i class="bx bx-check"></i> Semua Berkas Sudah Diverifikasi
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="kesimpulanPersetujuanKkprbModal" data-bs-backdrop="static" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">
                        Kesimpulan Persetujuan Kesesuaian Kegiatan Pemanfaatan Ruang (KKPR) 
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form wire:submit.prevent="submitKesimpulan">
                    <div class="modal-body">
                        <select class="form-select" name="kesimpulan" id="kesimpulan" wire:model="kesimpulan">
                            <option value="">--Pilih--</option>
                            <option value="Disetujui Seluruhnya">Disetujui Seluruhnya</option>
                            <option value="Disetujui Sebagian">Disetujui Sebagian</option>
                            <option value="Ditolak">Ditolak</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-primary">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="selesaiVerifikasiKkprbModal" data-bs-backdrop="static" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">
                        Proses Verifikasi Selesai
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Pastikan seluruh data dan berkas sudah terverifikasi dengan baik.
                    Lanjutkan ke proses cetak dokumen KKPR Berusaha?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                        Tidak
                    </button>
                    <button type="button" class="btn btn-primary" wire:click="selesaiVerifikasi">
                        Ya
                    </button>
                </div>
            </div>
        </div>
    </div>

    @teleport('body')
        @livewire('admin.permohonan.kkprb.spv.kkprb-verifikasi-create', [], key('kkprb-verifikasi-create-'.$kkprb->id))
    @endteleport
    @teleport('body')
        @livewire('admin.permohonan.kkprb.spv.kkprb-verifikasi-edit', [], key('kkprb-verifikasi-edit-'.$kkprb->id))
    @endteleport
</div>
@script
    <script>
        Livewire.on('trigger-close-modal', () => {
            const modalIds = ['selesaiVerifikasiKkprbModal', 'kesimpulanPersetujuanKkprbModal'];
            modalIds.forEach(id => {
                const modalElement = document.getElementById(id);
                if (modalElement) {
                    const modalInstance = bootstrap.Modal.getInstance(modalElement);
                    if (modalInstance) {
                        modalInstance.hide();
                    }
                }
            });
        });
    </script>
@endscript