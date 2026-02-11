<?php

namespace App\Livewire\Admin\Pelanggaran\Analis;

use App\Models\Pelanggaran;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use PhpOffice\PhpWord\TemplateProcessor;

class PelanggaranAnalisDetail extends Component
{
    use WithFileUploads;

    public $pelanggaran;
    public $temuan_pelanggaran;
    public $existing_foto_tindak_lanjut = [];

    #[Validate('required_if:temuan_pelanggaran,Ada Pelanggaran', message: 'Tindak lanjut wajib diisi')]
    public $tindak_lanjut;

    #[Validate(['foto_tindak_lanjut.*' => 'image|max:10240'])]
    public $foto_tindak_lanjut = [];

    public $existing_foto_existing = [];
    #[Validate('nullable|date')]
    public $tgl_evaluasi;
    public $status_pelanggaran;
    #[Validate(['temp_foto_existing.*' => 'image|max:10240'])]
    public $temp_foto_existing = [];

    #[Validate('nullable|file|mimes:pdf,jpg,jpeg,png|max:10240')]
    public $upload_sp1;
    #[Validate('nullable|file|mimes:pdf,jpg,jpeg,png|max:10240')]
    public $upload_sp2;
    #[Validate('nullable|file|mimes:pdf,jpg,jpeg,png|max:10240')]
    public $upload_sp3;
    #[Validate('nullable|file|mimes:pdf,jpg,jpeg,png|max:10240')]
    public $upload_pelimpahan_polpp;
    #[Validate('nullable|file|mimes:pdf,jpg,jpeg,png|max:10240')]
    public $upload_pernyataan;
    #[Validate('nullable|file|mimes:pdf,jpg,jpeg,png|max:10240')]
    public $upload_sosialisasi;
    #[Validate('nullable|file|mimes:pdf,jpg,jpeg,png|max:10240')]
    public $upload_ba_pengambilan_dokumen;
    #[Validate('nullable|file|mimes:pdf,jpg,jpeg,png|max:10240')]
    public $upload_ba_penolakan;
    #[Validate('nullable|file|mimes:pdf,jpg,jpeg,png|max:10240')]
    public $upload_ba_survey;
    #[Validate('nullable|file|mimes:pdf,jpg,jpeg,png|max:10240')]
    public $upload_ba_survey_surveyor;
    #[Validate('nullable|file|mimes:pdf,jpg,jpeg,png|max:10240')]
    public $upload_ba_wawancara;
    #[Validate('nullable|file|mimes:pdf,jpg,jpeg,png|max:10240')]
    public $upload_ba_penerapan_sanksi;
    #[Validate('nullable|file|mimes:pdf,jpg,jpeg,png|max:10240')]
    public $upload_ba_sosialisasi;
    #[Validate('nullable|file|mimes:pdf,jpg,jpeg,png|max:10240')]
    public $upload_sk_sanksi_pemberhentian;

    public function render()
    {
        return view('livewire.admin.pelanggaran.analis.pelanggaran-analis-detail');
    }

    #[On('refresh-pelanggaran-analis-list')]
    public function refresh() {
        $this->mount($this->pelanggaran->id);
    }

    public function mount($id)
    {
        $this->pelanggaran = Pelanggaran::find($id);
        $this->temuan_pelanggaran = $this->pelanggaran->temuan_pelanggaran;
        $this->tindak_lanjut = $this->pelanggaran->tindak_lanjut;
        $this->tgl_evaluasi = $this->pelanggaran->tgl_evaluasi;
        $this->status_pelanggaran = $this->pelanggaran->status;
        $this->existing_foto_tindak_lanjut = $this->pelanggaran->foto_tindak_lanjut ?? [];
        $this->existing_foto_existing = $this->pelanggaran->foto_existing ?? [];
    }

