<?php

namespace App\Livewire\Admin\Dashboard;

use App\Models\Disposisi;
use App\Models\Itr;
use App\Models\Kkprb;
use App\Models\Kkprnb;
use App\Models\Layanan;
use App\Models\Pengaduan;
use App\Models\Permohonan;
use App\Models\Registrasi;
use App\Models\Skrk;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

#[Title('Dashboard')]
class DashboardIndex extends Component
{
    use WithPagination, WithoutUrlPagination;
    
    protected $paginationTheme = 'bootstrap';
    public $rekap = [];
    #[Url]
    public $year;

    public function render()
    {
        $count_registrasi = Registrasi::whereYear('created_at', $this->year)->count();
        $count_permohonan = Permohonan::whereYear('created_at', $this->year)->count();
        $count_layanan = Layanan::count();
        $count_pengaduan = Pengaduan::whereYear('created_at', $this->year)->count();
        
        $skrkStats = Skrk::whereYear('skrk.created_at', $this->year)
            ->leftJoin('permohonan', function ($join) {
                $join->on('skrk.permohonan_id', '=', 'permohonan.id')
                    ->whereNull('permohonan.deleted_at');
            })
            ->selectRaw('COUNT(*) as total, COALESCE(SUM(CASE WHEN permohonan.is_done = 1 THEN 1 ELSE 0 END), 0) as done')
            ->first();
        $count_skrk = (int) ($skrkStats->total ?? 0);
        $count_skrk_done = (int) ($skrkStats->done ?? 0);

        $itrStats = Itr::whereYear('itr.created_at', $this->year)
            ->leftJoin('permohonan', function ($join) {
                $join->on('itr.permohonan_id', '=', 'permohonan.id')
                    ->whereNull('permohonan.deleted_at');
            })
            ->selectRaw('COUNT(*) as total, COALESCE(SUM(CASE WHEN permohonan.is_done = 1 THEN 1 ELSE 0 END), 0) as done')
            ->first();
        $count_itr = (int) ($itrStats->total ?? 0);
        $count_itr_done = (int) ($itrStats->done ?? 0);

        $kkprbStats = Kkprb::whereYear('kkprb.created_at', $this->year)
            ->leftJoin('permohonan', function ($join) {
                $join->on('kkprb.permohonan_id', '=', 'permohonan.id')
                    ->whereNull('permohonan.deleted_at');
            })
            ->selectRaw('COUNT(*) as total, COALESCE(SUM(CASE WHEN permohonan.is_done = 1 THEN 1 ELSE 0 END), 0) as done')
            ->first();
        $count_kkprb = (int) ($kkprbStats->total ?? 0);
        $count_kkprb_done = (int) ($kkprbStats->done ?? 0);

        $kkprnbStats = Kkprnb::whereYear('kkprnb.created_at', $this->year)
            ->leftJoin('permohonan', function ($join) {
                $join->on('kkprnb.permohonan_id', '=', 'permohonan.id')
                    ->whereNull('permohonan.deleted_at');
            })
            ->selectRaw('COUNT(*) as total, COALESCE(SUM(CASE WHEN permohonan.is_done = 1 THEN 1 ELSE 0 END), 0) as done')
            ->first();
        $count_kkprnb = (int) ($kkprnbStats->total ?? 0);
        $count_kkprnb_done = (int) ($kkprnbStats->done ?? 0);

        $count_total = $count_skrk + $count_itr + $count_kkprb + $count_kkprnb;
        $count_total_done = $count_skrk_done + $count_itr_done + $count_kkprb_done + $count_kkprnb_done;

        $monthly_raw = Permohonan::whereYear('created_at', $this->year)
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->groupBy('month')
            ->pluck('total', 'month');

        $monthly_counts = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthly_counts[] = (int) ($monthly_raw[$i] ?? 0);
        }

        $stats_layanan = Permohonan::whereYear('permohonan.created_at', $this->year)
            ->where('permohonan.is_done', true)
            ->join('layanan', 'permohonan.layanan_id', '=', 'layanan.id')
            ->selectRaw('layanan.nama as layanan_nama, 
                         layanan.kode as layanan_kode,
                         sum(waktu_pengerjaan) as total_days, 
                         count(*) as total_done')
            ->groupBy('layanan.id', 'layanan.nama', 'layanan.kode')
            ->get()
            ->map(function($item) {
                return [
                    'layanan_nama' => $item->layanan_nama,
                    'layanan_kode' => $item->layanan_kode,
                    'total_days' => (float)$item->total_days,
                    'total_done' => (int)$item->total_done,
                    'average_days' => $item->total_done > 0 ? round($item->total_days / $item->total_done) : 0,
                ];
            })->toArray();

        $total_days_all = collect($stats_layanan)->sum('total_days');
        $average_days_all = $count_total_done > 0 ? round($total_days_all / $count_total_done) : 0;

        $this->rekap = [
            'count_registrasi' => $count_registrasi,
            'count_permohonan' => $count_permohonan,
            'count_layanan' => $count_layanan,
            'count_pengaduan' => $count_pengaduan,
            'count_kkprb' => $count_kkprb,
            'count_kkprb_done' => $count_kkprb_done,
            'count_kkprnb' => $count_kkprnb,
            'count_kkprnb_done' => $count_kkprnb_done,
            'count_itr' => $count_itr,
            'count_itr_done' => $count_itr_done,
            'count_skrk' => $count_skrk,
            'count_skrk_done' => $count_skrk_done,
            'count_total' => $count_total,
            'count_total_done' => $count_total_done,
            'monthly_counts' => $monthly_counts,
            'stats_layanan' => $stats_layanan,
            'total_days_all' => $total_days_all,
            'average_days_all' => $average_days_all,
        ];

        $latestPermohonans = Permohonan::with(['registrasi', 'disposisi.tahapan', 'disposisi.penerima'])
                            ->whereYear('created_at', $this->year)
                            ->orderBy('created_at', 'desc')
                            ->paginate(10);

        $minYearDate = Permohonan::min('created_at');
        $minYear = $minYearDate ? date('Y', strtotime($minYearDate)) : date('Y');
        $years = range(date('Y'), min($minYear, (int)date('Y')));

        return view('livewire.admin.dashboard.dashboard-index',
        [
            'rekap' => $this->rekap,
            'latestPermohonans' => $latestPermohonans,
            'years' => $years
        ]);
    }

    public function mount()
    {
        $this->year = date('Y');
    }
}
