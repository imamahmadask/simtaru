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

        if ($pelanggaran->foto_pengawasan) {
            Storage::disk('public')->delete($pelanggaran->foto_pengawasan);
        }

        $pelanggaran->delete();

        session()->flash('success', 'Data berhasil dihapus');

        return redirect()->route('pelanggaran.index');
    }
}
