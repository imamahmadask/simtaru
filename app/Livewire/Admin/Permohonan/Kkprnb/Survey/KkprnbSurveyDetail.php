<?php

namespace App\Livewire\Admin\Permohonan\Kkprnb\Survey;

use App\Models\Kkprnb;
use App\Models\Permohonan;
use App\Models\RiwayatPermohonan;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use PhpOffice\PhpWord\TemplateProcessor;

class KkprnbSurveyDetail extends Component
{
    public $kkprnb;

    public function render()
    {
        return view('livewire.admin.permohonan.kkprnb.survey.kkprnb-survey-detail');
    }

    #[On('refresh-kkprnb-survey-list')]
    public function refresh() {}

    public function mount($kkprnb_id)
    {
        $this->kkprnb = Kkprnb::find($kkprnb_id);
    }

    public function download3a()
    {
        $permohonan = $this->kkprnb->permohonan;

        $data = [
            'nama_pemohon' => $permohonan->registrasi->nama,
            'alamat_tanah' => $permohonan->registrasi->alamat_tanah,
            'kel_tanah' => $permohonan->registrasi->kel_tanah,
            'kec_tanah' => $permohonan->registrasi->kec_tanah,
            'luas_tanah' => $permohonan->luas_tanah,
            'ada_bangunan' => $this->kkprnb->ada_bangunan,
            'status_jalan' => $this->kkprnb->status_jalan,
            'tipe_jalan' => $this->kkprnb->tipe_jalan,
            'fungsi_jalan' => $this->kkprnb->fungsi_jalan,
            'median_jalan' => $this->kkprnb->median_jalan,
            'lebar_jalan' => $this->kkprnb->lebar_jalan,
        ];

        return $this->generateDocument('3A_BA_PEMERIKSAAN_LAPANGAN_NON_BERUSAHA.docx', $data);
    }

    private function generateDocument($templatePath, $data)
    {
        $templateProcessor = new TemplateProcessor(public_path('templates/kkprnb/'.$templatePath));

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
            if ($this->kkprnb->is_survey || !$this->kkprnb->is_berkas_survey_uploaded) {
                // You can abort, show an error, or just do nothing.
                session()->flash('error', 'Aksi tidak diizinkan.');
            }
            else
            {
                // update tabel survey
                $this->kkprnb->update([
                    'is_survey' => true
                ]);
                // Find and update the disposisi for the 'Survey' stage
                $tahapanSurveyId = $this->kkprnb->permohonan->layanan->tahapan->where('nama', 'Survey')->value('id');
                if ($tahapanSurveyId) {
                    $this->kkprnb->permohonan->disposisi()->where('tahapan_id', $tahapanSurveyId)->update([
                        'is_done' => true,
                        'tgl_selesai' => now()
                    ]);
                }

                $this->kkprnb->permohonan->update([
                    'status' => 'Proses Analisa'
                ]);
                
                $this->createRiwayat($this->kkprnb->permohonan, 'Proses Analisa KKPR Non Berusaha');
            }

            session()->flash('success', 'Data Survey selesai!');
        }

        return redirect()->route('kkprnb.detail', ['id' => $this->kkprnb->id]);
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
