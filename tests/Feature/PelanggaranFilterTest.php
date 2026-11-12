<?php

namespace Tests\Feature;

use App\Livewire\Admin\Pelanggaran\PelanggaranIndex;
use App\Models\Pelanggaran;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class PelanggaranFilterTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'role' => 'admin-pelanggaran',
        ]);
    }

    protected function createPelanggaran(array $attributes = []): Pelanggaran
    {
        static $count = 1;
        $num = str_pad($count++, 3, '0', STR_PAD_LEFT);

        return Pelanggaran::create(array_merge([
            'no_pelanggaran' => "{$num}/Wasdal-Taru/2026",
            'tgl_laporan' => '2026-03-01',
            'sumber_informasi_pelanggaran' => 'Hasil Pengawasan dan Monitoring',
            'nama_pelanggar' => "Pelanggar {$num}",
            'nama_pemilik_perusahaan' => "Perusahaan {$num}",
            'alamat_pelanggar' => 'Jl. Pelanggar',
            'kel_pelanggar' => 'Kel Pelanggar',
            'kec_pelanggar' => 'Mataram',
            'kota_pelanggar' => 'Mataram',
            'prov_pelanggar' => 'NTB',
            'alamat_pelanggaran' => 'Jl. Lokasi ' . $num,
            'kel_pelanggaran' => 'Kelurahan ' . $num,
            'kec_pelanggaran' => 'Mataram',
            'koordinat_pelanggaran' => '-8.583, 116.094',
            'jenis_indikasi_pelanggaran' => 'tidak_mematuhi_kkpr',
            'temuan_pelanggaran' => 'Ada Pelanggaran',
            'tindak_lanjut' => 'Surat Peringatan 1',
            'status' => 'On Progress',
        ], $attributes));
    }

    public function test_can_render_pelanggaran_index_with_filters(): void
    {
        $this->actingAs($this->user);

        $this->createPelanggaran([
            'no_pelanggaran' => '001/WASDAL/2026',
            'nama_pelanggar' => 'Budi Santoso',
            'kec_pelanggaran' => 'Cakranegara',
            'klasifikasi_pelanggaran' => 'Pelanggaran Sedang',
        ]);

        Livewire::test(PelanggaranIndex::class)
            ->assertStatus(200)
            ->assertSee('List Data Kasus Pelanggaran')
            ->assertSee('Tahun Laporan')
            ->assertSee('Status Kasus')
            ->assertSee('Temuan Pelanggaran')
            ->assertSee('Kecamatan')
            ->assertSee('Klasifikasi Sanksi')
            ->assertSee('Sumber Informasi')
            ->assertSee('Tindak Lanjut')
            ->assertSee('001/WASDAL/2026')
            ->assertSee('Budi Santoso');
    }

    public function test_filter_by_status(): void
    {
        $this->actingAs($this->user);

        $this->createPelanggaran([
            'nama_pelanggar' => 'Kasus On Progress',
            'status' => 'On Progress',
        ]);

        $this->createPelanggaran([
            'nama_pelanggar' => 'Kasus Selesai',
            'status' => 'Selesai',
        ]);

        Livewire::test(PelanggaranIndex::class)
            ->set('filterStatus', 'Selesai')
            ->assertSee('Kasus Selesai')
            ->assertDontSee('Kasus On Progress')
            ->set('filterStatus', 'On Progress')
            ->assertSee('Kasus On Progress')
            ->assertDontSee('Kasus Selesai');
    }

    public function test_filter_by_temuan(): void
    {
        $this->actingAs($this->user);

        $this->createPelanggaran([
            'nama_pelanggar' => 'Pelanggar Terbukti A',
            'temuan_pelanggaran' => 'Ada Pelanggaran',
            'status' => 'On Progress',
        ]);

        $this->createPelanggaran([
            'nama_pelanggar' => 'Warga Patuh B',
            'temuan_pelanggaran' => 'Tidak Ada Pelanggaran',
            'status' => 'Selesai',
        ]);

        Livewire::test(PelanggaranIndex::class)
            ->set('filterTemuan', 'Tidak Ada Pelanggaran')
            ->assertSee('Warga Patuh B')
            ->assertDontSee('Pelanggar Terbukti A')
            ->set('filterTemuan', 'Ada Pelanggaran')
            ->assertSee('Pelanggar Terbukti A')
            ->assertDontSee('Warga Patuh B');
    }

    public function test_filter_by_kecamatan(): void
    {
        $this->actingAs($this->user);

        $this->createPelanggaran([
            'nama_pelanggar' => 'Kasus Mataram',
            'kec_pelanggaran' => 'Mataram',
        ]);

        $this->createPelanggaran([
            'nama_pelanggar' => 'Kasus Ampenan',
            'kec_pelanggaran' => 'Ampenan',
        ]);

        Livewire::test(PelanggaranIndex::class)
            ->set('filterKecamatan', 'Ampenan')
            ->assertSee('Kasus Ampenan')
            ->assertDontSee('Kasus Mataram');
    }

    public function test_filter_by_year(): void
    {
        $this->actingAs($this->user);

        $this->createPelanggaran([
            'tgl_laporan' => '2025-05-10',
            'nama_pelanggar' => 'Kasus Tahun 2025',
        ]);

        $this->createPelanggaran([
            'tgl_laporan' => '2026-05-10',
            'nama_pelanggar' => 'Kasus Tahun 2026',
        ]);

        Livewire::test(PelanggaranIndex::class)
            ->set('filterYear', '2025')
            ->assertSee('Kasus Tahun 2025')
            ->assertDontSee('Kasus Tahun 2026');
    }

    public function test_filter_by_klasifikasi(): void
    {
        $this->actingAs($this->user);

        $this->createPelanggaran([
            'nama_pelanggar' => 'Pelanggaran Tingkat Tinggi',
            'klasifikasi_pelanggaran' => 'Pelanggaran Tinggi',
        ]);

        $this->createPelanggaran([
            'nama_pelanggar' => 'Pelanggaran Belum Dianalisis',
            'klasifikasi_pelanggaran' => null,
        ]);

        Livewire::test(PelanggaranIndex::class)
            ->set('filterKlasifikasi', 'Pelanggaran Tinggi')
            ->assertSee('Pelanggaran Tingkat Tinggi')
            ->assertDontSee('Pelanggaran Belum Dianalisis')
            ->set('filterKlasifikasi', 'belum_dianalisis')
            ->assertSee('Pelanggaran Belum Dianalisis')
            ->assertDontSee('Pelanggaran Tingkat Tinggi');
    }

    public function test_reset_filters_restores_default_state(): void
    {
        $this->actingAs($this->user);

        $this->createPelanggaran([
            'nama_pelanggar' => 'Kasus Target Spesifik',
            'status' => 'Selesai',
        ]);

        Livewire::test(PelanggaranIndex::class)
            ->set('search', 'Target Spesifik')
            ->set('filterStatus', 'On Progress') // tidak cocok
            ->assertDontSee('Kasus Target Spesifik')
            ->call('resetFilters')
            ->assertSet('search', '')
            ->assertSet('filterStatus', '')
            ->assertSee('Kasus Target Spesifik');
    }

    public function test_filter_by_sumber_informasi(): void
    {
        $this->actingAs($this->user);

        $this->createPelanggaran([
            'nama_pelanggar' => 'Kasus Sumber Masyarakat',
            'sumber_informasi_pelanggaran' => 'Laporan Masyarakat',
        ]);

        $this->createPelanggaran([
            'nama_pelanggar' => 'Kasus Sumber Patroli',
            'sumber_informasi_pelanggaran' => 'Hasil Pengawasan dan Monitoring',
        ]);

        Livewire::test(PelanggaranIndex::class)
            ->set('filterSumber', 'Laporan Masyarakat')
            ->assertSee('Kasus Sumber Masyarakat')
            ->assertDontSee('Kasus Sumber Patroli');
    }

    public function test_filter_by_tindak_lanjut(): void
    {
        $this->actingAs($this->user);

        $this->createPelanggaran([
            'nama_pelanggar' => 'Kasus SP1',
            'tindak_lanjut' => 'Surat Peringatan 1',
        ]);

        $this->createPelanggaran([
            'nama_pelanggar' => 'Kasus Pembongkaran',
            'tindak_lanjut' => 'Pembongkaran',
        ]);

        Livewire::test(PelanggaranIndex::class)
            ->set('filterTindakLanjut', 'Pembongkaran')
            ->assertSee('Kasus Pembongkaran')
            ->assertDontSee('Kasus SP1');
    }

    public function test_filter_by_per_page(): void
    {
        $this->actingAs($this->user);

        for ($i = 1; $i <= 15; $i++) {
            $this->createPelanggaran([
                'nama_pelanggar' => "Pelanggar Iterasi Ke-{$i}",
            ]);
        }

        // Default 10: hanya sampai 10
        Livewire::test(PelanggaranIndex::class)
            ->assertSet('perPage', 10)
            ->assertSee('Pelanggar Iterasi Ke-15')
            ->assertDontSee('Pelanggar Iterasi Ke-5')
            ->set('perPage', 25)
            ->assertSee('Pelanggar Iterasi Ke-15')
            ->assertSee('Pelanggar Iterasi Ke-5');
    }

    public function test_combined_search_and_filters(): void
    {
        $this->actingAs($this->user);

        $this->createPelanggaran([
            'nama_pelanggar' => 'PT Surya Sejahtera',
            'kec_pelanggaran' => 'Mataram',
        ]);

        $this->createPelanggaran([
            'nama_pelanggar' => 'PT Surya Abadi',
            'kec_pelanggaran' => 'Sandubaya',
        ]);

        // Cari "Surya" tapi hanya di kecamatan "Mataram"
        Livewire::test(PelanggaranIndex::class)
            ->set('search', 'Surya')
            ->set('filterKecamatan', 'Mataram')
            ->assertSee('PT Surya Sejahtera')
            ->assertDontSee('PT Surya Abadi');
    }
}
