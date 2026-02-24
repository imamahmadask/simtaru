<div>
    <div wire:ignore.self class="modal fade" id="AddKajianKkprbModal" data-bs-backdrop="static" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="kajianKkprbModalLabel1">
                        Tambah Data Analisa KKPR Berusaha Non UMK
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form wire:submit="createKajianAnalisa">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col mb-3">
                                <label for="create_tgl_oss" class="form-label">Tanggal Permohonan Masuk OSS</label>
                                <input type="date" class="form-control" wire:model="tgl_oss" id="create_tgl_oss"
                                    placeholder="Masukkan Tanggal Permohonan Masuk OSS">
                            </div>
                        </div>    
                        <div class="row">
                            <div class="col mb-3">
                                <label for="create_oss_id" class="form-label">Nomor OSS ID</label>
                                <input type="text" class="form-control" wire:model="oss_id" id="create_oss_id"
                                    placeholder="Masukkan Nomor OSS ID">
                            </div>
                        </div>    
                        <div class="row">
                            <div class="col mb-3">
                                <label for="create_id_proyek" class="form-label">Proyek ID</label>
                                <input type="text" class="form-control" wire:model="id_proyek" id="create_id_proyek"
                                    placeholder="Masukkan Proyek ID">
                            </div>
                        </div>   
                        <div class="row">
                            <div class="col mb-3">
                                <label for="create_luas_disetujui" class="form-label">Luas Disetujui</label>
                                <input type="text" class="form-control" wire:model="luas_disetujui" id="create_luas_disetujui"
                                    placeholder="Masukkan Luas Disetujui">
                            </div>
                        </div>                         
                        <div class="row">
                            <div class="col mb-3">
                                <label for="create_skala_usaha" class="form-label">Skala Usaha</label>
                                <input type="text" class="form-control" wire:model="skala_usaha" id="create_skala_usaha"
                                    placeholder="Masukkan Skala Usaha">
                            </div>
                        </div>    
                        <div class="row">
                            <div class="col mb-3">
                                <label for="create_jenis_usaha" class="form-label">Jenis Usaha</label>
                                <input type="text" class="form-control" wire:model="jenis_usaha" id="create_jenis_usaha"
                                    placeholder="Masukkan Jenis Usaha">
                            </div>
                        </div>    
                        <div class="row">
                            <div class="col mb-3">
                                <label for="create_penguasaan_tanah" class="form-label">Informasi Penguasaan Tanah</label>
                                <input type="text" class="form-control" wire:model="penguasaan_tanah" id="create_penguasaan_tanah"
                                    placeholder="Masukkan Informasi Penguasaan Tanah">
                            </div>
                        </div>    
                        <div class="row">
                            <div class="col mb-3">
                                <label for="create_jml_bangunan" class="form-label">Jumlah Bangunan Yang Direncanakan</label>
                                <input type="text" class="form-control" wire:model="jml_bangunan" id="create_jml_bangunan"
                                    placeholder="Masukkan Jumlah Bangunan Yang Direncanakan">
                            </div>
                        </div>   
                        <div class="row">
                            <div class="col mb-3">
                                <label for="create_jml_lantai" class="form-label">Rencana Lantai Bangunan</label>
                                <input type="text" class="form-control" wire:model="jml_lantai" id="create_jml_lantai"
                                    placeholder="Masukkan Rencana Lantai Bangunan">
                            </div>
                        </div>   
                        <div class="row">
                            <div class="col mb-3">
                                <label for="create_luas_lantai" class="form-label">Rencana Luas Lantai Bangunan</label>
                                <input type="text" class="form-control" wire:model="luas_lantai" id="create_luas_lantai"
                                    placeholder="Masukkan Rencana Luas Lantai Bangunan">
                            </div>
                        </div>   
                        <div class="row">
                            <div class="col mb-3">
                                <label for="create_kedalaman_min" class="form-label">Kedalaman Minimal</label>
                                <input type="text" class="form-control" wire:model="kedalaman_min" id="create_kedalaman_min"
                                    placeholder="Masukkan Kedalaman Minimal yang dimohon">
                            </div>
                        </div>   
                        <div class="row">
                            <div class="col mb-3">
                                <label for="create_kedalaman_max" class="form-label">Kedalaman Maksimal</label>
                                <input type="text" class="form-control" wire:model="kedalaman_max" id="create_kedalaman_max"
                                    placeholder="Masukkan Kedalaman Maksimal yang dimohon">
                            </div>
                        </div>   
                        <div class="row">
                            <div class="col mb-3">
                                <label for="create_ketinggian_min" class="form-label">Ketinggian Minimal</label>
                                <input type="text" class="form-control" wire:model="ketinggian_min" id="create_ketinggian_min"
                                    placeholder="Masukkan Ketinggian Minimal yang dimohon">
                            </div>
                        </div>   
                        <div class="row">
                            <div class="col mb-3">
                                <label for="create_ketinggian_max" class="form-label">Ketinggian Maksimal</label>
                                <input type="text" class="form-control" wire:model="ketinggian_max" id="create_ketinggian_max"
                                    placeholder="Masukkan Ketinggian Maksimal yang dimohon">
                            </div>
                        </div>   
                        <div class="row">
                            <div class="col mb-3">
                                <label for="create_nib" class="form-label">Nomor Induk Bangunan (NIB)</label>
                                <input type="text" class="form-control" wire:model="nib" id="create_nib"
                                    placeholder="Masukkan Nomor Induk Bangunan">
                            </div>
                        </div>   
                        <div class="row">
                            <div class="col mb-3">
                                <label for="create_indikasi_program" class="form-label">Indikasi Program Pemanfaatan Ruang</label>
                                <input type="text" class="form-control" wire:model="indikasi_program" id="create_indikasi_program"
                                    placeholder="Masukkan Indikasi Program Pemanfaatan Ruang">
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
                                <label for="create_kdh" class="form-label">Koefisien Dasar Hijau (KDH) Minimal</label>
                                <input type="text" class="form-control" wire:model="kdh" id="create_kdh"
                                    placeholder="Masukkan Koefisien Dasar Hijau">
                            </div>
                        </div> 
                        <div class="row">
                            <div class="col mb-3">
                                <label for="create_gsb" class="form-label">Garis Sempadan Bangunan (GSB)</label>
                                <input type="text" class="form-control" wire:model="gsb" id="create_gsb"
                                    placeholder="Masukkan GSB">
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
            const modal = bootstrap.Modal.getInstance(document.getElementById('AddKajianKkprbModal'));
            if (modal) {
                modal.hide();
            }
        });
    </script>
@endscript