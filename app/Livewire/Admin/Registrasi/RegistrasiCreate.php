<?php

namespace App\Livewire\Admin\Registrasi;

use App\Models\Layanan;
use App\Models\Registrasi;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;

class RegistrasiCreate extends Component
{
    public $layanans;

    #[Validate('required')]
    public $nama, $no_hp, $layanan_id, $tanggal;

    #[Validate('required|min:16,max:16|numeric')]
    public $nik;

    public function render()
    {
        return view('livewire.admin.registrasi.registrasi-create');
    }

    public function createRegistrasi(){
        $this->validate();

        Registrasi::create([
           'nama' => $this->nama,
           'nik' => $this->nik,
           'no_hp' => $this->no_hp,
           'tanggal' => $this->tanggal,
           'layanan_id' => $this->layanan_id,
           'created_by' => Auth::user()->id
        ]);

        session()->flash('success', 'Registrasi berhasil ditambahkan!');

        $this->redirectRoute('registrasi.index');
    }

    public function mount(){
        $this->layanans = Layanan::all();
    }
}
