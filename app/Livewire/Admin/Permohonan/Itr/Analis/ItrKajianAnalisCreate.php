<?php

namespace App\Livewire\Admin\Permohonan\Itr\Analis;

use App\Models\Permohonan;
use App\Models\RiwayatPermohonan;
use App\Models\Itr;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ItrKajianAnalisCreate extends Component
{
    public $permohonan, $itr, $permohonan_id, $itr_id;

    public $penguasaan_tanah;

    public function render()
    {
        return view('livewire.admin.permohonan.itr.analis.itr-kajian-analis-create');
    }

    public function createKajianAnalisa()
    {
        $this->itr->update([
            'penguasaan_tanah' => $this->penguasaan_tanah,
            'is_kajian' => true
        ]);

        $this->permohonan->update([
            'status' => 'Proses Analisa'
        ]);

        $this->createRiwayat($this->permohonan, 'Entry Data Kajian Analisa');

        session()->flash('success', 'Data Kajian Analisa berhasil ditambahkan!');

        return redirect()->route('itr.detail', ['id' => $this->itr_id]);
    }

    public function mount($permohonan_id, $itr_id)
    {
        $this->permohonan_id = $permohonan_id;
        $this->itr_id = $itr_id;
        $this->permohonan = Permohonan::findOrFail($this->permohonan_id);
        $this->itr = Itr::findOrFail($this->itr_id);
    }

    private function createRiwayat(Permohonan $permohonan, string $keterangan)
    {
        RiwayatPermohonan::create([
            'registrasi_id' => $permohonan->registrasi_id,
            'user_id' => Auth::user()->id,
            'keterangan' => $keterangan
        ]);
    }
}
