<div>
    <div wire:ignore.self class="modal fade" id="AddDokumenItrModal" data-bs-backdrop="static" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">
                        Tambah Data Dokumen ITR
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form wire:submit="createDokumenAnalisa">
                    <div class="modal-body">
                        <div class="col mb-3">
                            <label for="create_jenis_itr" class="form-label">Jenis Permohonan ITR</label>
                            <select name="jenis_itr" wire:model.live="jenis_itr" id="create_jenis_itr" class="form-select">
                                <option value="" selected>Pilih Jenis ITR</option>
                                <option value="ITR">ITR</option>
                                <option value="ITR-KKKPR">ITR KKKPR</option>
                            </select>
                        </div>
                        @if ($jenis_itr == 'ITR')
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="create_penguasaan_tanah" class="form-label">Informasi Penguasaan Tanah</label>
                                    <textarea class="form-control" wire:model="penguasaan_tanah"
                                        id="create_penguasaan_tanah" placeholder="Masukkan Informasi Penguasaan Tanah" rows="5"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="create_pemanfaatan_ruang" class="form-label">Jenis Pemanfaatan Ruang</label>
                                    <textarea class="form-control" wire:model="pemanfaatan_ruang"
                                        id="create_pemanfaatan_ruang" placeholder="Masukkan Jenis Pemanfaatan Ruang" rows="5"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="create_peraturan_zonasi" class="form-label">Peraturan Zonasi</label>
                                    <textarea class="form-control" wire:model="peraturan_zonasi" id="create_peraturan_zonasi"
                                        placeholder="Masukkan Peraturan Zonasi" rows="5"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="create_persyaratan_pelaksanaan" class="form-label">Persyaratan Pelaksanaan
                                        Kegiatan Pemanfaatan Ruang</label>
                                    <textarea class="form-control" wire:model="persyaratan_pelaksanaan"
                                        id="create_persyaratan_pelaksanaan" placeholder="Masukkan Persyaratan Pelaksanaan" rows="5"></textarea>
                                </div>
                            </div>
                        @elseif($jenis_itr == 'ITR-KKKPR')
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="create_no_kkkpr" class="form-label">No KKKPR</label>
                                    <input type="text" class="form-control" wire:model="no_kkkpr" id="create_no_kkkpr"
                                        placeholder="Masukkan Nomor KKKPR">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <div class="d-flex align-items-center">
                                        <label for="create_dokumen_kkkpr" class="form-label mb-0 me-2">
                                            Upload Dokumen KKKPR
                                            <div wire:loading wire:target="dokumen_kkkpr"
                                                class="spinner-border spinner-border-sm text-primary" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                            @if (!empty($dokumen_kkkpr))
                                                <i wire:loading.remove wire:target="dokumen_kkkpr"
                                                    class="bx bx-check-circle text-success"></i>
                                            @endif
                                        </label>
                                    </div>
                                    <input type="file" class="form-control" wire:model="dokumen_kkkpr"
                                        id="create_dokumen_kkkpr">                                    
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
                                    <label for="create_kdb" class="form-label">Koefisien Dasar Bangunan (KDB)
                                        Maksimum</label>
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
                                    <label for="create_kdh" class="form-label">Koefisien Dasar Hijau (KDH)
                                        Minimal</label>
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
                                    <label for="create_persyaratan_pelaksanaan" class="form-label">Persyaratan Pelaksanaan
                                        Kegiatan Pemanfaatan Ruang</label>
                                    <textarea class="form-control" wire:model="persyaratan_pelaksanaan" id="create_persyaratan_pelaksanaan"
                                        placeholder="Masukkan Persyaratan Pelaksanaan"></textarea>
                                </div>
                            </div>

                        @endif
                        <div class="row">
                            <div class="col mb-3">
                                <label for="create_keterangan" class="form-label">Keterangan</label>
                                <textarea class="form-control" wire:model="keterangan" id="create_keterangan"
                                    placeholder="Masukkan Keterangan"></textarea>
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
            const modal = bootstrap.Modal.getInstance(document.getElementById('AddDokumenItrModal'));
            if (modal) {
                modal.hide();
            }
        });
    </script>
@endscript