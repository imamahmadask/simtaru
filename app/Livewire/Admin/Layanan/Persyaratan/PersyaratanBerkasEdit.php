<?php

namespace App\Livewire\Admin\Layanan\Persyaratan;

use App\Models\PersyaratanBerkas;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class PersyaratanBerkasEdit extends Component
{
    public $berkas, $tahapan_id, $layanan_id;

    #[Validate(['required'])]
    public $nama_berkas, $deskripsi, $urutan, $wajib;
    public function render()
    {
        return view('livewire.admin.layanan.persyaratan.persyaratan-berkas-edit');
    }

    #[On('persyaratan-berkas-edit')]
    public function getPersyaratanBerkas($id)
    {
        $this->berkas = PersyaratanBerkas::find($id);
        $this->tahapan_id = $this->berkas->tahapan_id;
        $this->nama_berkas = $this->berkas->nama_berkas;
        $this->deskripsi = $this->berkas->deskripsi;
        $this->urutan = $this->berkas->urutan;
        $this->wajib = $this->berkas->wajib;


        $this->layanan_id = $this->berkas->tahapan->layanan_id;
    }

    public function editPersyaratanBerkas()
    {
        $this->validate();

        $this->berkas->update([
            'tahapan_id' => $this->tahapan_id,
            'nama_berkas' => $this->nama_berkas,
            'deskripsi' => $this->deskripsi,
            'urutan' => $this->urutan,
            'wajib' => $this->wajib
        ]);

        session()->flash('message', 'Persyaratan Berkas berhasil diubah.');

        return redirect()->route('layanan.detail', ['id' => $this->layanan_id]);
    }
}
