<?php

namespace App\Livewire\Admin\Permohonan;

use App\Models\Disposisi;
use App\Models\Layanan;
use App\Models\Permohonan;
use App\Models\Registrasi;
use App\Models\RiwayatPermohonan;
use App\Models\Tahapan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
#[Title('Tambah Permohonan')]
class PermohonanCreate extends Component
{
    public $layanans, $registrasis, $users;
    public $tahapans = [];

    #[Validate('required')]
    public $registrasi_id, $layanan_id, $nama, $alamat_tanah, $kel_tanah, $kec_tanah, $jenis_bangunan, $tahapan_id, $penerima_id;

    public $keterangan, $status, $pemberi_id, $catatan;

    public function render()
    {
        return view('livewire.admin.permohonan.permohonan-create');
    }

    public function addPermohonan()
    {
        $this->validate();

        $this->status = 'pending';

        Permohonan::create([
            'registrasi_id' => $this->registrasi_id,
            'layanan_id' => $this->layanan_id,
            'alamat_tanah' => $this->alamat_tanah,
            'kel_tanah' => $this->kel_tanah,
            'kec_tanah' => $this->kec_tanah,
            'jenis_bangunan' => $this->jenis_bangunan,
            'status' => $this->status,
            'keterangan' => $this->keterangan,
            'created_by' => Auth::user()->id,
            'updated_by' => Auth::user()->id
        ]);

        $permohonan = Permohonan::latest()->first();

        RiwayatPermohonan::create([
            'registrasi_id' => $permohonan->registrasi_id,
            'user_id' => Auth::user()->id,
            'keterangan' => 'Entry Permohonan'
        ]);

        $this->pemberi_id = Auth::user()->id;

        Disposisi::create([
            'permohonan_id' => $permohonan->id,
            'tahapan_id' => $this->tahapan_id,
            'pemberi_id' => $this->pemberi_id,
            'penerima_id' => $this->penerima_id,
            'catatan' => $this->catatan
        ]);

         RiwayatPermohonan::create([
            'registrasi_id' => $permohonan->registrasi_id,
            'user_id' => Auth::user()->id,
            'keterangan' => 'Disposisi kepada ' . $this->users->where('id', $this->penerima_id)->first()->name.' pada tahapan Survey Berkas'
        ]);

        session()->flash('success', 'Permohonan berhasil ditambahkan!');

        $this->redirectRoute('permohonan.index');
    }

    public function mount()
    {
        $this->layanans = Layanan::all();
        $this->registrasis = Registrasi::doesntHave('permohonan')->get();
        $this->users = User::where('role', 'surveyor')->get();
    }

    public function updated($registrasi_id)
    {
        if ($this->registrasi_id != "") {
            $registrasi = Registrasi::find($this->registrasi_id);
            $this->layanan_id = $registrasi->layanan_id;
            $this->nama = $registrasi->nama;
            $this->tahapans = Tahapan::where('layanan_id', $this->layanan_id)->where('urutan', 1)->get();
        }
        else
        {
            $this->layanan_id = null;
            $this->nama = null;
            $this->tahapans = null;
        }
    }
}
