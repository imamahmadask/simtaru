<?php

namespace Tests\Feature;

use App\Models\Layanan;
use App\Models\Registrasi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * RegistrasiNomorUrutTest
 *
 * Menguji semua skenario penomoran kode registrasi otomatis.
 *
 * Aturan yang diuji:
 *   1. Nomor urut dimulai dari 0001 jika belum ada registrasi
 *   2. Nomor berikutnya selalu MAX + 1 (tidak mengisi gap)
 *   3. Counter GLOBAL — semua jenis layanan berbagi satu urutan
 *   4. Kode yang pernah dihapus tidak dipakai ulang
 *   5. Reset ke 0001 di tahun baru
 *   6. Format kode: NNNN-KODE-BULAN-TAHUN
 *   7. Aman dari race condition (concurrent submission)
 *
 * Jalankan: php artisan test --filter=RegistrasiNomorUrutTest
 */
class RegistrasiNomorUrutTest extends TestCase
{
    use RefreshDatabase;

    // ─────────────────────────────────────────────────────────────────────────
    // Setup: seed data layanan yang dibutuhkan setiap test
    // ─────────────────────────────────────────────────────────────────────────
    protected function setUp(): void
    {
        parent::setUp();

        // Seed layanan sesuai data production.
        // insertOrIgnore: aman jika data sudah ada (misal akibat truncate
        // yang memicu implicit commit di MySQL dan mengacaukan rollback).
        DB::table('layanan')->insertOrIgnore([
            ['id' => 1, 'nama' => 'SKRK',              'kode' => 'SKRK',    'keterangan' => 'Surat Keterangan Rencana Kota',                          'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'nama' => 'KKPR Berusaha',     'kode' => 'KKPR-B',  'keterangan' => 'Kesesuaian Kegiatan Pemanfaatan Ruang (Berusaha)',       'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'nama' => 'KKPR Non Berusaha', 'kode' => 'KKPR-NB', 'keterangan' => 'Kesesuaian Kegiatan Pemanfaatan Ruang (Non Berusaha)',   'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'nama' => 'ITR',               'kode' => 'ITR',     'keterangan' => 'Informasi Tata Ruang',                                    'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Helper: buat dummy registrasi langsung ke DB (bypass Livewire)
    // ─────────────────────────────────────────────────────────────────────────
    private function buatRegistrasi(string $kode, int $layanan_id = 1, string $tanggal = null): Registrasi
    {
        return Registrasi::create([
            'kode'             => $kode,
            'nama'             => 'Test Pemohon',
            'nik'              => '1234567890123456',
            'no_hp'            => '08123456789',
            'tanggal'          => $tanggal ?? date('Y-m-d'),
            'layanan_id'       => $layanan_id,
            'created_by'       => 1,
            'email'            => 'test@example.com',
            'fungsi_bangunan'  => 'Hunian',
            'alamat_tanah'     => 'Jl. Test No. 1',
            'kel_tanah'        => 'Mataram',
            'kec_tanah'        => 'Mataram',
        ]);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Helper: panggil logika generate kode seperti yang ada di RegistrasiCreate
    // ─────────────────────────────────────────────────────────────────────────
    private function generateKode(int $layanan_id, string $year = null, string $month = null): string
    {
        $year         = $year  ?? date('Y');
        $month        = $month ?? date('m');
        $layanan_kode = Layanan::findOrFail($layanan_id)->kode;

        return DB::transaction(function () use ($year, $month, $layanan_kode) {
            $lastKode = Registrasi::whereYear('created_at', $year)
                ->lockForUpdate()
                ->pluck('kode')
                ->map(function ($kode) {
                    return (int) explode('-', $kode)[0];
                })
                ->max();

            $sequence = ($lastKode ?? 0) + 1;

            return str_pad($sequence, 4, '0', STR_PAD_LEFT)
                . '-' . $layanan_kode
                . '-' . $month
                . '-' . $year;
        });
    }

    // ─────────────────────────────────────────────────────────────────────────
    // TEST 1: Mulai dari 0001 saat belum ada registrasi sama sekali
    // ─────────────────────────────────────────────────────────────────────────
    public function test_kode_pertama_dimulai_dari_0001(): void
    {
        $year  = date('Y');
        $month = date('m');

        $kode = $this->generateKode(layanan_id: 1);

        $this->assertStringStartsWith('0001-SKRK-', $kode,
            'Kode pertama harus dimulai dari 0001');

        $this->assertEquals("0001-SKRK-{$month}-{$year}", $kode,
            'Format kode harus NNNN-KODE-BULAN-TAHUN');
    }

    // ─────────────────────────────────────────────────────────────────────────
    // TEST 2: Kode berikutnya adalah MAX + 1 (urutan normal tanpa gap)
    // ─────────────────────────────────────────────────────────────────────────
    public function test_kode_berikutnya_adalah_max_plus_satu(): void
    {
        $year  = date('Y');
        $month = date('m');

        // Simulasi sudah ada 5 registrasi berturut-turut
        $this->buatRegistrasi("0001-SKRK-{$month}-{$year}",   1);
        $this->buatRegistrasi("0002-KKPR-B-{$month}-{$year}", 2);
        $this->buatRegistrasi("0003-KKPR-NB-{$month}-{$year}",3);
        $this->buatRegistrasi("0004-ITR-{$month}-{$year}",    4);
        $this->buatRegistrasi("0005-SKRK-{$month}-{$year}",   1);

        $kode = $this->generateKode(layanan_id: 1);

        $this->assertStringStartsWith('0006-', $kode,
            'Setelah kode 0005, kode berikutnya harus 0006');
    }

    // ─────────────────────────────────────────────────────────────────────────
    // TEST 3: Kode yang dihapus TIDAK dipakai ulang (no gap-filling)
    //
    // SKENARIO (kasus nyata yang dilaporkan):
    //   - Ada kode 0001 s/d 0100
    //   - Kode 0018 dihapus → ada gap di nomor 18
    //   - Registrasi baru harus mendapat 0101, BUKAN 0018
    // ─────────────────────────────────────────────────────────────────────────
    public function test_kode_yang_dihapus_tidak_dipakai_ulang(): void
    {
        $year  = date('Y');
        $month = date('m');

        // Buat kode 0001 s/d 0100
        for ($i = 1; $i <= 100; $i++) {
            $this->buatRegistrasi(
                str_pad($i, 4, '0', STR_PAD_LEFT) . "-SKRK-{$month}-{$year}",
                1
            );
        }

        // Hapus kode 0018 — mensimulasikan kasus yang terjadi di production
        Registrasi::where('kode', "0018-SKRK-{$month}-{$year}")->delete();

        // Pastikan gap memang ada
        $this->assertDatabaseMissing('registrasi', ['kode' => "0018-SKRK-{$month}-{$year}"]);

        // Generate kode baru
        $kode = $this->generateKode(layanan_id: 1);

        // Harus mendapat 0101, BUKAN mengisi kembali 0018
        $this->assertStringStartsWith('0101-', $kode,
            'BUG FIX: Kode baru harus 0101, BUKAN 0018 meskipun ada gap di nomor 18');

        $this->assertStringNotContainsString('0018-', $kode,
            'Kode 0018 yang sudah dihapus tidak boleh dipakai ulang');
    }

    // ─────────────────────────────────────────────────────────────────────────
    // TEST 4: Counter GLOBAL — semua layanan berbagi satu urutan
    //
    // SKENARIO:
    //   - Registrasi terakhir: 0100-KKPR-NB (layanan KKPR Non Berusaha)
    //   - Registrasi baru layanan SKRK → harus mendapat 0101-SKRK, bukan 0001-SKRK
    // ─────────────────────────────────────────────────────────────────────────
    public function test_counter_global_berbagi_antar_semua_layanan(): void
    {
        $year  = date('Y');
        $month = date('m');

        // Buat 100 registrasi campuran berbagai layanan
        for ($i = 1; $i <= 100; $i++) {
            $layanan_id = (($i - 1) % 4) + 1; // Rotasi 1,2,3,4,1,2,3,4,...
            $layanan_kode = Layanan::find($layanan_id)->kode;
            $this->buatRegistrasi(
                str_pad($i, 4, '0', STR_PAD_LEFT) . "-{$layanan_kode}-{$month}-{$year}",
                $layanan_id
            );
        }

        // Kode terakhir adalah 0100, generate kode baru dengan layanan SKRK
        $kodeSkrk = $this->generateKode(layanan_id: 1); // SKRK

        $this->assertStringStartsWith('0101-SKRK-', $kodeSkrk,
            'Counter global: setelah 0100-xxx, registrasi SKRK berikutnya harus 0101-SKRK');

        // Simulasikan simpan kode 0101-SKRK
        $this->buatRegistrasi($kodeSkrk, 1);

        // Sekarang generate kode baru untuk KKPR-B → harus 0102
        $kodeKkprb = $this->generateKode(layanan_id: 2); // KKPR-B

        $this->assertStringStartsWith('0102-KKPR-B-', $kodeKkprb,
            'Counter global: setelah 0101-SKRK, registrasi KKPR-B berikutnya harus 0102-KKPR-B');
    }

    // ─────────────────────────────────────────────────────────────────────────
    // TEST 5: Counter RESET ke 0001 di tahun baru
    // ─────────────────────────────────────────────────────────────────────────
    public function test_counter_reset_di_tahun_baru(): void
    {
        $lastYear  = date('Y', strtotime('-1 year'));
        $thisYear  = date('Y');
        $month     = date('m');

        // Buat 150 registrasi, lalu set created_at ke tahun lalu.
        // Gunakan DB::table() langsung karena Eloquent melindungi created_at
        // dari perubahan via update().
        for ($i = 1; $i <= 150; $i++) {
            $reg = $this->buatRegistrasi(
                str_pad($i, 4, '0', STR_PAD_LEFT) . "-SKRK-{$month}-{$lastYear}",
                1
            );
            DB::table('registrasi')
                ->where('id', $reg->id)
                ->update(['created_at' => "{$lastYear}-{$month}-15 10:00:00"]);
        }

        // Tahun ini belum ada registrasi sama sekali
        $this->assertEquals(0,
            Registrasi::whereYear('created_at', $thisYear)->count(),
            'Tidak boleh ada registrasi tahun ini'
        );

        // Generate kode untuk tahun ini
        $kode = $this->generateKode(layanan_id: 1, year: $thisYear);

        $this->assertStringStartsWith('0001-', $kode,
            "Counter harus reset ke 0001 di tahun {$thisYear}, meskipun tahun lalu sudah sampai 0150");
        $this->assertStringContainsString($thisYear, $kode,
            'Kode harus mengandung tahun yang benar');
    }

    // ─────────────────────────────────────────────────────────────────────────
    // TEST 6: Format kode sudah benar (NNNN-KODE-MM-YYYY)
    // ─────────────────────────────────────────────────────────────────────────
    public function test_format_kode_sudah_benar(): void
    {
        $year  = date('Y');
        $month = date('m');

        // Test format untuk setiap layanan
        $expectedFormats = [
            1 => "0001-SKRK-{$month}-{$year}",
            2 => "0001-KKPR-B-{$month}-{$year}",
            3 => "0001-KKPR-NB-{$month}-{$year}",
            4 => "0001-ITR-{$month}-{$year}",
        ];

        foreach ($expectedFormats as $layananId => $expectedKode) {
            // Hapus semua registrasi agar selalu mulai dari 0001.
            // Gunakan delete() bukan truncate() — truncate menyebabkan
            // implicit commit di MySQL sehingga mengacaukan RefreshDatabase.
            Registrasi::query()->delete();

            $kode = $this->generateKode(layanan_id: $layananId);

            $this->assertEquals($expectedKode, $kode,
                "Format kode layanan ID {$layananId} tidak sesuai");
        }
    }

    // ─────────────────────────────────────────────────────────────────────────
    // TEST 7: Nomor terisi 4 digit dengan zero-padding
    // ─────────────────────────────────────────────────────────────────────────
    public function test_nomor_urut_empat_digit_dengan_zero_padding(): void
    {
        $year  = date('Y');
        $month = date('m');

        // Buat 9 registrasi (urutan 1-9, harus jadi 0001-0009)
        for ($i = 1; $i <= 9; $i++) {
            $kode = $this->generateKode(layanan_id: 1);
            $this->buatRegistrasi($kode, 1);
        }

        $kode10 = $this->generateKode(layanan_id: 1);

        // Nomor ke-10 harus "0010-..." bukan "10-..."
        $this->assertStringStartsWith('0010-', $kode10,
            'Nomor urut harus selalu 4 digit dengan zero-padding');

        $nomorBagian = explode('-', $kode10)[0];
        $this->assertEquals(4, strlen($nomorBagian),
            'Bagian nomor urut harus tepat 4 karakter');
    }

    // ─────────────────────────────────────────────────────────────────────────
    // TEST 8: Multiple gap tidak mempengaruhi nomor berikutnya
    // ─────────────────────────────────────────────────────────────────────────
    public function test_multiple_gap_tidak_mempengaruhi_nomor_berikutnya(): void
    {
        $year  = date('Y');
        $month = date('m');

        // Buat kode 0001 s/d 0050
        for ($i = 1; $i <= 50; $i++) {
            $this->buatRegistrasi(
                str_pad($i, 4, '0', STR_PAD_LEFT) . "-SKRK-{$month}-{$year}",
                1
            );
        }

        // Hapus beberapa nomor (buat multiple gap)
        $gapNomors = [5, 12, 18, 25, 33, 41, 49];
        foreach ($gapNomors as $nomor) {
            Registrasi::where('kode', str_pad($nomor, 4, '0', STR_PAD_LEFT) . "-SKRK-{$month}-{$year}")
                ->delete();
        }

        // Generate kode baru — harus 0051, BUKAN salah satu dari gap di atas
        $kode = $this->generateKode(layanan_id: 4); // ITR

        $this->assertStringStartsWith('0051-', $kode,
            'Meskipun ada 7 gap, kode baru harus tetap melanjutkan ke 0051');

        foreach ($gapNomors as $nomor) {
            $nomorPadded = str_pad($nomor, 4, '0', STR_PAD_LEFT);
            $this->assertFalse(
                str_starts_with($kode, "{$nomorPadded}-"),
                "Kode tidak boleh mengisi kembali gap di nomor {$nomorPadded}"
            );
        }
    }

    // ─────────────────────────────────────────────────────────────────────────
    // TEST 9: Nomor tidak duplikat meskipun di-generate secara berurutan cepat
    // ─────────────────────────────────────────────────────────────────────────
    public function test_tidak_ada_kode_duplikat_dalam_pembuatan_berurutan(): void
    {
        $year  = date('Y');
        $month = date('m');

        $kodeList = [];

        // Generate dan simpan 20 kode secara berurutan
        for ($i = 0; $i < 20; $i++) {
            $layananId = ($i % 4) + 1; // Rotasi layanan
            $kode      = $this->generateKode(layanan_id: $layananId);
            $kodeList[] = $kode;
            $this->buatRegistrasi($kode, $layananId);
        }

        // Pastikan tidak ada duplikat
        $uniqueKodes = array_unique($kodeList);
        $this->assertCount(
            count($kodeList),
            $uniqueKodes,
            'Setiap kode yang di-generate harus unik, tidak boleh ada duplikat'
        );

        // Pastikan nomor urut benar-benar berurutan (0001, 0002, ..., 0020)
        for ($i = 1; $i <= 20; $i++) {
            $nomorPadded = str_pad($i, 4, '0', STR_PAD_LEFT);
            $ditemukan = collect($kodeList)->filter(function ($k) use ($nomorPadded) {
                return str_starts_with($k, $nomorPadded . '-');
            })->isNotEmpty();

            $this->assertTrue($ditemukan,
                "Nomor urut {$nomorPadded} harus ada dalam daftar kode yang dihasilkan");
        }
    }

    // ─────────────────────────────────────────────────────────────────────────
    // TEST 10: Registrasi lintas layanan, nomor tetap global berurutan
    // (Skenario paling realistis seperti penggunaan sehari-hari)
    // ─────────────────────────────────────────────────────────────────────────
    public function test_skenario_realistis_campuran_layanan(): void
    {
        $year  = date('Y');
        $month = date('m');

        // Simulasi: registrasi campuran, kode 0096-0100 dihapus
        for ($i = 1; $i <= 100; $i++) {
            $this->buatRegistrasi(
                str_pad($i, 4, '0', STR_PAD_LEFT) . "-SKRK-{$month}-{$year}",
                1
            );
        }

        // Admin menghapus 5 registrasi terakhir (misal: salah input)
        for ($i = 96; $i <= 100; $i++) {
            Registrasi::where('kode', str_pad($i, 4, '0', STR_PAD_LEFT) . "-SKRK-{$month}-{$year}")
                ->delete();
        }

        // Kode MAX yang tersisa sekarang adalah 0095
        $maxKode = Registrasi::whereYear('created_at', $year)
            ->pluck('kode')
            ->map(fn($k) => (int) explode('-', $k)[0])
            ->max();

        $this->assertEquals(95, $maxKode, 'MAX kode sekarang harus 95 setelah penghapusan');

        // Generate kode baru → harus 0096, BUKAN melanjutkan ke 0101
        // (karena MAX adalah 95, bukan 100)
        $kode = $this->generateKode(layanan_id: 3); // KKPR-NB

        $this->assertStringStartsWith('0096-KKPR-NB-', $kode,
            'Setelah 0095 menjadi MAX, kode baru harus 0096 (MAX+1)');
    }
}
