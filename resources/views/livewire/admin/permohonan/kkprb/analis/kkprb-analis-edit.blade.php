<div>
    <div wire:ignore.self class="modal fade" id="EditKajianKkprbModal" data-bs-backdrop="static" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="kajianKkprbModalLabel1">
                        Tambah Data Kajian Analisa
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form wire:submit="updateKajianAnalisa">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col mb-3">
                                <label for="edit_tgl_oss" class="form-label">Tanggal Permohonan Masuk OSS</label>
                                <input type="date" class="form-control" wire:model="tgl_oss" id="edit_tgl_oss"
                                    placeholder="Masukkan Tanggal Permohonan Masuk OSS">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="edit_oss_id" class="form-label">OSS ID</label>
                                <input type="text" class="form-control" wire:model="oss_id" id="edit_oss_id"
                                    placeholder="Masukkan OSS ID">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="edit_id_proyek" class="form-label">ID Proyek</label>
                                <input type="text" class="form-control" wire:model="id_proyek" id="edit_id_proyek"
                                    placeholder="Masukkan ID Proyek">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="edit_luas_disetujui" class="form-label">Luas Disetujui</label>
                                <input type="text" class="form-control" wire:model="luas_disetujui" id="edit_luas_disetujui"
                                    placeholder="Masukkan Luas Disetujui">
                            </div>
                        </div>                        
                        <div class="row">
                            <div class="col mb-3">
                                <label for="edit_skala_usaha" class="form-label">Skala Usaha</label>
                                <input type="text" class="form-control" wire:model="skala_usaha" id="edit_skala_usaha"
                                    placeholder="Masukkan Skala Usaha">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="edit_jenis_usaha" class="form-label">Jenis Usaha</label>
                                <input type="text" class="form-control" wire:model="jenis_usaha" id="edit_jenis_usaha"
                                    placeholder="Masukkan Jenis Usaha">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="edit_nib" class="form-label">NIB</label>
                                <input type="text" class="form-control" wire:model="nib" id="edit_nib"
                                    placeholder="Masukkan NIB">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="edit_penguasaan_tanah" class="form-label">Informasi Penguasaan Tanah</label>
                                <input type="text" class="form-control" wire:model="penguasaan_tanah" id="edit_penguasaan_tanah"
                                    placeholder="Masukkan Informasi Penguasaan Tanah">
                            </div>
                        </div>    
                        <div class="row">
                            <div class="col mb-3">
                                <label for="edit_jml_bangunan" class="form-label">Jumlah Bangunan Yang Direncanakan</label>
                                <input type="text" class="form-control" wire:model="jml_bangunan" id="edit_jml_bangunan"
                                    placeholder="Masukkan Jumlah Bangunan Yang Direncanakan">
                            </div>
                        </div>   
                        <div class="row">
                            <div class="col mb-3">
                                <label for="edit_jml_lantai" class="form-label">Rencana Lantai Bangunan</label>
                                <input type="text" class="form-control" wire:model="jml_lantai" id="edit_jml_lantai"
                                    placeholder="Masukkan Rencana Lantai Bangunan">
                            </div>
                        </div>   
                        <div class="row">
                            <div class="col mb-3">
                                <label for="edit_luas_lantai" class="form-label">Rencana Luas Lantai Bangunan</label>
                                <input type="text" class="form-control" wire:model="luas_lantai" id="edit_luas_lantai"
                                    placeholder="Masukkan Rencana Luas Lantai Bangunan">
                            </div>
                        </div>   
                        <div class="row">
                            <div class="col mb-3">
                                <label for="edit_kedalaman_min" class="form-label">Kedalaman Minimal</label>
                                <input type="text" class="form-control" wire:model="kedalaman_min" id="edit_kedalaman_min"
                                    placeholder="Masukkan Kedalaman Minimal yang dimohon">
                            </div>
                        </div>   
                        <div class="row">
                            <div class="col mb-3">
                                <label for="edit_kedalaman_max" class="form-label">Kedalaman Maksimal</label>
                                <input type="text" class="form-control" wire:model="kedalaman_max" id="edit_kedalaman_max"
                                    placeholder="Masukkan Kedalaman Maksimal yang dimohon">
                            </div>
                        </div>   
                        <div class="row">
                            <div class="col mb-3">
                                <label for="edit_ketinggian_min" class="form-label">Ketinggian Minimal</label>
                                <input type="text" class="form-control" wire:model="ketinggian_min" id="edit_ketinggian_min"
                                    placeholder="Masukkan Ketinggian Minimal yang dimohon">
                            </div>
                        </div>   
                        <div class="row">
                            <div class="col mb-3">
                                <label for="edit_ketinggian_max" class="form-label">Ketinggian Maksimal</label>
                                <input type="text" class="form-control" wire:model="ketinggian_max" id="edit_ketinggian_max"
                                    placeholder="Masukkan Ketinggian Maksimal yang dimohon">
                            </div>
                        </div>   
                        <div class="row">
                            <div class="col mb-3">
                                <label for="edit_kdb" class="form-label">Koefisien Dasar Bangunan (KDB) Maksimum</label>
                                <input type="text" class="form-control" wire:model="kdb" id="edit_kdb"
                                    placeholder="Masukkan Koefisien Dasar Bangunan">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="edit_klb" class="form-label">Koefisien Lantai Bangunan (KLB)</label>
                                <input type="text" class="form-control" wire:model="klb" id="edit_klb"
                                    placeholder="Masukkan Koefisien Lantai Bangunan">
                            </div>
                        </div>                                                                  
                        <div class="row">
                            <div class="col mb-3">
                                <label for="edit_kdh" class="form-label">Koefisien Dasar Hijau (KDH) Minimal</label>
                                <input type="text" class="form-control" wire:model="kdh" id="edit_kdh"
                                    placeholder="Masukkan Koefisien Dasar Hijau">
                            </div>
                        </div>   
                        <div class="row">
                            <div class="col mb-3">
                                <label for="edit_gsb" class="form-label">Garis Sempadan Bangunan (GSB)</label>
                                <input type="text" class="form-control" wire:model="gsb" id="edit_gsb"
                                    placeholder="Masukkan GSB">
                            </div>
                        </div>                                                                   
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" id="auto-close-btn">
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
            const modal = bootstrap.Modal.getInstance(document.getElementById('EditKajianKkprbModal'));
            if (modal) {
                modal.hide();
            }
        });
    </script>
@endscript  
