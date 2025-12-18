<?php

namespace App\Livewire\Admin\Permohonan\Kkprb\Survey;

use App\Models\Kkprb;
use App\Models\Permohonan;
use App\Models\RiwayatPermohonan;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use PhpOffice\PhpWord\TemplateProcessor;

class KkprbSurveyDetail extends Component
{
    public $kkprb;

    public function render()
    {
        return view('livewire.admin.permohonan.kkprb.survey.kkprb-survey-detail');
    }

    #[On('refresh-kkprb-survey-list')]
    public function refresh() {}

    public function mount($kkprb_id)
    {
        $this->kkprb = Kkprb::find($kkprb_id);
    }

    public function download1()
    {
        $permohonan = $this->kkprb->permohonan;

        $data = [
            'nama_pemohon' => $permohonan->registrasi->nama,
            'alamat_tanah' => $permohonan->registrasi->alamat_tanah,
            'kel_tanah' => $permohonan->registrasi->kel_tanah,
            'kec_tanah' => $permohonan->registrasi->kec_tanah,
            'luas_tanah' => $permohonan->luas_tanah,
            'no_ptp' => $this->kkprb->no_ptp,
            'tgl_ptp' => $this->kkprb->tgl_ptp,
            'ada_bangunan' => $this->kkprb->ada_bangunan,
            'status_jalan' => $this->kkprb->status_jalan,
            'fungsi_jalan' => $this->kkprb->fungsi_jalan,
            'tipe_jalan' => $this->kkprb->tipe_jalan,
            'median_jalan' => $this->kkprb->median_jalan,
            'lebar_jalan' => $this->kkprb->lebar_jalan,            
        ];

        return $this->generateDocument('1_BA_PEMERIKSAAN_LAPANGAN.docx', $data);
    }

    private function generateDocument($templatePath, $data)
    {
        $templateProcessor = new TemplateProcessor(public_path('templates/kkprb/'.$templatePath));

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
            if ($this->kkprb->is_survey || !$this->kkprb->is_berkas_survey_uploaded) {
                // You can abort, show an error, or just do nothing.
                session()->flash('error', 'Aksi tidak diizinkan.');
            }
            else
            {
                // update tabel survey
                $this->kkprb->update([
                    'is_survey' => true
                ]);
                // Find and update the disposisi for the 'Survey' stage
                $tahapanSurveyId = $this->kkprb->permohonan->layanan->tahapan->where('nama', 'Survey')->value('id');
                if ($tahapanSurveyId) {
                    $this->kkprb->permohonan->disposisi()->where('tahapan_id', $tahapanSurveyId)->update([
                        'is_done' => true,
                        'tgl_selesai' => now()
                    ]);
                }

                $this->kkprb->permohonan->update([
                    'status' => 'Proses Analisa'
                ]);
                
                $this->createRiwayat($this->kkprb->permohonan, 'Proses Survey KKPR Berusaha Selesai!');
                $this->createRiwayat($this->kkprb->permohonan, 'Proses Analisa KKPR Berusaha');
            }

            session()->flash('success', 'Data Survey selesai!');
        }

        return redirect()->route('kkprb.detail', ['id' => $this->kkprb->id]);
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
