<?php

namespace App\Livewire\Admin\Permohonan\Itr\Survey;

use App\Models\Itr;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ItrSurveyHold extends Component
{
    public $itr_id;
    
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
        return view('livewire.admin.permohonan.itr.survey.itr-survey-hold');
    }

    #[On('itr-survey-hold')]
    public function loadItr($itr_id)
    {
        $this->itr_id = $itr_id;
        $itr = Itr::find($this->itr_id);
        if ($itr) {
            $this->is_survey_hold = $itr->is_survey_hold ?? true;
            $this->ket_survey_hold = $itr->ket_survey_hold;
            $this->tgl_survey_hold = $itr->tgl_survey_hold;
            $this->tgl_survey_unhold = $itr->tgl_survey_unhold;
        }
    }

    public function saveHold()
    {
        $this->validate();

        $itr = Itr::findOrFail($this->itr_id);
        $itr->update([
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
        
        $this->dispatch('refresh-itr-survey-list'); // Assuming ITR uses a similar refresh event
        $this->dispatch('trigger-close-modal-itr');
    }
}
