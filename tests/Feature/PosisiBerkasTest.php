<?php

namespace Tests\Feature;

use App\Livewire\Admin\Permohonan\KeteranganBerkasModal;
use App\Livewire\Admin\Permohonan\Kkprb\KkprbDetail;
use App\Livewire\Admin\Permohonan\Kkprb\KkprbIndex;
use App\Livewire\Admin\Permohonan\Kkprnb\KkprnbDetail;
use App\Livewire\Admin\Permohonan\Kkprnb\KkprnbIndex;
use App\Livewire\Admin\Permohonan\PermohonanDetail;
use App\Livewire\Admin\Permohonan\PermohonanIndex;
use App\Livewire\Admin\Permohonan\Riwayat\RiwayatPermohonanIndex;
use App\Livewire\Admin\Permohonan\Skrk\SkrkDetail;
use App\Livewire\Admin\Permohonan\Skrk\SkrkIndex;
use App\Livewire\Guest\LacakBerkas;
use App\Models\Kkprb;
use App\Models\Kkprnb;
use App\Models\Layanan;
use App\Models\Permohonan;
use App\Models\Registrasi;
use App\Models\RiwayatPermohonan;
use App\Models\Skrk;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Livewire\Livewire;
use Tests\TestCase;

class PosisiBerkasTest extends TestCase
{
    use RefreshDatabase;

    private User $superadmin;
    private User $regularAdmin;
    private Registrasi $registrasi;
    private Permohonan $permohonan;
    private Skrk $skrk;

    protected function setUp(): void
    {
        parent::setUp();

        DB::table('layanan')->insertOrIgnore([
            ['id' => 1, 'nama' => 'SKRK', 'kode' => 'SKRK', 'keterangan' => 'Surat Keterangan Rencana Kota', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'nama' => 'KKPR Non Berusaha', 'kode' => 'KKPRNB', 'keterangan' => 'KKPR Non Berusaha', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'nama' => 'KKPR Berusaha', 'kode' => 'KKPRB', 'keterangan' => 'KKPR Berusaha', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'nama' => 'Informasi Tata Ruang', 'kode' => 'ITR', 'keterangan' => 'Informasi Tata Ruang', 'created_at' => now(), 'updated_at' => now()],
        ]);

        $this->superadmin = User::factory()->create([
            'role' => 'superadmin',
        ]);

        $this->regularAdmin = User::factory()->create([
            'role' => 'admin',
        ]);

        $this->registrasi = Registrasi::create([
            'kode'            => '0001-SKRK-10-2026',
            'nama'            => 'Ahmad Test',
            'nik'             => '1234567890123456',
            'no_hp'           => '08123456789',
            'tanggal'         => date('Y-m-d'),
            'layanan_id'      => 1,
            'created_by'      => $this->superadmin->id,
            'email'           => 'ahmad@example.com',
            'fungsi_bangunan' => 'Rumah Tinggal',
            'alamat_tanah'    => 'Jl. Majapahit No. 10',
            'kel_tanah'       => 'Pagesangan',
            'kec_tanah'       => 'Mataram',
        ]);

        $this->permohonan = Permohonan::create([
            'registrasi_id' => $this->registrasi->id,
            'layanan_id'    => 1,
            'status'        => 'Proses Survey',
            'keterangan'    => 'Permohonan baru',
            'created_by'    => $this->superadmin->id,
            'updated_by'    => $this->superadmin->id,
            'luas_tanah'    => '200',
        ]);

        $this->skrk = Skrk::create([
            'permohonan_id' => $this->permohonan->id,
            'layanan_id'    => 1,
        ]);
    }

