<?php

namespace App\Livewire\Admin\Pelanggaran\Analis;

use App\Models\Pelanggaran;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Title('Analisis Kasus Pelanggaran')]
#[Layout('layouts.app-pelanggaran')]
class PelanggaranAnalisForm extends Component
{
    use WithFileUploads;

    public $pelanggaran;
    public $temuan_pelanggaran;
    public $tindak_lanjut;

    // Alur Sanksi Administrasi
    public $jenis_indikasi_pelanggaran;
    public $kategori_pelanggaran;
    public $jenis_pelanggaran;
    public $dampak_keluhan_masyarakat;
    public $dampak_radius_wilayah;

    // Expert Judgment
    public $expert_user_id;
    public $expert_user_name;
    public $expert_justifikasi;
    public $expert_kesimpulan;
    public $expert_tindakan_rekomendasi = 'Ikuti Rekomendasi';
    public $existing_expert_dokumen = [];

    #[Validate(['upload_expert_dokumen.*' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240'])]
    public $upload_expert_dokumen = [];

    // Klasifikasi Pelanggaran
    public $klasifikasi_pelanggaran;

    // Foto Tindak Lanjut
    public $existing_foto_tindak_lanjut = [];
    #[Validate(['foto_tindak_lanjut.*' => 'image|max:10240'])]
    public $foto_tindak_lanjut = [];

    // Dokumen Sanksi Administratif
    #[Validate('nullable|file|mimes:pdf,jpg,jpeg,png|max:10240')]
    public $upload_sp1;
    #[Validate('nullable|file|mimes:pdf,jpg,jpeg,png|max:10240')]
    public $upload_sp2;
    #[Validate('nullable|file|mimes:pdf,jpg,jpeg,png|max:10240')]
    public $upload_sp3;
    #[Validate('nullable|file|mimes:pdf,jpg,jpeg,png|max:10240')]
    public $upload_pelimpahan_polpp;
    #[Validate('nullable|file|mimes:pdf,jpg,jpeg,png|max:10240')]
    public $upload_pernyataan;
    #[Validate('nullable|file|mimes:pdf,jpg,jpeg,png|max:10240')]
    public $upload_sosialisasi;
    #[Validate('nullable|file|mimes:pdf,jpg,jpeg,png|max:10240')]
    public $upload_sk_sanksi_pemberhentian;
    #[Validate('nullable|file|mimes:pdf,jpg,jpeg,png|max:10240')]
    public $upload_pembatalan_kkpr;
    #[Validate('nullable|file|mimes:pdf,jpg,jpeg,png|max:10240')]
    public $upload_pembongkaran_bangunan;

    // Dokumen Jika Tidak Ada Pelanggaran
    #[Validate('nullable|file|mimes:pdf,jpg,jpeg,png|max:10240')]
    public $upload_kkpr_skrk;
    #[Validate('nullable|file|mimes:pdf,jpg,jpeg,png|max:10240')]
    public $upload_pbg_imb;
    #[Validate('nullable|file|mimes:pdf,jpg,jpeg,png|max:10240')]
    public $upload_nib_kbli;

    // Bukti Perizinan
    #[Validate('nullable|file|mimes:pdf|max:10240')]
    public $upload_bukti_perizinan;