    public function storeAnalisa()
    {
        if ($this->temuan_pelanggaran == 'Ada Pelanggaran') {
            $this->validate();
        } else {
            $this->validate([
                'temuan_pelanggaran' => 'required'
            ]);
        }

        $all_photos = $this->existing_foto_tindak_lanjut;

        if($this->foto_tindak_lanjut)
        {
            foreach ($this->foto_tindak_lanjut as $foto) {
                $foto_tindak_lanjut_filename = $this->pelanggaran->no_pelanggaran . '_' . Str::random(5) . '.' . $foto->getClientOriginalExtension();
                $all_photos[] = $foto->storeAs('pelanggaran/'.$this->pelanggaran->no_pelanggaran.'/foto_tindak_lanjut', $foto_tindak_lanjut_filename, 'public');
            }
        }

        $updateData = [
            'temuan_pelanggaran' => $this->temuan_pelanggaran,
            'tindak_lanjut' => $this->tindak_lanjut,
            'foto_tindak_lanjut' => count($all_photos) > 0 ? $all_photos : null,
        ];

        // Handle Document Uploads
        $documentTemplates = [
            'upload_sp1' => 'file_sp1',
            'upload_sp2' => 'file_sp2',
            'upload_sp3' => 'file_sp3',
            'upload_pelimpahan_polpp' => 'file_pelimpahan_polpp',
            'upload_pernyataan' => 'file_pernyataan',
            'upload_sosialisasi' => 'file_sosialisasi',
            'upload_ba_pengambilan_dokumen' => 'file_ba_pengambilan_dokumen',
            'upload_ba_penolakan' => 'file_ba_penolakan',
            'upload_ba_survey' => 'file_ba_survey',
            'upload_ba_survey_surveyor' => 'file_ba_survey_surveyor',
            'upload_ba_wawancara' => 'file_ba_wawancara',
            'upload_ba_penerapan_sanksi' => 'file_ba_penerapan_sanksi',
            'upload_ba_sosialisasi' => 'file_ba_sosialisasi',
            'upload_sk_sanksi_pemberhentian' => 'file_sk_sanksi_pemberhentian',

        ];

        foreach ($documentTemplates as $property => $column) {
            if ($this->$property) {
                $fileName = Str::upper(str_replace('upload_', '', $property)) . '_' . $this->pelanggaran->no_pelanggaran . '_' . Str::random(5) . '.' . $this->$property->getClientOriginalExtension();
                $updateData[$column] = $this->$property->storeAs('pelanggaran/'.$this->pelanggaran->no_pelanggaran.'/dokumen', $fileName, 'public');
            }
        }

        $this->pelanggaran->update($updateData);

        session()->flash('message', 'Analisa Pelanggaran Berhasil Ditambahkan!');

        $this->dispatch('refresh-pelanggaran-analis-list');
        $this->dispatch('closeModal');

        // Reset new photos after save
        $this->foto_tindak_lanjut = [];
        $this->upload_sp1 = null;
        $this->upload_sp2 = null;
        $this->upload_sp3 = null;
        $this->upload_pelimpahan_polpp = null;
        $this->upload_pernyataan = null;
        $this->upload_sosialisasi = null;
        $this->upload_ba_pengambilan_dokumen = null;
        $this->upload_ba_penolakan = null;
        $this->upload_ba_survey = null;
        $this->upload_ba_survey_surveyor = null;
        $this->upload_ba_wawancara = null;
        $this->upload_ba_penerapan_sanksi = null;
        $this->upload_ba_sosialisasi = null;
        $this->upload_sk_sanksi_pemberhentian = null;
    }

    public function removeImage($index)
    {
        unset($this->foto_tindak_lanjut[$index]);
        $this->foto_tindak_lanjut = array_values($this->foto_tindak_lanjut);
    }

    public function removeExistingImage($index)
    {
        unset($this->existing_foto_tindak_lanjut[$index]);
        $this->existing_foto_tindak_lanjut = array_values($this->existing_foto_tindak_lanjut);
    }

    public function removeTempFotoExisting($index)
    {
        unset($this->temp_foto_existing[$index]);
        $this->temp_foto_existing = array_values($this->temp_foto_existing);
    }

    public function removeExistingFotoExisting($index)
    {
        unset($this->existing_foto_existing[$index]);
        $this->existing_foto_existing = array_values($this->existing_foto_existing);
    }

    public function storeEvaluasi()
    {
        $this->validate([
            'tgl_evaluasi' => 'nullable|date',
            'status_pelanggaran' => 'required',
            'temp_foto_existing.*' => 'image|max:10240'
        ]);

        $all_existing_photos = $this->existing_foto_existing;

        if($this->temp_foto_existing)
        {
            foreach ($this->temp_foto_existing as $foto) {
                $filename = $this->pelanggaran->no_pelanggaran . '_eval_' . Str::random(5) . '.' . $foto->getClientOriginalExtension();
                $all_existing_photos[] = $foto->storeAs('pelanggaran/'.$this->pelanggaran->no_pelanggaran.'/foto_existing', $filename, 'public');
            }
        }

        $this->pelanggaran->update([
            'tgl_evaluasi' => $this->tgl_evaluasi,
            'status' => $this->status_pelanggaran,
            'foto_existing' => count($all_existing_photos) > 0 ? $all_existing_photos : null,
        ]);

        session()->flash('message', 'Evaluasi Pelanggaran Berhasil Diperbarui!');

        $this->dispatch('refresh-pelanggaran-analis-list');
        $this->dispatch('closeEvaluasiModal');

        $this->temp_foto_existing = [];
    }