    public function test_modal_can_save_posisi_berkas_bpn_survey()
    {
        $this->actingAs($this->superadmin);

        Livewire::test(KeteranganBerkasModal::class)
            ->call('openModal', $this->permohonan->id, $this->skrk->id, 'BPN', 'Proses Survey')
            ->set('tanggal_status', '2026-10-05')
            ->set('catatan', 'Menunggu pengukuran batas bidang')
            ->call('saveKeterangan')
            ->assertDispatched('toast')
            ->assertDispatched('refresh-riwayat-permohonan')
            ->assertDispatched('refresh-skrk-detail')
            ->assertDispatched('refresh-skrk-index')
            ->assertDispatched('refresh-kkprnb-detail')
            ->assertDispatched('refresh-kkprnb-index')
            ->assertDispatched('refresh-kkprb-detail')
            ->assertDispatched('refresh-kkprb-index')
            ->assertDispatched('refresh-permohonan-detail')
            ->assertDispatched('refresh-permohonan-index');

        // Verifikasi pada database permohonan
        $this->permohonan->refresh();
        $this->assertEquals('BPN', $this->permohonan->posisi_berkas);
        $this->assertEquals('Proses Survey', $this->permohonan->proses_berkas);
        $this->assertEquals('2026-10-05', $this->permohonan->tgl_posisi_berkas->format('Y-m-d'));
        $this->assertEquals('Menunggu pengukuran batas bidang', $this->permohonan->ket_posisi_berkas);

        // Verifikasi pada riwayat_permohonans
        $riwayat = RiwayatPermohonan::where('registrasi_id', $this->registrasi->id)
            ->where('instansi', 'BPN')
            ->first();

        $this->assertNotNull($riwayat);
        $this->assertEquals('Proses Survey', $riwayat->proses);
        $this->assertEquals('2026-10-05', $riwayat->tanggal_status->format('Y-m-d'));
        $this->assertEquals('Menunggu pengukuran batas bidang', $riwayat->catatan);
        $this->assertStringNotContainsString('Bagian Survey', $riwayat->keterangan);
        $this->assertStringContainsString('Berkas berada di BPN (Proses Survey) per tanggal', $riwayat->keterangan);
    }

    public function test_modal_can_save_posisi_berkas_bpn_analisa()
    {
        $this->actingAs($this->superadmin);

        Livewire::test(KeteranganBerkasModal::class)
            ->call('openModal', $this->permohonan->id, $this->skrk->id, 'BPN', 'Analisa')
            ->set('tanggal_status', '2026-10-05')
            ->set('catatan', 'Analisa batas kawasan')
            ->call('saveKeterangan')
            ->assertDispatched('toast');

        $this->permohonan->refresh();
        $this->assertEquals('BPN', $this->permohonan->posisi_berkas);
        $this->assertEquals('Analisa', $this->permohonan->proses_berkas);

        $riwayat = RiwayatPermohonan::where('registrasi_id', $this->registrasi->id)
            ->where('instansi', 'BPN')
            ->first();

        $this->assertNotNull($riwayat);
        $this->assertEquals('Analisa', $riwayat->proses);
        $this->assertStringContainsString('Berkas berada di BPN (Analisa) per tanggal', $riwayat->keterangan);
    }

    public function test_modal_rejects_invalid_proses_for_bpn()
    {
        $this->actingAs($this->superadmin);

        Livewire::test(KeteranganBerkasModal::class)
            ->call('openModal', $this->permohonan->id, $this->skrk->id, 'BPN')
            ->set('proses', 'Tahapan Ngawur')
            ->call('saveKeterangan')
            ->assertHasErrors(['proses']);
    }

    public function test_modal_can_save_posisi_berkas_dpmptsp_cetak()
    {
        $this->actingAs($this->superadmin);

        Livewire::test(KeteranganBerkasModal::class)
            ->call('openModal', $this->permohonan->id, $this->skrk->id, 'DPMPTSP', 'Cetak Berkas')
            ->set('tanggal_status', '2026-10-06')
            ->set('catatan', 'Antrian cetak dan legalisir dokumen')
            ->call('saveKeterangan');

        $this->permohonan->refresh();
        $this->assertEquals('DPMPTSP', $this->permohonan->posisi_berkas);
        $this->assertEquals('Cetak Berkas', $this->permohonan->proses_berkas);
        $this->assertEquals('2026-10-06', $this->permohonan->tgl_posisi_berkas->format('Y-m-d'));
    }

    public function test_modal_rejects_invalid_proses_for_dpmptsp()
    {
        $this->actingAs($this->superadmin);

        Livewire::test(KeteranganBerkasModal::class)
            ->call('openModal', $this->permohonan->id, $this->skrk->id, 'DPMPTSP')
            ->set('proses', 'Proses Tidak Valid')
            ->call('saveKeterangan')
            ->assertHasErrors(['proses']);
    }

