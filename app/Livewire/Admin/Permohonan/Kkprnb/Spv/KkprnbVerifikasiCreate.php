<?php

namespace App\Livewire\Admin\Permohonan\Kkprnb\Spv;

use App\Models\Kkprnb;
use App\Models\Permohonan;
use App\Models\PermohonanBerkas;
use App\Models\RiwayatPermohonan;
use App\Models\Tahapan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class KkprnbVerifikasiCreate extends Component
{
    public $berkas, $catatan, $persyaratan;
    public $kkprnb_id;
    public $tahapans, $permohonan;

    #[Validate('required')]
    public $status;

    public function render()
    {
        return view('livewire.admin.permohonan.kkprnb.spv.kkprnb-verifikasi-create');
    }

    #[On('kkprnb-verifikasi-create')]
    public function getBerkas($kkprnb_id, $berkas_id)
    {
        $this->kkprnb_id = $kkprnb_id;
        $this->berkas = PermohonanBerkas::find($berkas_id);
        $this->permohonan = Permohonan::findOrFail($this->berkas->permohonan_id);
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

        $kkprnb = Kkprnb::find($this->kkprnb_id);

        $this->berkas->update([
            'status' => $this->status,
            'catatan_verifikator' => $this->catatan,
            'verified_by' => $verified_by,
            'verified_at' => $verified_at
        ]);

        if($this->status == 'ditolak')
        {
            $kkprnb->disposisis()->create([
                'permohonan_id' => $kkprnb->permohonan->id,
                'tahapan_id' => $tahapan_id,
                'pemberi_id' => Auth::user()->id,
                'penerima_id' => $penerima_id,
                'tanggal_disposisi' => now(),
                'catatan' => $this->catatan,
            ]);

            if($nama_tahapan == 'Survey')
            {
                $kkprnb->update([
                    'is_survey' => false,
                    'is_berkas_survey_uploaded' => false,
                ]);
            }
            elseif($nama_tahapan == 'Analisis')
            {
                $kkprnb->update([
                    'is_berkas_analis_uploaded' => false,
                    'is_analis' => false,
                ]);
            }

            $this->createRiwayat($kkprnb->permohonan, "Disposisi kembali kepada {$penerima_name} pada tahapan ". $nama_tahapan);
        }

        $message = $this->status == 'diterima'
            ? "Berkas berhasil diverifikasi sebagai : Diterima"
            : "Berkas : Ditolak";

        $this->dispatch('toast', [
            'type'    => $this->status == 'diterima' ? 'success' : 'error',
            'message' => $message
        ]);
        
        $this->dispatch('refresh-kkprnb-verifikasi-list');

        $this->dispatch('trigger-close-modal');
    }

    // public function mount($kkprnb_id, $berkas_id)
    // {
    //     $this->kkprnb_id = $kkprnb_id;
    //     $this->berkas = PermohonanBerkas::find($berkas_id);
    //     $this->permohonan = Permohonan::findOrFail($this->berkas->permohonan_id);
    // }

    private function createRiwayat(Permohonan $permohonan, string $keterangan)
    {
        RiwayatPermohonan::create([
            'registrasi_id' => $permohonan->registrasi_id,
            'user_id' => Auth::user()->id,
            'keterangan' => $keterangan
        ]);
    }
}
