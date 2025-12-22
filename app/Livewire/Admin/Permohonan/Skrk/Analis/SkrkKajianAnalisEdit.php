<?php

namespace App\Livewire\Admin\Permohonan\Skrk\Analis;

use App\Models\Permohonan;
use App\Models\Skrk;
use Livewire\Component;

class SkrkKajianAnalisEdit extends Component
{
    public $permohonan, $skrk, $permohonan_id, $skrk_id;

    public $penguasaan_tanah, $ada_bangunan, $jml_bangunan, $jml_lantai, $luas_lantai, $kedalaman_min, $kedalaman_max;
    public function render()
    {
        return view('livewire.admin.permohonan.skrk.analis.skrk-kajian-analis-edit');
    }

    public function mount($permohonan_id, $skrk_id)
    {
        $this->skrk = Skrk::findOrFail($skrk_id);
        $this->permohonan = Permohonan::findOrFail($permohonan_id);

        $this->penguasaan_tanah = $this->skrk->penguasaan_tanah;
        $this->ada_bangunan = $this->skrk->ada_bangunan;
        $this->jml_bangunan = $this->skrk->jml_bangunan;
        $this->jml_lantai = $this->skrk->jml_lantai;
        $this->luas_lantai = $this->skrk->luas_lantai;
        $this->kedalaman_min = $this->skrk->kedalaman_min;
        $this->kedalaman_max = $this->skrk->kedalaman_max;
    }

    public function editKajianAnalisa()
    {
        $this->skrk->update([
            'penguasaan_tanah' => $this->penguasaan_tanah,
            'ada_bangunan' => $this->ada_bangunan,
            'jml_bangunan' => $this->jml_bangunan,
            'jml_lantai' => $this->jml_lantai,
            'luas_lantai' => $this->luas_lantai,
            'kedalaman_min' => $this->kedalaman_min,
            'kedalaman_max' => $this->kedalaman_max
        ]);

        $this->dispatch('toast', [
            'type'    => 'success',
            'message' => 'Data Kajian Analisa SKRK berhasil diupdate!'
        ]);

        $this->dispatch('refresh-skrk-analis-list');

        $this->dispatch('trigger-close-modal');
    }
}
