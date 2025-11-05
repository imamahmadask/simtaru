<?php

namespace App\Livewire\Admin\Permohonan\Itr\Final;

use App\Models\Itr;
use Livewire\Component;

class FinalDetail extends Component
{
    public $itr;
    public $berkas_final;

    public function render()
    {
        return view('livewire.admin.permohonan.itr.final.final-detail');
    }

    public function mount($itr_id)
    {
        $this->itr = Itr::find($itr_id);
        $this->berkas_final = $this->itr->permohonan->berkas->where('versi', 'final');
    }
}
