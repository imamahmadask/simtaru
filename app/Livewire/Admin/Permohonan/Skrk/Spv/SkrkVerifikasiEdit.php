<?php

namespace App\Livewire\Admin\Permohonan\Skrk\Spv;

use App\Models\Disposisi;
use App\Models\PermohonanBerkas;
use App\Models\Skrk;
use App\Models\Tahapan;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class SkrkVerifikasiEdit extends Component
{
    public $berkas, $catatan;
    public $skrk_id;

    #[Validate('required')]
    public $status;

    #[On('skrk-verifikasi-edit')]
    public function getData($skrk_id, $berkas_id)
    {
        $this->skrk_id = $skrk_id;
        $this->berkas = PermohonanBerkas::find($berkas_id);
        $this->status = $this->berkas->status;
        $this->catatan = $this->berkas->catatan_verifikator;
    }

    public function render()
    {
        return view('livewire.admin.permohonan.skrk.spv.skrk-verifikasi-edit');
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

            $skrk = Skrk::find($this->skrk_id);
            $currentDisposisi = $skrk->disposisis()
                ->where('tahapan_id', $this->berkas->persyaratan->tahapan_id)
                ->where('is_done', true)
                ->latest()
                ->first();

            $currentDisposisi->update([
                'status'      => 'revised',
                'updated_by'  => Auth::id(),
            ]);

            $skrk->disposisis()->create([
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
                $skrk->update([
                    'is_survey' => false
                ]);
            }
            elseif($nama_tahapan == 'Analisis')
            {
                $skrk->update([
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

        $this->dispatch('refresh-skrk-verifikasi-list');
        $this->dispatch('refresh-skrk-analis-list');
        $this->dispatch('refresh-skrk-survey-list');

        $this->dispatch('trigger-close-modal');
    }
}
