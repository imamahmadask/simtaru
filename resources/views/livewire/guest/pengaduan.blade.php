<div>
    <!-- Modal Pengaduan -->
    <div class="modal fade" id="modalPengaduan" tabindex="-1" aria-labelledby="modalPengaduanLabel" aria-hidden="true"
        wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="modalPengaduanLabel">Form Pengaduan Tata Ruang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form wire:submit="submitPengaduan">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="jenis" class="form-label">Jenis</label>
                            <select class="form-select @error('jenis') is-invalid @enderror" id="jenis"
                                wire:model="jenis">
                                <option value="">Pilih Jenis</option>
                                <option value="Pengaduan">Pengaduan</option>
                                <option value="Usulan">Usulan</option>
                            </select>
                            @error('jenis')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="name"
                                wire:model="nama" placeholder="Masukkan nama lengkap Anda">
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Alamat</label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror" id="address" wire:model="alamat" rows="2"
                                placeholder="Masukkan alamat lengkap"></textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">No. Telepon / WhatsApp</label>
                            <input type="tel" class="form-control @error('no_hp') is-invalid @enderror" id="phone"
                                wire:model="no_hp" placeholder="Contoh: 08123456789">
                            @error('no_hp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="pengaduan" class="form-label">Isi Pengaduan</label>
                            <textarea class="form-control @error('pengaduan') is-invalid @enderror" id="pengaduan" wire:model="pengaduan"
                                rows="4" placeholder="Tuliskan detail pengaduan Anda"></textarea>
                            @error('pengaduan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">
                            <span wire:loading.remove wire:target="submitPengaduan">Kirim Pengaduan</span>
                            <span wire:loading wire:target="submitPengaduan">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                Mengirim...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>    

    @script
        <script>
            $wire.on('close-modal-pengaduan', (event) => {
                // Close Modal
                const modalEl = document.getElementById('modalPengaduan');
                const modal = bootstrap.Modal.getInstance(modalEl);
                if (modal) {
                    modal.hide();
                }

                // Show Toast
                const toastEl = document.getElementById('successToast');
                const toastMsg = document.getElementById('toastMessage');
                if (toastEl && toastMsg) {
                    toastMsg.textContent = event.message;
                    const toast = new bootstrap.Toast(toastEl);
                    toast.show();
                }
            });
        </script>
    @endscript
</div>
