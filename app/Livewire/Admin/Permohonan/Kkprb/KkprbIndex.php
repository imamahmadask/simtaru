<?php

namespace App\Livewire\Admin\Permohonan\Kkprb;

use App\Models\Kkprb;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Permohonan KKPR Berusaha')]
class KkprbIndex extends Component
{
    use WithPagination;
    
    public $search = '';
    
    public function render()
    {
        $kkprb = Kkprb::with('layanan.permohonan.registrasi')
            ->whereHas('layanan', function($query) {
                        $query->where('kode', 'KKPRB');
            })
            ->whereHas('registrasi', (function($query) {
                $query->where('kode', 'LIKE', '%'.$this->search.'%')
                ->orWhere('nama', 'LIKE', '%'.$this->search.'%');
            }))
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.admin.permohonan.kkprb.kkprb-index', compact('kkprb'));
    }
}
