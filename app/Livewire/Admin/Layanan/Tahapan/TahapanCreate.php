<?php

namespace App\Livewire\Admin\Layanan\Tahapan;

use App\Models\Tahapan;
use Livewire\Attributes\Validate;
use Livewire\Component;

class TahapanCreate extends Component
{
    public $layanan_id;

    #[Validate(['required'])]
    public $nama, $urutan;
    public function render()
    {
        return view('livewire.admin.layanan.tahapan.tahapan-create');
    }

    public function mount($layanan_id)
    {
        $this->layanan_id = $layanan_id;
    }

    public function createTahapan()
    {
        $this->validate();

        Tahapan::create([
            'layanan_id' => $this->layanan_id,
            'nama' => $this->nama,
            'urutan' => $this->urutan,
        ]);

        session()->flash('message', 'Tahapan berhasil ditambahkan.');

        return redirect()->route('layanan.detail', ['id' => $this->layanan_id]);
    }
}
