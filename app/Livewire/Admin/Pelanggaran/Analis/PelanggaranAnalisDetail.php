<?php

namespace App\Livewire\Admin\Pelanggaran\Analis;

use App\Models\Pelanggaran;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use PhpOffice\PhpWord\TemplateProcessor;

class PelanggaranAnalisDetail extends Component
{
    use WithFileUploads;

    public $pelanggaran;
    public $temuan_pelanggaran;
    public $existing_foto_tindak_lanjut = [];

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
    public $expert_tindakan_rekomendasi;
    public $existing_expert_dokumen = [];

    #[Validate(['upload_expert_dokumen.*' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240'])]
    public $upload_expert_dokumen = [];

    // Klasifikasi Pelanggaran
    public $klasifikasi_pelanggaran;

    #[Validate(['foto_tindak_lanjut.*' => 'image|max:10240'])]
    public $foto_tindak_lanjut = [];

    public $existing_foto_existing = [];
    #[Validate('nullable|date')]
    public $tgl_evaluasi;
    public $hasil_evaluasi;
    public $status_pelanggaran;
    #[Validate(['temp_foto_existing.*' => 'image|max:10240'])]
    public $temp_foto_existing = [];

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
    public $upload_ba_pengambilan_dokumen;
    #[Validate('nullable|file|mimes:pdf,jpg,jpeg,png|max:10240')]
    public $upload_ba_penolakan;
    #[Validate('nullable|file|mimes:pdf,jpg,jpeg,png|max:10240')]
    public $upload_ba_survey;
    #[Validate('nullable|file|mimes:pdf,jpg,jpeg,png|max:10240')]
    public $upload_ba_survey_surveyor;
    #[Validate('nullable|file|mimes:pdf,jpg,jpeg,png|max:10240')]
    public $upload_ba_wawancara;
    #[Validate('nullable|file|mimes:pdf,jpg,jpeg,png|max:10240')]
    public $upload_ba_penerapan_sanksi;
    #[Validate('nullable|file|mimes:pdf,jpg,jpeg,png|max:10240')]
    public $upload_ba_sosialisasi;
    #[Validate('nullable|file|mimes:pdf|max:10240')]
    public $upload_bukti_perizinan;
    #[Validate('nullable|file|mimes:pdf,jpg,jpeg,png|max:10240')]
    public $upload_sk_sanksi_pemberhentian;
    #[Validate('nullable|file|mimes:pdf,jpg,jpeg,png|max:10240')]
    public $upload_kkpr_skrk;
    #[Validate('nullable|file|mimes:pdf,jpg,jpeg,png|max:10240')]
    public $upload_pbg_imb;
    #[Validate('nullable|file|mimes:pdf,jpg,jpeg,png|max:10240')]
    public $upload_nib_kbli;
    #[Validate('nullable|file|mimes:pdf,jpg,jpeg,png|max:10240')]
    public $upload_pembatalan_kkpr;
    #[Validate('nullable|file|mimes:pdf,jpg,jpeg,png|max:10240')]
    public $upload_pembongkaran_bangunan;

    public function render()
    {
        return view('livewire.admin.pelanggaran.analis.pelanggaran-analis-detail');
    }

    #[On('refresh-pelanggaran-analis-list')]
    public function refresh() {
        $this->mount($this->pelanggaran->id);
    }

    public function mount($id)
    {
        $this->pelanggaran = Pelanggaran::find($id);
        $this->temuan_pelanggaran = $this->pelanggaran->temuan_pelanggaran;
        $this->tindak_lanjut = $this->pelanggaran->tindak_lanjut;
        $this->tgl_evaluasi = $this->pelanggaran->tgl_evaluasi;
        $this->hasil_evaluasi = $this->pelanggaran->hasil_evaluasi;
        $this->status_pelanggaran = $this->pelanggaran->status;
        $this->existing_foto_tindak_lanjut = $this->pelanggaran->foto_tindak_lanjut ?? [];
        $this->existing_foto_existing = $this->pelanggaran->foto_existing ?? [];

        // Bagan Alur Sanksi Administrasi
        $this->jenis_indikasi_pelanggaran = $this->pelanggaran->jenis_indikasi_pelanggaran;
        $this->kategori_pelanggaran = $this->pelanggaran->kategori_pelanggaran;
        $this->jenis_pelanggaran = $this->pelanggaran->jenis_pelanggaran;
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
    }

