<?php

namespace App\Livewire\Admin\Permohonan\Itr\Spv;

use App\Models\Permohonan;
use App\Models\PermohonanBerkas;
use App\Models\RiwayatPermohonan;
use App\Models\Itr;
use App\Models\Tahapan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ItrVerifikasiCreate extends Component
{
    public $berkas, $catatan, $persyaratan;
    public $itr_id;
    public $tahapans, $permohonan;

    #[Validate('required')]
    public $status;

    public function render()
    {
        return view('livewire.admin.permohonan.itr.spv.itr-verifikasi-create');
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

        $itr = Itr::find($this->itr_id);

        $this->berkas->update([
            'status' => $this->status,
            'catatan_verifikator' => $this->catatan,
            'verified_by' => $verified_by,
            'verified_at' => $verified_at
        ]);

        if($this->status == 'ditolak')
        {
            $itr->disposisis()->create([
                'permohonan_id' => $itr->permohonan->id,
                'tahapan_id' => $tahapan_id,
                'pemberi_id' => Auth::user()->id,
                'penerima_id' => $penerima_id,
                'tanggal_disposisi' => now(),
                'catatan' => $this->catatan,
            ]);

            if($nama_tahapan == 'Survey')
            {
                $itr->update([
                    'is_survey' => false,
                    'is_berkas_survey' => false,
                ]);
            }
            elseif($nama_tahapan == 'Analisis')
            {
                $itr->update([
                    'is_berkas_analis' => false,
                    'is_analis' => false,
                ]);
            }

            $this->createRiwayat($itr->permohonan, "Disposisi kembali kepada {$penerima_name} pada tahapan ". $nama_tahapan);
        }

        $this->reset('status', 'catatan', 'berkas', 'permohonan', 'itr_id', 'tahapans');

        $message = $this->status == 'diterima'
            ? "Berkas berhasil diverifikasi sebagai : Diterima"
            : "Berkas : Ditolak";       

        $this->dispatch('toast', [
            'type'    => $this->status == 'diterima' ? 'success' : 'error',
            'message' => $message
        ]);
        
        $this->dispatch('refresh-itr-verifikasi-list');

        $this->dispatch('trigger-close-modal');
    }

    public function mount($itr_id, $berkas_id)
    {
        $this->itr_id = $itr_id;
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
