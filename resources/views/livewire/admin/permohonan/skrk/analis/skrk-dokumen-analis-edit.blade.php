<div>
    <div wire:ignore.self class="modal fade" id="EditDokumenSkrkModal" data-bs-backdrop="static" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">
                        Edit Data Dokumen SKRK
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form wire:submit="editKajianAnalisa">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col mb-3">
                                <label for="skala_usaha" class="form-label">Skala Usaha</label>
                                <input type="text" class="form-control" wire:model="skala_usaha" id="skala_usaha"
                                    placeholder="Masukkan Skala Usaha">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="luas_disetujui" class="form-label">Luas Tanah yang Disetujui</label>
                                <input type="text" class="form-control" wire:model="luas_disetujui"
                                    id="luas_disetujui" placeholder="Masukkan Luas Tanah yang Disetujui">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="pemanfaatan_ruang" class="form-label">Jenis Pemanfaatan Ruang</label>
                                <input type="text" class="form-control" wire:model="pemanfaatan_ruang"
                                    id="pemanfaatan_ruang" placeholder="Masukkan Jenis Pemanfaatan Ruang">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="peraturan_zonasi" class="form-label">Peraturan Zonasi</label>
                                <input type="text" class="form-control" wire:model="peraturan_zonasi"
                                    id="peraturan_zonasi" placeholder="Masukkan Peraturan Zonasi">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="kbli_diizinkan" class="form-label">Kode KBLI Diizinkan</label>
                                <input type="text" class="form-control" wire:model="kbli_diizinkan"
                                    id="kbli_diizinkan" placeholder="Masukkan Kode KBLI Diizinkan">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="kdb" class="form-label">Koefisien Dasar Bangunan (KDB)</label>
                                <input type="text" class="form-control" wire:model="kdb" id="kdb"
                                    placeholder="Masukkan Koefisien Dasar Bangunan">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="klb" class="form-label">Koefisien Lantai Bangunan (KLB)</label>
                                <input type="text" class="form-control" wire:model="klb" id="klb"
                                    placeholder="Masukkan Koefisien Lantai Bangunan">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="gsb" class="form-label">Garis Sempadan Bangunan (GSB)</label>
                                <input type="text" class="form-control" wire:model="gsb" id="gsb"
                                    placeholder="Masukkan Garis Sempadan Bangunan">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="jba" class="form-label">Jarak Bebas Antar Bangunan (JBA)
                                    Minimum</label>
                                <input type="text" class="form-control" wire:model="jba" id="jba"
                                    placeholder="Masukkan Jarak Bebas Antar Bangunan">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="jbb" class="form-label">Jarak Bebas Belakang (JBB) Minimum
                                    Minimum</label>
                                <input type="text" class="form-control" wire:model="jbb" id="jbb"
                                    placeholder="Masukkan Jarak Bebas Belakang">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="kdh" class="form-label">Koefisien Dasar Hijau (KDH) Minimal</label>
                                <input type="text" class="form-control" wire:model="kdh" id="kdh"
                                    placeholder="Masukkan Koefisien Dasar Hijau">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="ktb" class="form-label">Koefisien Tapak Basement (KTB)</label>
                                <input type="text" class="form-control" wire:model="ktb" id="ktb"
                                    placeholder="Masukkan Koefisien Tapak Basement">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="luas_kavling" class="form-label">Luas Kavling Minimum</label>
                                <input type="text" class="form-control" wire:model="luas_kavling"
                                    id="luas_kavling" placeholder="Masukkan Luas Kavling Minimum (m2)">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="jaringan_utilitas" class="form-label">Jaringan Utilitas Kota</label>
                                <input type="text" class="form-control" wire:model="jaringan_utilitas"
                                    id="jaringan_utilitas" placeholder="Masukkan Jaringan Utilitas Kota">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="persyaratan_pelaksanaan" class="form-label">Persyaratan Pelaksanaan
                                    Kegiatan Pemanfaatan Ruang</label>
                                <input type="text" class="form-control" wire:model="persyaratan_pelaksanaan"
                                    id="persyaratan_pelaksanaan" placeholder="Masukkan Persyaratan Pelaksanaan">
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
@script
    <script>
        $wire.on('trigger-close-modal', () => {
            const modal = bootstrap.Modal.getInstance(document.getElementById('EditDokumenSkrkModal'));
            if (modal) {
                modal.hide();
            }
        });
    </script>
@endscript