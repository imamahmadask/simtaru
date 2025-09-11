<?php

namespace App\Livewire\Admin\Permohonan\Skrk;

use App\Models\Permohonan;
use App\Models\PermohonanBerkas;
use App\Models\Skrk;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

class SkrkSurveyCreate extends Component
{
    use WithFileUploads;

    public $tahapan, $permohonan_id, $skrk_id;

    #[Validate('required')]
    public $tgl_survey, $koordinat;

    #[Validate(['foto_survey.*' => 'image|max:1024'])]
    public $foto_survey = [];

    public $file_ = [];

    public function render()
    {
        $permohonan = Permohonan::findOrFail($this->permohonan_id);
        $tahapan_id = $permohonan->layanan->tahapan->where('nama', 'Survey')->value('id');
        $persyaratan_berkas = $permohonan->persyaratanBerkas->where('tahapan_id', $tahapan_id);

        return view('livewire.admin.permohonan.skrk.skrk-survey-create', [
            'persyaratan_berkas' => $persyaratan_berkas
        ]);
    }

    public function createSurvey()
    {
        $this->validate();

        $permohonan = Permohonan::findOrFail($this->permohonan_id);
        $skrk = Skrk::findOrFail($this->skrk_id);
        $no_reg = $skrk->registrasi->kode;

        foreach ($permohonan->persyaratanBerkas as $item) {
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
            $foto_survey_path = null;
        }

        $skrk->update([
           'tgl_survey' => $this->tgl_survey,
           'koordinat' => $this->koordinat,
           'foto_survey' => $foto_survey_path
        ]);

        session()->flash('success', 'Data Survey berhasil ditambahkan!');

        return redirect()->route('skrk.detail', ['id' => $this->skrk_id]);
    }

    public function mount($permohonan_id, $skrk_id)
    {
        $this->permohonan_id = $permohonan_id;
        $this->skrk_id = $skrk_id;
    }
}
