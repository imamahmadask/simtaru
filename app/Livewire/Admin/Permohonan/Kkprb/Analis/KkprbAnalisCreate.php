<?php

namespace App\Livewire\Admin\Permohonan\Kkprb\Analis;

use App\Models\Kkprb;
use App\Models\Permohonan;
use App\Models\RiwayatPermohonan;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class KkprbAnalisCreate extends Component
{
    public $permohonan, $kkprb;
    public $tgl_oss, $oss_id, $id_proyek, $skala_usaha, $jenis_usaha, $penguasaan_tanah, $jml_bangunan, $jml_lantai, $luas_lantai, $kedalaman_min, $kedalaman_max;
    public $nib, $kdb, $klb, $indikasi_program, $kdh, $gsb, $luas_disetujui, $ketinggian_min, $ketinggian_max;

    public function render()
    {
        return view('livewire.admin.permohonan.kkprb.analis.kkprb-analis-create');
    }

    public function createKajianAnalisa()
    {
        $this->kkprb->update([
            'tgl_oss' => $this->tgl_oss,
            'oss_id' => $this->oss_id,
            'id_proyek' => $this->id_proyek,
            'skala_usaha' => $this->skala_usaha,
            'jenis_usaha' => $this->jenis_usaha,
            'nib' => $this->nib,
            'penguasaan_tanah' => $this->penguasaan_tanah,
            'jml_bangunan' => $this->jml_bangunan,
            'jml_lantai' => $this->jml_lantai,
            'luas_lantai' => $this->luas_lantai,
            'kedalaman_min' => $this->kedalaman_min,
            'kedalaman_max' => $this->kedalaman_max,
            'ketinggian_min' => $this->ketinggian_min,
            'ketinggian_max' => $this->ketinggian_max,
            'indikasi_program' => $this->indikasi_program,
            'kdb' => $this->kdb,
            'klb' => $this->klb,
            'kdh' => $this->kdh,
            'gsb' => $this->gsb,
            'luas_disetujui' => $this->luas_disetujui,
            'is_kajian' => true,
        ]);

        $this->permohonan->update([
            'status' => 'Proses  Analisa'
        ]);

        // $this->createRiwayat($this->kkprb->permohonan, 'Proses Analisa KKPR Berusaha');

        $this->reset('tgl_oss', 'oss_id', 'id_proyek', 'skala_usaha', 'nib', 'penguasaan_tanah', 'jml_bangunan', 'jml_lantai', 'luas_lantai', 'kedalaman_min', 'kedalaman_max', 'ketinggian_min', 'ketinggian_max', 'kdb', 'klb', 'indikasi_program', 'kdh', 'gsb', 'luas_disetujui');

        $this->dispatch('toast', [
            'type'    => 'success',
            'message' => 'Data Kajian KKPR Non Berusaha berhasil disimpan!'
        ]);

        $this->dispatch('refresh-kkprb-analis-list');

        $this->dispatch('trigger-close-modal');
    }

    public function mount($permohonan_id, $kkprb_id)
    {
        $this->kkprb = Kkprb::findOrFail($kkprb_id);
        $this->permohonan = Permohonan::findOrFail($permohonan_id);
    }


}
