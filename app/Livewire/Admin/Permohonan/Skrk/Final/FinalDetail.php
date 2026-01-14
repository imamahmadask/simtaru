<?php

namespace App\Livewire\Admin\Permohonan\Skrk\Final;

use App\Models\Permohonan;
use App\Models\RiwayatPermohonan;
use App\Models\Skrk;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class FinalDetail extends Component
{
    public $skrk;
    public $berkas_final;
    public $count_final;

    #[On('refresh-skrk-final-list')]
    public function refresh()
    {
        $this->skrk->refresh();
        $this->berkas_final = $this->skrk->permohonan->berkas->where('versi', 'final');
    }
    
    public function render()
    {
        return view('livewire.admin.permohonan.skrk.final.final-detail');
    }

    public function mount($skrk_id)
    {
        $this->skrk = Skrk::find($skrk_id);
        $this->berkas_final = $this->skrk->permohonan->berkas->where('versi', 'final');
    }

    public function selesaiFinalisasi()
    {
        if(Auth::user()->role == 'supervisor' || Auth::user()->role == 'superadmin' || Auth::user()->role == 'data-entry') {
            
            $persyaratan = $this->skrk->permohonan->persyaratanBerkas->where('wajib', true);
            $this->count_final = 0;
            foreach ($persyaratan as $syarat) {
                $berkas_uploaded = $this->berkas_final->where('persyaratan_berkas_id', $syarat->id)->first();
                if (!$berkas_uploaded) {
                    $this->count_final++;
                }
            }
            
            if($this->count_final == 0) {
                $this->skrk->permohonan->update([
                    'is_done' => true,
                    'status' => 'completed',
                ]);                 

                // Find and update the disposisi for the 'Verifikasi' stage
                $tahapanCetakId = $this->skrk->permohonan->layanan->tahapan->where('nama', 'Cetak')->value('id');
                if ($tahapanCetakId) {
                    $this->skrk->permohonan->disposisi()->where('tahapan_id', $tahapanCetakId)
                    ->where('is_done', false)
                    ->update([
                        'is_done' => true,
                        'tgl_selesai' => now()
                    ]);
                    $this->createRiwayat($this->skrk->permohonan, 'Permohonan SKRK selesai!');
                }

                session()->flash('success', 'Permohonan SKRK selesai!');
            }
            else
            {
                session()->flash('error', 'ERROR: Permohonan SKRK belum selesai! Mohon cek kembali kelengkapan/validasi berkas!');
            }
        }

        return redirect()->route('skrk.detail', ['id' => $this->skrk->id]);
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
