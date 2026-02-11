<div>
    <div class="row">
        <div class="col-md-12">
            <div class="mb-3 text-start">
                <button type="button" class="btn btn-{{ $pelanggaran->temuan_pelanggaran ? 'warning' : 'primary' }}" 
                    data-bs-toggle="modal" data-bs-target="#AnalisaPelanggaranModal">
                    <i class="bx bx-{{ $pelanggaran->temuan_pelanggaran ? 'edit' : 'plus' }}"></i> 
                    {{ $pelanggaran->temuan_pelanggaran ? 'Edit Analisa' : 'Analisa Pelanggaran' }}
                </button>
                <button type="button" class="btn btn-info ms-1" data-bs-toggle="modal" data-bs-target="#EvaluasiModal">
                    <i class="bx bx-calendar-check"></i> Evaluasi
                </button>
            </div>
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Analisis</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th style="width: 40%">Kesimpulan Pelanggaran</th>
                            <td style="width: 5%">:</td>
                            <td class="text-start">{{ $pelanggaran->temuan_pelanggaran ?? '-' }}</td>
                        </tr>       
                        <tr>
                            <th style="width: 40%">Tindak Lanjut</th>
                            <td style="width: 5%">:</td>
                            <td class="text-start">{{ $pelanggaran->tindak_lanjut ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th style="width: 40%">Tanggal Evaluasi</th>
                            <td style="width: 5%">:</td>
                            <td class="text-start">{{ $pelanggaran->tgl_evaluasi ? \Carbon\Carbon::parse($pelanggaran->tgl_evaluasi)->translatedFormat('d F Y') : '-' }}</td>
                        </tr>
                        <tr>
                            <th style="width: 40%">Status Terkini</th>
                            <td style="width: 5%">:</td>
                            <td class="text-start">
                                <span class="badge bg-{{ $pelanggaran->status == 'Selesai' ? 'success' : 'warning' }}">
                                    {{ $pelanggaran->status }}
                                </span>
                            </td>
                        </tr>
                    </table>

                    <hr>

                    <div class="my-3">
                        <label for="foto_tindak_lanjut" class="form-label fw-bold">Foto Tindak Lanjut</label>
                        <div class="d-flex flex-wrap gap-2 mt-2">
                            @if($pelanggaran->foto_tindak_lanjut)
                                @foreach($pelanggaran->foto_tindak_lanjut as $foto)
                                    <a href="{{ asset('storage/' . $foto) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $foto) }}" class="img-thumbnail" style="width: 150px; height: 150px; object-fit: cover;" alt="Foto Tindak Lanjut">
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
                            @if($pelanggaran->foto_existing)
                                @foreach($pelanggaran->foto_existing as $foto)
                                    <a href="{{ asset('storage/' . $foto) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $foto) }}" class="img-thumbnail" style="width: 150px; height: 150px; object-fit: cover;" alt="Foto Evaluasi">
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
                            $templates = [
                                ['label' => 'SP 1', 'download' => 'downloadSP1', 'file' => 'file_sp1'],
                                ['label' => 'SP 2', 'download' => 'downloadSP2', 'file' => 'file_sp2'],
                                ['label' => 'SP 3', 'download' => 'downloadSP3', 'file' => 'file_sp3'],
                                ['label' => 'Pelimpahan Berkas Pol PP', 'download' => 'downloadSuratPelimpahanBerkasPolPP', 'file' => 'file_pelimpahan_polpp'],
                                ['label' => 'Surat Pernyataan', 'download' => 'downloadSuratPernyataan', 'file' => 'file_pernyataan'],
                                ['label' => 'Surat Sosialisasi', 'download' => 'downloadSuratSosialisasi', 'file' => 'file_sosialisasi'],
                            ];
                        @endphp

                        @foreach($templates as $tpl)
                            <div class="col-12 col-md-4">
                                <div class="btn-group w-100">
                                    <button wire:click="{{ $tpl['download'] }}" class="btn btn-outline-primary btn-sm w-100" title="Download Template">
                                        <i class="bx bx-download"></i> {{ $tpl['label'] }}
                                    </button>
                                    @if($pelanggaran->{$tpl['file']})
                                        <a href="{{ Storage::url($pelanggaran->{$tpl['file']}) }}" target="_blank" class="btn btn-primary btn-sm" title="Lihat Dokumen Terupload">
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

    <div wire:ignore.self class="modal fade" id="AnalisaPelanggaranModal" tabindex="-1" aria-labelledby="AnalisaPelanggaranModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="AnalisaPelanggaranModalLabel">
                        {{ $pelanggaran->temuan_pelanggaran ? 'Edit' : 'Tambah' }} Analisa Pelanggaran
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form wire:submit.prevent="storeAnalisa">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="temuan_pelanggaran" class="form-label">Kesimpulan Pelanggaran</label>
                            <select wire:model.live="temuan_pelanggaran" class="form-select @error('temuan_pelanggaran') is-invalid @enderror" id="temuan_pelanggaran">
                                <option value="">Pilih Kesimpulan Pelanggaran</option>
                                <option value="Ada Pelanggaran">Ada Pelanggaran</option>
                                <option value="Tidak Ada Pelanggaran">Tidak Ada Pelanggaran</option>
                            </select>
                            @error('temuan_pelanggaran')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        @if($temuan_pelanggaran == 'Ada Pelanggaran')
                            <div class="mb-3">
                                <label for="tindak_lanjut" class="form-label">Tindak Lanjut</label>
                                <select wire:model="tindak_lanjut" class="form-select @error('tindak_lanjut') is-invalid @enderror" id="tindak_lanjut">
                                    <option value="">Pilih Tindak Lanjut</option>
                                    <option value="Teguran Lisan">Teguran Lisan</option>
                                    <option value="Sosialisasi/Konfirmasi">Sosialisasi/Konfirmasi</option>
                                    <option value="Surat Peringatan 1">Surat Peringatan 1</option>
                                    <option value="Surat Peringatan 2">Surat Peringatan 2</option>
                                    <option value="Surat Peringatan 3">Surat Peringatan 3</option>
                                    <option value="Pelimpangan Pol PP/">Pelimpangan Pol PP/</option>
                                    <option value="PPNS">PPNS</option>
                                    <option value="Penertiban Tim Gabungan">Penertiban Tim Gabungan</option>
                                    <option value="Pembongkaran">Pembongkaran</option>
                                </select>
                                @error('tindak_lanjut')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="foto_tindak_lanjut" class="form-label">Bukti Tindak Lanjut (Gambar)</label>
                                <input type="file" wire:model="foto_tindak_lanjut" class="form-control @error('foto_tindak_lanjut.*') is-invalid @enderror" id="foto_tindak_lanjut" multiple accept="image/*">
                                <div wire:loading wire:target="foto_tindak_lanjut" class="text-info mt-1">Uploading...</div>
                                @error('foto_tindak_lanjut.*')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                                @if(count($existing_foto_tindak_lanjut) > 0)
                                    <div class="mt-3">
                                        <label class="form-label">Foto Saat Ini:</label>
                                        <div class="row g-2">
                                            @foreach($existing_foto_tindak_lanjut as $index => $foto)
                                                <div class="col-3 position-relative">
                                                    <img src="{{ Storage::url($foto) }}" class="img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">
                                                    <button type="button" wire:click="removeExistingImage({{ $index }})" 
                                                        class="btn btn-danger btn-xs position-absolute top-0 end-0 m-1" title="Hapus">
                                                        <i class="bx bx-x"></i>
                                                    </button>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                @if($foto_tindak_lanjut)
                                    <div class="mt-3">
                                        <label class="form-label">Preview Foto Baru:</label>
                                        <div class="row g-2">
                                            @foreach($foto_tindak_lanjut as $index => $foto)
                                                <div class="col-3 position-relative">
                                                    <img src="{{ $foto->temporaryUrl() }}" class="img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">
                                                    <button type="button" wire:click="removeImage({{ $index }})" 
                                                        class="btn btn-danger btn-xs position-absolute top-0 end-0 m-1" title="Hapus">
                                                        <i class="bx bx-x"></i>
                                                    </button>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <hr>
                            <h6 class="fw-bold mb-3">Dokumen Template Berkas (Tandatangani/Scan)</h6>
                            <div class="row g-2">
                                @php
                                    $uploadFields = [
                                        ['label' => 'Upload SP 1', 'id' => 'upload_sp1', 'current' => 'file_sp1'],
                                        ['label' => 'Upload SP 2', 'id' => 'upload_sp2', 'current' => 'file_sp2'],
                                        ['label' => 'Upload SP 3', 'id' => 'upload_sp3', 'current' => 'file_sp3'],
                                        ['label' => 'Upload Pelimpahan Pol PP', 'id' => 'upload_pelimpahan_polpp', 'current' => 'file_pelimpahan_polpp'],
                                        ['label' => 'Upload Surat Pernyataan', 'id' => 'upload_pernyataan', 'current' => 'file_pernyataan'],
                                        ['label' => 'Upload Surat Sosialisasi', 'id' => 'upload_sosialisasi', 'current' => 'file_sosialisasi'],
                                    ];
                                @endphp

                                @foreach($uploadFields as $field)
                                    <div class="col-md-6 mb-3">
                                        <label for="{{ $field['id'] }}" class="form-label small">{{ $field['label'] }}</label>
                                        <input type="file" wire:model="{{ $field['id'] }}" class="form-control form-control-sm @error($field['id']) is-invalid @enderror" id="{{ $field['id'] }}">
                                        <div wire:loading wire:target="{{ $field['id'] }}" class="text-info x-small">Uploading...</div>
                                        @if($pelanggaran->{$field['current']})
                                            <div class="mt-1">
                                                <a href="{{ Storage::url($pelanggaran->{$field['current']}) }}" target="_blank" class="text-primary x-small">
                                                    <i class="bx bx-file"></i> Lihat Berkas Saat Ini
                                                </a>
                                            </div>
                                        @endif
                                        @error($field['id'])
                                            <div class="invalid-feedback small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Analisa</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="EvaluasiModal" tabindex="-1" aria-labelledby="EvaluasiModalLabel" aria-hidden="true">
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
                            <input type="date" wire:model="tgl_evaluasi" class="form-control @error('tgl_evaluasi') is-invalid @enderror" id="tgl_evaluasi">
                            @error('tgl_evaluasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status_pelanggaran" class="form-label">Status Terkini</label>
                            <select wire:model="status_pelanggaran" class="form-select @error('status_pelanggaran') is-invalid @enderror" id="status_pelanggaran">
                                <option value="">Pilih Status</option>
                                <option value="On Progress">On Progress</option>
                                <option value="Selesai">Selesai</option>
                            </select>
                            @error('status_pelanggaran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="temp_foto_existing" class="form-label">Foto Lokasi Terkini (Multiple)</label>
                            <input type="file" wire:model="temp_foto_existing" class="form-control @error('temp_foto_existing.*') is-invalid @enderror" id="temp_foto_existing" multiple accept="image/*">
                            <div wire:loading wire:target="temp_foto_existing" class="text-info mt-1 small">Uploading...</div>
                            @error('temp_foto_existing.*')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            @if(count($existing_foto_existing) > 0)
                                <div class="mt-3">
                                    <label class="form-label small fw-bold">Foto Saat Ini:</label>
                                    <div class="row g-2">
                                        @foreach($existing_foto_existing as $index => $foto)
                                            <div class="col-3 position-relative">
                                                <img src="{{ Storage::url($foto) }}" class="img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">
                                                <button type="button" wire:click="removeExistingFotoExisting({{ $index }})" 
                                                    class="btn btn-danger btn-xs position-absolute top-0 end-0 m-1" title="Hapus">
                                                    <i class="bx bx-x"></i>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if($temp_foto_existing)
                                <div class="mt-3">
                                    <label class="form-label small fw-bold">Preview Foto Baru:</label>
                                    <div class="row g-2">
                                        @foreach($temp_foto_existing as $index => $foto)
                                            <div class="col-3 position-relative">
                                                <img src="{{ $foto->temporaryUrl() }}" class="img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">
                                                <button type="button" wire:click="removeTempFotoExisting({{ $index }})" 
                                                    class="btn btn-danger btn-xs position-absolute top-0 end-0 m-1" title="Hapus">
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
        $wire.on('closeModal', () => {
            const modal = bootstrap.Modal.getInstance(document.getElementById('AnalisaPelanggaranModal'));
            if (modal) {
                modal.hide();
            }
        });

        $wire.on('closeEvaluasiModal', () => {
            const modal = bootstrap.Modal.getInstance(document.getElementById('EvaluasiModal'));
            if (modal) {
                modal.hide();
            }
        });
    </script>
@endscript