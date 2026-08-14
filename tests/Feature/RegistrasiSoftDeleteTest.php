<?php

namespace Tests\Feature;

use App\Livewire\Admin\Registrasi\RegistrasiIndex;
use App\Models\Layanan;
use App\Models\Permohonan;
use App\Models\Registrasi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * RegistrasiSoftDeleteTest
 *
 * Menguji fitur SoftDelete, Sampah (Trash), Restore, dan Force Delete
 * pada modul Registrasi.
 *
 * Jalankan: php artisan test --filter=RegistrasiSoftDeleteTest
 */
class RegistrasiSoftDeleteTest extends TestCase
{
    use RefreshDatabase;

    private User $superadmin;

    protected function setUp(): void
    {
        parent::setUp();

        DB::table('layanan')->insertOrIgnore([
            ['id' => 1, 'nama' => 'SKRK', 'kode' => 'SKRK', 'keterangan' => 'Surat Keterangan Rencana Kota', 'created_at' => now(), 'updated_at' => now()],
        ]);

        $this->superadmin = User::factory()->create([
            'role' => 'superadmin',
        ]);
    }

    private function buatRegistrasiDanPermohonan(): Registrasi
    {
        $reg = Registrasi::create([
            'kode'            => '0001-SKRK-08-2026',
            'nama'            => 'Budi Pemohon',
            'nik'             => '1234567890123456',
            'no_hp'           => '08123456789',
            'tanggal'         => date('Y-m-d'),
            'layanan_id'      => 1,
            'created_by'      => $this->superadmin->id,
            'email'           => 'budi@example.com',
            'fungsi_bangunan' => 'Rumah Tinggal',
            'alamat_tanah'    => 'Jl. Merdeka No. 1',
            'kel_tanah'       => 'Mataram',
            'kec_tanah'       => 'Mataram',
        ]);

        $permohonan = Permohonan::create([
            'registrasi_id' => $reg->id,
            'layanan_id'    => 1,
            'status'        => 'pending',
            'created_by'    => $this->superadmin->id,
            'berkas_ktp'    => 'permohonan/dummy_ktp.pdf',
        ]);

        // Simulasikan file dummy di storage disk
        Storage::disk('public')->put('permohonan/dummy_ktp.pdf', 'dummy content');

        return $reg;
    }

    public function test_delete_registrasi_melakukan_soft_delete(): void
    {
        $reg = $this->buatRegistrasiDanPermohonan();

        Livewire::actingAs($this->superadmin)
            ->test(RegistrasiIndex::class)
            ->call('deleteRegistrasi', $reg->id);

        // Record terisi deleted_at (soft deleted)
        $this->assertSoftDeleted('registrasi', ['id' => $reg->id]);
        $this->assertSoftDeleted('permohonan', ['registrasi_id' => $reg->id]);

        // File fisik di storage TIDAK terhapus saat soft delete
        Storage::disk('public')->assertExists('permohonan/dummy_ktp.pdf');
    }

    public function test_data_soft_deleted_muncul_di_trash_view(): void
    {
        $reg = $this->buatRegistrasiDanPermohonan();

        $component = Livewire::actingAs($this->superadmin)
            ->test(RegistrasiIndex::class);

        // Di mode normal (aktif), data tidak boleh muncul
        $reg->delete();

        $component->set('viewTrash', false);
        $this->assertCount(0, $component->viewData('registrasis'));

        // Di mode trash, data soft deleted harus muncul
        $component->set('viewTrash', true);
        $this->assertCount(1, $component->viewData('registrasis'));
    }

    public function test_restore_registrasi_mengembalikan_data_ke_aktif(): void
    {
        $reg = $this->buatRegistrasiDanPermohonan();

        // Soft delete dulu
        Livewire::actingAs($this->superadmin)
            ->test(RegistrasiIndex::class)
            ->call('deleteRegistrasi', $reg->id);

        $this->assertSoftDeleted('registrasi', ['id' => $reg->id]);

        // Panggil restoreRegistrasi
        Livewire::actingAs($this->superadmin)
            ->test(RegistrasiIndex::class)
            ->call('restoreRegistrasi', $reg->id);

        // Data kembali aktif (deleted_at NULL)
        $this->assertDatabaseHas('registrasi', [
            'id'         => $reg->id,
            'deleted_at' => null,
        ]);

        $this->assertDatabaseHas('permohonan', [
            'registrasi_id' => $reg->id,
            'deleted_at'    => null,
        ]);
    }

    public function test_force_delete_registrasi_menghapus_permanen_data_dan_file(): void
    {
        $reg = $this->buatRegistrasiDanPermohonan();

        // Perform Soft Delete dulu
        $reg->delete();

        // Panggil forceDeleteRegistrasi
        Livewire::actingAs($this->superadmin)
            ->test(RegistrasiIndex::class)
            ->call('forceDeleteRegistrasi', $reg->id);

        // Data benar-benar hilang dari database
        $this->assertDatabaseMissing('registrasi', ['id' => $reg->id]);
        $this->assertDatabaseMissing('permohonan', ['registrasi_id' => $reg->id]);

        // File fisik di storage HARUS terhapus saat force delete
        Storage::disk('public')->assertMissing('permohonan/dummy_ktp.pdf');
    }
}
