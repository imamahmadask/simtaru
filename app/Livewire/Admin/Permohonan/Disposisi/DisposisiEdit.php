<?php

namespace App\Livewire\Admin\Permohonan\Disposisi;

use App\Models\Disposisi;
use App\Models\Permohonan;
use App\Models\Tahapan;
use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;

class DisposisiEdit extends Component
{
    public $disposisi, $nama_layanan, $tahapan_id, $users, $kode_registrasi;
    public $tahapans = [];
    public function render()
    {
        return view('livewire.admin.permohonan.disposisi.disposisi-edit');
    }

    #[On('disposisi-edit')]
    public function getDisposisi($id)
    {
        $this->disposisi = Disposisi::find($id);
        $permohonan = Permohonan::findOrFail($this->disposisi->permohonan_id);
        $this->nama_layanan = $permohonan->layanan->nama;
        $this->kode_registrasi = $permohonan->registrasi->kode;
        $this->tahapans = Tahapan::where('layanan_id', $permohonan->layanan_id)->get();
        $this->tahapan_id = $this->disposisi->tahapan_id;
    }

    public function mount()
    {
        $this->users = User::where('role', '!=', 'superadmin')->where('role', '!=', 'supervisor')->get();
    }
}
