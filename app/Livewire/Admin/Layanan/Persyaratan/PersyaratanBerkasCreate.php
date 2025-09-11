<?php

namespace App\Livewire\Admin\Layanan\Persyaratan;

use App\Models\PersyaratanBerkas;
use App\Models\Tahapan;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class PersyaratanBerkasCreate extends Component
{
    public $tahapan_id, $layanan_id;

    #[Validate(['required'])]
    public $nama_berkas, $kode, $deskripsi, $urutan, $wajib;

    public function render()
    {
        return view('livewire.admin.layanan.persyaratan.persyaratan-berkas-create');
    }

    #[On('persyaratan-add')]
    public function getTahapanId($tahapan_id, $layanan_id)
    {
        $this->tahapan_id = $tahapan_id;
        $this->layanan_id = $layanan_id;
    }

    public function createPersyaratanBerkas()
    {
        $this->validate();

        PersyaratanBerkas::create([
            'tahapan_id' => $this->tahapan_id,
            'nama_berkas' => $this->nama_berkas,
            'kode' => $this->kode,
            'deskripsi' => $this->deskripsi,
            'urutan' => $this->urutan,
            'wajib' => $this->wajib
        ]);

        session()->flash('message', 'Persyaratan Berkas berhasil ditambahkan.');

        return redirect()->route('layanan.detail', ['id' => $this->layanan_id]);
    }
}
