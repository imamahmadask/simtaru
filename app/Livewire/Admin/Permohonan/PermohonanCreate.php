<?php

namespace App\Livewire\Admin\Permohonan;

use App\Models\Layanan;
use App\Models\Permohonan;
use App\Models\Registrasi;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
#[Title('Tambah Permohonan')]
class PermohonanCreate extends Component
{
    public $layanans, $registrasis;

    #[Validate('required')]
    public $registrasi_id, $layanan_id, $nama, $alamat_tanah, $kel_tanah, $kec_tanah, $jenis_bangunan;

    public $keterangan, $status;

    public function render()
    {
        return view('livewire.admin.permohonan.permohonan-create');
    }

    public function addPermohonan()
    {
        $this->validate();

        $this->status = 'Pending';

        Permohonan::create([
            'registrasi_id' => $this->registrasi_id,
            'layanan_id' => $this->layanan_id,
            'alamat_tanah' => $this->alamat_tanah,
            'kel_tanah' => $this->kel_tanah,
            'kec_tanah' => $this->kec_tanah,
            'jenis_bangunan' => $this->jenis_bangunan,
            'status' => $this->status,
            'keterangan' => $this->keterangan,
            'created_by' => Auth::user()->id,
            'updated_by' => Auth::user()->id
        ]);

        session()->flash('success', 'Permohonan berhasil ditambahkan!');

        $this->redirectRoute('permohonan.index');
    }

    public function mount()
    {
        $this->layanans = Layanan::all();
        $this->registrasis = Registrasi::doesntHave('permohonan')->get();
    }

    public function updated($registrasi_id)
    {
        if ($this->registrasi_id != "") {
            $registrasi = Registrasi::find($this->registrasi_id);
            $this->layanan_id = $registrasi->layanan_id;
            $this->nama = $registrasi->nama;
        }
        else
        {
            $this->layanan_id = null;
            $this->nama = null;
        }
    }
}
