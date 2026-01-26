<?php

namespace App\Livewire\Admin\Permohonan\Kkprb\Survey;

use App\Models\Kkprb;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class KkprbSurveyHold extends Component
{
    public $kkprb_id;
    
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
        return view('livewire.admin.permohonan.kkprb.survey.kkprb-survey-hold');
    }

    #[On('kkprb-survey-hold')]
    public function loadKkprb($kkprb_id)
    {
        $this->kkprb_id = $kkprb_id;
        $kkprb = Kkprb::find($this->kkprb_id);
        if ($kkprb) {
            $this->is_survey_hold = $kkprb->is_survey_hold ?? true;
            $this->ket_survey_hold = $kkprb->ket_survey_hold;
            $this->tgl_survey_hold = $kkprb->tgl_survey_hold;
            $this->tgl_survey_unhold = $kkprb->tgl_survey_unhold;
        }
    }

    public function saveHold()
    {
        $this->validate();

        $kkprb = Kkprb::findOrFail($this->kkprb_id);
        $kkprb->update([
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
        
        $this->dispatch('refresh-kkprb-survey-list');
        $this->dispatch('trigger-close-modal-kkprb');
    }
}
