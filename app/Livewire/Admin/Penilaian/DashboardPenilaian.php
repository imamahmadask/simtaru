<?php

namespace App\Livewire\Admin\Penilaian;

use App\Models\Penilaian;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Dashboard Penilaian')]
class DashboardPenilaian extends Component
{
    public $rekap = [];
    public $year;

    public function mount()
    {
        $this->year = date('Y');
    }
    
    #[Layout('layouts.app-penilaian')]
    public function render()
    {
        $count_penilaian_year = Penilaian::whereYear('tanggal_penilaian', $this->year)->count();
        $count_penilaian = Penilaian::count();
        
        // Example breakdown by jenis_penilaian
        $count_kesesuaian = Penilaian::where('jenis_penilaian', 'Kesesuaian')->count();
        $count_kepatuhan = Penilaian::where('jenis_penilaian', 'Kepatuhan')->count();

        $this->rekap = [
            'count_penilaian_year' => $count_penilaian_year,
            'count_penilaian' => $count_penilaian,
            'count_kesesuaian' => $count_kesesuaian,
            'count_kepatuhan' => $count_kepatuhan,
        ];
        
        return view('livewire.admin.penilaian.dashboard-penilaian', [
            'rekap' => $this->rekap
        ]);
    }
}
