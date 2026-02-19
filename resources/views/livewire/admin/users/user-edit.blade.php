<div>
    <div wire:ignore.self class="modal fade" id="editUserModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Edit User {{ $name }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form wire:submit="editUser">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col mb-3">
                                <label for="edit-name" class="form-label">Name</label>
                                <input type="text" id="edit-name" wire:model="name" name="name"
                                    class="form-control" placeholder="Enter Name" autocomplete="name" />
                                @error('name')
                                    <span class="form-text text-xs text-danger"> {{ $message }} </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col mb-3">
                                <label for="edit-email" class="form-label">Email</label>
                                <input type="text" id="edit-email" wire:model="email" name="email"
                                    class="form-control" placeholder="xxxx@xxx.xx" autocomplete="email" />
                                @error('email')
                                    <span class="form-text text-xs text-danger"> {{ $message }} </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col mb-3">
                                <label class="form-label" for="password-{{ $user_id }}">Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password-{{ $user_id }}"
                                        wire:model="password" name="password" placeholder="**********" />
                                    <span class="input-group-text cursor-pointer"
                                        onclick="togglePassword('password-{{ $user_id }}')">
                                        <!-- Eye open (tampil kalau password terlihat) -->
                                        <i id="eye-open-{{ $user_id }}" class="bx bx-show d-none"></i>
                                        <!-- Eye closed (tampil default) -->
                                        <i id="eye-closed-{{ $user_id }}" class="bx bx-hide"></i>
                                    </span>
                                </div>
                                @error('password')
                                    <span class="form-text text-xs text-danger"> {{ $message }} </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col mb-3">
                                <label for="edit-role" class="form-label">Role</label>
                                <select class="form-select" id="edit-role" wire:model="role" name="role"
                                    aria-label="Select Role">
                                    <option value="" selected>Pilih Role</option>
                                    <option value="superadmin">Super Admin</option>
                                    <option value="supervisor">Supervisor</option>
                                    <option value="surveyor">Surveyor</option>
                                    <option value="analis">Analis</option>
                                    <option value="cs">Customer Service</option>
                                    <option value="data-entry">Data Entry</option>
                                    <option value="admin-pelanggaran">Admin Pelanggaran</option>
                                    <option value="admin-penilaian">Admin Penilaian</option>
                                </select>
                                @error('role')
                                    <span class="form-text text-xs text-danger"> {{ $message }} </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" class="btn btn-primary">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        function togglePassword(id) {
            const input = document.getElementById(id);
            const eyeOpen = document.getElementById('eye-open-' + id.split('-')[1]);
            const eyeClosed = document.getElementById('eye-closed-' + id.split('-')[1]);

            if (!input) return; // biar gak error kalau id tidak ada

            if (input.type === 'password') {
                input.type = 'text';
                eyeOpen.classList.remove('d-none');
                eyeClosed.classList.add('d-none');
            } else {
                input.type = 'password';
                eyeOpen.classList.add('d-none');
                eyeClosed.classList.remove('d-none');
            }
        }
    </script>
@endpush