    public function test_riwayat_index_admin_shows_bpn_with_proses_badge()
    {
        RiwayatPermohonan::create([
            'registrasi_id'  => $this->registrasi->id,
            'user_id'        => $this->superadmin->id,
            'instansi'       => 'BPN',
            'proses'         => 'Proses Survey',
            'tanggal_status' => '2026-10-05',
            'catatan'        => 'Proses pertanahan di BPN',
            'keterangan'     => 'Berkas berada di BPN (Proses Survey) per tanggal 05 Oktober 2026 - Proses pertanahan di BPN',
        ]);

        $this->actingAs($this->superadmin);

        Livewire::test(RiwayatPermohonanIndex::class, ['permohonan' => $this->permohonan])
            ->assertSee('BPN')
            ->assertSee('Proses Survey')
            ->assertDontSee('Bagian Survey')
            ->assertSee('Berkas berada di BPN (Proses Survey) per tanggal 05 Oktober 2026');
    }

    public function test_guest_lacak_berkas_shows_status_posisi_berkas_bpn_and_proses()
    {
        $this->permohonan->update([
            'posisi_berkas'     => 'BPN',
            'proses_berkas'     => 'Proses Survey',
            'tgl_posisi_berkas' => '2026-10-05',
            'ket_posisi_berkas' => 'Pemeriksaan titik patok tanah',
        ]);

        RiwayatPermohonan::create([
            'registrasi_id'  => $this->registrasi->id,
            'user_id'        => $this->superadmin->id,
            'instansi'       => 'BPN',
            'proses'         => 'Proses Survey',
            'tanggal_status' => '2026-10-05',
            'catatan'        => 'Pemeriksaan titik patok tanah',
            'keterangan'     => 'Berkas berada di BPN (Proses Survey) per tanggal 05 Oktober 2026 - Pemeriksaan titik patok tanah',
        ]);

        Livewire::test(LacakBerkas::class)
            ->set('no_reg', $this->registrasi->kode)
            ->call('lacakBerkas')
            ->assertSee('Status Posisi Berkas Terkini')
            ->assertSee('Berkas sedang berada di BPN (Proses Survey)')
            ->assertDontSee('Bagian Survey')
            ->assertSee('Pemeriksaan titik patok tanah');
    }

    public function test_skrk_index_shows_posisi_berkas_badge()
    {
        $this->permohonan->update([
            'posisi_berkas'     => 'DPMPTSP',
            'proses_berkas'     => 'Input Permohonan',
            'tgl_posisi_berkas' => '2026-10-05',
        ]);

        $this->actingAs($this->superadmin);

        Livewire::test(SkrkIndex::class)
            ->assertSee('DPMPTSP')
            ->assertSee('(Input Permohonan)');
    }

    public function test_skrk_detail_renders_with_posisi_berkas_bpn_clean()
    {
        $this->permohonan->update([
            'posisi_berkas'     => 'BPN',
            'proses_berkas'     => 'Proses Survey',
            'tgl_posisi_berkas' => '2026-10-05',
            'ket_posisi_berkas' => 'Menunggu pengukuran batas',
        ]);

        $this->actingAs($this->superadmin);

        Livewire::test(SkrkDetail::class, ['id' => $this->skrk->id])
            ->assertSee('Posisi Berkas (BPN / DPMPTSP)')
            ->assertSee('Sedang berada di BPN')
            ->assertSee('Tahapan Proses Survey')
            ->assertSee('Menunggu pengukuran batas');
    }

    public function test_modal_can_clear_posisi_berkas()
    {
        $this->permohonan->update([
            'posisi_berkas'     => 'BPN',
            'proses_berkas'     => 'Proses Survey',
            'tgl_posisi_berkas' => '2026-10-05',
        ]);

        $this->actingAs($this->superadmin);

        Livewire::test(KeteranganBerkasModal::class)
            ->call('openModal', $this->permohonan->id, $this->skrk->id)
            ->call('clearPosisiBerkas')
            ->assertDispatched('toast');

        $this->permohonan->refresh();
        $this->assertNull($this->permohonan->posisi_berkas);
        $this->assertNull($this->permohonan->proses_berkas);

        // Riwayat pengembalian tercatat
        $this->assertDatabaseHas('riwayat_permohonans', [
            'registrasi_id' => $this->registrasi->id,
            'catatan'       => 'Berkas kembali diproses di SIMTARU',
        ]);
    }

