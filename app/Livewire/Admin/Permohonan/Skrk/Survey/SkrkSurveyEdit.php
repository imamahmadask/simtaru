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

    public $permohonan, $skrk, $tahapans, $users;
    public $foto_survey_lama, $gambar_peta_lama;

    #[Validate('required')]
    public $tgl_survey, $batas_utara, $batas_selatan, $batas_timur, $batas_barat;

    #[Validate(['foto_survey.*' => 'image|max:1024'])]
    public $foto_survey = [];
    public $gambar_peta;

    public $koordinat = [];
    public function render()
    {
        return view('livewire.admin.permohonan.skrk.survey.skrk-survey-edit');
    }

    public function EditSurvey()
    {
        $this->validate();

        $no_reg = $this->skrk->registrasi->kode;

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

        if($this->gambar_peta) {
            $gambar_peta_filename = $no_reg . '_' . Str::random(5) . '.' . $this->gambar_peta->getClientOriginalExtension();
            $gambar_peta_path = $this->gambar_peta->storeAs('skrk_gambar_peta', $gambar_peta_filename, 'public');
        }
        else
        {
            $gambar_peta_path = $this->gambar_peta_lama;
        }

        // update tabel survey
        $this->skrk->update([
           'tgl_survey' => $this->tgl_survey,
           'koordinat' => $this->koordinat,
           'foto_survey' => $foto_survey_path,
           'gambar_peta' => $gambar_peta_path,
           'batas_administratif' => [
                'utara' => $this->batas_utara,
                'selatan' => $this->batas_selatan,
                'timur' => $this->batas_timur,
                'barat' => $this->batas_barat,
            ],
        ]);

        session()->flash('success', 'Data Survey berhasil diupdate!');

        return redirect()->route('skrk.detail', ['id' => $this->skrk->id]);
    }

    public function mount($permohonan_id, $skrk_id)
    {
        $this->skrk = Skrk::find($skrk_id);
        $this->permohonan = Permohonan::findOrFail($permohonan_id);

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

        $this->gambar_peta_lama = $this->skrk->gambar_peta;
        $this->batas_barat = $this->skrk->batas_administratif['barat'];
        $this->batas_selatan = $this->skrk->batas_administratif['selatan'];
        $this->batas_timur = $this->skrk->batas_administratif['timur'];
        $this->batas_utara = $this->skrk->batas_administratif['utara'];
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
