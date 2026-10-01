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
        $count_pelanggaran = Pelanggaran::count();

        $stats = Pelanggaran::whereYear('tgl_laporan', $this->year)
            ->selectRaw("
                COUNT(*) as count_pelanggaran_year,
                COALESCE(SUM(CASE WHEN status = 'Pelimpahan Berkas' THEN 1 ELSE 0 END), 0) as count_pelimpahan,
                COALESCE(SUM(CASE WHEN status = 'On Progress' THEN 1 ELSE 0 END), 0) as count_on_progress,
                COALESCE(SUM(CASE WHEN status = 'Selesai' THEN 1 ELSE 0 END), 0) as count_selesai,
                COALESCE(SUM(CASE WHEN sumber_informasi_pelanggaran = 'Hasil Pengawasan dan Monitoring' THEN 1 ELSE 0 END), 0) as count_sumber_pengawasan,
                COALESCE(SUM(CASE WHEN sumber_informasi_pelanggaran = 'Laporan Masyarakat' THEN 1 ELSE 0 END), 0) as count_sumber_masyarakat,
                COALESCE(SUM(CASE WHEN sumber_informasi_pelanggaran = 'Hasil Penilaian KKPR atau SKRK' THEN 1 ELSE 0 END), 0) as count_sumber_penilaian,
                COALESCE(SUM(CASE WHEN temuan_pelanggaran = 'Ada Pelanggaran' THEN 1 ELSE 0 END), 0) as count_temuan_ada,
                COALESCE(SUM(CASE WHEN temuan_pelanggaran = 'Tidak Ada Pelanggaran' THEN 1 ELSE 0 END), 0) as count_temuan_tidak_ada,
                COALESCE(SUM(CASE WHEN jenis_indikasi_pelanggaran = 'Tidak Memiliki KKPR atau SKRK' THEN 1 ELSE 0 END), 0) as count_indikasi_tidak_memiliki_kkpr,
                COALESCE(SUM(CASE WHEN jenis_indikasi_pelanggaran = 'Tidak Memenuhi Ketentuan Dalam KKPR/SKRK' THEN 1 ELSE 0 END), 0) as count_indikasi_tidak_memenuhi_ketentuan,
                COALESCE(SUM(CASE WHEN jenis_indikasi_pelanggaran = 'Menghalangi Akses Terhadap Kawasan Yang Ditetapkan Sebagai Milik Umum' THEN 1 ELSE 0 END), 0) as count_indikasi_menghalangi_akses,
                COALESCE(SUM(CASE WHEN jenis_indikasi_pelanggaran = 'Tidak Memiliki Persetujuan Bangunan Gedung (PBG)' THEN 1 ELSE 0 END), 0) as count_indikasi_tidak_memiliki_pbg
            ")
            ->first();

        $monthly_raw = Pelanggaran::whereYear('tgl_laporan', $this->year)
            ->selectRaw('MONTH(tgl_laporan) as month, COUNT(*) as total')
            ->groupBy('month')
            ->pluck('total', 'month');

        $monthly_counts = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthly_counts[] = (int) ($monthly_raw[$i] ?? 0);
        }

        $this->rekap = [
            'count_pelanggaran_year' => (int) ($stats->count_pelanggaran_year ?? 0),
            'count_pelanggaran' => $count_pelanggaran,
            'count_pelimpahan' => (int) ($stats->count_pelimpahan ?? 0),
            'count_on_progress' => (int) ($stats->count_on_progress ?? 0),
            'count_selesai' => (int) ($stats->count_selesai ?? 0),
            'count_sumber_pengawasan' => (int) ($stats->count_sumber_pengawasan ?? 0),
            'count_sumber_masyarakat' => (int) ($stats->count_sumber_masyarakat ?? 0),
            'count_sumber_penilaian' => (int) ($stats->count_sumber_penilaian ?? 0),
            'count_temuan_ada' => (int) ($stats->count_temuan_ada ?? 0),
            'count_temuan_tidak_ada' => (int) ($stats->count_temuan_tidak_ada ?? 0),
            'count_indikasi_tidak_memiliki_kkpr' => (int) ($stats->count_indikasi_tidak_memiliki_kkpr ?? 0),
            'count_indikasi_tidak_memenuhi_ketentuan' => (int) ($stats->count_indikasi_tidak_memenuhi_ketentuan ?? 0),
            'count_indikasi_menghalangi_akses' => (int) ($stats->count_indikasi_menghalangi_akses ?? 0),
            'count_indikasi_tidak_memiliki_pbg' => (int) ($stats->count_indikasi_tidak_memiliki_pbg ?? 0),
            'monthly_counts' => $monthly_counts
        ];
        
        return view('livewire.admin.pelanggaran.dashboard-pelanggaran', [
            'rekap' => $this->rekap
        ]);
    }
}
