<?php

namespace App\Livewire\Admin\Registrasi;

use App\Models\Layanan;
use App\Models\Registrasi;
use App\Models\RiwayatPermohonan;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;

class RegistrasiCreate extends Component
{
    public $layanans;

    #[Validate('required')]
    public $nama, $no_hp, $layanan_id, $tanggal, $fungsi_bangunan, $alamat_tanah, $kel_tanah, $kec_tanah;

    #[Validate('required|min:16,max:16|numeric')]
    public $nik;

    #[Validate('required|email')]
    public $email;

    public function render()
    {
        return view('livewire.admin.registrasi.registrasi-create');
    }

    public function createRegistrasi(){
        $this->validate();

        // Generate unique 'kode'
        $year = date('Y');
        $month = date('m');
        $latestRegistrasi = Registrasi::whereYear('created_at', $year)->latest('id')->first();
        $sequence = 1;
        if ($latestRegistrasi) {
            $lastSequence = (int) substr($latestRegistrasi->kode, -4);
            $sequence = $lastSequence + 1;
        }
        $layanan_kode = Layanan::findOrFail($this->layanan_id)->kode;
        $newKode = 'REG-' .str_pad($sequence, 4, '0', STR_PAD_LEFT).'-'.$layanan_kode.'-'. $month .'-'. $year ;

        Registrasi::create([
           'kode' => $newKode,
           'nama' => $this->nama,
           'nik' => $this->nik,
           'no_hp' => $this->no_hp,
           'tanggal' => $this->tanggal,
           'layanan_id' => $this->layanan_id,
           'created_by' => Auth::user()->id,
           'email' => $this->email,
           'fungsi_bangunan' => $this->fungsi_bangunan,
           'alamat_tanah' => $this->alamat_tanah,
           'kel_tanah' => $this->kel_tanah,
           'kec_tanah' => $this->kec_tanah
        ]);
        $registrasi = Registrasi::latest()->first();

        RiwayatPermohonan::create([
            'registrasi_id' => $registrasi->id,
            'user_id' => Auth::user()->id,
            'keterangan' => 'Entry Registrasi'
        ]);

        session()->flash('success', 'Registrasi berhasil ditambahkan!');

        $this->redirectRoute('registrasi.index');
    }

    public function mount(){
        $this->layanans = Layanan::all();
    }
}
