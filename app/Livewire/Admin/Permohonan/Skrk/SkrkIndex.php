<?php

namespace App\Livewire\Admin\Permohonan\Skrk;

use App\Models\Permohonan;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Permohonan SKRK')]
class SkrkIndex extends Component
{
    public function render()
    {
        $permohonans = Permohonan::with('layanan.registrasi')
                    ->whereHas('layanan', function($query) {
                        $query->where('kode', 'SKRK');
                    })
                    ->orderBy('created_at', 'desc')->get();

        return view('livewire.admin.permohonan.skrk.skrk-index', [
            'permohonans' => $permohonans
        ]);
    }
}
