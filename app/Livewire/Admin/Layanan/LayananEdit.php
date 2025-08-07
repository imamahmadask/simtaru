<?php

namespace App\Livewire\Admin\Layanan;

use App\Models\Layanan;
use Livewire\Component;

class LayananEdit extends Component
{
    public $layananId;
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

    public function mount($id)
    {
        $layanan = Layanan::findOrFail($id);
        $this->layananId = $layanan->id;
        $this->nama_layanan = $layanan->nama_layanan;
        $this->deskripsi = $layanan->deskripsi;
    }

    public function update()
    {
        $this->validate();

        $layanan = Layanan::findOrFail($this->layananId);
        $layanan->update([
            'nama_layanan' => $this->nama_layanan,
            'deskripsi' => $this->deskripsi,
        ]);

        session()->flash('message', 'Layanan berhasil diperbarui.');
        return redirect()->route('admin.layanan.index');
    }

    public function render()
    {
        return view('livewire.admin.layanan.layanan-edit');
    }
}
