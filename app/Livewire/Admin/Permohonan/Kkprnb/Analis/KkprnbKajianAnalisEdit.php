<?php

namespace App\Livewire\Admin\Permohonan\Kkprnb\Analis;

use App\Models\Kkprnb;
use App\Models\Permohonan;
use Livewire\Attributes\On;
use Livewire\Component;

class KkprnbKajianAnalisEdit extends Component
{
    public $permohonan, $kkprnb;
    public $penguasaan_tanah, $jml_bangunan, $jml_lantai, $luas_lantai, $kedalaman_min, $kedalaman_max, $jenis_kegiatan;
    public $kdb, $klb, $indikasi_program, $gsb, $jba, $jbb, $kdh, $ktb, $jaringan_utilitas, $persyaratan_pelaksanaan, $luas_disetujui, $kesimpulan, $ketinggian_bangunan_max;

    public function render()
    {
        return view('livewire.admin.permohonan.kkprnb.analis.kkprnb-kajian-analis-edit');
    }
    
    #[On('kkprnb-kajian-edit')]
    public function getKkprnb($permohonan_id, $kkprnb_id)
    {
        $this->kkprnb = Kkprnb::findOrFail($kkprnb_id);
        $this->permohonan = Permohonan::findOrFail($permohonan_id);

        $this->penguasaan_tanah = $this->kkprnb->penguasaan_tanah;
        $this->jml_bangunan = $this->kkprnb->jml_bangunan;
        $this->jml_lantai = $this->kkprnb->jml_lantai;        
        $this->luas_lantai = $this->kkprnb->luas_lantai;
        $this->luas_disetujui = $this->kkprnb->luas_disetujui; 
        $this->jenis_kegiatan = $this->kkprnb->jenis_kegiatan;       
        $this->kedalaman_min = $this->kkprnb->kedalaman_min;        
        $this->kedalaman_max = $this->kkprnb->kedalaman_max;        
        $this->kdb = $this->kkprnb->kdb;
        $this->klb = $this->kkprnb->klb;
        $this->gsb = $this->kkprnb->gsb;
        $this->jba = $this->kkprnb->jba;
        $this->jbb = $this->kkprnb->jbb;
        $this->kdh = $this->kkprnb->kdh;
        $this->ktb = $this->kkprnb->ktb;
        $this->ketinggian_bangunan_max = $this->kkprnb->ketinggian_bangunan_max;
        $this->indikasi_program = $this->kkprnb->indikasi_program;
        $this->jaringan_utilitas = $this->kkprnb->jaringan_utilitas;
        $this->persyaratan_pelaksanaan = $this->kkprnb->persyaratan_pelaksanaan;
    } 

    public function updateKajianAnalisa()
    {
        $this->kkprnb->update([
            'penguasaan_tanah' => $this->penguasaan_tanah,
            'jml_bangunan' => $this->jml_bangunan,
            'jml_lantai' => $this->jml_lantai,
            'luas_lantai' => $this->luas_lantai,
            'kedalaman_min' => $this->kedalaman_min,
            'kedalaman_max' => $this->kedalaman_max,
            'jenis_kegiatan' => $this->jenis_kegiatan,
            'luas_disetujui' => $this->luas_disetujui,
            'kdb' => $this->kdb,
            'klb' => $this->klb,
            'gsb' => $this->gsb,
            'jba' => $this->jba,
            'jbb' => $this->jbb,
            'kdh' => $this->kdh,
            'ktb' => $this->ktb,
            'ketinggian_bangunan_max' => $this->ketinggian_bangunan_max,
            'indikasi_program' => $this->indikasi_program,
            'jaringan_utilitas' => $this->jaringan_utilitas,
            'persyaratan_pelaksanaan' => $this->persyaratan_pelaksanaan
        ]);

        $this->reset('penguasaan_tanah', 'jml_bangunan', 'jml_lantai', 'luas_lantai', 'kedalaman_min', 'kedalaman_max', 'kdb', 'klb', 'indikasi_program', 'gsb', 'jba', 'jbb', 'kdh', 'ktb', 'ketinggian_bangunan_max', 'jaringan_utilitas', 'persyaratan_pelaksanaan');

        $this->dispatch('toast', [
            'type'    => 'success',
            'message' => 'Data Kajian Analisa KKPR Non Berusaha berhasil diupdate!'
        ]);
        
        $this->dispatch('refresh-kkprnb-analis-detail');

        $this->dispatch('trigger-close-modal');
    }
}
