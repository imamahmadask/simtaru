<?php

namespace App\Livewire\Admin\Pelanggaran\Analis;

use App\Models\Pelanggaran;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
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
    public int $currentStep = 1;

    // Langkah 1: Penjelasan Kasus
    public $penjelasan_singkat;
    public $pasal_aturan_dilanggar;
    public $penjelasan_lainnya;

    // Alur Sanksi Administrasi & Komponen Penilaian (A, B, C, D)
    public $jenis_indikasi_pelanggaran;
    public $kategori_pelanggaran;
    public $jenis_pelanggaran = [];
    public $dampak_keluhan_masyarakat;
    public $dampak_radius_wilayah;
    public $skala_pelanggaran;
    public $riwayat_pelanggaran;

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

    // Peta Deliniasi
    public $existing_peta_deliniasi = [];
    #[Validate(['upload_peta_deliniasi.*' => 'nullable|image|max:10240'])]
    public $upload_peta_deliniasi = [];

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
        $this->penjelasan_singkat = $this->pelanggaran->penjelasan_singkat;
        $this->pasal_aturan_dilanggar = $this->pelanggaran->pasal_aturan_dilanggar;
        $this->penjelasan_lainnya = $this->pelanggaran->penjelasan_lainnya;
        $this->temuan_pelanggaran = $this->pelanggaran->temuan_pelanggaran;
        $this->tindak_lanjut = $this->pelanggaran->tindak_lanjut;

        // Normalisasi slug dari data yang tersimpan
        $this->jenis_indikasi_pelanggaran = Pelanggaran::normalizeIndikasi($this->pelanggaran->jenis_indikasi_pelanggaran);
        $this->kategori_pelanggaran = Pelanggaran::normalizeKategori($this->pelanggaran->kategori_pelanggaran);
        $this->jenis_pelanggaran = Pelanggaran::normalizeJenisPelanggaranList($this->pelanggaran->jenis_pelanggaran);

        $this->dampak_keluhan_masyarakat = $this->pelanggaran->dampak_keluhan_masyarakat;
        $this->dampak_radius_wilayah = Pelanggaran::normalizeDampak($this->pelanggaran->dampak_radius_wilayah);
        $this->skala_pelanggaran = Pelanggaran::normalizeSkala($this->pelanggaran->skala_pelanggaran);
        $this->riwayat_pelanggaran = Pelanggaran::normalizeRiwayat($this->pelanggaran->riwayat_pelanggaran);

        // Expert Judgment
        $this->expert_user_id = $this->pelanggaran->expert_user_id ?? Auth::id();
        $this->expert_user_name = $this->pelanggaran->expert_user_name ?? (Auth::user()?->name ?? 'Analis');
        $this->expert_justifikasi = $this->pelanggaran->expert_justifikasi;
        $this->expert_kesimpulan = $this->pelanggaran->expert_kesimpulan;
        $this->expert_tindakan_rekomendasi = $this->pelanggaran->expert_tindakan_rekomendasi ?? 'Ikuti Rekomendasi';
        $this->existing_expert_dokumen = $this->pelanggaran->expert_dokumen_pendukung ?? [];

        // Klasifikasi & Dokumentasi
        $this->klasifikasi_pelanggaran = $this->pelanggaran->klasifikasi_pelanggaran;
        $this->existing_foto_tindak_lanjut = $this->pelanggaran->foto_tindak_lanjut ?? [];
        $this->existing_peta_deliniasi = $this->pelanggaran->peta_deliniasi ?? [];

        // Jika belum ada klasifikasi dan tindakan = 'Ikuti Rekomendasi', auto sync
        if (!$this->klasifikasi_pelanggaran && $this->rekomendasi_sistem && $this->expert_tindakan_rekomendasi === 'Ikuti Rekomendasi') {
            $this->klasifikasi_pelanggaran = $this->rekomendasi_sistem;
        }
    }

    public function getPenilaianSkorProperty(): array
    {
        return Pelanggaran::hitungSkorPenilaian(
            $this->jenis_pelanggaran,
            $this->dampak_radius_wilayah,
            $this->skala_pelanggaran,
            $this->riwayat_pelanggaran
        );
    }

    public function getRekomendasiSistemProperty(): ?string
    {
        return $this->penilaian_skor['rekomendasi_kategori'];
    }

    public function updatedJenisPelanggaran($value = null, $key = null)
    {
        // Livewire 3 mengirim diff per indeks (mis. jenis_pelanggaran.1 = 'klb' atau '__rm__'),
        // sedangkan array lengkap hasil update sudah tersedia pada $this->jenis_pelanggaran.
        $this->jenis_pelanggaran = Pelanggaran::normalizeJenisPelanggaranList($this->jenis_pelanggaran);
        $this->autoSyncKlasifikasi();
    }

    public function selectAllJenisPelanggaran(): void
    {
        if (!$this->kategori_pelanggaran || !isset(Pelanggaran::JENIS_PER_KATEGORI[$this->kategori_pelanggaran])) {
            return;
        }
        $this->jenis_pelanggaran = Pelanggaran::JENIS_PER_KATEGORI[$this->kategori_pelanggaran];
        $this->autoSyncKlasifikasi();
    }

    public function clearJenisPelanggaran(): void
    {
        $this->jenis_pelanggaran = [];
        $this->autoSyncKlasifikasi();
    }

    public function updatedTemuanPelanggaran($value): void
    {
        $this->resetErrorBag();
        if ($value === 'Tidak Ada Pelanggaran' && $this->currentStep > 3) {
            $this->currentStep = 3;
        }
        if ($this->currentStep > $this->total_steps) {
            $this->currentStep = $this->total_steps;
        }
    }

    public function getWizardStepsProperty(): array
    {
        $penjelasanDone = filled($this->penjelasan_singkat)
            || filled($this->pasal_aturan_dilanggar)
            || filled($this->penjelasan_lainnya);

        $step1 = [
            'num' => 1,
            'title' => 'Penjelasan Kasus',
            'short' => 'Penjelasan Kasus',
            'optional' => true,
            'done' => $penjelasanDone,
        ];

        if ($this->temuan_pelanggaran === 'Tidak Ada Pelanggaran') {
            return [
                1 => $step1,
                2 => [
                    'num' => 2,
                    'title' => 'Kesimpulan Pemeriksaan',
                    'short' => 'Kesimpulan',
                    'done' => true,
                ],
                3 => [
                    'num' => 3,
                    'title' => 'Berkas Perizinan & Peta Deliniasi (Opsional)',
                    'short' => 'Berkas & Peta',
                    'done' => (bool) (
                        $this->pelanggaran->file_kkpr_skrk
                        || $this->pelanggaran->file_pbg_imb
                        || $this->pelanggaran->file_nib_kbli
                        || !empty($this->existing_peta_deliniasi)
                        || !empty($this->upload_peta_deliniasi)
                    ),
                ],
            ];
        }

        $selectedJenis = Pelanggaran::normalizeJenisPelanggaranList($this->jenis_pelanggaran);
        $isAda = $this->temuan_pelanggaran === 'Ada Pelanggaran';

        return [
            1 => $step1,
            2 => [
                'num' => 2,
                'title' => 'Kesimpulan Pemeriksaan',
                'short' => 'Kesimpulan',
                'done' => $isAda,
            ],
            3 => [
                'num' => 3,
                'title' => 'A. Jenis Pelanggaran (40%)',
                'short' => 'Komponen A (40%)',
                'done' => $isAda && $this->jenis_indikasi_pelanggaran && $this->kategori_pelanggaran && count($selectedJenis) > 0,
            ],
            4 => [
                'num' => 4,
                'title' => 'B. Dampak Masyarakat (35%)',
                'short' => 'Komponen B (35%)',
                'done' => $isAda && filled($this->dampak_radius_wilayah),
            ],
            5 => [
                'num' => 5,
                'title' => 'C. Skala & Intensitas (15%)',
                'short' => 'Komponen C (15%)',
                'done' => $isAda && filled($this->skala_pelanggaran),
            ],
            6 => [
                'num' => 6,
                'title' => 'D. Riwayat Pelanggaran (10%)',
                'short' => 'Komponen D (10%)',
                'done' => $isAda && filled($this->riwayat_pelanggaran),
            ],
            7 => [
                'num' => 7,
                'title' => 'Skor Penilaian & Expert Judgement',
                'short' => 'Skor & Expert',
                'done' => $isAda && filled($this->expert_tindakan_rekomendasi),
            ],
            8 => [
                'num' => 8,
                'title' => 'Klasifikasi, Sanksi & Peta Deliniasi',
                'short' => 'Klasifikasi & Sanksi',
                'done' => $isAda && filled($this->klasifikasi_pelanggaran),
            ],
        ];
    }

    public function getTotalStepsProperty(): int
    {
        return count($this->wizard_steps);
    }

    public function canAccessStep(int $targetStep): bool
    {
        if ($targetStep <= 1 || $targetStep <= $this->currentStep) {
            return true;
        }
        if ($targetStep > $this->total_steps) {
            return false;
        }

        $steps = $this->wizard_steps;
        for ($s = 1; $s < $targetStep; $s++) {
            if (empty($steps[$s]['done']) && empty($steps[$s]['optional'])) {
                return false;
            }
        }

        return true;
    }

    public function nextStep(): void
    {
        if ($this->currentStep === 3 && $this->temuan_pelanggaran === 'Ada Pelanggaran') {
            $this->jenis_pelanggaran = Pelanggaran::normalizeJenisPelanggaranList($this->jenis_pelanggaran);
        }

        $this->validate($this->rulesForStep($this->currentStep), $this->stepValidationMessages());

        if ($this->currentStep < $this->total_steps) {
            $this->currentStep++;
            $this->dispatch('wizard-step-changed', step: $this->currentStep);
        }
    }

    public function prevStep(): void
    {
        $this->resetErrorBag();
        if ($this->currentStep > 1) {
            $this->currentStep--;
            $this->dispatch('wizard-step-changed', step: $this->currentStep);
        }
    }

    public function goToStep(int $step): void
    {
        $target = max(1, min($this->total_steps, $step));
        if ($target === $this->currentStep) {
            return;
        }

        if ($target < $this->currentStep) {
            $this->resetErrorBag();
            $this->currentStep = $target;
            $this->dispatch('wizard-step-changed', step: $this->currentStep);
            return;
        }

        for ($s = $this->currentStep; $s < $target; $s++) {
            if ($s === 3 && $this->temuan_pelanggaran === 'Ada Pelanggaran') {
                $this->jenis_pelanggaran = Pelanggaran::normalizeJenisPelanggaranList($this->jenis_pelanggaran);
            }
            try {
                $this->validate($this->rulesForStep($s), $this->stepValidationMessages());
            } catch (ValidationException $e) {
                $this->currentStep = $s;
                $this->dispatch('wizard-step-changed', step: $this->currentStep);
                throw $e;
            }
        }

        $this->currentStep = $target;
        $this->dispatch('wizard-step-changed', step: $this->currentStep);
    }

    private function rulesForStep(int $step): array
    {
        if ($step === 1) {
            return [
                'penjelasan_singkat' => 'nullable|string',
                'pasal_aturan_dilanggar' => 'nullable|string',
                'penjelasan_lainnya' => 'nullable|string',
            ];
        }

        if ($step === 2) {
            return ['temuan_pelanggaran' => 'required'];
        }

        if ($this->temuan_pelanggaran === 'Tidak Ada Pelanggaran') {
            return match ($step) {
                3 => [
                    'upload_kkpr_skrk' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
                    'upload_pbg_imb' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
                    'upload_nib_kbli' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
                    'upload_peta_deliniasi.*' => 'nullable|image|max:10240',
                ],
                default => [],
            };
        }

        return match ($step) {
            3 => [
                'jenis_indikasi_pelanggaran' => 'required',
                'kategori_pelanggaran' => 'required',
                'jenis_pelanggaran' => [
                    'required',
                    function ($attribute, $value, $fail) {
                        if (empty(Pelanggaran::normalizeJenisPelanggaranList($value))) {
                            $fail('Pilih minimal satu sub-pelanggaran pada Komponen A.');
                        }
                    },
                ],
            ],
            4 => [
                'dampak_keluhan_masyarakat' => 'nullable|string',
                'dampak_radius_wilayah' => 'required',
            ],
            5 => [
                'skala_pelanggaran' => 'required',
            ],
            6 => [
                'riwayat_pelanggaran' => 'required',
            ],
            7 => [
                'expert_justifikasi' => 'nullable|string',
                'expert_kesimpulan' => 'nullable|string',
                'expert_tindakan_rekomendasi' => 'required|string',
                'upload_expert_dokumen.*' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
            ],
            8 => [
                'klasifikasi_pelanggaran' => 'required|string',
                'foto_tindak_lanjut.*' => 'nullable|image|max:10240',
                'upload_peta_deliniasi.*' => 'nullable|image|max:10240',
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
            ],
            default => [],
        };
    }

    private function stepValidationMessages(): array
    {
        return [
            'temuan_pelanggaran.required' => 'Pilih kesimpulan pemeriksaan terlebih dahulu.',
            'jenis_indikasi_pelanggaran.required' => 'Pilih uraian indikasi pelanggaran terlebih dahulu.',
            'kategori_pelanggaran.required' => 'Pilih kategori pelanggaran terlebih dahulu.',
            'jenis_pelanggaran.required' => 'Pilih minimal satu sub-pelanggaran pada Komponen A.',
            'dampak_radius_wilayah.required' => 'Pilih kategori dampak terhadap masyarakat terlebih dahulu.',
            'skala_pelanggaran.required' => 'Pilih skala dan intensitas pelanggaran (Komponen C) terlebih dahulu.',
            'riwayat_pelanggaran.required' => 'Pilih riwayat pelanggaran (Komponen D) terlebih dahulu.',
            'expert_tindakan_rekomendasi.required' => 'Pilih tindakan terhadap rekomendasi sistem terlebih dahulu.',
            'klasifikasi_pelanggaran.required' => 'Pilih klasifikasi akhir pelanggaran terlebih dahulu.',
        ];
    }

    private function stepForErrorKeys(array $keys): int
    {
        foreach (range(1, $this->total_steps) as $step) {
            $stepFields = array_keys($this->rulesForStep($step));
            foreach ($keys as $errorKey) {
                $baseKey = explode('.', $errorKey)[0];
                if (in_array($errorKey, $stepFields, true) || in_array($baseKey . '.*', $stepFields, true)) {
                    return $step;
                }
            }
        }

        return $this->currentStep;
    }

    public function updatedDampakKeluhanMasyarakat()
    {
        $this->autoSyncKlasifikasi();
    }

    public function updatedDampakRadiusWilayah()
    {
        $this->autoSyncKlasifikasi();
    }

    public function updatedSkalaPelanggaran()
    {
        $this->autoSyncKlasifikasi();
    }

    public function updatedRiwayatPelanggaran()
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
     * Daftar dokumen sanksi administratif per klasifikasi pelanggaran (sesuai Excel).
     */
    public function getDokumenSanksiProperty(): array
    {
        $all = [
            'sp1' => ['prop' => 'upload_sp1', 'col' => 'file_sp1', 'label' => 'Surat Peringatan I', 'icon' => 'bx-error'],
            'sp2' => ['prop' => 'upload_sp2', 'col' => 'file_sp2', 'label' => 'Surat Peringatan II', 'icon' => 'bx-error'],
            'sp3' => ['prop' => 'upload_sp3', 'col' => 'file_sp3', 'label' => 'Surat Peringatan III', 'icon' => 'bx-error'],
            'pernyataan' => ['prop' => 'upload_pernyataan', 'col' => 'file_pernyataan', 'label' => 'Surat Pernyataan', 'icon' => 'bx-pen'],
            'sosialisasi' => ['prop' => 'upload_sosialisasi', 'col' => 'file_sosialisasi', 'label' => 'Pembinaan / Sosialisasi', 'icon' => 'bx-chalkboard'],
            'pelimpahan' => ['prop' => 'upload_pelimpahan_polpp', 'col' => 'file_pelimpahan_polpp', 'label' => 'Pelimpahan PPNS dan Penertiban Bangunan', 'icon' => 'bx-transfer'],
            'penghentian' => ['prop' => 'upload_sk_sanksi_pemberhentian', 'col' => 'file_sk_sanksi_pemberhentian', 'label' => 'Penghentian Sementara Kegiatan', 'icon' => 'bx-stop-circle'],
            'pembatalan' => ['prop' => 'upload_pembatalan_kkpr', 'col' => 'file_pembatalan_kkpr', 'label' => 'Pembatalan dan Pencabutan KKPR', 'icon' => 'bx-x-circle'],
            'pembongkaran' => ['prop' => 'upload_pembongkaran_bangunan', 'col' => 'file_pembongkaran_bangunan', 'label' => 'Pembongkaran Bangunan', 'icon' => 'bx-building'],
        ];

        $keys = match ($this->klasifikasi_pelanggaran) {
            'Pelanggaran Rendah' => ['sp1', 'pernyataan', 'sosialisasi'],
            'Pelanggaran Sedang' => ['sp1', 'sp2', 'sp3', 'pernyataan', 'sosialisasi', 'pelimpahan'],
            'Pelanggaran Tinggi' => ['sp1', 'sp2', 'sp3', 'pernyataan', 'pelimpahan', 'penghentian', 'pembatalan', 'pembongkaran'],
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
        $this->jenis_pelanggaran = [];
        $this->autoSyncKlasifikasi();
    }

    public function updatedKategoriPelanggaran($value)
    {
        $this->jenis_pelanggaran = [];
        $this->autoSyncKlasifikasi();
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

    public function removeExistingPetaDeliniasi($index)
    {
        if (isset($this->existing_peta_deliniasi[$index])) {
            $path = $this->existing_peta_deliniasi[$index];
            if ($path && Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
            unset($this->existing_peta_deliniasi[$index]);
            $this->existing_peta_deliniasi = array_values($this->existing_peta_deliniasi);
            $this->pelanggaran->update([
                'peta_deliniasi' => count($this->existing_peta_deliniasi) > 0 ? $this->existing_peta_deliniasi : null,
            ]);
        }
    }

    public function removeTempPetaDeliniasi($index)
    {
        unset($this->upload_peta_deliniasi[$index]);
        $this->upload_peta_deliniasi = array_values($this->upload_peta_deliniasi);
    }

    public function storeAnalisa()
    {
        $skorData = null;

        if ($this->temuan_pelanggaran == 'Ada Pelanggaran') {
            $this->jenis_pelanggaran = Pelanggaran::normalizeJenisPelanggaranList($this->jenis_pelanggaran);

            $rules = [];
            for ($s = 1; $s <= 8; $s++) {
                $rules = array_merge($rules, $this->rulesForStep($s));
            }

            try {
                $this->validate($rules, $this->stepValidationMessages());
            } catch (ValidationException $e) {
                $this->currentStep = $this->stepForErrorKeys($e->validator->errors()->keys());
                $this->dispatch('wizard-step-changed', step: $this->currentStep);
                throw $e;
            }

            $skorData = Pelanggaran::hitungSkorPenilaian(
                $this->jenis_pelanggaran,
                $this->dampak_radius_wilayah,
                $this->skala_pelanggaran,
                $this->riwayat_pelanggaran
            );

            // Kompilasi nama sanksi administratif dari dokumen yang diunggah / telah ada
            $sanksiTerunggah = [];
            if ($this->upload_sp1 || $this->pelanggaran->file_sp1) $sanksiTerunggah[] = 'Surat Peringatan I';
            if ($this->upload_sp2 || $this->pelanggaran->file_sp2) $sanksiTerunggah[] = 'Surat Peringatan II';
            if ($this->upload_sp3 || $this->pelanggaran->file_sp3) $sanksiTerunggah[] = 'Surat Peringatan III';
            if ($this->upload_pernyataan || $this->pelanggaran->file_pernyataan) $sanksiTerunggah[] = 'Surat Pernyataan';
            if ($this->upload_sosialisasi || $this->pelanggaran->file_sosialisasi) $sanksiTerunggah[] = 'Pembinaan/Sosialisasi';
            if ($this->upload_pelimpahan_polpp || $this->pelanggaran->file_pelimpahan_polpp) $sanksiTerunggah[] = 'Pelimpahan PPNS / Penertiban Bangunan';
            if ($this->upload_sk_sanksi_pemberhentian || $this->pelanggaran->file_sk_sanksi_pemberhentian) $sanksiTerunggah[] = 'Penghentian Sementara Kegiatan';
            if ($this->upload_pembatalan_kkpr || $this->pelanggaran->file_pembatalan_kkpr) $sanksiTerunggah[] = 'Pembatalan & Pencabutan KKPR';
            if ($this->upload_pembongkaran_bangunan || $this->pelanggaran->file_pembongkaran_bangunan) $sanksiTerunggah[] = 'Pembongkaran Bangunan';

            $this->tindak_lanjut = count($sanksiTerunggah) > 0 ? implode(', ', $sanksiTerunggah) : 'Menunggu Unggahan Dokumen Sanksi';
        } else {
            $rules = array_merge($this->rulesForStep(1), $this->rulesForStep(2), $this->rulesForStep(3));
            try {
                $this->validate($rules, $this->stepValidationMessages());
            } catch (ValidationException $e) {
                $this->currentStep = $this->stepForErrorKeys($e->validator->errors()->keys());
                $this->dispatch('wizard-step-changed', step: $this->currentStep);
                throw $e;
            }
            $this->tindak_lanjut = null;
            $this->jenis_indikasi_pelanggaran = null;
            $this->kategori_pelanggaran = null;
            $this->jenis_pelanggaran = [];
            $this->dampak_keluhan_masyarakat = null;
            $this->dampak_radius_wilayah = null;
            $this->skala_pelanggaran = null;
            $this->riwayat_pelanggaran = null;
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

        // Upload Peta Deliniasi
        $all_peta_deliniasi = $this->existing_peta_deliniasi;
        if ($this->upload_peta_deliniasi) {
            foreach ($this->upload_peta_deliniasi as $peta) {
                $petaFilename = "PETA_{$safeFolder}_" . Str::random(5) . '.' . $peta->getClientOriginalExtension();
                $all_peta_deliniasi[] = $peta->storeAs("pelanggaran/{$safeFolder}/peta_deliniasi", $petaFilename, 'public');
            }
        }

        $updateData = [
            'penjelasan_singkat' => $this->penjelasan_singkat,
            'pasal_aturan_dilanggar' => $this->pasal_aturan_dilanggar,
            'penjelasan_lainnya' => $this->penjelasan_lainnya,
            'temuan_pelanggaran' => $this->temuan_pelanggaran,
            'tindak_lanjut' => $this->tindak_lanjut,
            'jenis_indikasi_pelanggaran' => Pelanggaran::normalizeIndikasi($this->jenis_indikasi_pelanggaran),
            'kategori_pelanggaran' => Pelanggaran::normalizeKategori($this->kategori_pelanggaran),
            'jenis_pelanggaran' => $this->temuan_pelanggaran == 'Ada Pelanggaran'
                ? Pelanggaran::encodeJenisPelanggaran($this->jenis_pelanggaran)
                : null,
            'dampak_keluhan_masyarakat' => $this->dampak_keluhan_masyarakat,
            'dampak_radius_wilayah' => Pelanggaran::normalizeDampak($this->dampak_radius_wilayah),
            'skala_pelanggaran' => Pelanggaran::normalizeSkala($this->skala_pelanggaran),
            'riwayat_pelanggaran' => Pelanggaran::normalizeRiwayat($this->riwayat_pelanggaran),
            'nilai_a' => $skorData['nilai_a'] ?? null,
            'nilai_b' => $skorData['nilai_b'] ?? null,
            'nilai_c' => $skorData['nilai_c'] ?? null,
            'nilai_d' => $skorData['nilai_d'] ?? null,
            'skor_total' => ($skorData && $skorData['is_complete']) ? $skorData['skor_total'] : null,
            'expert_user_id' => $this->temuan_pelanggaran == 'Ada Pelanggaran' ? (Auth::id() ?? $this->expert_user_id) : null,
            'expert_user_name' => $this->temuan_pelanggaran == 'Ada Pelanggaran' ? (Auth::user()?->name ?? $this->expert_user_name) : null,
            'expert_justifikasi' => $this->expert_justifikasi,
            'expert_dokumen_pendukung' => count($all_expert_dokumen) > 0 ? $all_expert_dokumen : null,
            'expert_kesimpulan' => $this->expert_kesimpulan,
            'expert_tindakan_rekomendasi' => $this->expert_tindakan_rekomendasi,
            'klasifikasi_pelanggaran' => $this->klasifikasi_pelanggaran,
            'foto_tindak_lanjut' => count($all_photos) > 0 ? $all_photos : null,
            'peta_deliniasi' => count($all_peta_deliniasi) > 0 ? $all_peta_deliniasi : null,
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
