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
            $foto_pengawasan = json_decode($pelanggaran->foto_pengawasan, true);
            foreach ($foto_pengawasan as $foto) {
                Storage::disk('public')->delete($foto);
            }
        }

        if ($pelanggaran->foto_tindak_lanjut) {
            $foto_tindak_lanjut = json_decode($pelanggaran->foto_tindak_lanjut, true);
            foreach ($foto_tindak_lanjut as $foto) {
                Storage::disk('public')->delete($foto);
            }
        }

        $pelanggaran->delete();

        session()->flash('success', 'Data berhasil dihapus');

        return redirect()->route('pelanggaran.index');
    }
}
