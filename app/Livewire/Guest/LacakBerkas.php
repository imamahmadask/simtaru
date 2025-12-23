<?php

namespace App\Livewire\Guest;

use App\Models\Registrasi;
use Livewire\Component;

class LacakBerkas extends Component
{
    public $no_reg;
    public $riwayats = [];    

    public function render()
    {
        return view('livewire.guest.lacak-berkas');
    }

    public function lacakBerkas()
    {        
        $berkas = Registrasi::where('kode', $this->no_reg)->first();
        
        if ($berkas) {
            $this->riwayats = $berkas->riwayat;           
            $this->reset('no_reg');
        }
        else{
            $this->riwayats = [];
        }

    }
}
