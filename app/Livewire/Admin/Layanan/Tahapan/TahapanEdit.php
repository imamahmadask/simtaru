<?php

namespace App\Livewire\Admin\Layanan\Tahapan;

use App\Models\Tahapan;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class TahapanEdit extends Component
{
    public $tahapan, $layanan_id;

    #[Validate(['required'])]
    public $nama, $urutan;


    #[On('tahapan-edit')]
    public function getTahapan($id)
    {
        $this->tahapan = Tahapan::find($id);
        $this->layanan_id = $this->tahapan->layanan_id;
        $this->nama = $this->tahapan->nama;
        $this->urutan = $this->tahapan->urutan;
    }

    public function editTahapan()
    {
        $this->validate();

        $this->tahapan->update([
            'layanan_id' => $this->layanan_id,
            'nama' => $this->nama,
            'urutan' => $this->urutan,
        ]);

        session()->flash('message', 'Tahapan berhasil diubah.');

        return redirect()->route('layanan.detail', ['id' => $this->layanan_id]);
    }
    public function render()
    {
        return view('livewire.admin.layanan.tahapan.tahapan-edit');
    }
}
