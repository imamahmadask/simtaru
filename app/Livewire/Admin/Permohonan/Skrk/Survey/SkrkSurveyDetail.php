<?php

namespace App\Livewire\Admin\Permohonan\Skrk\Survey;

use App\Models\Skrk;
use Livewire\Component;
use PhpOffice\PhpWord\TemplateProcessor;

class SkrkSurveyDetail extends Component
{
    public $skrk;
    public function render()
    {
        return view('livewire.admin.permohonan.skrk.survey.skrk-survey-detail');
    }

    public function mount($skrk_id)
    {
        $this->skrk = Skrk::find($skrk_id);
    }

    public function download1a()
    {
        $permohonan = $this->skrk->permohonan;
        $data = [
            'nama_pemohon' => $permohonan->registrasi->nama,
            'alamat_tanah' => $permohonan->alamat_tanah,
            'kel_tanah' => $permohonan->kel_tanah,
            'kec_tanah' => $permohonan->kec_tanah,
            'luas_tanah' => $permohonan->luas_tanah,
            'jenis_bangunan' => $permohonan->jenis_bangunan,
        ];

        return $this->generateDocument('1A_Form_Survey_template.docx', $data);
    }

    public function download1b()
    {
        $permohonan = $this->skrk->permohonan;
        $data = [
            'nama_pemohon' => $permohonan->registrasi->nama,
            'alamat_tanah' => $permohonan->alamat_tanah,
            'kel_tanah' => $permohonan->kel_tanah,
            'kec_tanah' => $permohonan->kec_tanah,
            'luas_tanah' => $permohonan->luas_tanah,
            'ada_bangunan' => $this->skrk->ada_bangunan,
        ];

        return $this->generateDocument('1B_BA_survey_template.docx', $data);
    }

    private function generateDocument($templatePath, $data)
    {
        $templateProcessor = new TemplateProcessor(storage_path('app/public/templates/skrk/'.$templatePath));

        foreach ($data as $key => $value) {
            $templateProcessor->setValue($key, $value);
        }

        $fileName = str_replace('.docx', '', basename($templatePath)).'_'.$data['nama_pemohon'].'.docx';
        $tempPath = storage_path("app/public/{$fileName}");

        $templateProcessor->saveAs($tempPath);

        return response()->download($tempPath)->deleteFileAfterSend(true);
    }
}
