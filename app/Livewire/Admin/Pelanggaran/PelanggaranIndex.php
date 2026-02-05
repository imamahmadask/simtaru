<?php

namespace App\Livewire\Admin\Pelanggaran;

use App\Models\Pelanggaran;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Title('Pelanggaran')]
class PelanggaranIndex extends Component
{
    #[Layout('layouts.app-pelanggaran')]
    public function render()
    {

        $pelanggarans = Pelanggaran::all();

        return view('livewire.admin.pelanggaran.pelanggaran-index', compact('pelanggarans'));
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