    public function test_non_superadmin_cannot_open_modal_or_save_keterangan()
    {
        // 1. Regular admin accessing modal
        $this->actingAs($this->regularAdmin);

        Livewire::test(KeteranganBerkasModal::class)
            ->call('openModal', $this->permohonan->id, $this->skrk->id)
            ->assertDispatched('toast')
            ->assertNotDispatched('show-posisi-berkas-modal');

        // 2. Regular admin attempting to call saveKeterangan directly
        Livewire::test(KeteranganBerkasModal::class)
            ->call('saveKeterangan')
            ->assertStatus(403);

        // 3. Regular admin attempting to call clearPosisiBerkas directly
        Livewire::test(KeteranganBerkasModal::class)
            ->call('clearPosisiBerkas')
            ->assertStatus(403);
    }

    public function test_non_superadmin_does_not_see_action_buttons()
    {
        $this->actingAs($this->regularAdmin);

        // SkrkIndex should not show the yellow Posisi Berkas button
        Livewire::test(SkrkIndex::class)
            ->assertDontSee('title="Keterangan Posisi Berkas (BPN / DPMPTSP)"', false);

        // SkrkDetail should not show the Posisi Berkas button in header
        Livewire::test(SkrkDetail::class, ['id' => $this->skrk->id])
            ->assertDontSee('Posisi Berkas (BPN / DPMPTSP)');
    }

    public function test_kkprnb_index_and_detail_posisi_berkas()
    {
        $regKkprnb = Registrasi::create([
            'kode'            => '0002-KKPRNB-10-2026',
            'nama'            => 'Budi KKPRNB',
            'nik'             => '1234567890123457',
            'no_hp'           => '08123456780',
            'tanggal'         => date('Y-m-d'),
            'layanan_id'      => 2,
            'created_by'      => $this->superadmin->id,
            'fungsi_bangunan' => 'Rumah Tinggal',
            'alamat_tanah'    => 'Jl. Majapahit No. 10',
            'kel_tanah'       => 'Pagesangan',
            'kec_tanah'       => 'Mataram',
        ]);

        $permKkprnb = Permohonan::create([
            'registrasi_id'     => $regKkprnb->id,
            'layanan_id'        => 2,
            'status'            => 'Proses Survey',
            'posisi_berkas'     => 'BPN',
            'proses_berkas'     => 'Proses Survey',
            'tgl_posisi_berkas' => '2026-10-05',
            'ket_posisi_berkas' => 'Survei bersama BPN',
            'created_by'        => $this->superadmin->id,
            'updated_by'        => $this->superadmin->id,
        ]);

        $kkprnb = Kkprnb::create([
            'permohonan_id' => $permKkprnb->id,
            'layanan_id'    => 2,
        ]);

        $this->actingAs($this->superadmin);

        // 1. KkprnbIndex renders Posisi Berkas
        Livewire::test(KkprnbIndex::class)
            ->assertSee('BPN')
            ->assertSee('(Proses Survey)')
            ->assertSee('title="Keterangan Posisi Berkas (BPN / DPMPTSP)"', false);

        // 2. KkprnbDetail renders header button and banner
        Livewire::test(KkprnbDetail::class, ['id' => $kkprnb->id])
            ->assertSee('Posisi Berkas (BPN / DPMPTSP)')
            ->assertSee('Sedang berada di BPN')
            ->assertSee('Tahapan Proses Survey')
            ->assertSee('Survei bersama BPN');

        // 3. Modal can be opened via kkprnb_id
        Livewire::test(KeteranganBerkasModal::class)
            ->call('openModal', null, null, null, null, $kkprnb->id)
            ->assertDispatched('show-posisi-berkas-modal')
            ->assertSet('permohonan_id', $permKkprnb->id)
            ->assertSet('instansi', 'BPN')
            ->assertSet('proses', 'Proses Survey');
    }