    public function updatedJenisIndikasiPelanggaran($value)
    {
        $norm = Pelanggaran::normalizeIndikasi($value);
        if (in_array($norm, ['tidak_menaati_rtr', 'tidak_mematuhi_kkpr'])) {
            $currentNormKat = Pelanggaran::normalizeKategori($this->kategori_pelanggaran);
            if (!in_array($currentNormKat, ['tanpa_kkpr', 'tidak_sesuai_kkpr'])) {
                $this->kategori_pelanggaran = null;
            }
        } elseif ($norm === 'menghalangi_akses_umum') {
            $this->kategori_pelanggaran = 'akses_umum';
        } else {
            $this->kategori_pelanggaran = null;
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
                'expert_dokumen_pendukung' => count($this->existing_expert_dokumen) > 0 ? $this->existing_expert_dokumen : null
            ]);
        }
    }

    public function removeTempExpertDokumen($index)
    {
        unset($this->upload_expert_dokumen[$index]);
        $this->upload_expert_dokumen = array_values($this->upload_expert_dokumen);
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

        // Handle Expert Dokumen Uploads
        $all_expert_dokumen = $this->existing_expert_dokumen;
        if ($this->upload_expert_dokumen) {
            foreach ($this->upload_expert_dokumen as $doc) {
                $docFilename = "EXPERT_{$safeFolder}_" . Str::random(5) . '.' . $doc->getClientOriginalExtension();
                $all_expert_dokumen[] = $doc->storeAs("pelanggaran/{$safeFolder}/dokumen_expert", $docFilename, 'public');
            }
        }

        // Clean up physically removed photos from existing_foto_tindak_lanjut
        $deletedPhotos = array_diff((array)($this->pelanggaran->foto_tindak_lanjut ?? []), (array)$this->existing_foto_tindak_lanjut);
        foreach ($deletedPhotos as $oldPath) {
            if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }
        }

        $all_photos = $this->existing_foto_tindak_lanjut;

        if($this->foto_tindak_lanjut)
        {
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

        // Handle Document Uploads
        $documentTemplates = [
            'upload_sp1' => 'file_sp1',
            'upload_sp2' => 'file_sp2',
            'upload_sp3' => 'file_sp3',
            'upload_pelimpahan_polpp' => 'file_pelimpahan_polpp',
            'upload_pernyataan' => 'file_pernyataan',
            'upload_sosialisasi' => 'file_sosialisasi',
            'upload_ba_pengambilan_dokumen' => 'file_ba_pengambilan_dokumen',
            'upload_ba_penolakan' => 'file_ba_penolakan',
            'upload_ba_survey' => 'file_ba_survey',
            'upload_ba_survey_surveyor' => 'file_ba_survey_surveyor',
            'upload_ba_wawancara' => 'file_ba_wawancara',
            'upload_ba_penerapan_sanksi' => 'file_ba_penerapan_sanksi',
            'upload_ba_sosialisasi' => 'file_ba_sosialisasi',
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
                // Delete old document file if exists to prevent orphans
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
        
        $this->dispatch('toast', ['type' => 'success', 'message' => 'Analisa Pelanggaran Berhasil Ditambahkan!']);

        $this->dispatch('refresh-pelanggaran-analis-list');
        $this->dispatch('closeModal');

        // Reset new photos after save
        $this->foto_tindak_lanjut = [];
        $this->upload_sp1 = null;
        $this->upload_sp2 = null;
        $this->upload_sp3 = null;
        $this->upload_pelimpahan_polpp = null;
        $this->upload_pernyataan = null;
        $this->upload_sosialisasi = null;
        $this->upload_ba_pengambilan_dokumen = null;
        $this->upload_ba_penolakan = null;
        $this->upload_ba_survey = null;
        $this->upload_ba_survey_surveyor = null;
        $this->upload_ba_wawancara = null;
        $this->upload_ba_penerapan_sanksi = null;
        $this->upload_ba_sosialisasi = null;
        $this->upload_sk_sanksi_pemberhentian = null;
        $this->upload_bukti_perizinan = null;
        $this->upload_kkpr_skrk = null;
        $this->upload_pbg_imb = null;
        $this->upload_nib_kbli = null;
        $this->upload_pembatalan_kkpr = null;
        $this->upload_pembongkaran_bangunan = null;
        $this->upload_expert_dokumen = [];
    }

    public function removeImage($index)
    {
        unset($this->foto_tindak_lanjut[$index]);
        $this->foto_tindak_lanjut = array_values($this->foto_tindak_lanjut);
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
                'foto_tindak_lanjut' => count($this->existing_foto_tindak_lanjut) > 0 ? $this->existing_foto_tindak_lanjut : null
            ]);
        }
    }

    public function removeTempFotoExisting($index)
    {
        unset($this->temp_foto_existing[$index]);
        $this->temp_foto_existing = array_values($this->temp_foto_existing);
    }

    public function removeExistingFotoExisting($index)
    {
        if (isset($this->existing_foto_existing[$index])) {
            $path = $this->existing_foto_existing[$index];
            if ($path && Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
            unset($this->existing_foto_existing[$index]);
            $this->existing_foto_existing = array_values($this->existing_foto_existing);
            $this->pelanggaran->update([
                'foto_existing' => count($this->existing_foto_existing) > 0 ? $this->existing_foto_existing : null
            ]);
        }
    }

    public function storeEvaluasi()
    {
        $this->validate([
            'tgl_evaluasi' => 'nullable|date',
            'status_pelanggaran' => 'required',
            'temp_foto_existing.*' => 'image|max:10240'
        ]);

        $safeFolder = str_replace('/', '-', $this->pelanggaran->no_pelanggaran);

        // Delete any photos removed from existing_foto_existing
        $deletedExistingPhotos = array_diff((array)($this->pelanggaran->foto_existing ?? []), (array)$this->existing_foto_existing);
        foreach ($deletedExistingPhotos as $oldPath) {
            if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }
        }

        $all_existing_photos = $this->existing_foto_existing;

        if($this->temp_foto_existing)
        {
            foreach ($this->temp_foto_existing as $foto) {
                $filename = "{$safeFolder}_eval_" . Str::random(5) . '.' . $foto->getClientOriginalExtension();
                $all_existing_photos[] = $foto->storeAs("pelanggaran/{$safeFolder}/foto_existing", $filename, 'public');
            }
        }

        $this->pelanggaran->update([
            'tgl_evaluasi' => $this->tgl_evaluasi,
            'hasil_evaluasi' => $this->hasil_evaluasi,
            'status' => $this->status_pelanggaran,
            'foto_existing' => count($all_existing_photos) > 0 ? $all_existing_photos : null,
        ]);

        $this->dispatch('toast', ['type' => 'success', 'message' => 'Evaluasi Pelanggaran Berhasil Diperbarui!']);

        $this->dispatch('refresh-pelanggaran-analis-list');
        $this->dispatch('closeEvaluasiModal');

        $this->temp_foto_existing = [];
    }

    public function downloadSP1()
    {
        $data = $this->pelanggaran;

        $data = [
            'jenis_indikasi_pelanggaran' => $data->jenis_indikasi_pelanggaran,
            'nama_pemilik_bangunan' => $data->nama_pelanggar,
            'alamat_pelanggaran' => $data->alamat_pelanggaran,
            'kel_pelanggaran' => $data->kel_pelanggaran,
            'kec_pelanggaran' => $data->kec_pelanggaran,
            'jenis_pemanfaatan_ruang' => $data->jenis_pemanfaatan_ruang,
            'pemanfaatan_ruang' => $data->pemanfaatan_ruang,
        ];

        return $this->generateDocument('SURAT_PERINGATAN_1.docx', $data);
    }

    public function downloadSP2()
    {
        $data = $this->pelanggaran;

        $data = [
            'jenis_indikasi_pelanggaran' => $data->jenis_indikasi_pelanggaran,
            'nama_pemilik_bangunan' => $data->nama_pelanggar,
            'alamat_pelanggaran' => $data->alamat_pelanggaran,
            'kel_pelanggaran' => $data->kel_pelanggaran,
            'kec_pelanggaran' => $data->kec_pelanggaran,
            'jenis_pemanfaatan_ruang' => $data->jenis_pemanfaatan_ruang,
            'pemanfaatan_ruang' => $data->pemanfaatan_ruang,
        ];

        return $this->generateDocument('SURAT_PERINGATAN_2.docx', $data);
    }

    public function downloadSP3()
    {
        $data = $this->pelanggaran;

        $data = [
            'jenis_indikasi_pelanggaran' => $data->jenis_indikasi_pelanggaran,
            'nama_pemilik_bangunan' => $data->nama_pelanggar,
            'alamat_pelanggaran' => $data->alamat_pelanggaran,
            'kel_pelanggaran' => $data->kel_pelanggaran,
            'kec_pelanggaran' => $data->kec_pelanggaran,
            'jenis_pemanfaatan_ruang' => $data->jenis_pemanfaatan_ruang,
            'pemanfaatan_ruang' => $data->pemanfaatan_ruang,
        ];

        return $this->generateDocument('SURAT_PERINGATAN_3.docx', $data);
    }

    public function downloadSuratPelimpahanBerkasPolPP()
    {
        $data = $this->pelanggaran;

        $data = [
            'jenis_indikasi_pelanggaran' => $data->jenis_indikasi_pelanggaran,
            'nama_pemilik_bangunan' => $data->nama_pelanggar,
            'alamat_pelanggaran' => $data->alamat_pelanggaran,
            'kel_pelanggaran' => $data->kel_pelanggaran,
            'kec_pelanggaran' => $data->kec_pelanggaran,
            'jenis_pemanfaatan_ruang' => $data->jenis_pemanfaatan_ruang,
            'pemanfaatan_ruang' => $data->pemanfaatan_ruang,
        ];

        return $this->generateDocument('SURAT_PELIMPAHAN_BERKAS_POLPP.docx', $data);
    }

    public function downloadSuratPernyataan()
    {
        $data = $this->pelanggaran;

        $data = [
            'jenis_indikasi_pelanggaran' => $data->jenis_indikasi_pelanggaran,
            'nama_pemilik_bangunan' => $data->nama_pelanggar,
            'alamat_pelanggaran' => $data->alamat_pelanggaran,
            'kel_pelanggaran' => $data->kel_pelanggaran,
            'kec_pelanggaran' => $data->kec_pelanggaran,
            'jenis_pemanfaatan_ruang' => $data->jenis_pemanfaatan_ruang,
            'pemanfaatan_ruang' => $data->pemanfaatan_ruang,
        ];

        return $this->generateDocument('SURAT_PERNYATAAN_PELANGGARAN_PEMANFAATAN_RUANG.docx', $data);
    }

    public function downloadSuratSosialisasi(){
        $data = $this->pelanggaran;

        $data = [
            'jenis_indikasi_pelanggaran' => $data->jenis_indikasi_pelanggaran,
            'nama_pemilik_bangunan' => $data->nama_pelanggar,
            'alamat_pelanggaran' => $data->alamat_pelanggaran,
            'kel_pelanggaran' => $data->kel_pelanggaran,
            'kec_pelanggaran' => $data->kec_pelanggaran,
            'jenis_pemanfaatan_ruang' => $data->jenis_pemanfaatan_ruang,
            'pemanfaatan_ruang' => $data->pemanfaatan_ruang,
        ];

        return $this->generateDocument('SURAT_SOSIALISASI_PELANGGARAN.docx', $data);
    }

    public function downloadBAPengambilanDokumen(){
        $data = $this->pelanggaran;

        $data = [
            'jenis_indikasi_pelanggaran' => $data->jenis_indikasi_pelanggaran,
            'alamat_pelanggaran' => $data->alamat_pelanggaran,
            'kel_pelanggaran' => $data->kel_pelanggaran,
            'kec_pelanggaran' => $data->kec_pelanggaran,
        ];

        return $this->generateDocument('1_BA_PENGAMBILAN_DOKUMEN.docx', $data);
    }

    public function downloadBAPenolakan(){
        $data = $this->pelanggaran;

        $data = [
            'jenis_indikasi_pelanggaran' => $data->jenis_indikasi_pelanggaran,
            'alamat_pelanggaran' => $data->alamat_pelanggaran,
            'kel_pelanggaran' => $data->kel_pelanggaran,
            'kec_pelanggaran' => $data->kec_pelanggaran,
        ];

        return $this->generateDocument('2_BA_PENOLAKAN.docx', $data);
    }

    public function downloadBASurvey(){
        $data = $this->pelanggaran;
        $parts = array_map('trim', explode(',', (string) $data->koordinat_pelanggaran));
        $lat = $parts[0] ?? '-';
        $lng = $parts[1] ?? '-';

        $data = [
            'jenis_indikasi_pelanggaran' => $data->jenis_indikasi_pelanggaran,
            'alamat_pelanggaran' => $data->alamat_pelanggaran,
            'kel_pelanggaran' => $data->kel_pelanggaran,
            'kec_pelanggaran' => $data->kec_pelanggaran,
            'nama_pemilik_bangunan' => $data->nama_pelanggar,
            'latitude' => $lat !== '' ? $lat : '-',
            'longitude' => $lng !== '' ? $lng : '-',
            'gmaps' => $data->gmaps_pelanggaran,
            'alamat_pelanggar' => $data->alamat_pelanggar,
            'kel_pelanggar' => $data->kel_pelanggar,
            'kec_pelanggar' => $data->kec_pelanggar,
            'kota_pelanggar' => $data->kota_pelanggar,
            'prov_pelanggar' => $data->prov_pelanggar,
        ];

        return $this->generateDocument('3A_BA_SURVEI_LAPANGAN.docx', $data);
    }

    public function downloadBASurveySurveyor(){
        $data = $this->pelanggaran;

        $data = [
            'nama_pemilik_bangunan' => $data->nama_pelanggar,
        ];

        return $this->generateDocument('3B_BA_SURVEI_LAPANGAN_SURVEYOR.docx', $data);
    }

    public function downloadBAWawancara(){
        $data = $this->pelanggaran;

        $data = [
            'nama_pemilik_bangunan' => $data->nama_pelanggar,
        ];

        return $this->generateDocument('4A_BA_WAWANCARA.docx', $data);
    }

    public function downloadPenerapanSanksi(){
        $data = $this->pelanggaran;

        $data = [
            'jenis_indikasi_pelanggaran' => $data->jenis_indikasi_pelanggaran,
            'alamat_pelanggaran' => $data->alamat_pelanggaran,
            'kel_pelanggaran' => $data->kel_pelanggaran,
            'kec_pelanggaran' => $data->kec_pelanggaran,
            'nama_pemilik_bangunan' => $data->nama_pelanggar,
            'alamat_pelanggar' => $data->alamat_pelanggar,
            'kel_pelanggar' => $data->kel_pelanggar,
            'kec_pelanggar' => $data->kec_pelanggar,
            'kota_pelanggar' => $data->kota_pelanggar,
            'prov_pelanggar' => $data->prov_pelanggar,
        ];

        return $this->generateDocument('5_BA_PENERAPAN_SANKSI.docx', $data);
    }

    public function downloadBASosialisasi(){
        $data = $this->pelanggaran;

        $data = [
            'jenis_indikasi_pelanggaran' => $data->jenis_indikasi_pelanggaran,
            'alamat_pelanggaran' => $data->alamat_pelanggaran,
            'kel_pelanggaran' => $data->kel_pelanggaran,
            'kec_pelanggaran' => $data->kec_pelanggaran,
            'nama_pemilik_bangunan' => $data->nama_pelanggar,
        ];

        return $this->generateDocument('6_BA_SOSIALISASI.docx', $data);
    }

    public function downloadSKSanksiPemberhentian(){
        $data = $this->pelanggaran;

        $data = [
            'jenis_indikasi_pelanggaran' => $data->jenis_indikasi_pelanggaran,
            'alamat_pelanggaran' => strtoupper($data->alamat_pelanggaran),
            'kel_pelanggaran' => $data->kel_pelanggaran,
            'kec_pelanggaran' => strtoupper($data->kec_pelanggaran),
            'nama_pemilik_bangunan' => $data->nama_pelanggar,
        ];

        return $this->generateDocument('10_SK_SANKSI_PEMBERHENTIAN.docx', $data);
    }

    private function generateDocument($templatePath, $data)
    {
        return app(\App\Services\DocumentTemplateService::class)->generate(
            codeOrPath: $templatePath,
            data: $data,
            modul: 'pelanggaran'
        );
    }
}
