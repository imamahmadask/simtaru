<?php

namespace App\Livewire\Admin\Permohonan\Kkprb\Spv;

use App\Models\Kkprb;
use App\Models\PermohonanBerkas;
use App\Models\Tahapan;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class KkprbVerifikasiEdit extends Component
{
    public $berkas, $catatan;
    public $kkprb_id;

    #[Validate('required')]
    public $status;
    
    public function render()
    {
        return view('livewire.admin.permohonan.kkprb.spv.kkprb-verifikasi-edit');
    }

    #[On('kkprb-verifikasi-edit')]
    public function getBerkas($kkprb_id, $berkas_id)
    {
        $this->kkprb_id = $kkprb_id;
        $this->berkas = PermohonanBerkas::find($berkas_id);
        $this->status = $this->berkas->status;
        $this->catatan = $this->berkas->catatan_verifikator;
    }

    public function updateVerifikasi()
    {
        $this->validate();

        $verified_at = $this->status == 'diterima' ? now() : null;
        $verified_by = $this->status == 'diterima' ? Auth::user()->id : null;

        $this->berkas->update([
            'status' => $this->status,
            'catatan_verifikator' => $this->catatan,
            'verified_by' => $verified_by,
            'verified_at' => $verified_at
        ]);

        if($this->status == 'ditolak')
        {
            $tahapan_id = $this->berkas->persyaratan->tahapan_id;
            $tahapan = Tahapan::find($tahapan_id);
            $nama_tahapan = $tahapan->nama;

            $kkprb = Kkprb::find($this->kkprb_id);
            $currentDisposisi = $kkprb->disposisis()
                ->where('tahapan_id', $this->berkas->persyaratan->tahapan_id)
                ->latest()
                ->first();

            if ($currentDisposisi) {
                $currentDisposisi->update([
                    'status'    => 'pending',
                    'catatan'   => $this->catatan,
                    'updated_by' => Auth::id(),
                    'is_revisi'  => 1,
                    'is_done'    => 0,
                ]);
            }

            if($nama_tahapan == 'Survey')
            {
                $kkprb->update([
                    'is_survey' => false
                ]);
            }
            elseif($nama_tahapan == 'Analisis')
            {
                $kkprb->update([
                    'is_analis' => false
                ]);
            }
        }

        
        $message = $this->status == 'diterima'
        ? "Verifikasi : Berkas Diterima!"
        : "Verifikasi : Berkas Ditolak!";
        
        $this->dispatch('toast', [
            'type'    => $this->status == 'diterima' ? 'success' : 'error',
            'message' => $message
        ]);
        
        $this->reset('status', 'catatan');
        
        $this->dispatch('refresh-kkprb-verifikasi-list');
        $this->dispatch('refresh-kkprb-analis-list');
        $this->dispatch('refresh-kkprb-survey-list');

        $this->dispatch('trigger-close-modal');
    }
}
