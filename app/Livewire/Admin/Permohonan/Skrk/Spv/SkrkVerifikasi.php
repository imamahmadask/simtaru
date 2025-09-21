<?php

namespace App\Livewire\Admin\Permohonan\Skrk\Spv;

use App\Models\PermohonanBerkas;
use Livewire\Attributes\On;
use Livewire\Component;

class SkrkVerifikasi extends Component
{
    public $berkas;
    public $skrk_id;
    public function render()
    {
        return view('livewire.admin.permohonan.skrk.spv.skrk-verifikasi');
    }

    #[On('open-verifikasi')]
    public function getBerkas($id)
    {
        $this->berkas = PermohonanBerkas::find($id);
    }

    public function verifikasi(string $status): void
    {
        if (!$this->berkas) {
            return;
        }

        $this->berkas->update([
            'status' => $status,
        ]);

        session()->flash('success', "Berkas berhasil diverifikasi sebagai: {$status}");

        redirect()->route('skrk.detail', ['id' => $this->skrk_id]);
    }

    public function mount($skrk_id)
    {
        $this->skrk_id = $skrk_id;
    }
}
