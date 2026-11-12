<?php

namespace App\Livewire\Admin\Pelanggaran;

use App\Models\Pelanggaran;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\WithPagination;

#[Title('Pelanggaran')]
class PelanggaranIndex extends Component
{
    use WithPagination;

    #[Url(except: '')]
    public $search = '';

    #[Url(except: '')]
    public $filterStatus = '';

    #[Url(except: '')]
    public $filterTemuan = '';

    #[Url(except: '')]
    public $filterKecamatan = '';

    #[Url(except: '')]
    public $filterYear = '';

    #[Url(except: '')]
    public $filterSumber = '';

    #[Url(except: '')]
    public $filterTindakLanjut = '';

    #[Url(except: '')]
    public $filterKlasifikasi = '';

    #[Url(except: 10)]
    public $perPage = 10;

    public $selectedPelanggaran;
    public $showSaranModal = false;

    public function updated($propertyName)
    {
        if (str_starts_with($propertyName, 'filter') || in_array($propertyName, ['search', 'perPage'])) {
            $this->resetPage();
        }
    }

    public function resetFilters()
    {
        $this->reset([
            'search',
            'filterStatus',
            'filterTemuan',
            'filterKecamatan',
            'filterYear',
            'filterSumber',
            'filterTindakLanjut',
            'filterKlasifikasi',
        ]);
        $this->perPage = 10;
        $this->resetPage();
    }

    public function getActiveFilterCountProperty(): int
    {
        $count = 0;
        if (filled($this->search)) $count++;
        if (filled($this->filterStatus)) $count++;
        if (filled($this->filterTemuan)) $count++;
        if (filled($this->filterKecamatan)) $count++;
        if (filled($this->filterYear)) $count++;
        if (filled($this->filterSumber)) $count++;
        if (filled($this->filterTindakLanjut)) $count++;
        if (filled($this->filterKlasifikasi)) $count++;
        return $count;
    }

    #[On('refresh')]
    #[Layout('layouts.app-pelanggaran')]
    public function render()
    {
        $pelanggarans = Pelanggaran::query()
            ->withCount('sarans')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('no_pelanggaran', 'like', '%' . $this->search . '%')
                        ->orWhere('nama_pelanggar', 'like', '%' . $this->search . '%')
                        ->orWhere('nama_pemilik_perusahaan', 'like', '%' . $this->search . '%')
                        ->orWhere('alamat_pelanggaran', 'like', '%' . $this->search . '%')
                        ->orWhere('kel_pelanggaran', 'like', '%' . $this->search . '%')
                        ->orWhere('kec_pelanggaran', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterStatus, fn($q) => $q->where('status', $this->filterStatus))
            ->when($this->filterTemuan, fn($q) => $q->where('temuan_pelanggaran', $this->filterTemuan))
            ->when($this->filterKecamatan, fn($q) => $q->where('kec_pelanggaran', $this->filterKecamatan))
            ->when($this->filterYear, fn($q) => $q->whereYear('tgl_laporan', $this->filterYear))
            ->when($this->filterSumber, fn($q) => $q->where('sumber_informasi_pelanggaran', $this->filterSumber))
            ->when($this->filterTindakLanjut, fn($q) => $q->where('tindak_lanjut', $this->filterTindakLanjut))
            ->when($this->filterKlasifikasi, function ($q) {
                if ($this->filterKlasifikasi === 'belum_dianalisis') {
                    $q->whereNull('klasifikasi_pelanggaran');
                } else {
                    $q->where('klasifikasi_pelanggaran', $this->filterKlasifikasi);
                }
            })
            ->latest('tgl_laporan')
            ->latest('id')
            ->paginate($this->perPage);

        $driver = DB::connection()->getDriverName();
        $yearExpr = $driver === 'sqlite' ? "strftime('%Y', tgl_laporan) as year" : "YEAR(tgl_laporan) as year";

        $years = Pelanggaran::selectRaw($yearExpr)
            ->whereNotNull('tgl_laporan')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->filter()
            ->values();

        $kecamatans = Pelanggaran::select('kec_pelanggaran')
            ->whereNotNull('kec_pelanggaran')
            ->where('kec_pelanggaran', '!=', '')
            ->distinct()
            ->orderBy('kec_pelanggaran')
            ->pluck('kec_pelanggaran');

        $tindakLanjuts = Pelanggaran::select('tindak_lanjut')
            ->whereNotNull('tindak_lanjut')
            ->where('tindak_lanjut', '!=', '')
            ->distinct()
            ->orderBy('tindak_lanjut')
            ->pluck('tindak_lanjut');

        $sumberInformasis = Pelanggaran::select('sumber_informasi_pelanggaran')
            ->whereNotNull('sumber_informasi_pelanggaran')
            ->where('sumber_informasi_pelanggaran', '!=', '')
            ->distinct()
            ->orderBy('sumber_informasi_pelanggaran')
            ->pluck('sumber_informasi_pelanggaran');

        return view('livewire.admin.pelanggaran.pelanggaran-index', compact(
            'pelanggarans',
            'years',
            'kecamatans',
            'tindakLanjuts',
            'sumberInformasis'
        ));
    }

    public function openSaranModal($id)
    {
        $this->selectedPelanggaran = Pelanggaran::with('sarans')->findOrFail($id);
        $this->showSaranModal = true;
        $this->dispatch('open-modal-saran-admin');
    }

    public function closeSaranModal()
    {
        $this->showSaranModal = false;
        $this->selectedPelanggaran = null;
    }

    public function deletePelanggaran($id)
    {
        if (!in_array(Auth::user()->role, ['superadmin', 'admin-pelanggaran'])) {
            abort(403);
        }

        $pelanggaran = Pelanggaran::findOrFail($id);

        // Collect all file paths to delete
        $documentFiles = [
            $pelanggaran->dokumen_penilaian_kkpr,
            $pelanggaran->bukti_perizinan,
            $pelanggaran->file_kkpr_skrk,
            $pelanggaran->file_pbg_imb,
            $pelanggaran->file_nib_kbli,
            $pelanggaran->file_sp1,
            $pelanggaran->file_sp2,
            $pelanggaran->file_sp3,
            $pelanggaran->file_pelimpahan_polpp,
            $pelanggaran->file_pernyataan,
            $pelanggaran->file_sosialisasi,
            $pelanggaran->file_ba_pengambilan_dokumen,
            $pelanggaran->file_ba_penolakan,
            $pelanggaran->file_ba_survey,
            $pelanggaran->file_ba_survey_surveyor,
            $pelanggaran->file_ba_wawancara,
            $pelanggaran->file_ba_penerapan_sanksi,
            $pelanggaran->file_ba_sosialisasi,
            $pelanggaran->file_sk_sanksi_pemberhentian,
        ];

        $filesToDelete = array_merge(
            (array) $pelanggaran->foto_pengawasan,
            (array) $pelanggaran->foto_tindak_lanjut,
            (array) $pelanggaran->foto_existing,
            $documentFiles
        );

        // Delete files from storage
        Storage::disk('public')->delete(array_filter($filesToDelete));
        
        // Also ensure the directory is cleaned up
        if ($pelanggaran->no_pelanggaran) {
            $safeFolder = str_replace('/', '-', $pelanggaran->no_pelanggaran);
            Storage::disk('public')->deleteDirectory('pelanggaran/' . $safeFolder);
            Storage::disk('public')->deleteDirectory('pelanggaran/' . $pelanggaran->no_pelanggaran);
        }

        $pelanggaran->delete();

        session()->flash('success', 'Data berhasil dihapus');

        return redirect()->route('pelanggaran.index');
    }
}
