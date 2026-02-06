<div>
    <div class="row">
        <div class="col-md-12">
            <div class="mb-3 text-start">
                <button type="button" class="btn btn-{{ $pelanggaran->temuan_pelanggaran ? 'warning' : 'primary' }}" 
                    data-bs-toggle="modal" data-bs-target="#AnalisaPelanggaranModal">
                    <i class="bx bx-{{ $pelanggaran->temuan_pelanggaran ? 'edit' : 'plus' }}"></i> 
                    {{ $pelanggaran->temuan_pelanggaran ? 'Edit Analisa' : 'Analisa Pelanggaran' }}
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
                    </table>

                    <div class="my-3">
                        <label for="foto_tindak_lanjut" class="form-label">Foto Tindak Lanjut</label>
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
</div>
@script
    <script>
        $wire.on('closeModal', () => {
            const modal = bootstrap.Modal.getInstance(document.getElementById('AnalisaPelanggaranModal'));
            if (modal) {
                modal.hide();
            }
        });
    </script>
@endscript  