<?php

namespace App\Livewire\Admin\Permohonan;

use App\Models\Permohonan;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Permohonan')]
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
