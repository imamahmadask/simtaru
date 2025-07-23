<?php

namespace App\Livewire\Admin\Permohonan;

use App\Models\Permohonan;
use Livewire\Component;

class PermohonanIndex extends Component
{
    public function render()
    {
        $permohonans = Permohonan::with('layanan.registrasi')->get();

        return view('livewire.admin.permohonan.permohonan-index', [
            'permohonans' => $permohonans
        ]);
    }
}
