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
        $count_pelimpahan = Pelanggaran::where('status', 'Pelimpahan Berkas')->whereYear('tgl_laporan', $this->year)->count();
        $count_on_progress = Pelanggaran::where('status', 'On Progress')->whereYear('tgl_laporan', $this->year)->count();
        $count_selesai = Pelanggaran::where('status', 'Selesai')->whereYear('tgl_laporan', $this->year)->count();

        $count_sumber_pengawasan = Pelanggaran::where('sumber_informasi_pelanggaran', 'Hasil Pengawasan dan Monitoring')->whereYear('tgl_laporan', $this->year)->count();
        $count_sumber_masyarakat = Pelanggaran::where('sumber_informasi_pelanggaran', 'Laporan Masyarakat')->whereYear('tgl_laporan', $this->year)->count();
        $count_sumber_penilaian = Pelanggaran::where('sumber_informasi_pelanggaran', 'Hasil Penilaian KKPR atau SKRK')->whereYear('tgl_laporan', $this->year)->count();

        $count_temuan_ada = Pelanggaran::where('temuan_pelanggaran', 'Ada Pelanggaran')->whereYear('tgl_laporan', $this->year)->count();
        $count_temuan_tidak_ada = Pelanggaran::where('temuan_pelanggaran', 'Tidak Ada Pelanggaran')->whereYear('tgl_laporan', $this->year)->count();
        
        $count_indikasi_tidak_memiliki_kkpr = Pelanggaran::where('jenis_indikasi_pelanggaran', 'Tidak Memiliki KKPR atau SKRK')->whereYear('tgl_laporan', $this->year)->count();
        $count_indikasi_tidak_memenuhi_ketentuan = Pelanggaran::where('jenis_indikasi_pelanggaran', 'Tidak Memenuhi Ketentuan Dalam KKPR/SKRK')->whereYear('tgl_laporan', $this->year)->count();
        $count_indikasi_menghalangi_akses = Pelanggaran::where('jenis_indikasi_pelanggaran', 'Menghalangi Akses Terhadap Kawasan Yang Ditetapkan Sebagai Milik Umum')->whereYear('tgl_laporan', $this->year)->count();
        $count_indikasi_tidak_memiliki_pbg = Pelanggaran::where('jenis_indikasi_pelanggaran', 'Tidak Memiliki Persetujuan Bangunan Gedung (PBG)')->whereYear('tgl_laporan', $this->year)->count();

        $monthly_counts = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthly_counts[] = Pelanggaran::whereYear('tgl_laporan', $this->year)
                ->whereMonth('tgl_laporan', $i)
                ->count();
        }

        $this->rekap = [
            'count_pelanggaran_year' => $count_pelanggaran_year,
            'count_pelanggaran' => $count_pelanggaran,
            'count_pelimpahan' => $count_pelimpahan,
            'count_on_progress' => $count_on_progress,
            'count_selesai' => $count_selesai,
            'count_sumber_pengawasan' => $count_sumber_pengawasan,
            'count_sumber_masyarakat' => $count_sumber_masyarakat,
            'count_sumber_penilaian' => $count_sumber_penilaian,
            'count_temuan_ada' => $count_temuan_ada,
            'count_temuan_tidak_ada' => $count_temuan_tidak_ada,
            'count_indikasi_tidak_memiliki_kkpr' => $count_indikasi_tidak_memiliki_kkpr,
            'count_indikasi_tidak_memenuhi_ketentuan' => $count_indikasi_tidak_memenuhi_ketentuan,
            'count_indikasi_menghalangi_akses' => $count_indikasi_menghalangi_akses,
            'count_indikasi_tidak_memiliki_pbg' => $count_indikasi_tidak_memiliki_pbg,
            'monthly_counts' => $monthly_counts
        ];
        
        return view('livewire.admin.pelanggaran.dashboard-pelanggaran', [
            'rekap' => $this->rekap
        ]);
    }
}
