<?php

namespace App\Livewire\Admin\Permohonan\Skrk\Analis;

use App\Models\Permohonan;
use App\Models\RiwayatPermohonan;
use App\Models\Skrk;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SkrkKajianAnalisCreate extends Component
{
    public $permohonan, $skrk, $permohonan_id, $skrk_id;

    public $penguasaan_tanah, $ada_bangunan, $jml_bangunan, $jml_lantai, $luas_lantai, $kedalaman_min, $kedalaman_max;

    public function render()
    {
        return view('livewire.admin.permohonan.skrk.analis.skrk-kajian-analis-create');
    }

    public function createKajianAnalisa()
    {
        $this->skrk->update([
            'penguasaan_tanah' => $this->penguasaan_tanah,
            'ada_bangunan' => $this->ada_bangunan,
            'jml_bangunan' => $this->jml_bangunan,
            'jml_lantai' => $this->jml_lantai,
            'luas_lantai' => $this->luas_lantai,
            'kedalaman_min' => $this->kedalaman_min,
            'kedalaman_max' => $this->kedalaman_max,
            'is_kajian' => true
        ]);

        $this->createRiwayat($this->permohonan, 'Entry Data Kajian Analisa');

        session()->flash('success', 'Data Kajian Analisa berhasil ditambahkan!');

        return redirect()->route('skrk.detail', ['id' => $this->skrk_id]);
    }

    public function mount($permohonan_id, $skrk_id)
    {
        $this->permohonan_id = $permohonan_id;
        $this->skrk_id = $skrk_id;
        $this->permohonan = Permohonan::findOrFail($this->permohonan_id);
        $this->skrk = Skrk::findOrFail($this->skrk_id);
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
