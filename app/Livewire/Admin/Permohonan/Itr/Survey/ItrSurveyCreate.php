<?php

namespace App\Livewire\Admin\Permohonan\Itr\Survey;

use App\Models\Itr;
use App\Models\Permohonan;
use App\Models\RiwayatPermohonan;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;


class ItrSurveyCreate extends Component
{
    use WithFileUploads;
    public $permohonan_id, $itr_id, $tahapan_id;

    #[Validate(['foto_survey.*' => 'image|max:10240'])]
    public $foto_survey = [];

    #[Validate(['gambar_peta.*' => 'image|max:10240'])]
    public $gambar_peta = [];

    #[Validate('required')]
    public $tgl_survey, $batas_utara, $batas_selatan, $batas_timur, $batas_barat;

    public $koordinat = [];

    public function render()
    {
        return view('livewire.admin.permohonan.itr.survey.itr-survey-create');
    }

    public function createSurvey()
    {
        $this->validate();
        $permohonan = Permohonan::findOrFail($this->permohonan_id);
        $itr = Itr::findOrFail($this->itr_id);
        $no_reg = $itr->registrasi->kode;

        if($this->foto_survey) {
            $foto_survey_path = [];
            foreach ($this->foto_survey as $foto) {
                $foto_survey_filename = $no_reg . '_' . Str::random(5) . '.' . $foto->getClientOriginalExtension();
                $foto_survey_path[] = $foto->storeAs('itr/foto_survey', $foto_survey_filename, 'public');
            }
        }
        else
        {
            $foto_survey_path = null;
        }

        if($this->gambar_peta) {
            $gambar_peta_path = [];
            foreach ($this->gambar_peta as $foto) {
                $gambar_peta_filename = $no_reg . '_' . Str::random(5) . '.' . $foto->getClientOriginalExtension();
                $gambar_peta_path[] = $foto->storeAs('itr/gambar_peta', $gambar_peta_filename, 'public');
            }
        }
        else
        {
            $gambar_peta_path = null;
        }

        // update tabel survey
        $itr->update([
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

        $this->reset('tgl_survey', 'koordinat', 'foto_survey', 'gambar_peta', 'batas_utara', 'batas_selatan', 'batas_timur', 'batas_barat');

        $this->dispatch('toast', [
            'type'    => 'success',
            'message' => 'Data Survey berhasil ditambahkan!'
        ]);

        $this->dispatch('refresh-itr-survey-list');

        $this->dispatch('trigger-close-modal');
    }

    public function mount($permohonan_id, $itr_id)
    {
        $this->permohonan_id = $permohonan_id;
        $this->itr_id = $itr_id;

         $this->koordinat = $itr->koordinat ?? [
            ['x' => '', 'y' => ''],
            ['x' => '', 'y' => ''],
            ['x' => '', 'y' => ''],
            ['x' => '', 'y' => ''], // minimal 4
        ];
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

    private function createRiwayat(Permohonan $permohonan, string $keterangan)
    {
        RiwayatPermohonan::create([
            'registrasi_id' => $permohonan->registrasi_id,
            'user_id' => Auth::user()->id,
            'keterangan' => $keterangan
        ]);
    }
}
