<?php

namespace App\Livewire\Admin\Penilaian;

use App\Models\Penilaian;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\WithPagination;

#[Title('Penilaian')]
class PenilaianIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $filterYear = '';
    public $filterJenis = '';
    public $filterAnalisa = '';
    public $selectedPenilaian;
    public $showSaranModal = false;

    protected $listeners = ['refresh' => '$refresh'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterYear()
    {
        $this->resetPage();
    }

    public function updatingFilterJenis()
    {
        $this->resetPage();
    }

    public function updatingFilterAnalisa()
    {
        $this->resetPage();
    }

    #[Layout('layouts.app-penilaian')]
    public function render()
    {
        $penilaians = Penilaian::query()
            ->withCount('sarans')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('nomor_dokumen', 'like', '%' . $this->search . '%')
                        ->orWhere('nama_pelaku_usaha', 'like', '%' . $this->search . '%')
                        ->orWhere('nama_usaha', 'like', '%' . $this->search . '%')
                        ->orWhere('alamat_lokasi_usaha', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterYear, function ($query) {
                $query->whereYear('tanggal_penilaian', $this->filterYear);
            })
            ->when($this->filterJenis, function ($query) {
                $query->where('jenis_penilaian', $this->filterJenis);
            })
            ->when($this->filterAnalisa, function ($query) {
                $query->where('analisa_penilaian', $this->filterAnalisa);
            })
            ->latest()
            ->paginate(10);

        $years = Penilaian::selectRaw('YEAR(tanggal_penilaian) as year')
            ->whereNotNull('tanggal_penilaian')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        $jenisPenilaians = Penilaian::select('jenis_penilaian')
            ->whereNotNull('jenis_penilaian')
            ->distinct()
            ->orderBy('jenis_penilaian')
            ->pluck('jenis_penilaian');

        $analisas = Penilaian::select('analisa_penilaian')
            ->whereNotNull('analisa_penilaian')
            ->where('analisa_penilaian', '!=', '')
            ->distinct()
            ->orderBy('analisa_penilaian')
            ->pluck('analisa_penilaian');

        return view('livewire.admin.penilaian.penilaian-index', compact('penilaians', 'years', 'jenisPenilaians', 'analisas'));
    }

    public function openSaranModal($id)
    {
        $this->selectedPenilaian = Penilaian::with('sarans')->findOrFail($id);
        $this->showSaranModal = true;
        $this->dispatch('open-modal-saran-admin');
    }

    public function closeSaranModal()
    {
        $this->showSaranModal = false;
        $this->selectedPenilaian = null;
    }

    public function deletePenilaian($id)
    {
        $penilaian = Penilaian::findOrFail($id);

        if ($penilaian->file_dokumen) {
            Storage::disk('public')->delete($penilaian->file_dokumen);
        }
        
        // Ensure the directory is cleaned up if it was stored in a specific path
        if ($penilaian->nomor_dokumen) {
            $folder = 'penilaian/' . str_replace(['/', '\\'], '_', $penilaian->nomor_dokumen);
            Storage::disk('public')->deleteDirectory($folder);
        }

        $penilaian->delete();

        session()->flash('success', 'Data berhasil dihapus');

        return redirect()->route('penilaian.index');
    }
}
