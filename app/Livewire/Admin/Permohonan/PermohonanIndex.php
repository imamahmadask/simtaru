<?php

namespace App\Livewire\Admin\Permohonan;

use App\Models\Layanan;
use App\Models\Permohonan;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Permohonan')]
class PermohonanIndex extends Component
{
    public $search = '';
    public $filterLayanan = '';
    public $filterStatus = '';
    public $layanans;
    public function render()
    {
        $permohonans = Permohonan::with('layanan.registrasi')
                        ->whereHas('layanan', function($query) {
                            $query->where('id', 'like', '%'.$this->filterLayanan.'%');
                        })
                        ->whereHas('registrasi', function($query) {
                            $query->where('nama', 'like', '%' . $this->search . '%')
                                ->orWhere('kode', 'like', '%' . $this->search . '%');
                        })
                        ->where('status', 'like', '%' . $this->filterStatus . '%')
                        ->orderBy('created_at', 'desc')->get();

        return view('livewire.admin.permohonan.permohonan-index', [
            'permohonans' => $permohonans
        ]);
    }

    public function mount()
    {
        $this->layanans = Layanan::all();
    }
}
