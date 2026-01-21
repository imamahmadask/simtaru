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
                            <th>Tanggal</th>
                            <th>Kode/Layanan</th>
                            <th>Pemohon</th>
                            <th>Tahapan</th>
                            <th>Pemberi</th>
                            <th>Penerima</th>
                            <th>Catatan</th>
                            <th class="text-center">Selesai</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">

                        @foreach ($disposisi as $data)
                            <div wire:key="{{ $data->id }}">
                                <tr>
                                    <td>
                                        {{ ($disposisi->currentPage() - 1) * $disposisi->perPage() + $loop->iteration }}
                                    </td>
                                    <td>
                                        {{ date('d-m-Y', strtotime($data->tanggal_disposisi)) }} <br>
                                        <small class="text-muted fst-italic">
                                            {{ date('H:i:s', strtotime($data->tanggal_disposisi)) }}
                                        </small>
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
                                    <td class="text-wrap">
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
                                        <button type="button" class="btn btn-outline-primary btn-sm"
                                            data-bs-toggle="modal" data-bs-target="#catatanModal{{ $data->id }}">
                                            Lihat
                                        </button>
                                    </td>
                                    <td class="text-center">
                                        @if ($data->is_done)
                                            <span class="badge badge-center bg-label-success me-1">
                                                <i class="bx bx-check"></i>
                                            </span>
                                        @else
                                            <span class="badge badge-center bg-label-danger me-1">
                                                <i class="bx bx-block"></i>
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="me-3">
                                            <!-- Button trigger modal -->
                                            @if (Auth::user()->role == 'superadmin' || Auth::user()->role == 'supervisor')
                                                <button
                                                    wire:click="$dispatch('disposisi-edit', { id: {{ $data->id }} })"
                                                    type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#editDisposisiModal">
                                                    <i class="bx bx-edit"></i>
                                                </button>
                                            @endif

                                            <a href="{{ route(Str::lower($data->layanan_type_name) . '.detail', ['id' => $data->layanan_id]) }}"
                                                target="_blank" type="button" class="btn btn-primary btn-sm">
                                                <i class="bx bx-link-external"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            </div>
                            <!-- Modal -->
                            <div class="modal fade" id="catatanModal{{ $data->id }}" tabindex="-1"
                                aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="catatanModalLabel">Catatan
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            {{ $data->catatan }}
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-secondary"
                                                data-bs-dismiss="modal">
                                                Tutup
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="row mx-3 my-3">
                <div class="col d-flex justify-content-end align-items-center">
                    {{ $disposisi->links() }}
                </div>
            </div>
        </div>
        <!--/ Basic Bootstrap Table -->

        @if (Auth::user()->role != 'superadmin')
            <!-- Basic Bootstrap Table -->
            <div class="card mt-5">
                <h5 class="card-header">List Disposisi Selesai</h5>
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Kode/Layanan</th>
                                <th>Pemohon</th>
                                <th>Tahapan</th>
                                <th>Pemberi</th>
                                <th>Penerima</th>
                                <th>Catatan</th>
                                <th class="text-center">Selesai</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">

                            @foreach ($disposisi_selesai as $data)
                                <div wire:key="{{ $data->id }}">
                                    <tr>
                                        <td>
                                            {{ ($disposisi_selesai->currentPage() - 1) * $disposisi_selesai->perPage() + $loop->iteration }}
                                        </td>
                                        <td>
                                            {{ date('d-m-Y', strtotime($data->tanggal_disposisi)) }} <br>
                                            <small class="text-muted fst-italic">
                                                {{ date('H:i:s', strtotime($data->tanggal_disposisi)) }}
                                            </small>
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
                                            <button type="button" class="btn btn-outline-primary btn-sm"
                                                data-bs-toggle="modal"
                                                data-bs-target="#catatanModal{{ $data->id }}">
                                                Lihat
                                            </button>
                                        </td>
                                        <td class="text-center">
                                            @if ($data->is_done)
                                                <span class="badge badge-center bg-label-success me-1">
                                                    <i class="bx bx-check"></i>
                                                </span>
                                            @else
                                                <span class="badge badge-center bg-label-danger me-1">
                                                    <i class="bx bx-block"></i>
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                </div>
                                <!-- Modal -->
                                <div class="modal fade" id="catatanModal{{ $data->id }}" tabindex="-1"
                                    aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="catatanModalLabel">Catatan
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                {{ $data->catatan }}
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-outline-secondary"
                                                    data-bs-dismiss="modal">
                                                    Tutup
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="row mx-3 my-3">
                    <div class="col d-flex justify-content-end align-items-center">
                        {{ $disposisi->links() }}
                    </div>
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
@script
    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('toast', (event) => {
                const { type = 'success', message = 'Berhasil!' } = event[0] || event;

                // Pakai Bootstrap 5 Toast (atau SweetAlert2 kalau mau lebih cantik)
                const toastEl = document.createElement('div');
                toastEl.className = `bs-toast toast align-items-center text-white bg-${type === 'error' ? 'danger' : 'success'} bg-${type === 'error' ? 'danger' : 'success'} fade show position-fixed top-0 end-0 m-3`;
                toastEl.style.zIndex = 9999;
                toastEl.setAttribute('role', 'alert');
                toastEl.innerHTML = `
                    <div class="d-flex">
                        <div class="toast-body">
                            <strong>${type === 'success' ? 'Berhasil!' : 'Gagal!'}</strong><br>
                            ${message}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                    </div>
                `;

                document.body.appendChild(toastEl);

                // Init dan tampilkan
                const toast = new bootstrap.Toast(toastEl, { delay: 4000 });
                toast.show();

                // Hapus dari DOM setelah selesai
                toastEl.addEventListener('hidden.bs.toast', () => toastEl.remove());
            });
        });
    </script>
@endscript