    public function mount($id)
    {
        $this->pelanggaran = Pelanggaran::findOrFail($id);
        $this->temuan_pelanggaran = $this->pelanggaran->temuan_pelanggaran;
        $this->tindak_lanjut = $this->pelanggaran->tindak_lanjut;

        // Normalisasi slug dari data yang tersimpan
        $this->jenis_indikasi_pelanggaran = Pelanggaran::normalizeIndikasi($this->pelanggaran->jenis_indikasi_pelanggaran);
        $this->kategori_pelanggaran = Pelanggaran::normalizeKategori($this->pelanggaran->kategori_pelanggaran);
        $this->jenis_pelanggaran = Pelanggaran::normalizeJenisPelanggaran($this->pelanggaran->jenis_pelanggaran);

        $this->dampak_keluhan_masyarakat = $this->pelanggaran->dampak_keluhan_masyarakat;
        $this->dampak_radius_wilayah = $this->pelanggaran->dampak_radius_wilayah;

        // Expert Judgment
        $this->expert_user_id = $this->pelanggaran->expert_user_id ?? Auth::id();
        $this->expert_user_name = $this->pelanggaran->expert_user_name ?? (Auth::user()?->name ?? 'Analis');
        $this->expert_justifikasi = $this->pelanggaran->expert_justifikasi;
        $this->expert_kesimpulan = $this->pelanggaran->expert_kesimpulan;
        $this->expert_tindakan_rekomendasi = $this->pelanggaran->expert_tindakan_rekomendasi ?? 'Ikuti Rekomendasi';
        $this->existing_expert_dokumen = $this->pelanggaran->expert_dokumen_pendukung ?? [];

        // Klasifikasi
        $this->klasifikasi_pelanggaran = $this->pelanggaran->klasifikasi_pelanggaran;
        $this->existing_foto_tindak_lanjut = $this->pelanggaran->foto_tindak_lanjut ?? [];

        // Jika belum ada klasifikasi dan tindakan = 'Ikuti Rekomendasi', auto sync
        if (!$this->klasifikasi_pelanggaran && $this->rekomendasi_sistem && $this->expert_tindakan_rekomendasi === 'Ikuti Rekomendasi') {
            $this->klasifikasi_pelanggaran = $this->rekomendasi_sistem;
        }
    }

    public function getRekomendasiSistemProperty(): ?string
    {
        $level = Pelanggaran::levelDampak($this->dampak_keluhan_masyarakat, $this->dampak_radius_wilayah);

        return $level ? "Pelanggaran {$level}" : null;
    }

    public function updatedDampakKeluhanMasyarakat()
    {
        $this->autoSyncKlasifikasi();
    }

    public function updatedDampakRadiusWilayah()
    {
        $this->autoSyncKlasifikasi();
    }

    public function updatedExpertTindakanRekomendasi($value)
    {
        if ($value === 'Ikuti Rekomendasi' && $this->rekomendasi_sistem) {
            $this->klasifikasi_pelanggaran = $this->rekomendasi_sistem;
        }
    }

    /**
     * Jaga konsistensi: jika analis memilih klasifikasi berbeda dari rekomendasi sistem,
     * tindakan otomatis menjadi "Anulir Rekomendasi" (dan sebaliknya).
     */
    public function updatedKlasifikasiPelanggaran($value)
    {
        if (!$this->rekomendasi_sistem || !$value) {
            return;
        }

        $this->expert_tindakan_rekomendasi = $value === $this->rekomendasi_sistem
            ? 'Ikuti Rekomendasi'
            : 'Anulir Rekomendasi';
    }

    /**
     * Daftar dokumen sanksi administratif per klasifikasi pelanggaran.
     */
    public function getDokumenSanksiProperty(): array
    {
        $sp1Label = $this->klasifikasi_pelanggaran === 'Pelanggaran Rendah' ? 'Surat Peringatan' : 'Surat Peringatan I (SP 1)';

        $all = [
            'sosialisasi' => ['prop' => 'upload_sosialisasi', 'col' => 'file_sosialisasi', 'label' => 'Surat Sosialisasi / Pembinaan', 'icon' => 'bx-chalkboard'],
            'sp1' => ['prop' => 'upload_sp1', 'col' => 'file_sp1', 'label' => $sp1Label, 'icon' => 'bx-error'],
            'sp2' => ['prop' => 'upload_sp2', 'col' => 'file_sp2', 'label' => 'Surat Peringatan II (SP 2)', 'icon' => 'bx-error'],
            'sp3' => ['prop' => 'upload_sp3', 'col' => 'file_sp3', 'label' => 'Surat Peringatan III (SP 3)', 'icon' => 'bx-error'],
            'pernyataan' => ['prop' => 'upload_pernyataan', 'col' => 'file_pernyataan', 'label' => 'Surat Pernyataan', 'icon' => 'bx-pen'],
            'pelimpahan' => ['prop' => 'upload_pelimpahan_polpp', 'col' => 'file_pelimpahan_polpp', 'label' => 'Pelimpahan PPNS / Penertiban Bangunan', 'icon' => 'bx-transfer'],
            'penghentian' => ['prop' => 'upload_sk_sanksi_pemberhentian', 'col' => 'file_sk_sanksi_pemberhentian', 'label' => 'SK Penghentian Sementara Kegiatan', 'icon' => 'bx-stop-circle'],
            'pembatalan' => ['prop' => 'upload_pembatalan_kkpr', 'col' => 'file_pembatalan_kkpr', 'label' => 'Pembatalan & Pencabutan KKPR', 'icon' => 'bx-x-circle'],
            'pembongkaran' => ['prop' => 'upload_pembongkaran_bangunan', 'col' => 'file_pembongkaran_bangunan', 'label' => 'Pembongkaran Bangunan', 'icon' => 'bx-building'],
        ];

        $keys = match ($this->klasifikasi_pelanggaran) {
            'Pelanggaran Rendah' => ['sosialisasi', 'sp1', 'pernyataan'],
            'Pelanggaran Sedang' => ['sosialisasi', 'sp1', 'sp2', 'sp3', 'pernyataan', 'pelimpahan'],
            'Pelanggaran Tinggi' => ['sosialisasi', 'sp1', 'sp2', 'sp3', 'pernyataan', 'penghentian', 'pembatalan', 'pembongkaran'],
            default => [],
        };

        return array_map(fn ($k) => $all[$k], $keys);
    }

