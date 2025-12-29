<?php

namespace App\Livewire\Admin\Permohonan\Itr\Final;

use App\Models\Itr;
use App\Models\Permohonan;
use App\Models\RiwayatPermohonan;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class FinalDetail extends Component
{
    public $itr;
    public $berkas_final;
    public $count_final;

    #[On('refresh-itr-final-list')]
    public function refresh()
    {
        $this->itr->refresh();
        $this->berkas_final = $this->itr->permohonan->berkas->where('versi', 'final');
    }
    
    public function render()
    {
        return view('livewire.admin.permohonan.itr.final.final-detail');
    }

    public function mount($itr_id)
    {
        $this->itr = Itr::find($itr_id);
        $this->berkas_final = $this->itr->permohonan->berkas->where('versi', 'final');
    }

    public function selesaiFinalisasi()
    {
        if(Auth::user()->role == 'supervisor' || Auth::user()->role == 'superadmin') {
            
            $persyaratan = $this->itr->permohonan->persyaratanBerkas->where('wajib', true);
            $this->count_final = 0;
            foreach ($persyaratan as $syarat) {
                $berkas_uploaded = $this->berkas_final->where('persyaratan_berkas_id', $syarat->id)->first();
                if (!$berkas_uploaded) {
                    $this->count_final++;
                }
            }

            if($this->count_final == 0) {
                $this->itr->permohonan->update([
                    'is_done' => true,
                    'status' => 'completed',
                ]);                 

                // Find and update the disposisi for the 'Verifikasi' stage
                $tahapanAnalisId = $this->itr->permohonan->layanan->tahapan->where('nama', 'Cetak')->value('id');
                if ($tahapanAnalisId) {
                    $this->itr->permohonan->disposisi()->where('tahapan_id', $tahapanAnalisId)
                    ->where('is_done', false)
                    ->update([
                        'is_done' => true,
                        'tgl_selesai' => now()
                    ]);
                    $this->createRiwayat($this->itr->permohonan, 'Permohonan ITR selesai!');
                }

                session()->flash('success', 'Permohonan ITR selesai!');
            }
            else
            {
                session()->flash('error', 'ERROR: Permohonan ITR belum selesai! Mohon cek kembali kelengkapan/validasi berkas!');
            }
        }

        return redirect()->route('itr.detail', ['id' => $this->itr->id]);
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
