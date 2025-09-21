<?php

namespace App\Livewire\Admin\Permohonan\Skrk\Analis;

use App\Models\Permohonan;
use App\Models\RiwayatPermohonan;
use App\Models\Skrk;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SkrkDokumenAnalisCreate extends Component
{
    public $permohonan, $skrk;
    public $luas_disetujui, $pemanfaatan_ruang, $peraturan_zonasi, $kbli_diizinkan, $kdb, $klb, $gsb, $jba, $jbb, $kdh, $ktb, $luas_kavling, $jaringan_utilitas, $persyaratan_pelaksanaan;
    public function render()
    {
        return view('livewire.admin.permohonan.skrk.analis.skrk-dokumen-analis-create');
    }

    public function createKajianAnalisa()
    {
        $this->skrk->update([
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
            'persyaratan_pelaksanaan' => $this->persyaratan_pelaksanaan,
            'is_dokumen' => true,
            'is_analis' => true
        ]);

        $this->permohonan->update([
            'status' => 'Proses Analisa'
        ]);

        $this->createRiwayat($this->permohonan, 'Entry Data Dokumen SKRK');

        session()->flash('success', 'Data Dokumen SKRK berhasil disimpan!');

        return redirect()->route('skrk.detail', ['id' => $this->skrk->id]);
    }

    public function mount($permohonan_id, $skrk_id)
    {
        $this->skrk = Skrk::findOrFail($skrk_id);
        $this->permohonan = Permohonan::findOrFail($permohonan_id);
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
