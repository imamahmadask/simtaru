<?php

namespace App\Livewire\Admin\Permohonan\Skrk\Spv;

use App\Models\Disposisi;
use App\Models\Permohonan;
use App\Models\PermohonanBerkas;
use App\Models\PersyaratanBerkas;
use App\Models\RiwayatPermohonan;
use App\Models\Skrk;
use App\Models\Tahapan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class SkrkVerifikasiCreate extends Component
{
    public $berkas, $catatan, $persyaratan;
    public $skrk_id;
    public $tahapans, $permohonan;

    #[Validate('required')]
    public $status;

    public function render()
    {
        return view('livewire.admin.permohonan.skrk.spv.skrk-verifikasi-create');
    }

    public function addVerifikasi()
    {
        $this->validate();

        $verified_at = $this->status == 'diterima' ? now() : null;
        $verified_by = $this->status == 'diterima' ? Auth::user()->id : null;

        $tahapan_id = $this->berkas->persyaratan->tahapan_id;
        $tahapan = Tahapan::find($tahapan_id);
        $nama_tahapan = $tahapan->nama;

        $penerima_id = $this->berkas->uploaded_by;
        $penerima_name = User::where('id', $penerima_id)->first()->name;

        $skrk = Skrk::find($this->skrk_id);

        $this->berkas->update([
            'status' => $this->status,
            'catatan_verifikator' => $this->catatan,
            'verified_by' => $verified_by,
            'verified_at' => $verified_at
        ]);

        if($this->status == 'ditolak')
        {
            $skrk->disposisis()->create([
                'permohonan_id' => $skrk->permohonan->id,
                'tahapan_id' => $tahapan_id,
                'pemberi_id' => Auth::user()->id,
                'penerima_id' => $penerima_id,
                'tanggal_disposisi' => now(),
                'catatan' => $this->catatan,
            ]);

            if($nama_tahapan == 'Survey')
            {
                $skrk->update([
                    'is_survey' => false,
                    'is_berkas_survey_uploaded' => false,
                ]);
            }
            elseif($nama_tahapan == 'Analisis')
            {
                $skrk->update([
                    'is_berkas_analis_uploaded' => false,
                    'is_analis' => false,
                ]);
            }

            $this->createRiwayat($skrk->permohonan, "Disposisi kembali kepada {$penerima_name} pada tahapan ". $nama_tahapan);
        }

        $message = $this->status == 'diterima'
            ? "Berkas berhasil diverifikasi sebagai : Diterima"
            : "Berkas : Ditolak";

        $this->dispatch('toast', [
            'type'    => $this->status == 'diterima' ? 'success' : 'error',
            'message' => $message
        ]);

        $this->reset('status', 'catatan');

        $this->dispatch('refresh-skrk-verifikasi-list');
        $this->dispatch('refresh-skrk-analis-list');
        $this->dispatch('refresh-skrk-survey-list');

        $this->dispatch('trigger-close-modal');
    }

    public function mount($skrk_id, $berkas_id)
    {
        $this->skrk_id = $skrk_id;
        $this->berkas = PermohonanBerkas::find($berkas_id);
        $this->permohonan = Permohonan::findOrFail($this->berkas->permohonan_id);
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
