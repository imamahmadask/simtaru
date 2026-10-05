<?php

namespace App\Livewire\Guest;

use App\Models\Registrasi;
use Livewire\Component;

class LacakBerkas extends Component
{
    public $no_reg;
    public $berkas;
    public $riwayats = [];    

    public function render()
    {
        return view('livewire.guest.lacak-berkas');
    }

    public function lacakBerkas()
    {        
        $this->berkas = Registrasi::with(['riwayat.user', 'permohonan'])->where('kode', $this->no_reg)->first();
        
        if ($this->berkas) {
            $this->riwayats = $this->berkas->riwayat;
        }
        else{
            $this->riwayats = [];
        }
    }
}
