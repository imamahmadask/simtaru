<?php

namespace App\Livewire\Admin\Permohonan\Skrk\Survey;

use App\Models\Permohonan;
use App\Models\RiwayatPermohonan;
use App\Models\Skrk;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Number;
use Livewire\Attributes\On;
use Livewire\Component;
use PhpOffice\PhpWord\TemplateProcessor;

class SkrkSurveyDetail extends Component
{
    public $skrk;
    public $cek_disposisi = false;

    public function render()
    {
        $this->cek_disposisi = $this->skrk->permohonan->disposisi()
            ->where('tahapan_id', $this->skrk->permohonan->layanan->tahapan
            ->where('nama', 'Analisis')->value('id'))->first();

        return view('livewire.admin.permohonan.skrk.survey.skrk-survey-detail');
    }

    #[On('refresh-skrk-survey-list')]
    public function refresh()
    {
        $this->cek_disposisi = $this->skrk->permohonan->disposisi()->where('tahapan_id', $this->skrk->permohonan->layanan->tahapan->where('nama', 'Analisis')->value('id'))->first();
    }

    public function mount($skrk_id)
    {
        $this->skrk = Skrk::find($skrk_id);
    }

    public function download1a()
    {
        $permohonan = $this->skrk->permohonan;
        $batas = $this->skrk->batas_administratif;
        $hari_survey = $this->skrk->tgl_survey ? \Carbon\Carbon::parse($this->skrk->tgl_survey)->locale('id')->isoFormat('dddd') : '______';
        $tgl_survey = $this->skrk->tgl_survey ? ucwords(Number::spell(\Carbon\Carbon::parse($this->skrk->tgl_survey)->locale('id')->isoFormat('D'), 'id')) : '______';
        $bulan_survey = $this->skrk->tgl_survey ? \Carbon\Carbon::parse($this->skrk->tgl_survey)->locale('id')->isoFormat('MMMM') : '______';
        $tahun_survey = $this->skrk->tgl_survey ? ucwords(Number::spell(\Carbon\Carbon::parse($this->skrk->tgl_survey)->locale('id')->isoFormat('YYYY'), 'id')) : '______';

        $data = [
            'nama_pemohon' => $permohonan->registrasi->nama,
            'alamat_tanah' => $permohonan->registrasi->alamat_tanah,
            'kel_tanah' => $permohonan->registrasi->kel_tanah,
            'kec_tanah' => $permohonan->registrasi->kec_tanah,
            'luas_tanah' => $permohonan->luas_tanah,
            'fungsi_bangunan' => $permohonan->registrasi->fungsi_bangunan,
            'batas_barat' => $batas['barat'],
            'batas_timur' => $batas['timur'],
            'batas_utara' => $batas['utara'],
            'batas_selatan' => $batas['selatan'],
            'hari_survey' => $hari_survey,
            'tgl_survey' => $tgl_survey,
            'bulan_survey' => $bulan_survey,
            'tahun_survey' => $tahun_survey,
        ];

        return $this->generateDocument('1A_Form_Survey_template.docx', $data);
    }

    public function download1b()
    {
        $permohonan = $this->skrk->permohonan;
        $batas = $this->skrk->batas_administratif;
        $surveyor = $permohonan->disposisi->where('tahapan_id', $permohonan->layanan->tahapan->where('nama', 'Survey')->value('id'))->first()->penerima->name;
        $hari_survey = $this->skrk->tgl_survey ? \Carbon\Carbon::parse($this->skrk->tgl_survey)->locale('id')->isoFormat('dddd') : '______';
        $tgl_survey = $this->skrk->tgl_survey ? ucwords(Number::spell(\Carbon\Carbon::parse($this->skrk->tgl_survey)->locale('id')->isoFormat('D'), 'id')) : '______';
        $bulan_survey = $this->skrk->tgl_survey ? \Carbon\Carbon::parse($this->skrk->tgl_survey)->locale('id')->isoFormat('MMMM') : '______';
        $tahun_survey = $this->skrk->tgl_survey ? ucwords(Number::spell(\Carbon\Carbon::parse($this->skrk->tgl_survey)->locale('id')->isoFormat('YYYY'), 'id')) : '______';
        $tahun_number_survey = $this->skrk->tgl_survey ? \Carbon\Carbon::parse($this->skrk->tgl_survey)->locale('id')->isoFormat('YYYY') : '______';
        $data = [
            'nama_surveyor' => $surveyor,
            'nama_pemohon' => $permohonan->registrasi->nama,
            'alamat_tanah' => $permohonan->registrasi->alamat_tanah,
            'kel_tanah' => $permohonan->registrasi->kel_tanah,
            'kec_tanah' => $permohonan->registrasi->kec_tanah,
            'luas_tanah' => $permohonan->luas_tanah,
            'ada_bangunan' => $this->skrk->ada_bangunan,
            'batas_barat' => $batas['barat'],
            'batas_timur' => $batas['timur'],
            'batas_utara' => $batas['utara'],
            'batas_selatan' => $batas['selatan'],
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
        $templateProcessor = new TemplateProcessor(public_path('templates/skrk/'.$templatePath));

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
            if ($this->skrk->is_survey || !$this->skrk->is_berkas_survey_uploaded) {
                // You can abort, show an error, or just do nothing.
                session()->flash('error', 'Aksi tidak diizinkan.');
            }
            else
            {
                // update tabel survey
                $this->skrk->update([
                    'is_survey' => true
                ]);
                // Find and update the disposisi for the 'Survey' stage
                $tahapanSurveyId = $this->skrk->permohonan->layanan->tahapan->where('nama', 'Survey')->value('id');
                if ($tahapanSurveyId) {
                    $this->skrk->permohonan->disposisi()->where('tahapan_id', $tahapanSurveyId)->update([
                        'is_done' => true,
                        'tgl_selesai' => now()
                    ]);
                }

                $this->skrk->permohonan->update([
                    'status' => 'Proses Analisa'
                ]);

                $this->createRiwayat($this->skrk->permohonan, 'Selesai Survey Data SKRK');

                session()->flash('success', 'Data Survey selesai!');
            }

        }

        return redirect()->route('skrk.detail', ['id' => $this->skrk->id]);
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
