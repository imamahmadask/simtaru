<?php

namespace App\Livewire\Admin\Permohonan\Disposisi;

use App\Models\Disposisi;
use App\Models\Permohonan;
use App\Models\RiwayatPermohonan;
use App\Models\Tahapan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Component;

class DisposisiCreate extends Component
{
    public $tahapans, $users;
    public $permohonan, $catatan, $pemberi_id, $permohonan_id;

    #[Validate('required')]
    public $tahapan_id, $penerima_id;

    public function render()
    {
        return view('livewire.admin.permohonan.disposisi.disposisi-create');
    }

    public function mount($permohonan_id)
    {
        $this->permohonan = Permohonan::findOrFail($permohonan_id);
        $this->tahapans = Tahapan::where('layanan_id', $this->permohonan->layanan_id)
                                 ->get();
        $this->users = User::where('role', '!=', 'superadmin')->where('role', '!=', 'supervisor')->get();
    }

    public function createDisposisi()
    {
        $this->validate();

        $this->pemberi_id = Auth::user()->id;

        Disposisi::create([
            'permohonan_id' => $this->permohonan->id,
            'tahapan_id' => $this->tahapan_id,
            'pemberi_id' => $this->pemberi_id,
            'penerima_id' => $this->penerima_id,
            // 'tanggal_disposisi' => $this->tanggal_disposisi,
            'catatan' => $this->catatan
        ]);

         RiwayatPermohonan::create([
            'registrasi_id' => $this->permohonan->registrasi_id,
            'user_id' => Auth::user()->id,
            'keterangan' => 'Disposisi kepada ' . $this->users->where('id', $this->penerima_id)->first()->name.' pada tahapan ' . $this->tahapans->where('id', $this->tahapan_id)->first()->nama
        ]);

        session()->flash('message', 'Disposisi berhasil ditambahkan.');
        $this->redirectRoute('permohonan.detail', ['id' => $this->permohonan_id]);
    }

    // public function updatedTahapanId($value)
    // {

    // }
}
