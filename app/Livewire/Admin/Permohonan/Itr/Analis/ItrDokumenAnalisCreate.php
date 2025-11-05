<?php

namespace App\Livewire\Admin\Permohonan\Itr\Analis;

use App\Models\Permohonan;
use App\Models\RiwayatPermohonan;
use App\Models\Itr;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ItrDokumenAnalisCreate extends Component
{
    public $permohonan, $itr;
    public $jenis_itr, $skala_usaha, $luas_disetujui, $pemanfaatan_ruang, $peraturan_zonasi, $kbli_diizinkan, $kdb, $klb, $gsb, $jba, $jbb, $kdh, $ktb, $luas_kavling, $jaringan_utilitas, $persyaratan_pelaksanaan;
    public $penguasaan_tanah;

    public function render()
    {
        return view('livewire.admin.permohonan.itr.analis.itr-dokumen-analis-create');
    }

    public function createDokumenAnalisa()
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
            'persyaratan_pelaksanaan' => $this->persyaratan_pelaksanaan,
            'is_dokumen' => true
        ]);

        $this->createRiwayat($this->permohonan, 'Entry Data Dokumen ITR');

        session()->flash('success', 'Data Dokumen ITR berhasil disimpan!');

        return redirect()->route('itr.detail', ['id' => $this->itr->id]);
    }

    public function mount($permohonan_id, $itr_id)
    {
        $this->itr = Itr::findOrFail($itr_id);
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
