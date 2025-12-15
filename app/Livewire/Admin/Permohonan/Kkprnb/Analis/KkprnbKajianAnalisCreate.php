<?php

namespace App\Livewire\Admin\Permohonan\Kkprnb\Analis;

use App\Models\Kkprnb;
use App\Models\Permohonan;
use App\Models\RiwayatPermohonan;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class KkprnbKajianAnalisCreate extends Component
{
    public $permohonan, $kkprnb;
    public $penguasaan_tanah, $jml_bangunan, $jml_lantai, $luas_lantai, $kedalaman_min, $kedalaman_max;
    public $kdb, $klb, $indikasi_program, $gsb, $jba, $jbb, $kdh, $ktb, $jaringan_utilitas, $persyaratan_pelaksanaan;

    public function render()
    {
        return view('livewire.admin.permohonan.kkprnb.analis.kkprnb-kajian-analis-create');
    }

    public function createKajianAnalisa()
    {
        $this->kkprnb->update([
            'penguasaan_tanah' => $this->penguasaan_tanah,
            'jml_bangunan' => $this->jml_bangunan,
            'jml_lantai' => $this->jml_lantai,
            'luas_lantai' => $this->luas_lantai,
            'kedalaman_min' => $this->kedalaman_min,
            'kedalaman_max' => $this->kedalaman_max,
            'kdb' => $this->kdb,
            'klb' => $this->klb,
            'indikasi_program' => $this->indikasi_program,
            'gsb' => $this->gsb,
            'jba' => $this->jba,
            'jbb' => $this->jbb,
            'kdh' => $this->kdh,
            'ktb' => $this->ktb,
            'jaringan_utilitas' => $this->jaringan_utilitas,
            'persyaratan_pelaksanaan' => $this->persyaratan_pelaksanaan,
            'is_kajian' => true,
        ]);

        $this->permohonan->update([
            'status' => 'Proses  Analisa'
        ]);

        $this->createRiwayat($this->permohonan, 'Entry Data Kajian KKPR Non Berusaha');

        $this->reset('penguasaan_tanah', 'ada_bangunan', 'jml_bangunan', 'jml_lantai', 'luas_lantai', 'kedalaman_min', 'kedalaman_max', 'kdb', 'klb', 'indikasi_program', 'gsb', 'jba', 'jbb', 'kdh', 'ktb', 'jaringan_utilitas', 'persyaratan_pelaksanaan');

        $this->dispatch('toast', [
            'type'    => 'success',
            'message' => 'Data Kajian KKPR Non Berusaha berhasil disimpan!'
        ]);

        $this->dispatch('refresh-kkprnb-analis-list');

        $this->dispatch('trigger-close-modal');
    }

    public function mount($permohonan_id, $kkprnb_id)
    {
        $this->kkprnb = Kkprnb::findOrFail($kkprnb_id);
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
