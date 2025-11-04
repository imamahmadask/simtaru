<?php

namespace App\Livewire\Admin\Permohonan\Itr\Analis;

use App\Models\Itr;
use App\Models\Permohonan;
use Livewire\Component;

class ItrKajianAnalisEdit extends Component
{
    public $permohonan, $itr, $permohonan_id, $itr_id;

    public $penguasaan_tanah;

    public function render()
    {
        return view('livewire.admin.permohonan.itr.analis.itr-kajian-analis-edit');
    }

    public function mount($permohonan_id, $itr_id)
    {
        $this->itr = Itr::findOrFail($itr_id);
        $this->permohonan = Permohonan::findOrFail($permohonan_id);

        $this->penguasaan_tanah = $this->itr->penguasaan_tanah;
    }

    public function editKajianAnalisa()
    {
        $this->itr->update([
            'penguasaan_tanah' => $this->penguasaan_tanah,
        ]);

        session()->flash('success', 'Data Kajian Analisis berhasil diupdate!');

        return redirect()->route('itr.detail', ['id' => $this->itr_id]);
    }
}
