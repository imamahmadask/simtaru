<?php

namespace App\Livewire\Admin\Pelanggaran;

use App\Models\Pelanggaran;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\WithPagination;

#[Title('Pelanggaran')]
class PelanggaranIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedPelanggaran;
    public $showSaranModal = false;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    #[On('refresh')]
    #[Layout('layouts.app-pelanggaran')]
    public function render()
    {
        $pelanggarans = Pelanggaran::query()
            ->withCount('sarans')
            ->when($this->search, function ($query) {
                $query->where('no_pelanggaran', 'like', '%' . $this->search . '%')
                    ->orWhere('nama_pelanggar', 'like', '%' . $this->search . '%')
                    ->orWhere('nama_pemilik_perusahaan', 'like', '%' . $this->search . '%')
                    ->orWhere('alamat_pelanggaran', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);

        return view('livewire.admin.pelanggaran.pelanggaran-index', compact('pelanggarans'));
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
