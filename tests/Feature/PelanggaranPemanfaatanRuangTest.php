<?php

namespace Tests\Feature;

use App\Livewire\Admin\Pelanggaran\Analis\PelanggaranAnalisDetail;
use App\Livewire\Admin\Pelanggaran\Analis\PelanggaranAnalisForm;
use App\Livewire\Admin\Pelanggaran\PelanggaranCreate;
use App\Livewire\Admin\Pelanggaran\PelanggaranDetail;
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
            ->set('nama_pemilik_perusahaan', 'PT Ruang Indah')
            ->set('alamat_pelanggaran', 'Jl. Lokasi Test No. 2')
            ->set('kel_pelanggaran', 'Mataram Barat')
            ->set('kec_pelanggaran', 'Mataram')
            ->set('koordinat_pelanggaran', '-8.583, 116.094')
            ->set('gmaps_pelanggaran', 'https://maps.google.com/?q=-8.583,116.094')
            ->set('jenis_pemanfaatan_ruang', 'Zona Perumahan Kepadatan Tinggi')
            ->set('pemanfaatan_ruang', 'Rumah Tinggal dan Toko')
            ->call('store')
            ->assertHasNoErrors()
            ->assertRedirect();

        $pelanggaran = Pelanggaran::where('nama_pelanggar', 'Test Pemilik')->latest()->first();
        $this->assertNotNull($pelanggaran);
        $this->assertEquals('PT Ruang Indah', $pelanggaran->nama_pemilik_perusahaan);
        $this->assertEquals('Rumah Tinggal dan Toko', $pelanggaran->pemanfaatan_ruang);

        // Test Edit
        Livewire::test(PelanggaranEdit::class, ['id' => $pelanggaran->id])
            ->assertSet('pemanfaatan_ruang', 'Rumah Tinggal dan Toko')
            ->assertSet('nama_pemilik_perusahaan', 'PT Ruang Indah')
            ->set('nama_pemilik_perusahaan', 'PT Ruang Maju')
            ->set('pemanfaatan_ruang', 'Rumah Tinggal dan Kafe')
            ->call('update')
            ->assertHasNoErrors()
            ->assertRedirect();

        $pelanggaran->refresh();
        $this->assertEquals('PT Ruang Maju', $pelanggaran->nama_pemilik_perusahaan);
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

    public function test_analisa_ada_pelanggaran_dengan_alur_sanksi_dan_expert_judgment(): void
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'name' => 'Dr. Analis Tata Ruang',
            'role' => 'admin-pelanggaran',
        ]);
        $this->actingAs($user);

        $pelanggaran = Pelanggaran::create([
            'no_pelanggaran' => '077/Wasdal-Taru/XI/2026',
            'tgl_laporan' => '2026-11-11',
            'sumber_informasi_pelanggaran' => 'Hasil Pengawasan dan Monitoring',
            'nama_pelanggar' => 'PT Pengembang Maju',
            'nama_pemilik_perusahaan' => 'Budi Sudarsono',
            'alamat_pelanggaran' => 'Jl. Pariwisata No. 8',
            'kel_pelanggaran' => 'Ampenan',
            'kec_pelanggaran' => 'Ampenan',
            'koordinat_pelanggaran' => '-8.58, 116.08',
            'status' => 'On Progress',
        ]);

        $fakeDoc1 = UploadedFile::fake()->create('kajian_lingkungan.pdf', 200, 'application/pdf');
        $fakeDoc2 = UploadedFile::fake()->create('foto_lapangan.jpg', 200, 'image/jpeg');
        $fakeSp1 = UploadedFile::fake()->create('sp1_signed.pdf', 150, 'application/pdf');
        $fakePembongkaran = UploadedFile::fake()->create('sk_pembongkaran.pdf', 150, 'application/pdf');

        $component = Livewire::test(PelanggaranAnalisDetail::class, ['id' => $pelanggaran->id])
            ->set('temuan_pelanggaran', 'Ada Pelanggaran')
            ->set('jenis_indikasi_pelanggaran', 'Tidak Mematuhi Ketentuan Pemanfaatan Ruang dalam Rencana Tata Ruang')
            ->set('kategori_pelanggaran', 'Pemanfaatan Ruang yang tidak Memenuhi ketentuan dalam KKPR')
            ->set('jenis_pelanggaran', 'Pelanggaran Sempadan (GSB, GSS, Sempadan Sungai, dll)')
            ->set('dampak_keluhan_masyarakat', 'Ada')
            ->set('dampak_radius_wilayah', 'Besar (> 500 m)')
            ->set('expert_justifikasi', 'Bangunan melanggar sempadan sungai sejauh 15 meter dan berpotensi banjir.')
            ->set('expert_kesimpulan', 'Perlu dilakukan penindakan tegas penghentian dan pembongkaran.')
            ->set('expert_tindakan_rekomendasi', 'Ikuti Rekomendasi')
            ->set('upload_expert_dokumen', [$fakeDoc1, $fakeDoc2])
            ->set('klasifikasi_pelanggaran', 'Pelanggaran Tinggi')
            ->set('upload_sp1', $fakeSp1)
            ->set('upload_pembongkaran_bangunan', $fakePembongkaran)
            ->call('storeAnalisa')
            ->assertHasNoErrors();

        $pelanggaran->refresh();

        $this->assertEquals('Ada Pelanggaran', $pelanggaran->temuan_pelanggaran);
        $this->assertEquals('tidak_mematuhi_kkpr', $pelanggaran->jenis_indikasi_pelanggaran);
        $this->assertEquals('Tidak Mematuhi Ketentuan Pemanfaatan Ruang dalam Rencana Tata Ruang', $pelanggaran->indikasi_full_text);
        $this->assertEquals('tidak_sesuai_kkpr', $pelanggaran->kategori_pelanggaran);
        $this->assertEquals('Pemanfaatan Ruang yang tidak Memenuhi ketentuan dalam KKPR', $pelanggaran->kategori_full_text);
        $this->assertEquals('sempadan', $pelanggaran->jenis_pelanggaran);
        $this->assertEquals('Pelanggaran Sempadan (GSB, GSS, Sempadan Sungai, dll)', $pelanggaran->jenis_pelanggaran_full_text);
        $this->assertEquals('Ada', $pelanggaran->dampak_keluhan_masyarakat);
        $this->assertEquals('Besar (> 500 meter)', $pelanggaran->dampak_radius_wilayah);
        $this->assertEquals($user->id, $pelanggaran->expert_user_id);
        $this->assertEquals('Dr. Analis Tata Ruang', $pelanggaran->expert_user_name);
        $this->assertEquals('Bangunan melanggar sempadan sungai sejauh 15 meter dan berpotensi banjir.', $pelanggaran->expert_justifikasi);
        $this->assertEquals('Perlu dilakukan penindakan tegas penghentian dan pembongkaran.', $pelanggaran->expert_kesimpulan);
        $this->assertEquals('Ikuti Rekomendasi', $pelanggaran->expert_tindakan_rekomendasi);
        $this->assertEquals('Pelanggaran Tinggi', $pelanggaran->klasifikasi_pelanggaran);
        $this->assertEquals('Surat Peringatan I, Pembongkaran Bangunan', $pelanggaran->tindak_lanjut);

        // Dokumen tersimpan di storage
        $this->assertCount(2, $pelanggaran->expert_dokumen_pendukung);
        Storage::disk('public')->assertExists($pelanggaran->expert_dokumen_pendukung[0]);
        Storage::disk('public')->assertExists($pelanggaran->expert_dokumen_pendukung[1]);
        Storage::disk('public')->assertExists($pelanggaran->file_sp1);
        Storage::disk('public')->assertExists($pelanggaran->file_pembongkaran_bangunan);

        // Verifikasi bahwa opsi pertama juga bisa memilih 'Pemanfaatan Ruang yang tidak memiliki KKPR'
        Livewire::test(PelanggaranAnalisDetail::class, ['id' => $pelanggaran->id])
            ->set('jenis_indikasi_pelanggaran', 'tidak_menaati_rtr')
            ->set('kategori_pelanggaran', 'tanpa_kkpr')
            ->set('jenis_pelanggaran', 'lokasi_tidak_sesuai')
            ->call('storeAnalisa')
            ->assertHasNoErrors();

        $pelanggaran->refresh();
        $this->assertEquals('tanpa_kkpr', $pelanggaran->kategori_pelanggaran);
        $this->assertEquals('lokasi_tidak_sesuai', $pelanggaran->jenis_pelanggaran);
        $this->assertEquals('Pemanfaatan Ruang Tidak Memiliki KKPR', $pelanggaran->kategori_label);
        $this->assertEquals('Lokasi Tidak Sesuai Peruntukannya', $pelanggaran->jenis_pelanggaran_label);
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
            ->set('nama_pemilik_perusahaan', 'PT Cipta Ruang')
            ->set('alamat_pelanggaran', 'Jl. Kasus')
            ->set('kel_pelanggaran', 'Kel. Kasus')
            ->set('kec_pelanggaran', 'Mataram')
            ->set('koordinat_pelanggaran', '-8.583, 116.094')
            ->set('gmaps_pelanggaran', 'https://maps.google.com/?q=-8.583,116.094')
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

    public function test_dedicated_page_pelanggaran_analis_form_saves_slugs_and_redirects(): void
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'role' => 'admin-pelanggaran',
            'name' => 'Analis Ahli Tata Ruang',
            'password_changed_at' => now(),
        ]);
        $this->actingAs($user);

        $pelanggaran = Pelanggaran::create([
            'no_pelanggaran' => '099/Wasdal-Taru/XI/2026',
            'tgl_laporan' => '2026-11-11',
            'sumber_informasi_pelanggaran' => 'Hasil Pengawasan dan Monitoring',
            'nama_pelanggar' => 'PT Mega Land',
            'nama_pemilik_perusahaan' => 'PT Mega Land Corporation',
            'alamat_pelanggaran' => 'Jl. Bypass Mataram',
            'kel_pelanggaran' => 'Dasan Cermen',
            'kec_pelanggaran' => 'Sandubaya',
            'koordinat_pelanggaran' => '-8.601, 116.142',
            'jenis_pemanfaatan_ruang' => 'Zona Perdagangan dan Jasa',
            'pemanfaatan_ruang' => 'Pusat Perbelanjaan',
            'status' => 'On Progress',
        ]);

        $response = $this->get(route('pelanggaran.analis', $pelanggaran->id));
        $response->assertStatus(200);

        $fakeSp1 = UploadedFile::fake()->create('sp1.pdf', 100, 'application/pdf');

        Livewire::test(PelanggaranAnalisForm::class, ['id' => $pelanggaran->id])
            ->set('temuan_pelanggaran', 'Ada Pelanggaran')
            ->set('jenis_indikasi_pelanggaran', 'tidak_mematuhi_kkpr')
            ->set('kategori_pelanggaran', 'tidak_sesuai_kkpr')
            ->set('jenis_pelanggaran', 'klb')
            ->set('dampak_keluhan_masyarakat', 'Ada')
            ->set('dampak_radius_wilayah', 'Besar (> 500 meter)')
            ->set('skala_pelanggaran', 'skala_5')
            ->set('riwayat_pelanggaran', 'riwayat_5')
            ->assertSet('klasifikasi_pelanggaran', 'Pelanggaran Tinggi')
            ->set('expert_justifikasi', 'Bangunan melebihi batas koefisien lantai bangunan sebesar 2 lantai.')
            ->set('expert_kesimpulan', 'Disarankan pengenaan sanksi administratif penghentian sementara dan penyesuaian izin.')
            ->set('expert_tindakan_rekomendasi', 'Ikuti Rekomendasi')
            ->set('upload_sp1', $fakeSp1)
            ->call('storeAnalisa')
            ->assertHasNoErrors()
            ->assertRedirect(route('pelanggaran.detail', $pelanggaran->id));

        $pelanggaran->refresh();
        $this->assertEquals('Ada Pelanggaran', $pelanggaran->temuan_pelanggaran);
        $this->assertEquals('tidak_mematuhi_kkpr', $pelanggaran->jenis_indikasi_pelanggaran);
        $this->assertEquals('Tidak Mematuhi Ketentuan Pemanfaatan Ruang (Pelanggaran KKPR)', $pelanggaran->indikasi_label);
        $this->assertEquals('tidak_sesuai_kkpr', $pelanggaran->kategori_pelanggaran);
        $this->assertEquals('Pemanfaatan Ruang Tidak Memenuhi Ketentuan KKPR', $pelanggaran->kategori_label);
        $this->assertEquals('klb', $pelanggaran->jenis_pelanggaran);
        $this->assertEquals('Pelanggaran Ketentuan Koefisien Lantai Bangunan (KLB)', $pelanggaran->jenis_pelanggaran_label);
        $this->assertEquals('Pelanggaran Tinggi', $pelanggaran->klasifikasi_pelanggaran);
        $this->assertEquals(69, $pelanggaran->skor_total);
        $this->assertEquals($user->id, $pelanggaran->expert_user_id);
        $this->assertEquals('Analis Ahli Tata Ruang', $pelanggaran->expert_user_name);
        $this->assertNotNull($pelanggaran->file_sp1);
        Storage::disk('public')->assertExists($pelanggaran->file_sp1);

        // Render setiap cabang UI halaman analisis
        Livewire::test(PelanggaranAnalisForm::class, ['id' => $pelanggaran->id])
            ->assertSee('Dokumen Sanksi Administratif')
            ->assertSee('1 / 8 terunggah')
            ->set('klasifikasi_pelanggaran', 'Pelanggaran Rendah')
            ->assertSet('expert_tindakan_rekomendasi', 'Anulir Rekomendasi')
            ->assertSee('Anulir Rekomendasi')
            ->set('temuan_pelanggaran', 'Tidak Ada Pelanggaran')
            ->assertSee('Berkas Perizinan')
            ->assertDontSee('Dokumen Sanksi Administratif');

        // Verifikasi tombol Resume Pelanggaran berada pada Tab Detail (PelanggaranDetail)
        Livewire::test(PelanggaranDetail::class, ['id' => $pelanggaran->id])
            ->assertSee('Resume Pelanggaran')
            ->assertSee('RESUME PELANGGARAN')
            ->assertSee('Delik Pelanggaran')
            ->assertSee('Hasil Tipologi')
            ->assertSee('Arah Penanganan');
    }

    public function test_skoring_penilaian_mengikuti_rumus_dan_sheet_kasus_excel(): void
    {
        // Contoh 1 Sheet Kasus (Sopian - Single A): Nilai Total = 55 -> Pelanggaran Sedang
        $kasus1 = Pelanggaran::hitungSkorPenilaian(
            ['lokasi_tidak_sesuai'],
            'Tidak Ada',
            'skala_2',
            'riwayat_1'
        );
        $this->assertTrue($kasus1['is_complete']);
        $this->assertEquals(5, $kasus1['nilai_a']);
        $this->assertEquals(2.00, $kasus1['hasil_a']);
        $this->assertEquals(1, $kasus1['nilai_b']);
        $this->assertEquals(0.35, $kasus1['hasil_b']);
        $this->assertEquals(2, $kasus1['nilai_c']);
        $this->assertEquals(0.30, $kasus1['hasil_c']);
        $this->assertEquals(1, $kasus1['nilai_d']);
        $this->assertEquals(0.10, $kasus1['hasil_d']);
        $this->assertEquals(2.75, $kasus1['jumlah_abcd']);
        $this->assertEquals(55, $kasus1['skor_total']);
        $this->assertEquals('Pelanggaran Sedang', $kasus1['rekomendasi_kategori']);

        // Contoh 2 Sheet Kasus (Sopian - Multi-Select A): Nilai Total = 73 -> Pelanggaran Tinggi
        $kasus2 = Pelanggaran::hitungSkorPenilaian(
            ['sempadan', 'perubahan_fungsi_bangunan'],
            'Kecil (< 250 meter)',
            'skala_3',
            'riwayat_1'
        );
        $this->assertTrue($kasus2['is_complete']);
        $this->assertCount(2, $kasus2['items_a']);
        $this->assertEquals(6, $kasus2['nilai_a']);
        $this->assertEquals(2.40, $kasus2['hasil_a']);
        $this->assertEquals(2, $kasus2['nilai_b']);
        $this->assertEquals(0.70, $kasus2['hasil_b']);
        $this->assertEquals(3, $kasus2['nilai_c']);
        $this->assertEquals(0.45, $kasus2['hasil_c']);
        $this->assertEquals(1, $kasus2['nilai_d']);
        $this->assertEquals(0.10, $kasus2['hasil_d']);
        $this->assertEquals(3.65, $kasus2['jumlah_abcd']);
        $this->assertEquals(73, $kasus2['skor_total']);
        $this->assertEquals('Pelanggaran Tinggi', $kasus2['rekomendasi_kategori']);

        // Skoring minimal (< 40): Skor = 20 -> Pelanggaran Rendah
        $kasusRendah = Pelanggaran::hitungSkorPenilaian(
            ['tidak_lanjut_pbg'],
            'Tidak Ada',
            'skala_1',
            'riwayat_1'
        );
        $this->assertEquals(1.00, $kasusRendah['jumlah_abcd']);
        $this->assertEquals(20, $kasusRendah['skor_total']);
        $this->assertEquals('Pelanggaran Rendah', $kasusRendah['rekomendasi_kategori']);
    }

    public function test_multi_select_komponen_a_pada_pelanggaran_analis_form_menghitung_dan_menyimpan_skor(): void
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'role' => 'admin-pelanggaran',
            'name' => 'Tim Penilai Tata Ruang',
            'password_changed_at' => now(),
        ]);
        $this->actingAs($user);

        $pelanggaran = Pelanggaran::create([
            'no_pelanggaran' => '100/Wasdal-Taru/XI/2026',
            'tgl_laporan' => '2026-11-16',
            'sumber_informasi_pelanggaran' => 'Hasil Pengawasan dan Monitoring',
            'nama_pelanggar' => 'Sopian',
            'alamat_pelanggaran' => 'Jl. Majapahit No. 10',
            'kel_pelanggaran' => 'Pagesangan',
            'kec_pelanggaran' => 'Mataram',
            'koordinat_pelanggaran' => '-8.590, 116.105',
            'status' => 'On Progress',
        ]);

        Livewire::test(PelanggaranAnalisForm::class, ['id' => $pelanggaran->id])
            ->set('temuan_pelanggaran', 'Ada Pelanggaran')
            ->set('jenis_indikasi_pelanggaran', 'tidak_mematuhi_kkpr')
            ->set('kategori_pelanggaran', 'tidak_sesuai_kkpr')
            ->set('jenis_pelanggaran', ['sempadan', 'perubahan_fungsi_bangunan'])
            ->set('dampak_radius_wilayah', 'Kecil (< 250 meter)')
            ->set('skala_pelanggaran', 'skala_3')
            ->set('riwayat_pelanggaran', 'riwayat_1')
            ->assertSet('klasifikasi_pelanggaran', 'Pelanggaran Tinggi')
            ->assertSee('73.00')
            ->call('storeAnalisa')
            ->assertHasNoErrors()
            ->assertRedirect(route('pelanggaran.detail', $pelanggaran->id));

        $pelanggaran->refresh();
        $this->assertEquals(['sempadan', 'perubahan_fungsi_bangunan'], $pelanggaran->jenis_pelanggaran_list);
        $this->assertEquals(6, $pelanggaran->nilai_a);
        $this->assertEquals(2, $pelanggaran->nilai_b);
        $this->assertEquals(3, $pelanggaran->nilai_c);
        $this->assertEquals(1, $pelanggaran->nilai_d);
        $this->assertEquals(73, $pelanggaran->skor_total);
        $this->assertEquals('Pelanggaran Tinggi', $pelanggaran->klasifikasi_pelanggaran);
        $this->assertStringContainsString('Pelanggaran GSB & GSS', $pelanggaran->jenis_pelanggaran_label);
        $this->assertStringContainsString('Perubahan Fungsi Bangunan', $pelanggaran->jenis_pelanggaran_label);

        // Pastikan Resume, Detail & Tab Analisis terender bersih tanpa kode mentah
        $detailResponse = $this->get(route('pelanggaran.detail', $pelanggaran->id));
        $detailResponse->assertStatus(200)
            ->assertSee('ResumeCaptureArea')
            ->assertSee('Download PNG')
            ->assertSee('Download PDF')
            ->assertDontSee('Download JPG')
            ->assertSee('Resume_Pelanggaran_100-Wasdal-Taru-XI-2026')
            ->assertSee('html2canvas.min.js');

        Livewire::test(PelanggaranDetail::class, ['id' => $pelanggaran->id])
            ->assertSee('Tidak Mematuhi Ketentuan Pemanfaatan Ruang (Pelanggaran KKPR)')
            ->assertDontSee('2. Tidak Mematuhi Ketentuan Pemanfaatan Ruang (Pelanggaran KKPR)')
            ->assertSee('Perubahan Fungsi Bangunan')
            ->assertSee('73')
            ->call('downloadResumePdf')
            ->assertFileDownloaded('Resume_Pelanggaran_100-Wasdal-Taru-XI-2026.pdf');

        Livewire::test(PelanggaranAnalisDetail::class, ['id' => $pelanggaran->id])
            ->assertSee('Tidak Mematuhi Ketentuan Pemanfaatan Ruang (Pelanggaran KKPR)')
            ->assertDontSee('2. Tidak Mematuhi Ketentuan Pemanfaatan Ruang (Pelanggaran KKPR)')
            ->assertSee('Pelanggaran GSB & GSS (Sempadan Sungai, dll)')
            ->assertSee('Perubahan Fungsi Bangunan')
            ->assertSee('25 - 50% Luasan Maksimal yg Diperbolehkan / Luasan Bangunan 200 - 500 m²')
            ->assertDontSee('(Luasan Bangunan')
            ->assertSee('Tidak Ditemukan faktor pemberat')
            ->assertDontSee('tidak_mematuhi_kkpr')
            ->assertDontSee('tidak_sesuai_kkpr')
            ->assertDontSee('skala_3')
            ->assertDontSee('riwayat_1');

        Livewire::test(PelanggaranAnalisForm::class, ['id' => $pelanggaran->id])
            ->assertSee('Tidak Menaati Rencana Tata Ruang (Perubahan Fungsi Ruang)')
            ->assertSee('Tidak Mematuhi Ketentuan Pemanfaatan Ruang (Pelanggaran KKPR)')
            ->assertSee('Menghalangi Akses Kawasan Milik Umum')
            ->assertDontSee('1. Tidak Menaati')
            ->assertDontSee('2. Tidak Mematuhi')
            ->assertDontSee('3. Menghalangi Akses');

        // Pastikan PelanggaranIndex menampilkan label terbaca tanpa nomor dan bukan slug mentah
        Livewire::test(PelanggaranIndex::class)
            ->assertSee('Tidak Mematuhi Ketentuan Pemanfaatan Ruang (Pelanggaran KKPR)')
            ->assertDontSee('2. Tidak Mematuhi Ketentuan Pemanfaatan Ruang (Pelanggaran KKPR)')
            ->assertDontSee('tidak_mematuhi_kkpr');

        // Pastikan PetaPelanggaran dan DashboardPelanggaran membaca indikasi baru dengan label terbaca tanpa nomor
        $peta = Livewire::test(PetaPelanggaran::class);
        $locations = $peta->get('locations');
        $this->assertEquals(
            'Tidak Mematuhi Ketentuan Pemanfaatan Ruang (Pelanggaran KKPR)',
            collect($locations)->firstWhere('id', $pelanggaran->id)['jenis_indikasi_pelanggaran'] ?? null
        );

        Livewire::test(\App\Livewire\Admin\Pelanggaran\DashboardPelanggaran::class)
            ->assertSet('rekap.count_indikasi_tidak_memenuhi_ketentuan', 1);

        // Pastikan data lama yang masih menyimpan prefiks angka (mis. "3. Menghalangi...") ikut bersih saat tampil
        $pelanggaran->update(['jenis_indikasi_pelanggaran' => '3. Menghalangi Akses Kawasan Milik Umum']);
        $pelanggaran->refresh();
        $this->assertEquals('Menghalangi Akses Kawasan Milik Umum', $pelanggaran->indikasi_label);
        Livewire::test(PelanggaranIndex::class)
            ->assertSee('Menghalangi Akses Kawasan Milik Umum')
            ->assertDontSee('3. Menghalangi Akses Kawasan Milik Umum');
    }

    public function test_livewire_incremental_checkbox_updates_preserve_multi_select_komponen_a(): void
    {
        $user = User::factory()->create(['role' => 'analis']);
        $this->actingAs($user);

        $pelanggaran = Pelanggaran::create([
            'no_pelanggaran' => '101/Wasdal-Taru/XI/2026',
            'tgl_laporan' => '2026-11-17',
            'sumber_informasi_pelanggaran' => 'Hasil Pengawasan dan Monitoring',
            'nama_pelanggar' => 'Budi Santoso',
            'alamat_pelanggaran' => 'Jl. Pejanggik',
            'kel_pelanggaran' => 'Cakranegara',
            'kec_pelanggaran' => 'Cakranegara',
            'koordinat_pelanggaran' => '-8.589, 116.120',
            'status' => 'On Progress',
        ]);

        // Simulasikan payload Livewire 3 sebenarnya saat checkbox dicentang satu per satu & di-uncheck (__rm__)
        Livewire::test(PelanggaranAnalisForm::class, ['id' => $pelanggaran->id])
            ->set('temuan_pelanggaran', 'Ada Pelanggaran')
            ->set('jenis_indikasi_pelanggaran', 'tidak_mematuhi_kkpr')
            ->set('kategori_pelanggaran', 'tidak_sesuai_kkpr')
            ->set('jenis_pelanggaran.0', 'sempadan')
            ->assertSet('jenis_pelanggaran', ['sempadan'])
            ->assertSee('1 dipilih')
            ->set('jenis_pelanggaran.1', 'perubahan_fungsi_bangunan')
            ->assertSet('jenis_pelanggaran', ['sempadan', 'perubahan_fungsi_bangunan'])
            ->assertSee('2 dipilih')
            ->set('jenis_pelanggaran.2', 'klb')
            ->assertSet('jenis_pelanggaran', ['sempadan', 'perubahan_fungsi_bangunan', 'klb'])
            ->assertSee('3 dipilih')
            ->set('jenis_pelanggaran.1', 'klb')
            ->set('jenis_pelanggaran.2', '__rm__')
            ->assertSet('jenis_pelanggaran', ['sempadan', 'klb'])
            ->assertSee('2 dipilih')
            ->set('dampak_radius_wilayah', 'Kecil (< 250 meter)')
            ->set('skala_pelanggaran', 'skala_2')
            ->set('riwayat_pelanggaran', 'riwayat_1')
            ->call('storeAnalisa')
            ->assertHasNoErrors();

        $pelanggaran->refresh();
        $this->assertEquals(['sempadan', 'klb'], $pelanggaran->jenis_pelanggaran_list);
        $this->assertEquals(4, $pelanggaran->nilai_a);
    }

    public function test_wizard_step_by_step_dengan_komponen_c_dan_d_terpisah_berjalan_sesuai_validasi(): void
    {
        $user = User::factory()->create(['role' => 'analis']);
        $this->actingAs($user);

        $pelanggaran = Pelanggaran::create([
            'no_pelanggaran' => '102/Wasdal-Taru/XI/2026',
            'tgl_laporan' => '2026-11-17',
            'sumber_informasi_pelanggaran' => 'Hasil Pengawasan dan Monitoring',
            'nama_pelanggar' => 'CV Maju Bersama',
            'alamat_pelanggaran' => 'Jl. Sriwijaya',
            'kel_pelanggaran' => 'Mataram Timur',
            'kec_pelanggaran' => 'Mataram',
            'koordinat_pelanggaran' => '-8.591, 116.115',
            'status' => 'On Progress',
        ]);

        // 1. Alur 7 Langkah untuk "Ada Pelanggaran" (Komponen C = Step 4, Komponen D = Step 5 terpisah)
        $wizard = Livewire::test(PelanggaranAnalisForm::class, ['id' => $pelanggaran->id])
            ->assertSet('currentStep', 1)
            ->call('nextStep')
            ->assertHasErrors(['temuan_pelanggaran'])
            ->assertSet('currentStep', 1)
            // Pilih Ada Pelanggaran -> lanjut ke Step 2 (Komponen A)
            ->set('temuan_pelanggaran', 'Ada Pelanggaran')
            ->assertSet('total_steps', 7)
            ->call('nextStep')
            ->assertHasNoErrors()
            ->assertSet('currentStep', 2)
            // Validasi Step 2 (Komponen A)
            ->call('nextStep')
            ->assertHasErrors(['jenis_indikasi_pelanggaran', 'kategori_pelanggaran', 'jenis_pelanggaran'])
            ->assertSet('currentStep', 2)
            ->set('jenis_indikasi_pelanggaran', 'tidak_menaati_rtr')
            ->set('kategori_pelanggaran', 'tanpa_kkpr')
            ->call('selectAllJenisPelanggaran')
            ->assertSet('jenis_pelanggaran', ['lokasi_sesuai', 'lokasi_tidak_sesuai'])
            ->call('clearJenisPelanggaran')
            ->assertSet('jenis_pelanggaran', [])
            ->set('jenis_pelanggaran.0', 'lokasi_tidak_sesuai')
            ->call('nextStep')
            ->assertHasNoErrors()
            ->assertSet('currentStep', 3)
            // Validasi Step 3 (Komponen B)
            ->call('nextStep')
            ->assertHasErrors(['dampak_radius_wilayah'])
            ->assertSet('currentStep', 3)
            ->set('dampak_radius_wilayah', 'Tidak Ada')
            ->call('nextStep')
            ->assertHasNoErrors()
            ->assertSet('currentStep', 4)
            // Validasi Step 4 (Komponen C - Skala terpisah sendiri)
            ->call('nextStep')
            ->assertHasErrors(['skala_pelanggaran'])
            ->assertSet('currentStep', 4)
            ->set('skala_pelanggaran', 'skala_2')
            ->call('nextStep')
            ->assertHasNoErrors()
            ->assertSet('currentStep', 5)
            // Validasi Step 5 (Komponen D - Riwayat terpisah sendiri)
            ->call('nextStep')
            ->assertHasErrors(['riwayat_pelanggaran'])
            ->assertSet('currentStep', 5)
            ->set('riwayat_pelanggaran', 'riwayat_1')
            ->assertSee('55.00')
            ->call('nextStep')
            ->assertHasNoErrors()
            ->assertSet('currentStep', 6)
            // Step 6: Ringkasan Skor & Expert Judgement -> lanjut ke Step 7
            ->set('expert_justifikasi', 'Lokasi tidak sesuai rencana peruntukan ruang.')
            ->call('nextStep')
            ->assertHasNoErrors()
            ->assertSet('currentStep', 7)
            ->assertSee('Pelanggaran Sedang')
            // Uji prevStep & goToStep
            ->call('prevStep')
            ->assertSet('currentStep', 6)
            ->call('goToStep', 2)
            ->assertSet('currentStep', 2)
            ->call('goToStep', 7)
            ->assertSet('currentStep', 7)
            ->call('storeAnalisa')
            ->assertHasNoErrors();

        $pelanggaran->refresh();
        $this->assertEquals(55, $pelanggaran->skor_total);
        $this->assertEquals('Pelanggaran Sedang', $pelanggaran->klasifikasi_pelanggaran);

        // 2. Jika storeAnalisa() gagal validasi di langkah awal, currentStep otomatis melompat ke langkah tersebut
        Livewire::test(PelanggaranAnalisForm::class, ['id' => $pelanggaran->id])
            ->set('currentStep', 7)
            ->set('skala_pelanggaran', null)
            ->call('storeAnalisa')
            ->assertHasErrors(['skala_pelanggaran'])
            ->assertSet('currentStep', 4);

        // 3. Alur 2 Langkah untuk "Tidak Ada Pelanggaran"
        Livewire::test(PelanggaranAnalisForm::class, ['id' => $pelanggaran->id])
            ->set('temuan_pelanggaran', 'Tidak Ada Pelanggaran')
            ->assertSet('total_steps', 2)
            ->call('nextStep')
            ->assertHasNoErrors()
            ->assertSet('currentStep', 2)
            ->assertSee('Berkas Perizinan');
    }

    public function test_dashboard_pelanggaran_menampilkan_rekap_klasifikasi_dan_jenis_indikasi(): void
    {
        $user = User::factory()->create(['role' => 'admin']);
        $this->actingAs($user);

        $year = date('Y');
        $base = [
            'tgl_laporan' => "{$year}-06-15",
            'sumber_informasi_pelanggaran' => 'Laporan Masyarakat',
            'alamat_pelanggaran' => 'Jl. Majapahit',
            'kel_pelanggaran' => 'Kekalik Jaya',
            'kec_pelanggaran' => 'Sekarbela',
            'koordinat_pelanggaran' => '-8.590, 116.100',
            'status' => 'On Progress',
        ];

        Pelanggaran::create(array_merge($base, [
            'no_pelanggaran' => '201/Wasdal-Taru/VI/' . $year,
            'nama_pelanggar' => 'Pelanggar Tinggi 1',
            'temuan_pelanggaran' => 'Ada Pelanggaran',
            'klasifikasi_pelanggaran' => 'Pelanggaran Tinggi',
            'jenis_indikasi_pelanggaran' => 'tidak_menaati_rtr',
        ]));

        Pelanggaran::create(array_merge($base, [
            'no_pelanggaran' => '202/Wasdal-Taru/VI/' . $year,
            'nama_pelanggar' => 'Pelanggar Tinggi 2',
            'temuan_pelanggaran' => 'Ada Pelanggaran',
            'klasifikasi_pelanggaran' => 'Pelanggaran Tinggi',
            'jenis_indikasi_pelanggaran' => 'tidak_mematuhi_kkpr',
        ]));

        Pelanggaran::create(array_merge($base, [
            'no_pelanggaran' => '203/Wasdal-Taru/VI/' . $year,
            'nama_pelanggar' => 'Pelanggar Sedang',
            'temuan_pelanggaran' => 'Ada Pelanggaran',
            'klasifikasi_pelanggaran' => 'Pelanggaran Sedang',
            'jenis_indikasi_pelanggaran' => 'menghalangi_akses_umum',
        ]));

        Pelanggaran::create(array_merge($base, [
            'no_pelanggaran' => '204/Wasdal-Taru/VI/' . $year,
            'nama_pelanggar' => 'Pelanggar Rendah Lama',
            'temuan_pelanggaran' => 'Ada Pelanggaran',
            'klasifikasi_pelanggaran' => 'Pelanggaran Rendah',
            'jenis_indikasi_pelanggaran' => 'Tidak Memiliki Persetujuan Bangunan Gedung (PBG)',
        ]));

        Pelanggaran::create(array_merge($base, [
            'no_pelanggaran' => '205/Wasdal-Taru/VI/' . $year,
            'nama_pelanggar' => 'Belum Dianalisis',
            'klasifikasi_pelanggaran' => null,
            'jenis_indikasi_pelanggaran' => null,
        ]));

        // Data tahun sebelumnya tidak boleh ikut terhitung di rekap tahun aktif
        Pelanggaran::create(array_merge($base, [
            'no_pelanggaran' => '206/Wasdal-Taru/VI/' . ((int) $year - 1),
            'tgl_laporan' => ((int) $year - 1) . '-06-15',
            'nama_pelanggar' => 'Pelanggar Tahun Lalu',
            'temuan_pelanggaran' => 'Ada Pelanggaran',
            'klasifikasi_pelanggaran' => 'Pelanggaran Tinggi',
            'jenis_indikasi_pelanggaran' => 'tidak_menaati_rtr',
        ]));

        Livewire::test(\App\Livewire\Admin\Pelanggaran\DashboardPelanggaran::class)
            ->assertSet('rekap.count_pelanggaran_year', 5)
            ->assertSet('rekap.count_klasifikasi_tinggi', 2)
            ->assertSet('rekap.count_klasifikasi_sedang', 1)
            ->assertSet('rekap.count_klasifikasi_rendah', 1)
            ->assertSet('rekap.count_klasifikasi_belum', 1)
            ->assertSet('rekap.count_indikasi_tidak_memiliki_kkpr', 1)
            ->assertSet('rekap.count_indikasi_tidak_memenuhi_ketentuan', 1)
            ->assertSet('rekap.count_indikasi_menghalangi_akses', 1)
            ->assertSet('rekap.count_indikasi_tidak_memiliki_pbg', 1)
            ->assertSee('Rekap Berdasarkan Klasifikasi Pelanggaran')
            ->assertSee('Rekap Jenis Indikasi Pelanggaran')
            ->assertSee('Pelanggaran Tinggi')
            ->assertSee('Pelanggaran Sedang')
            ->assertSee('Pelanggaran Rendah')
            ->assertSee('Belum Dianalisis')
            ->assertSee('Tidak Menaati Rencana Tata Ruang')
            ->assertSee('Tidak Mematuhi Ketentuan Pemanfaatan Ruang')
            ->assertSee('Menghalangi Akses Kawasan Milik Umum')
            ->assertSee('Tidak Memiliki PBG (Data Lama)');
    }
}
