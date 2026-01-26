<?php

namespace App\Livewire\Admin\Permohonan\Skrk\Survey;

use App\Models\Permohonan;
use App\Models\RiwayatPermohonan;
use App\Models\Skrk;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class SkrkSurveyHold extends Component
{
    public $skrk_id;
    
    #[Validate('required|boolean')]
    public $is_survey_hold = false;

    #[Validate('required_if:is_survey_hold,true')]
    public $ket_survey_hold;

    #[Validate('required_if:is_survey_hold,true')]
    public $tgl_survey_hold;

    #[Validate('required_if:is_survey_hold,false')]
    public $tgl_survey_unhold;

    public function render()
    {
        return view('livewire.admin.permohonan.skrk.survey.skrk-survey-hold');
    }

    #[On('skrk-survey-hold')]
    public function loadSkrk($skrk_id)
    {
        $this->skrk_id = $skrk_id;
        $skrk = Skrk::find($this->skrk_id);
        if ($skrk) {
            $this->is_survey_hold = $skrk->is_survey_hold ?? true;
            $this->ket_survey_hold = $skrk->ket_survey_hold;
            $this->tgl_survey_hold = $skrk->tgl_survey_hold;
            $this->tgl_survey_unhold = $skrk->tgl_survey_unhold;
        }
    }

    public function saveHold()
    {
        $this->validate();

        $skrk = Skrk::findOrFail($this->skrk_id);
        $skrk->update([
            'is_survey_hold' => $this->is_survey_hold,
            'ket_survey_hold' => $this->ket_survey_hold,
            'tgl_survey_hold' => $this->tgl_survey_hold,
            'tgl_survey_unhold' => $this->tgl_survey_unhold,
        ]);

        $this->reset('is_survey_hold', 'ket_survey_hold', 'tgl_survey_hold', 'tgl_survey_unhold');
    
        $this->dispatch('toast', [
            'type'    => 'success',
            'message' => 'Status Hold Survey berhasil diperbarui!'
        ]);
        
        $this->dispatch('refresh-skrk-survey-list');
        $this->dispatch('trigger-close-modal');
    }
}
