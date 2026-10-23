<?php

namespace Tests\Feature;

use App\Livewire\Admin\Pelanggaran\Analis\PelanggaranAnalisDetail;
use App\Livewire\Admin\Pelanggaran\PelanggaranCreate;
use App\Livewire\Admin\Pelanggaran\PelanggaranEdit;
use App\Models\Pelanggaran;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class PelanggaranPemanfaatanRuangTest extends TestCase
{
    use \Illuminate\Foundation\Testing\RefreshDatabase;

    public function test_can_create_pelanggaran_with_pemanfaatan_ruang(): void
    {
        $user = User::factory()->create([
            'role' => 'admin',
        ]);

        $this->actingAs($user);

        Livewire::test(PelanggaranCreate::class)
            ->set('tgl_laporan', '2026-10-23')
            ->set('sumber_informasi_pelanggaran', 'Hasil Pengawasan dan Monitoring')
            ->set('tanggal_pengawasan', '2026-10-23')
            ->set('nama_pelanggar', 'Test Pemilik')
            ->set('alamat_pelanggar', 'Jl. Test No. 1')
            ->set('kel_pelanggar', 'Test Kelurahan')
            ->set('kec_pelanggar', 'Test Kecamatan')
            ->set('kota_pelanggar', 'Mataram')
            ->set('prov_pelanggar', 'NTB')
            ->set('alamat_pelanggaran', 'Jl. Lokasi Test No. 2')
            ->set('kel_pelanggaran', 'Mataram Barat')
            ->set('kec_pelanggaran', 'Mataram')
            ->set('koordinat_pelanggaran', '-8.583, 116.094')
            ->set('gmaps_pelanggaran', 'https://maps.google.com/?q=-8.583,116.094')
            ->set('jenis_indikasi_pelanggaran', 'Tidak Memiliki KKPR atau SKRK')
            ->set('jenis_pemanfaatan_ruang', 'Zona Perumahan Kepadatan Tinggi')
            ->set('pemanfaatan_ruang', 'Rumah Tinggal dan Toko')
            ->call('store')
            ->assertHasNoErrors()
            ->assertRedirect();

        $pelanggaran = Pelanggaran::where('nama_pelanggar', 'Test Pemilik')->latest()->first();
        $this->assertNotNull($pelanggaran);
        $this->assertEquals('Rumah Tinggal dan Toko', $pelanggaran->pemanfaatan_ruang);

        // Test Edit
        Livewire::test(PelanggaranEdit::class, ['id' => $pelanggaran->id])
            ->assertSet('pemanfaatan_ruang', 'Rumah Tinggal dan Toko')
            ->set('pemanfaatan_ruang', 'Rumah Tinggal dan Kafe')
            ->call('update')
            ->assertHasNoErrors()
            ->assertRedirect();

        $pelanggaran->refresh();
        $this->assertEquals('Rumah Tinggal dan Kafe', $pelanggaran->pemanfaatan_ruang);

        // Clean up
        $pelanggaran->delete();
    }

    public function test_analisa_tidak_ada_pelanggaran_nullable_and_with_uploads(): void
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'role' => 'admin',
        ]);
        $this->actingAs($user);

        $pelanggaran = Pelanggaran::create([
            'no_pelanggaran' => '001/Wasdal-Taru/X/2026',
            'tgl_laporan' => '2026-10-23',
            'sumber_informasi_pelanggaran' => 'Laporan Masyarakat',
            'nama_pelanggar' => 'Pemilik Lahan Test',
            'alamat_pelanggar' => 'Jl. Test',
            'kel_pelanggar' => 'Kel Test',
            'kec_pelanggar' => 'Kec Test',
            'kota_pelanggar' => 'Mataram',
            'prov_pelanggar' => 'NTB',
            'alamat_pelanggaran' => 'Jl. Lokasi',
            'kel_pelanggaran' => 'Kel Lokasi',
            'kec_pelanggaran' => 'Mataram',
            'koordinat_pelanggaran' => '-8.58, 116.09',
            'jenis_indikasi_pelanggaran' => 'Tidak Memiliki KKPR atau SKRK',
            'status' => 'On Progress',
        ]);

        // 1. Test simpan "Tidak Ada Pelanggaran" tanpa upload berkas (boleh kosong / nullable)
        Livewire::test(PelanggaranAnalisDetail::class, ['id' => $pelanggaran->id])
            ->set('temuan_pelanggaran', 'Tidak Ada Pelanggaran')
            ->call('storeAnalisa')
            ->assertHasNoErrors();

        $pelanggaran->refresh();
        $this->assertEquals('Tidak Ada Pelanggaran', $pelanggaran->temuan_pelanggaran);
        $this->assertNull($pelanggaran->file_kkpr_skrk);
        $this->assertNull($pelanggaran->file_pbg_imb);
        $this->assertNull($pelanggaran->file_nib_kbli);

        // 2. Test simpan "Tidak Ada Pelanggaran" dengan 3 berkas
        $fileKkpr = UploadedFile::fake()->create('kkpr.pdf', 100, 'application/pdf');
        $filePbg = UploadedFile::fake()->create('pbg.pdf', 100, 'application/pdf');
        $fileNib = UploadedFile::fake()->create('nib.pdf', 100, 'application/pdf');

        Livewire::test(PelanggaranAnalisDetail::class, ['id' => $pelanggaran->id])
            ->set('temuan_pelanggaran', 'Tidak Ada Pelanggaran')
            ->set('upload_kkpr_skrk', $fileKkpr)
            ->set('upload_pbg_imb', $filePbg)
            ->set('upload_nib_kbli', $fileNib)
            ->call('storeAnalisa')
            ->assertHasNoErrors();

        $pelanggaran->refresh();
        $this->assertNotNull($pelanggaran->file_kkpr_skrk);
        $this->assertNotNull($pelanggaran->file_pbg_imb);
        $this->assertNotNull($pelanggaran->file_nib_kbli);

        Storage::disk('public')->assertExists($pelanggaran->file_kkpr_skrk);
        Storage::disk('public')->assertExists($pelanggaran->file_pbg_imb);
        Storage::disk('public')->assertExists($pelanggaran->file_nib_kbli);
    }
}
