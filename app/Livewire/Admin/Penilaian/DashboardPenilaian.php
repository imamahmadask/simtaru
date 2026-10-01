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

        $count_penilaian = Penilaian::count();

        $stats = Penilaian::whereYear('tanggal_penilaian', $this->year)
            ->selectRaw("
                COUNT(*) as count_penilaian_year,
                COALESCE(SUM(CASE WHEN jenis_penilaian = 'KKPR/KKKPR' THEN 1 ELSE 0 END), 0) as count_kkpr_kkkpr,
                COALESCE(SUM(CASE WHEN jenis_penilaian = 'PMP UMK' THEN 1 ELSE 0 END), 0) as count_pmp_umk,
                COALESCE(SUM(CASE WHEN jenis_penilaian = 'KKPR/KKKPR' AND analisa_penilaian = 'Sesuai Sebagian' THEN 1 ELSE 0 END), 0) as count_kkpr_sesuai_sebagian,
                COALESCE(SUM(CASE WHEN jenis_penilaian = 'KKPR/KKKPR' AND analisa_penilaian = 'Sesuai Seluruhnya' THEN 1 ELSE 0 END), 0) as count_kkpr_sesuai_seluruhnya,
                COALESCE(SUM(CASE WHEN jenis_penilaian = 'PMP UMK' AND analisa_penilaian = 'Sesuai Sebagian' THEN 1 ELSE 0 END), 0) as count_pmp_umk_sesuai_sebagian,
                COALESCE(SUM(CASE WHEN jenis_penilaian = 'PMP UMK' AND analisa_penilaian = 'Sesuai Seluruhnya' THEN 1 ELSE 0 END), 0) as count_pmp_umk_sesuai_seluruhnya
            ")
            ->first();

        $monthly_raw = Penilaian::whereYear('tanggal_penilaian', $this->year)
            ->selectRaw('MONTH(tanggal_penilaian) as month, COUNT(*) as total')
            ->groupBy('month')
            ->pluck('total', 'month');

        $monthly_counts = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthly_counts[] = (int) ($monthly_raw[$i] ?? 0);
        }

        $this->rekap = [
            'count_penilaian_year' => (int) ($stats->count_penilaian_year ?? 0),
            'count_penilaian' => $count_penilaian,
            'count_kkpr_kkkpr' => (int) ($stats->count_kkpr_kkkpr ?? 0),
            'count_pmp_umk' => (int) ($stats->count_pmp_umk ?? 0),
            'count_kkpr_sesuai_sebagian' => (int) ($stats->count_kkpr_sesuai_sebagian ?? 0),
            'count_kkpr_sesuai_seluruhnya' => (int) ($stats->count_kkpr_sesuai_seluruhnya ?? 0),
            'count_pmp_umk_sesuai_sebagian' => (int) ($stats->count_pmp_umk_sesuai_sebagian ?? 0),
            'count_pmp_umk_sesuai_seluruhnya' => (int) ($stats->count_pmp_umk_sesuai_seluruhnya ?? 0),
            'monthly_counts' => $monthly_counts
        ];
        
        return view('livewire.admin.penilaian.dashboard-penilaian', [
            'rekap' => $this->rekap,
            'years' => $years
        ]);
    }
}
