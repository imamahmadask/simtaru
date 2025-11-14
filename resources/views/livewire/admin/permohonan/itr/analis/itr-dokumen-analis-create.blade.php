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
                            <label for="jenis_itr" class="form-label">Jenis Permohonan ITR</label>
                            <select name="jenis_itr" wire:model.live="jenis_itr" id="jenis_itr" class="form-select">
                                <option value="" selected>Pilih Jenis ITR</option>
                                <option value="ITR">ITR</option>
                                <option value="ITR-KKKPR">ITR KKKPR</option>
                            </select>
                        </div>
                        @if ($jenis_itr == 'ITR')
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="penguasaan_tanah" class="form-label">Informasi Penguasaan Tanah</label>
                                    <input type="text" class="form-control" wire:model="penguasaan_tanah"
                                        id="penguasaan_tanah" placeholder="Masukkan Informasi Penguasaan Tanah">
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
                                    <label for="persyaratan_pelaksanaan" class="form-label">Persyaratan Pelaksanaan
                                        Kegiatan Pemanfaatan Ruang</label>
                                    <input type="text" class="form-control" wire:model="persyaratan_pelaksanaan"
                                        id="persyaratan_pelaksanaan" placeholder="Masukkan Persyaratan Pelaksanaan">
                                </div>
                            </div>
                        @elseif($jenis_itr == 'ITR-KKKPR')
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="no_kkkpr" class="form-label">No KKKPR</label>
                                    <input type="text" class="form-control" wire:model="no_kkkpr" id="no_kkkpr"
                                        placeholder="Masukkan Nomor KKKPR">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <div class="d-flex align-items-center">
                                        <label for="dokumen_kkkpr" class="form-label mb-0 me-2">
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
                                        id="dokumen_kkkpr">
                                    @if ($dokumen_kkkpr)
                                        <div class="mt-2">
                                            {{-- Use the asset() helper for public storage files --}}
                                            <a href="{{ asset('storage/' . $dokumen_kkkpr->file_path) }}"
                                                target="_blank" class="text-primary">
                                                <i class="bx bx-file"></i> Lihat Berkas
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="no_kkkpr" class="form-label">Skala Usaha</label>
                                    <input type="text" class="form-control" wire:model="no_kkkpr" id="no_kkkpr"
                                        placeholder="Masukkan Skala Usaha">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="skala_usaha" class="form-label">Skala Usaha</label>
                                    <input type="text" class="form-control" wire:model="skala_usaha"
                                        id="skala_usaha" placeholder="Masukkan Skala Usaha">
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
                                    <label for="kdb" class="form-label">Koefisien Dasar Bangunan (KDB)
                                        Maksimum</label>
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
                                    <label for="kdh" class="form-label">Koefisien Dasar Hijau (KDH)
                                        Minimal</label>
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
                        @endif
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
