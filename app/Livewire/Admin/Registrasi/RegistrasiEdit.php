<?php

namespace App\Livewire\Admin\Registrasi;

use App\Models\Layanan;
use App\Models\Registrasi;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class RegistrasiEdit extends Component
{
    public $registrasi_id, $layanans, $count_permohonan;

    #[Validate('required')]
    public $nama, $no_hp, $layanan_id, $tanggal, $fungsi_bangunan, $alamat_tanah, $kel_tanah, $kec_tanah;

    #[Validate('required|min:0,max:16|numeric')]
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
        $this->count_permohonan = $registrasi->permohonan()->count();
    }

    public function editRegistrasi()
    {
        $this->validate();

        $registrasi = Registrasi::find($this->registrasi_id);

        if($registrasi->permohonan()->count() == 0){
            if($registrasi->layanan_id != $this->layanan_id){
                $year = date('Y');
                $month = date('m');
                $lastSequence = (int) explode('-', $registrasi->kode)[0];
                $layanan_kode = Layanan::findOrFail($this->layanan_id)->kode;
                $newKode = str_pad($lastSequence, 4, '0', STR_PAD_LEFT).'-'.$layanan_kode.'-'. $month .'-'. $year ;
                
                $registrasi->update([
                    'kode' => $newKode
                ]);
            }            
        }
        
        $registrasi->update([
            'layanan_id' => $this->layanan_id,
            'nama' => $this->nama,
            'nik' => $this->nik,
            'no_hp' => $this->no_hp,
            'email' => $this->email,
            'tanggal' => $this->tanggal,
            'fungsi_bangunan' => $this->fungsi_bangunan,
            'alamat_tanah' => $this->alamat_tanah,
            'kel_tanah' => $this->kel_tanah,
            'kec_tanah' => $this->kec_tanah
        ]);      
        
        $this->dispatch('toast', [
            'type'    => 'success',
            'message' => 'Data registrasi berhasil diupdate!'
        ]);

        $this->reset('nama', 'nik', 'no_hp', 'email', 'tanggal', 'layanan_id', 'fungsi_bangunan', 'alamat_tanah', 'kel_tanah', 'kec_tanah');
        
        $this->dispatch('refresh-registrasi-list');

        $this->dispatch('trigger-close-modal');
        
    }

    public function mount(){
        $this->layanans = Layanan::orderBy('nama', 'asc')->get();
    }
}
