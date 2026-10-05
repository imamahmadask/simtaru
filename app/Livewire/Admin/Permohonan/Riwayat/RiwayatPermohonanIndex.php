<?php

namespace App\Livewire\Admin\Permohonan\Riwayat;

use App\Models\RiwayatPermohonan;
use Livewire\Attributes\On;
use Livewire\Component;

class RiwayatPermohonanIndex extends Component
{
    public $permohonan;

    #[On('refresh-riwayat-permohonan')]
    public function refreshRiwayat()
    {
        $this->permohonan?->load('registrasi.riwayat.user');
    }

    public function render()
    {
        $this->permohonan?->loadMissing('registrasi.riwayat.user');

        return view('livewire.admin.permohonan.riwayat.riwayat-permohonan-index');
    }
}
