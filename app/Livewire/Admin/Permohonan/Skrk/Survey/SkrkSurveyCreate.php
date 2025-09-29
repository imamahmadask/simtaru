<?php

namespace App\Livewire\Admin\Permohonan\Skrk\Survey;

use App\Models\Disposisi;
use App\Models\Permohonan;
use App\Models\RiwayatPermohonan;
use App\Models\Skrk;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

class SkrkSurveyCreate extends Component
{
    use WithFileUploads;
    public $permohonan_id, $skrk_id, $tahapan_id;

    #[Validate(['foto_survey.*' => 'image|max:1024'])]
    public $foto_survey = [];

    #[Validate(['gambar_peta.*' => 'image|max:1024'])]
    public $gambar_peta = [];

    #[Validate('required')]
    public $tgl_survey, $batas_utara, $batas_selatan, $batas_timur, $batas_barat;

    public $koordinat = [];

    public function render()
    {
        return view('livewire.admin.permohonan.skrk.survey.skrk-survey-create');
    }

    public function createSurvey()
    {
        $this->validate();

        $permohonan = Permohonan::findOrFail($this->permohonan_id);
        $skrk = Skrk::findOrFail($this->skrk_id);
        $no_reg = $skrk->registrasi->kode;

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

        if($this->gambar_peta) {
            $gambar_peta_path = [];
            foreach ($this->gambar_peta as $foto) {
                $gambar_peta_filename = $no_reg . '_' . Str::random(5) . '.' . $foto->getClientOriginalExtension();
                $gambar_peta_path[] = $foto->storeAs('skrk_gambar_peta', $gambar_peta_filename, 'public');
            }
        }
        else
        {
            $gambar_peta_path = null;
        }

        // update tabel survey
        $skrk->update([
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

        $this->createRiwayat($permohonan, 'Entry Data Survey');

        session()->flash('success', 'Data Survey berhasil ditambahkan!');

        return redirect()->route('skrk.detail', ['id' => $this->skrk_id]);
    }

    public function mount($permohonan_id, $skrk_id)
    {
        $this->permohonan_id = $permohonan_id;
        $this->skrk_id = $skrk_id;

         $this->koordinat = $skrk->koordinat ?? [
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
