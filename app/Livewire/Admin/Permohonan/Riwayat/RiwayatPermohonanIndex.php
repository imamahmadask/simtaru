<?php

namespace App\Livewire\Admin\Permohonan\Riwayat;

use App\Models\RiwayatPermohonan;
use Livewire\Component;

class RiwayatPermohonanIndex extends Component
{
    public $permohonan;

    public function render()
    {
        $this->permohonan?->loadMissing('registrasi.riwayat.user');

        return view('livewire.admin.permohonan.riwayat.riwayat-permohonan-index');
    }
}