    public function downloadSP1()
    {
        $data = $this->pelanggaran;

        $data = [
            'jenis_indikasi_pelanggaran' => $data->jenis_indikasi_pelanggaran,
            'nama_pemilik_bangunan' => $data->nama_pelanggar,
            'alamat_pelanggaran' => $data->alamat_pelanggaran,
            'kel_pelanggaran' => $data->kel_pelanggaran,
            'kec_pelanggaran' => $data->kec_pelanggaran,
            'jenis_pemanfaatan_ruang' => $data->jenis_pemanfaatan_ruang,
        ];

        return $this->generateDocument('SURAT_PERINGATAN_1.docx', $data);
    }

    public function downloadSP2()
    {
        $data = $this->pelanggaran;

        $data = [
            'jenis_indikasi_pelanggaran' => $data->jenis_indikasi_pelanggaran,
            'nama_pemilik_bangunan' => $data->nama_pelanggar,
            'alamat_pelanggaran' => $data->alamat_pelanggaran,
            'kel_pelanggaran' => $data->kel_pelanggaran,
            'kec_pelanggaran' => $data->kec_pelanggaran,
            'jenis_pemanfaatan_ruang' => $data->jenis_pemanfaatan_ruang,
        ];

        return $this->generateDocument('SURAT_PERINGATAN_2.docx', $data);
    }

    public function downloadSP3()
    {
        $data = $this->pelanggaran;

        $data = [
            'jenis_indikasi_pelanggaran' => $data->jenis_indikasi_pelanggaran,
            'nama_pemilik_bangunan' => $data->nama_pelanggar,
            'alamat_pelanggaran' => $data->alamat_pelanggaran,
            'kel_pelanggaran' => $data->kel_pelanggaran,
            'kec_pelanggaran' => $data->kec_pelanggaran,
            'jenis_pemanfaatan_ruang' => $data->jenis_pemanfaatan_ruang,
        ];

        return $this->generateDocument('SURAT_PERINGATAN_3.docx', $data);
    }

    public function downloadSuratPelimpahanBerkasPolPP()
    {
        $data = $this->pelanggaran;

        $data = [
            'jenis_indikasi_pelanggaran' => $data->jenis_indikasi_pelanggaran,
            'nama_pemilik_bangunan' => $data->nama_pelanggar,
            'alamat_pelanggaran' => $data->alamat_pelanggaran,
            'kel_pelanggaran' => $data->kel_pelanggaran,
            'kec_pelanggaran' => $data->kec_pelanggaran,
            'jenis_pemanfaatan_ruang' => $data->jenis_pemanfaatan_ruang,
        ];

        return $this->generateDocument('SURAT_PELIMPAHAN_BERKAS_POLPP.docx', $data);
    }

    public function downloadSuratPernyataan()
    {
        $data = $this->pelanggaran;

        $data = [
            'jenis_indikasi_pelanggaran' => $data->jenis_indikasi_pelanggaran,
            'nama_pemilik_bangunan' => $data->nama_pelanggar,
            'alamat_pelanggaran' => $data->alamat_pelanggaran,
            'kel_pelanggaran' => $data->kel_pelanggaran,
            'kec_pelanggaran' => $data->kec_pelanggaran,
            'jenis_pemanfaatan_ruang' => $data->jenis_pemanfaatan_ruang,
        ];

        return $this->generateDocument('SURAT_PERNYATAAN_PELANGGARAN_PEMANFAATAN_RUANG.docx', $data);
    }

    public function downloadSuratSosialisasi(){
        $data = $this->pelanggaran;

        $data = [
            'jenis_indikasi_pelanggaran' => $data->jenis_indikasi_pelanggaran,
            'nama_pemilik_bangunan' => $data->nama_pelanggar,
            'alamat_pelanggaran' => $data->alamat_pelanggaran,
            'kel_pelanggaran' => $data->kel_pelanggaran,
            'kec_pelanggaran' => $data->kec_pelanggaran,
            'jenis_pemanfaatan_ruang' => $data->jenis_pemanfaatan_ruang,
        ];

        return $this->generateDocument('SURAT_SOSIALISASI_PELANGGARAN.docx', $data);
    }

    public function downloadBAPengambilanDokumen(){
        $data = $this->pelanggaran;

        $data = [
            'jenis_indikasi_pelanggaran' => $data->jenis_indikasi_pelanggaran,
            'alamat_pelanggaran' => $data->alamat_pelanggaran,
            'kel_pelanggaran' => $data->kel_pelanggaran,
            'kec_pelanggaran' => $data->kec_pelanggaran,
        ];

        return $this->generateDocument('1_BA_PENGAMBILAN_DOKUMEN.docx', $data);
    }

    public function downloadBAPenolakan(){
        $data = $this->pelanggaran;

        $data = [
            'jenis_indikasi_pelanggaran' => $data->jenis_indikasi_pelanggaran,
            'alamat_pelanggaran' => $data->alamat_pelanggaran,
            'kel_pelanggaran' => $data->kel_pelanggaran,
            'kec_pelanggaran' => $data->kec_pelanggaran,
        ];

        return $this->generateDocument('2_BA_PENOLAKAN.docx', $data);
    }

