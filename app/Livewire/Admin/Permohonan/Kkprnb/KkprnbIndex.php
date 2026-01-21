<?php

namespace App\Livewire\Admin\Permohonan\Kkprnb;

use App\Models\Kkprnb;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Permohonan KKPR Non Berusaha')]
class KkprnbIndex extends Component
{
    use WithPagination;

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
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.admin.permohonan.kkprnb.kkprnb-index', [
            'kkprnb' => $kkprnb,
        ]);
    }
}
