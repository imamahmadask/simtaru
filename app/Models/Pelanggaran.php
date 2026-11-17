<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Pelanggaran extends Model
{
    protected $table = 'pelanggarans';

    protected $fillable = [
        'no_pelanggaran',
        'tgl_laporan',
        'jenis_formulir',
        'tanggal_pengawasan',        
        'foto_pengawasan',
        'temuan_pelanggaran',
        'sumber_informasi_pelanggaran',
        'nama_pelanggar',
        'nama_pemilik_perusahaan',
        'alamat_pelanggar',
        'kel_pelanggar',
        'kec_pelanggar',
        'kota_pelanggar',
        'prov_pelanggar',
        'alamat_pelanggaran',
        'kel_pelanggaran',
        'kec_pelanggaran',
        'koordinat_pelanggaran',
        'gmaps_pelanggaran',
        'bentuk_laporan',
        'nama_pelapor',
        'telp_pelapor',
        'isi_laporan',
        'jenis_indikasi_pelanggaran',
        'status',
        'no_kkpr_skrk',
        'no_ba_sk_penilaian_kkpr',
        'dokumen_penilaian_kkpr',
        'jenis_pemanfaatan_ruang',
        'pemanfaatan_ruang',
        'tgl_evaluasi',
        'hasil_evaluasi',
        'tindak_lanjut',
        'dokumen_akhir',
        'foto_tindak_lanjut',
        'foto_existing',
        'penjelasan_singkat',
        'file_sp1',
        'file_sp2',
        'file_sp3',
        'file_pelimpahan_polpp',
        'file_pernyataan',
        'file_sosialisasi',
        'file_ba_pengambilan_dokumen',
        'file_ba_penolakan',
        'file_ba_survey',
        'file_ba_survey_surveyor',
        'file_ba_wawancara',
        'file_ba_penerapan_sanksi',
        'file_ba_sosialisasi',
        'file_sk_sanksi_pemberhentian',
        'bukti_perizinan',
        'file_kkpr_skrk',
        'file_pbg_imb',
        'file_nib_kbli',
        'kategori_pelanggaran',
        'jenis_pelanggaran',
        'dampak_keluhan_masyarakat',
        'dampak_radius_wilayah',
        'skala_pelanggaran',
        'riwayat_pelanggaran',
        'nilai_a',
        'nilai_b',
        'nilai_c',
        'nilai_d',
        'skor_total',
        'expert_user_id',
        'expert_user_name',
        'expert_justifikasi',
        'expert_dokumen_pendukung',
        'expert_kesimpulan',
        'expert_tindakan_rekomendasi',
        'klasifikasi_pelanggaran',
        'file_pembatalan_kkpr',
        'file_pembongkaran_bangunan',
    ];

    protected $casts = [
        'foto_pengawasan' => 'array',
        'foto_existing' => 'array',
        'foto_tindak_lanjut' => 'array',
        'expert_dokumen_pendukung' => 'array',
        'nilai_a' => 'float',
        'skor_total' => 'float',
    ];

    public const BOBOT_A = 0.40;
    public const BOBOT_B = 0.35;
    public const BOBOT_C = 0.15;
    public const BOBOT_D = 0.10;

    public const INDIKASI_MAP = [
        'tidak_menaati_rtr' => [
            'label' => 'Tidak Menaati Rencana Tata Ruang (Perubahan Fungsi Ruang)',
            'full' => 'Tidak Menaati Rencana Tata Ruang yang Telah Ditetapkan yang Mengakibatkan Perubahan Fungsi Ruang',
        ],
        'tidak_mematuhi_kkpr' => [
            'label' => 'Tidak Mematuhi Ketentuan Pemanfaatan Ruang (Pelanggaran KKPR)',
            'full' => 'Tidak Mematuhi Ketentuan Pemanfaatan Ruang dalam Rencana Tata Ruang',
        ],
        'menghalangi_akses_umum' => [
            'label' => 'Menghalangi Akses Kawasan Milik Umum',
            'full' => 'Menghalangi akses terhadap kawasan yang oleh ketentuan peraturan perundang-undangan dinyatakan sebagai milik umum',
        ],
    ];

    public const KATEGORI_MAP = [
        'tanpa_kkpr' => [
            'label' => 'Pemanfaatan Ruang Tidak Memiliki KKPR',
            'full' => 'Pemanfaatan Ruang yang tidak memiliki KKPR',
        ],
        'tidak_sesuai_kkpr' => [
            'label' => 'Pemanfaatan Ruang Tidak Memenuhi Ketentuan KKPR',
            'full' => 'Pemanfaatan Ruang yang tidak Memenuhi ketentuan dalam KKPR',
        ],
        'akses_umum' => [
            'label' => 'Menghalangi Akses Terhadap Kawasan Milik Umum',
            'full' => 'Menghalangi Akses Terhadap Kawasan Milik Umum',
        ],
    ];

    public const JENIS_MAP = [
        // Kategori: Tanpa KKPR
        'lokasi_sesuai' => [
            'label' => 'Lokasi Sesuai Peruntukannya',
            'full' => 'Lokasi Sesuai Peruntukannya',
            'nilai' => 2,
        ],
        'lokasi_tidak_sesuai' => [
            'label' => 'Lokasi Tidak Sesuai Peruntukannya',
            'full' => 'Lokasi Tidak Sesuai Peruntukkanya',
            'nilai' => 5,
        ],
        // Kategori: Tidak Sesuai KKPR
        'tidak_lanjut_pbg' => [
            'label' => 'Tidak Menindaklanjuti KKPR (Tidak Melanjutkan PBG)',
            'full' => 'Tidak Menindaklanjuti KKPR (Tidak Melanjutkan PBG)',
            'nilai' => 1,
        ],
        'fungsi_tidak_sesuai' => [
            'label' => 'Fungsi Ruang Tidak Sesuai Dengan KKPR Yang Telah Terbit',
            'full' => 'Fungsi Ruang Tidak Sesuai Dengan KKPR Yang Telah Terbit',
            'nilai' => 4,
        ],
        'sempadan' => [
            'label' => 'Pelanggaran GSB & GSS (Sempadan Sungai, dll)',
            'full' => 'Pelanggaran Sempadan (GSB, GSS, Sempadan Sungai, dll)',
            'nilai' => 2,
        ],
        'klb' => [
            'label' => 'Pelanggaran Ketentuan Koefisien Lantai Bangunan (KLB)',
            'full' => 'Pelanggaran Ketentuan KLB',
            'nilai' => 2,
        ],
        'kdb_kdh' => [
            'label' => 'Pelanggaran Ketentuan KDB dan KDH',
            'full' => 'Pelanggaran Ketentuan KDB dan KDH',
            'nilai' => 2,
        ],
        'perubahan_fungsi_bangunan' => [
            'label' => 'Perubahan Fungsi Bangunan',
            'full' => 'Perubahan Fungsi Bangunan',
            'nilai' => 4,
        ],
        'perubahan_fungsi_lahan' => [
            'label' => 'Perubahan Fungsi Lahan',
            'full' => 'Perubahan Fungsi Lahan',
            'nilai' => 4,
        ],
        'fasum_fasos' => [
            'label' => 'Tidak Menyediakan Fasum dan Fasos Sesuai KKPR',
            'full' => 'Tidak menyediakan Fasum dan Fasos Sesuai KKPR',
            'nilai' => 4,
        ],
        'ketentuan_lain' => [
            'label' => 'Tidak Memenuhi Ketentuan Lainnya dalam KKPR',
            'full' => 'Tidak memenuhi ketentuan lainnya dalam KKPR',
            'nilai' => 2,
        ],
        // Kategori: Akses Milik Umum
        'tutup_pantai_sungai' => [
            'label' => 'Menutup Akses Pantai, Sungai, Danau & Prasarana Publik',
            'full' => 'Menutup Akses pantai, sungai, danau dan sumber daya alam serta prasarana publik',
            'nilai' => 5,
        ],
        'tutup_sda' => [
            'label' => 'Menutup Akses Sumber Daya Air',
            'full' => 'Menutup Akses Sumber Daya Air',
            'nilai' => 5,
        ],
        'tutup_rth' => [
            'label' => 'Menutup Akses Ruang Terbuka Hijau (RTH)',
            'full' => 'Menutup Akses Ruang Terbuka Hijau',
            'nilai' => 4,
        ],
        'tutup_evakuasi' => [
            'label' => 'Menutup Akses Terhadap Lokasi dan Jalur Evakuasi Bencana',
            'full' => 'Menutup Akses Terhadap Lokasi dan Jalur Evakuasi Bencana',
            'nilai' => 5,
        ],
        'tutup_jalan' => [
            'label' => 'Menutup Akses Terhadap Jalan Umum Tanpa Izin',
            'full' => 'Menutup Akses Terhadap Jalan Umum Tanpa Izin',
            'nilai' => 4,
        ],
    ];

    public const DAMPAK_MAP = [
        'Tidak Ada' => [
            'label' => 'Tidak Ada',
            'nilai' => 1,
        ],
        'Kecil (< 250 meter)' => [
            'label' => 'Kecil (< 250 meter)',
            'nilai' => 2,
        ],
        'Sedang (250 - 500 meter)' => [
            'label' => 'Sedang (250 - 500 meter)',
            'nilai' => 3,
        ],
        'Besar (> 500 meter)' => [
            'label' => 'Besar (> 500 meter)',
            'nilai' => 4,
        ],
    ];

    public const SKALA_MAP = [
        'skala_1' => [
            'label' => '< 10% Luasan Maksimal yg Diperbolehkan (Luasan Bangunan < 50 m²)',
            'short' => '< 10% Luasan Maks / < 50 m²',
            'nilai' => 1,
        ],
        'skala_2' => [
            'label' => '10 - 25% Luasan Maksimal yg Diperbolehkan (Luasan Bangunan 50 - 200 m²)',
            'short' => '10 - 25% Luasan Maks / 50 - 200 m²',
            'nilai' => 2,
        ],
        'skala_3' => [
            'label' => '25 - 50% Luasan Maksimal yg Diperbolehkan (Luasan Bangunan 200 - 500 m²)',
            'short' => '25 - 50% Luasan Maks / 200 - 500 m²',
            'nilai' => 3,
        ],
        'skala_4' => [
            'label' => '50 - 75% Luasan Maksimal yg Diperbolehkan (Luasan Bangunan 500 - 1.000 m²)',
            'short' => '50 - 75% Luasan Maks / 500 - 1.000 m²',
            'nilai' => 4,
        ],
        'skala_5' => [
            'label' => '75 - 100% Luasan Maksimal yg Diperbolehkan (Luasan Bangunan > 1.000 m²)',
            'short' => '75 - 100% Luasan Maks / > 1.000 m²',
            'nilai' => 5,
        ],
    ];

    public const RIWAYAT_MAP = [
        'riwayat_1' => [
            'label' => 'Tidak Ditemukan faktor pemberat',
            'nilai' => 1,
        ],
        'riwayat_2' => [
            'label' => 'Pernah Menerima Pembinaan',
            'nilai' => 2,
        ],
        'riwayat_3' => [
            'label' => 'Pernah Menerima SP',
            'nilai' => 3,
        ],
        'riwayat_4' => [
            'label' => 'Tidak melaksanakan surat peringatan yang telah disampaikan',
            'nilai' => 4,
        ],
        'riwayat_5' => [
            'label' => 'Mengulangi pelanggaran setelah tindakan penegakan atau tetap melanggar setelah diperintahkan menghentikan kegiatan',
            'nilai' => 5,
        ],
    ];

    public const JENIS_PER_KATEGORI = [
        'tanpa_kkpr' => ['lokasi_sesuai', 'lokasi_tidak_sesuai'],
        'tidak_sesuai_kkpr' => [
            'tidak_lanjut_pbg', 'fungsi_tidak_sesuai', 'sempadan', 'klb', 'kdb_kdh',
            'perubahan_fungsi_bangunan', 'perubahan_fungsi_lahan', 'fasum_fasos', 'ketentuan_lain',
        ],
        'akses_umum' => ['tutup_pantai_sungai', 'tutup_sda', 'tutup_rth', 'tutup_evakuasi', 'tutup_jalan'],
    ];

    public static function normalizeIndikasi(?string $value): ?string
    {
        if (!$value) {
            return null;
        }
        $trimmed = trim($value);
        $stripped = preg_replace('/^\d+\.\s*/', '', $trimmed);
        $reverse = [
            'Tidak Menaati Rencana Tata Ruang yang Telah Ditetapkan yang Mengakibatkan Perubahan Fungsi Ruang' => 'tidak_menaati_rtr',
            'Tidak Menaati Rencana Tata Ruang (Perubahan Fungsi Ruang)' => 'tidak_menaati_rtr',
            'Tidak Mematuhi Ketentuan Pemanfaatan Ruang dalam Rencana Tata Ruang' => 'tidak_mematuhi_kkpr',
            'Tidak Mematuhi Ketentuan Pemanfaatan Ruang (Pelanggaran KKPR)' => 'tidak_mematuhi_kkpr',
            'Menghalangi akses terhadap kawasan yang oleh ketentuan peraturan perundang-undangan dinyatakan sebagai milik umum' => 'menghalangi_akses_umum',
            'Menghalangi Akses Terhadap Kawasan Yang Ditetapkan Sebagai Milik Umum' => 'menghalangi_akses_umum',
            'Menghalangi Akses Kawasan Milik Umum' => 'menghalangi_akses_umum',
        ];
        return $reverse[$trimmed] ?? $reverse[$stripped] ?? $stripped;
    }

    public static function normalizeKategori(?string $value): ?string
    {
        if (!$value) return null;
        $reverse = [
            'Pemanfaatan Ruang yang tidak memiliki KKPR' => 'tanpa_kkpr',
            'Pemanfaatan Ruang yang tidak Memenuhi ketentuan dalam KKPR' => 'tidak_sesuai_kkpr',
            'Pemanfaatan Ruang yang tidak mematuhi ketentuan dalam muatan KKPR' => 'tidak_sesuai_kkpr',
            'Menghalangi Akses Terhadap Kawasan Milik Umum' => 'akses_umum',
        ];
        return $reverse[$value] ?? $value;
    }

    public static function normalizeJenisPelanggaran(?string $value): ?string
    {
        if (!$value) return null;
        $reverse = [
            'Lokasi Sesuai Peruntukkannya' => 'lokasi_sesuai',
            'Lokasi Sesuai Peruntukannya' => 'lokasi_sesuai',
            'Lokasi Tidak Sesuai Peruntukkanya' => 'lokasi_tidak_sesuai',
            'Lokasi Tidak Sesuai Peruntukannya' => 'lokasi_tidak_sesuai',
            'Tidak Menindaklanjuti KKPR' => 'tidak_lanjut_pbg',
            'Tidak Menindaklanjuti KKPR (Tidak Melanjutkan PBG)' => 'tidak_lanjut_pbg',
            'Fungsi Ruang Tidak Sesuai Dengan KKPR Yang Telah Terbit' => 'fungsi_tidak_sesuai',
            'Pelanggaran GSB & GSS' => 'sempadan',
            'Pelanggaran Sempadan (GSB, GSS, Sempadan Sungai, dll)' => 'sempadan',
            'Pelanggaran Ketentuan KLB' => 'klb',
            'Pelanggaran Ketentuan KDB dan KDH' => 'kdb_kdh',
            'Perubahan Fungsi Bangunan' => 'perubahan_fungsi_bangunan',
            'Perubahan Fungsi Lahan' => 'perubahan_fungsi_lahan',
            'Tidak menyediakan Fasum dan Fasos Sesuai KKPR' => 'fasum_fasos',
            'Tidak memenuhi ketentuan lainnya dalam KKPR' => 'ketentuan_lain',
            'Menutup Akses pantai, sungai, danau dan sumber daya alam serta prasarana publik' => 'tutup_pantai_sungai',
            'Menutup Akses sumber daya air' => 'tutup_sda',
            'Menutup Akses Sumber Daya Air' => 'tutup_sda',
            'Menutup Akses RTH' => 'tutup_rth',
            'Menutup Akses Ruang Terbuka Hijau' => 'tutup_rth',
            'Menutup Akses terhadap lokasi dan jalur evakuasi bencana' => 'tutup_evakuasi',
            'Menutup Akses Terhadap Lokasi dan Jalur Evakuasi Bencana' => 'tutup_evakuasi',
            'Menutup Akses Terhadap Jalan Umum Tanpa Izin' => 'tutup_jalan',
        ];
        return $reverse[$value] ?? $value;
    }

    /**
     * Mengubah nilai jenis_pelanggaran (single slug, teks lama, JSON array string, atau PHP array)
     * menjadi array kode slug unik yang ternormalisasi.
     */
    public static function normalizeJenisPelanggaranList(mixed $value): array
    {
        if ($value === null || $value === '') {
            return [];
        }

        if (is_string($value)) {
            $trimmed = trim($value);
            if ($trimmed === '') {
                return [];
            }
            if (str_starts_with($trimmed, '[')) {
                $decoded = json_decode($trimmed, true);
                $items = is_array($decoded) ? $decoded : [$trimmed];
            } else {
                $items = [$trimmed];
            }
        } elseif (is_array($value)) {
            $items = $value;
        } else {
            return [];
        }

        $normalized = [];
        foreach ($items as $item) {
            if (!is_string($item) && !is_numeric($item)) {
                continue;
            }
            $trimmedItem = trim((string) $item);
            if ($trimmedItem === '' || $trimmedItem === '__rm__') {
                continue;
            }
            $slug = self::normalizeJenisPelanggaran($trimmedItem);
            if ($slug !== null && $slug !== '') {
                $normalized[] = $slug;
            }
        }

        return array_values(array_unique($normalized));
    }

    /**
     * Menyimpan 1 pilihan sebagai slug string agar kompatibel dengan data/test lama,
     * dan >= 2 pilihan sebagai JSON array string.
     */
    public static function encodeJenisPelanggaran(mixed $value): ?string
    {
        $list = self::normalizeJenisPelanggaranList($value);
        if (empty($list)) {
            return null;
        }

        return count($list) === 1 ? $list[0] : json_encode($list);
    }

    public static function normalizeDampak(?string $value): ?string
    {
        if (!$value) return null;
        $reverse = [
            'Dampak Tidak Ada' => 'Tidak Ada',
            'Kecil (< 500 m)' => 'Sedang (250 - 500 meter)',
            'Besar (> 500 m)' => 'Besar (> 500 meter)',
        ];
        return $reverse[$value] ?? $value;
    }

    public static function normalizeSkala(?string $value): ?string
    {
        if (!$value) return null;
        foreach (self::SKALA_MAP as $slug => $meta) {
            if ($value === $slug || $value === $meta['label'] || $value === $meta['short']) {
                return $slug;
            }
        }
        return $value;
    }

    public static function normalizeRiwayat(?string $value): ?string
    {
        if (!$value) return null;
        foreach (self::RIWAYAT_MAP as $slug => $meta) {
            if ($value === $slug || $value === $meta['label']) {
                return $slug;
            }
        }
        return $value;
    }

    public function getIndikasiLabelAttribute(): string
    {
        $val = self::normalizeIndikasi($this->jenis_indikasi_pelanggaran);
        if (isset(self::INDIKASI_MAP[$val]['label'])) {
            return self::INDIKASI_MAP[$val]['label'];
        }
        $fallback = trim((string) ($this->jenis_indikasi_pelanggaran ?? ''));
        $fallback = preg_replace('/^\d+\.\s*/', '', $fallback);
        return $fallback !== '' ? $fallback : '-';
    }

    public function getIndikasiFullTextAttribute(): string
    {
        $val = self::normalizeIndikasi($this->jenis_indikasi_pelanggaran);
        if (isset(self::INDIKASI_MAP[$val]['full'])) {
            return self::INDIKASI_MAP[$val]['full'];
        }
        $fallback = trim((string) ($this->jenis_indikasi_pelanggaran ?? ''));
        $fallback = preg_replace('/^\d+\.\s*/', '', $fallback);
        return $fallback !== '' ? $fallback : '-';
    }

    public function getKategoriLabelAttribute(): string
    {
        $val = self::normalizeKategori($this->kategori_pelanggaran);
        return self::KATEGORI_MAP[$val]['label'] ?? ($this->kategori_pelanggaran ?? '-');
    }

    public function getKategoriFullTextAttribute(): string
    {
        $val = self::normalizeKategori($this->kategori_pelanggaran);
        return self::KATEGORI_MAP[$val]['full'] ?? ($this->kategori_pelanggaran ?? '-');
    }

    public function getJenisPelanggaranListAttribute(): array
    {
        return self::normalizeJenisPelanggaranList($this->jenis_pelanggaran);
    }

    public function getJenisPelanggaranLabelAttribute(): string
    {
        $list = $this->jenis_pelanggaran_list;
        if (empty($list)) {
            return '-';
        }
        return collect($list)
            ->map(fn ($slug) => self::JENIS_MAP[$slug]['label'] ?? $slug)
            ->implode(', ');
    }

    public function getJenisPelanggaranFullTextAttribute(): string
    {
        $list = $this->jenis_pelanggaran_list;
        if (empty($list)) {
            return '-';
        }
        return collect($list)
            ->map(fn ($slug) => self::JENIS_MAP[$slug]['full'] ?? $slug)
            ->implode(', ');
    }

    public function getDampakLabelAttribute(): string
    {
        $val = self::normalizeDampak($this->dampak_radius_wilayah);
        return self::DAMPAK_MAP[$val]['label'] ?? ($this->dampak_radius_wilayah ?? '-');
    }

    public function getSkalaLabelAttribute(): string
    {
        $val = self::normalizeSkala($this->skala_pelanggaran);
        return self::SKALA_MAP[$val]['label'] ?? ($this->skala_pelanggaran ?? '-');
    }

    public function getRiwayatLabelAttribute(): string
    {
        $val = self::normalizeRiwayat($this->riwayat_pelanggaran);
        return self::RIWAYAT_MAP[$val]['label'] ?? ($this->riwayat_pelanggaran ?? '-');
    }

    /**
     * Menghitung rincian penilaian A, B, C, D dan Skor Total S = 20 * ((A*40%) + (B*35%) + (C*15%) + (D*10%)).
     */
    public static function hitungSkorPenilaian(mixed $jenisList, ?string $dampak, ?string $skala, ?string $riwayat): array
    {
        $itemsA = [];
        $nilaiA = 0.0;
        $hasilA = 0.0;

        foreach (self::normalizeJenisPelanggaranList($jenisList) as $slug) {
            $meta = self::JENIS_MAP[$slug] ?? null;
            if ($meta) {
                $nilai = (int) $meta['nilai'];
                $hasil = round($nilai * self::BOBOT_A, 2);
                $itemsA[] = [
                    'slug' => $slug,
                    'label' => $meta['label'],
                    'nilai' => $nilai,
                    'bobot' => self::BOBOT_A,
                    'hasil' => $hasil,
                ];
                $nilaiA += $nilai;
                $hasilA += $hasil;
            }
        }
        $hasilA = round($hasilA, 2);

        $dampakKey = self::normalizeDampak($dampak);
        $dampakMeta = $dampakKey ? (self::DAMPAK_MAP[$dampakKey] ?? null) : null;
        $nilaiB = $dampakMeta ? (int) $dampakMeta['nilai'] : null;
        $hasilB = $nilaiB !== null ? round($nilaiB * self::BOBOT_B, 2) : 0.0;

        $skalaKey = self::normalizeSkala($skala);
        $skalaMeta = $skalaKey ? (self::SKALA_MAP[$skalaKey] ?? null) : null;
        $nilaiC = $skalaMeta ? (int) $skalaMeta['nilai'] : null;
        $hasilC = $nilaiC !== null ? round($nilaiC * self::BOBOT_C, 2) : 0.0;

        $riwayatKey = self::normalizeRiwayat($riwayat);
        $riwayatMeta = $riwayatKey ? (self::RIWAYAT_MAP[$riwayatKey] ?? null) : null;
        $nilaiD = $riwayatMeta ? (int) $riwayatMeta['nilai'] : null;
        $hasilD = $nilaiD !== null ? round($nilaiD * self::BOBOT_D, 2) : 0.0;

        $jumlahAbcd = round($hasilA + $hasilB + $hasilC + $hasilD, 2);
        $skorTotal = round(20 * $jumlahAbcd, 2);
        $isComplete = count($itemsA) > 0 && $nilaiB !== null && $nilaiC !== null && $nilaiD !== null;

        return [
            'items_a' => $itemsA,
            'nilai_a' => count($itemsA) > 0 ? $nilaiA : null,
            'hasil_a' => $hasilA,
            'dampak_label' => $dampakMeta['label'] ?? null,
            'nilai_b' => $nilaiB,
            'hasil_b' => $hasilB,
            'skala_label' => $skalaMeta['label'] ?? null,
            'nilai_c' => $nilaiC,
            'hasil_c' => $hasilC,
            'riwayat_label' => $riwayatMeta['label'] ?? null,
            'nilai_d' => $nilaiD,
            'hasil_d' => $hasilD,
            'jumlah_abcd' => $jumlahAbcd,
            'skor_total' => $skorTotal,
            'is_complete' => $isComplete,
            'rekomendasi_kategori' => $isComplete ? self::kategoriDariSkor($skorTotal) : null,
        ];
    }

    public static function kategoriDariSkor(float|int $skor): string
    {
        if ($skor < 40) {
            return 'Pelanggaran Rendah';
        }
        if ($skor <= 60) {
            return 'Pelanggaran Sedang';
        }
        return 'Pelanggaran Tinggi';
    }

    /**
     * Tingkat bobot delik per jenis pelanggaran (Rendah / Sedang / Tinggi).
     * Dapat disesuaikan dengan ketentuan teknis yang berlaku.
     */
    public const DELIK_LEVEL = [
        'lokasi_sesuai' => 'Rendah',
        'lokasi_tidak_sesuai' => 'Tinggi',
        'tidak_lanjut_pbg' => 'Rendah',
        'fungsi_tidak_sesuai' => 'Tinggi',
        'sempadan' => 'Tinggi',
        'klb' => 'Sedang',
        'kdb_kdh' => 'Sedang',
        'perubahan_fungsi_bangunan' => 'Sedang',
        'perubahan_fungsi_lahan' => 'Tinggi',
        'fasum_fasos' => 'Sedang',
        'ketentuan_lain' => 'Sedang',
        'tutup_pantai_sungai' => 'Tinggi',
        'tutup_sda' => 'Tinggi',
        'tutup_rth' => 'Sedang',
        'tutup_evakuasi' => 'Tinggi',
        'tutup_jalan' => 'Sedang',
    ];

    public const ARAH_PENANGANAN = [
        'Pelanggaran Rendah' => 'Surat Peringatan I, Surat Pernyataan, dan Pembinaan.',
        'Pelanggaran Sedang' => 'Surat Peringatan I–III, Surat Pernyataan, Pembinaan, serta Pelimpahan PPNS dan Penertiban Bangunan.',
        'Pelanggaran Tinggi' => 'Surat Peringatan I–III, Surat Pernyataan, Pelimpahan PPNS dan Penertiban Bangunan, Penghentian Sementara Kegiatan, Pembatalan dan Pencabutan KKPR, serta Pembongkaran Bangunan.',
    ];

    /**
     * Tingkat dampak berdasarkan keluhan masyarakat & kategori dampak terhadap masyarakat.
     */
    public static function levelDampak(?string $keluhan, ?string $radius): ?string
    {
        $normRadius = self::normalizeDampak($radius);
        if (!$normRadius) {
            return null;
        }
        if ($normRadius === 'Besar (> 500 meter)') {
            return 'Tinggi';
        }
        if ($normRadius === 'Sedang (250 - 500 meter)' || $keluhan === 'Ada') {
            return 'Sedang';
        }
        return 'Rendah';
    }

    /**
     * Data ringkas untuk card Resume Pelanggaran.
     * Menerima $overrides agar dapat menampilkan pratinjau langsung dari state form Livewire.
     */
    public function resume(array $overrides = []): array
    {
        $indikasiKey = self::normalizeIndikasi($overrides['jenis_indikasi_pelanggaran'] ?? $this->jenis_indikasi_pelanggaran);
        $kategoriKey = self::normalizeKategori($overrides['kategori_pelanggaran'] ?? $this->kategori_pelanggaran);
        $jenisKeys = self::normalizeJenisPelanggaranList($overrides['jenis_pelanggaran'] ?? $this->jenis_pelanggaran);
        $keluhan = $overrides['dampak_keluhan_masyarakat'] ?? $this->dampak_keluhan_masyarakat;
        $radius = $overrides['dampak_radius_wilayah'] ?? $this->dampak_radius_wilayah;
        $skala = $overrides['skala_pelanggaran'] ?? $this->skala_pelanggaran;
        $riwayat = $overrides['riwayat_pelanggaran'] ?? $this->riwayat_pelanggaran;
        $klasifikasi = $overrides['klasifikasi_pelanggaran'] ?? $this->klasifikasi_pelanggaran;
        $justifikasi = $overrides['expert_justifikasi'] ?? $this->expert_justifikasi;
        $kesimpulan = $overrides['expert_kesimpulan'] ?? $this->expert_kesimpulan;
        $temuan = $overrides['temuan_pelanggaran'] ?? $this->temuan_pelanggaran;

        $jenisLabels = collect($jenisKeys)
            ->map(fn ($slug) => self::JENIS_MAP[$slug]['label'] ?? $slug)
            ->values();

        // Uraian kasus
        if (filled($this->penjelasan_singkat)) {
            $kasus = $this->penjelasan_singkat;
        } else {
            $lokasi = collect([
                $this->alamat_pelanggaran,
                $this->kel_pelanggaran ? 'Kel. ' . $this->kel_pelanggaran : null,
                $this->kec_pelanggaran ? 'Kec. ' . $this->kec_pelanggaran : null,
            ])->filter()->implode(', ');

            $kasus = ($this->jenis_pemanfaatan_ruang ?: 'Pemanfaatan ruang')
                . ($lokasi ? " di {$lokasi}" : '')
                . ($this->pemanfaatan_ruang ? " pada zona peruntukan {$this->pemanfaatan_ruang} dalam RTR" : '')
                . ($jenisLabels->isNotEmpty() ? '. Ditemukan indikasi: ' . $jenisLabels->implode(', ') : '')
                . '.';
        }

        // Foto utama
        $foto = collect([
            $this->foto_existing[0] ?? null,
            $this->foto_pengawasan[0] ?? null,
            $this->foto_tindak_lanjut[0] ?? null,
        ])->filter()->first();

        // Delik Pelanggaran (ambil bobot tertinggi bila multi-select)
        $kategoriLabel = self::KATEGORI_MAP[$kategoriKey]['full'] ?? (self::KATEGORI_MAP[$kategoriKey]['label'] ?? $kategoriKey);
        $delikText = collect([$kategoriLabel, $jenisLabels->implode(', ')])->filter()->implode(' — ');

        $delikOrder = ['Rendah' => 1, 'Sedang' => 2, 'Tinggi' => 3];
        $delikLevel = null;
        $maxWeight = 0;
        foreach ($jenisKeys as $slug) {
            $lvl = self::DELIK_LEVEL[$slug] ?? null;
            if ($lvl && ($delikOrder[$lvl] ?? 0) > $maxWeight) {
                $maxWeight = $delikOrder[$lvl];
                $delikLevel = $lvl;
            }
        }

        // Dampak
        $normRadius = self::normalizeDampak($radius);
        $dampakParts = collect([
            match ($keluhan) {
                'Ada' => 'Terdapat keluhan masyarakat',
                'Tidak Ada' => 'Tidak ada keluhan masyarakat',
                default => null,
            },
            match ($normRadius) {
                'Tidak Ada' => 'tidak berdampak pada wilayah sekitar',
                'Kecil (< 250 meter)' => 'dampak kecil pada radius < 250 meter',
                'Sedang (250 - 500 meter)' => 'dampak sedang pada radius 250 - 500 meter',
                'Besar (> 500 meter)' => 'dampak meluas pada radius > 500 meter',
                default => null,
            },
        ])->filter()->implode(', ');

        $dampakText = $dampakParts ? ucfirst($dampakParts) . '.' : '-';
        if (filled($justifikasi)) {
            $dampakText = ($dampakParts ? ucfirst($dampakParts) . '. ' : '') . $justifikasi;
        }

        // Hitung skor penilaian
        $penilaian = self::hitungSkorPenilaian($jenisKeys, $radius, $skala, $riwayat);

        // Arah Penanganan
        $arahDefault = self::ARAH_PENANGANAN[$klasifikasi] ?? ($temuan === 'Tidak Ada Pelanggaran' ? 'Tidak diperlukan sanksi administratif (pemanfaatan ruang telah sesuai ketentuan).' : '-');
        $arahText = filled($kesimpulan) ? $kesimpulan : $arahDefault;

        return [
            'temuan' => $temuan,
            'kasus' => $kasus,
            'foto' => $foto,
            'indikasi_text' => self::INDIKASI_MAP[$indikasiKey]['label'] ?? ($indikasiKey ?: '-'),
            'delik_level' => $delikLevel,
            'delik_items' => $jenisLabels->all(),
            'delik_text' => $delikText ?: '-',
            'delik_sub' => $kategoriLabel ?: null,
            'dampak_level' => self::levelDampak($keluhan, $radius),
            'dampak_text' => $dampakText,
            'skala_label' => $penilaian['skala_label'],
            'riwayat_label' => $penilaian['riwayat_label'],
            'skor_total' => $penilaian['is_complete'] ? $penilaian['skor_total'] : ($this->skor_total !== null ? (float) $this->skor_total : null),
            'jumlah_abcd' => $penilaian['is_complete'] ? $penilaian['jumlah_abcd'] : null,
            'tipologi' => $klasifikasi ?: ($temuan === 'Tidak Ada Pelanggaran' ? 'Tidak Ada Pelanggaran' : null),
            'arah' => $arahText,
        ];
    }

    public function expertUser()
    {
        return $this->belongsTo(User::class, 'expert_user_id');
    }

    public function sarans()
    {
        return $this->hasMany(SaranPelanggaran::class, 'pelanggaran_id');
    }

    /**
     * Terapkan pencarian teks dan filter daftar kasus pelanggaran secara seragam.
     */
    public function scopeApplyFilters(Builder $query, array $filters): Builder
    {
        return $query
            ->when($filters['search'] ?? null, function ($q, $search) {
                $q->where(function ($sub) use ($search) {
                    $sub->where('no_pelanggaran', 'like', '%' . $search . '%')
                        ->orWhere('nama_pelanggar', 'like', '%' . $search . '%')
                        ->orWhere('nama_pemilik_perusahaan', 'like', '%' . $search . '%')
                        ->orWhere('alamat_pelanggaran', 'like', '%' . $search . '%')
                        ->orWhere('kel_pelanggaran', 'like', '%' . $search . '%')
                        ->orWhere('kec_pelanggaran', 'like', '%' . $search . '%');
                });
            })
            ->when($filters['status'] ?? null, fn ($q, $v) => $q->where('status', $v))
            ->when($filters['temuan'] ?? null, fn ($q, $v) => $q->where('temuan_pelanggaran', $v))
            ->when($filters['kecamatan'] ?? null, fn ($q, $v) => $q->where('kec_pelanggaran', $v))
            ->when($filters['year'] ?? null, fn ($q, $v) => $q->whereYear('tgl_laporan', $v))
            ->when($filters['sumber'] ?? null, fn ($q, $v) => $q->where('sumber_informasi_pelanggaran', $v))
            ->when($filters['tindak_lanjut'] ?? null, fn ($q, $v) => $q->where('tindak_lanjut', $v))
            ->when($filters['klasifikasi'] ?? null, function ($q, $klasifikasi) {
                if ($klasifikasi === 'belum_dianalisis') {
                    $q->whereNull('klasifikasi_pelanggaran');
                } else {
                    $q->where('klasifikasi_pelanggaran', $klasifikasi);
                }
            });
    }
}
