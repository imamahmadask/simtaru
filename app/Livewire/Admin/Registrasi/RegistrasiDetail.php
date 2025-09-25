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
    public $fungsi_bangunan;
    public $alamat_tanah;
    public $kel_tanah;
    public $kec_tanah;
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
        $this->fungsi_bangunan = $this->registrasi->fungsi_bangunan;
        $this->alamat_tanah = $this->registrasi->alamat_tanah;
        $this->kel_tanah = $this->registrasi->kel_tanah;
        $this->kec_tanah = $this->registrasi->kec_tanah;

        $this->riwayats = $this->registrasi->riwayat;

    }
}
