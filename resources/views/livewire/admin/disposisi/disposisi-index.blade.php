<div>
    <style>
        .scrollable-cell {
            max-width: 250px;
            /* atur lebar maksimum kolom */
            white-space: nowrap;
            /* supaya teks tidak turun ke bawah */
            overflow-x: auto;
            /* munculkan scroll horizontal */
            overflow-y: hidden;
            /* cegah scroll vertical */

            /* wajib supaya overflow bisa jalan */
        }
    </style>
    <div class="container-xxl flex-grow-1 container-p-y">
        @if (session()->has('success'))
            <div class="bs-toast toast fade show bg-primary top-0 end-0 m-2" role="alert" aria-role="alert"
                aria-live="assertive" aria-atomic="true" data-delay="2000">
                <div class="toast-header">
                    <i class="bx bx-bell me-2"></i>
                    <div class="me-auto fw-semibold">Bootstrap</div>
                    <small>a moment ago</small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">{{ session('success') }}</div>
            </div>
        @endif

        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Disposisi /</span> Daftar Disposisi</h4>

        <!-- Basic Bootstrap Table -->
        <div class="card">
            <h5 class="card-header">List Disposisi Masuk</h5>
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode/Layanan</th>
                            <th>Pemohon</th>
                            <th>Tahapan</th>
                            <th>Pemberi</th>
                            <th>Penerima</th>
                            <th>Tanggal</th>
                            <th>Catatan</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($disposisi_masuk as $data)
                            <div wire:key="{{ $data->id }}">
                                <tr>
                                    <td>
                                        {{ $no++ }}
                                    </td>
                                    <td>
                                        <span class="fw-bold">
                                            {{ $data->permohonan->registrasi->kode }}
                                        </span>
                                        <br>
                                        <small class="text-muted fst-italic ">
                                            {{ $data->permohonan->layanan->nama }}
                                        </small>
                                    </td>
                                    <td>
                                        {{ $data->permohonan->registrasi->nama }}
                                    </td>
                                    <td>
                                        {{ $data->tahapan->nama }}
                                    </td>
                                    <td>
                                        {{ Auth::user()->where('id', $data->pemberi_id)->first()->name ?? '-' }}
                                    </td>
                                    <td>
                                        {{ Auth::user()->where('id', $data->penerima_id)->first()->name ?? '-' }}
                                    </td>
                                    <td>
                                        {{ date('d-m-Y', strtotime($data->tanggal_disposisi)) }} <br>
                                        <small class="text-muted fst-italic">
                                            {{ date('H:i:s', strtotime($data->tanggal_disposisi)) }}
                                        </small>
                                    </td>
                                    <td class="scrollable-cell">
                                        {{ $data->catatan }}
                                    </td>
                                    <td>
                                        <div class="me-3">
                                            <!-- Button trigger modal -->
                                            @if (Auth::user()->role == 'superadmin' || Auth::user()->role == 'supervisor')
                                                <button
                                                    wire:click="$dispatch('disposisi-edit', { id: {{ $data->id }} })"
                                                    type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#editDisposisiModal">
                                                    Edit
                                                </button>
                                            @endif

                                            <a href="{{ route(Str::lower($data->layanan_type_name) . '.detail', ['id' => $data->layanan_id]) }}"
                                                target="_blank" type="button" class="btn btn-primary btn-sm">
                                                Go To
                                            </a>
                                        </div>

                                    </td>
                                </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!--/ Basic Bootstrap Table -->

        @if (Auth::user()->role != 'superadmin')
            <!-- Basic Bootstrap Table -->
            <div class="card mt-5">
                <h5 class="card-header">List Disposisi Keluar</h5>
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode/Layanan</th>
                                <th>Pemohon</th>
                                <th>Tahapan</th>
                                <th>Pemberi</th>
                                <th>Penerima</th>
                                <th>Tanggal</th>
                                <th>Catatan</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($disposisi_keluar as $data)
                                <div wire:key="{{ $data->id }}">
                                    <tr>
                                        <td>
                                            {{ $no++ }}
                                        </td>
                                        <td>
                                            <span class="fw-bold">
                                                {{ $data->permohonan->registrasi->kode }}
                                            </span>
                                            <br>
                                            <small class="text-muted fst-italic ">
                                                {{ $data->permohonan->layanan->nama }}
                                            </small>
                                        </td>
                                        <td>
                                            {{ $data->permohonan->registrasi->nama }}
                                        </td>
                                        <td>
                                            {{ $data->tahapan->nama }}
                                        </td>
                                        <td>
                                            {{ Auth::user()->where('id', $data->pemberi_id)->first()->name ?? '-' }}
                                        </td>
                                        <td>
                                            {{ Auth::user()->where('id', $data->penerima_id)->first()->name ?? '-' }}
                                        </td>
                                        <td>
                                            {{ date('d-m-Y', strtotime($data->tanggal_disposisi)) }} <br>
                                            <small class="text-muted fst-italic">
                                                {{ date('H:i:s', strtotime($data->tanggal_disposisi)) }}
                                            </small>
                                        </td>
                                        <td class="scrollable-cell">
                                            {{ $data->catatan }}
                                        </td>
                                        <td>
                                            <div class="me-3">
                                                <!-- Button trigger modal -->
                                                <button
                                                    wire:click="$dispatch('disposisi-edit', { id: {{ $data->id }}})"
                                                    type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#editDisposisiModal">
                                                    Edit
                                                </button>

                                                <a href="{{ route(Str::lower($data->layanan_type_name) . '.detail', ['id' => $data->layanan_id]) }}"
                                                    target="_blank" type="button" class="btn btn-primary btn-sm">
                                                    Go To
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!--/ Basic Bootstrap Table -->
        @endif
    </div>
    @teleport('body')
        <!-- Edit  Regustrasi Modal -->
        @livewire('admin.disposisi.disposisi-edit')
    @endteleport
</div>
