<?php

namespace App\Livewire\Admin\Layanan;

use App\Models\Layanan;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Title('Tambah Layanan')]
class LayananCreate extends Component
{
    #[Validate('required')]
    public $nama = '';

    public $deskripsi = '';

    public function addLayanan()
    {
        $this->validate();

        Layanan::create([
            'nama' => $this->nama,
            'deskripsi' => $this->deskripsi,
        ]);

        session()->flash('message', 'Layanan berhasil ditambahkan.');

        return redirect()->route('layanan.index');
    }

    public function render()
    {
        return view('livewire.admin.layanan.layanan-create');
    }
}
