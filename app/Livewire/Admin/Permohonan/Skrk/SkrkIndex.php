<?php

namespace App\Livewire\Admin\Permohonan\Skrk;

use App\Models\Permohonan;
use App\Models\Skrk;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Permohonan SKRK')]
class SkrkIndex extends Component
{
    use WithPagination;

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
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.admin.permohonan.skrk.skrk-index', [
            'skrk' => $skrk
        ]);
    }
}
