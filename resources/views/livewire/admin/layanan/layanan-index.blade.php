<div>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Layanan /</span> Daftar Layanan</h4>
        @if (session()->has('success'))
            <div class="bs-toast toast fade bg-primary top-0 end-0 mb-2" role="alert" aria-role="alert"
                aria-live="assertive" aria-atomic="true" data-delay="2000">
                <div class="toast-header">
                    <i class="bx bx-bell me-2"></i>
                    <div class="me-auto fw-semibold">Success!</div>
                    <small>a moment ago</small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">{{ session('success') }}</div>
            </div>
        @endif
        <!-- Basic Bootstrap Table -->
        <div class="card">
            <h5 class="card-header">List Data Layanan</h5>
            <div class="col-4">
                <button type="button" class="ms-4 mb-3 btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#addLayananModal">
                    Create Layanan
                </button>
            </div>
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Layanan</th>
                            <th>Kode</th>
                            <th>Keterangan</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($layanans as $data)
                            <div wire:key="{{ $data->id }}">
                                <tr>
                                    <td>
                                        {{ $no++ }}
                                    </td>
                                    <td>
                                        {{ $data->nama }}
                                    </td>
                                    <td>
                                        {{ $data->kode }}
                                    </td>
                                    <td>
                                        {{ $data->keterangan }}
                                    </td>
                                    <td>
                                        <div class="me-3">
                                            <!-- Button trigger modal -->
                                            <button wire:click="$dispatch('layanan-edit', { id: {{ $data->id }} })"
                                                type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editLayananModal">
                                                Edit
                                            </button>
                                            <a href="{{ route('layanan.detail', ['id' => $data->id]) }}" type="button"
                                                class="btn btn-primary btn-sm">
                                                Detail
                                            </a>
                                        </div>
                                        <!-- Modal -->
                                        @teleport('body')
                                            <!-- Edit  Regustrasi Modal -->
                                            @livewire('admin.layanan.layanan-edit')
                                        @endteleport
                                    </td>
                                </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!--/ Basic Bootstrap Table -->
    </div>

    <!-- Modal -->
    @teleport('body')
        <!-- Create  Layanan Modal -->
        @livewire('admin.layanan.layanan-create')
    @endteleport
</div>
