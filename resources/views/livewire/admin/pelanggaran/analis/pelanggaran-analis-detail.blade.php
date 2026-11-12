<div>
    <div class="row">
        <div class="col-md-12">
            <div class="mb-3 d-flex flex-wrap gap-2">
                <a href="{{ route('pelanggaran.analis', $pelanggaran->id) }}" class="btn btn-{{ $pelanggaran->temuan_pelanggaran ? 'warning' : 'primary' }}">
                    <i class="bx bx-{{ $pelanggaran->temuan_pelanggaran ? 'edit' : 'plus' }} me-1"></i>
                    {{ $pelanggaran->temuan_pelanggaran ? 'Edit Analisa Pelanggaran' : 'Mulai Analisa Pelanggaran' }}
                </a>
                <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#EvaluasiModal">
                    <i class="bx bx-calendar-check me-1"></i> Evaluasi
                </button>
            </div>
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Analisis</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th style="width: 35%">Kesimpulan Pelanggaran</th>
                            <td style="width: 3%">:</td>
                            <td class="text-start">
                                @if ($pelanggaran->temuan_pelanggaran == 'Ada Pelanggaran')
                                    <span class="badge bg-danger">Ada Pelanggaran</span>
                                @elseif ($pelanggaran->temuan_pelanggaran == 'Tidak Ada Pelanggaran')
                                    <span class="badge bg-success">Tidak Ada Pelanggaran</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                        @if ($pelanggaran->temuan_pelanggaran == 'Ada Pelanggaran')
                            @if ($pelanggaran->klasifikasi_pelanggaran)
                                <tr>
                                    <th>Klasifikasi Pelanggaran</th>
                                    <td>:</td>
                                    <td class="text-start">
                                        @php
                                            $badgeColor = match($pelanggaran->klasifikasi_pelanggaran) {
                                                'Pelanggaran Rendah' => 'success',
                                                'Pelanggaran Sedang' => 'warning',
                                                'Pelanggaran Tinggi' => 'danger',
                                                default => 'secondary'
                                            };
                                        @endphp
                                        <span class="badge bg-{{ $badgeColor }} fs-6">{{ $pelanggaran->klasifikasi_pelanggaran }}</span>
                                    </td>
                                </tr>
                            @endif
                            @if ($pelanggaran->jenis_indikasi_pelanggaran)
                                <tr>
                                    <th>Indikasi Pelanggaran</th>
                                    <td>:</td>
                                    <td class="text-start fw-semibold">{{ $pelanggaran->indikasi_label }}</td>
                                </tr>
                            @endif
                            @if ($pelanggaran->kategori_pelanggaran)
                                <tr>
                                    <th>Kategori Pelanggaran</th>
                                    <td>:</td>
                                    <td class="text-start">{{ $pelanggaran->kategori_label }}</td>
                                </tr>
                            @endif
                            @if ($pelanggaran->jenis_pelanggaran)
                                <tr>
                                    <th>Jenis Pelanggaran</th>
                                    <td>:</td>
                                    <td class="text-start text-danger fw-semibold">{{ $pelanggaran->jenis_pelanggaran_label }}</td>
                                </tr>
                            @endif
                            @if ($pelanggaran->dampak_keluhan_masyarakat || $pelanggaran->dampak_radius_wilayah)
                                <tr>
                                    <th>Dampak Pelanggaran</th>
                                    <td>:</td>
                                    <td class="text-start">
                                        Keluhan Masyarakat: <span class="badge bg-label-info">{{ $pelanggaran->dampak_keluhan_masyarakat ?? '-' }}</span> | 
                                        Radius Wilayah: <span class="badge bg-label-primary">{{ $pelanggaran->dampak_radius_wilayah ?? '-' }}</span>
                                    </td>
                                </tr>
                            @endif
                            <tr>
                                <th>Tindak Lanjut (Sanksi)</th>
                                <td>:</td>
                                <td class="text-start fw-bold text-primary">{{ $pelanggaran->tindak_lanjut ?? '-' }}</td>
                            </tr>
                            @if ($pelanggaran->expert_user_name || $pelanggaran->expert_tindakan_rekomendasi)
                                <tr>
                                    <th>Expert Judgment</th>
                                    <td>:</td>
                                    <td class="text-start">
                                        <small class="text-muted">Analis: <strong>{{ $pelanggaran->expert_user_name ?? ($pelanggaran->expertUser?->name ?? '-') }}</strong></small> | 
                                        <span class="badge bg-{{ $pelanggaran->expert_tindakan_rekomendasi == 'Ikuti Rekomendasi' ? 'label-success' : 'label-warning' }}">
                                            {{ $pelanggaran->expert_tindakan_rekomendasi ?? 'Ikuti Rekomendasi' }}
                                        </span>
                                        @if ($pelanggaran->expert_justifikasi)
                                            <div class="mt-1 small"><strong>Justifikasi:</strong> {{ $pelanggaran->expert_justifikasi }}</div>
                                        @endif
                                        @if ($pelanggaran->expert_kesimpulan)
                                            <div class="mt-1 small"><strong>Kesimpulan:</strong> {{ $pelanggaran->expert_kesimpulan }}</div>
                                        @endif
                                        @if ($pelanggaran->expert_dokumen_pendukung && count($pelanggaran->expert_dokumen_pendukung) > 0)
                                            <div class="mt-2">
                                                <strong class="small">Dokumen Pendukung Expert:</strong>
                                                <div class="d-flex flex-wrap gap-1 mt-1">
                                                    @foreach ($pelanggaran->expert_dokumen_pendukung as $idx => $doc)
                                                        <a href="{{ Storage::url($doc) }}" target="_blank" class="btn btn-outline-info btn-xs">
                                                            <i class="bx bx-file me-1"></i> Berkas {{ $idx + 1 }}
                                                        </a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endif
                        @else
                            <tr>
                                <th>Tindak Lanjut</th>
                                <td>:</td>
                                <td class="text-start">{{ $pelanggaran->tindak_lanjut ?? '-' }}</td>
                            </tr>
                        @endif
                        <tr>
                            <th>Tanggal Evaluasi</th>
                            <td>:</td>
                            <td class="text-start">
                                {{ $pelanggaran->tgl_evaluasi ? \Carbon\Carbon::parse($pelanggaran->tgl_evaluasi)->translatedFormat('d F Y') : '-' }}
                            </td>
                        </tr>
                        <tr>
                            <th>Hasil Evaluasi</th>
                            <td>:</td>
                            <td class="text-start">{{ $pelanggaran->hasil_evaluasi ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Status Terkini</th>
                            <td>:</td>
                            <td class="text-start">
                                <span
                                    class="badge bg-{{ $pelanggaran->status == 'Selesai' ? 'success' : ($pelanggaran->status == 'Pelimpahan Berkas' ? 'primary' : 'warning') }}">
                                    {{ $pelanggaran->status }}
                                </span>
                            </td>
                        </tr>
                        @if ($pelanggaran->temuan_pelanggaran == 'Tidak Ada Pelanggaran')
                            <tr>
                                <th>Berkas KKPR/SKRK</th>
                                <td>:</td>
                                <td class="text-start">
                                    @if($pelanggaran->file_kkpr_skrk)
                                        <a href="{{ Storage::url($pelanggaran->file_kkpr_skrk) }}" target="_blank" class="btn btn-primary btn-sm"><i class="bx bx-file me-1"></i>Lihat Berkas</a>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Berkas PBG/IMB</th>
                                <td>:</td>
                                <td class="text-start">
                                    @if($pelanggaran->file_pbg_imb)
                                        <a href="{{ Storage::url($pelanggaran->file_pbg_imb) }}" target="_blank" class="btn btn-primary btn-sm"><i class="bx bx-file me-1"></i>Lihat Berkas</a>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Berkas NIB KBLI</th>
                                <td>:</td>
                                <td class="text-start">
                                    @if($pelanggaran->file_nib_kbli)
                                        <a href="{{ Storage::url($pelanggaran->file_nib_kbli) }}" target="_blank" class="btn btn-primary btn-sm"><i class="bx bx-file me-1"></i>Lihat Berkas</a>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @else
                            <tr>
                                <th>Bukti Perizinan</th>
                                <td>:</td>
                                <td class="text-start">
                                    @if($pelanggaran->bukti_perizinan)
                                        <a href="{{ Storage::url($pelanggaran->bukti_perizinan) }}" target="_blank" class="btn btn-primary btn-sm"><i class="bx bx-file me-1"></i>Lihat Berkas</a>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @endif
                    </table>

                    <hr>

                    <div class="my-3">
                        <label for="foto_tindak_lanjut" class="form-label fw-bold">Foto Tindak Lanjut</label>
                        <div class="d-flex flex-wrap gap-2 mt-2">
                            @if ($pelanggaran->foto_tindak_lanjut)
                                @foreach ($pelanggaran->foto_tindak_lanjut as $foto)
                                    <a href="{{ asset('storage/' . $foto) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $foto) }}" class="img-thumbnail"
                                            style="width: 150px; height: 150px; object-fit: cover;"
                                            alt="Foto Tindak Lanjut">
                                    </a>
                                @endforeach
                            @else
                                <p class="text-muted small italic">Tidak ada foto tindak lanjut</p>
                            @endif
                        </div>
                    </div>

                    <hr>

                    <div class="my-3">
                        <label class="form-label fw-bold">Foto Lokasi Terkini (Evaluasi)</label>
                        <div class="d-flex flex-wrap gap-2 mt-2">
                            @if ($pelanggaran->foto_existing)
                                @foreach ($pelanggaran->foto_existing as $foto)
                                    <a href="{{ asset('storage/' . $foto) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $foto) }}" class="img-thumbnail"
                                            style="width: 150px; height: 150px; object-fit: cover;" alt="Foto Evaluasi">
                                    </a>
                                @endforeach
                            @else
                                <p class="text-muted small italic">Belum ada foto evaluasi lokasi</p>
                            @endif
                        </div>
                    </div>

                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="mb-0">Template Surat</h5>
                </div>
                <div class="card-body">
                    <div class="row g-2 mt-2">
                        @php
                            $templatesSurat = [
                                ['label' => 'SP 1', 'download' => 'downloadSP1', 'file' => 'file_sp1'],
                                ['label' => 'SP 2', 'download' => 'downloadSP2', 'file' => 'file_sp2'],
                                ['label' => 'SP 3', 'download' => 'downloadSP3', 'file' => 'file_sp3'],
                                [
                                    'label' => 'Pelimpahan Berkas Pol PP',
                                    'download' => 'downloadSuratPelimpahanBerkasPolPP',
                                    'file' => 'file_pelimpahan_polpp',
                                ],
                                [
                                    'label' => 'Surat Pernyataan',
                                    'download' => 'downloadSuratPernyataan',
                                    'file' => 'file_pernyataan',
                                ],
                                [
                                    'label' => 'Surat Sosialisasi',
                                    'download' => 'downloadSuratSosialisasi',
                                    'file' => 'file_sosialisasi',
                                ],
                            ];
                        @endphp

                        @foreach ($templatesSurat as $tpl)
                            <div class="col-12 col-md-4">
                                <div class="btn-group w-100">
                                    <button wire:click="{{ $tpl['download'] }}"
                                        class="btn btn-outline-primary btn-sm w-100" title="Download Template">
                                        <i class="bx bx-download"></i> {{ $tpl['label'] }}
                                    </button>
                                    @if ($pelanggaran->{$tpl['file']})
                                        <a href="{{ Storage::url($pelanggaran->{$tpl['file']}) }}" target="_blank"
                                            class="btn btn-primary btn-sm" title="Lihat Dokumen Terupload">
                                            <i class="bx bx-show"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="mb-0">Template Berita Acara</h5>
                </div>
                <div class="card-body">
                    <div class="row g-2 mt-2">
                        @php
                            $templatesBa = [
                                [
                                    'label' => 'Upload BA Pengambilan Dokumen',
                                    'download' => 'downloadBAPengambilanDokumen',
                                    'file' => 'file_ba_pengambilan_dokumen',
                                ],
                                [
                                    'label' => 'Upload BA Penolakan',
                                    'download' => 'downloadBAPenolakan',
                                    'file' => 'file_ba_penolakan',
                                ],
                                [
                                    'label' => 'Upload BA Survey Lapangan',
                                    'download' => 'downloadBASurvey',
                                    'file' => 'file_ba_survey',
                                ],
                                [
                                    'label' => 'Upload BA Survey Untuk Surveyor',
                                    'download' => 'downloadBASurveySurveyor',
                                    'file' => 'file_ba_survey_surveyor',
                                ],
                                [
                                    'label' => 'Upload BA Wawancara',
                                    'download' => 'downloadBAWawancara',
                                    'file' => 'file_ba_wawancara',
                                ],
                                [
                                    'label' => 'Upload BA Penerapan Sanksi',
                                    'download' => 'downloadPenerapanSanksi',
                                    'file' => 'file_ba_penerapan_sanksi',
                                ],
                                [
                                    'label' => 'Upload BA Sosialisasi',
                                    'download' => 'downloadBASosialisasi',
                                    'file' => 'file_ba_sosialisasi',
                                ],
                                [
                                    'label' => 'Upload SK  Sanksi Pemberhentian',
                                    'download' => 'downloadSKSanksiPemberhentian',
                                    'file' => 'file_sk_sanksi_pemberhentian',
                                ],
                            ];
                        @endphp

                        @foreach ($templatesBa as $tpl)
                            <div class="col-12 col-md-4">
                                <div class="btn-group w-100">
                                    <button wire:click="{{ $tpl['download'] }}"
                                        class="btn btn-outline-primary btn-sm w-100" title="Download Template">
                                        <i class="bx bx-download"></i> {{ $tpl['label'] }}
                                    </button>
                                    @if ($pelanggaran->{$tpl['file']})
                                        <a href="{{ Storage::url($pelanggaran->{$tpl['file']}) }}" target="_blank"
                                            class="btn btn-primary btn-sm" title="Lihat Dokumen Terupload">
                                            <i class="bx bx-show"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="EvaluasiModal" tabindex="-1" aria-labelledby="EvaluasiModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="EvaluasiModalLabel">Evaluasi Pelanggaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form wire:submit.prevent="storeEvaluasi">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="tgl_evaluasi" class="form-label">Tanggal Evaluasi</label>
                            <input type="date" wire:model="tgl_evaluasi"
                                class="form-control @error('tgl_evaluasi') is-invalid @enderror" id="tgl_evaluasi">
                            @error('tgl_evaluasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status_pelanggaran" class="form-label">Status Terkini</label>
                            <select wire:model="status_pelanggaran"
                                class="form-select @error('status_pelanggaran') is-invalid @enderror"
                                id="status_pelanggaran">
                                <option value="">Pilih Status</option>
                                <option value="On Progress">On Progress</option>
                                <option value="Pelimpahan Berkas">Pelimpahan Berkas</option>
                                <option value="Selesai">Selesai</option>
                            </select>
                            @error('status_pelanggaran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="hasil_evaluasi" class="form-label">Hasil Evaluasi</label>
                            <textarea wire:model="hasil_evaluasi" class="form-control @error('hasil_evaluasi') is-invalid @enderror"
                                id="hasil_evaluasi" rows="3" placeholder="Masukkan hasil evaluasi..."></textarea>
                            @error('hasil_evaluasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="temp_foto_existing" class="form-label">Foto Lokasi Terkini (Multiple)</label>
                            <input type="file" wire:model="temp_foto_existing"
                                class="form-control @error('temp_foto_existing.*') is-invalid @enderror"
                                id="temp_foto_existing" multiple accept="image/*">
                            <div wire:loading wire:target="temp_foto_existing" class="text-info mt-1 small">
                                Uploading...</div>
                            @error('temp_foto_existing.*')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            @if (count($existing_foto_existing) > 0)
                                <div class="mt-3">
                                    <label class="form-label small fw-bold">Foto Saat Ini:</label>
                                    <div class="row g-2">
                                        @foreach ($existing_foto_existing as $index => $foto)
                                            <div class="col-3 position-relative">
                                                <img src="{{ Storage::url($foto) }}" class="img-thumbnail"
                                                    style="width: 100px; height: 100px; object-fit: cover;">
                                                <button type="button"
                                                    wire:click="removeExistingFotoExisting({{ $index }})"
                                                    class="btn btn-danger btn-xs position-absolute top-0 end-0 m-1"
                                                    title="Hapus">
                                                    <i class="bx bx-x"></i>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if ($temp_foto_existing)
                                <div class="mt-3">
                                    <label class="form-label small fw-bold">Preview Foto Baru:</label>
                                    <div class="row g-2">
                                        @foreach ($temp_foto_existing as $index => $foto)
                                            <div class="col-3 position-relative">
                                                <img src="{{ $foto->temporaryUrl() }}" class="img-thumbnail"
                                                    style="width: 100px; height: 100px; object-fit: cover;">
                                                <button type="button"
                                                    wire:click="removeTempFotoExisting({{ $index }})"
                                                    class="btn btn-danger btn-xs position-absolute top-0 end-0 m-1"
                                                    title="Hapus">
                                                    <i class="bx bx-x"></i>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Evaluasi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@script
    <script>
        $wire.on('closeEvaluasiModal', () => {
            const modal = bootstrap.Modal.getInstance(document.getElementById('EvaluasiModal'));
            if (modal) {
                modal.hide();
            }
        });
    </script>
@endscript
