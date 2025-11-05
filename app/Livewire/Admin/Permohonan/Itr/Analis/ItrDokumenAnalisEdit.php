<?php

namespace App\Livewire\Admin\Permohonan\Itr\Analis;

use App\Models\Permohonan;
use App\Models\Itr;
use Livewire\Component;

class ItrDokumenAnalisEdit extends Component
{
    public $permohonan, $itr;
    public $jenis_itr, $skala_usaha, $luas_disetujui, $pemanfaatan_ruang, $peraturan_zonasi, $kbli_diizinkan, $kdb, $klb, $gsb, $jba, $jbb, $kdh, $ktb, $luas_kavling, $jaringan_utilitas, $persyaratan_pelaksanaan;
    public $penguasaan_tanah;

    public function render()
    {
        return view('livewire.admin.permohonan.itr.analis.itr-dokumen-analis-edit');
    }

    public function mount($permohonan_id, $itr_id)
    {
        $this->itr = Itr::findOrFail($itr_id);
        $this->permohonan = Permohonan::findOrFail($permohonan_id);
        $this->jenis_itr = $this->itr->jenis_itr;

        if($this->jenis_itr == 'ITR')
        {
            $this->penguasaan_tanah = $this->itr->penguasaan_tanah;
        }
        elseif($this->jenis_itr == 'ITR-KKPR')
        {
            $this->skala_usaha = $this->itr->skala_usaha;
            $this->luas_disetujui = $this->itr->luas_disetujui;
            $this->pemanfaatan_ruang = $this->itr->pemanfaatan_ruang;
            $this->peraturan_zonasi = $this->itr->peraturan_zonasi;
            $this->kbli_diizinkan = $this->itr->kbli_diizinkan;
            $this->kdb = $this->itr->kdb;
            $this->klb = $this->itr->klb;
            $this->gsb = $this->itr->gsb;
            $this->jba = $this->itr->jba;
            $this->jbb = $this->itr->jbb;
            $this->kdh = $this->itr->kdh;
            $this->ktb = $this->itr->ktb;
            $this->luas_kavling = $this->itr->luas_kavling;
            $this->jaringan_utilitas = $this->itr->jaringan_utilitas;
            $this->persyaratan_pelaksanaan = $this->itr->persyaratan_pelaksanaan;
        }
    }

    public function editDokumenAnalisa()
    {
        $this->itr->update([
            'jenis_itr' => $this->jenis_itr,
            'penguasaan_tanah' => $this->penguasaan_tanah,
            'skala_usaha' => $this->skala_usaha,
            'luas_disetujui' => $this->luas_disetujui,
            'pemanfaatan_ruang' => $this->pemanfaatan_ruang,
            'peraturan_zonasi' => $this->peraturan_zonasi,
            'kbli_diizinkan' => $this->kbli_diizinkan,
            'kdb' => $this->kdb,
            'klb' => $this->klb,
            'gsb' => $this->gsb,
            'jba' => $this->jba,
            'jbb' => $this->jbb,
            'kdh' => $this->kdh,
            'ktb' => $this->ktb,
            'luas_kavling' => $this->luas_kavling,
            'jaringan_utilitas' => $this->jaringan_utilitas,
            'persyaratan_pelaksanaan' => $this->persyaratan_pelaksanaan
        ]);

        session()->flash('success', 'Data Dokumen ITR berhasil diupdate!');

        return redirect()->route('itr.detail', ['id' => $this->itr->id]);
    }
}
