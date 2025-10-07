<?php

namespace App\Livewire\Admin\Permohonan\Skrk\Spv;

use App\Models\Disposisi;
use App\Models\PermohonanBerkas;
use App\Models\PersyaratanBerkas;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class SkrkVerifikasiCreate extends Component
{
    public $berkas, $catatan, $persyaratan;
    public $skrk_id;

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

        $this->berkas->update([
            'status' => $this->status,
            'catatan_verifikator' => $this->catatan,
            'verified_by' => $verified_by,
            'verified_at' => $verified_at
        ]);

        if($this->status == 'ditolak')
        {
            $disposisi = Disposisi::where('permohonan_id', $this->berkas->permohonan_id)
                ->where('tahapan_id', $this->berkas->persyaratan->tahapan_id)
                ->first();

            if ($disposisi) {
                $disposisi->update([
                    'is_done' => false,
                    'tgl_selesai' => null,
                    'updated_by' => Auth::user()->id,
                    'catatan' => $this->catatan
                ]);
            }
        }

        $message = $this->status == 'diterima'
            ? "Berkas berhasil diverifikasi sebagai : Diterima"
            : "Berkas : Ditolak";

        session()->flash($this->status == 'diterima' ? 'success' : 'error', $message);

        redirect()->route('skrk.detail', ['id' => $this->skrk_id]);
    }

    public function mount($skrk_id, $berkas_id)
    {
        $this->skrk_id = $skrk_id;
        $this->berkas = PermohonanBerkas::find($berkas_id);
        // $this->persyaratan = PersyaratanBerkas::find($this->berkas->persyaratan_berkas_id);

    }
}
