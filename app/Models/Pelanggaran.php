<?php

namespace App\Models;

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
    ];

    public const INDIKASI_MAP = [
        'tidak_menaati_rtr' => [
            'label' => '1. Tidak Menaati Rencana Tata Ruang (Perubahan Fungsi Ruang)',
            'full' => 'Tidak Menaati Rencana Tata Ruang yang Telah Ditetapkan yang Mengakibatkan Perubahan Fungsi Ruang',
        ],
        'tidak_mematuhi_kkpr' => [
            'label' => '2. Tidak Mematuhi Ketentuan Pemanfaatan Ruang (Pelanggaran KKPR)',
            'full' => 'Tidak Mematuhi Ketentuan Pemanfaatan Ruang dalam Rencana Tata Ruang',
        ],
        'menghalangi_akses_umum' => [
            'label' => '3. Menghalangi Akses Kawasan Milik Umum',
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
        ],
        'lokasi_tidak_sesuai' => [
            'label' => 'Lokasi Tidak Sesuai Peruntukannya',
            'full' => 'Lokasi Tidak Sesuai Peruntukkanya',
        ],
        // Kategori: Tidak Sesuai KKPR
        'tidak_lanjut_pbg' => [
            'label' => 'Tidak Menindaklanjuti KKPR (Tidak Melanjutkan PBG)',
            'full' => 'Tidak Menindaklanjuti KKPR (Tidak Melanjutkan PBG)',
        ],
        'fungsi_tidak_sesuai' => [
            'label' => 'Fungsi Ruang Tidak Sesuai Dengan KKPR Yang Telah Terbit',
            'full' => 'Fungsi Ruang Tidak Sesuai Dengan KKPR Yang Telah Terbit',
        ],
        'sempadan' => [
            'label' => 'Pelanggaran Sempadan (GSB, GSS, Sempadan Sungai, dll)',
            'full' => 'Pelanggaran Sempadan (GSB, GSS, Sempadan Sungai, dll)',
        ],
        'klb' => [
            'label' => 'Pelanggaran Ketentuan Koefisien Lantai Bangunan (KLB)',
            'full' => 'Pelanggaran Ketentuan KLB',
        ],
        'kdb_kdh' => [
            'label' => 'Pelanggaran Ketentuan KDB dan KDH',
            'full' => 'Pelanggaran Ketentuan KDB dan KDH',
        ],
        'perubahan_fungsi_bangunan' => [
            'label' => 'Perubahan Fungsi Bangunan',
            'full' => 'Perubahan Fungsi Bangunan',
        ],
        'perubahan_fungsi_lahan' => [
            'label' => 'Perubahan Fungsi Lahan',
            'full' => 'Perubahan Fungsi Lahan',
        ],
        'fasum_fasos' => [
            'label' => 'Tidak Menyediakan Fasum dan Fasos Sesuai KKPR',
            'full' => 'Tidak menyediakan Fasum dan Fasos Sesuai KKPR',
        ],
        'ketentuan_lain' => [
            'label' => 'Tidak Memenuhi Ketentuan Lainnya dalam KKPR',
            'full' => 'Tidak memenuhi ketentuan lainnya dalam KKPR',
        ],
        // Kategori: Akses Milik Umum
        'tutup_pantai_sungai' => [
            'label' => 'Menutup Akses Pantai, Sungai, Danau & Prasarana Publik',
            'full' => 'Menutup Akses pantai, sungai, danau dan sumber daya alam serta prasarana publik',
        ],
        'tutup_sda' => [
            'label' => 'Menutup Akses Sumber Daya Air',
            'full' => 'Menutup Akses Sumber Daya Air',
        ],
        'tutup_rth' => [
            'label' => 'Menutup Akses Ruang Terbuka Hijau (RTH)',
            'full' => 'Menutup Akses Ruang Terbuka Hijau',
        ],
        'tutup_evakuasi' => [
            'label' => 'Menutup Akses Terhadap Lokasi dan Jalur Evakuasi Bencana',
            'full' => 'Menutup Akses Terhadap Lokasi dan Jalur Evakuasi Bencana',
        ],
        'tutup_jalan' => [
            'label' => 'Menutup Akses Terhadap Jalan Umum Tanpa Izin',
            'full' => 'Menutup Akses Terhadap Jalan Umum Tanpa Izin',
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
        if (!$value) return null;
        $reverse = [
            'Tidak Menaati Rencana Tata Ruang yang Telah Ditetapkan yang Mengakibatkan Perubahan Fungsi Ruang' => 'tidak_menaati_rtr',
            'Tidak Mematuhi Ketentuan Pemanfaatan Ruang dalam Rencana Tata Ruang' => 'tidak_mematuhi_kkpr',
            'Menghalangi akses terhadap kawasan yang oleh ketentuan peraturan perundang-undangan dinyatakan sebagai milik umum' => 'menghalangi_akses_umum',
            'Menghalangi Akses Terhadap Kawasan Yang Ditetapkan Sebagai Milik Umum' => 'menghalangi_akses_umum',
        ];
        return $reverse[$value] ?? $value;
    }

    public static function normalizeKategori(?string $value): ?string
    {
        if (!$value) return null;
        $reverse = [
            'Pemanfaatan Ruang yang tidak memiliki KKPR' => 'tanpa_kkpr',
            'Pemanfaatan Ruang yang tidak Memenuhi ketentuan dalam KKPR' => 'tidak_sesuai_kkpr',
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
            'Tidak Menindaklanjuti KKPR (Tidak Melanjutkan PBG)' => 'tidak_lanjut_pbg',
            'Fungsi Ruang Tidak Sesuai Dengan KKPR Yang Telah Terbit' => 'fungsi_tidak_sesuai',
            'Pelanggaran Sempadan (GSB, GSS, Sempadan Sungai, dll)' => 'sempadan',
            'Pelanggaran Ketentuan KLB' => 'klb',
            'Pelanggaran Ketentuan KDB dan KDH' => 'kdb_kdh',
            'Perubahan Fungsi Bangunan' => 'perubahan_fungsi_bangunan',
            'Perubahan Fungsi Lahan' => 'perubahan_fungsi_lahan',
            'Tidak menyediakan Fasum dan Fasos Sesuai KKPR' => 'fasum_fasos',
            'Tidak memenuhi ketentuan lainnya dalam KKPR' => 'ketentuan_lain',
            'Menutup Akses pantai, sungai, danau dan sumber daya alam serta prasarana publik' => 'tutup_pantai_sungai',
            'Menutup Akses Sumber Daya Air' => 'tutup_sda',
            'Menutup Akses Ruang Terbuka Hijau' => 'tutup_rth',
            'Menutup Akses Terhadap Lokasi dan Jalur Evakuasi Bencana' => 'tutup_evakuasi',
            'Menutup Akses Terhadap Jalan Umum Tanpa Izin' => 'tutup_jalan',
        ];
        return $reverse[$value] ?? $value;
    }

    public function getIndikasiLabelAttribute(): string
    {
        $val = self::normalizeIndikasi($this->jenis_indikasi_pelanggaran);
        return self::INDIKASI_MAP[$val]['label'] ?? ($this->jenis_indikasi_pelanggaran ?? '-');
    }

    public function getIndikasiFullTextAttribute(): string
    {
        $val = self::normalizeIndikasi($this->jenis_indikasi_pelanggaran);
        return self::INDIKASI_MAP[$val]['full'] ?? ($this->jenis_indikasi_pelanggaran ?? '-');
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

    public function getJenisPelanggaranLabelAttribute(): string
    {
        $val = self::normalizeJenisPelanggaran($this->jenis_pelanggaran);
        return self::JENIS_MAP[$val]['label'] ?? ($this->jenis_pelanggaran ?? '-');
    }

    public function getJenisPelanggaranFullTextAttribute(): string
    {
        $val = self::normalizeJenisPelanggaran($this->jenis_pelanggaran);
        return self::JENIS_MAP[$val]['full'] ?? ($this->jenis_pelanggaran ?? '-');
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
        'Pelanggaran Rendah' => 'Pembinaan/sosialisasi, surat peringatan tertulis, dan surat pernyataan.',
        'Pelanggaran Sedang' => 'Pembinaan/sosialisasi, surat peringatan I–III, surat pernyataan, serta pelimpahan ke PPNS/penertiban bangunan.',
        'Pelanggaran Tinggi' => 'Surat peringatan I–III, penghentian sementara kegiatan, pembatalan/pencabutan KKPR, dan pembongkaran bangunan serta pemulihan fungsi ruang.',
    ];

    /**
     * Tingkat dampak berdasarkan keluhan masyarakat & radius wilayah terdampak.
     */
    public static function levelDampak(?string $keluhan, ?string $radius): ?string
    {
        if (!$keluhan || !$radius) {
            return null;
        }
        if ($radius === 'Besar (> 500 m)') {
            return 'Tinggi';
        }
        if ($keluhan === 'Ada' || $radius === 'Kecil (< 500 m)') {
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
        $jenisKey = self::normalizeJenisPelanggaran($overrides['jenis_pelanggaran'] ?? $this->jenis_pelanggaran);
        $keluhan = $overrides['dampak_keluhan_masyarakat'] ?? $this->dampak_keluhan_masyarakat;
        $radius = $overrides['dampak_radius_wilayah'] ?? $this->dampak_radius_wilayah;
        $klasifikasi = $overrides['klasifikasi_pelanggaran'] ?? $this->klasifikasi_pelanggaran;
        $justifikasi = $overrides['expert_justifikasi'] ?? $this->expert_justifikasi;
        $kesimpulan = $overrides['expert_kesimpulan'] ?? $this->expert_kesimpulan;
        $temuan = $overrides['temuan_pelanggaran'] ?? $this->temuan_pelanggaran;

        // Uraian kasus
        if (filled($this->penjelasan_singkat)) {
            $kasus = $this->penjelasan_singkat;
        } else {
            $lokasi = collect([
                $this->alamat_pelanggaran,
                $this->kel_pelanggaran ? 'Kel. ' . $this->kel_pelanggaran : null,
                $this->kec_pelanggaran ? 'Kec. ' . $this->kec_pelanggaran : null,
            ])->filter()->implode(', ');

            $jenisLabel = self::JENIS_MAP[$jenisKey]['label'] ?? $jenisKey;

            $kasus = ($this->pemanfaatan_ruang ?: 'Pemanfaatan ruang')
                . ($lokasi ? " di {$lokasi}" : '')
                . ($this->jenis_pemanfaatan_ruang ? " pada zona peruntukan {$this->jenis_pemanfaatan_ruang} dalam RTR" : '')
                . ($jenisLabel ? ". Ditemukan indikasi: {$jenisLabel}" : '')
                . '.';
        }

        // Foto utama
        $foto = collect([
            $this->foto_existing[0] ?? null,
            $this->foto_pengawasan[0] ?? null,
            $this->foto_tindak_lanjut[0] ?? null,
        ])->filter()->first();

        // Delik Pelanggaran
        $kategoriLabel = self::KATEGORI_MAP[$kategoriKey]['full'] ?? (self::KATEGORI_MAP[$kategoriKey]['label'] ?? $kategoriKey);
        $jenisLabel = self::JENIS_MAP[$jenisKey]['label'] ?? $jenisKey;
        $delikText = collect([$kategoriLabel, $jenisLabel])->filter()->implode(' — ');

        // Dampak
        $dampakParts = collect([
            match ($keluhan) {
                'Ada' => 'Terdapat keluhan masyarakat',
                'Tidak Ada' => 'Tidak ada keluhan masyarakat',
                default => null,
            },
            match ($radius) {
                'Tidak Ada' => 'tidak berdampak pada wilayah sekitar',
                'Kecil (< 500 m)' => 'dampak terbatas pada radius < 500 m',
                'Besar (> 500 m)' => 'dampak meluas pada radius > 500 m',
                default => null,
            },
        ])->filter()->implode(', ');

        $dampakText = $dampakParts ? ucfirst($dampakParts) . '.' : '-';
        if (filled($justifikasi)) {
            $dampakText = ($dampakParts ? ucfirst($dampakParts) . '. ' : '') . $justifikasi;
        }

        // Arah Penanganan
        $arahDefault = self::ARAH_PENANGANAN[$klasifikasi] ?? ($temuan === 'Tidak Ada Pelanggaran' ? 'Tidak diperlukan sanksi administratif (pemanfaatan ruang telah sesuai ketentuan).' : '-');
        $arahText = filled($kesimpulan) ? $kesimpulan : $arahDefault;

        return [
            'temuan' => $temuan,
            'kasus' => $kasus,
            'foto' => $foto,
            'indikasi_text' => self::INDIKASI_MAP[$indikasiKey]['label'] ?? ($indikasiKey ?: '-'),
            'delik_level' => self::DELIK_LEVEL[$jenisKey] ?? null,
            'delik_text' => $delikText ?: '-',
            'delik_sub' => $kategoriLabel ?: null,
            'dampak_level' => self::levelDampak($keluhan, $radius),
            'dampak_text' => $dampakText,
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
}
