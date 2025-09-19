<?php

namespace App\Livewire\Admin\Registrasi;

use App\Models\Registrasi;
use Livewire\Attributes\On;
use Livewire\Component;

class RegistrasiDetail extends Component
{
    public $registrasi;
    public $nama;
    public $kode;
    public $nik;
    public $no_hp;
    public $email;
    public $layanan;
    public $tanggal;
    public $riwayats = [];
    public function render()
    {
        return view('livewire.admin.registrasi.registrasi-detail');
    }

    #[On('registrasi-detail')]
    public function detailRegistrasi($id)
    {
        $this->registrasi = Registrasi::find($id);
        $this->nama = $this->registrasi->nama;
        $this->kode = $this->registrasi->kode;
        $this->nik = $this->registrasi->nik;
        $this->no_hp = $this->registrasi->no_hp;
        $this->email = $this->registrasi->email;
        $this->layanan = $this->registrasi->layanan->nama;
        $this->tanggal = $this->registrasi->tanggal;
        $this->riwayats = $this->registrasi->riwayat;

    }
}
