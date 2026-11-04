<?php

namespace App\Livewire\Admin\Permohonan\Kkprnb\Spv;

use App\Models\Kkprnb;
use App\Models\PermohonanBerkas;
use App\Models\Tahapan;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class KkprnbVerifikasiEdit extends Component
{
    public $berkas, $catatan;
    public $kkprnb_id;
    public $isLoading = true;

    #[Validate('required')]
    public $status;
    
    public function render()
    {
        return view('livewire.admin.permohonan.kkprnb.spv.kkprnb-verifikasi-edit');
    }

    #[On('kkprnb-verifikasi-edit')]
    public function getBerkas($kkprnb_id, $berkas_id)
    {
        $this->reset(['berkas', 'status', 'catatan']);
        $this->isLoading = true;
        $this->kkprnb_id = $kkprnb_id;
        $this->berkas = PermohonanBerkas::with('persyaratan.tahapan')->find($berkas_id);
        if ($this->berkas) {
            $this->status = $this->berkas->status;
            $this->catatan = $this->berkas->catatan_verifikator;
        }
        $this->isLoading = false;
    }

    public function updateVerifikasi()
    {
        $this->validate();

        if (!$this->berkas) {
            $this->dispatch('toast', [
                'type'    => 'error',
                'message' => 'Berkas belum dipilih atau sedang dimuat!'
            ]);
            return;
        }

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
            $nama_tahapan = $tahapan->nama ?? '';

            $kkprnb = Kkprnb::find($this->kkprnb_id);

            $currentDisposisi = $kkprnb->disposisis()
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
                $kkprnb->update([
                    'is_survey' => false,
                    'is_berkas_survey_uploaded' => false,
                ]);
            }
            elseif($nama_tahapan == 'Analisis')
            {
                $kkprnb->update([
                    'is_analis' => false,
                    'is_berkas_analis_uploaded' => false,
                ]);
            }
        }

        $this->reset(['status', 'catatan', 'berkas']);
        $this->isLoading = true;

        $message = $this->status == 'diterima'
            ? "Verifikasi : Berkas Diterima!"
            : "Verifikasi : Berkas Ditolak!";

        $this->dispatch('toast', [
            'type'    => $this->status == 'diterima' ? 'success' : 'error',
            'message' => $message
        ]);
        
        $this->dispatch('refresh-kkprnb-verifikasi-list');
        $this->dispatch('refresh-kkprnb-analis-list');
        $this->dispatch('refresh-kkprnb-survey-list');

        $this->dispatch('trigger-close-modal');
    }
}
