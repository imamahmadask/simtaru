<?php

namespace App\Livewire\Admin\Permohonan\Kkprnb\Survey;

use App\Models\Kkprnb;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class KkprnbSurveyHold extends Component
{
    public $kkprnb_id;
    
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
        return view('livewire.admin.permohonan.kkprnb.survey.kkprnb-survey-hold');
    }

    #[On('kkprnb-survey-hold')]
    public function loadKkprnb($kkprnb_id)
    {
        $this->kkprnb_id = $kkprnb_id;
        $kkprnb = Kkprnb::find($this->kkprnb_id);
        if ($kkprnb) {
            $this->is_survey_hold = $kkprnb->is_survey_hold ?? true;
            $this->ket_survey_hold = $kkprnb->ket_survey_hold;
            $this->tgl_survey_hold = $kkprnb->tgl_survey_hold;
            $this->tgl_survey_unhold = $kkprnb->tgl_survey_unhold;
        }
    }

    public function saveHold()
    {
        $this->validate();

        $kkprnb = Kkprnb::findOrFail($this->kkprnb_id);
        $kkprnb->update([
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
        
        $this->dispatch('refresh-kkprnb-survey-list');
        $this->dispatch('trigger-close-modal-kkprnb');
    }
}
