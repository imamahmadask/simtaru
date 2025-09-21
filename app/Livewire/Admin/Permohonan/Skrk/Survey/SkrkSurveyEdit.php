<?php

namespace App\Livewire\Admin\Permohonan\Skrk\Survey;

use App\Models\Disposisi;
use App\Models\Permohonan;
use App\Models\PermohonanBerkas;
use App\Models\RiwayatPermohonan;
use App\Models\Skrk;
use App\Models\Tahapan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

class SkrkSurveyEdit extends Component
{
    use WithFileUploads;

    public $permohonan, $skrk, $tahapans, $users, $permohonan_id, $skrk_id, $catatan, $disposisi;
    public $foto_survey_lama;

    #[Validate('required')]
    public $tahapan_id, $penerima_id;

    #[Validate('required')]
    public $tgl_survey;

    #[Validate(['foto_survey.*' => 'image|max:1024'])]
    public $foto_survey = [];

    public $file_ = [];

    public $koordinat = [];
    public function render()
    {
        $tahapan_survey = $this->permohonan->layanan->tahapan->where('nama', 'Survey')->value('id');
        $persyaratan_berkas = $this->permohonan->persyaratanBerkas->where('tahapan_id', $tahapan_survey);

        return view('livewire.admin.permohonan.skrk.survey.skrk-survey-edit', [
            'persyaratan_berkas' => $persyaratan_berkas
        ]);
    }

    public function EditSurvey()
    {
        $this->validate();

        $no_reg = $this->skrk->registrasi->kode;

        foreach ($this->permohonan->persyaratanBerkas as $item) {
            // cek apakah file untuk persyaratan ini diupload
            if (!empty($this->file_[$item->kode])) {
                $uploadedFile = $this->file_[$item->kode];

                // buat nama file unik -> {no_reg}_{kode}.{ext}
                $filename = $no_reg . '_' . $item->kode . '.' . $uploadedFile->getClientOriginalExtension();

                // simpan file ke storage/app/public/skrk_form_survey
                $path = $uploadedFile->storeAs(
                    'skrk_form_survey/' . $no_reg, // folder per registrasi
                    $filename,
                    'public'
                );

                // simpan ke database
                PermohonanBerkas::updateOrCreate(
                    [
                        'permohonan_id'        => $this->permohonan_id,
                        'persyaratan_berkas_id'=> $item->id,
                    ],
                    [
                        'file_path'           => $path,
                        'uploaded_by'         => Auth::id(),
                        'uploaded_at'         => now(),
                        'status'              => 'menunggu',
                        'catatan_verifikator' => null,
                    ]
                );
            }
        }

        if($this->foto_survey) {
            $foto_survey_path = [];
            foreach ($this->foto_survey as $foto) {
                $foto_survey_filename = $no_reg . '_' . Str::random(5) . '.' . $foto->getClientOriginalExtension();
                $foto_survey_path[] = $foto->storeAs('skrk_foto_survey', $foto_survey_filename, 'public');
            }
        }
        else
        {
            $foto_survey_path = $this->foto_survey_lama;
        }

        // update tabel survey
        $this->skrk->update([
           'tgl_survey' => $this->tgl_survey,
           'koordinat' => $this->koordinat,
           'foto_survey' => $foto_survey_path
        ]);

        // update tabel disposisi
        if($this->disposisi->penerima_id != $this->penerima_id || $this->disposisi->catatan != $this->catatan){
            $this->disposisi->update([
                'penerima_id' => $this->penerima_id,
                'catatan' => $this->catatan,
                'updated_by' => Auth::user()->id
            ]);
        }

        session()->flash('success', 'Data Survey berhasil diupdate!');

        return redirect()->route('skrk.detail', ['id' => $this->skrk_id]);
    }

    public function mount($permohonan_id, $skrk_id)
    {
        $this->permohonan_id = $permohonan_id;
        $this->skrk_id = $skrk_id;
        $this->skrk = Skrk::find($this->skrk_id);
        $this->permohonan = Permohonan::findOrFail($this->permohonan_id);
        $this->tahapans = Tahapan::where('layanan_id', $this->permohonan->layanan_id)->where('urutan', 2)->get();
        $this->users = User::where('role', 'analis')->get();

        $this->koordinat = $this->skrk->koordinat ?? [
            ['x' => '', 'y' => ''],
            ['x' => '', 'y' => ''],
            ['x' => '', 'y' => ''],
            ['x' => '', 'y' => ''], // minimal 4
        ];
        $this->tgl_survey = $this->skrk->tgl_survey;
         $this->foto_survey_lama = $this->skrk->foto_survey
        ? json_decode($this->skrk->foto_survey, true)
        : [];

        $tahapan_analis = Tahapan::where('nama', 'Analisis')->value('id');
        $this->disposisi = $this->permohonan->disposisi->where('tahapan_id', $tahapan_analis)->first();

        if($this->disposisi) {
            $this->tahapan_id = $this->disposisi->tahapan_id;
            $this->penerima_id = $this->disposisi->penerima_id;
            $this->catatan = $this->disposisi->catatan;
        }

    }

    public function addRow()
    {
        if (count($this->koordinat) < 8) {
            $this->koordinat[] = ['x' => '', 'y' => ''];
        }
    }

    public function removeRow($index)
    {
        if (count($this->koordinat) > 4) { // minimal 4 titik
            unset($this->koordinat[$index]);
            $this->koordinat = array_values($this->koordinat);
        }
    }
}
