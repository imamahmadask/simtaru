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
use Livewire\Attributes\On;

class ItrVerifikasiCreate extends Component
{
    public $berkas, $catatan, $persyaratan;
    public $itr_id;
    public $tahapans, $permohonan;
    public $isLoading = true;

    #[Validate('required')]
    public $status;

    public function render()
    {
        return view('livewire.admin.permohonan.itr.spv.itr-verifikasi-create');
    }

    #[On('itr-verifikasi-create')]
    public function itrVerifikasiCreate($itr_id, $berkas_id)
    {
        $this->reset(['berkas', 'status', 'catatan']);
        $this->isLoading = true;
        $this->itr_id = $itr_id;
        $this->berkas = PermohonanBerkas::with('persyaratan.tahapan')->find($berkas_id);
        $this->permohonan = $this->berkas ? Permohonan::find($this->berkas->permohonan_id) : null;
        $this->isLoading = false;
    }

    public function addVerifikasi()
    {
        $this->validate();

        if (!$this->berkas) {
            $this->dispatch('toast', [
                'type'    => 'error',
                'message' => 'Berkas belum dipilih atau sedang dimuat!'
            ]);
            return;
        }

        $verified_at = $this->status == 'diterima' ? now() : null;
        $verified_by = $this->status == 'diterima' ? Auth::user()->id : null;

        $tahapan_id = $this->berkas->persyaratan->tahapan_id;
        $tahapan = Tahapan::find($tahapan_id);
        $nama_tahapan = $tahapan->nama ?? '';

        $penerima_id = $this->berkas->uploaded_by;
        $penerima = User::find($penerima_id);
        $penerima_name = $penerima ? $penerima->name : 'Petugas';

        $itr = Itr::find($this->itr_id);
        
        $this->berkas->update([
            'status' => $this->status,
            'catatan_verifikator' => $this->catatan,
            'verified_by' => $verified_by,
            'verified_at' => $verified_at
        ]);

        if($this->status == 'ditolak')
        {
            $activeRevisi = $itr->disposisis()
                ->where('tahapan_id', $tahapan_id)
                ->where('is_revisi', 1)
                ->where('is_done', 0)
                ->latest()
                ->first();

            if ($activeRevisi) {
                $newCatatan = $this->catatan 
                    ? ($activeRevisi->catatan ? $activeRevisi->catatan . "\n" . $this->catatan : $this->catatan)
                    : $activeRevisi->catatan;

                $activeRevisi->update([
                    'catatan'    => $newCatatan,
                    'updated_by' => Auth::user()->id,
                ]);
            } else {
                $currentDisposisi = $itr->disposisis()
                    ->where('tahapan_id', $tahapan_id)
                    ->where('is_done', true)
                    ->latest()
                    ->first();

                if ($currentDisposisi) {
                    $currentDisposisi->update([
                        'status'     => $currentDisposisi->is_revisi == 1 ? 'revised' : 'completed',
                        'updated_by' => Auth::user()->id,
                    ]);
                }

                $parent_id = $currentDisposisi ? $currentDisposisi->id : null;
                $permohonan_id = $itr->permohonan_id ?? $this->berkas->permohonan_id;

                $itr->disposisis()->create([
                    'permohonan_id' => $permohonan_id,
                    'tahapan_id' => $tahapan_id,
                    'pemberi_id' => Auth::user()->id,
                    'penerima_id' => $penerima_id,
                    'tanggal_disposisi' => now(),
                    'catatan' => $this->catatan,
                    'parent_id' => $parent_id,
                    'is_revisi' => 1,
                    'status' => 'pending',
                    'is_done' => 0,
                ]);
            }

            if($nama_tahapan == 'Survey')
            {
                $itr->update([
                    'is_survey' => false,
                    'is_berkas_survey_uploaded' => false,
                ]);
            }
            elseif($nama_tahapan == 'Analisis')
            {
                $itr->update([
                    'is_berkas_analis_uploaded' => false,
                    'is_analis' => false,
                ]);
            }

            $this->createRiwayat($itr->permohonan, "Disposisi kembali kepada {$penerima_name} pada tahapan ". $nama_tahapan);

            $this->dispatch('refresh-itr-survey-list');
            $this->dispatch('refresh-itr-survey-detail');
            $this->dispatch('refresh-itr-analis-list');
            $this->dispatch('refresh-itr-analis-detail');
        }
        
        $message = $this->status == 'diterima'
        ? "Berkas berhasil diverifikasi sebagai : Diterima"
        : "Berkas : Ditolak";       
        
        $this->dispatch('toast', [
            'type'    => $this->status == 'diterima' ? 'success' : 'error',
            'message' => $message
        ]);
        
        $this->reset(['status', 'catatan', 'berkas']);
        $this->isLoading = true;
        
        $this->dispatch('refresh-itr-verifikasi-list');        

        $this->dispatch('trigger-close-modal');
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
