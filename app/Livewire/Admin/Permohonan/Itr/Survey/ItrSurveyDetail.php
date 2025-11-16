<?php

namespace App\Livewire\Admin\Permohonan\Itr\Survey;

use App\Models\Itr;
use App\Models\Permohonan;
use App\Models\RiwayatPermohonan;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use PhpOffice\PhpWord\TemplateProcessor;

class ItrSurveyDetail extends Component
{
    public $itr;

    public function render()
    {
        return view('livewire.admin.permohonan.itr.survey.itr-survey-detail');
    }

    public function mount($itr_id)
    {
        $this->itr = Itr::find($itr_id);
    }

    public function download1a()
    {
        $permohonan = $this->itr->permohonan;

        $data = [
            'nama_pemohon' => $permohonan->registrasi->nama,
            'alamat_tanah' => $permohonan->registrasi->alamat_tanah,
            'kel_tanah' => $permohonan->registrasi->kel_tanah,
            'kec_tanah' => $permohonan->registrasi->kec_tanah,
            'luas_tanah' => $permohonan->luas_tanah,
            'fungsi_bangunan' => $permohonan->registrasi->fungsi_bangunan,
            'batas_utara' => $this->itr->batas_persil['utara'],
            'batas_selatan' => $this->itr->batas_persil['selatan'],
            'batas_timur' => $this->itr->batas_persil['timur'],
            'batas_barat' => $this->itr->batas_persil['barat'],
        ];

        return $this->generateDocument('1A_Form_Survey_template.docx', $data);
    }

    public function download1b()
    {
        $permohonan = $this->itr->permohonan;
        $data = [
            'nama_pemohon' => $permohonan->registrasi->nama,
            'alamat_tanah' => $permohonan->registrasi->alamat_tanah,
            'kel_tanah' => $permohonan->registrasi->kel_tanah,
            'kec_tanah' => $permohonan->registrasi->kec_tanah,
            'luas_tanah' => $permohonan->luas_tanah,
            'ada_bangunan' => $this->itr->ada_bangunan,
        ];

        return $this->generateDocument('1B_BA_survey_template.docx', $data);
    }

    private function generateDocument($templatePath, $data)
    {
        $templateProcessor = new TemplateProcessor(public_path('templates/itr/'.$templatePath));

        foreach ($data as $key => $value) {
            $templateProcessor->setValue($key, $value);
        }

        $fileName = str_replace('.docx', '', basename($templatePath)).'_'.$data['nama_pemohon'].'.docx';
        $tempPath = storage_path("app/public/{$fileName}");

        $templateProcessor->saveAs($tempPath);

        return response()->download($tempPath)->deleteFileAfterSend(true);
    }

    public function selesaiSurvey()
    {
        if(Auth::user()->role == 'surveyor' || Auth::user()->role == 'superadmin' || Auth::user()->role == 'supervisor') {
            if ($this->itr->is_survey || !$this->itr->is_berkas_survey_uploaded) {
                // You can abort, show an error, or just do nothing.
                session()->flash('error', 'Aksi tidak diizinkan.');
            }
            else
            {
                // update tabel survey
                $this->itr->update([
                    'is_survey' => true
                ]);
                // Find and update the disposisi for the 'Survey' stage
                $tahapanSurveyId = $this->itr->permohonan->layanan->tahapan->where('nama', 'Survey')->value('id');
                if ($tahapanSurveyId) {
                    $this->itr->permohonan->disposisi()->where('tahapan_id', $tahapanSurveyId)->update([
                        'is_done' => true,
                        'tgl_selesai' => now()
                    ]);
                }

                $this->itr->permohonan->update([
                    'status' => 'Proses Analisa'
                ]);

                $this->createRiwayat($this->itr->permohonan, 'Selesai Survey Data ITR');
                $this->createRiwayat($this->itr->permohonan, 'Proses Analisa ITR');

                session()->flash('success', 'Data Survey selesai!');
            }

        }

        return redirect()->route('itr.detail', ['id' => $this->itr->id]);
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
