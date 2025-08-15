<?php

namespace App\Livewire\Admin\Dashboard;

use App\Models\Layanan;
use App\Models\Permohonan;
use App\Models\Registrasi;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Dashboard')]
class DashboardIndex extends Component
{
    public $rekap = [];
    public function render()
    {
        $count_registrasi = Registrasi::count();
        $count_permohonan = Permohonan::count();
        $count_layanan = Layanan::count();
        $count_pending = Permohonan::where('status', 'pending')->count();

        $this->rekap = [
            'count_registrasi' => $count_registrasi,
            'count_permohonan' => $count_permohonan,
            'count_layanan' => $count_layanan,
            'count_pending' => $count_pending
        ];

        return view('livewire.admin.dashboard.dashboard-index',
        [
            'rekap' => $this->rekap
        ]);
    }
}
