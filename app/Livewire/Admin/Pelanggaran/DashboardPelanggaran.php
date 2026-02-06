<?php

namespace App\Livewire\Admin\Pelanggaran;

use App\Models\Pelanggaran;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Dashboard Pelanggaran')]
class DashboardPelanggaran extends Component
{
    public $rekap = [];
    public $year;

    public function mount()
    {
        $this->year = date('Y');
    }
    
    #[Layout('layouts.app-pelanggaran')]
    public function render()
    {
        $count_pelanggaran_year = Pelanggaran::whereYear('tgl_laporan', $this->year)->count();
        $count_pelanggaran = Pelanggaran::count();
        $count_pending = Pelanggaran::where('status', 'Pending')->count();
        $count_proses = Pelanggaran::where('status', 'Proses')->count();
        $count_selesai = Pelanggaran::where('status', 'Selesai')->count();

        $count_sumber_pengawasan = Pelanggaran::where('sumber_informasi_pelanggaran', 'Hasil Pengawasan dan Monitoring')->count();
        $count_sumber_masyarakat = Pelanggaran::where('sumber_informasi_pelanggaran', 'Laporan Masyarakat')->count();
        $count_sumber_penilaian = Pelanggaran::where('sumber_informasi_pelanggaran', 'Hasil Penilaian KKPR atau SKRK')->count();
        
        $this->rekap = [
            'count_pelanggaran_year' => $count_pelanggaran_year,
            'count_pelanggaran' => $count_pelanggaran,
            'count_pending' => $count_pending,
            'count_proses' => $count_proses,
            'count_selesai' => $count_selesai,
            'count_sumber_pengawasan' => $count_sumber_pengawasan,
            'count_sumber_masyarakat' => $count_sumber_masyarakat,
            'count_sumber_penilaian' => $count_sumber_penilaian
        ];
        
        return view('livewire.admin.pelanggaran.dashboard-pelanggaran', [
            'rekap' => $this->rekap
        ]);
    }
}
