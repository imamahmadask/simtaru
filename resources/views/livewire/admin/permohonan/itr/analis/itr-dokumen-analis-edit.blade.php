<div>
    <div wire:ignore.self class="modal fade" id="EditDokumenItrModal" data-bs-backdrop="static" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">
                        Edit Data Dokumen ITR
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form wire:submit="editDokumenAnalisa">
                    <div class="modal-body">
                        <div class="col mb-3">
                            <label for="edit_jenis_itr" class="form-label">Jenis Permohonan ITR</label>
                            <select name="jenis_itr" wire:model.live="jenis_itr" id="edit_jenis_itr" class="form-select">
                                <option value="" selected>Pilih Jenis ITR</option>
                                <option value="ITR">ITR</option>
                                <option value="ITR-KKKPR">ITR KKKPR</option>
                            </select>
                        </div>
                        @if ($jenis_itr == 'ITR')
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="edit_penguasaan_tanah" class="form-label">Informasi Penguasaan Tanah</label>
                                    <input type="text" class="form-control" wire:model="penguasaan_tanah"
                                        id="edit_penguasaan_tanah" placeholder="Masukkan Informasi Penguasaan Tanah">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="edit_pemanfaatan_ruang" class="form-label">Jenis Pemanfaatan Ruang</label>
                                    <input type="text" class="form-control" wire:model="pemanfaatan_ruang"
                                        id="edit_pemanfaatan_ruang" placeholder="Masukkan Jenis Pemanfaatan Ruang">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="edit_peraturan_zonasi" class="form-label">Peraturan Zonasi</label>
                                    <input type="text" class="form-control" wire:model="peraturan_zonasi"
                                        id="edit_peraturan_zonasi" placeholder="Masukkan Peraturan Zonasi">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="edit_persyaratan_pelaksanaan" class="form-label">Persyaratan Pelaksanaan
                                        Kegiatan Pemanfaatan Ruang</label>
                                    <input type="text" class="form-control" wire:model="persyaratan_pelaksanaan"
                                        id="edit_persyaratan_pelaksanaan" placeholder="Masukkan Persyaratan Pelaksanaan">
                                </div>
                            </div>
                        @elseif($jenis_itr == 'ITR-KKKPR')
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="edit_no_kkkpr" class="form-label">No KKKPR</label>
                                    <input type="text" class="form-control" wire:model="no_kkkpr" id="edit_no_kkkpr"
                                        placeholder="Masukkan Nomor KKKPR">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <div class="d-flex align-items-center">
                                        <label for="edit_dokumen_kkkpr" class="form-label mb-0 me-2">
                                            Upload Dokumen KKKPR
                                            {{-- Spinner saat proses upload --}}
                                            <div wire:loading wire:target="dokumen_kkkpr"
                                                class="spinner-border spinner-border-sm text-primary" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                            {{-- Tanda centang setelah upload selesai --}}
                                            @if (!empty($dokumen_kkkpr))
                                                <i wire:loading.remove wire:target="dokumen_kkkpr"
                                                    class="bx bx-check-circle text-success"></i>
                                            @endif
                                        </label>
                                    </div>
                                    <input type="file" class="form-control" wire:model="dokumen_kkkpr"
                                        id="edit_dokumen_kkkpr">
                                    @if ($dokumen_kkkpr_old)
                                        <div class="mt-2">
                                            <a href="{{ asset('storage/' . $dokumen_kkkpr_old) }}" target="_blank"
                                                class="text-primary">
                                                <i class="bx bx-file"></i> Lihat Berkas
                                            </a>
                                        </div>
                                    @endif
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
                                    <label for="edit_luas_disetujui" class="form-label">Luas Tanah yang Disetujui</label>
                                    <input type="text" class="form-control" wire:model="luas_disetujui"
                                        id="edit_luas_disetujui" placeholder="Masukkan Luas Tanah yang Disetujui">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="edit_pemanfaatan_ruang" class="form-label">Jenis Pemanfaatan Ruang</label>
                                    <input type="text" class="form-control" wire:model="pemanfaatan_ruang"
                                        id="edit_pemanfaatan_ruang" placeholder="Masukkan Jenis Pemanfaatan Ruang">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="edit_peraturan_zonasi" class="form-label">Peraturan Zonasi</label>
                                    <input type="text" class="form-control" wire:model="peraturan_zonasi"
                                        id="edit_peraturan_zonasi" placeholder="Masukkan Peraturan Zonasi">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="edit_kbli_diizinkan" class="form-label">Kode KBLI Diizinkan</label>
                                    <input type="text" class="form-control" wire:model="kbli_diizinkan"
                                        id="edit_kbli_diizinkan" placeholder="Masukkan Kode KBLI Diizinkan">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="edit_kdb" class="form-label">Koefisien Dasar Bangunan (KDB)</label>
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
                                    <label for="edit_kdh" class="form-label">Koefisien Dasar Hijau (KDH)
                                        Minimal</label>
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
                                    <label for="edit_luas_kavling" class="form-label">Luas Kavling Minimum</label>
                                    <input type="text" class="form-control" wire:model="luas_kavling"
                                        id="edit_luas_kavling" placeholder="Masukkan Luas Kavling Minimum (m2)">
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
                                    <textarea class="form-control" wire:model="persyaratan_pelaksanaan" id="edit_persyaratan_pelaksanaan"
                                        placeholder="Masukkan Persyaratan Pelaksanaan"></textarea>
                                </div>
                            </div>
                        @endif
                        <div class="row">
                            <div class="col mb-3">
                                <label for="edit_keterangan" class="form-label">Keterangan</label>
                                <textarea class="form-control" wire:model="keterangan" id="edit_keterangan"
                                    placeholder="Masukkan Keterangan"></textarea>
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
            const modal = bootstrap.Modal.getInstance(document.getElementById('EditDokumenItrModal'));
            if (modal) {
                modal.hide();
            }
        });
    </script>
@endscript