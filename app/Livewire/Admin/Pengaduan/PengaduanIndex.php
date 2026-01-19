<?php

namespace App\Livewire\Admin\Pengaduan;

use App\Models\Pengaduan;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Pengaduan')]
class PengaduanIndex extends Component
{
    public function render()
    {
        $pengaduan = Pengaduan::all();
        
        return view('livewire.admin.pengaduan.pengaduan-index', compact('pengaduan'));
    }
}