    public function test_kkprb_index_and_detail_posisi_berkas()
    {
        $regKkprb = Registrasi::create([
            'kode'            => '0003-KKPRB-10-2026',
            'nama'            => 'Citra KKPRB',
            'nik'             => '1234567890123458',
            'no_hp'           => '08123456781',
            'tanggal'         => date('Y-m-d'),
            'layanan_id'      => 3,
            'created_by'      => $this->superadmin->id,
            'fungsi_bangunan' => 'Rumah Tinggal',
            'alamat_tanah'    => 'Jl. Majapahit No. 10',
            'kel_tanah'       => 'Pagesangan',
            'kec_tanah'       => 'Mataram',
        ]);

        $permKkprb = Permohonan::create([
            'registrasi_id'     => $regKkprb->id,
            'layanan_id'        => 3,
            'status'            => 'Proses Finalisasi',
            'posisi_berkas'     => 'DPMPTSP',
            'proses_berkas'     => 'Cetak Berkas',
            'tgl_posisi_berkas' => '2026-10-06',
            'ket_posisi_berkas' => 'Menunggu penerbitan izin',
            'created_by'        => $this->superadmin->id,
            'updated_by'        => $this->superadmin->id,
        ]);

        $kkprb = Kkprb::create([
            'permohonan_id' => $permKkprb->id,
            'layanan_id'    => 3,
        ]);

        $this->actingAs($this->superadmin);

        // 1. KkprbIndex renders Posisi Berkas
        Livewire::test(KkprbIndex::class)
            ->assertSee('DPMPTSP')
            ->assertSee('(Cetak Berkas)')
            ->assertSee('title="Keterangan Posisi Berkas (BPN / DPMPTSP)"', false);

        // 2. KkprbDetail renders header button and banner
        Livewire::test(KkprbDetail::class, ['id' => $kkprb->id])
            ->assertSee('Posisi Berkas (BPN / DPMPTSP)')
            ->assertSee('Sedang berada di DPMPTSP')
            ->assertSee('Tahapan Cetak Berkas')
            ->assertSee('Menunggu penerbitan izin');

        // 3. Modal can be opened via kkprb_id
        Livewire::test(KeteranganBerkasModal::class)
            ->call('openModal', null, null, null, null, null, $kkprb->id)
            ->assertDispatched('show-posisi-berkas-modal')
            ->assertSet('permohonan_id', $permKkprb->id)
            ->assertSet('instansi', 'DPMPTSP')
            ->assertSet('proses', 'Cetak Berkas');
    }

    public function test_permohonan_index_and_detail_posisi_berkas()
    {
        $this->permohonan->update([
            'posisi_berkas'     => 'BPN',
            'proses_berkas'     => 'Analisa',
            'tgl_posisi_berkas' => '2026-10-05',
            'ket_posisi_berkas' => 'Analisa pertanahan',
        ]);

        $this->actingAs($this->superadmin);

        // 1. PermohonanIndex renders Posisi Berkas
        Livewire::test(PermohonanIndex::class)
            ->assertSee('BPN')
            ->assertSee('(Analisa)')
            ->assertSee('title="Keterangan Posisi Berkas (BPN / DPMPTSP)"', false);

        // 2. PermohonanDetail renders header button and banner
        Livewire::test(PermohonanDetail::class, ['id' => $this->permohonan->id])
            ->assertSee('Posisi Berkas (BPN / DPMPTSP)')
            ->assertSee('Sedang berada di BPN')
            ->assertSee('Tahapan Analisa')
            ->assertSee('Analisa pertanahan');
    }

    public function test_itr_service_is_strictly_excluded_from_posisi_berkas()
    {
        $regItr = Registrasi::create([
            'kode'            => '0004-ITR-10-2026',
            'nama'            => 'Doni ITR',
            'nik'             => '1234567890123459',
            'no_hp'           => '08123456782',
            'tanggal'         => date('Y-m-d'),
            'layanan_id'      => 4,
            'created_by'      => $this->superadmin->id,
            'fungsi_bangunan' => 'Rumah Tinggal',
            'alamat_tanah'    => 'Jl. Majapahit No. 10',
            'kel_tanah'       => 'Pagesangan',
            'kec_tanah'       => 'Mataram',
        ]);

        $permItr = Permohonan::create([
            'registrasi_id' => $regItr->id,
            'layanan_id'    => 4, // ITR
            'status'        => 'Proses Survey',
            'created_by'    => $this->superadmin->id,
            'updated_by'    => $this->superadmin->id,
        ]);

        $this->actingAs($this->superadmin);

        // 1. Modal openModal for ITR must be blocked with error toast
        Livewire::test(KeteranganBerkasModal::class)
            ->call('openModal', $permItr->id)
            ->assertDispatched('toast')
            ->assertNotDispatched('show-posisi-berkas-modal');

        // 2. PermohonanDetail for ITR should NOT show the Posisi Berkas header button or banner
        Livewire::test(PermohonanDetail::class, ['id' => $permItr->id])
            ->assertDontSee('Posisi Berkas (BPN / DPMPTSP)');
    }

