<div>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Layanan /</span> Detail Layanan</h4>
        <div class="row">
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0 fw-semibold">Data Layanan</h5>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <td>Nama Layanan</td>
                                <td>:</td>
                                <td>
                                    <strong>{{ $layanan->nama }}</strong>
                                </td>
                            </tr>
                            <tr>
                                <td>Keterangan</td>
                                <td>:</td>
                                <td>
                                    <strong>{{ $layanan->keterangan }}</strong>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0 fw-semibold">Persyaratan Berkas</h5>
                        <button type="button" class="ms-4 mb-3 btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#AddPersyaratanBerkasModal">
                            <i class="bx bx-plus"></i> Tambah Berkas
                        </button>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <th>No</th>
                                <th>Nama Berkas</th>
                                <th>Deskripsi</th>
                                <th>Urutan</th>
                                <th>Wajib</th>
                                <th>Actions</th>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($layanan->persyaratan as $persyaratan)
                                    <tr>
                                        <td>
                                            {{ $no++ }}
                                        </td>
                                        <td>
                                            {{ $persyaratan->nama_berkas }}
                                        </td>
                                        <td>
                                            {{ $persyaratan->deskripsi }}
                                        </td>
                                        <td>
                                            {{ $persyaratan->urutan }}
                                        </td>
                                        <td>
                                            {{ $persyaratan->wajib == 1 ? 'Ya' : 'Tidak' }}
                                        </td>
                                        <td>
                                            <button
                                                wire:click="$dispatch('persyaratan-berkas-edit', { id: {{ $persyaratan->id }} })"
                                                type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editPersyaratanBerkasModal">
                                                Edit
                                            </button>
                                            @teleport('body')
                                                <!-- Edit  Regustrasi Modal -->
                                                @livewire('admin.layanan.persyaratan.persyaratan-berkas-edit')
                                            @endteleport
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

    <!-- Modal -->
    @teleport('body')
        <!-- Edit  User Modal -->
        @livewire('admin.layanan.persyaratan.persyaratan-berkas-create', ['layanan_id' => $layanan->id])
    @endteleport
</div>
