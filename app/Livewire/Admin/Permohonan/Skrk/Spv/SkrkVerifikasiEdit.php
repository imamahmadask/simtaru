<?php

namespace App\Livewire\Admin\Permohonan\Skrk\Spv;

use App\Models\PermohonanBerkas;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;

class SkrkVerifikasiEdit extends Component
{
    public $berkas, $catatan;
    public $skrk_id;

    #[Validate('required')]
    public $status;
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

        $message = $this->status == 'diterima'
            ? "Verifikasi : Berkas Diterima!"
            : "Verifikasi : Berkas Ditolak!";

        session()->flash($this->status == 'diterima' ? 'success' : 'error', $message);

        redirect()->route('skrk.detail', ['id' => $this->skrk_id]);
    }

    public function mount($skrk_id, $berkas_id)
    {
        $this->skrk_id = $skrk_id;
        $this->berkas = PermohonanBerkas::find($berkas_id);
        $this->status = $this->berkas->status;
        $this->catatan = $this->berkas->catatan_verifikator;
    }
}
