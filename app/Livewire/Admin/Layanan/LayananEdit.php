<?php

namespace App\Livewire\Admin\Layanan;

use App\Models\Layanan;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Title('Edit Layanan')]
class LayananEdit extends Component
{
    public $layanan_id, $keterangan;

    #[Validate('required')]
    public $nama, $kode;

    public function render()
    {
        return view('livewire.admin.layanan.layanan-edit');
    }

    #[On('layanan-edit')]
    public function getLayanan($id)
    {
        $layanan = Layanan::findOrFail($id);
        $this->layanan_id = $layanan->id;
        $this->nama = $layanan->nama;
        $this->kode = $layanan->kode;
        $this->keterangan = $layanan->keterangan;
    }

    public function editLayanan()
    {
        $this->validate();

        $layanan = Layanan::findOrFail($this->layanan_id);
        $layanan->update([
            'nama' => $this->nama,
            'kode' => $this->kode,
            'keterangan' => $this->keterangan,
        ]);

        session()->flash('success', 'Layanan berhasil diperbarui.');

        return redirect()->route('layanan.index');
    }

}
