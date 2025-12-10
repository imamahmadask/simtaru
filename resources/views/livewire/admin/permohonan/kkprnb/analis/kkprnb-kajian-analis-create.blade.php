<div>
    <div wire:ignore.self class="modal fade" id="AddKajianKkprnbModal" data-bs-backdrop="static" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="kajianKkprnbModalLabel1">
                        Tambah Data Kajian Analisa
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form wire:submit="createKajianAnalisa">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col mb-3">
                                <label for="create_penguasaan_tanah" class="form-label">Informasi Penguasaan Tanah</label>
                                <input type="text" class="form-control" wire:model="penguasaan_tanah" id="create_penguasaan_tanah"
                                    placeholder="Masukkan Informasi Penguasaan Tanah">
                            </div>
                        </div>    
                        <div class="row">
                            <div class="col mb-3">
                                <label for="create_ada_bangunan" class="form-label">Sudah Ada Bangunan</label>
                                <select name="ada_bangunan" id="create_ada_bangunan" wire:model="ada_bangunan" class="form-control">
                                    <option value="">Pilih</option>
                                    <option value="Ada Bangunan">Ada Bangunan</option>
                                    <option value="Tidak Ada Bangunan">Tidak Ada Bangunan</option>
                                </select>
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
                                <label for="create_kedalaman_min" class="form-label">Kedalaman/ketinggian Minimal</label>
                                <input type="text" class="form-control" wire:model="kedalaman_min" id="create_kedalaman_min"
                                    placeholder="Masukkan Kedalaman/ketinggian Minimal yang dimohon">
                            </div>
                        </div>   
                        <div class="row">
                            <div class="col mb-3">
                                <label for="create_kedalaman_max" class="form-label">Kedalaman/ketinggian Maksimal</label>
                                <input type="text" class="form-control" wire:model="kedalaman_max" id="create_kedalaman_max"
                                    placeholder="Masukkan Kedalaman/ketinggian Maksimal yang dimohon">
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
                                <label for="create_indikasi_program" class="form-label">Indikasi Program Pemanfaatan Ruang</label>
                                <input type="text" class="form-control" wire:model="indikasi_program" id="create_indikasi_program"
                                    placeholder="Masukkan Indikasi Program Pemanfaatan Ruang">
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
                                <label for="create_jaringan_utilitas" class="form-label">Jaringan Utilitas Kota</label>
                                <input type="text" class="form-control" wire:model="jaringan_utilitas"
                                    id="create_jaringan_utilitas" placeholder="Masukkan Jaringan Utilitas Kota">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="create_persyaratan_pelaksanaan" class="form-label">Persyaratan Pelaksanaan
                                    Kegiatan Pemanfaatan Ruang</label>
                                <input type="text" class="form-control" wire:model="persyaratan_pelaksanaan"
                                    id="create_persyaratan_pelaksanaan" placeholder="Masukkan Persyaratan Pelaksanaan">
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
