<?php

namespace App\Livewire\Admin\Permohonan;

use App\Models\Permohonan;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Permohonan')]
class PermohonanIndex extends Component
{
    public $search = '';
    public function render()
    {
        $permohonans = Permohonan::with('layanan.registrasi')
                        ->whereHas('registrasi', function($query) {
                            $query->where('nama', 'like', '%' . $this->search . '%')
                                ->orWhere('kode', 'like', '%' . $this->search . '%');
                        })
                        ->orderBy('created_at', 'desc')->get();

        return view('livewire.admin.permohonan.permohonan-index', [
            'permohonans' => $permohonans
        ]);
    }
}
