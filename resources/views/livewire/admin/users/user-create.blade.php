<div>
    <div wire:ignore.self class="modal fade" id="AddUserModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Add User
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form wire:submit="createUser">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" id="name" wire:model="name" name="name"
                                    class="form-control" placeholder="Enter Name" autocomplete="name" />
                                @error('name')
                                    <span class="form-text text-xs text-danger"> {{ $message }} </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" id="email" wire:model="email" name="email"
                                    class="form-control" placeholder="xxxx@xxx.xx" autocomplete="email" />
                                @error('email')
                                    <span class="form-text text-xs text-danger"> {{ $message }} </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col mb-3">
                                <label class="form-label" for="password">Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password" wire:model="password"
                                        name="password" placeholder="**********" />
                                    <span class="input-group-text cursor-pointer" onclick="togglePasswordCreate()">
                                        <!-- Eye open (tampil kalau password sedang terlihat) -->
                                        <i id="eye-open" class="bx bx-show d-none"></i>
                                        <!-- Eye closed (tampil default) -->
                                        <i id="eye-closed" class="bx bx-hide"></i>
                                    </span>
                                </div>
                                @error('password')
                                    <span class="form-text text-xs text-danger"> {{ $message }} </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col mb-3">
                                <label for="role" class="form-label">Role</label>
                                <select class="form-select" id="role" wire:model="role" name="role"
                                    aria-label="Select Role">
                                    <option value="" selected>Pilih Role</option>
                                    <option value="superadmin">Super Admin</option>
                                    <option value="supervisor">Supervisor</option>
                                    <option value="surveyor">Surveyor</option>
                                    <option value="analis">Analis</option>
                                    <option value="cs">Customer Service</option>
                                    <option value="data-entry">Data Entry</option>
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
                            Create User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        function togglePasswordCreate() {
            const input = document.getElementById('password');
            const eyeOpen = document.getElementById('eye-open');
            const eyeClosed = document.getElementById('eye-closed');

            if (input.type === 'password') {
                input.type = 'text';
                // tampilkan eye-open
                eyeOpen.classList.remove('d-none');
                eyeClosed.classList.add('d-none');
            } else {
                input.type = 'password';
                // tampilkan eye-closed
                eyeOpen.classList.add('d-none');
                eyeClosed.classList.remove('d-none');
            }
        }
    </script>
@endpush
