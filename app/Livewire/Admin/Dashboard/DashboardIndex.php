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
        
        $count_skrk = Skrk::whereYear('created_at', $this->year)->count();
        $count_skrk_done = Skrk::whereYear('created_at', $this->year)->whereHas('permohonan', function($q) {
            $q->where('is_done', true);
        })->count();

        $count_itr = Itr::whereYear('created_at', $this->year)->count();
        $count_itr_done = Itr::whereYear('created_at', $this->year)->whereHas('permohonan', function($q) {
            $q->where('is_done', true);
        })->count();

        $count_kkprb = Kkprb::whereYear('created_at', $this->year)->count();
        $count_kkprb_done = Kkprb::whereYear('created_at', $this->year)->whereHas('permohonan', function($q) {
            $q->where('is_done', true);
        })->count();

        $count_kkprnb = Kkprnb::whereYear('created_at', $this->year)->count();
        $count_kkprnb_done = Kkprnb::whereYear('created_at', $this->year)->whereHas('permohonan', function($q) {
            $q->where('is_done', true);
        })->count();

        $count_total = $count_skrk + $count_itr + $count_kkprb + $count_kkprnb;
        $count_total_done = $count_skrk_done + $count_itr_done + $count_kkprb_done + $count_kkprnb_done;

        $monthly_counts = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthly_counts[] = Permohonan::whereYear('created_at', $this->year)
                ->whereMonth('created_at', $i)
                ->count();
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
                    'average_days' => $item->total_done > 0 ? round($item->total_days / $item->total_done, 2) : 0,
                ];
            })->toArray();

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
