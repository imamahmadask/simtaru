<?php

namespace App\Livewire\Admin\Permohonan\Skrk\Survey;

use App\Models\Permohonan;
use App\Models\Skrk;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Livewire\Attributes\On;

class SkrkSurveyEdit extends Component
{
    use WithFileUploads;

    public $permohonan, $skrk, $tahapans, $users;
    public $foto_survey_lama, $gambar_peta_lama;

    #[Validate('required')]
    public $tgl_survey, $batas_utara, $batas_selatan, $batas_timur, $batas_barat;

    #[Validate(['foto_survey.*' => 'image|max:10240'])]
    public $foto_survey = [];

    #[Validate(['gambar_peta.*' => 'image|max:10240'])]
    public $gambar_peta = [];

    public $gambar_peta_selected = [];
    public $foto_survey_selected = [];

    public $koordinat = [];
    public function render()
    {
        return view('livewire.admin.permohonan.skrk.survey.skrk-survey-edit');
    }

    public function EditSurvey()
    {
        $this->validate();
        $foto_survey_path = [];
        $gambar_peta_path = [];

        $no_reg = $this->skrk->registrasi->kode;

        // Foto Survey
        foreach ($this->foto_survey_lama as $foto) {
            if (in_array($foto, $this->foto_survey_selected)) {
                $foto_survey_path[] = $foto;
            } else {
                // hapus file dari storage jika user tidak pilih lagi
                if (Storage::disk('public')->exists($foto)) {
                    Storage::disk('public')->delete($foto);
                }
            }
        }
        if (!empty($this->foto_survey)) {
            foreach ($this->foto_survey as $foto) {
                $foto_survey_filename = $no_reg . '_' . Str::random(5) . '.' . $foto->getClientOriginalExtension();
                $foto_survey_path[] = $foto->storeAs('skrk/foto_survey', $foto_survey_filename, 'public');
            }
        }

        // Gambar Peta
        foreach ($this->gambar_peta_lama as $foto) {
            if (in_array($foto, $this->gambar_peta_selected)) {
                $gambar_peta_path[] = $foto;
            } else {
                // hapus file dari storage jika user tidak pilih lagi
                if (Storage::disk('public')->exists($foto)) {
                    Storage::disk('public')->delete($foto);
                }
            }
        }
        if (!empty($this->gambar_peta)) {
            foreach ($this->gambar_peta as $foto) {
                $gambar_peta_filename = $no_reg . '_' . Str::random(5) . '.' . $foto->getClientOriginalExtension();
                $gambar_peta_path[] = $foto->storeAs('skrk/gambar_peta', $gambar_peta_filename, 'public');
            }
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

        $this->dispatch('toast', [
            'type'    => 'success',
            'message' => 'Data Survey berhasil diupdate!'
        ]);

        $this->dispatch('refresh-skrk-survey-list');

        $this->dispatch('trigger-close-modal');
    }

    #[On('skrk-survey-edit')]
    public function getSurvey($permohonan_id, $skrk_id)
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
        $this->gambar_peta_lama = $this->skrk->gambar_peta
        ? json_decode($this->skrk->gambar_peta, true)
        : [];
        $this->gambar_peta_selected = $this->gambar_peta_lama;
        $this->foto_survey_selected = $this->foto_survey_lama;
        $this->batas_barat = $this->skrk->batas_administratif['barat'] ?? '';
        $this->batas_selatan = $this->skrk->batas_administratif['selatan'] ?? '';
        $this->batas_timur = $this->skrk->batas_administratif['timur'] ?? '';
        $this->batas_utara = $this->skrk->batas_administratif['utara'] ?? '';
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
