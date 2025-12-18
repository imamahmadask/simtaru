<?php

namespace App\Livewire\Admin\Disposisi;

use App\Models\Disposisi;
use App\Models\Itr;
use App\Models\Kkprb;
use App\Models\Kkprnb;
use App\Models\Layanan;
use App\Models\Permohonan;
use App\Models\RiwayatPermohonan;
use App\Models\Skrk;
use App\Models\Tahapan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Component;

class DisposisiCreate extends Component
{
    public $tahapans, $users;
    public $permohonan, $pelayanan_id, $catatan, $pemberi_id, $permohonan_id;

    #[Validate('required')]
    public $tahapan_id, $penerima_id;

    public function render()
    {
        return view('livewire.admin.disposisi.disposisi-create');
    }

    public function mount($permohonan_id, $pelayanan_id)
    {
        $this->pelayanan_id = $pelayanan_id;
        $this->permohonan = Permohonan::findOrFail($permohonan_id);
        $this->tahapans = Tahapan::where('layanan_id', $this->permohonan->layanan_id)
                                 ->whereNotIn('id', function($query) {
                                    $query->select('tahapan_id')
                                          ->from('disposisis')
                                          ->where('permohonan_id', $this->permohonan->id);
                                 })
                                 ->get();

        $this->users = User::where('role', '!=', 'superadmin')->where('role', '!=', 'supervisor')->get();
    }

    public function createDisposisi()
    {
        $this->validate();

        $layanan = Layanan::findOrFail($this->permohonan->layanan_id);

        $this->pemberi_id = Auth::user()->id;

        if($layanan->kode == 'SKRK')
        {
            $skrk = Skrk::find($this->pelayanan_id);
            $skrk->disposisis()->create([
                'permohonan_id' => $this->permohonan->id,
                'tahapan_id' => $this->tahapan_id,
                'pemberi_id' => $this->pemberi_id,
                'penerima_id' => $this->penerima_id,
                'tanggal_disposisi' => now(),
                'catatan' => $this->catatan,
            ]);
        }
        elseif($layanan->kode == 'ITR')
        {
            $itr = Itr::find($this->pelayanan_id);
            $itr->disposisis()->create([
                'permohonan_id' => $this->permohonan->id,
                'tahapan_id' => $this->tahapan_id,
                'pemberi_id' => $this->pemberi_id,
                'penerima_id' => $this->penerima_id,
                'tanggal_disposisi' => now(),
                'catatan' => $this->catatan,
            ]);
        }
        elseif($layanan->kode == 'KKPRNB')
        {
            $kkprnb = Kkprnb::find($this->pelayanan_id);
            $kkprnb->disposisis()->create([
                'permohonan_id' => $this->permohonan->id,
                'tahapan_id' => $this->tahapan_id,
                'pemberi_id' => $this->pemberi_id,
                'penerima_id' => $this->penerima_id,
                'tanggal_disposisi' => now(),
                'catatan' => $this->catatan,
            ]);
        }
        elseif($layanan->kode == 'KKPRB')
        {
            $kkprb = Kkprb::find($this->pelayanan_id);
            $kkprb->disposisis()->create([
                'permohonan_id' => $this->permohonan->id,
                'tahapan_id' => $this->tahapan_id,
                'pemberi_id' => $this->pemberi_id,
                'penerima_id' => $this->penerima_id,
                'tanggal_disposisi' => now(),
                'catatan' => $this->catatan,
            ]);
        }

        $this->createRiwayat($this->permohonan, "Disposisi kepada {$this->users->where('id', $this->penerima_id)->first()->name} pada tahapan ". $this->tahapans->where('id', $this->tahapan_id)->first()->nama);        

        $this->reset('tahapan_id', 'penerima_id', 'catatan');

        $this->dispatch('toast', [
            'type'    => 'success',
            'message' => 'Disposisi berhasil ditambahkan.'
        ]);

        $this->dispatch('refresh-disposisi-list');

        $this->dispatch('trigger-close-modal');
    }

    public function updatedTahapanId($value)
    {        
        $tahapan = Tahapan::find($value);

        if($tahapan->nama == 'Analisis')
        {
            $this->users = User::where('role', 'analis')->get();
        }
        else
        {
            $this->users = User::where('role', '!=', 'superadmin')
                            ->where('role', '!=', 'supervisor')->get();
        }
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
