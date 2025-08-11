<?php

namespace App\Livewire\Admin\Permohonan;

use App\Models\Layanan;
use App\Models\Permohonan;
use App\Models\Registrasi;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Title('Edit Permohonan')]
class PermohonanEdit extends Component
{
    public $layanans, $registrasis;
    public $permohonan_id;

    #[Validate('required')]
    public $registrasi_id, $layanan_id, $alamat_tanah, $kel_tanah, $kec_tanah, $jenis_bangunan;

    public $keterangan, $status;

    public function mount($id)
    {
        $permohonan = Permohonan::findOrFail($id);
        $this->permohonan_id = $permohonan->id;
        $this->registrasi_id = $permohonan->registrasi_id;
        $this->layanan_id = $permohonan->layanan_id;
        $this->alamat_tanah = $permohonan->alamat_tanah;
        $this->kel_tanah = $permohonan->kel_tanah;
        $this->kec_tanah = $permohonan->kec_tanah;
        $this->jenis_bangunan = $permohonan->jenis_bangunan;
        $this->keterangan = $permohonan->keterangan;
        $this->status = $permohonan->status;

        $this->layanans = Layanan::all();

        $this->registrasis = Registrasi::all();
    }

    public function updatePermohonan()
    {
        $this->validate();

        $permohonan = Permohonan::findOrFail($this->permohonan_id);
        $permohonan->update([
            'registrasi_id' => $this->registrasi_id,
            'layanan_id' => $this->layanan_id,
            'alamat_tanah' => $this->alamat_tanah,
            'kel_tanah' => $this->kel_tanah,
            'kec_tanah' => $this->kec_tanah,
            'jenis_bangunan' => $this->jenis_bangunan,
            'keterangan' => $this->keterangan,
            'status' => $this->status,
            'updated_by' => Auth::user()->id
        ]);

        session()->flash('message', 'Permohonan berhasil diperbarui.');
        $this->redirectRoute('permohonan.index');
    }

    public function render()
    {
        return view('livewire.admin.permohonan.permohonan-edit');
    }
}
