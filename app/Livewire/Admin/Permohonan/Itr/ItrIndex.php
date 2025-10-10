<?php

namespace App\Livewire\Admin\Permohonan\Itr;

use App\Models\Itr;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Permohonan ITR')]
class ItrIndex extends Component
{
    public $search = '';

    public function render()
    {
        $itr = Itr::with('layanan.permohonan.registrasi')
            ->whereHas('layanan', function($query) {
                        $query->where('kode', 'SKRK');
            })
            ->whereHas('registrasi', (function($query) {
                $query->where('kode', 'LIKE', '%'.$this->search.'%')
                ->orWhere('nama', 'LIKE', '%'.$this->search.'%');
            }))
            ->orderBy('created_at', 'desc')->get();

        return view('livewire.admin.permohonan.itr.itr-index');
    }
}
