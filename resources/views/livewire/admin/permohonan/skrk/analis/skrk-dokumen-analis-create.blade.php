<div>
    <div wire:ignore.self class="modal fade" id="AddDokumenSkrkModal" data-bs-backdrop="static" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">
                        Tambah Data Dokumen SKRK
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form wire:submit="createKajianAnalisa">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col mb-3">
                                <label for="create_skala_usaha" class="form-label">Skala Usaha</label>
                                <input type="text" class="form-control" wire:model="skala_usaha" id="create_skala_usaha"
                                    placeholder="Masukkan Skala Usaha">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="create_luas_disetujui" class="form-label">Luas Tanah yang Disetujui</label>
                                <input type="text" class="form-control" wire:model="luas_disetujui"
                                    id="create_luas_disetujui" placeholder="Masukkan Luas Tanah yang Disetujui">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="create_pemanfaatan_ruang" class="form-label">Jenis Pemanfaatan Ruang</label>
                                <input type="text" class="form-control" wire:model="pemanfaatan_ruang"
                                    id="create_pemanfaatan_ruang" placeholder="Masukkan Jenis Pemanfaatan Ruang">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="create_peraturan_zonasi" class="form-label">Peraturan Zonasi</label>
                                <input type="text" class="form-control" wire:model="peraturan_zonasi"
                                    id="create_peraturan_zonasi" placeholder="Masukkan Peraturan Zonasi">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="create_kbli_diizinkan" class="form-label">Kode KBLI Diizinkan</label>
                                <input type="text" class="form-control" wire:model="kbli_diizinkan"
                                    id="create_kbli_diizinkan" placeholder="Masukkan Kode KBLI Diizinkan">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="create_kdb" class="form-label">Koefisien Dasar Bangunan (KDB) Maksimum</label>
                                <input type="text" class="form-control" wire:model="kdb" id="create_kdb"
                                    placeholder="Masukkan Koefisien Dasar Bangunan">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="create_klb" class="form-label">Koefisien Lantai Bangunan (KLB)</label>
                                <input type="text" class="form-control" wire:model="klb" id="create_klb"
                                    placeholder="Masukkan Koefisien Lantai Bangunan">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="create_gsb" class="form-label">Garis Sempadan Bangunan (GSB)</label>
                                <input type="text" class="form-control" wire:model="gsb" id="create_gsb"
                                    placeholder="Masukkan Garis Sempadan Bangunan">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="create_jba" class="form-label">Jarak Bebas Antar Bangunan (JBA)
                                    Minimum</label>
                                <input type="text" class="form-control" wire:model="jba" id="create_jba"
                                    placeholder="Masukkan Jarak Bebas Antar Bangunan">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="create_jbb" class="form-label">Jarak Bebas Belakang (JBB) Minimum
                                    Minimum</label>
                                <input type="text" class="form-control" wire:model="jbb" id="create_jbb"
                                    placeholder="Masukkan Jarak Bebas Belakang">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="create_kdh" class="form-label">Koefisien Dasar Hijau (KDH) Minimal</label>
                                <input type="text" class="form-control" wire:model="kdh" id="create_kdh"
                                    placeholder="Masukkan Koefisien Dasar Hijau">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="create_ktb" class="form-label">Koefisien Tapak Basement (KTB)</label>
                                <input type="text" class="form-control" wire:model="ktb" id="create_ktb"
                                    placeholder="Masukkan Koefisien Tapak Basement">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="create_luas_kavling" class="form-label">Luas Kavling Minimum</label>
                                <input type="text" class="form-control" wire:model="luas_kavling"
                                    id="create_luas_kavling" placeholder="Masukkan Luas Kavling Minimum (m2)">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="create_jaringan_utilitas" class="form-label">Jaringan Utilitas Kota</label>
                                <input type="text" class="form-control" wire:model="jaringan_utilitas"
                                    id="create_jaringan_utilitas" placeholder="Masukkan Jaringan Utilitas Kota">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="edit_persyaratan_pelaksanaan" class="form-label">
                                    Persyaratan Pelaksanaan Kegiatan Pemanfaatan Ruang</label>
                                <textarea class="form-control" wire:model="persyaratan_pelaksanaan"
                                    id="edit_persyaratan_pelaksanaan" placeholder="Masukkan Persyaratan Pelaksanaan" rows="5"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" class="btn btn-primary">
                            Submit
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
            const modal = bootstrap.Modal.getInstance(document.getElementById('AddDokumenSkrkModal'));
            if (modal) {
                modal.hide();
            }
        });
    </script>
@endscript