<?php

namespace App\Livewire\Admin\Permohonan\Kkprb\Final;

use App\Models\Kkprb;
use App\Models\Permohonan;
use App\Models\RiwayatPermohonan;
use App\Models\Tahapan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;

class KkprbFinalDetail extends Component
{
    public $kkprb;
    public $berkas_final;
    public $count_final;

    public function render()
    {
        return view('livewire.admin.permohonan.kkprb.final.kkprb-final-detail');
    }

    public function mount($kkprb_id)
    {
        $this->kkprb = Kkprb::find($kkprb_id);
        $this->berkas_final = $this->kkprb->permohonan->berkas->where('versi', 'final');                
    }

    #[On('refresh-kkprb-final-list')]
    public function refresh()
    {
        $this->kkprb->refresh();
        $this->berkas_final = $this->kkprb->permohonan->berkas->where('versi', 'final');
    }    

    public function deleteBerkas($berkas_id)
    {
        $berkas = \App\Models\PermohonanBerkas::findOrFail($berkas_id);

        if ($berkas->file_path && Storage::disk('public')->exists($berkas->file_path)) {
            Storage::disk('public')->delete($berkas->file_path);
        }

        $berkas->delete();

        $this->refresh();

        $this->dispatch('toast', [
            'type'    => 'success',
            'message' => 'Berkas berhasil dihapus!'
        ]);
    }

    public function selesaiFinalisasi()
    {
        if(Auth::user()->role == 'supervisor' || Auth::user()->role == 'superadmin' || Auth::user()->role == 'data-entry') {
            
            $persyaratan = $this->kkprb->permohonan->persyaratanBerkas->where('wajib', true);
            $this->count_final = 0;
            foreach ($persyaratan as $syarat) {
                $berkas_uploaded = $this->berkas_final->where('persyaratan_berkas_id', $syarat->id)->first();
                if (!$berkas_uploaded) {
                    $this->count_final++;
                }
            }

            if($this->count_final == 0) {
                $this->kkprb->permohonan->update([
                    'is_done' => true,
                    'status' => 'completed',
                ]);                 

                // Find and update the disposisi for the 'Verifikasi' stage
                $tahapanCetakId = $this->kkprb->permohonan->layanan->tahapan->where('nama', 'Cetak')->value('id');
                if ($tahapanCetakId) {
                    $this->kkprb->permohonan->disposisi()->where('tahapan_id', $tahapanCetakId)
                    ->where('is_done', false)
                    ->update([
                        'is_done' => true,
                        'tgl_selesai' => now()
                    ]);
                    $this->createRiwayat($this->kkprb->permohonan, 'Permohonan KKPR Berusaha selesai!');
                }

                session()->flash('success', 'Permohonan KKPR Berusaha selesai!');
            }
            else
            {
                session()->flash('error', 'ERROR: Permohonan KKPR Berusaha belum selesai! Mohon cek kembali kelengkapan/validasi berkas!');
            }
        }

        return redirect()->route('kkprb.detail', ['id' => $this->kkprb->id]);
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
