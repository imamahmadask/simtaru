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
        
        // count by jenis penilaian
        $count_kkpr_kkkpr = Penilaian::where('jenis_penilaian', 'KKPR/KKKPR')->count();
        $count_pmp_umk = Penilaian::where('jenis_penilaian', 'PMP UMK')->count();

        // Example breakdown by analisa_penilaian
        $count_kkpr_sesuai_sebagian = Penilaian::where('jenis_penilaian', 'KKPR/KKKPR')->where('analisa_penilaian', 'Sesuai Sebagian')->count();
        $count_kkpr_sesuai_seluruhnya = Penilaian::where('jenis_penilaian', 'KKPR/KKKPR')->where('analisa_penilaian', 'Sesuai Seluruhnya')->count();        
        $count_pmp_umk_sesuai_sebagian = Penilaian::where('jenis_penilaian', 'PMP UMK')->where('analisa_penilaian', 'Sesuai Sebagian')->count();
        $count_pmp_umk_sesuai_seluruhnya = Penilaian::where('jenis_penilaian', 'PMP UMK')->where('analisa_penilaian', 'Sesuai Seluruhnya')->count();        

        $this->rekap = [
            'count_penilaian_year' => $count_penilaian_year,
            'count_penilaian' => $count_penilaian,
            'count_kkpr_kkkpr' => $count_kkpr_kkkpr,
            'count_pmp_umk' => $count_pmp_umk,
            'count_kkpr_sesuai_sebagian' => $count_kkpr_sesuai_sebagian,
            'count_kkpr_sesuai_seluruhnya' => $count_kkpr_sesuai_seluruhnya,
            'count_pmp_umk_sesuai_sebagian' => $count_pmp_umk_sesuai_sebagian,
            'count_pmp_umk_sesuai_seluruhnya' => $count_pmp_umk_sesuai_seluruhnya,
        ];
        
        return view('livewire.admin.penilaian.dashboard-penilaian', [
            'rekap' => $this->rekap
        ]);
    }
}
