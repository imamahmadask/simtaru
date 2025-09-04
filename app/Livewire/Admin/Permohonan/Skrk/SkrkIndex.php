<?php

namespace App\Livewire\Admin\Permohonan\Skrk;

use App\Models\Permohonan;
use App\Models\Skrk;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Permohonan SKRK')]
class SkrkIndex extends Component
{
    public $search = '';

    public function render()
    {
        $skrk = Skrk::with('layanan.permohonan.registrasi')
            ->whereHas('layanan', function($query) {
                        $query->where('kode', 'SKRK');
            })
            ->whereHas('registrasi', (function($query) {
                $query->where('kode', 'LIKE', '%'.$this->search.'%')
                ->orWhere('nama', 'LIKE', '%'.$this->search.'%');
            }))
            ->orderBy('created_at', 'desc')->get();

        return view('livewire.admin.permohonan.skrk.skrk-index', [
            'skrk' => $skrk
        ]);
    }
}
