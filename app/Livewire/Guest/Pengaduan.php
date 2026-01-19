<?php

namespace App\Livewire\Guest;

use App\Models\Pengaduan as PengaduanModel;
use Livewire\Attributes\Validate;   
use Livewire\Component;

class Pengaduan extends Component
{
    #[Validate('required', message: 'Jenis harus diisi')]
    public $jenis;
    
    #[Validate('required', message: 'Nama harus diisi')]
    public $nama;
    
    #[Validate('required', message: 'Alamat harus diisi')]
    public $alamat;
    
    #[Validate('required', message: 'No. Telepon / WhatsApp harus diisi')]
    public $no_hp;
    
    #[Validate('required', message: 'Isi Pengaduan harus diisi')]
    public $pengaduan;
    
    public function render()
    {
        return view('livewire.guest.pengaduan');
    }

    public function submitPengaduan()
    {
        $this->validate();

        PengaduanModel::create([
            'jenis' => $this->jenis,
            'nama' => $this->nama,
            'alamat' => $this->alamat,
            'no_hp' => $this->no_hp,
            'pengaduan' => $this->pengaduan,
        ]);

        $this->reset([
            'jenis',
            'nama',
            'alamat',
            'no_hp',
            'pengaduan',
        ]);

        $this->dispatch('close-modal-pengaduan', message: 'Pengaduan berhasil dikirim! Kami akan segera menindaklanjuti.');
    }
}
