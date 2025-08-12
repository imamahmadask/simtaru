<?php

namespace App\Livewire\Admin\Layanan;

use App\Models\Layanan;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Tambah Layanan')]
class LayananCreate extends Component
{
    public $nama_layanan = '';
    public $deskripsi = '';

    protected $rules = [
        'nama_layanan' => 'required|string|max:255',
        'deskripsi' => 'required|string',
    ];

    protected $messages = [
        'nama_layanan.required' => 'Nama layanan harus diisi.',
        'nama_layanan.max' => 'Nama layanan maksimal 255 karakter.',
        'deskripsi.required' => 'Deskripsi harus diisi.',
    ];

    public function store()
    {
        $this->validate();

        Layanan::create([
            'nama_layanan' => $this->nama_layanan,
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
