<div>
    <div class="container-xxl flex-grow-1 container-p-y">
        @if (session()->has('success'))
            <div class="bs-toast toast fade show bg-primary top-0 end-0 m-2" role="alert" aria-role="alert"
                aria-live="assertive" aria-atomic="true" data-delay="2000">
                <div class="toast-header">
                    <i class="bx bx-bell me-2"></i>
                    <div class="me-auto fw-semibold">Bootstrap</div>
                    <small>11 mins ago</small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">{{ session('success') }}</div>
            </div>
        @endif


        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Users /</span> Data User</h4>

        <!-- Basic Bootstrap Table -->
        <div class="card">
            <h5 class="card-header">List Data User</h5>
            <div class="col-4">
                <button type="button" class="ms-4 mb-3 btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#AddUserModal">
                    Add User
                </button>
            </div>
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($users as $user)
                            <div wire:key="{{ $user->id }}">
                                <tr>
                                    <td>
                                        {{ $no++ }}
                                    </td>
                                    <td>
                                        {{ $user->name }}
                                    </td>
                                    <td>
                                        {{ $user->email }}
                                    </td>
                                    <td>
                                        <span class="badge bg-label-primary me-1">
                                            {{ $user->role }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="me-3">
                                            <!-- Button trigger modal -->
                                            <button wire:click="$dispatch('user-edit', { id: {{ $user->id }} })"
                                                type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editUserModal">
                                                Edit
                                            </button>
                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#basicModal">
                                                Hapus
                                            </button>
                                        </div>

                                        <!-- Modal -->
                                        @teleport('body')
                                            <!-- Edit  User Modal -->
                                            @livewire('admin.users.user-edit')
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
        <!-- Edit  User Modal -->
        @livewire('admin.users.user-create')
    @endteleport
</div>
