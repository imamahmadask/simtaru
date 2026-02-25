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
        $years = Penilaian::whereNotNull('tanggal_penilaian')
            ->selectRaw('YEAR(tanggal_penilaian) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray();

        // Ensure current year is in the list
        if (!in_array(date('Y'), $years)) {
            $years[] = date('Y');
            rsort($years);
        }

        $query = Penilaian::whereYear('tanggal_penilaian', $this->year);

        $count_penilaian_year = (clone $query)->count();
        $count_penilaian = Penilaian::count();
        
        // count by jenis penilaian (filtered by year)
        $count_kkpr_kkkpr = (clone $query)->where('jenis_penilaian', 'KKPR/KKKPR')->count();
        $count_pmp_umk = (clone $query)->where('jenis_penilaian', 'PMP UMK')->count();

        // breakdowns (filtered by year)
        $count_kkpr_sesuai_sebagian = (clone $query)->where('jenis_penilaian', 'KKPR/KKKPR')->where('analisa_penilaian', 'Sesuai Sebagian')->count();
        $count_kkpr_sesuai_seluruhnya = (clone $query)->where('jenis_penilaian', 'KKPR/KKKPR')->where('analisa_penilaian', 'Sesuai Seluruhnya')->count();        
        $count_pmp_umk_sesuai_sebagian = (clone $query)->where('jenis_penilaian', 'PMP UMK')->where('analisa_penilaian', 'Sesuai Sebagian')->count();
        $count_pmp_umk_sesuai_seluruhnya = (clone $query)->where('jenis_penilaian', 'PMP UMK')->where('analisa_penilaian', 'Sesuai Seluruhnya')->count();        

        $monthly_counts = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthly_counts[] = Penilaian::whereYear('tanggal_penilaian', $this->year)
                ->whereMonth('tanggal_penilaian', $i)
                ->count();
        }

        $this->rekap = [
            'count_penilaian_year' => $count_penilaian_year,
            'count_penilaian' => $count_penilaian,
            'count_kkpr_kkkpr' => $count_kkpr_kkkpr,
            'count_pmp_umk' => $count_pmp_umk,
            'count_kkpr_sesuai_sebagian' => $count_kkpr_sesuai_sebagian,
            'count_kkpr_sesuai_seluruhnya' => $count_kkpr_sesuai_seluruhnya,
            'count_pmp_umk_sesuai_sebagian' => $count_pmp_umk_sesuai_sebagian,
            'count_pmp_umk_sesuai_seluruhnya' => $count_pmp_umk_sesuai_seluruhnya,
            'monthly_counts' => $monthly_counts
        ];
        
        return view('livewire.admin.penilaian.dashboard-penilaian', [
            'rekap' => $this->rekap,
            'years' => $years
        ]);
    }
}
