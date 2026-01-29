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

    #[Validate('required')]
    public $status;
    
    public function render()
    {
        return view('livewire.admin.permohonan.kkprnb.spv.kkprnb-verifikasi-edit');
    }

    #[On('kkprnb-verifikasi-edit')]
    public function getBerkas($kkprnb_id, $berkas_id)
    {
        $this->kkprnb_id = $kkprnb_id;
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
            $penerima_id = $this->berkas->uploaded_by;
            $tahapan_id = $this->berkas->persyaratan->tahapan_id;
            $tahapan = Tahapan::find($tahapan_id);
            $nama_tahapan = $tahapan->nama;

            $kkprnb = Kkprnb::find($this->kkprnb_id);

            $currentDisposisi = $kkprnb->disposisis()
            ->where('tahapan_id', $this->berkas->persyaratan->tahapan_id)
            ->where('is_done', true)
            ->latest()
            ->first();

            $currentDisposisi->update([
                'status'      => 'revised',
                'updated_by'  => Auth::id(),
            ]);

            $kkprnb->disposisis()->create([
                'permohonan_id' => $currentDisposisi->permohonan_id,
                'tahapan_id' => $currentDisposisi->tahapan_id,
                'pemberi_id' => Auth::user()->id,
                'penerima_id' => $penerima_id,
                'tanggal_disposisi' => now(),
                'catatan' => $this->catatan,
                'parent_id'         => $currentDisposisi->id,
                'is_revisi'         => 1,
                'status'            => 'pending',
                'is_done'           => 0,
            ]);

            if($nama_tahapan == 'Survey')
            {
                $kkprnb->update([
                    'is_survey' => false
                ]);
            }
            elseif($nama_tahapan == 'Analisis')
            {
                $kkprnb->update([
                    'is_analis' => false
                ]);
            }
        }

        $this->reset('status', 'catatan');

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
