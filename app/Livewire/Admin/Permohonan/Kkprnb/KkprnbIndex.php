<?php

namespace App\Livewire\Admin\Permohonan\Kkprnb;

use App\Models\Kkprnb;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Permohonan KKPR Non Berusaha')]
class KkprnbIndex extends Component
{
    public $search = '';

    public function render()
    {
        $kkprnb = Kkprnb::with('layanan.permohonan.registrasi')
            ->whereHas('layanan', function($query) {
                        $query->where('kode', 'KKPRNB');
            })
            ->whereHas('registrasi', (function($query) {
                $query->where('kode', 'LIKE', '%'.$this->search.'%')
                ->orWhere('nama', 'LIKE', '%'.$this->search.'%');
            }))
            ->orderBy('created_at', 'desc')->get();

        return view('livewire.admin.permohonan.kkprnb.kkprnb-index', [
            'kkprnb' => $kkprnb,
        ]);
    }
}