    private function autoSyncKlasifikasi()
    {
        if ($this->expert_tindakan_rekomendasi === 'Ikuti Rekomendasi' && $this->rekomendasi_sistem) {
            $this->klasifikasi_pelanggaran = $this->rekomendasi_sistem;
        }
    }

    public function updatedJenisIndikasiPelanggaran($value)
    {
        $norm = Pelanggaran::normalizeIndikasi($value);
        if ($norm === 'menghalangi_akses_umum') {
            $this->kategori_pelanggaran = 'akses_umum';
        } else {
            if (!in_array($this->kategori_pelanggaran, ['tanpa_kkpr', 'tidak_sesuai_kkpr'])) {
                $this->kategori_pelanggaran = null;
            }
        }
        $this->jenis_pelanggaran = null;
    }

    public function updatedKategoriPelanggaran($value)
    {
        $this->jenis_pelanggaran = null;
    }

    public function removeExistingExpertDokumen($index)
    {
        if (isset($this->existing_expert_dokumen[$index])) {
            $path = $this->existing_expert_dokumen[$index];
            if ($path && Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
            unset($this->existing_expert_dokumen[$index]);
            $this->existing_expert_dokumen = array_values($this->existing_expert_dokumen);
            $this->pelanggaran->update([
                'expert_dokumen_pendukung' => count($this->existing_expert_dokumen) > 0 ? $this->existing_expert_dokumen : null,
            ]);
        }
    }

    public function removeTempExpertDokumen($index)
    {
        unset($this->upload_expert_dokumen[$index]);
        $this->upload_expert_dokumen = array_values($this->upload_expert_dokumen);
    }

    public function removeExistingImage($index)
    {
        if (isset($this->existing_foto_tindak_lanjut[$index])) {
            $path = $this->existing_foto_tindak_lanjut[$index];
            if ($path && Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
            unset($this->existing_foto_tindak_lanjut[$index]);
            $this->existing_foto_tindak_lanjut = array_values($this->existing_foto_tindak_lanjut);
            $this->pelanggaran->update([
                'foto_tindak_lanjut' => count($this->existing_foto_tindak_lanjut) > 0 ? $this->existing_foto_tindak_lanjut : null,
            ]);
        }
    }

    public function removeImage($index)
    {
        unset($this->foto_tindak_lanjut[$index]);
        $this->foto_tindak_lanjut = array_values($this->foto_tindak_lanjut);
    }

    public function storeAnalisa()
    {
        if ($this->temuan_pelanggaran == 'Ada Pelanggaran') {
            $this->validate([
                'temuan_pelanggaran' => 'required',
                'jenis_indikasi_pelanggaran' => 'required',
                'kategori_pelanggaran' => 'required',
                'jenis_pelanggaran' => 'required',
                'dampak_keluhan_masyarakat' => 'required',
                'dampak_radius_wilayah' => 'required',
                'expert_justifikasi' => 'nullable|string',
                'expert_kesimpulan' => 'nullable|string',
                'expert_tindakan_rekomendasi' => 'required|string',
                'klasifikasi_pelanggaran' => 'required|string',
                'upload_expert_dokumen.*' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
                'foto_tindak_lanjut.*' => 'nullable|image|max:10240',
                'upload_bukti_perizinan' => 'nullable|file|mimes:pdf|max:10240',
                'upload_sp1' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
                'upload_sp2' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
                'upload_sp3' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
                'upload_pelimpahan_polpp' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
                'upload_pernyataan' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
                'upload_sosialisasi' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
                'upload_sk_sanksi_pemberhentian' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
                'upload_pembatalan_kkpr' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
                'upload_pembongkaran_bangunan' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            ]);

            // Kompilasi nama sanksi administratif dari dokumen yang diunggah / telah ada
            $sanksiTerunggah = [];
            if ($this->upload_sosialisasi || $this->pelanggaran->file_sosialisasi) $sanksiTerunggah[] = 'Pembinaan/Sosialisasi';
            if ($this->upload_sp1 || $this->pelanggaran->file_sp1) $sanksiTerunggah[] = ($this->klasifikasi_pelanggaran == 'Pelanggaran Rendah' ? 'Surat Peringatan' : 'Surat Peringatan I');
            if ($this->upload_sp2 || $this->pelanggaran->file_sp2) $sanksiTerunggah[] = 'Surat Peringatan II';
            if ($this->upload_sp3 || $this->pelanggaran->file_sp3) $sanksiTerunggah[] = 'Surat Peringatan III';
            if ($this->upload_pernyataan || $this->pelanggaran->file_pernyataan) $sanksiTerunggah[] = 'Surat Pernyataan';
            if ($this->upload_pelimpahan_polpp || $this->pelanggaran->file_pelimpahan_polpp) $sanksiTerunggah[] = 'Pelimpahan PPNS / Penertiban Bangunan';
            if ($this->upload_sk_sanksi_pemberhentian || $this->pelanggaran->file_sk_sanksi_pemberhentian) $sanksiTerunggah[] = 'Penghentian Sementara Kegiatan';
            if ($this->upload_pembatalan_kkpr || $this->pelanggaran->file_pembatalan_kkpr) $sanksiTerunggah[] = 'Pembatalan & Pencabutan KKPR';
            if ($this->upload_pembongkaran_bangunan || $this->pelanggaran->file_pembongkaran_bangunan) $sanksiTerunggah[] = 'Pembongkaran Bangunan';

            $this->tindak_lanjut = count($sanksiTerunggah) > 0 ? implode(', ', $sanksiTerunggah) : 'Menunggu Unggahan Dokumen Sanksi';
        } else {
            $this->validate([
                'temuan_pelanggaran' => 'required',
                'upload_kkpr_skrk' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
                'upload_pbg_imb' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
                'upload_nib_kbli' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
            ]);
            $this->tindak_lanjut = null;
            $this->jenis_indikasi_pelanggaran = null;
            $this->kategori_pelanggaran = null;
            $this->jenis_pelanggaran = null;
            $this->dampak_keluhan_masyarakat = null;
            $this->dampak_radius_wilayah = null;
            $this->expert_justifikasi = null;
            $this->expert_kesimpulan = null;
            $this->expert_tindakan_rekomendasi = null;
            $this->klasifikasi_pelanggaran = null;
        }

        $safeFolder = str_replace('/', '-', $this->pelanggaran->no_pelanggaran);

        // Upload Dokumen Pendukung Expert
        $all_expert_dokumen = $this->existing_expert_dokumen;
        if ($this->upload_expert_dokumen) {
            foreach ($this->upload_expert_dokumen as $doc) {
                $docFilename = "EXPERT_{$safeFolder}_" . Str::random(5) . '.' . $doc->getClientOriginalExtension();
                $all_expert_dokumen[] = $doc->storeAs("pelanggaran/{$safeFolder}/dokumen_expert", $docFilename, 'public');
            }
        }

        // Upload Foto Tindak Lanjut
        $all_photos = $this->existing_foto_tindak_lanjut;
        if ($this->foto_tindak_lanjut) {
            foreach ($this->foto_tindak_lanjut as $foto) {
                $foto_tindak_lanjut_filename = $safeFolder . '_' . Str::random(5) . '.' . $foto->getClientOriginalExtension();
                $all_photos[] = $foto->storeAs("pelanggaran/{$safeFolder}/foto_tindak_lanjut", $foto_tindak_lanjut_filename, 'public');
            }
        }

        $updateData = [
            'temuan_pelanggaran' => $this->temuan_pelanggaran,
            'tindak_lanjut' => $this->tindak_lanjut,
            'jenis_indikasi_pelanggaran' => Pelanggaran::normalizeIndikasi($this->jenis_indikasi_pelanggaran),
            'kategori_pelanggaran' => Pelanggaran::normalizeKategori($this->kategori_pelanggaran),
            'jenis_pelanggaran' => Pelanggaran::normalizeJenisPelanggaran($this->jenis_pelanggaran),
            'dampak_keluhan_masyarakat' => $this->dampak_keluhan_masyarakat,
            'dampak_radius_wilayah' => $this->dampak_radius_wilayah,
            'expert_user_id' => $this->temuan_pelanggaran == 'Ada Pelanggaran' ? (Auth::id() ?? $this->expert_user_id) : null,
            'expert_user_name' => $this->temuan_pelanggaran == 'Ada Pelanggaran' ? (Auth::user()?->name ?? $this->expert_user_name) : null,
            'expert_justifikasi' => $this->expert_justifikasi,
            'expert_dokumen_pendukung' => count($all_expert_dokumen) > 0 ? $all_expert_dokumen : null,
            'expert_kesimpulan' => $this->expert_kesimpulan,
            'expert_tindakan_rekomendasi' => $this->expert_tindakan_rekomendasi,
            'klasifikasi_pelanggaran' => $this->klasifikasi_pelanggaran,
            'foto_tindak_lanjut' => count($all_photos) > 0 ? $all_photos : null,
        ];

        // Handle Dokumen Berkas
        $documentTemplates = [
            'upload_sp1' => 'file_sp1',
            'upload_sp2' => 'file_sp2',
            'upload_sp3' => 'file_sp3',
            'upload_pelimpahan_polpp' => 'file_pelimpahan_polpp',
            'upload_pernyataan' => 'file_pernyataan',
            'upload_sosialisasi' => 'file_sosialisasi',
            'upload_sk_sanksi_pemberhentian' => 'file_sk_sanksi_pemberhentian',
            'upload_bukti_perizinan' => 'bukti_perizinan',
            'upload_kkpr_skrk' => 'file_kkpr_skrk',
            'upload_pbg_imb' => 'file_pbg_imb',
            'upload_nib_kbli' => 'file_nib_kbli',
            'upload_pembatalan_kkpr' => 'file_pembatalan_kkpr',
            'upload_pembongkaran_bangunan' => 'file_pembongkaran_bangunan',
        ];

        foreach ($documentTemplates as $property => $column) {
            if ($this->$property) {
                $oldFile = $this->pelanggaran->$column;
                if ($oldFile && Storage::disk('public')->exists($oldFile)) {
                    Storage::disk('public')->delete($oldFile);
                }
                $docPrefix = Str::upper(str_replace('upload_', '', $property));
                $fileName = "{$docPrefix}_{$safeFolder}_" . Str::random(5) . '.' . $this->$property->getClientOriginalExtension();
                $updateData[$column] = $this->$property->storeAs("pelanggaran/{$safeFolder}/dokumen", $fileName, 'public');
            }
        }

        $this->pelanggaran->update($updateData);

        session()->flash('success', 'Analisa Kasus Pelanggaran Berhasil Disimpan!');

        return redirect()->route('pelanggaran.detail', $this->pelanggaran->id);
    }

    public function render()
    {
        return view('livewire.admin.pelanggaran.analis.pelanggaran-analis-form');
    }
}
