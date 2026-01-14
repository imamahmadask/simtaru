<?php

namespace App\Livewire\Admin\Permohonan\Kkprnb\Survey;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use App\Models\Permohonan;
use App\Models\Kkprnb;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;

class KkprnbSurveyEdit extends Component
{
    use WithFileUploads;

    public $permohonan, $kkprnb, $tahapans, $users;
    public $foto_survey_lama, $gambar_peta_lama;
    public $ada_bangunan, $status_jalan, $fungsi_jalan, $tipe_jalan, $median_jalan, $lebar_jalan, $pola_ruang;

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
        return view('livewire.admin.permohonan.kkprnb.survey.kkprnb-survey-edit');
    }

    public function EditSurvey()
    {
        $this->validate();
        $foto_survey_path = [];
        $gambar_peta_path = [];

        $no_reg = $this->kkprnb->registrasi->kode;

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
                $foto_survey_path[] = $foto->storeAs('kkprnb/foto_survey', $foto_survey_filename, 'public');
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
                $gambar_peta_path[] = $foto->storeAs('kkprnb/gambar_peta', $gambar_peta_filename, 'public');
            }
        }

        // update tabel survey
        $this->kkprnb->update([
           'tgl_survey' => $this->tgl_survey,
           'ada_bangunan' => $this->ada_bangunan,
           'status_jalan' => $this->status_jalan,
           'fungsi_jalan' => $this->fungsi_jalan,
           'tipe_jalan' => $this->tipe_jalan,
           'median_jalan' => $this->median_jalan,
           'lebar_jalan' => $this->lebar_jalan,
           'koordinat' => $this->koordinat,
           'foto_survey' => $foto_survey_path,
           'gambar_peta' => $gambar_peta_path,
           'batas_persil' => [
                'utara' => $this->batas_utara,
                'selatan' => $this->batas_selatan,
                'timur' => $this->batas_timur,
                'barat' => $this->batas_barat,
            ],
            'pola_ruang' => $this->pola_ruang,
        ]);

        $this->reset('tgl_survey', 'ada_bangunan', 'status_jalan', 'fungsi_jalan', 'tipe_jalan', 'median_jalan', 'lebar_jalan', 'koordinat', 'foto_survey', 'gambar_peta', 'batas_utara', 'batas_selatan', 'batas_timur', 'batas_barat', 'pola_ruang');

        $this->dispatch('toast', [
            'type'    => 'success',
            'message' => 'Data Survey berhasil diupdate!'
        ]);

        $this->dispatch('refresh-kkprnb-survey-list');

        $this->dispatch('trigger-close-modal');
    }

    #[On('kkprnb-survey-edit')]
    public function getSurvey($permohonan_id, $kkprnb_id)
    {
        $this->kkprnb = Kkprnb::find($kkprnb_id);
        $this->permohonan = Permohonan::findOrFail($permohonan_id);

        $this->koordinat = $this->kkprnb->koordinat ?? [
            ['x' => '', 'y' => ''],
            ['x' => '', 'y' => ''],
            ['x' => '', 'y' => ''],
            ['x' => '', 'y' => ''], // minimal 4
        ];
        $this->tgl_survey = $this->kkprnb->tgl_survey;
        $this->foto_survey_lama = $this->kkprnb->foto_survey
        ? json_decode($this->kkprnb->foto_survey, true)
        : [];
        $this->gambar_peta_lama = $this->kkprnb->gambar_peta
        ? json_decode($this->kkprnb->gambar_peta, true)
        : [];
        $this->gambar_peta_selected = $this->gambar_peta_lama;
        $this->foto_survey_selected = $this->foto_survey_lama;
        $this->batas_barat = $this->kkprnb->batas_persil['barat'] ?? '';
        $this->batas_selatan = $this->kkprnb->batas_persil['selatan'] ?? '';
        $this->batas_timur = $this->kkprnb->batas_persil['timur'] ?? '';
        $this->batas_utara = $this->kkprnb->batas_persil['utara'] ?? '';
        $this->ada_bangunan = $this->kkprnb->ada_bangunan;
        $this->status_jalan = $this->kkprnb->status_jalan;
        $this->fungsi_jalan = $this->kkprnb->fungsi_jalan;
        $this->tipe_jalan = $this->kkprnb->tipe_jalan;
        $this->median_jalan = $this->kkprnb->median_jalan;
        $this->lebar_jalan = $this->kkprnb->lebar_jalan;
        $this->pola_ruang = $this->kkprnb->pola_ruang;
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
