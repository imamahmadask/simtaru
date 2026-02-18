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
    public $selectedPenilaian;
    public $showSaranModal = false;

    protected $listeners = ['refresh' => '$refresh'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    #[Layout('layouts.app-penilaian')]
    public function render()
    {
        $penilaians = Penilaian::query()
            ->withCount('sarans')
            ->when($this->search, function ($query) {
                $query->where('nomor_dokumen', 'like', '%' . $this->search . '%')
                    ->orWhere('nama_pelaku_usaha', 'like', '%' . $this->search . '%')
                    ->orWhere('nama_usaha', 'like', '%' . $this->search . '%')
                    ->orWhere('alamat_lokasi_usaha', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);

        return view('livewire.admin.penilaian.penilaian-index', compact('penilaians'));
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
