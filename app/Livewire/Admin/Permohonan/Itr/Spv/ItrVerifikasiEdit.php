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
    public $isLoading = true;

    #[Validate('required')]
    public $status;

    public function render()
    {
        return view('livewire.admin.permohonan.itr.spv.itr-verifikasi-edit');
    }

    #[On('itr-verifikasi-edit')]
    public function itrVerifikasiEdit($itr_id, $berkas_id)
    {
        $this->reset(['berkas', 'status', 'catatan']);
        $this->isLoading = true;
        $this->itr_id = $itr_id;
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

            $itr = Itr::find($this->itr_id);
            $currentDisposisi = $itr->disposisis()
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
                $itr->update([
                    'is_survey' => false,
                    'is_berkas_survey_uploaded' => false,
                ]);
            }
            elseif($nama_tahapan == 'Analisis')
            {
                $itr->update([
                    'is_analis' => false,
                    'is_berkas_analis_uploaded' => false,
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

        $this->reset(['status', 'catatan', 'berkas']);
        $this->isLoading = true;
        
        $this->dispatch('refresh-itr-verifikasi-list');
        $this->dispatch('refresh-itr-analis-list');
        $this->dispatch('refresh-itr-analis-detail');
        $this->dispatch('refresh-itr-survey-list');
        $this->dispatch('refresh-itr-survey-detail');

        $this->dispatch('trigger-close-modal');
    }
}
