<?php

namespace App\Livewire\Admin\Permohonan\Itr\Spv;

use App\Models\PermohonanBerkas;
use App\Models\Itr;
use App\Models\Tahapan;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ItrVerifikasiEdit extends Component
{
    public $berkas, $catatan;
    public $itr_id;

    #[Validate('required')]
    public $status;

    public function render()
    {
        return view('livewire.admin.permohonan.itr.spv.itr-verifikasi-edit');
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

            $itr = Itr::find($this->itr_id);
            $currentDisposisi = $itr->disposisis()
                ->where('tahapan_id', $this->berkas->persyaratan->tahapan_id)
                ->where('is_done', true)
                ->latest()
                ->first();

            $currentDisposisi->update([
                'status'      => 'revised',
                'updated_by'  => Auth::id(),
            ]);

            $itr->disposisis()->create([
                'permohonan_id'     => $currentDisposisi->permohonan_id,
                'tahapan_id'        => $currentDisposisi->tahapan_id,
                'pemberi_id'        => Auth::user()->id,
                'penerima_id'       => $penerima_id,
                'tanggal_disposisi' => now(),
                'catatan'           => $this->catatan,
                'parent_id'         => $currentDisposisi->id,
                'is_revisi'         => 1,
                'status'            => 'pending',
                'is_done'           => 0,
            ]);

            if($nama_tahapan == 'Survey')
            {
                $itr->update([
                    'is_survey' => false
                ]);
            }
            elseif($nama_tahapan == 'Analisis')
            {
                $itr->update([
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
        
        $this->dispatch('refresh-itr-verifikasi-list');
        $this->dispatch('refresh-itr-analis-list');
        $this->dispatch('refresh-itr-survey-list');

        $this->dispatch('trigger-close-modal');
    }

    #[On('itr-verifikasi-edit')]
    public function itrVerifikasiEdit($itr_id, $berkas_id)
    {
        $this->itr_id = $itr_id;
        $this->berkas = PermohonanBerkas::find($berkas_id);
        $this->status = $this->berkas->status;
        $this->catatan = $this->berkas->catatan_verifikator;
    }
}