    public function test_modal_array_payload_keeps_bpn_analisa()
    {
        $this->actingAs($this->superadmin);

        // Simulasi $dispatch('open-modal-posisi-berkas', { ... }) dari tombol Analisa
        Livewire::test(KeteranganBerkasModal::class)
            ->call('openModal', [
                'permohonan_id' => $this->permohonan->id,
                'instansi'      => 'BPN',
                'proses'        => 'Analisa',
            ])
            ->assertSet('instansi', 'BPN')
            ->assertSet('proses', 'Analisa')
            ->call('saveKeterangan');

        $this->permohonan->refresh();
        $this->assertEquals('BPN', $this->permohonan->posisi_berkas);
        $this->assertEquals('Analisa', $this->permohonan->proses_berkas);
    }

    public function test_modal_edit_prefills_existing_values_including_date()
    {
        $this->permohonan->update([
            'posisi_berkas'     => 'BPN',
            'proses_berkas'     => 'Analisa',
            'tgl_posisi_berkas' => '2026-09-20',
            'ket_posisi_berkas' => 'Catatan lama',
        ]);

        $this->actingAs($this->superadmin);

        Livewire::test(KeteranganBerkasModal::class)
            ->call('openModal', ['permohonan_id' => $this->permohonan->id])
            ->assertSet('instansi', 'BPN')
            ->assertSet('proses', 'Analisa')
            ->assertSet('tanggal_status', '2026-09-20')
            ->assertSet('catatan', 'Catatan lama');
    }

    public function test_delete_riwayat_reverts_to_previous_posisi()
    {
        $this->actingAs($this->superadmin);

        $lama = RiwayatPermohonan::create([
            'registrasi_id' => $this->registrasi->id, 'user_id' => $this->superadmin->id,
            'instansi' => 'DPMPTSP', 'proses' => 'Input Permohonan', 'tanggal_status' => '2026-10-01',
            'catatan' => 'lama', 'keterangan' => 'Berkas berada di DPMPTSP',
            'created_at' => now()->subDay(),
        ]);
        $baru = RiwayatPermohonan::create([
            'registrasi_id' => $this->registrasi->id, 'user_id' => $this->superadmin->id,
            'instansi' => 'BPN', 'proses' => 'Analisa', 'tanggal_status' => '2026-10-05',
            'catatan' => 'baru', 'keterangan' => 'Berkas berada di BPN',
        ]);
        $this->permohonan->update(['posisi_berkas' => 'BPN', 'proses_berkas' => 'Analisa', 'tgl_posisi_berkas' => '2026-10-05', 'ket_posisi_berkas' => 'baru']);

        Livewire::test(KeteranganBerkasModal::class)
            ->call('openModal', ['permohonan_id' => $this->permohonan->id])
            ->call('deleteRiwayat', $baru->id)
            ->assertSet('instansi', 'DPMPTSP')
            ->assertSet('proses', 'Input Permohonan');

        $this->assertDatabaseMissing('riwayat_permohonans', ['id' => $baru->id]);
        $this->permohonan->refresh();
        $this->assertEquals('DPMPTSP', $this->permohonan->posisi_berkas);

        // Hapus yang terakhir -> posisi dikosongkan
        Livewire::test(KeteranganBerkasModal::class)
            ->call('openModal', ['permohonan_id' => $this->permohonan->id])
            ->call('deleteRiwayat', $lama->id);
        $this->permohonan->refresh();
        $this->assertNull($this->permohonan->posisi_berkas);
    }

    public function test_non_superadmin_cannot_delete_riwayat()
    {
        $r = RiwayatPermohonan::create([
            'registrasi_id' => $this->registrasi->id, 'user_id' => $this->superadmin->id,
            'instansi' => 'BPN', 'proses' => 'Analisa', 'tanggal_status' => '2026-10-05', 'keterangan' => 'x',
        ]);
        $this->actingAs($this->regularAdmin);
        Livewire::test(KeteranganBerkasModal::class)->call('deleteRiwayat', $r->id)->assertStatus(403);
        $this->assertDatabaseHas('riwayat_permohonans', ['id' => $r->id]);
    }
}
