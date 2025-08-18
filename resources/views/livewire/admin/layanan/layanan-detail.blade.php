<div>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Layanan /</span> Detail Layanan</h4>
        <div class="row">
            <div class="col-4">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0 fw-semibold">Data Layanan</h5>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <td>Layanan</td>
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
            <div class="col-8">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0 fw-semibold">Tahapan</h5>
                        <button type="button" class="ms-4 mb-3 btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#AddTahapanModal">
                            <i class="bx bx-plus"></i> Tambah Tahapan
                        </button>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <th>No</th>
                                <th>Nama tahapan</th>
                                <th>Urutan</th>
                                <th>Persyaratan Berkas</th>
                                <th>Actions</th>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($layanan->tahapan as $tahapan)
                                    <tr>
                                        <td>
                                            {{ $no++ }}
                                        </td>
                                        <td>
                                            {{ $tahapan->nama }}
                                        </td>
                                        <td>
                                            {{ $tahapan->urutan }}
                                        </td>
                                        <td>
                                            @if ($tahapan->persyaratanBerkas->count() > 0)
                                                @foreach ($tahapan->persyaratanBerkas as $persyaratan)
                                                    <ul>
                                                        <li>
                                                            {{ $persyaratan->nama_berkas }}
                                                        </li>
                                                    </ul>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td>
                                            <button wire:click="$dispatch('tahapan-edit', { id: {{ $tahapan->id }} })"
                                                type="button" class="btn btn-primary btn-sm mr-1"
                                                data-bs-toggle="modal" data-bs-target="#editTahapanModal">
                                                Edit
                                            </button>
                                            @teleport('body')
                                                <!-- Edit  Regustrasi Modal -->
                                                @livewire('admin.layanan.tahapan.tahapan-edit')
                                            @endteleport
                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#addPersyaratanModal">
                                                Add Persyaratan
                                            </button>
                                            @teleport('body')
                                                <!-- Create Persyaratan Modal -->
                                                @livewire('admin.layanan.persyaratan.persyaratan-berkas-create', ['tahapan_id' => $tahapan->id, 'layanan_id' => $tahapan->layanan_id])
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
        <!-- Create Tahapan Modal -->
        @livewire('admin.layanan.tahapan.tahapan-create', ['layanan_id' => $layanan->id])
    @endteleport
</div>
