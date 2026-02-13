<?php

namespace App\Livewire\Admin\Permohonan\Itr\Survey;

use App\Models\Itr;
use App\Models\Permohonan;
use App\Models\RiwayatPermohonan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Number;
use Livewire\Attributes\On;
use Livewire\Component;
use PhpOffice\PhpWord\TemplateProcessor;

class ItrSurveyDetail extends Component
{
    public $itr;
    public $cek_disposisi = false;
    public $disposisiSurvey = null;

    public function render()
    {
        $this->cek_disposisi = $this->itr->permohonan->disposisi()
            ->where('tahapan_id', $this->itr->permohonan->layanan->tahapan
            ->where('nama', 'Analisis')->value('id'))->first();

        // Get the current survey disposisi for showing start button
        $tahapanSurveyId = $this->itr->permohonan->layanan->tahapan->where('nama', 'Survey')->value('id');
        if ($tahapanSurveyId) {
            $this->disposisiSurvey = $this->itr->permohonan->disposisi()
                ->where('tahapan_id', $tahapanSurveyId)
                ->where('is_done', false)
                ->latest()
                ->first();
        }

        return view('livewire.admin.permohonan.itr.survey.itr-survey-detail');
    }

    #[On('refresh-itr-survey-list')]
    public function refresh()
    {
        $this->cek_disposisi = $this->itr->permohonan->disposisi()->where('tahapan_id', $this->itr->permohonan->layanan->tahapan->where('nama', 'Analisis')->value('id'))->first();
    }

    public function mount($itr_id)
    {
        $this->itr = Itr::find($itr_id);
    }

    public function mulaiKerja()
    {
        $tahapanSurveyId = $this->itr->permohonan->layanan->tahapan->where('nama', 'Survey')->value('id');
        if ($tahapanSurveyId) {
            $disposisi = $this->itr->permohonan->disposisi()
                ->where('tahapan_id', $tahapanSurveyId)
                ->where('is_done', false)
                ->whereNull('tgl_mulai_kerja')
                ->latest()
                ->first();

            if ($disposisi) {
                $disposisi->update([
                    'tgl_mulai_kerja' => now(),
                ]);
                session()->flash('success', 'Waktu mulai kerja telah dicatat!');
            }
        }
    }

    public function download1a()
    {
        $permohonan = $this->itr->permohonan;
        $batas = $this->itr->batas_persil;
        $hari_survey = $this->itr->tgl_survey ? \Carbon\Carbon::parse($this->itr->tgl_survey)->locale('id')->isoFormat('dddd') : '______';
        $tgl_survey = $this->itr->tgl_survey ? ucwords(Number::spell(\Carbon\Carbon::parse($this->itr->tgl_survey)->locale('id')->isoFormat('D'), 'id')) : '______';
        $bulan_survey = $this->itr->tgl_survey ? \Carbon\Carbon::parse($this->itr->tgl_survey)->locale('id')->isoFormat('MMMM') : '______';
        $tahun_survey = $this->itr->tgl_survey ? ucwords(Number::spell(\Carbon\Carbon::parse($this->itr->tgl_survey)->locale('id')->isoFormat('YYYY'), 'id')) : '______';

        $data = [
            'nama_pemohon' => $permohonan->registrasi->nama,
            'alamat_tanah' => $permohonan->registrasi->alamat_tanah,
            'kel_tanah' => $permohonan->registrasi->kel_tanah,
            'kec_tanah' => $permohonan->registrasi->kec_tanah,
            'luas_tanah' => $permohonan->luas_tanah,
            'fungsi_bangunan' => $permohonan->registrasi->fungsi_bangunan,
            'batas_utara' => $batas['utara'],
            'batas_selatan' => $batas['selatan'],
            'batas_timur' => $batas['timur'],
            'batas_barat' => $batas['barat'],
            'hari_survey' => $hari_survey,
            'tgl_survey' => $tgl_survey,
            'bulan_survey' => $bulan_survey,
            'tahun_survey' => $tahun_survey
        ];

        return $this->generateDocument('1A_Form_Survey_template.docx', $data);
    }

    public function download1b()
    {
        $permohonan = $this->itr->permohonan;
        $batas = $this->itr->batas_persil;
        $surveyor = $permohonan->disposisi->where('tahapan_id', $permohonan->layanan->tahapan->where('nama', 'Survey')->value('id'))->first()->penerima->name;
        $hari_survey = $this->itr->tgl_survey ? \Carbon\Carbon::parse($this->itr->tgl_survey)->locale('id')->isoFormat('dddd') : '______';
        $tgl_survey = $this->itr->tgl_survey ? ucwords(Number::spell(\Carbon\Carbon::parse($this->itr->tgl_survey)->locale('id')->isoFormat('D'), 'id')) : '______';
        $bulan_survey = $this->itr->tgl_survey ? \Carbon\Carbon::parse($this->itr->tgl_survey)->locale('id')->isoFormat('MMMM') : '______';
        $tahun_survey = $this->itr->tgl_survey ? ucwords(Number::spell(\Carbon\Carbon::parse($this->itr->tgl_survey)->locale('id')->isoFormat('YYYY'), 'id')) : '______';
        $tahun_number_survey = $this->itr->tgl_survey ? \Carbon\Carbon::parse($this->itr->tgl_survey)->locale('id')->isoFormat('YYYY') : '______';

        $data = [
            'nama_surveyor' => $surveyor,
            'nama_pemohon' => $permohonan->registrasi->nama,
            'alamat_tanah' => $permohonan->registrasi->alamat_tanah,
            'kel_tanah' => $permohonan->registrasi->kel_tanah,
            'kec_tanah' => $permohonan->registrasi->kec_tanah,
            'luas_tanah' => $permohonan->luas_tanah,
            'ada_bangunan' => $this->itr->ada_bangunan,
            'batas_utara' => $batas['utara'],
            'batas_selatan' => $batas['selatan'],
            'batas_timur' => $batas['timur'],
            'batas_barat' => $batas['barat'],
            'hari_survey' => $hari_survey,
            'tgl_survey' => $tgl_survey,
            'bulan_survey' => $bulan_survey,
            'tahun_survey' => $tahun_survey,
            'tahun_number_survey' => $tahun_number_survey,
        ];

        return $this->generateDocument('1B_BA_survey_template.docx', $data);
    }

    private function generateDocument($templatePath, $data)
    {
        $templateProcessor = new TemplateProcessor(public_path('templates/itr/'.$templatePath));

        foreach ($data as $key => $value) {
            $templateProcessor->setValue($key, $value);
        }

        // Sanitize filename by removing special characters
        $baseName = str_replace('.docx', '', basename($templatePath));
        $sanitizedName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $data['nama_pemohon']);
        $fileName = $baseName . '_' . $sanitizedName . '.docx';
        $tempPath = storage_path('app' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . $fileName);

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
