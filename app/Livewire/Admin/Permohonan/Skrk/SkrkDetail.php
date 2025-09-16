<?php

namespace App\Livewire\Admin\Permohonan\Skrk;

use App\Models\Layanan;
use App\Models\Skrk;
use Livewire\Attributes\Title;
use Livewire\Component;
use PhpOffice\PhpWord\TemplateProcessor;

#[Title('Detail SKRK')]
class SkrkDetail extends Component
{
    public $skrk;

    public function render()
    {
        return view('livewire.admin.permohonan.skrk.skrk-detail');
    }

    public function mount()
    {
        $this->skrk = Skrk::first();
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

    public function download2a()
    {
        $permohonan = $this->skrk->permohonan;
        $data = [
            'nama_pemohon' => $permohonan->registrasi->nama,
            'alamat_tanah' => $permohonan->alamat_tanah,
            'kel_tanah' => $permohonan->kel_tanah,
            'kec_tanah' => $permohonan->kec_tanah,
            'jenis_bangunan' => $permohonan->jenis_bangunan,
        ];

        return $this->generateDocument('2A_BA_rapat_fpr.docx', $data);
    }

    public function download2b()
    {
        $permohonan = $this->skrk->permohonan;
        $data = [
            'nama_pemohon' => $permohonan->registrasi->nama,
        ];

        return $this->generateDocument('2B_notulensi_rapat_fpr.docx', $data);
    }

    public function download3()
    {
        $permohonan = $this->skrk->permohonan;
        $data = [
            'nama_pemohon' => $permohonan->registrasi->nama,
            'alamat_pemohon' => $permohonan->alamat_pemohon,
            'tanggal_regis' => date('d F Y', strtotime($permohonan->registrasi->tanggal)),
            'kode_regis' => $permohonan->registrasi->kode,
            'nik' => $permohonan->registrasi->nik,
            'no_hp' => $permohonan->registrasi->no_hp,
            'email' => $permohonan->registrasi->email,
            'alamat_tanah' => $permohonan->alamat_tanah,
            'kel_tanah' => $permohonan->kel_tanah,
            'kec_tanah' => $permohonan->kec_tanah,
            'jenis_bangunan' => $permohonan->jenis_bangunan,
            'luas_tanah' => $permohonan->luas_tanah,
            'ada_bangunan' => $this->skrk->ada_bangunan,
            'koordinat' => $this->skrk->koordinat,
            'penguasaan_tanah' => $this->skrk->penguasaan_tanah,
            'jml_bangunan' => $this->skrk->jml_bangunan,
            'jml_lantai' => $this->skrk->jml_lantai,
            'luas_lantai' => $this->skrk->luas_lantai,
            'kedalaman_min' => $this->skrk->kedalaman_min,
            'kedalaman_max' => $this->skrk->kedalaman_max,
        ];

        return $this->generateDocument('3_kajian_skrk.docx', $data);
    }

    public function download4()
    {
        $permohonan = $this->skrk->permohonan;
        $data = [
            'nama_pemohon' => $permohonan->registrasi->nama,
            'alamat_pemohon' => $permohonan->alamat_pemohon,
            'tanggal_regis' => date('d F Y', strtotime($permohonan->registrasi->tanggal)),
            'kode_regis' => $permohonan->registrasi->kode,
            'nik' => $permohonan->registrasi->nik,
            'no_hp' => $permohonan->registrasi->no_hp,
            'email' => $permohonan->registrasi->email,
            'npwp' => $permohonan->npwp,
            'alamat_tanah' => $permohonan->alamat_tanah,
            'kel_tanah' => $permohonan->kel_tanah,
            'kec_tanah' => $permohonan->kec_tanah,
            'jenis_bangunan' => $permohonan->jenis_bangunan,
            'luas_tanah' => $permohonan->luas_tanah,
            'skala_usaha' => $this->skrk->skala_usaha,
            'luas_disetujui' => $this->skrk->luas_disetujui,
            'pemanfaatan_ruang' => $this->skrk->pemanfaatan_ruang,
            'peraturan_zonasi' => $this->skrk->peraturan_zonasi,
            'kbli_diizinkan' => $this->skrk->kbli_diizinkan,
            'kdb' => $this->skrk->kdb,
            'klb' => $this->skrk->klb,
            'gsb' => $this->skrk->gsb,
            'jba' => $this->skrk->jba,
            'jbb' => $this->skrk->jbb,
            'kdh' => $this->skrk->kdh,
            'ktb' => $this->skrk->ktb,
            'luas_kavling' => $this->skrk->luas_kavling,
        ];

        return $this->generateDocument('4_dokumen_skrk.docx', $data);
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
