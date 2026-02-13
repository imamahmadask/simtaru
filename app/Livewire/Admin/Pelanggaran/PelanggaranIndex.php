<?php

namespace App\Livewire\Admin\Pelanggaran;

use App\Models\Pelanggaran;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\WithPagination;

#[Title('Pelanggaran')]
class PelanggaranIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedPelanggaran;
    public $showSaranModal = false;

    protected $listeners = ['refresh' => '$refresh'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    #[Layout('layouts.app-pelanggaran')]
    public function render()
    {
        $pelanggarans = Pelanggaran::query()
            ->withCount('sarans')
            ->when($this->search, function ($query) {
                $query->where('no_pelanggaran', 'like', '%' . $this->search . '%')
                    ->orWhere('nama_pelanggar', 'like', '%' . $this->search . '%')
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
        $pelanggaran = Pelanggaran::findOrFail($id);

        // Collect all file paths to delete
        $filesToDelete = array_merge(
            (array) $pelanggaran->foto_pengawasan,
            (array) $pelanggaran->foto_tindak_lanjut,
            (array) $pelanggaran->foto_existing,
            (array) ($pelanggaran->dokumen_penilaian_kkpr ? [$pelanggaran->dokumen_penilaian_kkpr] : [])
        );

        // Delete files from storage
        Storage::disk('public')->delete(array_filter($filesToDelete));
        
        // Also ensure the directory is cleaned up if empty
        // Assuming 'no_pelanggaran' is a property on the Pelanggaran model
        // and files are stored in a directory named after it.
        if ($pelanggaran->no_pelanggaran) {
            Storage::disk('public')->deleteDirectory('pelanggaran/' . $pelanggaran->no_pelanggaran);
        }

        $pelanggaran->delete();

        session()->flash('success', 'Data berhasil dihapus');

        return redirect()->route('pelanggaran.index');
    }
}