    public function downloadBASurvey(){
        $data = $this->pelanggaran;
        $koordinat = $data->koordinat_pelanggaran;
        $koordinat = explode(',', $koordinat);

        $data = [
            'jenis_indikasi_pelanggaran' => $data->jenis_indikasi_pelanggaran,
            'alamat_pelanggaran' => $data->alamat_pelanggaran,
            'kel_pelanggaran' => $data->kel_pelanggaran,
            'kec_pelanggaran' => $data->kec_pelanggaran,
            'nama_pemilik_bangunan' => $data->nama_pelanggar,
            'latitude' => $koordinat[0],
            'longitude' => $koordinat[1],
            'gmaps' => $data->gmaps,
            'alamat_pelanggar' => $data->alamat_pelanggar,
            'kel_pelanggar' => $data->kel_pelanggar,
            'kec_pelanggar' => $data->kec_pelanggar,
            'kota_pelanggar' => $data->kota_pelanggar,
            'prov_pelanggar' => $data->prov_pelanggar,
        ];

        return $this->generateDocument('3A_BA_SURVEI_LAPANGAN.docx', $data);
    }

    public function downloadBASurveySurveyor(){
        $data = $this->pelanggaran;

        $data = [
            'nama_pemilik_bangunan' => $data->nama_pelanggar,
        ];

        return $this->generateDocument('3B_BA_SURVEI_LAPANGAN_SURVEYOR.docx', $data);
    }

    public function downloadBAWawancara(){
        $data = $this->pelanggaran;

        $data = [
            'nama_pemilik_bangunan' => $data->nama_pelanggar,
        ];

        return $this->generateDocument('4A_BA_WAWANCARA.docx', $data);
    }

    public function downloadPenerapanSanksi(){
        $data = $this->pelanggaran;

        $data = [
            'jenis_indikasi_pelanggaran' => $data->jenis_indikasi_pelanggaran,
            'alamat_pelanggaran' => $data->alamat_pelanggaran,
            'kel_pelanggaran' => $data->kel_pelanggaran,
            'kec_pelanggaran' => $data->kec_pelanggaran,
            'nama_pemilik_bangunan' => $data->nama_pelanggar,
            'alamat_pelanggar' => $data->alamat_pelanggar,
            'kel_pelanggar' => $data->kel_pelanggar,
            'kec_pelanggar' => $data->kec_pelanggar,
            'kota_pelanggar' => $data->kota_pelanggar,
            'prov_pelanggar' => $data->prov_pelanggar,
        ];

        return $this->generateDocument('5_BA_PENERAPAN_SANKSI.docx', $data);
    }

    public function downloadBASosialisasi(){
        $data = $this->pelanggaran;

        $data = [
            'jenis_indikasi_pelanggaran' => $data->jenis_indikasi_pelanggaran,
            'alamat_pelanggaran' => $data->alamat_pelanggaran,
            'kel_pelanggaran' => $data->kel_pelanggaran,
            'kec_pelanggaran' => $data->kec_pelanggaran,
            'nama_pemilik_bangunan' => $data->nama_pelanggar,
        ];

        return $this->generateDocument('6_BA_SOSIALISASI.docx', $data);
    }

    public function downloadSKSanksiPemberhentian(){
        $data = $this->pelanggaran;

        $data = [
            'jenis_indikasi_pelanggaran' => $data->jenis_indikasi_pelanggaran,
            'alamat_pelanggaran' => strtoupper($data->alamat_pelanggaran),
            'kel_pelanggaran' => $data->kel_pelanggaran,
            'kec_pelanggaran' => strtoupper($data->kec_pelanggaran),
            'nama_pemilik_bangunan' => $data->nama_pelanggar,
        ];

        return $this->generateDocument('10_SK_SANKSI_PEMBERHENTIAN.docx', $data);
    }

    private function generateDocument($templatePath, $data)
    {
        $templateProcessor = new TemplateProcessor(public_path('templates/pelanggaran/'.$templatePath));

        foreach ($data as $key => $value) {
            $templateProcessor->setValue($key, $value);
        }

        $baseName = str_replace('.docx', '', basename($templatePath));
        $name = $data['nama_pemilik_bangunan'] ?? $data['jenis_indikasi_pelanggaran'];
        $sanitizedName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $name);
        $fileName = $baseName . '_' . $sanitizedName . '.docx';
        $tempPath = storage_path('app' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . $fileName);

        $templateProcessor->saveAs($tempPath);

        return response()->download($tempPath)->deleteFileAfterSend(true);
    }
}
