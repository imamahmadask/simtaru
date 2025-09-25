<?php

namespace App\Livewire\Admin\Registrasi;

use App\Models\Layanan;
use App\Models\Registrasi;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class RegistrasiEdit extends Component
{
    public $registrasi_id, $layanans;

    #[Validate('required')]
    public $nama, $no_hp, $layanan_id, $tanggal, $fungsi_bangunan, $alamat_tanah, $kel_tanah, $kec_tanah;

    #[Validate('required|min:16,max:16|numeric')]
    public $nik;

    #[Validate('required|email')]
    public $email;
    public function render()
    {
        return view('livewire.admin.registrasi.registrasi-edit');
    }

    #[On('registrasi-edit')]
    public function getRegistrasi($id)
    {
        $registrasi = Registrasi::find($id);

        $this->registrasi_id = $registrasi->id;
        $this->nama = $registrasi->nama;
        $this->nik = $registrasi->nik;
        $this->no_hp = $registrasi->no_hp;
        $this->email = $registrasi->email;
        $this->layanan_id = $registrasi->layanan_id;
        $this->tanggal = $registrasi->tanggal;
        $this->fungsi_bangunan = $registrasi->fungsi_bangunan;
        $this->alamat_tanah = $registrasi->alamat_tanah;
        $this->kel_tanah = $registrasi->kel_tanah;
        $this->kec_tanah = $registrasi->kec_tanah;
    }

    public function editRegistrasi()
    {
        $this->validate();

        $registrasi = Registrasi::find($this->registrasi_id);

        $registrasi->update([
            'nama' => $this->nama,
            'nik' => $this->nik,
            'no_hp' => $this->no_hp,
            'email' => $this->email,
            'tanggal' => $this->tanggal,
            'layanan_id' => $this->layanan_id,
            'fungsi_bangunan' => $this->fungsi_bangunan,
            'alamat_tanah' => $this->alamat_tanah,
            'kel_tanah' => $this->kel_tanah,
            'kec_tanah' => $this->kec_tanah
        ]);

        if($registrasi->permohonan()->count() > 0){
            $registrasi->permohonan()->update([
                'layanan_id' => $this->layanan_id,
            ]);
        }

        session()->flash('success', 'Data registrasi berhasil diupdate!');

        $this->redirectRoute('registrasi.index');
    }

    public function mount(){
        $this->layanans = Layanan::all();
    }
}
