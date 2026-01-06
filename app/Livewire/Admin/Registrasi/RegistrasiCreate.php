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

    #[Validate('required|min:0,max:16|numeric')]
    public $nik;

    #[Validate('required|email')]
    public $email;

    public function render()
    {
        return view('livewire.admin.registrasi.registrasi-create');
    }

    public function createRegistrasi(){
        $this->validate();

        // Generate unique 'kode' with gap reuse
        $year = date('Y');
        $month = date('m');
        $layanan_kode = Layanan::findOrFail($this->layanan_id)->kode;

        // Get all existing registrations for current year
        $existingRegistrasi = Registrasi::whereYear('created_at', $year)->pluck('kode');

        // Extract sequence numbers from existing codes
        $usedSequences = $existingRegistrasi->map(function($kode) {
            return (int) explode('-', $kode)[0];
        })->sort()->values()->toArray();

        // Find the smallest available sequence number
        $sequence = 1;
        if (!empty($usedSequences)) {
            // Check for gaps in the sequence
            for ($i = 1; $i <= max($usedSequences) + 1; $i++) {
                if (!in_array($i, $usedSequences)) {
                    $sequence = $i;
                    break;
                }
            }
        }

        $newKode = str_pad($sequence, 4, '0', STR_PAD_LEFT).'-'.$layanan_kode.'-'. $month .'-'. $year ;
        
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

        $this->dispatch('toast', [
            'type'    => 'success',
            'message' => 'Data registrasi berhasil ditambahkan!'
        ]);

        $this->reset('nama', 'nik', 'no_hp', 'email', 'tanggal', 'layanan_id', 'fungsi_bangunan', 'alamat_tanah', 'kel_tanah', 'kec_tanah');
        
        $this->dispatch('refresh-registrasi-list');

        $this->dispatch('trigger-close-modal');
    }

    public function mount(){
        $this->layanans = Layanan::orderBy('nama', 'ASC')->get();
    }
}
