<?php

namespace App\Livewire\Admin\Disposisi;

use App\Models\Disposisi;
use App\Models\Permohonan;
use App\Models\Tahapan;
use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;

class DisposisiEdit extends Component
{
    public $penerima_id, $catatan, $permohonan;
    public $disposisi, $nama_layanan, $tahapan_id, $users, $kode_registrasi;
    public $tahapans = [];
    public function render()
    {
        return view('livewire.admin.disposisi.disposisi-edit');
    }

    #[On('disposisi-edit')]
    public function getDisposisi($id)
    {
        $this->disposisi = Disposisi::find($id);
        $this->permohonan = Permohonan::findOrFail($this->disposisi->permohonan_id);
        $this->nama_layanan = $this->permohonan->layanan->nama;
        $this->kode_registrasi = $this->permohonan->registrasi->kode;

        $this->tahapan_id = $this->disposisi->tahapan_id;
        $this->penerima_id = $this->disposisi->penerima_id;
        $this->catatan = $this->disposisi->catatan;
    }

    public function mount($layanan_id)
    {
        $this->tahapans = Tahapan::where('layanan_id', $layanan_id)->get();
        $this->users = User::whereNotIn('role', ['superadmin', 'supervisor'])->get();
    }

    public function updateDisposisi()
    {
        $this->disposisi->update([
            'tahapan_id' => $this->tahapan_id,
            'penerima_id' => $this->penerima_id,
            'catatan' => $this->catatan
        ]);

        session()->flash('message', 'Disposisi berhasil diubah.');
        return redirect()->route('disposisi.index');
    }
}
