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
use Livewire\Component;

#[Title('Dashboard')]
class DashboardIndex extends Component
{
    public $rekap = [];
    public $year;

    public function render()
    {
        $count_registrasi = Registrasi::count();
        $count_permohonan = Permohonan::count();
        $count_layanan = Layanan::count();
        $count_pengaduan = Pengaduan::count();
        $count_kkprb = Kkprb::count();
        $count_kkprnb = Kkprnb::count();
        $count_itr = Itr::count();
        $count_skrk = Skrk::count();

        $this->rekap = [
            'count_registrasi' => $count_registrasi,
            'count_permohonan' => $count_permohonan,
            'count_layanan' => $count_layanan,
            'count_pengaduan' => $count_pengaduan,
            'count_kkprb' => $count_kkprb,
            'count_kkprnb' => $count_kkprnb,
            'count_itr' => $count_itr,
            'count_skrk' => $count_skrk
        ];

        $latestPermohonans = Permohonan::with(['registrasi', 'disposisi.tahapan'])
                            ->orderBy('created_at', 'desc')
                            ->limit(10)
                            ->get();

        return view('livewire.admin.dashboard.dashboard-index',
        [
            'rekap' => $this->rekap,
            'latestPermohonans' => $latestPermohonans
        ]);
    }

    public function mount()
    {
        $this->year = date('Y');
    }
}
