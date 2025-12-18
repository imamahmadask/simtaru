<?php

namespace App\Livewire\Admin\Permohonan\Kkprb\Analis;

use App\Models\Kkprb;
use App\Models\Permohonan;
use Livewire\Attributes\On;
use Livewire\Component;

class KkprbAnalisEdit extends Component
{
    public $permohonan, $kkprb;
    public $tgl_oss, $oss_id, $id_proyek, $skala_usaha, $jenis_usaha, $penguasaan_tanah, $jml_bangunan, $jml_lantai, $luas_lantai, $kedalaman_min, $kedalaman_max;
    public $nib, $kdb, $klb, $indikasi_program, $kdh, $gsb, $luas_disetujui, $no_nota_dinas, $tgl_nota_dinas;

    public function render()
    {
        return view('livewire.admin.permohonan.kkprb.analis.kkprb-analis-edit');
    }

    #[On('kkprb-kajian-edit')]
    public function getKkprb($permohonan_id, $kkprb_id)
    {
        $this->kkprb = Kkprb::findOrFail($kkprb_id);
        $this->permohonan = Permohonan::findOrFail($permohonan_id);

        $this->penguasaan_tanah = $this->kkprb->penguasaan_tanah;
        $this->jml_bangunan = $this->kkprb->jml_bangunan;
        $this->jml_lantai = $this->kkprb->jml_lantai;        
        $this->luas_lantai = $this->kkprb->luas_lantai;        
        $this->kedalaman_min = $this->kkprb->kedalaman_min;        
        $this->kedalaman_max = $this->kkprb->kedalaman_max;        
        $this->kdh = $this->kkprb->kdh;
        $this->kdb = $this->kkprb->kdb;
        $this->klb = $this->kkprb->klb;
        $this->gsb = $this->kkprb->gsb;
        $this->indikasi_program = $this->kkprb->indikasi_program;
        $this->nib = $this->kkprb->nib;
        $this->tgl_oss = $this->kkprb->tgl_oss;
        $this->oss_id = $this->kkprb->oss_id;
        $this->id_proyek = $this->kkprb->id_proyek;
        $this->skala_usaha = $this->kkprb->skala_usaha;
        $this->jenis_usaha = $this->kkprb->jenis_usaha;
        $this->luas_disetujui = $this->kkprb->luas_disetujui;
        $this->no_nota_dinas = $this->kkprb->no_nota_dinas;
        $this->tgl_nota_dinas = $this->kkprb->tgl_nota_dinas;        
    } 

    public function updateKajianAnalisa()
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
            'indikasi_program' => $this->indikasi_program,
            'kdb' => $this->kdb,
            'klb' => $this->klb,
            'kdh' => $this->kdh,
            'gsb' => $this->gsb,
            'luas_disetujui' => $this->luas_disetujui,
            'no_nota_dinas' => $this->no_nota_dinas,
            'tgl_nota_dinas' => $this->tgl_nota_dinas,
        ]);

        $this->reset('tgl_oss', 'oss_id', 'id_proyek', 'skala_usaha', 'nib', 'penguasaan_tanah', 'jml_bangunan', 'jml_lantai', 'luas_lantai', 'kedalaman_min', 'kedalaman_max', 'kdb', 'klb', 'indikasi_program', 'kdh', 'gsb', 'luas_disetujui', 'no_nota_dinas', 'tgl_nota_dinas');

        $this->dispatch('toast', [
            'type'    => 'success',
            'message' => 'Data Kajian Analisa KKPR Berusaha berhasil diupdate!'
        ]);
        
        $this->dispatch('refresh-kkprb-analis-list');

        $this->dispatch('trigger-close-modal');
    }
}
