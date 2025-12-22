<?php

namespace App\Livewire\Admin\Permohonan\Itr\Survey;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use App\Models\Permohonan;
use App\Models\Itr;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Validate;

class ItrSurveyEdit extends Component
{
    use WithFileUploads;

    public $permohonan, $itr, $tahapans, $users;
    public $foto_survey_lama, $gambar_peta_lama;

    #[Validate('required')]
    public $tgl_survey, $batas_utara, $batas_selatan, $batas_timur, $batas_barat;

    #[Validate(['foto_survey.*' => 'image|max:1024'])]
    public $foto_survey = [];

    #[Validate(['gambar_peta.*' => 'image|max:1024'])]
    public $gambar_peta = [];

    public $gambar_peta_selected = [];
    public $foto_survey_selected = [];

    public $koordinat = [];

    public function render()
    {
        return view('livewire.admin.permohonan.itr.survey.itr-survey-edit');
    }

    public function EditSurvey()
    {
        $this->validate();
        $foto_survey_path = [];
        $gambar_peta_path = [];

        $no_reg = $this->itr->registrasi->kode;

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
                $foto_survey_path[] = $foto->storeAs('itr/foto_survey', $foto_survey_filename, 'public');
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
                $gambar_peta_path[] = $foto->storeAs('itr/gambar_peta', $gambar_peta_filename, 'public');
            }
        }

        // update tabel survey
        $this->itr->update([
           'tgl_survey' => $this->tgl_survey,
           'koordinat' => $this->koordinat,
           'foto_survey' => $foto_survey_path,
           'gambar_peta' => $gambar_peta_path,
           'batas_persil' => [
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

        $this->dispatch('refresh-itr-survey-list');

        $this->dispatch('trigger-close-modal');
    }

    public function mount($permohonan_id, $itr_id)
    {
        $this->itr = Itr::find($itr_id);
        $this->permohonan = Permohonan::findOrFail($permohonan_id);

        $this->koordinat = $this->itr->koordinat ?? [
            ['x' => '', 'y' => ''],
            ['x' => '', 'y' => ''],
            ['x' => '', 'y' => ''],
            ['x' => '', 'y' => ''], // minimal 4
        ];
        $this->tgl_survey = $this->itr->tgl_survey;
        $this->foto_survey_lama = $this->itr->foto_survey
        ? json_decode($this->itr->foto_survey, true)
        : [];
        $this->gambar_peta_lama = $this->itr->gambar_peta
        ? json_decode($this->itr->gambar_peta, true)
        : [];
        $this->gambar_peta_selected = $this->gambar_peta_lama;
        $this->foto_survey_selected = $this->foto_survey_lama;
        $this->batas_barat = $this->itr->batas_administratif['barat'] ?? '';
        $this->batas_selatan = $this->itr->batas_administratif['selatan'] ?? '';
        $this->batas_timur = $this->itr->batas_administratif['timur'] ?? '';
        $this->batas_utara = $this->itr->batas_administratif['utara'] ?? '';
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
