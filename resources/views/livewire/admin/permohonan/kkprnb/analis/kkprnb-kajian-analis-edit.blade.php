<div>
    <div wire:ignore.self class="modal fade" id="EditKajianKkprnbModal" data-bs-backdrop="static" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="kajianKkprnbModalLabel1">
                        Tambah Data Kajian Analisa
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form wire:submit="updateKajianAnalisa">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col mb-3">
                                <label for="edit_jenis_kegiatan" class="form-label">Jenis Kegiatan</label>
                                <input type="text" class="form-control" wire:model="jenis_kegiatan" id="edit_jenis_kegiatan"
                                    placeholder="Masukkan Jenis Kegiatan">
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
                                <label for="edit_kedalaman_min" class="form-label">Kedalaman/ketinggian Minimal</label>
                                <input type="text" class="form-control" wire:model="kedalaman_min" id="edit_kedalaman_min"
                                    placeholder="Masukkan Kedalaman/ketinggian Minimal yang dimohon">
                            </div>
                        </div>   
                        <div class="row">
                            <div class="col mb-3">
                                <label for="edit_kedalaman_max" class="form-label">Kedalaman/ketinggian Maksimal</label>
                                <input type="text" class="form-control" wire:model="kedalaman_max" id="edit_kedalaman_max"
                                    placeholder="Masukkan Kedalaman/ketinggian Maksimal yang dimohon">
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
                                <label for="edit_indikasi_program" class="form-label">Indikasi Program Pemanfaatan Ruang</label>
                                <input type="text" class="form-control" wire:model="indikasi_program" id="edit_indikasi_program"
                                    placeholder="Masukkan Indikasi Program Pemanfaatan Ruang">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col mb-3">
                                <label for="edit_gsb" class="form-label">Garis Sempadan Bangunan (GSB)</label>
                                <input type="text" class="form-control" wire:model="gsb" id="edit_gsb"
                                    placeholder="Masukkan Garis Sempadan Bangunan">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="edit_jba" class="form-label">Jarak Bebas Antar Bangunan (JBA)
                                    Minimum</label>
                                <input type="text" class="form-control" wire:model="jba" id="edit_jba"
                                    placeholder="Masukkan Jarak Bebas Antar Bangunan">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="edit_jbb" class="form-label">Jarak Bebas Belakang (JBB) Minimum
                                    Minimum</label>
                                <input type="text" class="form-control" wire:model="jbb" id="edit_jbb"
                                    placeholder="Masukkan Jarak Bebas Belakang">
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
                                <label for="edit_ktb" class="form-label">Koefisien Tapak Basement (KTB)</label>
                                <input type="text" class="form-control" wire:model="ktb" id="edit_ktb"
                                    placeholder="Masukkan Koefisien Tapak Basement">
                            </div>
                        </div>                        
                        <div class="row">
                            <div class="col mb-3">
                                <label for="edit_jaringan_utilitas" class="form-label">Jaringan Utilitas Kota</label>
                                <input type="text" class="form-control" wire:model="jaringan_utilitas"
                                    id="edit_jaringan_utilitas" placeholder="Masukkan Jaringan Utilitas Kota">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="edit_persyaratan_pelaksanaan" class="form-label">Persyaratan Pelaksanaan
                                    Kegiatan Pemanfaatan Ruang</label>
                                <textarea class="form-control" wire:model="persyaratan_pelaksanaan" id="edit_persyaratan_pelaksanaan" rows="5"></textarea>
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
            const modal = bootstrap.Modal.getInstance(document.getElementById('EditKajianKkprnbModal'));
            if (modal) {
                modal.hide();
            }
        });
    </script>
@endscript  
