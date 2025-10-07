<?php

namespace App\Livewire\Admin\Permohonan\Skrk\Analis;

use App\Models\Permohonan;
use App\Models\Skrk;
use Livewire\Component;

class SkrkDokumenAnalisEdit extends Component
{
    public $permohonan, $skrk;
    public $skala_usaha, $luas_disetujui, $pemanfaatan_ruang, $peraturan_zonasi, $kbli_diizinkan, $kdb, $klb, $gsb, $jba, $jbb, $kdh, $ktb, $luas_kavling, $jaringan_utilitas, $persyaratan_pelaksanaan;

    public function render()
    {
        return view('livewire.admin.permohonan.skrk.analis.skrk-dokumen-analis-edit');
    }

    public function mount($permohonan_id, $skrk_id)
    {
        $this->skrk = Skrk::findOrFail($skrk_id);
        $this->permohonan = Permohonan::findOrFail($permohonan_id);

        $this->skala_usaha = $this->skrk->skala_usaha;
        $this->luas_disetujui = $this->skrk->luas_disetujui;
        $this->pemanfaatan_ruang = $this->skrk->pemanfaatan_ruang;
        $this->peraturan_zonasi = $this->skrk->peraturan_zonasi;
        $this->kbli_diizinkan = $this->skrk->kbli_diizinkan;
        $this->kdb = $this->skrk->kdb;
        $this->klb = $this->skrk->klb;
        $this->gsb = $this->skrk->gsb;
        $this->jba = $this->skrk->jba;
        $this->jbb = $this->skrk->jbb;
        $this->kdh = $this->skrk->kdh;
        $this->ktb = $this->skrk->ktb;
        $this->luas_kavling = $this->skrk->luas_kavling;
        $this->jaringan_utilitas = $this->skrk->jaringan_utilitas;
        $this->persyaratan_pelaksanaan = $this->skrk->persyaratan_pelaksanaan;
    }

    public function editKajianAnalisa()
    {
        $this->skrk->update([
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

        session()->flash('success', 'Data Dokumen SKRK berhasil diupdate!');

        return redirect()->route('skrk.detail', ['id' => $this->skrk->id]);
    }

}
