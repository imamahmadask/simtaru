<?php

namespace App\Livewire\Admin\Permohonan\Kkprnb\Spv;

use App\Models\Kkprnb;
use App\Models\Permohonan;
use App\Models\RiwayatPermohonan;
use App\Models\Tahapan;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class KkprnbVerifikasiDetail extends Component
{
    public $kkprnb;
    public $count_verifikasi;
    public $berkas_draft;

    #[On('refresh-kkprnb-verifikasi-list')]
    public function refresh() {}
    
    public function render()
    {
        return view('livewire.admin.permohonan.kkprnb.spv.kkprnb-verifikasi-detail');
    }

    public function mount($kkprnb_id)
    {
        $this->kkprnb = Kkprnb::findOrFail($kkprnb_id);
        $this->count_verifikasi = $this->kkprnb->permohonan->berkas->where('status', '!=', 'diterima')->where('versi', 'draft')->count();
        $this->berkas_draft = $this->kkprnb->permohonan->berkas->where('versi', 'draft');
    }

    public function selesaiVerifikasi()
    {
        if(Auth::user()->role == 'supervisor' || Auth::user()->role == 'superadmin') {

            if($this->count_verifikasi == 0) {
                $this->kkprnb->update([
                    'is_validate' => true
                ]);

                $this->kkprnb->permohonan->update([
                    'status' => 'Cetak Dokumen'
                ]);

                // Find and update the disposisi for the 'Verifikasi' stage
                $tahapanAnalisId = $this->kkprnb->permohonan->layanan->tahapan->where('nama', 'Verifikasi')->value('id');
                if ($tahapanAnalisId) {
                    $this->kkprnb->permohonan->disposisi()->where('tahapan_id', $tahapanAnalisId)
                    ->where('is_done', false)
                    ->update([
                        'is_done' => true,
                        'tgl_selesai' => now()
                    ]);
                    $this->createRiwayat($this->kkprnb->permohonan, 'Selesai Analisa Data SKRK');
                }

                $tahapan = Tahapan::where('layanan_id', $this->kkprnb->permohonan->layanan_id)->where('urutan', 4)->first();

                $this->kkprnb->disposisis()->create([
                    'permohonan_id' => $this->kkprnb->permohonan->id,
                    'tahapan_id' => $tahapan->id,
                    'pemberi_id' => Auth::user()->id,
                    'penerima_id' => $this->kkprnb->permohonan->created_by,
                    'tanggal_disposisi' => now(),
                    'catatan' => 'Lanjutkan proses cetak Dokumen SKRK',
                ]);

                $this->createRiwayat($this->kkprnb->permohonan, 'Selesai Verifikasi Berkas SKRK');
                $this->createRiwayat($this->kkprnb->permohonan, 'Sedang Proses Cetak Dokumen SKRK');

                $this->dispatch('toast', [
                    'type'    => 'success',
                    'message' => 'Data Verifikasi selesai!'
                ]);
            }
            else
            {
                $this->dispatch('toast', [
                    'type'    => 'error',
                    'message' => 'ERROR: Verifikasi belum selesai! Mohon cek kembali kelengkapan/validasi berkas!'
                ]);
            }
        }

        // return redirect()->route('kkprnb.detail', ['id' => $this->kkprnb->id]);

        $this->dispatch('refresh-kkprnb-verifikasi-list');

        $this->dispatch('trigger-close-modal');
    }

    private function createRiwayat(Permohonan $permohonan, string $keterangan)
    {
        RiwayatPermohonan::create([
            'registrasi_id' => $permohonan->registrasi_id,
            'user_id' => Auth::user()->id,
            'keterangan' => $keterangan
        ]);
    }
}
