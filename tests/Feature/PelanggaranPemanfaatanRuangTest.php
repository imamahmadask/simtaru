<?php

namespace Tests\Feature;

use App\Livewire\Admin\Pelanggaran\Analis\PelanggaranAnalisDetail;
use App\Livewire\Admin\Pelanggaran\PelanggaranCreate;
use App\Livewire\Admin\Pelanggaran\PelanggaranEdit;
use App\Livewire\Admin\Pelanggaran\PelanggaranIndex;
use App\Livewire\Guest\Maps\PetaPelanggaran;
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

    public function test_can_create_pelanggaran_with_dokumen_penilaian_kkpr_and_sanitized_folder(): void
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'role' => 'admin-pelanggaran',
        ]);
        $this->actingAs($user);

        $fakeDoc = UploadedFile::fake()->create('dokumen_penilaian.pdf', 100, 'application/pdf');
        $fakeFotoPengawasan = UploadedFile::fake()->image('pengawasan.jpg');
        $fakeFotoExisting = UploadedFile::fake()->image('existing.jpg');

        Livewire::test(PelanggaranCreate::class)
            ->set('tgl_laporan', '2026-11-11')
            ->set('sumber_informasi_pelanggaran', 'Hasil Penilaian KKPR atau SKRK')
            ->set('no_kkpr_skrk', 'KKPR-12345')
            ->set('no_ba_sk_penilaian_kkpr', 'BA-999')
            ->set('dokumen_penilaian_kkpr', $fakeDoc)
            ->set('nama_pelanggar', 'Pelanggar Dokumen Test')
            ->set('alamat_pelanggar', 'Jl. Pelanggar')
            ->set('kel_pelanggar', 'Kel. Test')
            ->set('kec_pelanggar', 'Kec. Test')
            ->set('kota_pelanggar', 'Mataram')
            ->set('prov_pelanggar', 'NTB')
            ->set('alamat_pelanggaran', 'Jl. Kasus')
            ->set('kel_pelanggaran', 'Kel. Kasus')
            ->set('kec_pelanggaran', 'Mataram')
            ->set('koordinat_pelanggaran', '-8.583, 116.094')
            ->set('gmaps_pelanggaran', 'https://maps.google.com/?q=-8.583,116.094')
            ->set('jenis_indikasi_pelanggaran', 'Tidak Memiliki Persetujuan Bangunan Gedung (PBG)')
            ->set('foto_pengawasan', [$fakeFotoPengawasan])
            ->set('foto_existing', [$fakeFotoExisting])
            ->call('store')
            ->assertHasNoErrors()
            ->assertRedirect();

        $pelanggaran = Pelanggaran::where('nama_pelanggar', 'Pelanggar Dokumen Test')->first();
        $this->assertNotNull($pelanggaran);
        $this->assertNotNull($pelanggaran->dokumen_penilaian_kkpr);

        $safeFolder = str_replace('/', '-', $pelanggaran->no_pelanggaran);
        $this->assertStringContainsString("pelanggaran/{$safeFolder}/dokumen_penilaian_kkpr", $pelanggaran->dokumen_penilaian_kkpr);
        Storage::disk('public')->assertExists($pelanggaran->dokumen_penilaian_kkpr);
    }

    public function test_remove_image_supports_both_types(): void
    {
        Storage::fake('public');

        $user = User::factory()->create(['role' => 'admin-pelanggaran']);
        $this->actingAs($user);

        $img1 = UploadedFile::fake()->image('p1.jpg');
        $img2 = UploadedFile::fake()->image('p2.jpg');
        $e1 = UploadedFile::fake()->image('e1.jpg');
        $e2 = UploadedFile::fake()->image('e2.jpg');

        $component = Livewire::test(PelanggaranCreate::class)
            ->set('foto_pengawasan', [$img1, $img2])
            ->set('foto_existing', [$e1, $e2])
            ->call('removeImage', 0, 'foto_pengawasan')
            ->call('removeImage', 1, 'foto_existing');

        $this->assertCount(1, $component->get('foto_pengawasan'));
        $this->assertCount(1, $component->get('foto_existing'));
    }

    public function test_generate_no_pelanggaran_handles_gaps_without_duplicate(): void
    {
        $year = date('Y');

        Pelanggaran::create([
            'no_pelanggaran' => "005/Wasdal-Taru/XI/{$year}",
            'tgl_laporan' => date('Y-m-d'),
            'sumber_informasi_pelanggaran' => 'Laporan Masyarakat',
            'nama_pelanggar' => 'P1',
            'alamat_pelanggar' => 'A1',
            'kel_pelanggar' => 'K1',
            'kec_pelanggar' => 'Kec1',
            'kota_pelanggar' => 'Mataram',
            'prov_pelanggar' => 'NTB',
            'alamat_pelanggaran' => 'Alamat Kasus',
            'kel_pelanggaran' => 'Kel Kasus',
            'kec_pelanggaran' => 'Mataram',
            'koordinat_pelanggaran' => '-8.58, 116.09',
            'jenis_indikasi_pelanggaran' => 'Tidak Memiliki KKPR atau SKRK',
            'status' => 'On Progress',
        ]);

        $user = User::factory()->create(['role' => 'admin-pelanggaran']);
        $this->actingAs($user);

        $component = new PelanggaranCreate();
        $reflection = new \ReflectionClass($component);
        $method = $reflection->getMethod('generateNoPelanggaran');
        $method->setAccessible(true);
        $nextNo = $method->invoke($component);

        $this->assertStringStartsWith('006/Wasdal-Taru/', $nextNo);
    }

    public function test_peta_pelanggaran_excludes_tidak_ada_pelanggaran(): void
    {
        Pelanggaran::create([
            'no_pelanggaran' => '001/Wasdal-Taru/I/2026',
            'tgl_laporan' => '2026-01-10',
            'sumber_informasi_pelanggaran' => 'Hasil Pengawasan dan Monitoring',
            'nama_pelanggar' => 'Kasus Pelanggaran Nyata',
            'alamat_pelanggar' => 'A',
            'kel_pelanggar' => 'K',
            'kec_pelanggar' => 'Mataram',
            'kota_pelanggar' => 'Mataram',
            'prov_pelanggar' => 'NTB',
            'alamat_pelanggaran' => 'Alamat 1',
            'kel_pelanggaran' => 'Kel 1',
            'kec_pelanggaran' => 'Mataram',
            'koordinat_pelanggaran' => '-8.581, 116.091',
            'jenis_indikasi_pelanggaran' => 'Tidak Memiliki KKPR atau SKRK',
            'temuan_pelanggaran' => 'Ada Pelanggaran',
            'status' => 'On Progress',
        ]);

        Pelanggaran::create([
            'no_pelanggaran' => '002/Wasdal-Taru/I/2026',
            'tgl_laporan' => '2026-01-11',
            'sumber_informasi_pelanggaran' => 'Hasil Pengawasan dan Monitoring',
            'nama_pelanggar' => 'Bukan Pelanggaran',
            'alamat_pelanggar' => 'B',
            'kel_pelanggar' => 'K',
            'kec_pelanggar' => 'Mataram',
            'kota_pelanggar' => 'Mataram',
            'prov_pelanggar' => 'NTB',
            'alamat_pelanggaran' => 'Alamat 2',
            'kel_pelanggaran' => 'Kel 2',
            'kec_pelanggaran' => 'Mataram',
            'koordinat_pelanggaran' => '-8.582, 116.092',
            'jenis_indikasi_pelanggaran' => 'Tidak Memiliki KKPR atau SKRK',
            'temuan_pelanggaran' => 'Tidak Ada Pelanggaran',
            'status' => 'Selesai',
        ]);

        $test = Livewire::test(PetaPelanggaran::class);
        $locations = $test->get('locations');

        $ids = array_column($locations, 'no_pelanggaran');
        $this->assertContains('001/Wasdal-Taru/I/2026', $ids);
        $this->assertNotContains('002/Wasdal-Taru/I/2026', $ids);
    }

    public function test_delete_pelanggaran_cleans_up_all_document_files_and_folders(): void
    {
        Storage::fake('public');

        $user = User::factory()->create(['role' => 'superadmin']);
        $this->actingAs($user);

        $fakeSp1Path = 'pelanggaran/009-Wasdal-Taru-I-2026/dokumen/SP1_test.pdf';
        $fakeFotoPath = 'pelanggaran/009-Wasdal-Taru-I-2026/foto_pengawasan/p1.jpg';
        Storage::disk('public')->put($fakeSp1Path, 'dummy content');
        Storage::disk('public')->put($fakeFotoPath, 'dummy content');

        $pelanggaran = Pelanggaran::create([
            'no_pelanggaran' => '009/Wasdal-Taru/I/2026',
            'tgl_laporan' => '2026-01-10',
            'sumber_informasi_pelanggaran' => 'Hasil Pengawasan dan Monitoring',
            'nama_pelanggar' => 'Test Delete',
            'alamat_pelanggar' => 'A',
            'kel_pelanggar' => 'K',
            'kec_pelanggar' => 'Mataram',
            'kota_pelanggar' => 'Mataram',
            'prov_pelanggar' => 'NTB',
            'alamat_pelanggaran' => 'Alamat 1',
            'kel_pelanggaran' => 'Kel 1',
            'kec_pelanggaran' => 'Mataram',
            'koordinat_pelanggaran' => '-8.581, 116.091',
            'jenis_indikasi_pelanggaran' => 'Tidak Memiliki KKPR atau SKRK',
            'foto_pengawasan' => [$fakeFotoPath],
            'file_sp1' => $fakeSp1Path,
            'status' => 'On Progress',
        ]);

        Storage::disk('public')->assertExists($fakeSp1Path);
        Storage::disk('public')->assertExists($fakeFotoPath);

        Livewire::test(PelanggaranIndex::class)
            ->call('deletePelanggaran', $pelanggaran->id)
            ->assertRedirect(route('pelanggaran.index'));

        $this->assertDatabaseMissing('pelanggarans', ['id' => $pelanggaran->id]);
        Storage::disk('public')->assertMissing($fakeSp1Path);
        Storage::disk('public')->assertMissing($fakeFotoPath);
    }
}
